
<div>
    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'users-form', 'enableAjaxValidation' => false)); ?>
    <?= CHtml::submitButton($user == NULL ? Yii::t('app', 'Поставить в бинар') : Yii::t('app', 'Поставить в бинар'), array('name' => 'btn_add_binar', 'class' => 'btn200')); ?>
    |<?php $this->endWidget(); ?>
</div>