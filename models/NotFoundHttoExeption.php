<?php 
namespace app\models;

use yii\base\Exception;

class NotFoundHttpException extends Exception
{
    public function getName() {
        return 'User not found';
    }
}