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
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header id="header">
    <nav class="navbar navbar-expand-lg ">
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
                        <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['main/index']) ?>">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['main/about']) ?>">О проекте</a>
                    </li>
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="briefesDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Брифы
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="briefesDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['brief/available']) ?>">
                                        Доступные брифы
                                    </a>
                                </li>
                            .</ul>
                        </li>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->isGuest) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['main/login']) ?>">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['main/register']) ?>">
                                Регистрация
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= Html::encode(Yii::$app->user->identity->username) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <?= Html::beginForm(['/main/logout'], 'post', ['class' => 'dropdown-item'])
                                        . Html::submitButton('Выход', [
                                            'class' => 'btn btn-link text-decoration-none w-100 text-start dropdown-item'
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

<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="text-white mb-3"><?= Html::encode(Yii::$app->name) ?></h5>
                <p>
                    Современная платформа для управления проектами с минималистичным дизайном и удобным интерфейсом.
                </p>
            </div>
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="text-white mb-3">Навигация</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= Yii::$app->urlManager->createUrl(['main/index']) ?>" class="text-decoration-none">
                            Главная
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= Yii::$app->urlManager->createUrl(['main/about']) ?>" class="text-decoration-none">
                            О проекте
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5 class="text-white mb-3">Информация</h5>
                <p class="mb-2">
                    © <?= date('Y') ?> <?= Html::encode(Yii::$app->name) ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
