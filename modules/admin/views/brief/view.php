<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */

$this->title = $brief->title;
$this->params['breadcrumbs'][] = ['label' => 'Брифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
    'comment' => 'document',
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
    'comment' => 'secondary',
];

?>

<div class="brief-view d-flex flex-column gap-3">

    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
        <div class="h2-center">
            <h1 class="h2 mb-1 fw-bold text-gray-800"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <?= Html::a(
                '<svg width="20" height="20" class="me-1" fill="currentColor">
                    <use href="' . Yii::getAlias('@web/icons/sprite.svg#pencil') . '"></use>
                 </svg> Редактировать',
                ['update', 'id' => $brief->id],
                ['class' => 'btn btn-primary d-flex align-items-center px-3 py-2 shadow-sm btn-sm']
            ) ?>
            <?= Html::a(
                '<svg width="20" height="20" class="me-1" fill="currentColor">
                    <use href="' . Yii::getAlias('@web/icons/sprite.svg#trash') . '"></use>
                 </svg> Удалить',
                ['delete', 'id' => $brief->id],
                [
                    'class' => 'btn btn-danger d-flex align-items-center px-3 py-2 shadow-sm btn-sm',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                        'method' => 'post',
                    ],
                ]
            ) ?>
        </div>
    </div>

    <div class="row flex-column g-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0 small text-uppercase text-muted">
                        <svg width="16" height="16" class="me-1" fill="currentColor">
                            <use href="<?= Yii::getAlias('@web/icons/sprite.svg#document') ?>"></use>
                        </svg>
                        Информация о брифе
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="mb-0 brief-meta">
                        <div class="brief-meta-row">
                            <dt>Название</dt>
                            <dd><?= Html::encode($brief->title) ?></dd>
                        </div>
                        <?php if ($brief->description) : ?>
                            <div class="brief-meta-row">
                                <dt>Описание</dt>
                                <dd class="text-muted"><?= Html::encode($brief->description) ?></dd>
                            </div>
                        <?php endif; ?>
                        <div class="brief-meta-row">
                            <dt>Статус</dt>
                            <dd>
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    <?= Html::encode($brief->status->title) ?>
                                </span>
                            </dd>
                        </div>
                        <div class="brief-meta-row">
                            <dt>Создатель</dt>
                            <dd><?= Html::encode($brief->user->username) ?></dd>
                        </div>
                        <div class="brief-meta-row">
                            <dt>Создан</dt>
                            <dd><?= Yii::$app->formatter->asDatetime($brief->created_at) ?></dd>
                        </div>
                        <div class="brief-meta-row">
                            <dt>Обновлён</dt>
                            <dd><?= Yii::$app->formatter->asDatetime($brief->updated_at) ?></dd>
                        </div>
                        <div class="brief-meta-row">
                            <dt>Вопросов</dt>
                            <dd><?= count($brief->briefQuestions) ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-light border-0">
                    <h5 class="mb-0 small text-uppercase text-muted">
                        <svg width="16" height="16" class="me-1" fill="currentColor">
                            <use href="<?= Yii::getAlias('@web/icons/sprite.svg#brief') ?>"></use>
                        </svg>
                        Вопросы (<?= count($brief->briefQuestions) ?>)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($brief->briefQuestions)) : ?>
                        <p class="text-muted p-4 mb-0">Вопросов пока нет.</p>
                    <?php else : ?>
                        <div class="table-responsive admin-brief-view-questions">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light text-muted small text-uppercase">
                                    <tr>
                                        <th>#</th>
                                        <th>Вопрос</th>
                                        <th>Тип поля</th>
                                        <th>Статус</th>
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
                                            <td data-label="#">
                                                <?= $index + 1 ?>
                                            </td>
                                            <td data-label="Вопрос">
                                                <div class="fw-semibold mb-1">
                                                    <?= Html::encode($question->question) ?>
                                                </div>
                                                <?php if (!empty($question->description)) : ?>
                                                    <div class="text-muted small">
                                                        <?= Html::encode($question->description) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="Тип поля">
                                                <span class="badge bg-<?= $badgeColor ?> d-inline-flex align-items-center gap-1">
                                                    <svg width="12" height="12" fill="currentColor">
                                                        <use href="/icons/sprite.svg#<?= $icon ?>"></use>
                                                    </svg>
                                                    <?= Html::encode($typeRu) ?>
                                                </span>
                                            </td>
                                            <td data-label="Статус">
                                                <?php if ($question->is_required) : ?>
                                                    <span class="badge bg-danger">Обязательное</span>
                                                <?php else : ?>
                                                    <span class="badge bg-light text-muted">Необязательное</span>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="Варианты">
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
