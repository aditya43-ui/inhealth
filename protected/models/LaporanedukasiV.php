<?php

/**
 * This is the model class for table "laporanedukasi_v".
 * digunakan untuk pembuatan laporan edukasi
 * RSST-3425
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package application.models
 * The followings are the available columns in table 'laporanedukasi_v':
 * @property string $tgledukasi
 * @property string $topikedukasi
 * @property string $metode_ceramah
 * @property string $metode_demonstrasi
 * @property string $metode_diskusi
 * @property string $metode_wawancara
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class LaporanedukasiV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir, $data, $jumlah, $bulanedukasi, $tahun, $tahunedukasi,$pegawai_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporanedukasiV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'laporanedukasi_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('instalasi_id, ruangan_id', 'numerical', 'integerOnly' => true),
            array('topikedukasi', 'length', 'max' => 100),
            array('instalasi_nama, ruangan_nama', 'length', 'max' => 50),
            array('tgledukasi, metode_ceramah, metode_demonstrasi, metode_diskusi, metode_wawancara', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tgledukasi, topikedukasi, metode_ceramah, metode_demonstrasi, metode_diskusi, metode_wawancara, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tgledukasi' => 'Tgledukasi',
            'topikedukasi' => 'Topikedukasi',
            'metode_ceramah' => 'Metode Ceramah',
            'metode_demonstrasi' => 'Metode Demonstrasi',
            'metode_diskusi' => 'Metode Diskusi',
            'metode_wawancara' => 'Metode Wawancara',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan Nama',
        );
    }

    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param integer $i id dari bulan
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($i = null) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 'EXTRACT(YEAR FROM tgledukasi) as tahunedukasi,EXTRACT(MONTH FROM tgledukasi) as bulanedukasi,topikedukasi,sum(metode_ceramah) as metode_ceramah, sum(metode_demonstrasi) as metode_demonstrasi,sum(metode_diskusi) as metode_diskusi,sum(metode_wawancara) as metode_wawancara';
        
        $criteria->compare('EXTRACT(YEAR FROM tgledukasi)', $this->tahun);
        if (!empty($this->ruangan_id)) {
            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {

            $criteria->addInCondition('instalasi_id', $this->instalasi_id);
        }

        $criteria->group = "topikedukasi,bulanedukasi,tahunedukasi";
        if (!empty($i)) {
            $criteria->addCondition('EXTRACT(MONTH FROM tgledukasi)=' . $i);
        }
        
        $criteria->order = "bulanedukasi";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param integer $rekap id triwulan
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchRekap($rekap = null) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 'topikedukasi,sum(metode_ceramah) as metode_ceramah, sum(metode_demonstrasi) as metode_demonstrasi,sum(metode_diskusi) as metode_diskusi,sum(metode_wawancara) as metode_wawancara';
        
        $criteria->compare('EXTRACT(YEAR FROM tgledukasi)', $this->tahun);
        if (!empty($this->ruangan_id)) {
            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {

            $criteria->addInCondition('instalasi_id', $this->instalasi_id);
        }

        $criteria->group = "topikedukasi";
      
        if(!empty($rekap)){
                 if($rekap==1){
                    $criteria->addCondition('EXTRACT(MONTH FROM tgledukasi)=1 OR EXTRACT(MONTH FROM tgledukasi)=2 OR EXTRACT(MONTH FROM tgledukasi)=3'); 
                 }else if($rekap==2){
                    $criteria->addCondition('EXTRACT(MONTH FROM tgledukasi)=4 OR EXTRACT(MONTH FROM tgledukasi)=5 OR EXTRACT(MONTH FROM tgledukasi)=6'); 
                 }else if($rekap==3){
                    $criteria->addCondition('EXTRACT(MONTH FROM tgledukasi)=7 OR EXTRACT(MONTH FROM tgledukasi)=8 OR EXTRACT(MONTH FROM tgledukasi)=9'); 
                 }else if($rekap==4){
                     $criteria->addCondition('EXTRACT(MONTH FROM tgledukasi)=10 OR EXTRACT(MONTH FROM tgledukasi)=11 OR EXTRACT(MONTH FROM tgledukasi)=12');
                 }  
        }
        $criteria->order = "topikedukasi";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 'topikedukasi,sum(metode_ceramah) as metode_ceramah, sum(metode_demonstrasi) as metode_demonstrasi,sum(metode_diskusi) as metode_diskusi,sum(metode_wawancara) as metode_wawancara';
        $criteria->addBetweenCondition('tgledukasi', $this->tgl_awal, $this->tgl_akhir, true);
        if (!empty($this->ruangan_id)) {
            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {

            $criteria->addInCondition('instalasi_id', $this->instalasi_id);
        }
        $criteria->group = "topikedukasi";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "count(edukasipkrs_id) as jumlah, case WHEN  metode_ceramah is true  THEN 'Ceramah'
	    WHEN  metode_demontrsasi is true  THEN 'Demonstrasi'
	    WHEN  metode_diskusi is true  THEN 'Diskusi Kelompok'
	    WHEN  metode_wawancara is true  THEN 'Tatap Muka' END as data";
        $criteria->addBetweenCondition('date(tgledukasi)', $this->tgl_awal, $this->tgl_akhir, true);
        if (!empty($this->ruangan_id)) {
            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        } else {
            
        }

        if (!empty($this->instalasi_id)) {

            $criteria->addInCondition('instalasi_id', $this->instalasi_id);
        }
        $criteria->group = "data";
        return new CActiveDataProvider(new EdukasipkrsT(), array(
            'criteria' => $criteria,
        ));
    }

}
