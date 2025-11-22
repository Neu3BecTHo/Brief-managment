<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $first_name
 * @property string $last_name
 * @property string|null $patronymic
 * @property string $auth_key
 * @property string $access_token
 * @property string $created_at
 * @property string $updated_at
 *
 * @property BriefAnswers[] $briefAnswers
 * @property Briefs[] $briefs
 */

class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;

    // Использование таблицы из БД
    public static function tableName()
    {
        return '{{%users}}';
    }

    // Установка правила для полей

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patronymic'], 'default', 'value' => null],
            [['username', 'password', 'email', 'phone', 'first_name', 'last_name', 'auth_key', 'access_token'], 'required'],
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
            'auth_key' => 'Ключ авторизации',
            'access_token' => 'Токен доступа',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    // Поиск по данным пользователя

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    // Access-токен

    public function generateAccessToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function validateAccessToken($token)
    {
        return $this->accessToken === $token;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    // Auth-токен

    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    // Пароль

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    // Связи

        /**
     * Gets query for [[BriefAnswers]].
     *
     * @return ActiveQuery
     */
    public function getBriefAnswers()
    {
        return $this->hasMany(BriefAnswers::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Briefs]].
     *
     * @return ActiveQuery
     */
    public function getBriefs()
    {
        return $this->hasMany(Briefs::class, ['user_id' => 'id']);
    }

    // Действия перед сохранением пользователя

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->generateAuthKey();
            $this->generateAccessToken();
        }

        return parent::beforeSave($insert);
    }

    // Действия после сохранения пользователя

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

    // Действия перед удалением пользователя

    public function beforeDelete()
    {
        return parent::beforeDelete();
    }

    // Действия после удаления пользователя

    public function afterDelete()
    {
        parent::afterDelete();
    }
}
