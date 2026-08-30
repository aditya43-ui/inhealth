<?php

/**
 * This is the model class for table "laporanantrian_v".
 *
 * The followings are the available columns in table 'laporanantrian_v':
 * @property integer $antrian_id
 * @property string $noantrian
 * @property string $barcode
 * @property string $tglantrian
 * @property string $jenis_kunjungan
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_singkatan
 * @property integer $loket_id
 * @property string $loket_nama
 * @property integer $modelantrian_id
 * @property string $modelantrian_nama
 * @property string $modelantrian_singkatan
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 */
class LaporanantrianV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanantrian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('antrian_id, ruangan_id, loket_id, modelantrian_id, pendaftaran_id, carabayar_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('noantrian', 'length', 'max'=>6),
			array('jenis_kunjungan, loket_nama, carabayar_nama, nama_pasien', 'length', 'max'=>50),
			array('ruangan_nama, modelantrian_nama', 'length', 'max'=>100),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('modelantrian_singkatan, no_rekam_medik', 'length', 'max'=>10),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('barcode, tglantrian', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('antrian_id, noantrian, barcode, tglantrian, jenis_kunjungan, ruangan_id, ruangan_nama, ruangan_singkatan, loket_id, loket_nama, modelantrian_id, modelantrian_nama, modelantrian_singkatan, pendaftaran_id, no_pendaftaran, carabayar_id, carabayar_nama, pasien_id, nama_pasien, no_rekam_medik', 'safe', 'on'=>'search'),
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
			'antrian_id' => 'Antrian',
			'noantrian' => 'Noantrian',
			'barcode' => 'Barcode',
			'tglantrian' => 'Tglantrian',
			'jenis_kunjungan' => 'Jenis Kunjungan',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'loket_id' => 'Loket',
			'loket_nama' => 'Loket Nama',
			'modelantrian_id' => 'Modelantrian',
			'modelantrian_nama' => 'Modelantrian Nama',
			'modelantrian_singkatan' => 'Modelantrian Singkatan',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('noantrian',$this->noantrian,true);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('tglantrian',$this->tglantrian,true);
		$criteria->compare('jenis_kunjungan',$this->jenis_kunjungan,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan,true);
		$criteria->compare('loket_id',$this->loket_id);
		$criteria->compare('loket_nama',$this->loket_nama,true);
		$criteria->compare('modelantrian_id',$this->modelantrian_id);
		$criteria->compare('modelantrian_nama',$this->modelantrian_nama,true);
		$criteria->compare('modelantrian_singkatan',$this->modelantrian_singkatan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaporanantrianV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
