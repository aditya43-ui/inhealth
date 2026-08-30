<?php

/**
 * This is the model class for table "lapproduksikomponen_v".
 *
 * @author  Andyka <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'lapproduksikomponen_v':
 * @property integer $daftardonasi_id
 * @property string $no_formulir
 * @property string $waktu_pendaftaran
 * @property integer $donasi_ke
 * @property string $status
 * @property string $no_pendonor
 * @property string $nama_lengkap
 * @property string $gol_darah
 * @property string $rhesus
 * @property integer $kantongdarah_id
 * @property string $no_kantongdarah
 * @property string $nama_jenis
 * @property string $namakomponendrh
 * @property integer $observasipendonor_id
 * @property boolean $is_batalpenyadapan
 * @property string $alasanbatal_penyadapan
 * @property string $waktu_observasi
 * @property integer $skriningimltd_id
 * @property string $tglskrining
 * @property boolean $hbsag
 * @property boolean $antihiv
 * @property boolean $antihvc
 * @property boolean $sifilis
 * @property string $hasil_skrining
 * @property integer $pengujian_ke
 * @property string $nomorbarcode_sample
 * @property string $periksakomponendarah_id
 * @property string $tglperiksakompdarah
 * @property string $komponen_wb
 * @property string $komponen_prc
 * @property string $komponen_tc
 * @property string $komponen_ffp
 * @property string $komponen_pcr
 * @property string $komponen_cry
 */
