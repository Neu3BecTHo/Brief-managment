<?php

use yii\bootstrap5\Html;

?>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center gap-2 <?= Yii::$app->controller->id == 'brief' ? 'active bg-secondary' : '' ?>" 
           href="<?= Yii::$app->urlManager->createUrl(['admin/brief/index']) ?>">
            <svg width="16" height="16" fill="currentColor"><use href="<?= Yii::getAlias('@web/icons/sprite.svg#settings') ?>"></use></svg>
            Конструктор брифов
        </a>
    </li>
</ul>

<hr class="text-white-50 mt-4">

<div class="dropdown px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
       id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <strong><?= Html::encode(Yii::$app->user->identity->username ?? 'Администратор') ?></strong>
    </a>
    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
        <li><a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['main/index']) ?>">На сайт</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <?= Html::beginForm(['/main/logout'], 'post')
                . Html::submitButton('Выход', ['class' => 'dropdown-item'])
                . Html::endForm() ?>
        </li>
    </ul>
</div>
