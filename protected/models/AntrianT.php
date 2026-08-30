<?php

/**
 * This is the model class for table "antrian_t".
 *
 * The followings are the available columns in table 'antrian_t':
 * @property integer $antrian_id
 * @property integer $ruangan_id
 * @property integer $carabayar_id
 * @property integer $pendaftaran_id
 * @property integer $profilrs_id
 * @property string $tglantrian
 * @property string $noantrian
 * @property string $statuspasien
 * @property string $carabayar_loket
 * @property boolean $panggil_flaq
 * @property integer $loket_id
 *
 * The followings are the available model relations:
 * @property CarabayarM $carabayar
 * @property PendaftaranT $pendaftaran
 * @property ProfilrumahsakitM $profilrs
 * @property RuanganM $ruangan
 * @property PendaftaranT[] $pendaftaranTs
 */
class AntrianT extends CActiveRecord
{
        public $default, $loket_singkatan;
        public $ruangan_nama, $modelantrian_nama, $modelantrian_singkatan;
        public $ruangan_singkatan, $loket_nama;
        public $katakunci;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianT the static model class
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
		return 'antrian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, profilrs_id, tglantrian, noantrian', 'required'),
			array('ruangan_id, carabayar_id, pendaftaran_id, profilrs_id, loket_id, modelantrian_id', 'numerical', 'integerOnly'=>true),
			array('noantrian', 'length', 'max'=>6),
			array('statuspasien, carabayar_loket', 'length', 'max'=>50),
			array('jam_panggil, status_barcode, barcode, jenis_kunjungan, no_rekam_medik, nama_pasien, nama_pj, alasan_fasttrack, tglakandilayani, panggil_flaq,carabayar_id,pegawai_id, tglpanggil', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('antrian_id, ruangan_id, carabayar_id, pendaftaran_id, profilrs_id, tglantrian, noantrian, statuspasien, carabayar_loket, panggil_flaq, loket_id, tglpanggil', 'safe', 'on'=>'search'),
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
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'ubahruangan' => array(self::BELONGS_TO, 'RuanganM', 'ubah_ruangan_id'),
			'loket' => array(self::BELONGS_TO, 'LoketM', 'loket_id'),
			'pendaftaranTs' => array(self::HAS_MANY, 'PendaftaranT', 'antrian_id'),
            'modelantrian' => array(self::BELONGS_TO, 'ModelantrianM', 'modelantrian_id'),
            'ubahmodelantrian' => array(self::BELONGS_TO, 'ModelantrianM', 'ubah_modelantrian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'antrian_id' => 'Antrian',
			'ruangan_id' => 'Ruangan Tujuan',
			'carabayar_id' => 'Jenis Penjamin',
			'pendaftaran_id' => 'Pendaftaran',
			'profilrs_id' => 'Profilrs',
			'tglantrian' => 'Tanggal Antrian',
			'noantrian' => 'No. Antrian',
			'statuspasien' => 'Status Pasien',
			'carabayar_loket' => 'Cara Bayar Loket',
			'panggil_flaq' => 'Panggil Flaq',
			'loket_id' => 'Loket',
            'ruangan_nama' => 'Poliklinik',
            'modelantrian_id' => 'Model Antrian'
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
                if (!empty($this->default)){
                    $criteria->addCondition("t.antrian_id IS NULL");
                }
                if (!empty($this->tglantrian)){
                    $criteria->addCondition(" DATE(t.tglantrian) = '".$this->tglantrian."' ");
                }
		
                $criteria->compare('LOWER(t.noantrian)',strtolower($this->noantrian),true);
		$criteria->compare('LOWER(t.statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(t.carabayar_loket)',strtolower($this->carabayar_loket),true);
                $criteria->compare('(t.barcode)',($this->barcode));
                $criteria->compare('LOWER(t.jenis_kunjungan)',strtolower($this->jenis_kunjungan));
                

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

    public function getModelAntriansKasir($modelantrian_id = null){
        $data = array();
        $criteria = new CDbCriteria();
        if (!empty($modelantrian_id)){
            $criteria->addCondition("modelantrian_id = ".$modelantrian_id);
        }
        $criteria->addCondition("modelantrian_aktif = TRUE");
        $criteria->order = "modelantrian_nama ASC";
        $modLoketsAlpha = ModelantrianM::model()->findAll($criteria);
        $modLokets = array();

        foreach ($modLoketsAlpha as $item) {
            $det = LoketM::model()->findByAttributes(array(
                'modelantrian_id'=>$item->modelantrian_id,
                'iskasir'=>true,
            ));
            if (!empty($det)) {
                $modLokets[] = $item;
            }
        }

        if(count((array)$modLokets) > 0){
            return $modLokets;
        }else{
            return array();
        }
    }


    public function criteriaSearchRiwayat()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria=new CDbCriteria;
            if (!empty($this->default)){
                $criteria->addCondition("t.antrian_id IS NULL");
            }
            if (!empty($this->tglantrian)){
                $criteria->addCondition(" DATE(t.tglantrian) = '".$this->tglantrian."' ");
            }
            if (!empty($this->default)){
                $criteria->addCondition("t.antrian_id IS NULL");
            }

            $criteria->compare('LOWER(t.noantrian)',strtolower($this->noantrian),true);
            $criteria->compare('LOWER(t.statuspasien)',strtolower($this->statuspasien),true);
            $criteria->compare('LOWER(t.carabayar_loket)',strtolower($this->carabayar_loket),true);
            $criteria->compare('(t.barcode)',($this->barcode));
            $criteria->compare('LOWER(t.jenis_kunjungan)',strtolower($this->jenis_kunjungan));


            return $criteria;
    }
    
    public function searchRiwayatPanggil()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id  
            JOIN modelantrian_m m ON m.modelantrian_id = t.modelantrian_id 
        ";
        $criteria->select = [
            't.*',
            'r.ruangan_nama',
            "CONCAT(r.ruangan_singkatan,'-',t.noantrian) as noantrian",
            "CONCAT(m.modelantrian_singkatan,'-',t.noantrian) as noantrians",
            "m.modelantrian_nama"
        ];
        $criteria->addCondition("DATE(tglantrian) = '".date('Y-m-d')."' AND pendaftaran_id IS NULL  ");


            $criteria->compare("t.barcode", $this->barcode);
            $criteria->compare("t.ruangan_id", $this->ruangan_id);
            $criteria->compare("t.jenis_kunjungan", $this->jenis_kunjungan);
            $criteria->compare("t.status_barcode", $this->status_barcode);
            $criteria->compare("t.loket_id", $this->loket_id);
            $criteria->compare("t.modelantrian_id", $this->modelantrian_id);
            $criteria->compare("t.jam_panggil::text", $this->jam_panggil, true);
            $criteria->compare("LOWER(r.ruangan_nama)", strtolower($this->ruangan_nama), true);
            $criteria->compare("LOWER(m.modelantrian_nama)", strtolower($this->modelantrian_nama), true);

            if (!empty($this->default)) {
                $criteria->addCondition("t.antrian_id IS NULL");
            }
            // if (!empty($this->noantrian)) {
            //     $criteria->addCondition(" CONCAT(r.ruangan_singkatan,'-',t.noantrian)  ilike '%" . $this->noantrian . "%' ");
            // }
            // if (!empty($this->noantrian2)) {
            //     $criteria->addCondition(" CONCAT(m.modelantrian_singkatan,'-',t.noantrian)  ilike '%" . $this->noantrian2 . "%' ");
            // }
            if(!empty($this->modelantrian_id == 1)){
             
            if (!empty($this->noantrians)) {
                $criteria->addCondition(" CONCAT(m.modelantrian_singkatan,'-',t.noantrian)  ilike '%" . $this->noantrians . "%' ");
            }
            }else if (!empty($this->modelantrian_id == 2)){
                if (!empty($this->noantrian)) {
                    $criteria->addCondition(" CONCAT(r.ruangan_singkatan,'-',t.noantrian)  ilike '%" . $this->noantrian . "%' ");
                }
            }else{
                if (!empty($this->noantrian)) {
                    $criteria->addCondition(" CONCAT(r.ruangan_singkatan,'-',t.noantrian)  ilike '%" . $this->noantrian . "%' ");
                }

            }
            $criteria->addCondition(" status_panggil != '" . ParamsConst::STATUSPANGGIL_ANTRIAN_SELESAI . "' ");
            $criteria->order = " (CASE WHEN jenis_kunjungan = 'Fast Track' THEN 1 ELSE 2 END) ASC, jam_panggil ASC, DATE(tglantrian) ASC, t.loket_id ASC, t.modelantrian_id ASC, t.noantrian::integer ASC ";

        $katakunci = $this->katakunci;
        if (!empty($katakunci)) {
            $criteria->addCondition("(t.barcode::text ilike '%".$katakunci."%' or t.noantrian::text ilike '%".$katakunci."%' or m.modelantrian_nama::text ilike
            '%".$katakunci."%' or r.ruangan_nama::text ilike '%".$katakunci."%' or t.jenis_kunjungan::text ilike '%".$katakunci."%'            
            )");
        }
       
        $criteria->limit=10;


        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    
    }


    public function searchRiwayatPanggil2()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id  
            JOIN modelantrian_m m ON m.modelantrian_id = t.modelantrian_id 
        ";
        $criteria->select = [
            't.*',
            'r.ruangan_nama',
            "m.modelantrian_nama",
            'r.ruangan_singkatan',
            'm.modelantrian_singkatan'
        ];
        $criteria->addCondition("DATE(tglantrian) = '".date('Y-m-d')."' AND pendaftaran_id IS NULL  ");


            $criteria->compare("t.barcode", $this->barcode);
            $criteria->compare("t.ruangan_id", $this->ruangan_id);
            $criteria->compare("t.jenis_kunjungan", $this->jenis_kunjungan);
            $criteria->compare("t.status_barcode", $this->status_barcode);
            $criteria->compare("t.loket_id", $this->loket_id);
            $criteria->compare("t.modelantrian_id", $this->modelantrian_id);
            $criteria->compare("t.jam_panggil::text", $this->jam_panggil, true);
            $criteria->compare("LOWER(r.ruangan_nama)", strtolower($this->ruangan_nama), true);
            $criteria->compare("LOWER(m.modelantrian_nama)", strtolower($this->modelantrian_nama), true);

            if (!empty($this->default)) {
                $criteria->addCondition("t.antrian_id IS NULL");
            }
            if (!empty($this->noantrian)) {
                $criteria->addCondition(" CONCAT(r.ruangan_singkatan,'-',t.noantrian)  ilike '%" . $this->noantrian . "%' ");
            }

            $criteria->addCondition(" status_panggil != '" . ParamsConst::STATUSPANGGIL_ANTRIAN_SELESAI . "' ");
            $criteria->order = " (CASE WHEN jenis_kunjungan = 'Fast Track' THEN 1 ELSE 2 END) ASC, jam_panggil ASC, DATE(tglantrian) ASC, t.loket_id ASC, t.modelantrian_id ASC, t.noantrian::integer ASC ";

        $katakunci = $this->katakunci;
        if (!empty($katakunci)) {
            $criteria->addCondition("(t.barcode::text ilike '%".$katakunci."%' or t.noantrian::text ilike '%".$katakunci."%' or m.modelantrian_nama::text ilike
            '%".$katakunci."%' or r.ruangan_nama::text ilike '%".$katakunci."%' or t.jenis_kunjungan::text ilike '%".$katakunci."%'            
            )");
        }
       
        $criteria->limit=10;


        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    
    }
 

    public static function listNoAntrianByLoketBelumPanggil($loket, $limit  = 6){
        $cri = new CDbCriteria();
        $cri->select = [
            't.*',
            'r.ruangan_nama',
            'ma.modelantrian_singkatan',
            "CONCAT(ma.modelantrian_singkatan,'-',t.noantrian) as noantrian",
        ];
        $cri->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id
        JOIN modelantrian_m ma ON ma.modelantrian_id = t.modelantrian_id  
        ";
        $cri->addCondition("loket_id = ".$loket->loket_id);
        $cri->addCondition("DATE(tglantrian) = '".date('Y-m-d')."' AND pendaftaran_id IS NULL AND panggil_flaq IS FALSE  ");
        $cri->order = " t.tglantrian ASC ";
        // $cri->limit = $limit;
        return self::model()->findAll($cri);
    }

    public static function listNoAntrianByLoketBelumPanggilNew($loket, $limit  = 6){
        $cri = new CDbCriteria();
        $cri->select = [
            't.*',
            'r.ruangan_nama',
            'r.ruangan_singkatan',
            'ma.modelantrian_singkatan',
            'ma.modelantrian_id'
            // "CONCAT(ma.modelantrian_singkatan,'-',t.noantrian) as noantrian",
        ];
        $cri->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id
        JOIN modelantrian_m ma ON ma.modelantrian_id = t.modelantrian_id  
        ";
        $cri->addCondition("loket_id = ".$loket->loket_id);
        $cri->addCondition("DATE(tglantrian) = '".date('Y-m-d')."' AND pendaftaran_id IS NULL AND panggil_flaq IS FALSE  ");
        $cri->order = " t.tglantrian ASC ";
        // $cri->limit = $limit;
        return self::model()->findAll($cri);
    }

    public static function listJenisKunjungan() {

        $cr = new CDbCriteria;
        $cr->select = 'jenis_kunjungan';
        $cr->group = $cr->select;
        $cr->addCondition('jenis_kunjungan is not null');

        return CHtml::listData(self::model()->findAll($cr),'jenis_kunjungan','jenis_kunjungan');
    }
}
