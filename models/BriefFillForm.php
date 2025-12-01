<?php

namespace app\models;

use yii\base\Model;

class BriefFillForm extends Model
{
    public array $answers = [];

    private Briefs $brief;

    public function __construct(Briefs $brief, $config = [])
    {
        $this->brief = $brief;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['answers', 'required'],
            ['answers', 'validateAnswers'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'answers' => 'Ответы на вопросы',
        ];
    }

    public function validateAnswers($attribute): void
    {
        foreach ($this->brief->briefQuestions as $question) {
            $qid = $question->id;
            $value = $this->answers[$qid] ?? null;

            // Обязательные
            if ($question->is_required) {
                if (is_array($value)) {
                    if (!array_filter($value, fn ($v) => trim((string)$v) !== '')) {
                        $this->addError("answers[$qid]", 'Это обязательный вопрос.');
                        continue;
                    }
                } else {
                    if ($value === null || trim((string)$value) === '') {
                        $this->addError("answers[$qid]", 'Это обязательный вопрос.');
                        continue;
                    }
                }
            }

            // Дополнительная валидация по типу
            $type = $question->typeField->title;

            if ($type === 'email' && $value) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError("answers[$qid]", 'Введите корректный email.');
                }
            }

            if ($type === 'number' && $value !== null && $value !== '') {
                if (!is_numeric($value)) {
                    $this->addError("answers[$qid]", 'Введите число.');
                }
            }

            if ($type === 'phone' && $value) {
                if (!preg_match('/^\+7\s?\(\d{3}\)\s?\d{3}-\d{2}-\d{2}$/', $value)) {
                    $this->addError("answers[$qid]", 'Введите корректный номер телефона.');
                }
            }
        }
    }
}
