<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */
/** @var array $userAnswers */

$this->title = 'Ответы на бриф: ' . $brief->title;
$this->params['breadcrumbs'][] = ['label' => 'Брифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $brief->title, 'url' => ['view', 'id' => $brief->id]];
$this->params['breadcrumbs'][] = 'Ответы';

// CSS/JS для модалки (оставляем)
$this->registerCss("
    .custom-modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; justify-content: center; align-items: center; }
    .custom-modal-overlay.active { display: flex; }
    .custom-modal-window { background: #fff; padding: 25px; border-radius: 8px; width: 400px; max-width: 90%; position: relative; }
    .custom-modal-close { position: absolute; top: 10px; right: 15px; font-size: 24px; cursor: pointer; border: none; background: none; }
");

$this->registerJs("
    $('.js-open-modal').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('action-url');
        $('#modalForm').attr('action', url);
        $('#customEmailModal').addClass('active');
    });
    $('.js-close-modal').on('click', function() { $('#customEmailModal').removeClass('active'); });
    $('#customEmailModal').on('click', function(e) { if (e.target === this) $(this).removeClass('active'); });
");
?>

<div class="brief-responses">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Всего ответов: <strong><?= count($userAnswers) ?></strong></p>
        </div>
        <div>
            <?= Html::a('Назад к брифу', ['view', 'id' => $brief->id], ['class' => 'btn btn-outline-primary']) ?>
        </div>
    </div>

    <?php if (empty($userAnswers)) : ?>
        <div class="alert alert-info">
            <p class="mb-0">Пока нет ответов. Никто ещё не заполнил этот бриф.</p>
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Пользователь</th>
                        <th style="width: 120px;">Ответов</th>
                        <th style="width: 180px;">Дата заполнения</th>
                        <th class="text-end" style="width: 220px;">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userAnswers as $userId => $data) : ?>
                        <?php $user = $data['user']; ?>
                        <?php $answersCount = count($data['answers']); ?>
                        <?php $createdAt = $data['created_at']; ?>

                        <tr>
                            <td><?= $userId ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                        <svg width="16" height="16" fill="currentColor" class="text-secondary">
                                            <use href="/icons/sprite.svg#user"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <strong><?= Html::encode($user->username) ?></strong><br>
                                        <small class="text-muted"><?= Html::encode($user->email) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary"><?= $answersCount ?></span>
                            </td>
                            <td>
                                <?= Yii::$app->formatter->asDatetime($createdAt, 'php:d.m.Y H:i') ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <!-- Просмотр ответов -->
                                    <?= Html::a(
                                        '<svg width="14" height="14" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#eye') . '"></use></svg>',
                                        ['response-view', 'id' => $brief->id, 'user_id' => $userId],
                                        ['class' => 'btn btn-outline-primary', 'title' => 'Просмотр ответов']
                                    ) ?>

                                    <!-- Отправить себе -->
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
    <?php endif; ?>
</div>

<div id="customEmailModal" class="custom-modal-overlay">
    <div class="custom-modal-window">
        <button type="button" class="custom-modal-close js-close-modal">&times;</button>
        <h4 class="mb-3">Отправить отчет</h4>
        <?php $form = ActiveForm::begin(['id' => 'modalForm', 'method' => 'post']); ?>
            <div class="form-group mb-3">
                <?= Html::input('email', 'email', '', ['class' => 'form-control', 'placeholder' => 'email@example.com', 'required' => true]) ?>
            </div>
            <div class="text-end mt-4 d-flex">
                <button type="button" class="btn btn-outline-secondary me-2 js-close-modal">
                    <svg width="14" height="14" fill="currentColor"><use href="<?= Yii::getAlias('@web/icons/sprite.svg#home') ?>"></use></svg>Отмена</button>
                <?= Html::submitButton('<svg width="14" height="14" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#send') . '"></use></svg>Отправить', ['class' => 'btn btn-outline-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>