<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%brief_answers}}".
 *
 * @property int $id
 * @property int $brief_question_id
 * @property int $user_id
 * @property string $answer
 * @property string $created_at
 * @property string $updated_at
 *
 * @property BriefQuestions $briefQuestion
 * @property User $user
 */
class BriefAnswers extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%brief_answers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brief_question_id', 'user_id', 'answer'], 'required'],
            [['brief_question_id', 'user_id'], 'integer'],
            [['answer'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['brief_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => BriefQuestions::class, 'targetAttribute' => ['brief_question_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'brief_question_id' => Yii::t('app', 'Вопрос'),
            'user_id' => Yii::t('app', 'Пользователь'),
            'answer' => Yii::t('app', 'Ответ'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }

    /**
     * Gets query for [[BriefQuestion]].
     *
     * @return ActiveQuery
     */
    public function getBriefQuestion()
    {
        return $this->hasOne(BriefQuestions::class, ['id' => 'brief_question_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
