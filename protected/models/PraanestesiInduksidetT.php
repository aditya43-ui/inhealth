<?php

/**
 * This is the model class for table "praanestesi_induksidet_t".
 *
 * The followings are the available columns in table 'praanestesi_induksidet_t':
 * 
 * @package application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 * @property integer $praanestesi_induksidet_id
 * @property integer $praanestesi_induksi_id
 * @property string $kelompokinduksi
 * @property string $ukuran
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property PraanestesiInduksiT $praanestesiInduksi
 */
class PraanestesiInduksidetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PraanestesiInduksidetT the static model class
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
		return 'praanestesi_induksidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('praanestesi_induksi_id', 'required'),
			array('praanestesi_induksi_id', 'numerical', 'integerOnly'=>true),
			array('kelompokinduksi', 'length', 'max'=>25),
			array('ukuran', 'length', 'max'=>50),
			array('keterangan', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('praanestesi_induksidet_id, praanestesi_induksi_id, kelompokinduksi, ukuran, keterangan', 'safe', 'on'=>'search'),
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
			'praanestesiInduksi' => array(self::BELONGS_TO, 'PraanestesiInduksiT', 'praanestesi_induksi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'praanestesi_induksidet_id' => 'Praanestesi Induksidet',
			'praanestesi_induksi_id' => 'Praanestesi Induksi',
			'kelompokinduksi' => 'Kelompokinduksi',
			'ukuran' => 'Ukuran',
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

		$criteria->compare('praanestesi_induksidet_id',$this->praanestesi_induksidet_id);
		$criteria->compare('praanestesi_induksi_id',$this->praanestesi_induksi_id);
		$criteria->compare('kelompokinduksi',$this->kelompokinduksi,true);
		$criteria->compare('ukuran',$this->ukuran,true);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}