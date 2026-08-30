<?php

/**
 * This is the model class for table "tindaklanjutigd_r".
 *
 * The followings are the available columns in table 'tindaklanjutigd_r':
 * @property integer $tindaklanjutigd_id
 * @property string $tanggal
 * @property integer $dirawat
 * @property integer $dirujuk
 * @property integer $pulang
 * @property integer $meinggal
 */
class SETindaklanjutigdR extends TindaklanjutigdR {

    public $jns_periode;
    public $periode, $jumlah_dirawat, $jumlah_dirujuk, $jumlah_pulang, $jumlah_meninggal, $bulan;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindaklanjutigdR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tindaklanjutigd_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dirawat, dirujuk, pulang, meninggal', 'numerical', 'integerOnly' => true),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tindaklanjutigd_id, tanggal, dirawat, dirujuk, pulang, meninggal', 'safe', 'on' => 'search'),
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
            'tindaklanjutigd_id' => 'Tindaklanjutigd',
            'tanggal' => 'Tanggal',
            'dirawat' => 'Rawat Inap',
            'dirujuk' => 'Rawat Jalan',
            'pulang' => 'Pasien Pulang',
            'meninggal' => 'Pasien Meninggal',
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

        if (!empty($this->tindaklanjutigd_id)) {
            $criteria->addCondition('tindaklanjutigd_id = ' . $this->tindaklanjutigd_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->dirawat)) {
            $criteria->addCondition('dirawat = ' . $this->dirawat);
        }
        if (!empty($this->dirujuk)) {
            $criteria->addCondition('dirujuk = ' . $this->dirujuk);
        }
        if (!empty($this->pulang)) {
            $criteria->addCondition('pulang = ' . $this->pulang);
        }
        if (!empty($this->meninggal)) {
            $criteria->addCondition('meninggal = ' . $this->meninggal);
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
     * Generate grafik untuk tindak lanjut IGD
     * @return string
     */
    public function generateTindakLanjutRD() {
        $first = $this->tgl_awal;
        $last = $this->tgl_akhir;

        $tahun_awal = date('Y', strtotime($first));
        $tahun_akhir = date('Y', strtotime($last));

        $sql = " 
                SELECT                    
                    sum(dirawat) as dirawat 
                FROM  tindaklanjutigd_r t 
                WHERE date(tanggal) between '" . $first . "' and '" . $last . "'
               ";
        $modRawatInap = Yii::app()->db->createCommand($sql)->queryRow();

        $sql1 = " 
                SELECT                    
                    sum(dirujuk) as dirujuk 
                FROM  tindaklanjutigd_r t 
                WHERE date(tanggal) between '" . $first . "' and '" . $last . "'
               ";
        $modRawatJalan = Yii::app()->db->createCommand($sql1)->queryRow();

        $sql2 = " 
                SELECT                    
                    sum(pulang) as pulang 
                FROM  tindaklanjutigd_r t 
                WHERE date(tanggal) between '" . $first . "' and '" . $last . "'
               ";
        $modPasienPulang = Yii::app()->db->createCommand($sql2)->queryRow();

        $sql3 = " 
                SELECT                    
                    sum(meninggal) as meninggal 
                FROM  tindaklanjutigd_r t 
                WHERE date(tanggal) between '" . $first . "' and '" . $last . "'
               ";
        $modPasienMeninggal = Yii::app()->db->createCommand($sql3)->queryRow();

        $tile = array();

        $tile['pasien_ri'] = $modRawatInap['dirawat'];
        $tile['pasien_rj'] = $modRawatJalan['dirujuk'];
        $tile['pasien_pulang'] = $modPasienPulang['pulang'];
        $tile['pasien_meninggal'] = $modPasienMeninggal['meninggal'];

        // Start Grafik Pie
        $crit = new CDbCriteria();
        $crit->select = "sum(dirawat) as dirawat, sum(t.dirujuk) as dirujuk, sum(pulang) as pulang, sum(meninggal) as meninggal";
        $crit->addBetweenCondition('tanggal', $first, $last);
        $modGrafik = SETindaklanjutigdR::model()->findAll($crit);

        $arrGrafikTindakan = array();
        $grafikTindakan = array();
        $data_grafik = array();
        foreach ($modGrafik as $det) {
            $grafikTindakan[$det['tanggal']]['det'][0]['jumlah'] = $det['dirawat'];
            $grafikTindakan[$det['tanggal']]['det'][0]['label'] = "Rawat Inap";
            $grafikTindakan[$det['tanggal']]['det'][0]['warna'] = '#FF7B89'; // merah 
            $grafikTindakan[$det['tanggal']]['det'][1]['jumlah'] = $det['dirujuk'];
            $grafikTindakan[$det['tanggal']]['det'][1]['label'] = "Rawat Jalan";
            $grafikTindakan[$det['tanggal']]['det'][1]['warna'] = '#8ac926'; // hijau 
            $grafikTindakan[$det['tanggal']]['det'][2]['jumlah'] = $det['pulang'];
            $grafikTindakan[$det['tanggal']]['det'][2]['label'] = "Pasien Pulang";
            $grafikTindakan[$det['tanggal']]['det'][2]['warna'] = '#ffca3a'; // kuning 
            $grafikTindakan[$det['tanggal']]['det'][3]['jumlah'] = $det['meninggal'];
            $grafikTindakan[$det['tanggal']]['det'][3]['label'] = "Pasien Meninggal";
            $grafikTindakan[$det['tanggal']]['det'][3]['warna'] = '#1982c4'; // biru 
        }

        $i = 0;

        foreach ($grafikTindakan as $key => $det) {
            foreach ($det['det'] as $key2 => $data) {
                $data_grafik['labels'][$key2] = $data['label']; // label untuk masing-masing batang 
                $jumlah = !empty($data['jumlah']) ? $data['jumlah'] : 0;
                $warna = $data['warna'];

                $data_grafik['datasets'][$i]['data'][] = $jumlah;
                $data_grafik['datasets'][$i]['backgroundColor'][] = $warna;
                $data_grafik['datasets'][$i]['fill'] = false;
                $data_grafik['datasets'][$i]['label'] = $key; // key = kategori (Pengadaan dan Penyedia)
            }
            $i++;
        }

        // End of Grafik Pie
        // Start Grafik Garis
        $crit2 = new CDbCriteria();
        $crit2->select = "date_trunc('month', tanggal) as bulan,
                           sum(dirawat)::int as dirawat,
                           sum(dirujuk)::int as dirujuk,
                           sum(pulang)::int as pulang,
                           sum(meninggal)::int as meninggal";
        $crit2->group = "bulan"; // data group by bulan 
        $crit2->addBetweenCondition('tanggal', $first, $last);
        $modGrafikGaris = SETindaklanjutigdR::model()->findAll($crit2);

        $grafikTindakLanjut = array();

        foreach ($modGrafikGaris as $det) {
            $bulan = date('m Y', strtotime($det['bulan']));
            if (isset($bulan)) {
                $grafikTindakLanjut[$bulan]['det'][0]['bulan'] = $det['bulan'];
                $grafikTindakLanjut[$bulan]['det'][0]['jumlah'] = $det['dirawat'];
                $grafikTindakLanjut[$bulan]['det'][0]['label'] = "Rawat Inap";
                $grafikTindakLanjut[$bulan]['det'][1]['bulan'] = $det['bulan'];
                $grafikTindakLanjut[$bulan]['det'][1]['jumlah'] = $det['dirujuk'];
                $grafikTindakLanjut[$bulan]['det'][1]['label'] = "Rawat Jalan";
                $grafikTindakLanjut[$bulan]['det'][2]['bulan'] = $det['bulan'];
                $grafikTindakLanjut[$bulan]['det'][2]['jumlah'] = $det['pulang'];
                $grafikTindakLanjut[$bulan]['det'][2]['label'] = "Pasien Pulang";
                $grafikTindakLanjut[$bulan]['det'][3]['bulan'] = $det['bulan'];
                $grafikTindakLanjut[$bulan]['det'][3]['jumlah'] = $det['meninggal'];
                $grafikTindakLanjut[$bulan]['det'][3]['label'] = "Pasien Meninggal";
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

        for ($i = 0; $i <= $selisih; $i++) {
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

            $tampungGrafik['line']['labels'][] = $bulan[$load_bln] . ' ' . $load_yr;

            $tampungGrafik['line']['datasets'][0]['data'][$i] = 0;
            $tampungGrafik['line']['datasets'][0]['backgroundColor'] = '#FF7B89'; // warna untuk titiknya        
            $tampungGrafik['line']['datasets'][0]['borderColor'] = '#FF7B89'; // warna garisnya         
            $tampungGrafik['line']['datasets'][0]['label'] = "Rawat Inap";
            $tampungGrafik['line']['datasets'][0]['fill'] = false; //untuk menghilangkan warna di grafik 

            $tampungGrafik['line']['datasets'][1]['data'][$i] = 0;
            $tampungGrafik['line']['datasets'][1]['backgroundColor'] = '#8ac926';
            $tampungGrafik['line']['datasets'][1]['borderColor'] = '#8ac926';
            $tampungGrafik['line']['datasets'][1]['label'] = "Rawat Jalan";
            $tampungGrafik['line']['datasets'][1]['fill'] = false;

            $tampungGrafik['line']['datasets'][2]['data'][$i] = 0;
            $tampungGrafik['line']['datasets'][2]['backgroundColor'] = '#ffca3a';
            $tampungGrafik['line']['datasets'][2]['borderColor'] = '#ffca3a';
            $tampungGrafik['line']['datasets'][2]['label'] = "Rawat Jalan";
            $tampungGrafik['line']['datasets'][2]['fill'] = false;

            $tampungGrafik['line']['datasets'][3]['data'][$i] = 0;
            $tampungGrafik['line']['datasets'][3]['backgroundColor'] = '#1982c4';
            $tampungGrafik['line']['datasets'][3]['borderColor'] = '#1982c4';
            $tampungGrafik['line']['datasets'][3]['label'] = "Rawat Jalan";
            $tampungGrafik['line']['datasets'][3]['fill'] = false;
        }

        foreach ($grafikTindakLanjut as $key => $val) {
            $iden = $cekIden[$key]; // iden diisi dengan bulan dan tahun  
            $pasien_ri = isset($grafikTindakLanjut[$key]['det'][0]['jumlah']) ? $grafikTindakLanjut[$key]['det'][0]['jumlah'] : 0;
            $pasien_rj = isset($grafikTindakLanjut[$key]['det'][1]['jumlah']) ? $grafikTindakLanjut[$key]['det'][1]['jumlah'] : 0;
            $pasien_pulang = isset($grafikTindakLanjut[$key]['det'][2]['jumlah']) ? $grafikTindakLanjut[$key]['det'][2]['jumlah'] : 0;
            $pasien_meninggal = isset($grafikTindakLanjut[$key]['det'][3]['jumlah']) ? $grafikTindakLanjut[$key]['det'][3]['jumlah'] : 0;

            $tampungGrafik['line']['datasets'][0]['data'][$iden] = $pasien_ri;
            $tampungGrafik['line']['datasets'][0]['label'] = "Rawat Inap";

            $tampungGrafik['line']['datasets'][1]['data'][$iden] = $pasien_rj;
            $tampungGrafik['line']['datasets'][1]['label'] = "Rawat Jalan";

            $tampungGrafik['line']['datasets'][2]['data'][$iden] = $pasien_pulang;
            $tampungGrafik['line']['datasets'][2]['label'] = "Pasien Pulang";

            $tampungGrafik['line']['datasets'][3]['data'][$iden] = $pasien_meninggal;
            $tampungGrafik['line']['datasets'][3]['label'] = "Pasien Meninggal";
        }

        $data['tile'] = $tile;
        $data['grafik']['grafik_tindakan'] = $data_grafik;
        $data['grafik']['grafik_garis'] = $tampungGrafik;
        return $data;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchTabel() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(dirawat) as jumlah_dirawat, sum(dirujuk) as jumlah_dirujuk, sum(pulang) jumlah_pulang, sum(meninggal) as jumlah_meninggal');
        $criteria->addBetweenCondition('DATE(tanggal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->group = 'periode';
        $criteria->order = 'periode ASC';
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data cetak 
     * @return \CActiveDataProvider
     */
    public function searchTabelPrint() {
        $criteria = $this->criteriaSearch();
        $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(dirawat) as jumlah_dirawat, sum(dirujuk) as jumlah_dirujuk, sum(pulang) jumlah_pulang, sum(meninggal) as jumlah_meninggal');
        $criteria->addBetweenCondition('DATE(tanggal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->group = 'periode';
        $criteria->order = 'periode ASC';
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}
