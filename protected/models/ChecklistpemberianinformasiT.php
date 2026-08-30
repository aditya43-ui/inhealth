<?php

/**
 * This is the model class for table "checklistpemberianinformasi_t".
 *
 * The followings are the available columns in table 'checklistpemberianinformasi_t':
 * @property integer $checklistpemberianinformasi_id
 * @property integer $pemberianinformasidet_id
 * @property string $checklistpemberianinformasi_awal
 * @property string $checklistpemberianinformasi_nama
 * @property string $checklistpemberianinformasi_akhir
 * @property boolean $checklistpemberianinformasi_ceklis
 *
 * The followings are the available model relations:
 * @property PemberianinformasidetT $pemberianinformasidet
 */
class ChecklistpemberianinformasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChecklistpemberianinformasiT the static model class
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
		return 'checklistpemberianinformasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemberianinformasidet_id', 'required'),
			array('pemberianinformasidet_id', 'numerical', 'integerOnly'=>true),
			array('checklistpemberianinformasi_awal, checklistpemberianinformasi_nama, checklistpemberianinformasi_akhir, checklistpemberianinformasi_ceklis', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('checklistpemberianinformasi_id, pemberianinformasidet_id, checklistpemberianinformasi_awal, checklistpemberianinformasi_nama, checklistpemberianinformasi_akhir, checklistpemberianinformasi_ceklis', 'safe', 'on'=>'search'),
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
			'pemberianinformasidet' => array(self::BELONGS_TO, 'PemberianinformasidetT', 'pemberianinformasidet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'checklistpemberianinformasi_id' => 'Checklistpemberianinformasi',
			'pemberianinformasidet_id' => 'Pemberianinformasidet',
			'checklistpemberianinformasi_awal' => 'Checklistpemberianinformasi Awal',
			'checklistpemberianinformasi_nama' => 'Checklistpemberianinformasi Nama',
			'checklistpemberianinformasi_akhir' => 'Checklistpemberianinformasi Akhir',
			'checklistpemberianinformasi_ceklis' => 'Checklistpemberianinformasi Ceklis',
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

		$criteria->compare('checklistpemberianinformasi_id',$this->checklistpemberianinformasi_id);
		$criteria->compare('pemberianinformasidet_id',$this->pemberianinformasidet_id);
		$criteria->compare('checklistpemberianinformasi_awal',$this->checklistpemberianinformasi_awal,true);
		$criteria->compare('checklistpemberianinformasi_nama',$this->checklistpemberianinformasi_nama,true);
		$criteria->compare('checklistpemberianinformasi_akhir',$this->checklistpemberianinformasi_akhir,true);
		$criteria->compare('checklistpemberianinformasi_ceklis',$this->checklistpemberianinformasi_ceklis);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}