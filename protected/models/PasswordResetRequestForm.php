<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
abstract class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        $user = $this->findUserByEmail($this->email);

        if (!$user) {
            return false;
        }
        
        $user->generatePasswordResetToken();
        if (!$user->save()) {
            return false;
        }

        return $user->sendResetPasswordEmail();
    }

    /**
     * @param  string $email
     * @return app\models\ForgotPasswordInterface
     */
    abstract public function findUserByEmail($email);
}
