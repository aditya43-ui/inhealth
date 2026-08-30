<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Elham Budianto <elhambudianto@.com>
 * @website	<https://piindonesia.co.id>
 * @package     application.models
 * @category model
 * 
 * This is the model class for table "daftardonasi_t".
 *
 * The followings are the available columns in table 'daftardonasi_t':
 * @property integer $daftardonasi_id
 * @property integer $pendonor_id
 * @property string $no_formulir
 * @property integer $nama_petugas_id
 * @property string $ruangan_rekruitmen_id
 * @property string $keterangan_donasi
 * @property integer $donasi_ke
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $waktu_pendaftaran
 *
 * The followings are the available model relations:
 * @property PendonorM $pendonor
 */
class DaftardonasiT extends CActiveRecord
{
        public $ruangrekrutmen_nama;
        public $nama_lengkap;
        public $no_pendonor;
        public $gol_darah;
        public $rhesus;
        public $tgllahir;
        public $is_jenis;
        public $tgl_awal,$tgl_akhir;
        public $observasipendonor_id;
        public $kecamatan;
        public $nama_jenis;
        public $ruangan_rekruitmen_nama;
        
        //untuk grafik
        public $jumlah,$data,$type;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DaftardonasiT the static model class
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
		return 'daftardonasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendonor_id, no_formulir, nama_petugas_id, donasi_ke, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_rekruitmen_id, pendonor_id, nama_petugas_id, donasi_ke, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('no_formulir', 'length', 'max'=>50),
			array('ruangan_rekruitmen_id', 'length', 'max'=>255),
			array('pembuatevent,gol_darah, rhesus, status,waktu_pendaftaran,keterangan_donasi, update_time,bataldonordarah, lokasi_rekruitmen', 'safe'),			
			array('daftardonasi_id, pendonor_id, no_formulir, nama_petugas_id, ruangan_rekruitmen_id, keterangan_donasi, donasi_ke, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, lokasi_rekruitmen', 'safe', 'on'=>'search'),
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
			'pendonor' => array(self::BELONGS_TO, 'PendonorM', 'pendonor_id'),
                        'ruangrekrutmen' => array(self::BELONGS_TO,'RuanganM','ruangan_rekruitmen_id')                       ,
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'daftardonasi_id' => 'Daftardonasi',
			'pendonor_id' => 'Pendonor',
			'no_formulir' => 'No Formulir',
			'nama_petugas_id' => 'Nama Petugas',
			'ruangan_rekruitmen_id' => 'Ruangan Rekruitmen',
			'keterangan_donasi' => 'Keterangan Donasi',
			'donasi_ke' => 'Donasi Ke',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'waktu_pendaftaran' => 'Waktu Pendaftaran',
            'tampilGrafik'=>'',
            'lokasi_rekruitmen' => 'Lokasi Rekruitmen' 
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()	 
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->daftardonasi_id)){
			$criteria->addCondition('daftardonasi_id = '.$this->daftardonasi_id);
		}
		if(!empty($this->pendonor_id)){
			$criteria->addCondition('pendonor_id = '.$this->pendonor_id);
		}
		$criteria->compare('LOWER(no_formulir)',strtolower($this->no_formulir),true);
		if(!empty($this->nama_petugas_id)){
			$criteria->addCondition('nama_petugas_id = '.$this->nama_petugas_id);
		}
                if(!empty($this->nama_petugas_id)){
			$criteria->addCondition('ruangan_rekruitmen_id = '.$this->ruangan_rekruitmen_id);
		}
		$criteria->compare('LOWER(keterangan_donasi)',strtolower($this->keterangan_donasi),true);
		if(!empty($this->donasi_ke)){
			$criteria->addCondition('donasi_ke = '.$this->donasi_ke);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        /**
         * pencarian yang digunakan untuk memfilter printout
         * @return \CActiveDataProvider
         */
        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }	
        
        /**
         * fungsi pencarian data pendonor dari seleksi
         * @return \CActiveDataProvider
         */
        public function searchDataPendonorDariSeleksi(){
            $cri=new CDbCriteria();
            $cri->group = " t.*, p.nama_lengkap, p.no_pendonor, p.gol_darah, p.rhesus, t.daftardonasi_id, jen.nama_jenis, kan.nomorbarcode_utama, kan.nomorbarcode_sample  ";
            $cri->select = $cri->group;
            $cri->join =  " JOIN pendonor_m p ON p.pendonor_id = t.pendonor_id "
                        . " JOIN seleksipendonor_t s ON s.daftardonasi_id = t.daftardonasi_id "
                        . " LEFT JOIN kantongdarah_t kan ON kan.daftarpendonor_id = t.daftardonasi_id "
                        . " LEFT JOIN jeniskantongdarah_m jen ON jen.jeniskantongdarah_id = kan.jeniskantongdarah_id ";
            $cri->compare('LOWER(no_formulir)', strtolower($this->no_formulir));
            $cri->compare('LOWER(no_pendonor)', strtolower($this->no_pendonor));
            $cri->compare('LOWER(p.nama_lengkap)', strtolower($this->nama_lengkap),true);
            $cri->addCondition(" s.status_pendonor = '".Params::STATUS_SELEKSI_DITERIMA."' ");            
            //$cri->addCondition(" kan.daftarpendonor_id is null ");
            if (!empty($this->gol_darah)){
                $cri->addCondition(" p.gol_darah = '".$this->gol_darah."' ");
            }
            $cri->limit=10; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$cri,
            ));
        }
        
        /**
         * Mencari data grafik untuk laporan produksi komponen darah
         * @return \CActiveDataProvider
         */
        public function searchGrafik() {
            $jam_awal = $this->tgl_awal.' 00:00:00';
            $jam_akhir = $this->tgl_akhir.' 23:59:59';
            $criteria = new CDbCriteria();
            if($this->is_jenis == 1){
                $criteria->select = "count(info.komponendarah_id) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))  as data";
                $criteria->join = "LEFT JOIN infokantongdarah_v as info ON info.daftardonasi_id = t.daftardonasi_id ";
                $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))";
                $criteria->order = "data ASC";
                $criteria->addCondition("info.komponendarah_id = 7");
                $criteria->addCondition('info.periksakomponendarah_id IS NOT NULL');
                $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
            }else if ($this->is_jenis == 2){
                $criteria->select = "count(info.komponendarah_id) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))  as data";
                $criteria->join = "LEFT JOIN infokantongdarah_v as info ON info.daftardonasi_id = t.daftardonasi_id ";
                $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))";
                $criteria->order = "data ASC";
                $criteria->addCondition("info.komponendarah_id = 8 OR info.komponendarah_id = 10");
                $criteria->addCondition('info.periksakomponendarah_id IS NOT NULL');
                $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
            }else if ($this->is_jenis == 3){
                $criteria->select = "count(info.komponendarah_id) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))  as data";
                $criteria->join = "LEFT JOIN infokantongdarah_v as info ON info.daftardonasi_id = t.daftardonasi_id ";
                $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))";
                $criteria->order = "data ASC";
                $criteria->addCondition("info.komponendarah_id = 12 OR info.komponendarah_id = 14");
                $criteria->addCondition('info.periksakomponendarah_id IS NOT NULL');
                $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
            }else if ($this->is_jenis == 4){
                $criteria->select = "count(info.komponendarah_id) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))  as data";
                $criteria->join = "LEFT JOIN infokantongdarah_v as info ON info.daftardonasi_id = t.daftardonasi_id ";
                $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))";
                $criteria->order = "data ASC";
                $criteria->addCondition("info.komponendarah_id = 9 OR info.komponendarah_id = 11 OR info.komponendarah_id = 13");
                $criteria->addCondition('info.periksakomponendarah_id IS NOT NULL');
                $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
            }else if ($this->is_jenis == 5){
                $criteria->select = "count(info.komponendarah_id) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))  as data";
                $criteria->join = "LEFT JOIN infokantongdarah_v as info ON info.daftardonasi_id = t.daftardonasi_id ";
                $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))";
                $criteria->order = "data ASC";
                $criteria->addCondition("info.komponendarah_id = 15");
                $criteria->addCondition('info.periksakomponendarah_id IS NOT NULL');
                $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
            }else if($this->is_jenis == 6){
                $criteria->select = "SUM(COALESCE(CASE WHEN periksa.komponen_wb = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0) "
                                    . "+ COALESCE(CASE WHEN periksa.komponen_prc = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0) "
                                    . "+ COALESCE(CASE WHEN periksa.komponen_ffp = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0)"
                                    . "+ COALESCE(CASE WHEN periksa.komponen_tc = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0)"
                                    . "+ COALESCE(CASE WHEN periksa.komponen_pcr = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0)"
                                    . ") as jumlah , "
                                    . "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))  as data";
                $criteria->join = "LEFT JOIN infokantongdarah_v as info ON info.daftardonasi_id = t.daftardonasi_id "
                                . "LEFT JOIN periksakomponendarah_t as periksa ON periksa.kantongdarah_id = info.kantongdarah_id";
                $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,'   ',date_part('year', t.waktu_pendaftaran))";
                $criteria->order = "data ASC";
                $criteria->addCondition("periksa.komponen_wb = 'GAGAL PRODUKSI' OR periksa.komponen_prc = 'GAGAL PRODUKSI' OR periksa.komponen_ffp = 'GAGAL PRODUKSI' OR periksa.komponen_tc = 'GAGAL PRODUKSI' OR periksa.komponen_pcr = 'GAGAL PRODUKSI'");
                $criteria->addCondition('info.periksakomponendarah_id IS NOT NULL');
                $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
            }
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
}