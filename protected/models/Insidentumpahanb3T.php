<?php

/**
 * This is the model class for table "insidentumpahanb3_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'insidentumpahanb3_t':
 * @property integer $insidentumpahanb3_id
 * @property string $tgl_pelaporan
 * @property string $no_dokumen
 * @property string $no_revisi
 * @property integer $mengetahuipegawai_id
 * @property integer $pelapor_id
 * @property string $nomorindukpegawai
 * @property string $saksi1
 * @property string $saksi2
 * @property string $saksi3
 * @property string $tgl_kejadian
 * @property integer $unitkerja_kejadian_id
 * @property string $lokasikejadian
 * @property string $kronologistumpahanb3
 * @property string $penyebabtumpahanb3
 * @property string $kerugiantumpahanb3
 * @property string $upayayangdilakukan
 * @property string $usulanperbaikan
 * @property string $tglverifikasi_pelaporan
 * @property boolean $is_revisi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RevisiInsidentumpahanb3R[] $revisiInsidentumpahanb3Rs
 */
class Insidentumpahanb3T extends CActiveRecord
{
        public $pelapor_nama, $mengetahuipegawai_nama, $unitkerja_kejadian_nama, 
            $tanggal_awal, $tanggal_akhir, $tanggal_awal2, $tanggal_akhir2, 
                $status_verifikasi, $tipeLapor, $tipeInsiden, $namaLengkap, $namaunitkerja, $mengetahuipegawai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Insidentumpahanb3T the static model class
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
		return 'insidentumpahanb3_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_dokumen, no_revisi, nomorindukpegawai, tgl_pelaporan, mengetahuipegawai_id, pelapor_id, tgl_kejadian, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('mengetahuipegawai_id, pelapor_id, unitkerja_kejadian_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('no_dokumen', 'length', 'max'=>25),
			array('no_revisi', 'length', 'max'=>10),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('saksi1, saksi2, saksi3', 'length', 'max'=>100),
			array('lokasikejadian', 'length', 'max'=>150),
			array('kronologistumpahanb3, penyebabtumpahanb3, kerugiantumpahanb3, upayayangdilakukan, usulanperbaikan, tglverifikasi_pelaporan, is_revisi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('insidentumpahanb3_id, tgl_pelaporan, no_dokumen, no_revisi, mengetahuipegawai_id, pelapor_id, nomorindukpegawai, saksi1, saksi2, saksi3, tgl_kejadian, unitkerja_kejadian_id, lokasikejadian, kronologistumpahanb3, penyebabtumpahanb3, kerugiantumpahanb3, upayayangdilakukan, usulanperbaikan, tglverifikasi_pelaporan, is_revisi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'revisiInsidentumpahanb3Rs' => array(self::HAS_MANY, 'RevisiInsidentumpahanb3R', 'insidentumpahanb3_id'),
                        'pegawai_pelapor'=>array(self::BELONGS_TO, 'PegawaiM', 'pelapor_id'),
                        'pegawai_mengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'mengetahuipegawai_id'),
                        'unitkerja'=>array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_kejadian_id'),
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'insidentumpahanb3_id' => 'Insidentumpahanb3',
			'tgl_pelaporan' => 'Tgl Pelaporan',
			'no_dokumen' => 'Nomor Pelaporan',
			'no_revisi' => 'Nomor Revisi',
			'mengetahuipegawai_id' => 'Mengetahuipegawai',
			'pelapor_id' => 'Pelapor',
			'nomorindukpegawai' => 'NIP',
			'saksi1' => 'Saksi 1',
			'saksi2' => 'Saksi 2',
			'saksi3' => 'Saksi 3',
			'tgl_kejadian' => 'Tgl Kejadian',
			'unitkerja_kejadian_id' => 'Unitkerja Kejadian',
			'lokasikejadian' => 'Lokasi Kejadian',
			'kronologistumpahanb3' => 'A. Kronologis Tumpahan B3',
			'penyebabtumpahanb3' => 'B. Penyebab Tumpahan B3',
			'kerugiantumpahanb3' => 'C. Kerugian/Akibat Tumpahan B3',
			'upayayangdilakukan' => 'D. Upaya yang Sudah Dilakukan',
			'usulanperbaikan' => 'E. Usulan Perbaikan',
			'tglverifikasi_pelaporan' => 'Tglverifikasi Pelaporan',
			'is_revisi' => 'Is Revisi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('insidentumpahanb3_id',$this->insidentumpahanb3_id);
		$criteria->compare('tgl_pelaporan',$this->tgl_pelaporan,true);
		$criteria->compare('no_dokumen',$this->no_dokumen,true);
		$criteria->compare('no_revisi',$this->no_revisi,true);
		$criteria->compare('mengetahuipegawai_id',$this->mengetahuipegawai_id);
		$criteria->compare('pelapor_id',$this->pelapor_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('saksi1',$this->saksi1,true);
		$criteria->compare('saksi2',$this->saksi2,true);
		$criteria->compare('saksi3',$this->saksi3,true);
		$criteria->compare('tgl_kejadian',$this->tgl_kejadian,true);
		$criteria->compare('unitkerja_kejadian_id',$this->unitkerja_kejadian_id);
		$criteria->compare('lokasikejadian',$this->lokasikejadian,true);
		$criteria->compare('kronologistumpahanb3',$this->kronologistumpahanb3,true);
		$criteria->compare('penyebabtumpahanb3',$this->penyebabtumpahanb3,true);
		$criteria->compare('kerugiantumpahanb3',$this->kerugiantumpahanb3,true);
		$criteria->compare('upayayangdilakukan',$this->upayayangdilakukan,true);
		$criteria->compare('usulanperbaikan',$this->usulanperbaikan,true);
		$criteria->compare('tglverifikasi_pelaporan',$this->tglverifikasi_pelaporan,true);
		$criteria->compare('is_revisi',$this->is_revisi);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

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
            $criteria->select = "t.*, t.insidentumpahanb3_id, t.pelapor_id, pelapor.nama_pegawai";
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
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	}
        
        /**
	 * Pencarian Informasi Laporan Insiden Selain Pasien
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrintInformasi()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria = new CDbCriteria();
            $criteria->select = "t.*, t.insidentumpahanb3_id, t.pelapor_id, pelapor.nama_pegawai";
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
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination' => false,
            ));
	}
}