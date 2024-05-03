<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use app\models\Admin;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ChangePassword extends Model
{
    public $USERNAME;
    public $PASSWORD_LAMA;
    public $PASSWORD_BARU;
    public $PASSWORD_BARU_REPEAT;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['USERNAME'], 'string'],
            [['PASSWORD_LAMA'], 'string','min'=>4],
            [['PASSWORD_BARU','PASSWORD_BARU_REPEAT'], 'string','min'=>6],
            [['PASSWORD_BARU_REPEAT'], 'compare', 'compareAttribute'=>'PASSWORD_BARU', 'message'=>"Passwords tidak sama" ],
            ['PASSWORD_LAMA', 'validatePasswordLama'],
            ['PASSWORD_BARU', 'validatePasswordBaru'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'USERNAME' => 'Username',
            'PASSWORD_LAMA' => 'Password Lama',
            'PASSWORD_BARU' => 'Password Baru',
            'PASSWORD_BARU_REPEAT' => 'Ulangi Password',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePasswordLama($attribute, $params)
    {
        $id = Yii::$app->user->identity->USERNAME;
        $model = Admin::find()->andWhere(['USERNAME'=>$id])->one();
        
        if(crypt($this->PASSWORD_LAMA, $model->PASSWORD) != $model->PASSWORD):
            $this->addError($attribute, 'Password lama tidak sesuai.');
        endif;
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePasswordBaru($attribute, $params)
    {
        $id = Yii::$app->user->identity->USERNAME;
        $model = Admin::find()->andWhere(['USERNAME'=>$id])->one();

        if(crypt($this->PASSWORD_BARU, $model->PASSWORD) == $model->PASSWORD):
            $this->addError($attribute, 'Password baru tidak boleh sama dengan password yang lama.');
        endif;
    }

}
