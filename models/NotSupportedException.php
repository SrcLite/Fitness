<?php 

namespace app\models;

use yii\base\Exception;

class NotSupportedException extends Exception
{
    public function getName() {
        return 'Not Supported Exception';
    }
}
