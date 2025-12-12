<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $briefs app\models\Briefs[] */

$this->title = 'Мои заполненные брифы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brief-completed container py-4">

    <div class="text-center mb-5">
        <h1 class="display-6 fw-bold text-gray-800"><?= Html::encode($this->title) ?></h1>
        <p class="text-muted lead">История ваших ответов и проектов</p>
    </div>

    <?php if (empty($briefs)) : ?>
        <div class="alert alert-info text-center shadow-sm border-0" role="alert">
            <div class="mb-3">
                <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
            </div>
            <h4 class="alert-heading">Список пуст</h4>
            <p>Вы еще не заполнили ни одного брифа.</p>
            <hr>
            <p class="mb-0">
                <?= Html::a('Перейти к доступным брифам', ['available'], ['class' => 'btn btn-primary']) ?>
            </p>
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
                                <?= Html::a('Посмотреть ответы', ['view', 'id' => $brief->id], [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>