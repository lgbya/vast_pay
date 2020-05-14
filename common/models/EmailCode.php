<?php

namespace common\models;

use Yii;
use common\helper\Helper;

/**
 * This is the model class for table "{{%email_code}}".
 *
 * @property int $id
 * @property string $email
 * @property string $code
 */
class EmailCode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%email_code}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'code'], 'required'],
            [['email', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'code' => '激活码',
        ];
    }

    public function sendCode($email)
    {
        $this->email = $email;
        $this->code = Helper::randomStr();
        if ($this->save()) {
            $subject = Yii::$app->name . '账号激活!!!';
            $htmlBody = '点击链接激活邮箱:' . Yii::$app->request->hostInfo . '/site/email-activate/' . $this->code;
            return Helper::sendEmail($email, $subject, $htmlBody);
        }
        return false;
    }
}
