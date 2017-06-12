<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use app\models\PasswordResetRequestForm as BaseForm;
use backend\models\User;

class PasswordResetRequestForm extends BaseForm {

    public function findUserByEmail($email) {
        return User::findByEmail($email);
    }
}
