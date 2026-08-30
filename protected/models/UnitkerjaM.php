<?php

/**
 * This is the model class for table "unitkerja_m".
 *
 * The followings are the available columns in table 'unitkerja_m':
 * @property integer $unitkerja_id
 * @property string $kodeunitkerja
 * @property string $namaunitkerja
 * @property string $namalain
 * @property boolean $unitkerja_aktif
 *
 * The followings are the available model relations:
 * @property RuanganM[] $ruanganMs
 */
class UnitkerjaM extends CActiveRecord
{
        public $namaunit;
        public $hasinstalasi, $pegawai_id, $nama_pegawai;
        public $kepalaunitpeg_nama, $kepalaunitpeg_nip, $kepalaunitpeg_jabatan, $kepalaunitpeg_id;  
        public $nomorindukpegawai, $jabatan;
        public $hasunitkerjabidang;
        public $haspejabatpengadaan;
        public $unitkerjabidang_hide;
        public $unitkerjapejabat_hide;
        public $instalasi_nama, $ruangan_nama, $ruangan_id;  
        public $jabatan_nama;
        public $periodeanggaran_id;
        public $default;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UnitkerjaM the static model class
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
		return 'unitkerja_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kodeunitkerja, namaunitkerja', 'required'),
			array('kodeunitkerja', 'length', 'max'=>50),
			array('namaunitkerja, namalain', 'length', 'max'=>200),
			array('divisi', 'length', 'max'=>200),
			array('instalasi_id, unitkerja_aktif, kepalaunitpeg_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('unitkerja_id, kodeunitkerja, namaunitkerja, namalain, unitkerja_aktif, divisi', 'safe', 'on'=>'search'),
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
                    'ruanganMs' => array(self::MANY_MANY, 'RuanganM', 'unitkerjaruangan_m(unitkerja_id, ruangan_id)'),
                    // 'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'unitkerja_id' => 'Unitkerja',
			'kodeunitkerja' => 'Kode',
			'namaunitkerja' => 'Nama Unit',
			'namalain' => 'Nama Lain',
			'unitkerja_aktif' => 'Aktif',
			'divisi'=>'Divisi'
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

		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->compare('LOWER(kodeunitkerja)',strtolower($this->kodeunitkerja),true);
		$criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
		$criteria->compare('LOWER(namalain)',strtolower($this->namalain),true);
		$criteria->compare('divisi',$this->divisi);
        $criteria->compare('unitkerja_aktif',isset($this->unitkerja_aktif)?$this->unitkerja_aktif:true);

		// if(!empty($this->unitkerja_aktif)){
		// 	$criteria->addCondition('unitkerja_aktif = '.$this->unitkerja_aktif);
		// }

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
        
        public function getUnitRek()
        {
            return $this->namaunitkerja." - ".$this->kodeunitkerja;
        }
        
        /**
         * Search Kepala Unit
         * @return \CActiveDataProvider
         */
        public function searchKepalaUnit(){
            $criteria=new CDbCriteria;

            if(!empty($this->unitkerja_id)){
                    $criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
            }
             if ($this->hasinstalasi){
                $criteria->addCondition(" instalasi_id is not null ");
            }
            
            $criteria->join = "left join pegawai_m on t.kepalaunitpeg_id = pegawai_m.pegawai_id "
                            . "join jabatan_m on pegawai_m.jabatan_id = jabatan_m.jabatan_id ";
            $criteria->addCondition("t.kepalaunitpeg_id is not null"); 
            $criteria->compare('LOWER(kodeunitkerja)',strtolower($this->kodeunitkerja),true);
            $criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->compare('LOWER(namalain)',strtolower($this->namalain),true);
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->addCondition('unitkerja_aktif is true'); 
            $criteria->select = "t.*, pegawai_m.*, jabatan_m.jabatan_nama as jabatan";
            $criteria->order = "t.namaunitkerja asc, pegawai_m.nama_pegawai asc";
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * Search Dialog unitkerja berdasarkan instalasi
         * @return \CActiveDataProvider
         */
        public function searchDialogByInstalasi(){
            $criteria=new CDbCriteria;
            $criteria->select = "t.*, instalasi_m.instalasi_nama";
            $criteria->join = 'JOIN instalasi_m ON instalasi_m.instalasi_id = t.instalasi_id';
            if(!empty($this->unitkerja_id)){
                $criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
            }
            
            $cekPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            if(!empty($cekPegawai)){
                $cekunitkerja = UnitkerjaM::model()->findByPk($cekPegawai->unitkerja_id);
                if(!empty($cekunitkerja)){
                    $criteria->addCondition('instalasi_m.instalasi_id = '.$cekunitkerja->instalasi_id);
                }
            }
            $criteria->compare('LOWER(instalasi_m.instalasi_nama)',strtolower($this->instalasi_nama),true);
            $criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->addCondition(" t.unitkerja_aktif = TRUE ");            
            if(isset($this->hasunitkerjabidang)){
                if ($this->hasunitkerjabidang == 'ada'){
                    $criteria->join .= " LEFT JOIN unitkerjabidang_m map_bid ON map_bid.unitkerja_id = t.unitkerja_id  ";
                    if ($this->unitkerjabidang_hide == 'ada'){
                        $criteria->addCondition(" map_bid.unitkerja_id is null ");
                    }
                }
            }
            if(isset($this->haspejabatpengadaan)){
                if ($this->haspejabatpengadaan == 'ada'){                    
                    if ($this->unitkerjapejabat_hide == 'ada'){
                        $criteria->join .= " LEFT JOIN pejabatpengadaandet_m pejabatdet ON pejabatdet.instalasi_id = t.instalasi_id  ";
                    }else{
                        $criteria->join .= " JOIN pejabatpengadaandet_m pejabatdet ON pejabatdet.instalasi_id = t.instalasi_id  ";
                    }
                }
            }
            
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * Search Dialog unitkerja berdasarkan instalasi
         * @return \CActiveDataProvider
         */
        public function searchDialogUnitKerjaPPK(){
            $criteria=new CDbCriteria;
            $criteria->group = " t.unitkerja_id, t.namaunitkerja, i.instalasi_nama, i.instalasi_id ";
            $criteria->select = " t.unitkerja_id, t.namaunitkerja, i.instalasi_nama, i.instalasi_id ";
            $criteria->join = " JOIN rencanaumumpengadaan_t ON rencanaumumpengadaan_t.unitkerja_id = t.unitkerja_id "
                            . " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id ";
            
            $criteria->compare('LOWER(i.instalasi_nama)',strtolower($this->instalasi_nama),true);
            $criteria->compare('LOWER(t.namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->addCondition(" t.unitkerja_aktif = TRUE");            
                       
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort' => array(
                        'defaultOrder' => 'namaunitkerja ASC'
                    )
            ));
        }
        
        /**
         * Pencarian data unit kerja berdasarkan unit kerja yang dibawahi oleh PJK yang login 
         * @return \CActiveDataProvider
         */
        public function searchDialogPJK(){
            $criteria=new CDbCriteria;
            $criteria->addCondition('unitkerja_aktif is true');
            $criteria->select = "t.*, instalasi_m.instalasi_id, instalasi_m.instalasi_nama";
            $criteria->join = "JOIN instalasi_m on instalasi_m.instalasi_id = t.instalasi_id";
            $criPejabat = new CDbCriteria();
            $criPejabat->addCondition("jabatan_pengadaan = 'Penanggung Jawab Kegiatan'");
            $criPejabat->addCondition('pejabatpengadaan_aktif is true');
            $criPejabat->addCondition('pegawai_id = '.Yii::app()->user->getState('pegawai_id'));
            $modPejabat = PejabatpengadaanM::model()->find($criPejabat);
            if (!empty($modPejabat)) {
                $modDetail = PejabatpengadaandetM::model()->findAllByAttributes(array('pejabatpengadaan_id' => $modPejabat->pejabatpengadaan_id));
                if (!empty($modDetail)) {
                    $instalasi = array();
                    foreach($modDetail as $det){
                        $instalasi[] = $det->instalasi_id; 
                    }
                    
                    $criUnit = new CDbCriteria();
                    $criUnit->addCondition('unitkerja_aktif is true');
                    if (!empty($this->instalasi_id)) {
                        $criUnit->addCondition('instalasi_id = '.$this->instalasi_id);
                    } else {
                        $criUnit->addInCondition('instalasi_id', $instalasi);
                    }
                    $modUnit = UnitkerjaM::model()->findAll($criUnit);
                    if (!empty($modUnit)) {
                        $unitkerja = array();
                        foreach($modUnit as $unit){
                            $unitkerja[] = $unit->unitkerja_id; 
                        }
                        
                        $criteria->addInCondition('t.unitkerja_id', $unitkerja);
                    }
                }
            }
            
            $criteria->order = "instalasi_m.instalasi_nama asc, t.namaunitkerja asc";
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort' => array(
                        'defaultOrder' => 'namaunitkerja ASC'
                    )
            ));
        }
        
        /**
         * Search Dialog
         * @return \CActiveDataProvider
         */
        public function searchUnitkerjaDPA(){
            
            $unitkerja_id = array();
            $dokumenpelaksanaananggaran_id = array();
            $crit = new CDbCriteria();
            $crit->select = 'dokumenpelaksanaananggaran_id';
            if(!empty($this->periodeanggaran_id)){
                $crit->addCondition('t.periodeanggaran_id = '.$this->periodeanggaran_id);
            }
            $crit->group = 'dokumenpelaksanaananggaran_id';
            $cekDPA = DokumenpelaksanaananggaranT::model()->findAll($crit);
            foreach ($cekDPA as $val){
                $dokumenpelaksanaananggaran_id[] = $val->dokumenpelaksanaananggaran_id;
            }
            
            $crit2 = new CDbCriteria();
            $crit2->select = 'unitkerja_id';
            $crit2->addInCondition('t.dokumenpelaksanaananggaran_id',$dokumenpelaksanaananggaran_id);
            $crit2->group = 'unitkerja_id';
            $cekDPA2 = DokumenpelaksanaananggarandetT::model()->findAll($crit2);
            foreach ($cekDPA2 as $val2){
                $unitkerja_id[] = $val2->unitkerja_id;
            }
            
            $criteria=new CDbCriteria;
            $criteria->select = "t.*, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,', ',gelar.gelarbelakang_nama) as kepalaunitpeg_nama, peg.pegawai_id as kepalaunitpeg_id, peg.nomorindukpegawai as kepalaunitpeg_nip, j.jabatan_nama as kepalaunitpeg_jabatan ";
            $criteria->join = " LEFT JOIN pegawai_m peg ON t.kepalaunitpeg_id = peg.pegawai_id "
                            . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id "
                            . " LEFT JOIN jabatan_m j ON j.jabatan_id = peg.jabatan_id ";            
            
            $criteria->addInCondition('t.unitkerja_id',$unitkerja_id);
            
            $criteria->compare('LOWER(kodeunitkerja)',strtolower($this->kodeunitkerja),true);
            $criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
            $criteria->compare('LOWER(namalain)',strtolower($this->namalain),true);
            $criteria->compare('LOWER(peg.nama_pegawai)', strtolower($this->kepalaunitpeg_nama), true);
            $criteria->order = "namaunitkerja ASC";
            $criteria->addCondition(" t.unitkerja_aktif = TRUE ");            
            if(isset($this->hasunitkerjabidang)){
                if ($this->hasunitkerjabidang == 'ada'){
                    $criteria->join .= " LEFT JOIN unitkerjabidang_m map_bid ON map_bid.unitkerja_id = t.unitkerja_id  ";
                    if ($this->unitkerjabidang_hide == 'ada'){
                        $criteria->addCondition(" map_bid.unitkerja_id is null ");
                    }
                }
            }
        }
            

		public function searchDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
			$criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
			$criteria->addCondition('unitkerja_aktif = true');
			$criteria->order = "namaunitkerja asc";
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}
