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
            [['username', 'first_name', 'last_name', 'patronymic'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^\+7\s?\(\d{3}\)\s?\d{3}-\d{2}-\d{2}$/',
            'message' => 'Введите номер телефона в формате +7 (XXX) XXX-XX-XX'],
            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username'],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],
            [['phone'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'phone'],
        ];
    }

        // Установка локализации для полей
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'email' => 'Электронная почта',
            'phone' => 'Телефон',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'patronymic' => 'Отчество',
        ];
    }

    public function register()
    {
        if ($this->validate()) {
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
                    Yii::$app->session->setFlash('error', 'Пользователь не зарегистрирован: ' .
                    implode(' ', $user->getFirstErrors()));
                }
                return false;
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return false;
            }
        };
    }
}
