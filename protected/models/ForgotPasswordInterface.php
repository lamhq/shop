<?php
namespace app\models;

/**
 * ForgotPasswordInterface is the interface that should be implemented by a class providing methods for forgot password feature
 *
 * This interface can typically be implemented by a user model class. For example, the following
 * code shows how to implement this interface by a User ActiveRecord class:
 *
 * ```php
 * class User extends ActiveRecord implements ForgotPasswordInterface
 * {
 *     // ...
 * }
 * ```
 *
 * @author Lam Huynh <hqlam.bt@gmail.com>
 */
interface ForgotPasswordInterface {

    /**
     * Finds an user by email.
     * @return ForgotPasswordInterface the identity object that matches the given email.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findByEmail($email);

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @return ForgotPasswordInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findByPasswordResetToken($token);

    /**
     * Check whether a reset token is valid
     * @param  mixed  $token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token);

    /**
     * send a reset password request email to customer
     * @return boolean
     */
    public function sendResetPasswordEmail();

    /**
     * generate a new password reset token for this user
     */
    public function generatePasswordResetToken();

    /**
     * unset password reset token of this user
     */
    public function removePasswordResetToken();

}