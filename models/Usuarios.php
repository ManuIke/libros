<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $password
 * @property string|null $auth_key
 * @property string|null $telefono
 * @property string|null $poblacion
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'unique'],
            [['nombre', 'auth_key', 'telefono', 'poblacion'], 'string', 'max' => 255],
            [['password', 'password_repeat'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['password'], 'compare', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['password_repeat'], 'safe', 'on' => [self::SCENARIO_UPDATE]],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['password_repeat']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'telefono' => 'Teléfono',
            'poblacion' => 'Población',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREATE) {
                goto salto;
            }
        } else {
            if ($this->scenario === self::SCENARIO_UPDATE) {
                if ($this->password === '') {
                    $this->password = $this->getOldAttribute('password');
                } else {
                    salto:
                    $this->password = Yii::$app->security
                        ->generatePasswordHash($this->password);
                }
            }
        }

        return true;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getAuthKey()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function validateAuthKey($authKey)
    {
    }

    public static function findByNombre($nombre)
    {
        return static::findOne(['nombre' => $nombre]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security
            ->validatePassword($password, $this->password);
    }
}
