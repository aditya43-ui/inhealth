<?php

/**
 * This is the model class for table "datapenunjang_t".
 *
 * The followings are the available columns in table 'datapenunjang_t':
 * @property integer $datapenunjang_id
 * @property integer $pengkajianaskep_id
 * @property string $datapenunjang_tgl
 * @property string $datapenunjang_nama
 *
 * The followings are the available model relations:
 * @property PengkajianaskepT $pengkajianaskep
 */
class DatapenunjangT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DatapenunjangT the static model class
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
		return 'datapenunjang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengkajianaskep_id', 'required'),
			array('pengkajianaskep_id', 'numerical', 'integerOnly'=>true),
			array('datapenunjang_nama', 'length', 'max'=>200),
			array('datapenunjang_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('datapenunjang_id, pengkajianaskep_id, datapenunjang_tgl, datapenunjang_nama', 'safe', 'on'=>'search'),
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
			'pengkajianaskep' => array(self::BELONGS_TO, 'PengkajianaskepT', 'pengkajianaskep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'datapenunjang_id' => 'Datapenunjang',
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'datapenunjang_tgl' => 'Datapenunjang Tgl',
			'datapenunjang_nama' => 'Datapenunjang Nama',
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

		$criteria->compare('datapenunjang_id',$this->datapenunjang_id);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('datapenunjang_tgl',$this->datapenunjang_tgl,true);
		$criteria->compare('datapenunjang_nama',$this->datapenunjang_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}