class LapproduksikomponenV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir, $is_jenis, $data, $jumlah;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LapproduksikomponenV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lapproduksikomponen_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('daftardonasi_id, donasi_ke, kantongdarah_id, observasipendonor_id, skriningimltd_id, pengujian_ke', 'numerical', 'integerOnly' => true),
            array('no_formulir, status, no_pendonor, komponen_wb, komponen_prc, komponen_tc, komponen_ffp, komponen_pcr, komponen_cry', 'length', 'max' => 50),
            array('nama_lengkap, no_kantongdarah, namakomponendrh, nomorbarcode_sample', 'length', 'max' => 100),
            array('gol_darah', 'length', 'max' => 2),
            array('rhesus', 'length', 'max' => 20),
            array('nama_jenis', 'length', 'max' => 255),
            array('alasanbatal_penyadapan', 'length', 'max' => 200),
            array('hasil_skrining', 'length', 'max' => 15),
            array('waktu_pendaftaran, is_batalpenyadapan, waktu_observasi, tglskrining, hbsag, antihiv, antihvc, sifilis, periksakomponendarah_id, tglperiksakompdarah', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('daftardonasi_id, no_formulir, waktu_pendaftaran, donasi_ke, status, no_pendonor, nama_lengkap, gol_darah, rhesus, kantongdarah_id, no_kantongdarah, nama_jenis, namakomponendrh, observasipendonor_id, is_batalpenyadapan, alasanbatal_penyadapan, waktu_observasi, skriningimltd_id, tglskrining, hbsag, antihiv, antihvc, sifilis, hasil_skrining, pengujian_ke, nomorbarcode_sample, periksakomponendarah_id, tglperiksakompdarah, komponen_wb, komponen_prc, komponen_tc, komponen_ffp, komponen_pcr, komponen_cry', 'safe', 'on' => 'search'),
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
            'daftardonasi_id' => 'Daftardonasi',
            'no_formulir' => 'No Formulir',
            'waktu_pendaftaran' => 'Waktu Pendaftaran',
            'donasi_ke' => 'Donasi Ke',
            'status' => 'Status',
            'no_pendonor' => 'No Pendonor',
            'nama_lengkap' => 'Nama Lengkap',
            'gol_darah' => 'Gol Darah',
            'rhesus' => 'Rhesus',
            'kantongdarah_id' => 'Kantongdarah',
            'no_kantongdarah' => 'No Kantongdarah',
            'nama_jenis' => 'Nama Jenis',
            'namakomponendrh' => 'Namakomponendrh',
            'observasipendonor_id' => 'Observasipendonor',
            'is_batalpenyadapan' => 'Is Batalpenyadapan',
            'alasanbatal_penyadapan' => 'Alasanbatal Penyadapan',
            'waktu_observasi' => 'Waktu Observasi',
            'skriningimltd_id' => 'Skriningimltd',
            'tglskrining' => 'Tglskrining',
            'hbsag' => 'Hbsag',
            'antihiv' => 'Antihiv',
            'antihvc' => 'Antihvc',
            'sifilis' => 'Sifilis',
            'hasil_skrining' => 'Hasil Skrining',
            'pengujian_ke' => 'Pengujian Ke',
            'nomorbarcode_sample' => 'Nomorbarcode Sample',
            'periksakomponendarah_id' => 'Periksakomponendarah',
            'tglperiksakompdarah' => 'Tglperiksakompdarah',
            'komponen_wb' => 'Komponen Wb',
            'komponen_prc' => 'Komponen Prc',
            'komponen_tc' => 'Komponen Tc',
            'komponen_ffp' => 'Komponen Ffp',
            'komponen_pcr' => 'Komponen Pcr',
            'komponen_cry' => 'Komponen Cry',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('daftardonasi_id', $this->daftardonasi_id);
        $criteria->compare('no_formulir', $this->no_formulir, true);
        $criteria->compare('waktu_pendaftaran', $this->waktu_pendaftaran, true);
        $criteria->compare('donasi_ke', $this->donasi_ke);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('no_pendonor', $this->no_pendonor, true);
        $criteria->compare('nama_lengkap', $this->nama_lengkap, true);
        $criteria->compare('gol_darah', $this->gol_darah, true);
        $criteria->compare('rhesus', $this->rhesus, true);
        $criteria->compare('kantongdarah_id', $this->kantongdarah_id);
        $criteria->compare('no_kantongdarah', $this->no_kantongdarah, true);
        $criteria->compare('nama_jenis', $this->nama_jenis, true);
        $criteria->compare('namakomponendrh', $this->namakomponendrh, true);
        $criteria->compare('observasipendonor_id', $this->observasipendonor_id);
        $criteria->compare('is_batalpenyadapan', $this->is_batalpenyadapan);
        $criteria->compare('alasanbatal_penyadapan', $this->alasanbatal_penyadapan, true);
        $criteria->compare('waktu_observasi', $this->waktu_observasi, true);
        $criteria->compare('skriningimltd_id', $this->skriningimltd_id);
        $criteria->compare('tglskrining', $this->tglskrining, true);
        $criteria->compare('hbsag', $this->hbsag);
        $criteria->compare('antihiv', $this->antihiv);
        $criteria->compare('antihvc', $this->antihvc);
        $criteria->compare('sifilis', $this->sifilis);
        $criteria->compare('hasil_skrining', $this->hasil_skrining, true);
        $criteria->compare('pengujian_ke', $this->pengujian_ke);
        $criteria->compare('nomorbarcode_sample', $this->nomorbarcode_sample, true);
        $criteria->compare('periksakomponendarah_id', $this->periksakomponendarah_id, true);
        $criteria->compare('tglperiksakompdarah', $this->tglperiksakompdarah, true);
        $criteria->compare('komponen_wb', $this->komponen_wb, true);
        $criteria->compare('komponen_prc', $this->komponen_prc, true);
        $criteria->compare('komponen_tc', $this->komponen_tc, true);
        $criteria->compare('komponen_ffp', $this->komponen_ffp, true);
        $criteria->compare('komponen_pcr', $this->komponen_pcr, true);
        $criteria->compare('komponen_cry', $this->komponen_cry, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Mencari data grafik untuk laporan produksi komponen darah
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {
        $jam_awal = $this->tgl_awal . ' 00:00:00';
        $jam_akhir = $this->tgl_akhir . ' 23:59:59';
        $criteria = new CDbCriteria();
        if ($this->is_jenis == 1) {
            $criteria->select = "count(t.namakomponendrh) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))  as data";
            $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))";
            $criteria->order = "data ASC";
            $criteria->addCondition("t.namakomponendrh = 'Whole Blood'");
            $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        } else if ($this->is_jenis == 2) {
            $criteria->select = "count(t.namakomponendrh) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))  as data";
            $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))";
            $criteria->order = "data ASC";
            $criteria->addCondition("t.namakomponendrh = 'Packed Red Cell'");
            $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        } else if ($this->is_jenis == 3) {
            $criteria->select = "count(t.namakomponendrh) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))  as data";
            $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))";
            $criteria->order = "data ASC";
            $criteria->addCondition("t.namakomponendrh = 'Thrombocyte Concentrate'");
            $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        } else if ($this->is_jenis == 4) {
            $criteria->select = "count(t.namakomponendrh) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))  as data";
            $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))";
            $criteria->order = "data ASC";
            $criteria->addCondition("t.namakomponendrh = 'Fresh Frozen Plasma'");
            $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        } else if ($this->is_jenis == 5) {
            $criteria->select = "count(t.namakomponendrh) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))  as data";
            $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))";
            $criteria->order = "data ASC";
            $criteria->addCondition("t.namakomponendrh = 'PCR'");
            $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        } else if ($this->is_jenis == 6) {
            $criteria->select = "count(t.namakomponendrh) as jumlah , CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))  as data";
            $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))";
            $criteria->order = "data ASC";
            $criteria->addCondition("t.namakomponendrh = 'Cryoprecipitate'");
            $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        } else if ($this->is_jenis == 7) {
            $criteria->select = "SUM(COALESCE(CASE WHEN t.komponen_wb = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0) "
                            . "+ COALESCE(CASE WHEN t.komponen_prc = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0) "
                            . "+ COALESCE(CASE WHEN t.komponen_ffp = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0)"
                            . "+ COALESCE(CASE WHEN t.komponen_tc = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0)"
                            . "+ COALESCE(CASE WHEN t.komponen_pcr = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0)"
                            . "+ COALESCE(CASE WHEN t.komponen_cry = 'GAGAL PRODUKSI' THEN 1 ELSE 0 END,0)"
                            . ") as jumlah , "
                            . "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))  as data";
            $criteria->group = "CONCAT(date_part('day', t.waktu_pendaftaran),' ',date_part('month', t.waktu_pendaftaran) ,' ',date_part('year', t.waktu_pendaftaran))";
            $criteria->order = "data ASC";
            $criteria->addCondition("t.komponen_wb = 'GAGAL PRODUKSI' OR t.komponen_prc = 'GAGAL PRODUKSI' OR t.komponen_ffp = 'GAGAL PRODUKSI' OR t.komponen_tc = 'GAGAL PRODUKSI' OR t.komponen_pcr = 'GAGAL PRODUKSI' OR t.komponen_cry = 'GAGAL PRODUKSI'");
            $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
