<?php

/**
 * This is the model class for table "pejabatpengadaan_m".
 * 
 * @author  Andyka Putra <andykaputra@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author  Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'pejabatpengadaan_m':
 * @property integer $pejabatpengadaan_id
 * @property integer $pegawai_id
 * @property string $jabatan_pengadaan
 * @property boolean $pejabatpengadaan_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PejabatpengadaandetM[] $pejabatpengadaandetMs
 */
class PejabatpengadaanM extends CActiveRecord
{
    public $nama_pegawai, $pegawai_nama, $unitkerja_id, $nomorindukpegawai, $namaLengkap, $jabatan_nama, $namaunitkerja;
    public $default, $nama_lengkap;
    public $anggaran_nama;
    public $temp_file;
    public $instalasi_id, $instalasi_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PejabatpengadaanM the static model class
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
		return 'pejabatpengadaan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodeanggaran_id, pegawai_id, jabatan_pengadaan, pejabatpengadaan_aktif, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jabatan_pengadaan', 'length', 'max'=>50),
			array('file_sk, periodeanggaran_id, no_sk,tgl_sk,update_time,kode_dokumen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('no_sk,kode_dokumen,tgl_sk,pejabatpengadaan_id, pegawai_id, jabatan_pengadaan, pejabatpengadaan_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pejabatpengadaandetMs' => array(self::HAS_MANY, 'PejabatpengadaandetM', 'pejabatpengadaan_id'),
                    'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'periodeanggaran' => array(self::BELONGS_TO, 'PeriodeanggaranK', 'periodeanggaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pejabatpengadaan_id' => 'Pejabatpengadaan',
			'no_sk' => 'No SK',
                        'kode_dokumen' => 'Kode Dokumen',
                        'tgl_sk' => 'Tanggal SK',
                        'pegawai_id' => 'Pegawai',
			'jabatan_pengadaan' => 'Jabatan Pengadaan',
			'pejabatpengadaan_aktif' => 'Pejabatpengadaan Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                        'periodeanggaran_id' => 'Periode'
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
                $criteria->select = " t.*, pa.anggaran_nama ";
                $criteria->join = " LEFT JOIN periodeanggaran_k pa ON pa.periodeanggaran_id = t.periodeanggaran_id ";
		$criteria->compare('t.pejabatpengadaan_id',$this->pejabatpengadaan_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.jabatan_pengadaan',$this->jabatan_pengadaan,true);
                $criteria->compare('t.pejabatpengadaan_aktif',isset($this->pejabatpengadaan_aktif)?$this->pejabatpengadaan_aktif:true);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.create_ruangan',$this->create_ruangan);
                if (!empty($this->periodeanggaran_id)){
                    $criteria->addCondition(" t.periodeanggaran_id = ".$this->periodeanggaran_id." ");
                }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Pencarian Dialog Pejabat Pengadaan Filter Berdasarkan jabatan_pengadaan = "Pejabat Pengadaan"
         * @return \CActiveDataProvider
         */
        public function searchDialog(){
            $criteria=new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*, unitkerja_m.namaunitkerja";
            $criteria->join = "LEFT JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "LEFT JOIN unitkerja_m on pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->addCondition("jabatan_pengadaan ilike '%Pejabat Pengadaan%'");
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->compare('pejabatpengadaan_id',$this->pejabatpengadaan_id);
            $criteria->compare('pegawai_id',$this->pegawai_id);
            $criteria->compare('jabatan_pengadaan',$this->jabatan_pengadaan,true);
            $criteria->compare('pejabatpengadaan_aktif',isset($this->pejabatpengadaan_aktif)?$this->pejabatpengadaan_aktif:true);
            $criteria->compare('create_time',$this->create_time,true);
            $criteria->compare('update_time',$this->update_time,true);
            $criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
            $criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
            $criteria->compare('create_ruangan',$this->create_ruangan);
            $criteria->order = "nama_pegawai asc";
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        /**
         * Pencarian Dialog Pejabat Pengadaan PPTK
         * @return \CActiveDataProvider
         */
        public function searchDialogPPTK() {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->addCondition("jabatan_pengadaan = 'Pejabat Pelaksana Teknis Kegiatan'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE and pegawai_aktif = true');
            $criteria->order = "nama_pegawai asc";
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }

        /**
         * Pencarian Dialog Pejabat Pengadaan PJK
         * @return \CActiveDataProvider
         */
        public function searchDialogPJK() {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->addCondition("jabatan_pengadaan = 'Penanggung Jawab Kegiatan'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');
            $criteria->order = "nama_pegawai asc";
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
         /**
         * Pencarian Dialog Pejabat Pengadaan PJK
         * @return \CActiveDataProvider
         */
        public function searchDialogPejabat() {
            $criteria = new CDbCriteria;
            if (!empty($this->default)){
                $criteria->addCondition(" pejabatpengadaan_id is null ");
            }
            $criteria->select = "p.pegawai_id, CONCAT(p.gelardepan,' ',p.nama_pegawai,', ',glr.gelarbelakang_nama) as nama_lengkap, j.jabatan_nama, u.namaunitkerja, p.nomorindukpegawai";
            $criteria->join = " JOIN pegawai_m p ON t.pegawai_id = p.pegawai_id "
                            . " LEFT JOIN gelarbelakang_m glr ON glr.gelarbelakang_id = p.gelarbelakang_id "
                            . " LEFT JOIN jabatan_m j ON p.jabatan_id = j.jabatan_id "
                            . " LEFT JOIN unitkerja_m u ON p.unitkerja_id = u.unitkerja_id ";
            $criteria->compare('LOWER(p.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(p.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(j.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(u.namaunitkerja)',strtolower($this->namaunitkerja),true);
            if (!empty($this->jabatan_pengadaan)){
                $criteria->addCondition("jabatan_pengadaan = '".$this->jabatan_pengadaan."'");
            }
            if (!empty($this->periodeanggaran_id)){
                $criteria->addCondition("periodeanggaran_id = '".$this->periodeanggaran_id."'");
            }
            
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Pencarian Dialog Tim Teknis
         * @return \CActiveDataProvider
         */
        public function searchDialogTimteknis() {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->addCondition("jabatan_pengadaan = 'Tim Teknis'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Pencarian Dialog PjPHP
         * @return \CActiveDataProvider
         */
        public function searchDialogPJPHP() {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->addCondition("jabatan_pengadaan = 'Pejabat Pemeriksa Hasil Pekerjaan'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Pencarian Dialog PPHP
         * @return \CActiveDataProvider
         */
        public function searchDialogPPHP() {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->addCondition("jabatan_pengadaan = 'Panitia Pemeriksa Hasil Pekerjaan'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Pencarian Dialog PPHP/PJPHP
         * @return \CActiveDataProvider
         */
        public function searchDialogPPHPdanPJPHP() {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->addCondition("jabatan_pengadaan = 'Panitia Pemeriksa Hasil Pekerjaan' OR jabatan_pengadaan = 'Pejabat Pemeriksa Hasil Pekerjaan'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');
            
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Pencarian Dialog KPA
         * @return \CActiveDataProvider
         */
//        public function searchDialogKPA() {
//            $criteria = new CDbCriteria;
//            $criteria->select = "t.*, pegawai_m.*";
//            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
//                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
//                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
//            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
//            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
//            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
//            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
//            $criteria->addCondition("jabatan_pengadaan = 'KPA'");
//            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');
//
//            return new CActiveDataProvider($this, array(
//                'criteria' => $criteria,
//            ));
//        }
        
        /**
         * Pencarian Dialog PPK
         * @return \CActiveDataProvider
         */
        public function searchDialogPPK() {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->addCondition("jabatan_pengadaan = '".Params::JABATAN_PENGADAAN_PPK."'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE and pegawai_aktif = true');
            $criteria->order = "nama_pegawai asc";
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Pencarian Dialog KPA
         * @return \CActiveDataProvider
         */
        public function searchDialogKPA() {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->compare('unitkerja_m.unitkerja_id',$this->unitkerja_id);
            $criteria->addCondition("jabatan_pengadaan = '".Params::JABATAN_PENGADAAN_KPA."'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE and pegawai_aktif = true');
            $criteria->order = "nama_pegawai asc";
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Pencarian Dialog PA
         * @return \CActiveDataProvider
         */
        public function searchDialogPA() {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)',strtolower($this->jabatan_nama),true);
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->compare('unitkerja_m.unitkerja_id',$this->unitkerja_id,true);
            $criteria->addCondition("jabatan_pengadaan = '".Params::JABATAN_PENGADAAN_PA."'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE and pegawai_aktif = true');
            $criteria->order = "nama_pegawai asc";
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
}