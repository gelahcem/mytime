<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */

$martedi = new CActiveDataProvider('Timesheet', array(
   'criteria'=>array(
          'select'=>'DATASHORT,IDCOMMESSA, DESCRIZIONE, ORE',
          'condition'=> 'DATASHORT= :id',
          'params'=> array(':id'=>date('Y-m-d', strtotime('tuesday this week')))
       )
));

$this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'timesheet-grid-b',
                                    'summaryText' => '',
                                    'dataProvider' => $martedi,
                                    'columns' => array(
                                        array(
                                            'header' => 'Commessa',
                                            'name' => 'IDCOMMESSA',
                                            'type' => 'raw',
                                            'value' => '$data->getInputField(\'IDCOMMESSA\',$row)',
                                            'headerHtmlOptions' => array('style' => 'width: 70px;'),
                                        ),
                                        array(
                                            'header' => 'Descrizione',
                                            'name' => 'DESCRIZIONE',
                                            'type' => 'raw',
                                            'value' => '$data->getInputField(\'DESCRIZIONE\',$row)',
                                            'headerHtmlOptions' => array('size' => '400px;'),
                                        ),
                                        array(
                                            'header' => 'Ore',
                                            'name' => 'ORE',
                                            'type' => 'raw',
                                            'value' => '$data->getInputField(\'ORE\',$row)',
                                            'headerHtmlOptions' => array('style' => 'width: 50px;'),
                                        ),
                                        array(
                                            'class' => 'CButtonColumn',
                                            'template' => '{delete}',
                                            'headerHtmlOptions' => array('style' => 'padding: 0 10px;'),
                                            'buttons' => array(
                                                'delete' => array(
                                                    'label'=>'<i class="fa fa-trash fa-2x"></i>',
                                                    'url' => '$this->grid->controller->createUrl("delete", array("ID"=>$data->ID))',
                                                    'imageUrl' => false,
                                                ),
                                            ),
                                        ),
                                )));
                                    echo CHtml::submitButton('salva', array('class' => 'btn btn-primary'));

