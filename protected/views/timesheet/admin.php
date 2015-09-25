<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */

$this->breadcrumbs = ViewHelper::breadcrumbs($this->action, $model);

$this->menu = ViewHelper::crudMenu($this->action, $model);

Yii::app()->clientScript->registerScript(
        "myHideEffect", "$('.alert.alert-success.alert-dismissable.pull-right').animate({opacity: 1.0}, 3000).fadeOut('fast');", CClientScript::POS_READY
);
Yii::import('application.modules.editgrid.*');

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#timesheet-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h4><?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable pull-right">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?></h4>

<br>
<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="#" class="pull-right">Vedi per settimana</a>
            <h4><i class="fa fa-user fa-2x"></i> <?php echo Yii::app()->user->getState('profile')->cn; ?></h4>
        </div>
        <div class="panel-heading">
            <a href="#" class="pull-left"><i class="fa fa-chevron-left"></i>&nbsp;sett. precedente</a>
            <a href="#" class="pull-right">sett. seguente&nbsp;<i class="fa fa-chevron-right"></i></a>
            <h4 align="center"><?php echo $this->oggimesse; ?>&nbsp;<?php echo '(Settimana ' . date('W') . ')'; ?></h4>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="<?php echo (date("l") == "Monday") ? "active" : ""; ?>">
                    <a href="#A" data-toggle="tab" align="center">
                        <div><small><?php echo $this->lunediOggi; ?>
                            </small><i class="fa fa-clock-o <?php echo $model->getHours('monday this week')<8?'label label-danger':'label label-success';?>">&nbsp;<?php echo $model->getHours('monday this week'); ?></i></div>Lunedì</a></li>
                <li class="<?php echo (date("l") == "Tuesday") ? "active" : ""; ?>">
                    <a href="#B" data-toggle="tab" align="center">
                        <div><small><?php echo $this->martediOggi; ?>
                            </small><i class="fa fa-clock-o <?php echo $model->getHours('tuesday this week')<8?'label label-danger':'label label-success';?>">&nbsp;<?php echo $model->getHours('tuesday this week'); ?></i></div>Martedì</a></li>
                <li class="<?php echo (date("l") == "Wednesday") ? "active" : ""; ?>">
                    <a href="#C" data-toggle="tab" align="center">
                        <div><small><?php echo $this->mercolediOggi; ?>
                            </small><i class="fa fa-clock-o <?php echo $model->getHours('wednesday this week')<8?'label label-danger':'label label-success';?>">&nbsp;<?php echo $model->getHours('wednesday this week'); ?></i></div>Mercoledì</a></li>
                <li class="<?php echo (date("l") == "Thursday") ? "active" : ""; ?>">
                    <a href="#D" data-toggle="tab" align="center">
                        <div><small><?php echo $this->giovediOggi; ?>
                            </small><i class="fa fa-clock-o <?php echo $model->getHours('thursday this week')<8?'label label-danger':'label label-success';?>">&nbsp;<?php echo $model->getHours('thursday this week'); ?></i></div>Giovedì</a></li>
                <li class="<?php echo (date("l") == "Friday") ? "active" : ""; ?>">
                    <a href="#E" data-toggle="tab" align="center">
                        <div><small><?php echo $this->venerdiOggi; ?>
                            </small><i class="fa fa-clock-o <?php echo $model->getHours('friday this week')<8?'label label-danger':'label label-success';?>">&nbsp;<?php echo $model->getHours('friday this week'); ?></i></div>Venerdì</a></li>
                <li class="<?php echo (date("l") == "Saturday") ? "active" : ""; ?>">
                    <a href="#F" data-toggle="tab" align="center">
                        <div><small><?php echo $this->sabatoOggi; ?>
                            </small><i class="fa fa-clock-o <?php echo $model->getHours('saturday this week')>0?'label label-info':'';?>">&nbsp;<?php echo $model->getHours('saturday this week'); ?></i></div>Sabato</a></li>
                <li class="<?php echo (date("l") == "Sunday") ? "active" : ""; ?>">
                    <a href="#G" data-toggle="tab" align="center">
                        <div><small><?php echo $this->domenicaOggi; ?>
                            </small><i class="fa fa-clock-o <?php echo $model->getHours('sunday this week')>0?'label label-info':'';?>">&nbsp;<?php echo $model->getHours('sunday this week'); ?></i></div>Domenica</a></li>
            </ul>
            <div class="tabbable">
                <div class="tab-content">
                    <div class="tab-pane <?php echo (date("l") == "Monday") ? "active" : ""; ?>" id="A">
                        <div class="panel-body" align="center">
                            <form name="editableGridFormCa" method="post" action="create">
                                <?php $this->renderPartial('_form', array('model' => $model,'datashort'=>$this->lunedisem)) ?>
                            </form>
                            <form name="editableGridFormA" method="post" action="editableGrid">
                                <?php $this->renderPartial('lunedi', array('model' => $model)) ?>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo (date("l") == "Tuesday") ? "active" : ""; ?>" id="B">
                        <div class="panel-body" align="center">
                            <form name="editableGridFormCb" method="post" action="create">
                                <?php $this->renderPartial('_form', array('model' => $model,'datashort'=>$this->martedisem)) ?>
                            </form>
                            <form name="editableGridFormB" method="post" action="editableGrid">
                                <?php $this->renderPartial('martedi', array('model' => $model)) ?>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo (date("l") == "Wednesday") ? "active" : ""; ?>" id="C">
                        <div class="panel-body" align="center">
                            <form name="editableGridFormCc" method="post" action="create">
                                <?php $this->renderPartial('_form', array('model' => $model,'datashort'=>$this->mercoledisem)) ?>
                            </form>
                            <form name="editableGridFormC" method="post" action="editableGrid">
                                <?php $this->renderPartial('mercoledi', array('model' => $model)) ?>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo (date("l") == "Thursday") ? "active" : ""; ?>" id="D">
                        <div class="panel-body" align="center">
                            <form name="editableGridFormCd" method="post" action="create">
                                <?php $this->renderPartial('_form', array('model' => $model,'datashort'=>$this->giovedisem)) ?>
                            </form>
                                <form name="editableGridFormD" method="post" action="editableGrid">
                                <?php $this->renderPartial('giovedi', array('model' => $model)) ?>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo (date("l") == "Friday") ? "active" : ""; ?>" id="E">
                        <div class="panel-body" align="center">
                            <form name="editableGridFormCe" method="post" action="create">
                                <?php $this->renderPartial('_form', array('model' => $model,'datashort'=>$this->venerdisem)) ?>
                            </form>
                            <form name="editableGridFormE" method="post" action="editableGrid" class="editableGrid">
                                <?php $this->renderPartial('venerdi', array('model' => $model)) ?>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo (date("l") == "Saturday") ? "active" : ""; ?>" id="F">
                        <div class="panel-body" align="center">
                            <form name="editableGridFormCf" method="post" action="create">
                                <?php $this->renderPartial('_form', array('model' => $model,'datashort'=>$this->sabatosem)) ?>
                            </form>
                            <form name="editableGridFormF" method="post" action="editableGrid" class="editableGrid">
                                <?php $this->renderPartial('sabato', array('model' => $model)) ?>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo (date("l") == "Sunday") ? "active" : ""; ?>" id="G">
                        <div class="panel-body" align="center">
                            <form name="editableGridFormCg" method="post" action="create">
                                <?php $this->renderPartial('_form', array('model' => $model,'datashort'=>$this->domenicasem)) ?>
                            </form>
                            <form name="editableGridFormG" method="post" action="editableGrid" class="editableGrid">
                                <?php $this->renderPartial('domenica', array('model' => $model)) ?>
                            </form>
                        </div>
                    </div>
                </div><!-- /tab-content-->
            </div>
        </div> <!-- /main-panel-body-->
    </div> <!-- /tabbable -->
</div><!--/main-container-12-columns-bootstrap-->



