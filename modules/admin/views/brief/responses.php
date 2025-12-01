<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */
/** @var array $userAnswers */

$this->title = 'Ответы на бриф: ' . $brief->title;
$this->params['breadcrumbs'][] = ['label' => 'Брифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $brief->title, 'url' => ['view', 'id' => $brief->id]];
$this->params['breadcrumbs'][] = 'Ответы';

// Переводы типов
$typeTranslations = [
    'text' => 'Текстовое поле',
    'number' => 'Число',
    'select' => 'Выпадающий список',
    'radio' => 'Радиокнопки',
    'checkbox' => 'Чекбоксы',
    'textarea' => 'Текстовая область',
    'date' => 'Дата',
    'email' => 'Email',
    'phone' => 'Телефон',
    'color' => 'Выбор цвета',
];

$typeBadgeColors = [
    'text' => 'secondary',
    'number' => 'info',
    'select' => 'primary',
    'radio' => 'primary',
    'checkbox' => 'primary',
    'textarea' => 'secondary',
    'date' => 'warning',
    'email' => 'info',
    'phone' => 'info',
    'color' => 'success',
];
?>

<div class="brief-responses">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">
                Всего ответов: <strong><?= count($userAnswers) ?></strong>
            </p>
        </div>
        <div>
            <?= Html::a('Назад к брифу', ['view', 'id' => $brief->id], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php if (empty($userAnswers)) : ?>
        <div class="alert alert-info">
            <svg width="48" height="48" fill="currentColor" class="mb-3">
                <use href="/icons/sprite.svg#info"></use>
            </svg>
            <h5>Пока нет ответов</h5>
            <p class="mb-0">Никто ещё не заполнил этот бриф.</p>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach ($userAnswers as $userId => $data) : ?>
                <?php $user = $data['user']; ?>
                <?php $answers = $data['answers']; ?>
                <?php $createdAt = $data['created_at']; ?>

                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">
                                    <svg width="18" height="18" fill="currentColor" class="me-2">
                                        <use href="/icons/sprite.svg#user"></use>
                                    </svg>
                                    <?= Html::encode($user->username) ?>
                                </h5>
                                <small class="text-muted">
                                    Заполнено: <?= Yii::$app->formatter->asDatetime($createdAt) ?>
                                </small>
                            </div>
                            <span class="badge bg-primary">
                                <?= count($answers) ?> ответов
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;">#</th>
                                            <th>Вопрос</th>
                                            <th style="width: 180px;">Тип поля</th>
                                            <th style="width: 120px;">Статус</th>
                                            <th>Ответ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($answers as $index => $answer) : ?>
                                            <?php
                                            $question = $answer->briefQuestion;
                                            $typeCode = $question->typeField->title ?? '';
                                            $typeRu = $typeTranslations[$typeCode] ?? $typeCode;
                                            $badgeColor = $typeBadgeColors[$typeCode] ?? 'secondary';
                                            ?>
                                            <tr>
                                                <td class="text-center text-muted fw-bold">
                                                    <?= $index + 1 ?>
                                                </td>
                                                <td>
                                                    <strong><?= Html::encode($question->question) ?></strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $badgeColor ?>">
                                                        <?= Html::encode($typeRu) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($question->is_required) : ?>
                                                        <span class="badge bg-danger">Обязательный</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-light text-dark">Необязательный</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($typeCode === 'color') : ?>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="color-dot" 
                                                                  style="background: <?= Html::encode($answer->answer) ?>; 
                                                                         display: inline-block; 
                                                                         width: 24px; 
                                                                         height: 24px; 
                                                                         border-radius: 4px; 
                                                                         border: 1px solid rgba(0,0,0,0.1);">
                                                            </span>
                                                            <code><?= Html::encode($answer->answer) ?></code>
                                                        </div>
                                                    <?php else : ?>
                                                        <?= Html::encode($answer->answer) ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
