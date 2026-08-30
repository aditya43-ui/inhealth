<?php

/**
 * This is the model class for table "laporanpelaksanaanestesi_v".
 *
 * The followings are the available columns in table 'laporanpelaksanaanestesi_v':
 * @property string $tgl_laporan
 * @property integer $dokter_id
 * @property string $nama_dokter
 * @property integer $perawat1_id
 * @property string $nama_perawat1
 * @property integer $perawat2_id
 * @property string $nama_perawat2
 * @property integer $totalpasien
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class LaporanpelaksanaanestesiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpelaksanaanestesiV the static model class
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
		return 'laporanpelaksanaanestesi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dokter_id, perawat1_id, perawat2_id, totalpasien, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('nama_dokter, nama_perawat1, nama_perawat2, ruangan_nama', 'length', 'max'=>50),
			array('tgl_laporan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, dokter_id, nama_dokter, perawat1_id, nama_perawat1, perawat2_id, nama_perawat2, totalpasien, ruangan_id, ruangan_nama', 'safe', 'on'=>'search'),
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
			'tgl_laporan' => 'Tgl Laporan',
			'dokter_id' => 'Dokter',
			'nama_dokter' => 'Nama Dokter',
			'perawat1_id' => 'Perawat1',
			'nama_perawat1' => 'Nama Perawat1',
			'perawat2_id' => 'Perawat2',
			'nama_perawat2' => 'Nama Perawat2',
			'totalpasien' => 'Totalpasien',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
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

		$criteria->compare('tgl_laporan',$this->tgl_laporan,true);
		$criteria->compare('dokter_id',$this->dokter_id);
		$criteria->compare('nama_dokter',$this->nama_dokter,true);
		$criteria->compare('perawat1_id',$this->perawat1_id);
		$criteria->compare('nama_perawat1',$this->nama_perawat1,true);
		$criteria->compare('perawat2_id',$this->perawat2_id);
		$criteria->compare('nama_perawat2',$this->nama_perawat2,true);
		$criteria->compare('totalpasien',$this->totalpasien);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}