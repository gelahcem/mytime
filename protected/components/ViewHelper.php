<?php

/**
 * Helper class for views
 *
 * @author Marco Careddu
 * @version 1.2
 * removed list links and other projects links
 * added datetimePickerDefaultOptionsRaw
 */
class ViewHelper {
    
    /**
     * Generates the crud Menu for specified action and model.
     * @param CAction $action
     * @param CModel $model
     * @return array
     */
    public static function crudMenu(&$action, &$model) {
        $a = array();
        
        $modelName = array('{model}'=>$model->modelName);
        $modelPluralName = array('{model}'=>$model->modelPluralName);
        
        switch($action->id) {
            case 'admin':
                $a = array(
                    array('label'=>Yii::t('model', 'Create {model}', $modelName), 'url'=>array('create')),
                );
                break;
            case 'view':
                $a = array(
                    array('label'=>Yii::t('model', 'Create {model}', $modelName), 'url'=>array('create')),
                    array('label'=>Yii::t('model', 'Update {model}', $modelName), 'url'=>array('update', 'id'=>$model->id)),
                    array('label'=>Yii::t('model', 'Delete {model}', $modelName), 'url'=>'#',
                        'linkOptions'=>array(
                            'submit'=>array('delete','id'=>$model->id),
                            'confirm'=>Yii::t('model','Are you sure you want to delete this item?')
                        )),
                    array('label'=>Yii::t('model', 'Manage {model}', $modelPluralName), 'url'=>array('admin')),
                );
                break;
            case 'create':
                $a = array(
                    array('label'=>Yii::t('model', 'Manage {model}', $modelPluralName), 'url'=>array('admin')),
                );
                break;
            case 'update':
                $a = array(
                    array('label'=>Yii::t('model', 'Create {model}', $modelName), 'url'=>array('create')),
                    array('label'=>Yii::t('model', 'View {model}', $modelName), 'url'=>array('view', 'id'=>$model->id)),
                    array('label'=>Yii::t('model', 'Manage {model}', $modelPluralName), 'url'=>array('admin')),
                );
                break;
            case 'delete':
                break;
        }
        
        return $a;
    }
    
    /**
     * Generates the breadcrumbs for specified action and model.
     * @param CAction $action
     * @param CModel $model
     * @return array
     */
    public static function breadcrumbs(&$action, &$model) {
        $a = array();
                
        $modelPluralName = array('{model}'=>$model->modelPluralName);
        
        switch($action->id) {
            case 'admin':
                $a = array(
                    Yii::t('model', '{model}', $modelPluralName)=>array('index'),
                    Yii::t('model', 'Manage'),
                );
                break;
            case 'view':
                $a = array(                
                    Yii::t('model', '{model}', $modelPluralName)=>array('index'),
                    $model->id,
                );
                break;
            case 'create':
                $a = array(
                    Yii::t('model', '{model}', $modelPluralName)=>array('index'),
                    Yii::t('model', 'Create'),
                );
                break;
            case 'update':
                $a = array(
                    Yii::t('model', '{model}', $modelPluralName)=>array('index'),
                    $model->id=>array('view','id'=>$model->id),
                    Yii::t('model', 'Update'),
                );                
                break;
            case 'delete':
                break;
        }
        
        return $a;
    }
    
    /**
     * Generates the title for specified action and model.
     * @param CAction $action
     * @param CModel $model
     * @return string
     */
    public static function title(&$action, &$model) {        
        
        $title = '';
        
        // some $model->modelPluralName and $model->modelName instruction retrieval repetition,
        // for performance purposes: it does less lookup.
        switch ($action->id) {
            case 'admin':
                $modelPluralName = array('{model}'=>$model->modelPluralName);
                $title = Yii::t('model', 'Manage {model}', $modelPluralName);
                break;
            case 'view':
                $modelName = array('{model}'=>$model->modelName);
                $title = Yii::t('model', 'View {model}', $modelName);
                break;
            case 'create':
                $modelName = array('{model}'=>$model->modelName);
                $title = Yii::t('model', 'Create {model}', $modelName);
                break;
            case 'update':
                $modelName = array('{model}'=>$model->modelName);
                $title = Yii::t('model', 'Update {model}', $modelName);
                break;
            case 'delete':
                // do nothing
                break;
            
        }
        return $title;
    }
    
    public static function linkList($arrayValues,$route) {
        $val='';
        foreach($arrayValues as &$a) {
            $val.=CHtml::link(
                CHtml::encode($a->label),
                array($route,'id'=>$a->id)
            ).";&nbsp;&nbsp;&nbsp;";
        }
        return $val;
    }
    
    public static function datetimePickerDefaultOptions($model,$attribute,$size=17) {
        return array(
            'model'=>$model, 
            'attribute'=>$attribute,
            'mode'=>'datetime',
            'htmlOptions'=>array(
                'id'=>"datepicker_for_$attribute",
                'size'=>$size,
                'style'=>'display: none;'
            ),
            'options'=>array(
                'showOn'=>'button',
                'buttonImage'=>Yii::app()->baseUrl.'/images/calendar.gif',
                'showOtherMonths'=>true,
                'selectOtherMonths'=>true,
                'dateFormat'=>'yy-mm-dd',
                'timeFormat'=>'HH:mm:ss',
                'showSecond'=>true,
                'changeMonth'=>true,
                'changeYear'=>true,
                'showButtonPanel'=>true,
                'altField'=>"#datepicker_for_{$attribute}_alternate",
                'altFieldTimeOnly'=>false,
                'altFormat'=>"dd-mm-yy"
            ),
        );
    }
    
    public static function datetimePickerDefaultOptionsRaw($model,$attribute,$size=17) {
        return array(
            'model'=>$model, 
            'attribute'=>$attribute,
            'mode'=>'datetime',
            'htmlOptions'=>array(
                'id'=>"datepicker_for_$attribute",
                'size'=>$size,
            ),
            'options'=>array(
                'showOn'=>'focus',
                'showOtherMonths'=>true,
                'selectOtherMonths'=>true,
                'dateFormat'=>'yy-mm-dd',
                'timeFormat'=>'HH:mm:ss',
                'showSecond'=>true,
                'changeMonth'=>true,
                'changeYear'=>true,
                'showButtonPanel'=>true,
            ),
        );
    }
}

?>
