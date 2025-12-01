<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Главная';
?>
<div class="site-index">

    <div class="hero-section text-center py-5 mb-5">
        <div class="floating-card max-w-2xl mx-auto fade-in">
            <h1 class="display-4 fw-light mb-4">
                Добро пожаловать в <span class="text-primary"><?= Html::encode(Yii::$app->name) ?></span>
            </h1>
            <p class="lead text-muted mb-4">
                Современная платформа для создания и управления брифами на разработку веб-ресурсов
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <?php if (Yii::$app->user->isGuest) : ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['main/login']) ?>" 
                       class="btn btn-outline-primary btn-lg">
                        Войти
                    </a>
                <?php else : ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['brief/available']) ?>" 
                       class="btn btn-outline-primary btn-lg">
                        Мои брифы
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="features-section py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="floating-card h-100 text-center">
                    <div class="feature-icon mb-3">
                        <svg class="icon text-primary" fill="currentColor">
                            <use href="<?= Yii::getAlias('@web/icons/sprite.svg#document') ?>"></use>
                        </svg>
                    </div>
                    <h5 class="fw-semibold mb-3">Простые формы</h5>
                    <p class="text-muted">
                        Удобные и интуитивные формы для заполнения брифа с пошаговыми инструкциями
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="floating-card h-100 text-center">
                    <div class="feature-icon mb-3">
                        <svg class="icon text-primary" fill="currentColor">
                            <use href="<?= Yii::getAlias('@web/icons/sprite.svg#lightning') ?>"></use>
                        </svg>
                    </div>
                    <h5 class="fw-semibold mb-3">Быстрая обработка</h5>
                    <p class="text-muted">
                        Оптимизированная система для быстрой обработки и рассмотрения ваших заявок
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="floating-card h-100 text-center">
                    <div class="feature-icon mb-3">
                        <svg class="icon text-primary" fill="currentColor">
                            <use href="<?= Yii::getAlias('@web/icons/sprite.svg#users') ?>"></use>
                        </svg>
                    </div>
                    <h5 class="fw-semibold mb-3">Командная работа</h5>
                    <p class="text-muted">
                        Эффективное взаимодействие между заказчиками и исполнителями
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-section py-5 mt-5">
        <div class="floating-card">
            <div class="row text-center">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h2 class="display-6 fw-bold text-primary mb-2">50+</h2>
                    <p class="text-muted">Обработанных брифов</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h2 class="display-6 fw-bold text-primary mb-2">30+</h2>
                    <p class="text-muted">Активных проектов</p>
                </div>
                <div class="col-md-4">
                    <h2 class="display-6 fw-bold text-primary mb-2">24/7</h2>
                    <p class="text-muted">Поддержка</p>
                </div>
            </div>
        </div>
    </div>

</div>
