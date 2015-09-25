<?php

/**
 * This is the model class for table "timesheet".
 *
 * The followings are the available columns in table 'timesheet':
 * @property integer $ID
 * @property integer $ANNO
 * @property integer $MESE
 * @property integer $SETTIMANA
 * @property string $IDENTIFICATIVO
 * @property string $DATA
 * @property string $DATASHORT
 * @property string $RISORSA
 * @property string $IDCOMMESSA
 * @property string $ORE
 * @property string $KM
 * @property string $AUTO
 * @property string $PASTO
 * @property string $DESCRIZIONE
 * @property integer $BLOCCO
 * @property string $INSERITO
 * @property string $MODIFICATO
 * @property string $MODIFICATODA
 * @property string $IDPREVENTIVO
 * @property string $SUPERCOMMESSA
 * @property integer $STRAORDINARIO
 */
class Timesheet extends CActiveRecord {
    
    public $datashort;
    /**
     * Override of behaviors
     * @return array
     */
    public function behaviors() {
        return array(
            'modelNameBehavior' => 'ModelNameBehavior',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Timesheet the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'timesheet';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ANNO, MESE, SETTIMANA, BLOCCO, STRAORDINARIO', 'numerical', 'integerOnly' => true),
            array('IDENTIFICATIVO, MODIFICATODA, IDPREVENTIVO', 'length', 'max' => 15),
            array('DATA', 'length', 'max' => 16),
            array('RISORSA, SUPERCOMMESSA', 'length', 'max' => 50),
            array('IDCOMMESSA', 'length', 'max' => 255),
            array('ORE', 'length', 'max' => 6),
            array('KM', 'length', 'max' => 4),
            array('AUTO, PASTO', 'length', 'max' => 10),
            array('DESCRIZIONE', 'length', 'max' => 2048),
            // safe inputs.
            array('DESCRIZIONE, DATASHORT, INSERITO, MODIFICATO', 'safe'),
            // required inputs.
            array('DESCRIZIONE', 'required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ID, ANNO, MESE, SETTIMANA, IDENTIFICATIVO, DATA, DATASHORT, RISORSA, IDCOMMESSA, ORE, KM, AUTO, PASTO, DESCRIZIONE, BLOCCO, INSERITO, MODIFICATO, MODIFICATODA, IDPREVENTIVO, SUPERCOMMESSA, STRAORDINARIO', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ID' => Yii::t('timesheet', 'ID'),
            'ANNO' => Yii::t('timesheet', 'Anno'),
            'MESE' => Yii::t('timesheet', 'Mese'),
            'SETTIMANA' => Yii::t('timesheet', 'Settimana'),
            'IDENTIFICATIVO' => Yii::t('timesheet', 'Identificativo'),
            'DATA' => Yii::t('timesheet', 'Data'),
            'DATASHORT' => Yii::t('timesheet', 'Datashort'),
            'RISORSA' => Yii::t('timesheet', 'Risorsa'),
            'IDCOMMESSA' => Yii::t('timesheet', 'Idcommessa'),
            'ORE' => Yii::t('timesheet', 'Ore'),
            'KM' => Yii::t('timesheet', 'Km'),
            'AUTO' => Yii::t('timesheet', 'Auto'),
            'PASTO' => Yii::t('timesheet', 'Pasto'),
            'DESCRIZIONE' => Yii::t('timesheet', 'Descrizione'),
            'BLOCCO' => Yii::t('timesheet', 'Blocco'),
            'INSERITO' => Yii::t('timesheet', 'Inserito'),
            'MODIFICATO' => Yii::t('timesheet', 'Modificato'),
            'MODIFICATODA' => Yii::t('timesheet', 'Modificatoda'),
            'IDPREVENTIVO' => Yii::t('timesheet', 'Idpreventivo'),
            'SUPERCOMMESSA' => Yii::t('timesheet', 'Supercommessa'),
            'STRAORDINARIO' => Yii::t('timesheet', 'Straordinario'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param integer $pageSize the pagination size. Defaults to 10
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('ID', $this->ID);
        $criteria->compare('ANNO', $this->ANNO);
        $criteria->compare('MESE', $this->MESE);
        $criteria->compare('SETTIMANA', $this->SETTIMANA);
        $criteria->compare('IDENTIFICATIVO', $this->IDENTIFICATIVO, true);
        $criteria->compare('DATA', $this->DATA, true);
        $criteria->compare('DATASHORT', $this->DATASHORT, true);
        $criteria->compare('RISORSA', $this->RISORSA, true);
        $criteria->compare('IDCOMMESSA', $this->IDCOMMESSA, true);
        $criteria->compare('ORE', $this->ORE, true);
        $criteria->compare('KM', $this->KM, true);
        $criteria->compare('AUTO', $this->AUTO, true);
        $criteria->compare('PASTO', $this->PASTO, true);
        $criteria->compare('DESCRIZIONE', $this->DESCRIZIONE, true);
        $criteria->compare('BLOCCO', $this->BLOCCO);
        $criteria->compare('INSERITO', $this->INSERITO, true);
        $criteria->compare('MODIFICATO', $this->MODIFICATO, true);
        $criteria->compare('MODIFICATODA', $this->MODIFICATODA, true);
        $criteria->compare('IDPREVENTIVO', $this->IDPREVENTIVO, true);
        $criteria->compare('SUPERCOMMESSA', $this->SUPERCOMMESSA, true);
        $criteria->compare('STRAORDINARIO', $this->STRAORDINARIO);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $pageSize,
            ),
        ));
    }

    public function getInputField($fieldName, $row, $options = array('style' => 'width:100%')) {
        return CActiveForm::textField($this, $fieldName, array_merge(array("name" => "Timesheet[" . $row . "][" . $fieldName . "]"), $options)
        );
    }
    
    public function getHours($day){
        $oreTot = date('Y-m-d', strtotime($day));
        $sql="SELECT SUM(ORE)FROM timesheet WHERE DATASHORT LIKE :data";
        $params=array(':data'=>$oreTot.'%');
        try {
            $res=Yii::app()->db->createCommand($sql)->queryAll(true,$params);
        }
        catch(Exception $e) {
            error_log($e->getMessage());
            $res=array();
        }
        
        if (count($res) == 0) {
            return false;
        }

        return "{$res[0]['SUM(ORE)']}";
    }

    protected function beforeSave() {
        parent::beforeSave();

        //$this->DATASHORT = UtilityHelper::sa();

        return true;
    }

}
