<?php

/**
 * This is the model class for table "rl1_2_indikatorpelayananrumahsakit".
 *
 * The followings are the available columns in table 'rl1_2_indikatorpelayananrumahsakit':
 * @property integer $rl1_2_indikatorpelayananrumahsakit_id
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $kabupaten
 * @property integer $profilrs_id
 * @property string $koders
 * @property string $namars
 * @property double $bor
 * @property double $los
 * @property double $bto
 * @property double $toi
 * @property double $ndr
 * @property double $gdr
 * @property integer $pendaftaran_id
 * @property integer $pasienpulang_id
 * @property integer $hariperawatan
 * @property integer $lamarawat
 * @property string $tgl_pendaftaran
 */
class Rl12Indikatorpelayananrumahsakit extends CActiveRecord {

    public $tgl_awal, $tgl_akhir;
	public $tahun;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Rl12Indikatorpelayananrumahsakit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rl1_2_indikatorpelayananrumahsakit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tgl_laporan, propinsi, kabupaten, koders, namars', 'required'),
            array('profilrs_id, pendaftaran_id, pasienpulang_id, hariperawatan, lamarawat', 'numerical', 'integerOnly' => true),
            array('bor, los, bto, toi, ndr, gdr', 'numerical'),
            array('propinsi, kabupaten, koders, namars', 'length', 'max' => 50),
            array('tgl_pendaftaran', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rl1_2_indikatorpelayananrumahsakit_id, tgl_laporan, propinsi, kabupaten, profilrs_id, koders, namars, bor, los, bto, toi, ndr, gdr, pendaftaran_id, pasienpulang_id, hariperawatan, lamarawat, tgl_pendaftaran', 'safe', 'on' => 'search'),
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
            'rl1_2_indikatorpelayananrumahsakit_id' => 'Rl1 2 Indikatorpelayananrumahsakit',
            'tgl_laporan' => 'Tgl. Laporan',
            'propinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten',
            'profilrs_id' => 'Profilrs',
            'koders' => 'Koders',
            'namars' => 'Namars',
            'bor' => 'Bor',
            'los' => 'Los',
            'bto' => 'Bto',
            'toi' => 'Toi',
            'ndr' => 'Ndr',
            'gdr' => 'Gdr',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienpulang_id' => 'Pasienpulang',
            'hariperawatan' => 'Hariperawatan',
            'lamarawat' => 'Lamarawat',
            'tgl_pendaftaran' => 'Tgl. Pendaftaran',
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

        if (!empty($this->rl1_2_indikatorpelayananrumahsakit_id)) {
            $criteria->addCondition('rl1_2_indikatorpelayananrumahsakit_id = ' . $this->rl1_2_indikatorpelayananrumahsakit_id);
        }
        $criteria->compare('LOWER(tgl_laporan)', strtolower($this->tgl_laporan), true);
        $criteria->compare('LOWER(propinsi)', strtolower($this->propinsi), true);
        $criteria->compare('LOWER(kabupaten)', strtolower($this->kabupaten), true);
        if (!empty($this->profilrs_id)) {
            $criteria->addCondition('profilrs_id = ' . $this->profilrs_id);
        }
        $criteria->compare('LOWER(koders)', strtolower($this->koders), true);
        $criteria->compare('LOWER(namars)', strtolower($this->namars), true);
        $criteria->compare('bor', $this->bor);
        $criteria->compare('los', $this->los);
        $criteria->compare('bto', $this->bto);
        $criteria->compare('toi', $this->toi);
        $criteria->compare('ndr', $this->ndr);
        $criteria->compare('gdr', $this->gdr);
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        }
        if (!empty($this->pasienpulang_id)) {
            $criteria->addCondition('pasienpulang_id = ' . $this->pasienpulang_id);
        }
        if (!empty($this->hariperawatan)) {
            $criteria->addCondition('hariperawatan = ' . $this->hariperawatan);
        }
        if (!empty($this->lamarawat)) {
            $criteria->addCondition('lamarawat = ' . $this->lamarawat);
        }
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);

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
     * @author	Deni Hamdani
     * @email	<denihamdani@piindonesia.co.id>
     * 
     * Menentukan data jumlah kamar tersedia, kamar yang dipakai, BOR, LOS, BTO, TOI, dan NDR
     * diambil dari periode yang diinput pada model ini.
     * 
     * @return mixed Hasil Perhitungan dari fungsi ini.
     */
    public function hitungPeriodeIndikator() {
        $jumlahkamar = KamarruanganM::model()->find(array(
            'select' => 'count(kamarruangan_id) as kamarruangan_id',
            'condition' => 'kamarruangan_aktif = true'
        ));

        $cur_date = $this->tahun . "-01-01";



        $sql = "select "
                . "extract (month from tgl_laporan) as bulan,"
                . "extract (year from tgl_laporan) as tahun,"
                . "sum(t.hariperawatan) as hari_perawatan, "
                . "extract(days FROM date_trunc('month', tgl_laporan) + interval '1 month - 1 day') as hari,"
                // . "('".$this->tgl_akhir."'::date - '".$this->tgl_awal."'::date) as hari, "
                . "sum(t.lamarawat) as lama_rawat, "
                . "sum(case when p.carakeluar_id <> 4 then 1 else 0 end) as pasien_keluar_hidup, "
                . "sum(case when p.carakeluar_id = 4 and kondisikeluar_id = 3 then 1 else 0 end) as pasien_keluar_meninggal_48, "
                . "sum(case when p.carakeluar_id = 4 and kondisikeluar_id = 4 then 1 else 0 end) as pasien_keluar_meninggal "
                . "from rl1_2_indikatorpelayananrumahsakit t "
                . "join pasienpulang_t p on t.pasienpulang_id = p.pasienpulang_id and p.pasienadmisi_id is not null and p.pasienbatalpulang_id is null "
                . "where p.pasienadmisi_id is not null and t.tgl_laporan::date between '" . $this->tgl_awal . "'::date and '" . $this->tgl_akhir . "'::date "
                . "group by extract (year from tgl_laporan), extract (month from tgl_laporan), extract(days FROM date_trunc('month', tgl_laporan) + interval '1 month - 1 day') "
                . "order by extract (year from tgl_laporan), extract (month from tgl_laporan) ";

        // var_dump($sql); die;

        $qres = Yii::app()->db->createCommand($sql)->queryAll();
        /*
          // Mock Up
          $qres = array(
          array('bulan'=>1, 'tahun'=>2018,'hari_perawatan'=>602,'hari'=>31,'lama_rawat'=>518,'pasien_keluar_hidup'=>149,'pasien_keluar_meninggal_48'=>0,'pasien_keluar_meninggal'=>0),
          array('bulan'=>2, 'tahun'=>2018,'hari_perawatan'=>763,'hari'=>28,'lama_rawat'=>667,'pasien_keluar_hidup'=>193,'pasien_keluar_meninggal_48'=>1,'pasien_keluar_meninggal'=>1),
          array('bulan'=>3, 'tahun'=>2018,'hari_perawatan'=>833,'hari'=>31,'lama_rawat'=>709,'pasien_keluar_hidup'=>265,'pasien_keluar_meninggal_48'=>0,'pasien_keluar_meninggal'=>0),
          array('bulan'=>4, 'tahun'=>2018,'hari_perawatan'=>711,'hari'=>30,'lama_rawat'=>585,'pasien_keluar_hidup'=>209,'pasien_keluar_meninggal_48'=>0,'pasien_keluar_meninggal'=>0),
          array('bulan'=>5, 'tahun'=>2018,'hari_perawatan'=>595,'hari'=>31,'lama_rawat'=>495,'pasien_keluar_hidup'=>172,'pasien_keluar_meninggal_48'=>2,'pasien_keluar_meninggal'=>1),
          array('bulan'=>6, 'tahun'=>2018,'hari_perawatan'=>569,'hari'=>30,'lama_rawat'=>533,'pasien_keluar_hidup'=>163,'pasien_keluar_meninggal_48'=>0,'pasien_keluar_meninggal'=>0),
          array('bulan'=>7, 'tahun'=>2018,'hari_perawatan'=>625,'hari'=>31,'lama_rawat'=>596,'pasien_keluar_hidup'=>170,'pasien_keluar_meninggal_48'=>0,'pasien_keluar_meninggal'=>0),
          array('bulan'=>8, 'tahun'=>2018,'hari_perawatan'=>708,'hari'=>31,'lama_rawat'=>668,'pasien_keluar_hidup'=>181,'pasien_keluar_meninggal_48'=>1,'pasien_keluar_meninggal'=>0),
          array('bulan'=>9, 'tahun'=>2018,'hari_perawatan'=>130,'hari'=>30,'lama_rawat'=>125,'pasien_keluar_hidup'=>41,'pasien_keluar_meninggal_48'=>0,'pasien_keluar_meninggal'=>0),

          ); */

        $main_res = array();

        foreach ($qres as $item) {
            $res = array(
                'jumlah_kamar' => $jumlahkamar->kamarruangan_id
            );
            $res = array_merge($res, $item);

            $res['val_o'] = 0;
            $res['val_bor'] = 0;
            $res['val_bor_persen'] = 0;
            $res['val_alos'] = 0;
            $res['val_bto'] = 0;
            $res['val_toi'] = 0;
            $res['val_ndr'] = 0;
            $res['val_ndr_permil'] = 0;
            $res['date'] = MyFormatter::formatMonthForUser($res['tahun'] . "-" . $res['bulan']);

            // var_dump($res); die;


            $pasien_keluar = 0;
            if (!empty($res['pasien_keluar_hidup']))
                $pasien_keluar += $res['pasien_keluar_hidup'];
            if (!empty($res['pasien_keluar_meninggal_48']))
                $pasien_keluar += $res['pasien_keluar_meninggal_48'];
            if (!empty($res['pasien_keluar_meninggal']))
                $pasien_keluar += $res['pasien_keluar_meninggal'];



            if (empty($res['hari']))
                $res['hari'] = 0;

            if ($res['hari'] != 0)
                $res['val_o'] = $res['hari_perawatan'] / $res['hari'];
            if ($res['hari'] != 0 && $res['jumlah_kamar'] != 0)
                $res['val_bor'] = $res['hari_perawatan'] / ($res['jumlah_kamar'] * $res['hari']);
            if ($pasien_keluar != 0)
                $res['val_alos'] = $res['lama_rawat'] / $pasien_keluar;
            if ($pasien_keluar != 0)
                $res['val_alos_format'] = number_format($res['lama_rawat'] / $pasien_keluar, 2, ".", "");
            if ($res['jumlah_kamar'] != 0)
                $res['val_bto'] = number_format($pasien_keluar / $res['jumlah_kamar'], 2, ".", "");
            if ($pasien_keluar != 0)
                $res['val_toi'] = (($res['jumlah_kamar'] * $res['hari']) - $res['hari_perawatan']) / $pasien_keluar;
            if ($pasien_keluar != 0)
                $res['val_toi_format'] = number_format((($res['jumlah_kamar'] * $res['hari']) - $res['hari_perawatan']) / $pasien_keluar, 2, ".", "");
            if ($res['pasien_keluar_meninggal'] != 0)
                $res['val_ndr'] = number_format($pasien_keluar / $res['pasien_keluar_meninggal'], 2, ".", "");

            $res['val_bor_persen'] = number_format($res['val_bor'] * 100, 2);
            $res['val_ndr_permil'] = number_format($res['val_ndr'] * 1000, 2);

            $main_res[] = $res;
        }


        // var_dump($main_res); die;
        //var_dump($res); die;

        return $main_res;
    }

}
