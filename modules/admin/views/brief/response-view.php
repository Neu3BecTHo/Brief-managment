<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */
/** @var app\models\User $user */
/** @var app\models\BriefAnswers[] $answers */

$this->title = 'Ответы: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Брифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $brief->title, 'url' => ['view', 'id' => $brief->id]];
$this->params['breadcrumbs'][] = ['label' => 'Все ответы', 'url' => ['responses', 'id' => $brief->id]];
$this->params['breadcrumbs'][] = $user->username;

$typeTranslations = [
    'text' => 'Текстовое поле', 'number' => 'Число', 'select' => 'Выпадающий список',
    'radio' => 'Радиокнопки', 'checkbox' => 'Чекбоксы', 'textarea' => 'Текстовая область',
    'date' => 'Дата', 'email' => 'Email', 'phone' => 'Телефон', 'color' => 'Выбор цвета',
];
$typeBadgeColors = [
    'text' => 'secondary', 'number' => 'info', 'select' => 'primary',
    'radio' => 'primary', 'checkbox' => 'primary', 'textarea' => 'secondary',
    'date' => 'warning', 'email' => 'info', 'phone' => 'info', 'color' => 'success',
];

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

<div class="response-view">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Ответы пользователя: <span class="text-primary"><?= Html::encode($user->username) ?></span></h1>
            <p class="text-muted mb-0"><?= Html::encode($user->email) ?></p>
        </div>
        
        <!-- Кнопки действий в хедере -->
        <div class="d-flex">
            <?= Html::a(
                '<svg width="14" height="14" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#mail') . '"></use></svg> Отправить мне',
                ['send-pdf', 'id' => $brief->id, 'response_user_id' => $user->id],
                ['class' => 'btn btn-outline-success me-1', 'data-method' => 'post']
            ) ?>
            
            <button type="button" class="btn btn-outline-success js-open-modal"
                    data-action-url="<?= Url::to(['send-pdf', 'id' => $brief->id, 'response_user_id' => $user->id]) ?>">
                <svg width="14" height="14" fill="currentColor"><use href="<?= Yii::getAlias('@web/icons/sprite.svg#send') ?>"></use></svg> Отправить...
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 50px;" class="text-center">#</th>
                            <th>Вопрос</th>
                            <th style="width: 180px;">Тип</th>
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
                                <td class="text-center text-muted"><?= $index + 1 ?></td>
                                <td>
                                    <div class="fw-bold mb-1"><?= Html::encode($question->question) ?></div>
                                    <?php if ($question->is_required) : ?>
                                        <span class="badge bg-danger" style="font-size: 0.6em">Обязательный</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $badgeColor ?>"><?= Html::encode($typeRu) ?></span>
                                </td>
                                <td>
                                    <?php if ($typeCode === 'color') : ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="color-dot" style="background: <?= Html::encode($answer->answer) ?>; width: 24px; height: 24px; border-radius: 4px; border: 1px solid #ddd;"></span>
                                            <code><?= Html::encode($answer->answer) ?></code>
                                        </div>
                                    <?php else : ?>
                                        <?= nl2br(Html::encode($answer->answer)) ?>
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
