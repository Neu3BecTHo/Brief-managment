<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $items */

$this->title = 'Мои заполненные брифы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="brief-completed">
    <div class="text-center mb-5">
        <h1 class="display-6 fw-light"><?= Html::encode($this->title) ?></h1>
        <p class="text-muted">История ваших заполненных брифов</p>
    </div>

    <?php if (empty($items)) : ?>
        <div class="alert alert-info text-center">
            <svg width="48" height="48" fill="currentColor" class="mb-3">
                <use href="/icons/sprite.svg#info"></use>
            </svg>
            <h5>Вы ещё не заполняли брифы</h5>
            <p class="mb-3">Перейдите к доступным брифам и заполните первый бриф</p>
            <?= Html::a('Перейти к брифам', ['available'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach ($items as $item) : ?>
                <?php $brief = $item['brief']; ?>
                <?php $briefAnswers = $item['answers']; ?>

                <div class="col-12">
                    <div class="card floating-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1"><?= Html::encode($brief->title) ?></h5>
                                <small class="text-muted">
                                    Заполнено: <?= Yii::$app->formatter->asDatetime($briefAnswers[0]->created_at) ?>
                                </small>
                            </div>
                            <span class="badge bg-primary">
                                <?= count($briefAnswers) ?> ответов
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 60px;">#</th>
                                            <th>Вопрос</th>
                                            <th style="width: 180px;">Тип поля</th>
                                            <th>Ответ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
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
                                        ];
                                        ?>

                                        <?php foreach ($briefAnswers as $index => $answer) : ?>
                                            <?php
                                            $question = $answer->briefQuestion;
                                            $typeCode = $question->typeField->title ?? '';
                                            $typeRu = $typeTranslations[$typeCode] ?? $typeCode;
                                            $badgeColor = $typeBadgeColors[$typeCode] ?? 'secondary';
                                            ?>
                                            <tr>
                                                <td class="text-center text-muted fw-semibold">
                                                    <?= $index + 1 ?>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold mb-1">
                                                        <?= Html::encode($question->question) ?>
                                                    </div>
                                                    <?php if ($question->is_required) : ?>
                                                        <span class="badge bg-danger">Обязательный</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-light text-muted">Необязательный</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $badgeColor ?>">
                                                        <?= Html::encode($typeRu) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($typeCode === 'color') : ?>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="color-dot"
                                                            style="background: <?= Html::encode($answer->answer) ?>">
                                                            </span>
                                                            <code><?= Html::encode($answer->answer) ?></code>
                                                        </div>
                                                    <?php else : ?>
                                                        <span class="text-muted">
                                                            <?= Html::encode($answer->answer) ?>
                                                        </span>
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
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
