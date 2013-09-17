<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
?>

<h1>Register</h1>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
    'type'=>'horizontal',
    'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnType'=>true,
		'validateOnSubmit'=>true,
    ),
)); ?>

	<p class="note">All fields are required.</p>

	<?php echo $form->textFieldRow($model,'username'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

	<?php echo $form->passwordFieldRow($model,'password',array()); ?>

    <?php echo $form->passwordFieldRow($model,'password_confirmation',array()); ?>

	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Register and login',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
