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
                <?php if (Yii::$app->user->isGuest): ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['main/register']) ?>" class="btn btn-primary btn-lg">
                        Создать бриф
                    </a>
                    <a href="<?= Yii::$app->urlManager->createUrl(['main/login']) ?>" class="btn btn-outline-primary btn-lg">
                        Войти
                    </a>
                <?php else: ?>
                    <a href="#" class="btn btn-primary btn-lg">
                        Новый бриф
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-lg">
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
                        <svg class="icon text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 100 4h2a2 2 0 100-4h-.5a1 1 0 000-2H8a2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"/>
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
                        <svg class="icon text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
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
                        <svg class="icon text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
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
