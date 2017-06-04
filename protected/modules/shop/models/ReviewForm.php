<?php

namespace shop\models;

use Yii;

class ReviewForm extends Review
{
    /**
     * used for captcha validation
     * @var string
     */
    public $verificationCode;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'verificationCode' => Yii::t('shop', 'Verification Code'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['verificationCode', 'required'],
            ['verificationCode', 'captcha', 'captchaAction'=>'/default/captcha'],
            [['author', 'text', 'rating'], 'required'],
        ];
    }
}
