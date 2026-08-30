<?php

/**
 * This is the model class for table "rekeningcolumn_m".
 *
 * The followings are the available columns in table 'rekeningcolumn_m':
 * @property integer $rekeningcolumn_id
 * @property string $table_name
 * @property string $column_name
 * @property integer $rekening5_id
 * @property string $debitkredit
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property Rekening5M $rekening5
 */
class RekeningcolumnM extends CActiveRecord
{
    public $kdrekening5, $rekening1_id, $rekening2_id, $rekening3_id, $rekening4_id, $nmrekening3, $nmrekening5, $nmrekening4;
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekeningcolumnM the static model class
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
		return 'rekeningcolumn_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening5_id', 'numerical', 'integerOnly'=>true),
			array('table_name, column_name', 'length', 'max'=>100),
			array('debitkredit', 'length', 'max'=>1),
			array('keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekeningcolumn_id, table_name, column_name, rekening5_id, debitkredit, keterangan', 'safe', 'on'=>'search'),
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
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekeningcolumn_id' => 'Rekeningcolumn',
			'table_name' => 'Nama Tabel',
			'column_name' => 'Nama Kolom',
			'rekening5_id' => 'Rekening5',
			'debitkredit' => 'Debitkredit',
			'keterangan' => 'Keterangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                if(!empty($this->rekeningcolumn_id)){
                    $criteria->addCondition('rekeningcolumn_id ='.$this->rekeningcolumn_id);
                }
		$criteria->compare('lower(table_name)', strtolower($this->table_name),true);
		$criteria->compare('lower(column_name)',strtolower($this->column_name),true);
                if(!empty($this->rekening5_id)){
                    $criteria->addCondition('rekening5_id ='.$this->rekening5_id);
                }
//		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit,true);
		$criteria->compare('lower(keterangan)',strtolower($this->keterangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}