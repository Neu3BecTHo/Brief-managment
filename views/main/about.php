<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'О проекте';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="floating-card p-5">
                <div class="text-center mb-5">
                    <h1 class="fw-light mb-4"><?= Html::encode($this->title) ?></h1>
                    <p class="lead text-muted">
                        Узнайте больше о нашей платформе и её возможностях
                    </p>
                </div>

                <div class="mb-5">
                    <h3 class="fw-semibold mb-3">О платформе</h3>
                    <p class="text-muted">
                        <?= Html::encode(Yii::$app->name) ?> — это специализированный веб-ресурс для заполнения 
                        заранее созданных брифов на разработку сайтов и их отправки на рассмотрение администрации. 
                        Наш минималистичный подход позволяет сосредоточиться на главном — эффективной работе 
                        с брифами без отвлекающих элементов.
                    </p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="feature-icon mb-3">
                            <svg class="icon text-primary" fill="currentColor">
                                <use href="/icons/sprite.svg#document"></use>
                            </svg>
                        </div>
                        <h5 class="fw-semibold mb-2">Стандартизированные брифы</h5>
                        <p class="text-muted small">
                            Заранее созданные структурированные формы для сбора всей необходимой информации
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-icon mb-3">
                            <svg class="icon text-primary" fill="currentColor">
                                <use href="/icons/sprite.svg#lightning"></use>
                            </svg>
                        </div>
                        <h5 class="fw-semibold mb-2">Быстрая обработка</h5>
                        <p class="text-muted small">
                            Оптимизированная система для быстрой обработки и рассмотрения брифов администрацией
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-icon mb-3">
                            <svg class="icon text-primary" fill="currentColor">
                                <use href="/icons/sprite.svg#users"></use>
                            </svg>
                        </div>
                        <h5 class="fw-semibold mb-2">Ролевой доступ</h5>
                        <p class="text-muted small">
                            Разграничение прав доступа между заказчиками и рассмотрением брифов
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-icon mb-3">
                            <svg class="icon text-primary" fill="currentColor">
                                <use href="/icons/sprite.svg#shield"></use>
                            </svg>
                        </div>
                        <h5 class="fw-semibold mb-2">Прозрачность процесса</h5>
                        <p class="text-muted small">
                            Полный контроль над статусом рассмотрения и принятия решений по брифам
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
