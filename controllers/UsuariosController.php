<?php

namespace app\controllers;

use app\models\FotoForm;
use app\models\Pendientes;
use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use Http\Discovery\Exception\NotFoundException;
use yii\bootstrap4\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                '__class' => AccessControl::class,
                'only' => ['foto'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionFoto()
    {
        $fotoForm = new FotoForm();

        if (Yii::$app->request->isPost) {
            $fotoForm->imageFile = UploadedFile::getInstance($fotoForm, 'imageFile');
            if ($fotoForm->upload()) {
                // el archivo se subió exitosamente
                return $this->redirect(['usuarios/index']);
            }
        }

        return $this->render('foto', [
            'fotoForm' => $fotoForm,
        ]);
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREATE]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $pendiente = new Pendientes([
                'id' => $model->id,
                'token' => Yii::$app->security->generateRandomString(),
            ]);
            $pendiente->save();
            $body = 'Para activar el usuario, pulse aquí: '
                . Html::a(
                    'Activar usuario',
                    Url::to([
                        'usuarios/activar',
                        'id' => $model->id,
                        'token' => $pendiente->token
                    ], true)
                );
            Yii::$app->mailer->compose()
                ->setTo($model->email)
                ->setFrom(Yii::$app->params['smtpUsername'])
                ->setSubject('Activar usuario')
                ->setHtmlBody($body)
                ->send();
            Yii::$app->session->setFlash(
                'success',
                'Debe activar al usuario para validar la cuenta'
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionActivar($id, $token)
    {
        $usuario = $this->findModel($id);
        if ($usuario->pendiente === null) {
            return $this->goHome();
        }
        if ($usuario->pendiente->token === $token) {
            $usuario->pendiente->delete();
            Yii::$app->session->setFlash('success', 'Usuario activado correctamente');
            return $this->redirect(Yii::$app->user->loginUrl);
        }
        Yii::$app->session->setFlash('error', 'Token incorrecto');
        return $this->goHome();
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Usuarios::SCENARIO_UPDATE;
        $model->password = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $usuario = $this->findModel($id);

        if ($id == Yii::$app->user->id) {
            Yii::$app->session->setFlash(
                'error',
                'El usuario no puede borrarse a sí mismo.'
            );
            return $this->redirect(['usuarios/index']);
        }

        $usuario->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
