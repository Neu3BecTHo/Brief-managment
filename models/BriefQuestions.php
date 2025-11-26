<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%brief_questions}}".
 *
 * @property int $id
 * @property int $brief_id
 * @property int $type_field_id
 * @property string $question
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Briefs $brief
 * @property BriefAnswers[] $briefAnswers
 * @property TypeFields $typeField
 */
class BriefQuestions extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%brief_questions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brief_id', 'type_field_id', 'question'], 'required'],
            [['brief_id', 'type_field_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['question'], 'string', 'max' => 255],
            [['brief_id'], 'exist', 'skipOnError' => true,
            'targetClass' => Briefs::class,
            'targetAttribute' => ['brief_id' => 'id']],
            [['type_field_id'], 'exist', 'skipOnError' => true,
            'targetClass' => TypeFields::class,
            'targetAttribute' => ['type_field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'brief_id' => Yii::t('app', 'Бриф'),
            'type_field_id' => Yii::t('app', 'Тип поля'),
            'question' => Yii::t('app', 'Вопрос'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }

    /**
     * Gets query for [[Brief]].
     *
     * @return ActiveQuery
     */
    public function getBrief()
    {
        return $this->hasOne(Briefs::class, ['id' => 'brief_id']);
    }

    /**
     * Gets query for [[BriefAnswers]].
     *
     * @return ActiveQuery
     */
    public function getBriefAnswers()
    {
        return $this->hasMany(BriefAnswers::class, ['brief_question_id' => 'id']);
    }

    /**
     * Gets query for [[TypeField]].
     *
     * @return ActiveQuery
     */
    public function getTypeField()
    {
        return $this->hasOne(TypeFields::class, ['id' => 'type_field_id']);
    }
}
