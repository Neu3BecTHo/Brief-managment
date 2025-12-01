<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

$this->title = 'Админ-панель';

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerCssFile(Yii::getAlias('@web/css/admin.css'));
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
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<div class="container-fluid h-100">
    <div class="row h-100 w-100">
        <nav id="sidebar" class="col-md-3 col-lg-2 d-none d-md-block sidebar bg-dark">
            <div class="position-sticky pt-3">
                <a href="<?= Yii::$app->urlManager->createUrl(['admin/brief/index']) ?>" 
                   class="d-flex align-items-center mb-3 text-white text-decoration-none px-3">
                    <span class="fs-4 fw-bold"><?= Html::encode(Yii::$app->name) ?></span>
                </a>
                <hr class="text-white-50">
                <?= $this->render('_sidebar_menu') ?>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">
            
            <div class="d-md-none d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h4 mb-0"><?= Html::encode($this->title) ?></h1>
                <button class="btn btn-outline-dark" type="button" 
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" 
                        aria-controls="offcanvasSidebar">
                    <svg width="24" height="24" fill="currentColor">
                        <use href="/icons/sprite.svg#menu"></use>
                    </svg>
                </button>
            </div>

            <div class="pt-3 pb-2 mb-3 border-bottom d-none d-md-flex justify-content-between align-items-center">
                <h1 class="h2"><?= Html::encode($this->title) ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                     <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
                </div>
            </div>

            <?= Alert::widget() ?>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <?= $content ?>
                </div>
            </div>

            <footer class="text-muted text-center text-small">
                <p class="mb-1">&copy; <?= date('Y') ?> <?= Html::encode(Yii::$app->name) ?> Admin</p>
            </footer>
        </main>
    </div>
</div>

<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" 
     id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasSidebarLabel"><?= Html::encode(Yii::$app->name) ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>
    <div class="offcanvas-body px-0">
        <?= $this->render('_sidebar_menu') ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
