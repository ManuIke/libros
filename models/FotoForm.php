<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class FotoForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate() && !Yii::$app->user->isGuest) {
            $this->imageFile->saveAs(Yii::getAlias('@uploads/' . Yii::$app->user->id . '.' . $this->imageFile->extension));
            return true;
        } else {
            return false;
        }
    }
}
