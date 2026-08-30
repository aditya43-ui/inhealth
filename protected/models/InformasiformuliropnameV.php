<?php

/**
 * This is the model class for table "informasiformuliropname_v".
 *
 * The followings are the available columns in table 'informasiformuliropname_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $formuliropname_id
 * @property string $tglformulir
 * @property string $noformulir
 * @property integer $stokopname_id
 * @property string $tglstokopname
 * @property string $nostokopname
 * @property boolean $isstokawal
 * @property string $jenisstokopname
 * @property string $keterangan_opname
 * @property double $totalharga
 * @property double $totalvolume
 * @property integer $petugas1_id
 * @property string $petugas1_nip
 * @property string $petugas1_noidentitas
 * @property string $petugas1_gelardepan
 * @property string $petugas1_nama
 * @property string $petugas1_gelarbelakang
 * @property integer $petugas2_id
 * @property string $petugas2_nip
 * @property string $petugas2_noidentitas
 * @property string $petugas2_gelardepan
 * @property string $petugas2_nama
 * @property string $petugas2_gelarbelakang
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_nip
 * @property string $pegawaimengetahui_noidentitas
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InformasiformuliropnameV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiformuliropnameV the static model class
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
		return 'informasiformuliropname_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, formuliropname_id, stokopname_id, petugas1_id, petugas2_id, pegawaimengetahui_id', 'numerical', 'integerOnly'=>true),
			array('totalharga, totalvolume', 'numerical'),
			array('instalasi_nama, ruangan_nama, noformulir, nostokopname, jenisstokopname, petugas1_nama, petugas2_nama, pegawaimengetahui_nama', 'length', 'max'=>50),
			array('petugas1_nip, petugas2_nip, pegawaimengetahui_nip', 'length', 'max'=>30),
			array('petugas1_noidentitas, petugas2_noidentitas, pegawaimengetahui_noidentitas', 'length', 'max'=>100),
			array('petugas1_gelardepan, petugas2_gelardepan, pegawaimengetahui_gelardepan', 'length', 'max'=>10),
			array('petugas1_gelarbelakang, petugas2_gelarbelakang, pegawaimengetahui_gelarbelakang', 'length', 'max'=>15),
			array('tglformulir, tglstokopname, isstokawal, keterangan_opname, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, formuliropname_id, tglformulir, noformulir, stokopname_id, tglstokopname, nostokopname, isstokawal, jenisstokopname, keterangan_opname, totalharga, totalvolume, petugas1_id, petugas1_nip, petugas1_noidentitas, petugas1_gelardepan, petugas1_nama, petugas1_gelarbelakang, petugas2_id, petugas2_nip, petugas2_noidentitas, petugas2_gelardepan, petugas2_nama, petugas2_gelarbelakang, pegawaimengetahui_id, pegawaimengetahui_nip, pegawaimengetahui_noidentitas, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'formuliropname_id' => 'Formulir Opname',
			'tglformulir' => 'Tanggal Formulir',
			'noformulir' => 'No. Formulir',
			'stokopname_id' => 'Stock Opname',
			'tglstokopname' => 'Tanggal Stock Opname',
			'nostokopname' => 'No. Stock Opname',
			'isstokawal' => 'Is Stok Awal',
			'jenisstokopname' => 'Jenis Stock Opname',
			'keterangan_opname' => 'Keterangan Opname',
			'totalharga' => 'Total Harga',
			'totalvolume' => 'Total Volume',
			'petugas1_id' => 'Petugas1',
			'petugas1_nip' => 'Petugas1 Nip',
			'petugas1_noidentitas' => 'Petugas1 Noidentitas',
			'petugas1_gelardepan' => 'Petugas1 Gelardepan',
			'petugas1_nama' => 'Petugas1 Nama',
			'petugas1_gelarbelakang' => 'Petugas1 Gelarbelakang',
			'petugas2_id' => 'Petugas2',
			'petugas2_nip' => 'Petugas2 Nip',
			'petugas2_noidentitas' => 'Petugas2 Noidentitas',
			'petugas2_gelardepan' => 'Petugas2 Gelardepan',
			'petugas2_nama' => 'Petugas2 Nama',
			'petugas2_gelarbelakang' => 'Petugas2 Gelarbelakang',
			'pegawaimengetahui_id' => 'Pegawaimengetahui',
			'pegawaimengetahui_nip' => 'Pegawaimengetahui Nip',
			'pegawaimengetahui_noidentitas' => 'Pegawaimengetahui Noidentitas',
			'pegawaimengetahui_gelardepan' => 'Pegawaimengetahui Gelardepan',
			'pegawaimengetahui_nama' => 'Pegawaimengetahui Nama',
			'pegawaimengetahui_gelarbelakang' => 'Pegawaimengetahui Gelarbelakang',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('formuliropname_id',$this->formuliropname_id);
		$criteria->compare('tglformulir',$this->tglformulir,true);
		$criteria->compare('noformulir',$this->noformulir,true);
		$criteria->compare('stokopname_id',$this->stokopname_id);
		$criteria->compare('tglstokopname',$this->tglstokopname,true);
		$criteria->compare('nostokopname',$this->nostokopname,true);
		$criteria->compare('isstokawal',$this->isstokawal);
		$criteria->compare('jenisstokopname',$this->jenisstokopname,true);
		$criteria->compare('keterangan_opname',$this->keterangan_opname,true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('totalvolume',$this->totalvolume);
		$criteria->compare('petugas1_id',$this->petugas1_id);
		$criteria->compare('petugas1_nip',$this->petugas1_nip,true);
		$criteria->compare('petugas1_noidentitas',$this->petugas1_noidentitas,true);
		$criteria->compare('petugas1_gelardepan',$this->petugas1_gelardepan,true);
		$criteria->compare('petugas1_nama',$this->petugas1_nama,true);
		$criteria->compare('petugas1_gelarbelakang',$this->petugas1_gelarbelakang,true);
		$criteria->compare('petugas2_id',$this->petugas2_id);
		$criteria->compare('petugas2_nip',$this->petugas2_nip,true);
		$criteria->compare('petugas2_noidentitas',$this->petugas2_noidentitas,true);
		$criteria->compare('petugas2_gelardepan',$this->petugas2_gelardepan,true);
		$criteria->compare('petugas2_nama',$this->petugas2_nama,true);
		$criteria->compare('petugas2_gelarbelakang',$this->petugas2_gelarbelakang,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimengetahui_nip',$this->pegawaimengetahui_nip,true);
		$criteria->compare('pegawaimengetahui_noidentitas',$this->pegawaimengetahui_noidentitas,true);
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}