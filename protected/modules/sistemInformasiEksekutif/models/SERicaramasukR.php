<?php

/**
 * This is the model class for table "ricaramasuk_r".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.sistemInformasiEksekutif
 * @subpackage models
 * @category model
 * The followings are the available columns in table 'ricaramasuk_r':
 * @property integer $ricaramasuk_id
 * @property string $tanggal
 * @property integer $langsung
 * @property integer $darird
 * @property integer $darirj
 */
class SERicaramasukR extends RicaramasukR {

    public $jns_periode, $bulan;
    public $periode, $jumlah_ri, $jumlah_rd, $jumlah_rj;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2, $instalasi_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RicaramasukR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ricaramasuk_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('langsung, darird, darirj', 'numerical', 'integerOnly' => true),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ricaramasuk_id, tanggal, langsung, darird, darirj', 'safe', 'on' => 'search'),
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
            'ricaramasuk_id' => 'Ricaramasuk',
            'tanggal' => 'Tanggal',
            'langsung' => 'Langsung',
            'darird' => 'Darird',
            'darirj' => 'Darirj',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->ricaramasuk_id)) {
            $criteria->addCondition('ricaramasuk_id = ' . $this->ricaramasuk_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->langsung)) {
            $criteria->addCondition('langsung = ' . $this->langsung);
        }
        if (!empty($this->darird)) {
            $criteria->addCondition('darird = ' . $this->darird);
        }
        if (!empty($this->darirj)) {
            $criteria->addCondition('darirj = ' . $this->darirj);
        }

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data cetak
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Generate laporan cara masuk 
     * Generate tile, grafik pie, grafik garis 
     * @return type
     */
    public function generateLaporanCaraMasuk() {
        $first = date('Y-m-d', strtotime($this->tgl_awal));
        $last = date('Y-m-d', strtotime($this->tgl_akhir));

        $tahun_awal = date('Y', strtotime($first));
        $tahun_akhir = date('Y', strtotime($last));
        
        // Start load data tile 
        $crit = new CDbCriteria();
        $crit->select = "sum(langsung) as langsung, sum(darird) as darird, sum(darirj) as darirj";
        $crit->addBetweenCondition('tanggal', $first, $last);
        
        if (!empty($this->instalasi_id)) {
            if (is_array($this->instalasi_id)) {
                $crit->addInCondition('instalasiasal_id', $this->instalasi_id);
            } else {
                $crit->addCondition('instalasiasal_id = '.$this->instalasi_id);
            }
        }
        $modRawatInap = SERicaramasukR::model()->find($crit);
        
        $tile = array();
        
        $tile['rawat_jalan'] = $modRawatInap['darirj']; 
        $tile['rawat_darurat'] = $modRawatInap['darird']; 
        // end load data tile 
        
         // Start Grafik Pie
        $crit1 = new CDbCriteria();
        $crit1->select = "sum(darird) as darird, sum(darirj) as darirj";
        $crit1->addBetweenCondition('tanggal', $first, $last);
        if (!empty($this->instalasi_id)) {
            if (is_array($this->instalasi_id)) {
                $crit1->addInCondition('instalasiasal_id', $this->instalasi_id);
            } else {
                $crit1->addCondition('instalasiasal_id = '.$this->instalasi_id);
            }
        }
        
        $modGrafik = SERicaramasukR::model()->findAll($crit1);

        $arrGrafikTindakan = array();
        $grafikTindakan = array();
        $data_grafik = array();
        foreach ($modGrafik as $det) {
            $grafikTindakan[$det['tanggal']]['det'][0]['jumlah'] = $det['darird'];
            $grafikTindakan[$det['tanggal']]['det'][0]['label'] = "Melalui Rawat Darurat";
            $grafikTindakan[$det['tanggal']]['det'][0]['warna'] = '#8ac926'; // hijau 
            $grafikTindakan[$det['tanggal']]['det'][1]['jumlah'] = $det['darirj'];
            $grafikTindakan[$det['tanggal']]['det'][1]['label'] = "Melalui Rawat Jalan";
            $grafikTindakan[$det['tanggal']]['det'][1]['warna'] = '#ffca3a'; // kuning 
        }

        $i = 0;

        foreach ($grafikTindakan as $key => $det) {
            foreach ($det['det'] as $key2 => $data) {
                $data_grafik['labels'][$key2] = $data['label']; // label untuk masing-masing batang 
                $jumlah = !empty($data['jumlah']) ? $data['jumlah'] : 0;
                $warna = $data['warna'];

                $data_grafik['datasets'][$i]['data'][] = $jumlah;
                $data_grafik['datasets'][$i]['backgroundColor'][] = $warna;
                $data_grafik['datasets'][$i]['label'] = $key; // 
            }
            $i++;
        }
        // End of Grafik Pie
        
        
        // Start Grafik Garis
        $crit2 = new CDbCriteria();
        $crit2->select = "date_trunc('month', tanggal) as bulan,
                           sum(darird)::int as darird,
                           sum(darirj)::int as darirj";
        $crit2->group = "bulan"; // data group by bulan 
        if (!empty($this->instalasi_id)) {
            if (is_array($this->instalasi_id)) {
                $crit2->addInCondition('instalasiasal_id', $this->instalasi_id);
            } else {
                $crit2->addCondition('instalasiasal_id = '.$this->instalasi_id);
            }
        }
        $crit2->addBetweenCondition('tanggal', $first, $last);
        $modGrafikGaris = SERicaramasukR::model()->findAll($crit2);

        $grafikCaraMasuk = array();

        foreach ($modGrafikGaris as $det) { // generate value 
            $bulan = date('m Y', strtotime($det['bulan']));
            if (isset($bulan)) {
                $grafikCaraMasuk[$bulan]['det'][0]['bulan'] = $det['bulan'];
                $grafikCaraMasuk[$bulan]['det'][0]['jumlah'] = $det['darird'];
                $grafikCaraMasuk[$bulan]['det'][0]['label'] = "Melalui Rawat Darurat";
                $grafikCaraMasuk[$bulan]['det'][1]['bulan'] = $det['bulan'];
                $grafikCaraMasuk[$bulan]['det'][1]['jumlah'] = $det['darirj'];
                $grafikCaraMasuk[$bulan]['det'][1]['label'] = "Melalui Rawat Jalan";
            }
        }

        $tampungGrafik = array();
        $bulan = CustomFunction::getBulan();
        $bulan2 = CustomFunction::getBulanNamaPendek();
        $name_tahun = false;
        if ($tahun_awal != $tahun_akhir) {
            $name_tahun = true;
        }
        $selisih = (CustomFunction::hitungBulan($last, $first));
        $cekIden = array();

        for ($i = 0; $i <= $selisih; $i++) { // set bulan dan tahun 
            $load_bln = date('m', strtotime($first . ' +' . $i . ' month'));
            $load_yr = date('Y', strtotime($first . ' +' . $i . ' month'));
            $cekIden[$load_bln . ' ' . $load_yr] = $i;
            if (!$name_tahun) {
                $load_yr = '';
            }
            $iden = (int) $load_bln;

            if ($iden < 10) {
                $iden = '0' . $iden;
            }

            $tampungGrafik['line']['labels'][] = $bulan[$load_bln] . ' ' . $load_yr; // label untuk grafik di bawah 

            $tampungGrafik['line']['datasets'][0]['data'][$i] = 0; // set default value 0 
            $tampungGrafik['line']['datasets'][0]['backgroundColor'] = '#8ac926'; // warna untuk titiknya      
            $tampungGrafik['line']['datasets'][0]['borderColor'] = '#8ac926';  // warna garisnya    
            $tampungGrafik['line']['datasets'][0]['label'] = "Melalui Rawat Darurat";
            $tampungGrafik['line']['datasets'][0]['fill'] = false; //untuk menghilangkan fill warna di grafik  
            $tampungGrafik['line']['datasets'][0]['lineTension'] = 0; // untuk mengatur lengkungan dari garisnya. kalau nilainya 0 maka garisnya tajam 

            $tampungGrafik['line']['datasets'][1]['data'][$i] = 0;
            $tampungGrafik['line']['datasets'][1]['backgroundColor'] = '#ffca3a';
            $tampungGrafik['line']['datasets'][1]['borderColor'] = '#ffca3a';
            $tampungGrafik['line']['datasets'][1]['label'] = "Melalui Rawat Jalan";
            $tampungGrafik['line']['datasets'][1]['fill'] = false;
            $tampungGrafik['line']['datasets'][1]['lineTension'] = 0;
        }

        foreach ($grafikCaraMasuk as $key => $val) {
            $iden = $cekIden[$key]; // iden diisi dengan bulan dan tahun  
            $dari_rd = isset($grafikCaraMasuk[$key]['det'][0]['jumlah']) ? $grafikCaraMasuk[$key]['det'][0]['jumlah'] : 0;
            $dari_rj = isset($grafikCaraMasuk[$key]['det'][1]['jumlah']) ? $grafikCaraMasuk[$key]['det'][1]['jumlah'] : 0;

            $tampungGrafik['line']['datasets'][0]['data'][$iden] = $dari_rd;
            $tampungGrafik['line']['datasets'][1]['data'][$iden] = $dari_rj;
        }
        
        $data['tile'] = $tile;
        $data['grafik']['grafik_pie'] = $data_grafik;
        $data['grafik']['grafik_garis'] = $tampungGrafik;

        return $data;
    }
    
    /**
     * Load data 
     * @return \CActiveDataProvider
     */
    public function searchTabel(){
        $criteria = new CDbCriteria;
        $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(langsung) as jumlah_ri, sum(darird) as jumlah_rd, sum(darirj) jumlah_rj');
        $criteria->addBetweenCondition('DATE(tanggal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->group = 'periode';
        $criteria->order = 'periode ASC';
        if (!empty($this->instalasi_id)) {
            if (is_array($this->instalasi_id)) {
                $criteria->addInCondition('instalasiasal_id', $this->instalasi_id);
            } else {
                $criteria->addCondition('instalasiasal_id = '.$this->instalasi_id);
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Load data cetak
     * @return \CActiveDataProvider
     */
    public function searchTabelPrint(){
        $criteria = new CDbCriteria;
        $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(langsung) as jumlah_ri, sum(darird) as jumlah_rd, sum(darirj) jumlah_rj');
        $criteria->addBetweenCondition('DATE(tanggal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->group = 'periode';
        $criteria->order = 'periode ASC';
        if (!empty($this->instalasi_id)) {
            if (is_array($this->instalasi_id)) {
                $criteria->addInCondition('instalasiasal_id', $this->instalasi_id);
            } else {
                $criteria->addCondition('instalasiasal_id = '.$this->instalasi_id);
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

}
