<?php

/**
 * This is the model class for table "evaluasipenawarandet_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'evaluasipenawarandet_t':
 * @property integer $evaluasipenawarandet_id
 * @property integer $evaluasipenawaran_id
 * @property integer $indikatorevaluasipenawaran_id
 * @property string $evaluasipenawarandet_jenis
 * @property string $evaluasipenawaran_nama
 * @property boolean $ismemenuhi
 *
 * The followings are the available model relations:
 * @property IndikatorevaluasipenawaranM $indikatorevaluasipenawaran
 * @property EvaluasipenawaranT $evaluasipenawaran
 */
class EvaluasipenawarandetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EvaluasipenawarandetT the static model class
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
		return 'evaluasipenawarandet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evaluasipenawarandet_jenis, evaluasipenawaran_nama', 'required'),
			array('evaluasipenawaran_id, indikatorevaluasipenawaran_id', 'numerical', 'integerOnly'=>true),
			array('evaluasipenawarandet_jenis', 'length', 'max'=>100),
			array('evaluasipenawaran_nama', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('evaluasipenawarandet_id, evaluasipenawaran_id, indikatorevaluasipenawaran_id, evaluasipenawarandet_jenis, evaluasipenawaran_nama, ismemenuhi', 'safe', 'on'=>'search'),
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
			'indikatorevaluasipenawaran' => array(self::BELONGS_TO, 'IndikatorevaluasipenawaranM', 'indikatorevaluasipenawaran_id'),
			'evaluasipenawaran' => array(self::BELONGS_TO, 'EvaluasipenawaranT', 'evaluasipenawaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'evaluasipenawarandet_id' => 'Evaluasipenawarandet',
			'evaluasipenawaran_id' => 'Evaluasipenawaran',
			'indikatorevaluasipenawaran_id' => 'Indikatorevaluasipenawaran',
			'evaluasipenawarandet_jenis' => 'Evaluasipenawarandet Jenis',
			'evaluasipenawaran_nama' => 'Evaluasipenawaran Nama',
			'ismemenuhi' => 'Ismemenuhi',
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

		$criteria->compare('evaluasipenawarandet_id',$this->evaluasipenawarandet_id);
		$criteria->compare('evaluasipenawaran_id',$this->evaluasipenawaran_id);
		$criteria->compare('indikatorevaluasipenawaran_id',$this->indikatorevaluasipenawaran_id);
		$criteria->compare('evaluasipenawarandet_jenis',$this->evaluasipenawarandet_jenis,true);
		$criteria->compare('evaluasipenawaran_nama',$this->evaluasipenawaran_nama,true);
		$criteria->compare('ismemenuhi',$this->ismemenuhi);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}