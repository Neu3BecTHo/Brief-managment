<?php

use yii\helpers\Html;
use app\models\BriefAnswers;

/** @var app\models\Briefs $brief */

$questionIds = array_column($brief->briefQuestions, 'id');

$answers = [];
if (!empty($questionIds)) {
    $answers = BriefAnswers::find()
        ->where(['user_id' => $targetUser->id])
        ->andWhere(['in', 'brief_question_id', $questionIds])
        ->indexBy('brief_question_id')
        ->all();
}

?>
<style>
    body { font-family: 'DejaVuSans', sans-serif; font-size: 12pt; color: #333; }
    h1 { font-size: 24pt; color: #000; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
    h3 { font-size: 16pt; margin-top: 30px; margin-bottom: 10px; color: #444; }
    .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .meta-table td { padding: 8px; border-bottom: 1px solid #ddd; }
    .meta-label { font-weight: bold; width: 30%; color: #555; }
    .meta-value { width: 70%; }
    
    .qa-block { margin-bottom: 15px; page-break-inside: avoid; }
    .question { font-weight: bold; font-size: 14pt; background-color: #f0f0f0; padding: 10px; border-left: 5px solid #007bff; }
    .answer { padding: 10px; border: 1px solid #ddd; border-top: none; background-color: #fff; }
    .no-answer { font-style: italic; color: #999; padding: 10px; border: 1px solid #eee; border-top: none; }
    .footer { font-size: 9pt; color: #777; border-top: 1px solid #ccc; margin-top: 50px; padding-top: 10px; text-align: center; }
</style>

<h1>Бриф: <?= Html::encode($brief->title) ?></h1>

<table class="meta-table">
    <tr>
        <td class="meta-label">Автор ответов:</td>
        <td class="meta-value">
            <?= Html::encode($targetUser->username) ?> (<?= Html::encode($targetUser->email) ?>)
        </td>
    </tr>
    <tr>
        <td class="meta-label">Статус:</td>
        <td class="meta-value"><?= Html::encode($brief->status->title ?? 'Не определен') ?></td>
    </tr>
    <tr>
        <td class="meta-label">Дата создания:</td>
        <td class="meta-value"><?= Yii::$app->formatter->asDatetime($brief->created_at, 'php:d.m.Y H:i') ?></td>
    </tr>
    <tr>
        <td class="meta-label">Описание:</td>
        <td class="meta-value"><?= nl2br(Html::encode($brief->description)) ?></td>
    </tr>
</table>

<h3>Ответы на вопросы</h3>

<?php if (empty($brief->briefQuestions)) : ?>
    <p>В этом брифе пока нет вопросов.</p>
<?php else : ?>
    <?php foreach ($brief->briefQuestions as $index => $question) : ?>
        <div class="qa-block">
            <div class="question">
                <?= ($index + 1) ?>. <?= Html::encode($question->question) ?>
            </div>
            
            <?php if (isset($answers[$question->id])) : ?>
                <div class="answer">
                    <?= nl2br(Html::encode($answers[$question->id]->answer)) ?>
                </div>
            <?php else : ?>
                <div class="no-answer">
                    Нет ответа
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

<div class="footer">
    Сгенерировано автоматически системой управления брифами. <br>
    <?= date('d.m.Y H:i') ?>
</div>