<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $brief app\models\Briefs */
/* @var $answers app\models\BriefAnswers[] */

$this->title = $brief->title;
$this->params['breadcrumbs'][] = ['label' => 'Мои заполненные брифы', 'url' => ['completed']];
$this->params['breadcrumbs'][] = $this->title;

// Словари (оставляем как есть)
$typeTranslations = [
    'text' => 'Текстовое поле', 'number' => 'Число', 'select' => 'Выпадающий список',
    'radio' => 'Радиокнопки', 'checkbox' => 'Чекбоксы', 'textarea' => 'Текстовая область',
    'date' => 'Дата', 'email' => 'Email', 'phone' => 'Телефон',
    'color' => 'Выбор цвета', 'comment' => 'Комментарий',
];

$typeBadgeColors = [
    'text' => 'secondary', 'number' => 'info', 'select' => 'primary',
    'radio' => 'primary', 'checkbox' => 'primary', 'textarea' => 'secondary',
    'date' => 'warning', 'email' => 'info', 'phone' => 'info',
    'color' => 'success', 'comment' => 'secondary',
];
?>

<div class="brief-view container py-4">
    
    <!-- Шапка брифа -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                <div>
                    <h1 class="h3 fw-bold text-primary mb-2"><?= Html::encode($brief->title) ?></h1>
                    <p class="text-muted mb-0 lead small-mobile"><?= Html::encode($brief->description) ?></p>
                </div>
                <?= Html::a('← Назад', ['completed'], ['class' => 'btn btn-outline-secondary w-100 w-md-auto']) ?>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header bg-white border-bottom p-4">
            <h5 class="mb-0 fw-bold text-gray-800">Ваши ответы</h5>
        </div>
        
        <div class="table-responsive mobile-card-view">
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
                            <td class="text-center text-muted fw-bold" data-label="#"><?= $index + 1 ?></td>
                            
                            <td data-label="Вопрос">
                                <div class="fw-bold mb-1 question-text"><?= Html::encode($question->question) ?></div>
                                <?php if ($question->is_required) : ?>
                                    <span 
                                    class="badge bg-danger bg-opacity-10 text-danger mobile-badge"
                                    >Обязательный</span>
                                <?php endif; ?>
                            </td>
                            
                            <td data-label="Тип">
                                <span class="badge bg-<?= $badgeColor ?> fw-normal"><?= Html::encode($typeRu) ?></span>
                            </td>
                            
                            <td data-label="Ответ" class="answer-cell">
                                <?php if ($typeCode === 'color') : ?>
                                    <div class="d-flex align-items-center gap-2 answer-content">
                                        <span class="color-dot" 
                                        style="
                                        background: <?= Html::encode($answer->answer) ?>; 
                                        width: 24px; 
                                        height: 24px; 
                                        border-radius: 4px; 
                                        border: 1px solid #ddd;
                                        "></span>
                                        <code><?= Html::encode($answer->answer) ?></code>
                                    </div>
                                <?php else : ?>
                                    <div class="answer-content">
                                        <?= nl2br(Html::encode($answer->answer)) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="card-footer bg-white p-4 border-top">
            <small class="text-muted">
                Бриф заполнен: <?= Yii::$app->formatter->asDatetime($answers[0]->created_at ?? 'now') ?>
            </small>
        </div>
    </div>
</div>