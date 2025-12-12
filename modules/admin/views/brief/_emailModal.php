<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var string $modalId */
/** @var array|string $action */

$modalId = $modalId ?? 'customEmailModal';
$formId  = $formId  ?? $modalId . '-form';

$this->registerJs("
    $('.js-open-modal').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('action-url');
        $('#{$formId}').attr('action', url);
        $('#{$modalId}').addClass('active');
    });
    $('.js-close-modal').on('click', function() {
        $('#{$modalId}').removeClass('active');
    });
    $('#{$modalId}').on('click', function(e) {
        if (e.target === this) $(this).removeClass('active');
    });
");

?>

<div id="<?= Html::encode($modalId) ?>" class="custom-modal-overlay">
    <div class="custom-modal-window">
        <button type="button" class="custom-modal-close js-close-modal">&times;</button>
        <h4 class="mb-3">Отправить отчет</h4>

        <?php $form = ActiveForm::begin([
            'id' => $formId,
            'method' => 'post',
            'action' => $action ?? '',
        ]); ?>

            <div class="form-group mb-3">
                <?= Html::input('email', 'email', '', [
                    'class' => 'form-control',
                    'placeholder' => 'email@example.com',
                    'required' => true,
                ]) ?>
            </div>

            <div class="text-end mt-4 d-flex justify-content-center">
                <button type="button" class="btn btn-outline-secondary me-2 js-close-modal">
                    <svg width="14" height="14" fill="currentColor">
                        <use href="<?= Yii::getAlias('@web/icons/sprite.svg#home') ?>"></use>
                    </svg>
                    <span class="ms-1">Отмена</span>
                </button>

                <?= Html::submitButton(
                    '<svg width="14" height="14" fill="currentColor">
                        <use href="' . Yii::getAlias('@web/icons/sprite.svg#send') . '"></use>
                      </svg>
                      <span class="ms-1">Отправить</span>',
                    ['class' => 'btn btn-outline-primary']
                ) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
