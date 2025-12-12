<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */
/** @var app\models\BriefAnswers[] $userAnswers */

$this->title = 'Ответы на бриф: ' . $brief->title;
$this->params['breadcrumbs'][] = ['label' => 'Брифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $brief->title, 'url' => ['view', 'id' => $brief->id]];
$this->params['breadcrumbs'][] = 'Ответы';
?>

<div class="brief-responses d-flex flex-column gap-3">

    <div class="d-flex row-mobile justify-content-between align-items-center mb-2 flex-wrap">
        <div class="text-center">
            <h1 class="h2 mb-1 fw-bold text-gray-800">
                <?= Html::encode($brief->title) ?>
            </h1>
        </div>

        <?= Html::a(
            '<svg width="20" height="20" class="me-1" fill="currentColor">
                <use href="' . Yii::getAlias('@web/icons/sprite.svg#brief') . '"></use>
             </svg> К брифу',
            ['view', 'id' => $brief->id],
            ['class' => 'btn btn-primary d-flex align-items-center px-3 py-2 shadow-sm btn-sm']
        ) ?>
    </div>

    <?php if (empty($userAnswers)) : ?>
        <div class="alert alert-info shadow-sm border-0 rounded-3 p-4 mb-0">
            <div class="d-flex align-items-center gap-3">
                <svg width="24" height="24" class="text-info flex-shrink-0" fill="currentColor">
                    <use href="<?= Yii::getAlias('@web/icons/sprite.svg#info') ?>"></use>
                </svg>
                <div>
                    <h5 class="alert-heading mb-1 fw-bold">Ответов пока нет</h5>
                    <p class="mb-0 text-muted">Как только появятся заполненные брифы, они отобразятся здесь.</p>
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
                            <th scope="col" class="py-3 border-bottom-0">Пользователь</th>
                            <th scope="col" class="py-3 border-bottom-0">Дата</th>
                            <th scope="col" class="py-3 border-bottom-0">Ответов</th>
                            <th scope="col" class="text-end pe-4 py-3 border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php foreach ($userAnswers as $userId => $data) : ?>
                            <?php $user = $data['user']; ?>
                            <?php $answersCount = count($data['answers']); ?>
                            <?php $createdAt = $data['created_at']; ?>
                            <tr class="brief-row">
                                <td class="ps-4 text-muted fw-bold small" data-label="ID">
                                    #<?= $userId ?>
                                </td>

                                <td data-label="Пользователь" class="cell-title">
                                    <div class="fw-bold text-dark mb-1 text-break fs-6 cell-title-text">
                                        <?= Html::encode($user->username ?? 'Аноним') ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= Yii::$app->formatter->asDatetime($createdAt) ?>
                                    </div>
                                </td>

                                <td data-label="Дата" class="cell-date">
                                    <div class="d-flex flex-column">
                                        <span class="text-dark fw-medium fs-7">
                                            <?= Yii::$app->formatter->asDate($createdAt, 'php:d.m.Y') ?>
                                        </span>
                                        <span class="text-muted small">
                                            <?= Yii::$app->formatter->asTime($createdAt, 'php:H:i') ?>
                                        </span>
                                    </div>
                                </td>

                                <td data-label="Ответов" class="cell-info">
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                                        <?= $answersCount ?> полей
                                    </span>
                                </td>

                                <td class="cell-actions">
                                    <div class="btn-group btn-group-sm w-100">
                                        <?= Html::a(
                                            '<svg width="14" height="14" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#eye') . '"></use></svg>',
                                            ['response-view', 'id' => $brief->id, 'user_id' => $userId],
                                            ['class' => 'btn btn-outline-primary', 'title' => 'Просмотр ответов']
                                        ) ?>

                                        <?= Html::a(
                                            '<svg width="14" height="14" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#mail') . '"></use></svg>',
                                            ['send-pdf', 'id' => $brief->id, 'response_user_id' => $userId],
                                            [
                                                'class' => 'btn btn-outline-success',
                                                'title' => 'Отправить PDF себе',
                                                'data' => [
                                                    'method' => 'post',
                                                    'confirm' => 'Отправить отчет на ваш email?'
                                                ]
                                            ]
                                        ) ?>

                                        <button type="button" 
                                                class="btn btn-outline-success btn-sm js-open-modal" 
                                                title="Отправить на другой email"
                                                data-action-url="<?= Url::to(['send-pdf', 'id' => $brief->id, 'response_user_id' => $userId]) ?>">
                                                <svg width="14" height="14" fill="currentColor"><use href="<?= Yii::getAlias('@web/icons/sprite.svg#send') ?>"></use></svg>
                                        </button>
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

<?= $this->render('_emailModal', [
    'modalId' => 'customEmailModal',
    'action' => ['send-pdf'],
]) ?>
