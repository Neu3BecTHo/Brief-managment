<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Briefs[] $briefs */

$this->title = 'Управление брифами';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="brief-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a(
            '<svg width="16" height="16" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#document') . '"></use></svg> Создать бриф',
            ['create'],
            ['class' => 'btn btn-primary d-flex align-items-center gap-2']
        ) ?>
    </div>

    <?php if (empty($briefs)) : ?>
        <div class="alert alert-info">
            <p class="mb-0">Брифов пока нет. Создайте первый бриф!</p>
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Статус</th>
                        <th>Вопросов</th>
                        <th>Создатель</th>
                        <th>Создан</th>
                        <th class="text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($briefs as $brief) : ?>
                        <tr>
                            <td><?= $brief->id ?></td>
                            <td>
                                <strong><?= Html::encode($brief->title) ?></strong><br>
                                <small class="text-muted"><?= Html::encode($brief->description) ?></small>
                            </td>
                            <td>
                                <span class="badge bg-primary"><?= Html::encode($brief->status->title) ?></span>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?= count($brief->briefQuestions) ?></span>
                            </td>
                            <td><?= Html::encode($brief->user->username) ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($brief->created_at, 'php:d.m.Y H:i') ?></td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <?= Html::a(
                                        '<svg width="14" height="14" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#brief') . '"></use></svg>',
                                        ['view', 'id' => $brief->id],
                                        ['class' => 'btn btn-outline-primary', 'title' => 'Просмотр']
                                    ) ?>
                                    <?= Html::a(
                                        '<svg width="14" height="14" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#settings') . '"></use></svg>',
                                        ['update', 'id' => $brief->id],
                                        ['class' => 'btn btn-outline-secondary', 'title' => 'Редактировать']
                                    ) ?>
                                    <?= Html::a(
                                        '<svg width="14" height="14" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#file-text') . '"></use></svg>',
                                        ['responses', 'id' => $brief->id],
                                        ['class' => 'btn btn-outline-success', 'title' => 'Ответы']
                                    ) ?>
                                    <?= Html::a(
                                        '×',
                                        ['delete', 'id' => $brief->id],
                                        [
                                            'class' => 'btn btn-outline-danger',
                                            'title' => 'Удалить',
                                            'data' => [
                                                'confirm' => 'Вы уверены, что хотите удалить этот бриф?',
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
    <?php endif; ?>
</div>
