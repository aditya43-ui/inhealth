<?php

/**
 * This is the model class for table "rl3_7_kegiatanradiologi_v".
 *
 * The followings are the available columns in table 'rl3_7_kegiatanradiologi_v':
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $koders
 * @property integer $profilrs_id
 * @property string $kabupaten
 * @property string $namars
 * @property integer $jeniskegiatan_id
 * @property string $jeniskegiatan_kode
 * @property string $jeniskegiatan_nama
 * @property integer $jumlah
 */
class Rl37KegiatanradiologiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl37KegiatanradiologiV the static model class
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
		return 'rl3_7_kegiatanradiologi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, jeniskegiatan_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('propinsi, koders, kabupaten, namars', 'length', 'max'=>50),
			array('jeniskegiatan_kode', 'length', 'max'=>25),
			array('jeniskegiatan_nama', 'length', 'max'=>100),
			array('tgl_laporan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, propinsi, koders, profilrs_id, kabupaten, namars, jeniskegiatan_id, jeniskegiatan_kode, jeniskegiatan_nama, jumlah', 'safe', 'on'=>'search'),
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
			'tgl_laporan' => 'Tgl. Laporan',
			'propinsi' => 'Provinsi',
			'koders' => 'Koders',
			'profilrs_id' => 'Profilrs',
			'kabupaten' => 'Kabupaten',
			'namars' => 'Namars',
			'jeniskegiatan_id' => 'Jeniskegiatan',
			'jeniskegiatan_kode' => 'Jeniskegiatan Kode',
			'jeniskegiatan_nama' => 'Jeniskegiatan Nama',
			'jumlah' => 'Jumlah',
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
		$criteria->compare('propinsi',$this->propinsi,true);
		$criteria->compare('koders',$this->koders,true);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('kabupaten',$this->kabupaten,true);
		$criteria->compare('namars',$this->namars,true);
		$criteria->compare('jeniskegiatan_id',$this->jeniskegiatan_id);
		$criteria->compare('jeniskegiatan_kode',$this->jeniskegiatan_kode,true);
		$criteria->compare('jeniskegiatan_nama',$this->jeniskegiatan_nama,true);
		$criteria->compare('jumlah',$this->jumlah);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}