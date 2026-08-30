<?php

/**
 * This is the model class for table "insidenrs_selainpasien_t".
 *
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'insidenrs_selainpasien_t':
 * @property integer $insidenrs_selainpasien_id
 * @property string $tgl_pelaporan
 * @property string $no_kejadian
 * @property integer $unitkerja_pelapor_id
 * @property string $tgl_kejadian
 * @property string $lokasikejadian
 * @property string $namakorban
 * @property integer $pegawai_mengetahuikejadian_id
 * @property string $uraiankejadian
 * @property string $jeniskejadian
 * @property string $cederaakibatkerja
 * @property string $penyakitakibatkerja
 * @property string $jeniscedera
 * @property string $bagianbadan_cedera
 * @property string $penyakityangtimbul
 * @property string $tindakanyangdiambil
 * @property string $kesimpulanpenyebabinsiden
 * @property string $rekomendasi
 * @property integer $pegawai_mengetahui1_id
 * @property integer $pegawai_mengetahui2_id
 * @property string $tglverifikasi_pelaporan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $update_loginpemakai_id
 */
class InsidenrsSelainpasienT extends CActiveRecord
{
        public $tanggal_awal, $tanggal_awal2, $tanggal_akhir, $tanggal_akhir2;
	public $tipeLapor, $tipeInsiden, $status_verifikasi;
        public $pelapor_nama, $unitkerja_pelapor_nama, $pegawai_mengetahuikejadian_nama, $pegawai_mengetahui1_nama, $pegawai_mengetahui2_nama;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InsidenrsSelainpasienT the static model class
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
		return 'insidenrs_selainpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pelapor_id, jeniscedera, jeniskejadian, uraiankejadian, tgl_pelaporan, unitkerja_pelapor_id, tgl_kejadian, lokasikejadian, namakorban, create_time, create_ruangan', 'required'),
			array('unitkerja_pelapor_id, pegawai_mengetahuikejadian_id, pegawai_mengetahui1_id, pegawai_mengetahui2_id, create_loginpemakai_id, create_ruangan, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('no_kejadian', 'length', 'max'=>25),
			array('lokasikejadian, jeniskejadian, jeniscedera', 'length', 'max'=>50),
			array('namakorban', 'length', 'max'=>100),
			array('cederaakibatkerja, penyakitakibatkerja, bagianbadan_cedera', 'length', 'max'=>300),
			array('uraiankejadian, penyakityangtimbul, tindakanyangdiambil, kesimpulanpenyebabinsiden, rekomendasi, tglverifikasi_pelaporan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('insidenrs_selainpasien_id, tgl_pelaporan, no_kejadian, unitkerja_pelapor_id, tgl_kejadian, lokasikejadian, namakorban, pegawai_mengetahuikejadian_id, uraiankejadian, jeniskejadian, cederaakibatkerja, penyakitakibatkerja, jeniscedera, bagianbadan_cedera, penyakityangtimbul, tindakanyangdiambil, kesimpulanpenyebabinsiden, rekomendasi, pegawai_mengetahui1_id, pegawai_mengetahui2_id, tglverifikasi_pelaporan, create_time, update_time, create_loginpemakai_id, create_ruangan, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
                    'pegawai_mengetahui1'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_mengetahui1_id'),
                    'pegawai_mengetahui2'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_mengetahui2_id'),
                    'pegawai_mengetahuikejadian'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_mengetahuikejadian_id'),
                    'unitkerja'=>array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_pelapor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'insidenrs_selainpasien_id' => 'Insidenrs Selainpasien',
			'tgl_pelaporan' => 'Tgl Pelaporan',
			'no_kejadian' => 'Nomor Kejadian',
			'unitkerja_pelapor_id' => 'Satuan Kerja',
			'tgl_kejadian' => 'Tgl Kejadian',
			'lokasikejadian' => 'Lokasi Kejadian',
			'namakorban' => 'Nama Korban',
			'pegawai_mengetahuikejadian_id' => 'Pegawai Mengetahuikejadian',
			'uraiankejadian' => 'Uraian Kejadian',
			'jeniskejadian' => 'Jenis Kejadian',
			'cederaakibatkerja' => 'Cedera Akibat Kerja',
			'penyakitakibatkerja' => 'Penyakit Akibat Kerja',
			'jeniscedera' => 'Jenis Cedera',
			'bagianbadan_cedera' => 'Bagian Badan yang Cedera',
			'penyakityangtimbul' => 'Penyakit yang Timbul',
			'tindakanyangdiambil' => 'Tindakan yang Diambil',
			'kesimpulanpenyebabinsiden' => 'Kesimpulan Penyebab Insiden',
			'rekomendasi' => 'Rekomendasi',
			'pegawai_mengetahui1_id' => 'Pegawai Mengetahui1',
			'pegawai_mengetahui2_id' => 'Pegawai Mengetahui2',
			'tglverifikasi_pelaporan' => 'Tglverifikasi Pelaporan',
                        'pelapor_id' => 'Pelapor',
                        'pelapor_nama' => 'Nama Pelapor',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('insidenrs_selainpasien_id',$this->insidenrs_selainpasien_id);
		$criteria->compare('tgl_pelaporan',$this->tgl_pelaporan,true);
		$criteria->compare('no_kejadian',$this->no_kejadian,true);
		$criteria->compare('unitkerja_pelapor_id',$this->unitkerja_pelapor_id);
		$criteria->compare('tgl_kejadian',$this->tgl_kejadian,true);
		$criteria->compare('lokasikejadian',$this->lokasikejadian,true);
		$criteria->compare('namakorban',$this->namakorban,true);
		$criteria->compare('pegawai_mengetahuikejadian_id',$this->pegawai_mengetahuikejadian_id);
		$criteria->compare('uraiankejadian',$this->uraiankejadian,true);
		$criteria->compare('jeniskejadian',$this->jeniskejadian,true);
		$criteria->compare('cederaakibatkerja',$this->cederaakibatkerja,true);
		$criteria->compare('penyakitakibatkerja',$this->penyakitakibatkerja,true);
		$criteria->compare('jeniscedera',$this->jeniscedera,true);
		$criteria->compare('bagianbadan_cedera',$this->bagianbadan_cedera,true);
		$criteria->compare('penyakityangtimbul',$this->penyakityangtimbul,true);
		$criteria->compare('tindakanyangdiambil',$this->tindakanyangdiambil,true);
		$criteria->compare('kesimpulanpenyebabinsiden',$this->kesimpulanpenyebabinsiden,true);
		$criteria->compare('rekomendasi',$this->rekomendasi,true);
		$criteria->compare('pegawai_mengetahui1_id',$this->pegawai_mengetahui1_id);
		$criteria->compare('pegawai_mengetahui2_id',$this->pegawai_mengetahui2_id);
		$criteria->compare('tglverifikasi_pelaporan',$this->tglverifikasi_pelaporan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	/**
	 * Pencarian Informasi Laporan Insiden Selain Pasien
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria = new CDbCriteria();
            $criteria->select = "t.*, t.insidenrs_selainpasien_id, t.pelapor_id, pelapor.nama_pegawai";
            $criteria->join = " LEFT JOIN pegawai_m pelapor ON pelapor.pegawai_id = t.pelapor_id";
            
            if ($this->tipeLapor == true) {
                $criteria->addBetweenCondition('DATE(t.tgl_pelaporan)', $this->tanggal_awal, $this->tanggal_akhir);
            }
            if ($this->tipeInsiden == true) {
                $criteria->addBetweenCondition('DATE(t.tgl_kejadian)', $this->tanggal_awal2, $this->tanggal_akhir2);
            }
            if (!empty($this->status_verifikasi == 'Belum')){
                $criteria->addCondition("t.tglverifikasi_pelaporan IS NULL");
            }else if (!empty($this->status_verifikasi == 'Sudah')){
                $criteria->addCondition("t.tglverifikasi_pelaporan IS NOT NULL");
            }
            $criteria->compare('lower(pelapor.nama_pegawai)', strtolower($this->pelapor_nama), true);
            $criteria->compare('lower(t.namakorban)', strtolower($this->namakorban), true);
            $criteria->compare('lower(t.jeniskejadian)', strtolower($this->jeniskejadian), true);
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	}    
        
	/**
	 * Pencarian Informasi Laporan Insiden Selain Pasien
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria = new CDbCriteria();
            $criteria->select = "t.*, t.insidenrs_selainpasien_id, t.pelapor_id, pelapor.nama_pegawai";
            $criteria->join = " LEFT JOIN pegawai_m pelapor ON pelapor.pegawai_id = t.pelapor_id";
            
            if ($this->tipeLapor == true) {
                $criteria->addBetweenCondition('DATE(t.tgl_pelaporan)', $this->tanggal_awal, $this->tanggal_akhir);
            }
            if ($this->tipeInsiden == true) {
                $criteria->addBetweenCondition('DATE(t.tgl_kejadian)', $this->tanggal_awal2, $this->tanggal_akhir2);
            }
            if (!empty($this->status_verifikasi == 'Belum')){
                $criteria->addCondition("t.tglverifikasi_pelaporan IS NULL");
            }else if (!empty($this->status_verifikasi == 'Sudah')){
                $criteria->addCondition("t.tglverifikasi_pelaporan IS NOT NULL");
            }
            $criteria->compare('lower(pelapor.nama_pegawai)', strtolower($this->pelapor_nama), true);
            $criteria->compare('lower(t.namakorban)', strtolower($this->namakorban), true);
            $criteria->compare('lower(t.jeniskejadian)', strtolower($this->jeniskejadian), true);
            $criteria->limit = -1;
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	}    

}