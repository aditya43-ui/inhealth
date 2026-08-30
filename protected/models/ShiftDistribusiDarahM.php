<?php

/**
 * This is the model class for table "shift_distribusi_darah_m".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'shift_distribusi_darah_m':
 * @property integer $shift_distribusi_darah_id
 * @property string $shift_distribusi_darah_nama
 * @property string $shift_distribusi_darah_namalainnya
 * @property string $shift_distribusi_darah_jamawal
 * @property string $shift_distribusi_darah_jamakhir
 * @property boolean $shift_distribusi_darah_akhir
 * @property string $shift_distribusi_darah_kode
 * @property integer $shift_distribusi_darah_urutan
 * @property boolean $shift_distribusi_darah_bedatanggal
 */
class ShiftDistribusiDarahM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftDistribusiDarahM the static model class
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
		return 'shift_distribusi_darah_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_distribusi_darah_nama, shift_distribusi_darah_jamawal, shift_distribusi_darah_jamakhir, shift_distribusi_darah_akhir', 'required'),
			array('shift_distribusi_darah_urutan', 'numerical', 'integerOnly'=>true),
			array('shift_distribusi_darah_nama, shift_distribusi_darah_namalainnya', 'length', 'max'=>50),
			array('shift_distribusi_darah_kode', 'length', 'max'=>1),
			array('shift_distribusi_darah_bedatanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shift_distribusi_darah_id, shift_distribusi_darah_nama, shift_distribusi_darah_namalainnya, shift_distribusi_darah_jamawal, shift_distribusi_darah_jamakhir, shift_distribusi_darah_akhir, shift_distribusi_darah_kode, shift_distribusi_darah_urutan, shift_distribusi_darah_bedatanggal', 'safe', 'on'=>'search'),
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
			'shift_distribusi_darah_id' => 'Shift Distribusi Darah',
			'shift_distribusi_darah_nama' => 'Shift Distribusi Darah Nama',
			'shift_distribusi_darah_namalainnya' => 'Shift Distribusi Darah Namalainnya',
			'shift_distribusi_darah_jamawal' => 'Shift Distribusi Darah Jamawal',
			'shift_distribusi_darah_jamakhir' => 'Shift Distribusi Darah Jamakhir',
			'shift_distribusi_darah_akhir' => 'Shift Distribusi Darah Akhir',
			'shift_distribusi_darah_kode' => 'Shift Distribusi Darah Kode',
			'shift_distribusi_darah_urutan' => 'Shift Distribusi Darah Urutan',
			'shift_distribusi_darah_bedatanggal' => 'Shift Distribusi Darah Bedatanggal',
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

		$criteria->compare('shift_distribusi_darah_id',$this->shift_distribusi_darah_id);
		$criteria->compare('shift_distribusi_darah_nama',$this->shift_distribusi_darah_nama,true);
		$criteria->compare('shift_distribusi_darah_namalainnya',$this->shift_distribusi_darah_namalainnya,true);
		$criteria->compare('shift_distribusi_darah_jamawal',$this->shift_distribusi_darah_jamawal,true);
		$criteria->compare('shift_distribusi_darah_jamakhir',$this->shift_distribusi_darah_jamakhir,true);
		$criteria->compare('shift_distribusi_darah_akhir',$this->shift_distribusi_darah_akhir);
		$criteria->compare('shift_distribusi_darah_kode',$this->shift_distribusi_darah_kode,true);
		$criteria->compare('shift_distribusi_darah_urutan',$this->shift_distribusi_darah_urutan);
		$criteria->compare('shift_distribusi_darah_bedatanggal',$this->shift_distribusi_darah_bedatanggal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}