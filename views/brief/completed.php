<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Briefs[] $completedBriefs */

$this->title = 'Заполненные брифы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brief-completed">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Доступные брифы', ['available'], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Список заполненных брифов</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($completedBriefs)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Заголовок</th>
                                <th>Описание</th>
                                <th>Автор</th>
                                <th>Статус</th>
                                <th>Дата создания</th>
                                <th>Дата обновления</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($completedBriefs as $brief) : ?>
                                <tr>
                                    <td><?= $brief->id ?></td>
                                    <td><?= Html::encode($brief->title) ?></td>
                                    <td><?= Html::encode(mb_substr($brief->description, 0, 100) . '...') ?></td>
                                    <td><?= Html::encode($brief->user->username ?? 'Неизвестно') ?></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?= Html::encode($brief->status->title) ?>
                                        </span>
                                    </td>
                                    <td><?= Yii::$app->formatter->asDate($brief->created_at) ?></td>
                                    <td><?= Yii::$app->formatter->asDate($brief->updated_at) ?></td>
                                    <td>
                                        <?= Html::a(
                                            'Просмотр',
                                            ['view', 'id' => $brief->id],
                                            ['class' => 'btn btn-sm btn-info']
                                        ) ?>
                                        <?= Html::a(
                                            'Редактировать',
                                            ['update', 'id' => $brief->id],
                                            ['class' => 'btn btn-sm btn-warning']
                                        ) ?>
                                        <?= Html::a(
                                            'Удалить',
                                            ['delete', 'id' => $brief->id],
                                            [
                                                'class' => 'btn btn-sm btn-danger',
                                                'data' => [
                                                    'confirm' => 'Вы уверены, что хотите удалить этот бриф?',
                                                    'method' => 'post',
                                                ],
                                            ]
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="alert alert-info">
                    <h4 class="alert-heading">Нет заполненных брифов</h4>
                    <p>В настоящее время нет заполненных брифов. Перейдите к доступным брифам, чтобы начать работу.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
