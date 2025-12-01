<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%type_fields}}".
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 *
 * @property BriefQuestions[] $briefQuestions
 */
class TypeFields extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%type_fields}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Заголовок'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }

    /**
     * Получение списка типов для выпадающего списка с переводом
     */
    public static function getTypesDropdown()
    {
        $types = self::find()->select(['title', 'id'])->indexBy('id')->column();

        $translations = [
        'text' => 'Текстовое поле',
        'number' => 'Число',
        'select' => 'Выпадающий список',
        'radio' => 'Радиокнопки',
        'checkbox' => 'Чекбоксы',
        'textarea' => 'Текстовая область',
        'date' => 'Дата',
        'email' => 'Email',
        'phone' => 'Телефон',
        'color' => 'Цвет',
        'comment' => 'Комментарий',
        ];

        $result = [];
        foreach ($types as $id => $code) {
            $result[$id] = $translations[$code] ?? $code;
        }

        return $result;
    }

    /**
     * Gets query for [[BriefQuestions]].
     *
     * @return ActiveQuery
     */
    public function getBriefQuestions()
    {
        return $this->hasMany(BriefQuestions::class, ['type_field_id' => 'id']);
    }
}
