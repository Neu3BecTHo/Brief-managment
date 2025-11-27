<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\RegisterForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="floating-card p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-light mb-3"><?= Html::encode($this->title) ?></h2>
                    <p class="text-muted">Создайте новый аккаунт для доступа к системе</p>
                </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'form-label'],
                        'inputOptions' => ['class' => 'form-control'],
                        'errorOptions' => ['class' => 'invalid-feedback'],
                    ],
                ]); ?>

                <div class="mb-3">
                    <?= $form->field($model, 'username')
                        ->textInput(['autofocus' => true, 'placeholder' => 'Введите имя пользователя']) ?>
                </div>

                <div class="mb-3">
                    <?= $form->field($model, 'email')
                        ->textInput(['type' => 'email', 'placeholder' => 'Введите email']) ?>
                </div>

                <div class="mb-3">
                    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                        'mask' => '+7 (999) 999-99-99',
                        'options' => [
                            'placeholder' => 'Введите номер телефона',
                        ],
                    ]) ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Фамилия']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'Имя']) ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <?= $form->field($model, 'patronymic')->textInput(['placeholder' => 'Отчество (необязательно)']) ?>
                </div>

                <div class="mb-3">
                    <?= $form->field($model, 'password')
                        ->passwordInput(['placeholder' => 'Введите пароль (минимум 6 символов)']) ?>
                </div>

                <div class="d-grid gap-2">
                    <?= Html::submitButton(
                        'Зарегистрироваться',
                        ['class' => 'btn btn-primary btn-lg', 'name' => 'register-button']
                    ) ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['main/login']) ?>" 
                       class="btn btn-outline-primary">
                        Уже есть аккаунт? Войдите
                    </a>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
