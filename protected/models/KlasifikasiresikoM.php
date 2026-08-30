<?php

/**
 * This is the model class for table "klasifikasiresiko_m".
 *
 * The followings are the available columns in table 'klasifikasiresiko_m':
 * @property integer $klasfikasiresiko_id
 * @property string $kelompokresiko
 * @property string $kategori_resiko
 * @property integer $nilai_resiko
 * @property string $jenis_resiko
 * @property string $defenisi_resiko
 * @property string $resiko_ket
 * @property boolean $klasifikasiresiko_aktif
 */
class KlasifikasiresikoM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KlasifikasiresikoM the static model class
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
		return 'klasifikasiresiko_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokresiko, kategori_resiko, nilai_resiko, jenis_resiko, defenisi_resiko, klasifikasiresiko_aktif', 'required'),
			array('nilai_resiko', 'numerical', 'integerOnly'=>true),
			array('kelompokresiko', 'length', 'max'=>20),
			array('kategori_resiko, jenis_resiko', 'length', 'max'=>100),
			array('resiko_ket', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('klasfikasiresiko_id, kelompokresiko, kategori_resiko, nilai_resiko, jenis_resiko, defenisi_resiko, resiko_ket, klasifikasiresiko_aktif', 'safe', 'on'=>'search'),
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
			'klasfikasiresiko_id' => 'Klasfikasiresiko',
			'kelompokresiko' => 'Kelompokresiko',
			'kategori_resiko' => 'Kategori Resiko',
			'nilai_resiko' => 'Nilai Resiko',
			'jenis_resiko' => 'Jenis Resiko',
			'defenisi_resiko' => 'Defenisi Resiko',
			'resiko_ket' => 'Resiko Ket',
			'klasifikasiresiko_aktif' => 'Klasifikasiresiko Aktif',
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

		$criteria->compare('klasfikasiresiko_id',$this->klasfikasiresiko_id);
		$criteria->compare('kelompokresiko',$this->kelompokresiko,true);
		$criteria->compare('kategori_resiko',$this->kategori_resiko,true);
		$criteria->compare('nilai_resiko',$this->nilai_resiko);
		$criteria->compare('jenis_resiko',$this->jenis_resiko,true);
		$criteria->compare('defenisi_resiko',$this->defenisi_resiko,true);
		$criteria->compare('resiko_ket',$this->resiko_ket,true);
		$criteria->compare('klasifikasiresiko_aktif',$this->klasifikasiresiko_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}