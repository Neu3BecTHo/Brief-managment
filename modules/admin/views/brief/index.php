<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Briefs[] $briefs */

$this->title = 'Управление брифами';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="brief-index d-flex flex-column gap-3">
    
    <div class="d-flex justify-content-between mobile-justify-content-center align-items-center mb-2 flex-wrap gap-2">
        <h1 class="h2 mb-0 fw-bold text-gray-800"><?= Html::encode($this->title) ?></h1>
        <?= Html::a(
            '<svg width="20" height="20" class="me-2" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#document') . '"></use></svg> Создать бриф',
            ['create'],
            ['class' => 'btn btn-primary d-flex align-items-center px-3 py-2 shadow-sm']
        ) ?>
    </div>

    <?php if (empty($briefs)) : ?>
        <div class="alert alert-info shadow-sm border-0 rounded-3 p-4">
            <div class="d-flex align-items-center gap-3">
                <svg width="24" height="24" class="text-info flex-shrink-0" fill="currentColor"><use href="<?= Yii::getAlias('@web/icons/sprite.svg#document') ?>"></use></svg>
                <div>
                    <h5 class="alert-heading mb-1 fw-bold">Список пуст</h5>
                    <p class="mb-0">Брифов пока нет. Создайте первый бриф!</p>
                </div>
            </div>
        </div>
    <?php else : ?>
        
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white w-100">
            <div class="table-responsive admin-table-mobile-cards">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase text-muted small fw-bold">
                        <tr>
                            <th scope="col" class="ps-4 py-3 border-bottom-0">ID</th>
                            <th scope="col" class="py-3 border-bottom-0">Название</th>
                            <th scope="col" class="py-3 border-bottom-0">Статус</th>
                            <th scope="col" class="py-3 border-bottom-0">Инфо</th>
                            <th scope="col" class="py-3 border-bottom-0">Дата</th>
                            <th scope="col" class="text-end pe-4 py-3 border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php foreach ($briefs as $brief) : ?>
                            <tr>
                                <td class="text-muted fw-bold small" data-label="ID">#<?= $brief->id ?></td>

                                <td data-label="Статус">
                                    <?php
                                    $statusClass = match($brief->status_id) {
                                        1 => 'bg-secondary',
                                        2 => 'bg-success',
                                        3 => 'bg-warning text-dark',
                                        default => 'bg-primary'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2 fw-normal d-inline-flex align-items-center gap-1">
                                        <?= Html::encode($brief->status->title) ?>
                                    </span>
                                </td>
                                
                                <td data-label="Название" class="cell-title">
                                    <div class="fw-bold text-dark mb-1 text-break fs-6">
                                        <?= Html::encode($brief->title) ?>
                                    </div>
                                    <div class="text-muted small text-truncate d-none d-md-block" style="max-width: 300px;">
                                        <?= Html::encode($brief->description) ?>
                                    </div>
                                </td>
                                
                                <td data-label="Инфо" class="cell-info">
                                    <div class="d-flex align-items-end flex-column gap-1">
                                        <div class="d-flex align-items-center gap-2 text-muted small">
                                            <svg width="14" height="14" fill="currentColor" class="opacity-50"><use href="<?= Yii::getAlias('@web/icons/sprite.svg#document') ?>"></use></svg>
                                            <span><?= count($brief->briefQuestions) ?> вопросов</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-muted small">
                                            <svg width="14" height="14" fill="currentColor" class="opacity-50"><use href="<?= Yii::getAlias('@web/icons/sprite.svg#user') ?>"></use></svg>
                                            <span><?= Html::encode($brief->user->username) ?></span>
                                        </div>
                                    </div>
                                </td>
                                
                                <td data-label="Дата" class="cell-date">
                                    <div class="d-flex flex-column">
                                        <span class="text-dark fw-medium fs-7">
                                            <?= Yii::$app->formatter->asDate($brief->created_at, 'php:d.m.Y') ?>
                                        </span>
                                        <span class="text-muted small">
                                            <?= Yii::$app->formatter->asTime($brief->created_at, 'php:H:i') ?>
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="text-end cell-actions">
                                    <div class="btn-group shadow-sm rounded-3 bg-white border" role="group">
                                        <?= Html::a(
                                            '<svg width="16" height="16" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#brief') . '"></use></svg>',
                                            ['view', 'id' => $brief->id],
                                            ['class' => 'btn btn-sm btn-light text-primary', 'title' => 'Просмотр']
                                        ) ?>
                                        <?= Html::a(
                                            '<svg width="16" height="16" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#pencil') . '"></use></svg>',
                                            ['update', 'id' => $brief->id],
                                            ['class' => 'btn btn-sm btn-light text-dark', 'title' => 'Редактировать']
                                        ) ?>
                                        <?= Html::a(
                                            '<svg width="16" height="16" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#eye') . '"></use></svg>',
                                            ['responses', 'id' => $brief->id],
                                            ['class' => 'btn btn-sm btn-light text-success', 'title' => 'Ответы']
                                        ) ?>
                                        <?= Html::a(
                                            '<svg width="16" height="16" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#trash') . '"></use></svg>',
                                            ['delete', 'id' => $brief->id],
                                            [
                                                'class' => 'btn btn-sm btn-light text-danger',
                                                'title' => 'Удалить',
                                                'data' => [
                                                    'confirm' => 'Удалить этот бриф?',
                                                    'method' => 'post',
                                                ],
                                            ]
                                        ) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>