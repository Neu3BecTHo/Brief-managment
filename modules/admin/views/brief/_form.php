<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Json;
use app\models\TypeFields;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var array $statuses */
/** @var array $typeFields */

$typeFieldsCodes = TypeFields::find()->select(['title', 'id'])->indexBy('id')->column();
$typeFieldsTranslated = TypeFields::getTypesDropdown();

// Подготовка данных для JS
$existingQuestions = [];
if (!$brief->isNewRecord) {
    foreach ($brief->briefQuestions as $q) {
        $existingQuestions[] = [
            'question' => $q->question ?? '',
            'type_field_id' => $q->type_field_id ?? 1,
            'is_required' => $q->is_required ?? false,
            'options' => $q->options ? implode(', ', $q->getOptionsArray()) : '',
        ];
    }
}

// Передаём данные в JS через window
$this->registerJs("
    window.briefFormData = {
        typeFields: " . Json::encode($typeFieldsTranslated) . ", // Для отображения
        typeFieldsCodes: " . Json::encode($typeFieldsCodes) . ", // Для логики
        existingQuestions: " . Json::encode($existingQuestions) . "
    };
", \yii\web\View::POS_HEAD);

$this->registerJsFile(
    '@web/js/briefForm.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>

<div class="brief-form">
    <?php $form = ActiveForm::begin(['id' => 'brief-form']); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Основная информация</h5>
                </div>
                <div class="card-body">
                    <?= $form->field($brief, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($brief, 'description')->textarea(['rows' => 3]) ?>
                    <?= $form->field($brief, 'status_id')->dropDownList($statuses, ['prompt' => 'Выберите статус']) ?>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Вопросы брифа</h5>
                </div>
                <div class="card-body">
                    <div id="questions-container"></div>
                    <p class="text-muted" id="no-questions-msg">
                        Нажмите "Добавить вопрос" для создания первого вопроса
                    </p>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-lg']) ?>
                <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-outline-secondary btn-lg']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<!-- Плавающая кнопка добавления вопроса -->
<button type="button" class="btn btn-success btn-floating" id="add-question-btn" title="Добавить вопрос">
    <svg width="24" height="24" fill="currentColor">
        <use href="<?= Yii::getAlias('@web/icons/sprite.svg#document') ?>"></use>
    </svg>
    <span class="btn-floating-text">+</span>
</button>