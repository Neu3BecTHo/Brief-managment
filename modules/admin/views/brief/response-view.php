<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
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
?>

<div class="response-view">
    
    <div class="d-flex row-mobile gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1>Ответы пользователя: <span class="text-primary"><?= Html::encode($user->username) ?></span></h1>
            <p class="text-muted mb-0"><?= Html::encode($user->email) ?></p>
        </div>
        
        <div class="d-flex gap-2">
            <?= Html::a(
                '<svg width="14" height="14" fill="currentColor"><use href="' . Yii::getAlias('@web/icons/sprite.svg#mail') . '"></use></svg> Отправить мне',
                ['send-pdf', 'id' => $brief->id, 'response_user_id' => $user->id],
                ['class' => 'btn btn-success', 'data-method' => 'post']
            ) ?>
            
            <button type="button" class="btn btn-success js-open-modal"
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
                            <th>#</th>
                            <th>Вопрос</th>
                            <th>Тип</th>
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
                                <td class="text-muted" tdta-label="#"><?= $index + 1 ?></td>
                                <td data-label="Вопрос">
                                    <div class="fw-bold mb-1">
                                        <div class="d-flex align-items-center flex-end gap-1">
                                            <?= Html::encode($question->question) ?>
                                            <?php if ($question->is_required) : ?>
                                                <span class="badge bg-danger mt-0" style="font-size: 0.6em">Обязательный</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Тип">
                                    <span class="badge bg-<?= $badgeColor ?>"><?= Html::encode($typeRu) ?></span>
                                </td>
                                <td data-label="Ответ">
                                    <?php if ($typeCode === 'color') : ?>
                                        <div class="gap-2 d-flex flex-end">
                                            <span class="color-dot" style="background: <?= Html::encode($answer->answer) ?>; display: inline-block; width: 24px; height: 24px; border-radius: 4px; border: 1px solid #ddd;"></span>
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

<?= $this->render('_emailModal', [
    'modalId' => 'customEmailModal',
    'action' => ['send-pdf'],
]) ?>