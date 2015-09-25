<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */

$this->breadcrumbs=ViewHelper::breadcrumbs($this->action, $model);

$this->menu=ViewHelper::crudMenu($this->action, $model);
?>

<h1><?php echo ViewHelper::title($this->action, $model); ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ID',
		'ANNO',
		'MESE',
		'SETTIMANA',
		'IDENTIFICATIVO',
		'DATA',
		'DATASHORT',
		'RISORSA',
		'IDCOMMESSA',
		'ORE',
		'KM',
		'AUTO',
		'PASTO',
		'DESCRIZIONE',
		'BLOCCO',
		'INSERITO',
		'MODIFICATO',
		'MODIFICATODA',
		'IDPREVENTIVO',
		'SUPERCOMMESSA',
		'STRAORDINARIO',
	),
)); ?>
