<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $phone;
    public $first_name;
    public $last_name;
    public $patronymic;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patronymic'], 'default', 'value' => null],
            [['username', 'password', 'email', 'phone', 'first_name', 'last_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'first_name', 'last_name', 'patronymic'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
        ];
    }

   public function register()
   {
        if ($this->load(Yii::$app->request->post()) && $this->validate()) {
            try {
                $user = new User();
                $user->username = $this->username;
                $user->password = $this->password;
                $user->email = $this->email;
                $user->phone = $this->phone;
                $user->first_name = $this->first_name;
                $user->last_name = $this->last_name;
                $user->patronymic = $this->patronymic;
                if ($user->save()) {
                    Yii::$app->session->setFlash('success', 'Пользователь успешно зарегистрирован.');
                    if (Yii::$app->user->login($user)) {
                        return $user;
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Пользователь не зарегистрирован: ' . implode(' ', $user->getFirstErrors()));
                }
                return false;
            } catch (\Exception $e) {
                return Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return Yii::$app->session->setFlash('error', 'Пользователь не зарегистрирован.');
   }
}
