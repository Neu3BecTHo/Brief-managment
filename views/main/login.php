<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="floating-card p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-light mb-3"><?= Html::encode($this->title) ?></h2>
                    <p class="text-muted">Введите данные для доступа к системе</p>
                </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
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
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль']) ?>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <?= $form->field($model, 'rememberMe', ['template' => '{input}{label}'])->checkbox([
                            'class' => 'form-check-input',
                            'id' => 'rememberMe'
                        ]) ?>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button']) ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['main/register']) ?>" 
                   class="btn btn-outline-primary">
                        Нет аккаунта? Зарегистрируйтесь
                    </a>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
