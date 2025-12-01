<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */
/** @var array $statuses */
/** @var array $typeFields */

$this->title = 'Создать бриф';
$this->params['breadcrumbs'][] = ['label' => 'Брифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="brief-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'brief' => $brief,
        'statuses' => $statuses,
        'typeFields' => $typeFields,
    ]) ?>
</div>
