<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerCssFile(Yii::getAlias('@web/css/icons.css'));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::tag('object', '', [
        'type' => 'image/svg+xml',
        'data' => Yii::getAlias('@web/icons/sprite.svg'),
        'style' => 'display: none;'
    ]) ?>
</head>
<body>
<?php $this->beginBody() ?>

<header id="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                <?= Html::encode(Yii::$app->name) ?>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Смена навигации">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1" 
                           href="<?= Yii::$app->urlManager->createUrl(['main/index']) ?>">
                            <svg width="16" height="16" fill="currentColor">
                                <use href="<?= Yii::getAlias('@web/icons/sprite.svg#home') ?>"></use>
                            </svg>
                            Главная
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1" 
                           href="<?= Yii::$app->urlManager->createUrl(['main/about']) ?>">
                            <svg width="16" height="16" fill="currentColor">
                                <use href="<?= Yii::getAlias('@web/icons/sprite.svg#info') ?>"></use>
                            </svg>
                            О проекте
                        </a>
                    </li>
                    
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <!-- Меню брифов (только для авторизованных) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" 
                               href="#" id="briefesDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="16" height="16" fill="currentColor">
                                    <use href="<?= Yii::getAlias('@web/icons/sprite.svg#brief') ?>"></use>
                                </svg>
                                Брифы
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="briefesDropdown">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" 
                                       href="<?= Yii::$app->urlManager->createUrl(['brief/available']) ?>">
                                        <svg width="14" height="14" fill="currentColor">
                                            <use href="<?= Yii::getAlias('@web/icons/sprite.svg#brief') ?>"></use>
                                        </svg>
                                        Доступные брифы
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" 
                                       href="<?= Yii::$app->urlManager->createUrl(['brief/completed']) ?>">
                                        <svg width="14" height="14" fill="currentColor">
                                            <use href="<?= Yii::getAlias('@web/icons/sprite.svg#file-text') ?>"></use>
                                        </svg>
                                        Мои заполненные брифы
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (Yii::$app->user->isGuest) : ?>
                        <!-- Меню для гостей -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['main/login']) ?>">
                                Вход
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['main/register']) ?>">
                                Регистрация
                            </a>
                        </li>
                    <?php else : ?>
                        <!-- Меню пользователя (только для авторизованных) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" 
                               href="#" id="navbarDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="16" height="16" fill="currentColor">
                                    <use href="<?= Yii::getAlias('@web/icons/sprite.svg#user') ?>"></use>
                                </svg>
                                <?= Html::encode(Yii::$app->user->identity->username) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php if (Yii::$app->user->can('admin')) : ?>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2" 
                                        href="<?= Yii::$app->urlManager->createUrl(['admin/brief/index']) ?>">
                                            <svg width="14" height="14" fill="currentColor">
                                                <use href="<?= Yii::getAlias('@web/icons/sprite.svg#settings') ?>"></use>
                                            </svg>
                                            Админ-панель
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <?= Html::beginForm(['/main/logout'], 'post', ['class' => 'dropdown-item'])
                                        . Html::submitButton('Выход', [
                                            'class' =>
                                                    'btn btn-link text-decoration-none w-100
                                                    text-start dropdown-item'
                                        ])
                                        . Html::endForm() ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])) : ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
