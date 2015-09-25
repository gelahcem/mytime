<?php
/* @var $this TimesheetController */
/* @var $dataProvider CActiveDataProvider */
/* @var $model Timesheet */

$this->breadcrumbs=ViewHelper::breadcrumbs($this->action, $model);

$this->menu=ViewHelper::crudMenu($this->action, $model);
?>

<h1><?php echo ViewHelper::title($this->action, $model); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
