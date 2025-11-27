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
                            <svg class="icon text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 100 4h2a2 2 0 100-4h-.5a1 1 0 000-2H8a2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h5 class="fw-semibold mb-2">Стандартизированные брифы</h5>
                        <p class="text-muted small">
                            Заранее созданные структурированные формы для сбора всей необходимой информации
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-icon mb-3">
                            <svg class="icon text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h5 class="fw-semibold mb-2">Быстрая обработка</h5>
                        <p class="text-muted small">
                            Оптимизированная система для быстрой обработки и рассмотрения брифов администрацией
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-icon mb-3">
                            <svg class="icon text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                            </svg>
                        </div>
                        <h5 class="fw-semibold mb-2">Ролевой доступ</h5>
                        <p class="text-muted small">
                            Разграничение прав доступа между заказчиками и рассмотрением брифов
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-icon mb-3">
                            <svg class="icon text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
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
