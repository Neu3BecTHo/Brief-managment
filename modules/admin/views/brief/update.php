<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */
/** @var array $statuses */
/** @var array $typeFields */

$this->title = "Редактировать: {$brief->title}";
$this->params['breadcrumbs'][] = ['label' => 'Брифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $brief->title, 'url' => ['view', 'id' => $brief->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="brief-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'brief' => $brief,
        'statuses' => $statuses,
        'typeFields' => $typeFields,
    ]) ?>
</div>
