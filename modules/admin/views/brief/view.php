<?php

use yii\helpers\Html;
use app\models\TypeField;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */

$this->title = $brief->title;
$this->params['breadcrumbs'][] = ['label' => 'Брифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
    'comment' => 'Комментарий',
];

// Иконки
$typeIcons = [
    'text' => 'document',
    'number' => 'document',
    'select' => 'brief',
    'radio' => 'brief',
    'checkbox' => 'brief',
    'textarea' => 'document',
    'date' => 'document',
    'email' => 'document',
    'phone' => 'document',
    'color' => 'palette',
];

// Цвета бейджей
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
    'comment' => 'secondary',
];
?>

<div class="brief-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="btn-group" role="group">
            <?= Html::a('Редактировать', ['update', 'id' => $brief->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Ответы', ['responses', 'id' => $brief->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $brief->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Информация о брифе</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 200px;">Название:</th>
                            <td><?= Html::encode($brief->title) ?></td>
                        </tr>
                        <tr>
                            <th>Описание:</th>
                            <td><?= Html::encode($brief->description) ?></td>
                        </tr>
                        <tr>
                            <th>Статус:</th>
                            <td><span class="badge bg-primary"><?= Html::encode($brief->status->title) ?></span></td>
                        </tr>
                        <tr>
                            <th>Создатель:</th>
                            <td><?= Html::encode($brief->user->username) ?></td>
                        </tr>
                        <tr>
                            <th>Создан:</th>
                            <td><?= Yii::$app->formatter->asDatetime($brief->created_at) ?></td>
                        </tr>
                        <tr>
                            <th>Обновлён:</th>
                            <td><?= Yii::$app->formatter->asDatetime($brief->updated_at) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Вопросы (<?= count($brief->briefQuestions) ?>)</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($brief->briefQuestions)) : ?>
                        <p class="text-muted p-4 mb-0">Вопросов пока нет.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Вопрос</th>
                                        <th style="width: 180px;">Тип поля</th>
                                        <th style="width: 140px;">Статус</th>
                                        <th>Варианты</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($brief->briefQuestions as $index => $question) : ?>
                                        <?php
                                        $typeCode = $question->typeField->title;
                                        $typeRu = $typeTranslations[$typeCode] ?? $typeCode;
                                        $icon = $typeIcons[$typeCode] ?? 'document';
                                        $badgeColor = $typeBadgeColors[$typeCode] ?? 'secondary';
                                        ?>
                                        <tr>
                                            <td class="text-center text-muted fw-bold"><?= $index + 1 ?></td>
                                            <td>
                                                <strong><?= Html::encode($question->question) ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $badgeColor ?> d-inline-flex align-items-center gap-1">
                                                    <svg width="12" height="12" fill="currentColor">
                                                        <use href="/icons/sprite.svg#<?= $icon ?>"></use>
                                                    </svg>
                                                    <?= $typeRu ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($question->is_required) : ?>
                                                    <span class="badge bg-danger">Обязательное</span>
                                                <?php else : ?>
                                                    <span class="badge bg-light text-dark">Необязательное</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($question->options) : ?>
                                                    <?php
                                                    $options = $question->getOptionsArray();
                                                    if (count($options) > 3) {
                                                        echo Html::encode(implode(', ', array_slice($options, 0, 3))) . '...';
                                                        echo ' <small class="text-muted">(+' . (count($options) - 3) . ')</small>';
                                                    } else {
                                                        echo Html::encode(implode(', ', $options));
                                                    }
                                                    ?>
                                                <?php else : ?>
                                                    <span class="text-muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
