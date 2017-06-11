<?php
namespace shop\models;

use Yii;
use shop\models\Customer;

/**
 * Password reset form
 */
class ResetPasswordForm extends \app\models\ResetPasswordForm
{
    protected function findUserByAccessToken($token) {
        return Customer::findByPasswordResetToken($token);
    }
}
