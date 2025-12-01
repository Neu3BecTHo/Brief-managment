<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Briefs[] $briefs */

$this->title = 'Доступные брифы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="brief-available">
    <div class="text-center mb-5">
        <h1 class="display-6 fw-light"><?= Html::encode($this->title) ?></h1>
        <p class="text-muted">Выберите бриф для заполнения</p>
    </div>

    <?php if (empty($briefs)) : ?>
        <div class="alert alert-info text-center">
            <svg width="48" height="48" fill="currentColor" class="mb-3">
                <use href="/icons/sprite.svg#info"></use>
            </svg>
            <h5>Нет доступных брифов</h5>
            <p class="mb-0">В данный момент нет активных брифов для заполнения. Попробуйте позже.</p>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach ($briefs as $brief) : ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card floating-card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-start mb-3">
                                <div class="feature-icon me-3">
                                    <svg width="32" height="32" fill="currentColor">
                                        <use href="/icons/sprite.svg#brief"></use>
                                    </svg>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-2"><?= Html::encode($brief->title) ?></h5>
                                    <span class="badge bg-primary"><?= count($brief->briefQuestions) ?> вопросов</span>
                                </div>
                            </div>
                            
                            <p class="card-text text-muted flex-grow-1">
                                <?= Html::encode($brief->description) ?>
                            </p>
                            
                            <div class="mt-3">
                                <small class="text-muted d-block mb-2">
                                    <svg width="14" height="14" fill="currentColor" class="me-1">
                                        <use href="/icons/sprite.svg#user"></use>
                                    </svg>
                                    Автор: <?= Html::encode($brief->user->username) ?>
                                </small>
                            </div>
                            
                            <div class="d-grid mt-auto">
                                <?= Html::a(
                                    'Заполнить бриф',
                                    ['fill', 'id' => $brief->id],
                                    ['class' => 'btn btn-primary']
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
