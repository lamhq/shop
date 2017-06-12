<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use backend\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends \app\models\ResetPasswordForm
{
    protected function findUserByAccessToken($token) {
        return User::findByPasswordResetToken($token);
    }
}
