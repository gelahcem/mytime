<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */

$this->breadcrumbs=ViewHelper::breadcrumbs($this->action, $model);

$this->menu=ViewHelper::crudMenu($this->action, $model);
?>

<h1><?php echo ViewHelper::title($this->action, $model); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>