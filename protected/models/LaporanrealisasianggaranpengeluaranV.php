<?php

/**
 * This is the model class for table "laporanrealisasianggaranpengeluaran_v".
 *
 * The followings are the available columns in table 'laporanrealisasianggaranpengeluaran_v':
 * @property integer $rencanggaranpeng_id
 * @property string $rencanggaranpeng_no
 * @property integer $konfiganggaran_id
 * @property string $deskripsiperiode
 * @property string $rencanggaranpeng_tgl
 * @property integer $unitkerja_id
 * @property string $namaunitkerja
 * @property double $total_nilairencpeng
 * @property integer $rencanggaranpengdet_id
 * @property integer $apprrencanggaran_id
 * @property double $nilaiygdisetujui
 */
class LaporanrealisasianggaranpengeluaranV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrealisasianggaranpengeluaranV the static model class
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
		return 'laporanrealisasianggaranpengeluaran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanggaranpeng_id, konfiganggaran_id, unitkerja_id, rencanggaranpengdet_id, apprrencanggaran_id', 'numerical', 'integerOnly'=>true),
			array('total_nilairencpeng, nilaiygdisetujui', 'numerical'),
			array('rencanggaranpeng_no', 'length', 'max'=>30),
			array('deskripsiperiode', 'length', 'max'=>100),
			array('namaunitkerja', 'length', 'max'=>200),
			array('rencanggaranpeng_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanggaranpeng_id, rencanggaranpeng_no, konfiganggaran_id, deskripsiperiode, rencanggaranpeng_tgl, unitkerja_id, namaunitkerja, total_nilairencpeng, rencanggaranpengdet_id, apprrencanggaran_id, nilaiygdisetujui', 'safe', 'on'=>'search'),
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
			'rencanggaranpeng_id' => 'Rencanggaranpeng',
			'rencanggaranpeng_no' => 'Rencanggaranpeng No',
			'konfiganggaran_id' => 'Konfiganggaran',
			'deskripsiperiode' => 'Deskripsiperiode',
			'rencanggaranpeng_tgl' => 'Rencanggaranpeng Tgl',
			'unitkerja_id' => 'Unitkerja',
			'namaunitkerja' => 'Namaunitkerja',
			'total_nilairencpeng' => 'Total Nilairencpeng',
			'rencanggaranpengdet_id' => 'Rencanggaranpengdet',
			'apprrencanggaran_id' => 'Apprrencanggaran',
			'nilaiygdisetujui' => 'Nilaiygdisetujui',
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

		$criteria->compare('rencanggaranpeng_id',$this->rencanggaranpeng_id);
		$criteria->compare('rencanggaranpeng_no',$this->rencanggaranpeng_no,true);
		$criteria->compare('konfiganggaran_id',$this->konfiganggaran_id);
		$criteria->compare('deskripsiperiode',$this->deskripsiperiode,true);
		$criteria->compare('rencanggaranpeng_tgl',$this->rencanggaranpeng_tgl,true);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
		$criteria->compare('namaunitkerja',$this->namaunitkerja,true);
		$criteria->compare('total_nilairencpeng',$this->total_nilairencpeng);
		$criteria->compare('rencanggaranpengdet_id',$this->rencanggaranpengdet_id);
		$criteria->compare('apprrencanggaran_id',$this->apprrencanggaran_id);
		$criteria->compare('nilaiygdisetujui',$this->nilaiygdisetujui);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}