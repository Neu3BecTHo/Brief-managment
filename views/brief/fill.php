<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var app\models\Briefs $brief */

$this->title = $brief->title;
$this->params['breadcrumbs'][] = ['label' => 'Доступные брифы', 'url' => ['available']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="brief-fill">
    <div class="text-center mb-4">
        <h1 class="display-6 fw-light"><?= Html::encode($this->title) ?></h1>
        <p class="text-muted"><?= Html::encode($brief->description) ?></p>
        <span class="badge bg-primary"><?= count($brief->briefQuestions) ?> вопросов</span>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card floating-card">
                <div class="card-body p-4 p-md-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'brief-fill-form',
                        'enableClientValidation' => true,
                    ]); ?>

                    <?php foreach ($brief->briefQuestions as $index => $question) : ?>
                        <?php
                        $fieldName = "answers[{$question->id}]";
                        $typeCode = $question->typeField->title;
                        $options = $question->getOptionsArray();
                        ?>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <span class="text-primary me-1"><?= $index + 1 ?>.</span>
                                <?= Html::encode($question->question) ?>
                                <?php if ($question->is_required) : ?>
                                    <span class="text-danger">*</span>
                                <?php endif; ?>
                            </label>

                            <?php if (
                            in_array(
                                $typeCode,
                                ['text', 'number', 'email', 'phone', 'date', 'color', 'textarea', 'comment'],
                                true
                            )
) : ?>
                                <?php
                                $field = $form->field($model, $fieldName)->label(false);
                                $inputOptions = [];
                                switch ($typeCode) {
                                    case 'number':
                                        $field = $form->field($model, $fieldName)
                                            ->label(false)
                                            ->input('number', [
                                                'class' => 'form-control form-control-lg',
                                                'placeholder' => 'Введите число',
                                            ]);
                                        break;

                                    case 'email':
                                        $field = $form->field($model, $fieldName)
                                            ->label(false)
                                            ->input('email', [
                                                'class' => 'form-control form-control-lg',
                                                'placeholder' => 'example@mail.com',
                                            ]);
                                        break;

                                    case 'phone':
                                        $field = $form->field($model, $fieldName)
                                            ->label(false)
                                            ->widget(MaskedInput::class, [
                                                'mask' => '+7 (999) 999-99-99',
                                                'options' => [
                                                    'class' => 'form-control form-control-lg',
                                                    'placeholder' => '+7 (___) ___-__-__',
                                                ],
                                            ]);
                                        break;

                                    case 'date':
                                        $field = $form->field($model, $fieldName)
                                            ->label(false)
                                            ->input('date', [
                                                'class' => 'form-control form-control-lg',
                                            ]);
                                        break;

                                    case 'color':
                                        $field = $form->field($model, $fieldName)
                                            ->label(false)
                                            ->input('color', [
                                                'class' => 'form-control form-control-color',
                                                'style' => 'width: 80px; height: 50px;',
                                            ]);
                                        break;

                                    case 'textarea':
                                        $field = $form->field($model, $fieldName)
                                            ->label(false)
                                            ->textarea([
                                                'class' => 'form-control form-control-lg',
                                                'rows' => 4,
                                                'placeholder' => 'Введите ваш ответ',
                                            ]);
                                        break;

                                    case 'comment':
                                        $field = $form->field($model, $fieldName)
                                            ->label(false)
                                            ->textarea([
                                                'class' => 'form-control form-control-lg',
                                                'rows' => 4,
                                                'placeholder' => 'Введите ваше пожелание',
                                            ]);
                                        break;

                                    default: // text
                                        $field = $form->field($model, $fieldName)
                                            ->label(false)
                                            ->textInput([
                                                'class' => 'form-control form-control-lg',
                                                'placeholder' => 'Введите ответ',
                                            ]);
                                }

                                echo $field;
                                ?>

                            <?php elseif ($typeCode === 'select') : ?>
                                <?= $form->field($model, $fieldName)
                                    ->dropDownList(array_combine($options, $options), ['prompt' => 'Выберите вариант', 'class' => 'form-row'])
                                    ->label(false) ?>

                            <?php elseif ($typeCode === 'radio') : ?>
                                <?= $form->field($model, $fieldName)->radioList(
                                    array_combine($options, $options),
                                    ['separator' => '<br>', 'class' => 'form-row']
                                )->label(false) ?>

                            <?php elseif ($typeCode === 'checkbox') : ?>
                                <?= $form->field($model, $fieldName)->checkboxList(
                                    array_combine($options, $options),
                                    ['separator' => '<br>', 'class' => 'form-row']
                                )->label(false) ?>

                            <?php else : ?>
                                <div class="text-muted">Неизвестный тип поля: <?= Html::encode($typeCode) ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="d-grid gap-3 mt-4">
                        <?= Html::submitButton('Отправить бриф', ['class' => 'btn btn-primary btn-lg']) ?>
                        <?= Html::a('Отмена', ['available'], ['class' => 'btn btn-outline-secondary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
