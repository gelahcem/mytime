<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'timesheet-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    /* @var $form CActiveForm */
    ?>

    <p class="note"><?php //echo Yii::t('model', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php //echo $form->labelEx($model,'ANNO'); ?>
        <?php //echo $form->textField($model,'ANNO'); ?>
<?php // $form->error($model,'ANNO');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'MESE'); ?>
        <?php //echo $form->textField($model,'MESE'); ?>
<?php //echo $form->error($model,'MESE');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'SETTIMANA'); ?>
        <?php //echo $form->textField($model,'SETTIMANA'); ?>
<?php //echo $form->error($model,'SETTIMANA');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'IDENTIFICATIVO'); ?>
        <?php //echo $form->textField($model,'IDENTIFICATIVO',array('size'=>15,'maxlength'=>15)); ?>
<?php //echo $form->error($model,'IDENTIFICATIVO');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'DATA'); ?>
        <?php //echo $form->textField($model,'DATA',array('size'=>16,'maxlength'=>16)); ?>
<?php //echo $form->error($model,'DATA');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'DATASHORT'); ?>
        <?php //echo $form->textField($model,'DATASHORT'); ?>
<?php //echo $form->error($model,'DATASHORT');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'RISORSA'); ?>
        <?php //echo $form->textField($model,'RISORSA',array('size'=>50,'maxlength'=>50)); ?>
<?php //echo $form->error($model,'RISORSA');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'IDCOMMESSA'); ?>
        <?php echo $form->hiddenField($model,'DATASHORT',array('value'=>$datashort,'size'=>16,'maxlength'=>16)); ?>
        <?php
        echo $form->dropDownList($model, 'IDCOMMESSA', CHtml::listData(Commesse::model()->findAll(), 'IDENTIFICATIVO', 'DESCRIZIONE'), 
                array('empty' => 'selezziona commessa', 'style' => 'width:200px; height:26px')
        );
        ?>
        <?php echo $form->textField($model, 'DESCRIZIONE', array('size' => 70, 'maxlength' => 2048, 'placeholder' => 'descrizione',)); ?>
        <?php echo $form->textField($model, 'ORE', array('size' => 6, 'maxlength' => 6, 'placeholder' => 'ore',)); ?>
        <?php echo CHtml::submitButton(Yii::t('model', '+'), array('class' => 'btn btn-primary')); ?>
<?php //echo $form->error($model,'IDCOMMESSA');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'DESCRIZIONE'); ?>
        <?php //echo $form->textField($model,'DESCRIZIONE',array('size'=>60,'maxlength'=>2048)); ?>
<?php //echo $form->error($model,'DESCRIZIONE');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'ORE'); ?>
        <?php //echo $form->textField($model,'ORE',array('size'=>6,'maxlength'=>6)); ?>
<?php //echo $form->error($model,'ORE');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'KM'); ?>
        <?php //echo $form->textField($model,'KM',array('size'=>4,'maxlength'=>4)); ?>
<?php //echo $form->error($model,'KM');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'AUTO'); ?>
        <?php //echo $form->textField($model,'AUTO',array('size'=>10,'maxlength'=>10)); ?>
<?php //echo $form->error($model,'AUTO');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'PASTO'); ?>
        <?php //echo $form->textField($model,'PASTO',array('size'=>10,'maxlength'=>10)); ?>
<?php //echo $form->error($model,'PASTO');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'BLOCCO'); ?>
        <?php //echo $form->textField($model,'BLOCCO'); ?>
<?php //echo $form->error($model,'BLOCCO');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'INSERITO'); ?>
        <?php //echo $form->textField($model,'INSERITO'); ?>
<?php //echo $form->error($model,'INSERITO');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'MODIFICATO'); ?>
        <?php //echo $form->textField($model,'MODIFICATO'); ?>
<?php //echo $form->error($model,'MODIFICATO');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'MODIFICATODA'); ?>
        <?php //echo $form->textField($model,'MODIFICATODA',array('size'=>15,'maxlength'=>15)); ?>
<?php //echo $form->error($model,'MODIFICATODA');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'IDPREVENTIVO'); ?>
        <?php //echo $form->textField($model,'IDPREVENTIVO',array('size'=>15,'maxlength'=>15)); ?>
<?php //echo $form->error($model,'IDPREVENTIVO');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'SUPERCOMMESSA'); ?>
        <?php //echo $form->textField($model,'SUPERCOMMESSA',array('size'=>50,'maxlength'=>50)); ?>
<?php //echo $form->error($model,'SUPERCOMMESSA');  ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'STRAORDINARIO'); ?>
        <?php //echo $form->textField($model,'STRAORDINARIO'); ?>
<?php //echo $form->error($model,'STRAORDINARIO');  ?>
    </div>

    <div class="row buttons">
<?php //echo CHtml::submitButton(Yii::t('model','Confirm'));  ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
