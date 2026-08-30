<?php

/**
 * This is the model class for table "informasipembebasantarif_v".
 *
 * The followings are the available columns in table 'informasipembebasantarif_v':
 * @property integer $pembebasantarif_id
 * @property string $tglpembebasan
 * @property double $jmlpembebasan
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 */
class InformasipembebasantarifV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipembebasantarifV the static model class
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
		return 'informasipembebasantarif_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembebasantarif_id, pegawai_id, tindakanpelayanan_id, daftartindakan_id, komponentarif_id, pendaftaran_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('jmlpembebasan', 'numerical'),
			array('nama_pegawai, nama_pasien', 'length', 'max'=>50),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('komponentarif_nama', 'length', 'max'=>25),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tglpembebasan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembebasantarif_id, tglpembebasan, jmlpembebasan, pegawai_id, nama_pegawai, tindakanpelayanan_id, daftartindakan_id, daftartindakan_nama, komponentarif_id, komponentarif_nama, pendaftaran_id, no_pendaftaran, pasien_id, no_rekam_medik, nama_pasien', 'safe', 'on'=>'search'),
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
			'pembebasantarif_id' => 'Pembebasan Tarif',
			'tglpembebasan' => 'Tanggal Pembebasan',
			'jmlpembebasan' => 'Jumlah Pembebasan',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Pegawai / Dokter',
			'tindakanpelayanan_id' => 'Tindakan Pelayanan',
			'daftartindakan_id' => 'Tindakan',
			'daftartindakan_nama' => 'Tindakan',
			'komponentarif_id' => 'Komponen Tarif',
			'komponentarif_nama' => 'Komponen Tarif',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
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

		$criteria->compare('pembebasantarif_id',$this->pembebasantarif_id);
		$criteria->compare('tglpembebasan',$this->tglpembebasan,true);
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('komponentarif_nama',$this->komponentarif_nama,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}