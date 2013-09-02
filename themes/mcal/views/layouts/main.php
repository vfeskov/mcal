<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/lib/moment.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/lib/underscore.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/lib/backbone.js"></script>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/models/day.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/collections/days.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/views/calendar.js"></script>

    <script type="text/template" id="calendar"><?php include(Yii::app()->theme->basePath.'/js/templates/calendar.html')?></script>
    <script type="text/template" id="calendar_day"><?php include(Yii::app()->theme->basePath.'/js/templates/calendar/day.html')?></script>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/app.js"></script>
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        ),
    ),
)); ?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Vladimir Feskov.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
