<?php

/**
 * This is the model class for table "commesse".
 *
 * The followings are the available columns in table 'commesse':
 * @property integer $ID
 * @property string $IDENTIFICATIVO
 * @property string $DATAAPERTURA
 * @property string $DATACHIUSURA
 * @property string $CLIENTE
 * @property string $DESCRIZIONE
 * @property string $TITOLO
 * @property string $REFERENTE
 * @property string $RESPCOMMESSA
 * @property string $COORDINATORE
 * @property string $IDPREVENTIVO
 * @property string $SUPERCOMMESSA
 * @property string $COMMESSEPRECEDENTI
 * @property string $NUMEROFATTURA
 * @property string $DATAFATTURA
 * @property integer $SOLOFORNITURA
 */
class Commesse extends CActiveRecord
{

    /**
     * Override of behaviors
     * @return array
     */
    public function behaviors() {
        return array(
            'modelNameBehavior'=>'ModelNameBehavior',
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Commesse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'commesse';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SOLOFORNITURA', 'numerical', 'integerOnly'=>true),
			array('IDENTIFICATIVO, RESPCOMMESSA, COORDINATORE, IDPREVENTIVO, SUPERCOMMESSA', 'length', 'max'=>50),
			array('CLIENTE, DESCRIZIONE, TITOLO, REFERENTE, COMMESSEPRECEDENTI, NUMEROFATTURA', 'length', 'max'=>255),
			array('DATAAPERTURA, DATACHIUSURA, DATAFATTURA', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, IDENTIFICATIVO, DATAAPERTURA, DATACHIUSURA, CLIENTE, DESCRIZIONE, TITOLO, REFERENTE, RESPCOMMESSA, COORDINATORE, IDPREVENTIVO, SUPERCOMMESSA, COMMESSEPRECEDENTI, NUMEROFATTURA, DATAFATTURA, SOLOFORNITURA', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('commesse','ID'),
			'IDENTIFICATIVO' => Yii::t('commesse','Identificativo'),
			'DATAAPERTURA' => Yii::t('commesse','Dataapertura'),
			'DATACHIUSURA' => Yii::t('commesse','Datachiusura'),
			'CLIENTE' => Yii::t('commesse','Cliente'),
			'DESCRIZIONE' => Yii::t('commesse','Descrizione'),
			'TITOLO' => Yii::t('commesse','Titolo'),
			'REFERENTE' => Yii::t('commesse','Referente'),
			'RESPCOMMESSA' => Yii::t('commesse','Respcommessa'),
			'COORDINATORE' => Yii::t('commesse','Coordinatore'),
			'IDPREVENTIVO' => Yii::t('commesse','Idpreventivo'),
			'SUPERCOMMESSA' => Yii::t('commesse','Supercommessa'),
			'COMMESSEPRECEDENTI' => Yii::t('commesse','Commesseprecedenti'),
			'NUMEROFATTURA' => Yii::t('commesse','Numerofattura'),
			'DATAFATTURA' => Yii::t('commesse','Datafattura'),
			'SOLOFORNITURA' => Yii::t('commesse','Solofornitura'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
     * @param integer $pageSize the pagination size. Defaults to 10
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pageSize=10)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('IDENTIFICATIVO',$this->IDENTIFICATIVO,true);
		$criteria->compare('DATAAPERTURA',$this->DATAAPERTURA,true);
		$criteria->compare('DATACHIUSURA',$this->DATACHIUSURA,true);
		$criteria->compare('CLIENTE',$this->CLIENTE,true);
		$criteria->compare('DESCRIZIONE',$this->DESCRIZIONE,true);
		$criteria->compare('TITOLO',$this->TITOLO,true);
		$criteria->compare('REFERENTE',$this->REFERENTE,true);
		$criteria->compare('RESPCOMMESSA',$this->RESPCOMMESSA,true);
		$criteria->compare('COORDINATORE',$this->COORDINATORE,true);
		$criteria->compare('IDPREVENTIVO',$this->IDPREVENTIVO,true);
		$criteria->compare('SUPERCOMMESSA',$this->SUPERCOMMESSA,true);
		$criteria->compare('COMMESSEPRECEDENTI',$this->COMMESSEPRECEDENTI,true);
		$criteria->compare('NUMEROFATTURA',$this->NUMEROFATTURA,true);
		$criteria->compare('DATAFATTURA',$this->DATAFATTURA,true);
		$criteria->compare('SOLOFORNITURA',$this->SOLOFORNITURA);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$pageSize,
            ),
		));
	}
}