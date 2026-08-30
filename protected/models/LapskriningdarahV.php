<?php
/**
 * digunakan sebagai Laporan Skrining IMLTD
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * 
 * This is the model class for table "lapskriningdarah_v".
 * @package application.models
 * The followings are the available columns in table 'lapskriningdarah_v':
 * @property integer $skriningimltd_id
 * @property string $tglskrining
 * @property boolean $hbsag
 * @property boolean $antihiv
 * @property boolean $antihvc
 * @property boolean $sifilis
 * @property string $ket_skrining
 * @property string $hasil_skrining
 * @property integer $kantongdarah_id
 * @property string $tglpencatatan
 * @property string $no_kantongdarah
 * @property integer $kantongdarahdet_id
 * @property string $nomorbarcode
 * @property string $nomorbarcode_utama
 * @property string $nomorbarcode_sample
 * @property integer $jeniskantongdarah_id
 * @property string $nama_jenis
 * @property string $nama_jenis_sngkt
 * @property integer $komponendarah_id
 * @property string $namakomponendrh
 * @property string $singkatan_komp
 * @property integer $daftardonasi_id
 * @property integer $pendonor_id
 * @property string $no_pendonor
 * @property string $jenisidentitas
 * @property string $no_identitas
 * @property string $nama_lengkap
 * @property string $tempat_lahir
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property string $alamat_lengkap
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $notelp_pendonor
 * @property string $nomobile_pendonor
 * @property string $statusperkawinan
 * @property string $gol_darah
 * @property string $rhesus
 * @property integer $terimakantongdarah_id
 * @property string $tglterimakantong
 * @property string $no_terimakantong
 * @property integer $terimakantongdet_id
 * @property string $nobarcodekantong
 * @property integer $jmlterima
 */
class LapskriningdarahV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir, $is_jenis, $data, $jumlah;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LapskriningdarahV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lapskriningdarah_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('skriningimltd_id, kantongdarah_id, kantongdarahdet_id, jeniskantongdarah_id, komponendarah_id, daftardonasi_id, pendonor_id, terimakantongdarah_id, terimakantongdet_id, jmlterima', 'numerical', 'integerOnly' => true),
            array('beratbadan_kg, tinggibadan_cm', 'numerical'),
            array('hasil_skrining', 'length', 'max' => 15),
            array('no_kantongdarah, nomorbarcode, namakomponendrh, nama_lengkap, tempat_lahir, notelp_pendonor, nobarcodekantong', 'length', 'max' => 100),
            array('nomorbarcode_utama, nomorbarcode_sample, jenisidentitas', 'length', 'max' => 30),
            array('nama_jenis, alamat_lengkap, nomobile_pendonor', 'length', 'max' => 255),
            array('nama_jenis_sngkt, singkatan_komp', 'length', 'max' => 5),
            array('no_pendonor, no_identitas, no_terimakantong', 'length', 'max' => 50),
            array('jenis_kelamin, statusperkawinan, rhesus', 'length', 'max' => 20),
            array('gol_darah', 'length', 'max' => 2),
            array('tglskrining, hbsag, antihiv, antihvc, sifilis, ket_skrining, tglpencatatan, tgllahir, tglterimakantong', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('skriningimltd_id, tglskrining, hbsag, antihiv, antihvc, sifilis, ket_skrining, hasil_skrining, kantongdarah_id, tglpencatatan, no_kantongdarah, kantongdarahdet_id, nomorbarcode, nomorbarcode_utama, nomorbarcode_sample, jeniskantongdarah_id, nama_jenis, nama_jenis_sngkt, komponendarah_id, namakomponendrh, singkatan_komp, daftardonasi_id, pendonor_id, no_pendonor, jenisidentitas, no_identitas, nama_lengkap, tempat_lahir, tgllahir, jenis_kelamin, alamat_lengkap, beratbadan_kg, tinggibadan_cm, notelp_pendonor, nomobile_pendonor, statusperkawinan, gol_darah, rhesus, terimakantongdarah_id, tglterimakantong, no_terimakantong, terimakantongdet_id, nobarcodekantong, jmlterima', 'safe', 'on' => 'search'),
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
            'skriningimltd_id' => 'Skriningimltd',
            'tglskrining' => 'Tglskrining',
            'hbsag' => 'Hbsag',
            'antihiv' => 'Antihiv',
            'antihvc' => 'Antihvc',
            'sifilis' => 'Sifilis',
            'ket_skrining' => 'Ket Skrining',
            'hasil_skrining' => 'Hasil Skrining',
            'kantongdarah_id' => 'Kantongdarah',
            'tglpencatatan' => 'Tglpencatatan',
            'no_kantongdarah' => 'No Kantongdarah',
            'kantongdarahdet_id' => 'Kantongdarahdet',
            'nomorbarcode' => 'Nomorbarcode',
            'nomorbarcode_utama' => 'Nomorbarcode Utama',
            'nomorbarcode_sample' => 'Nomorbarcode Sample',
            'jeniskantongdarah_id' => 'Jeniskantongdarah',
            'nama_jenis' => 'Nama Jenis',
            'nama_jenis_sngkt' => 'Nama Jenis Sngkt',
            'komponendarah_id' => 'Komponendarah',
            'namakomponendrh' => 'Namakomponendrh',
            'singkatan_komp' => 'Singkatan Komp',
            'daftardonasi_id' => 'Daftardonasi',
            'pendonor_id' => 'Pendonor',
            'no_pendonor' => 'No Pendonor',
            'jenisidentitas' => 'Jenisidentitas',
            'no_identitas' => 'No Identitas',
            'nama_lengkap' => 'Nama Lengkap',
            'tempat_lahir' => 'Tempat Lahir',
            'tgllahir' => 'Tgllahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat_lengkap' => 'Alamat Lengkap',
            'beratbadan_kg' => 'Beratbadan Kg',
            'tinggibadan_cm' => 'Tinggibadan Cm',
            'notelp_pendonor' => 'Notelp Pendonor',
            'nomobile_pendonor' => 'Nomobile Pendonor',
            'statusperkawinan' => 'Statusperkawinan',
            'gol_darah' => 'Gol Darah',
            'rhesus' => 'Rhesus',
            'terimakantongdarah_id' => 'Terimakantongdarah',
            'tglterimakantong' => 'Tglterimakantong',
            'no_terimakantong' => 'No Terimakantong',
            'terimakantongdet_id' => 'Terimakantongdet',
            'nobarcodekantong' => 'Nobarcodekantong',
            'jmlterima' => 'Jmlterima',
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

        $criteria->compare('skriningimltd_id', $this->skriningimltd_id);
        $criteria->compare('tglskrining', $this->tglskrining, true);
        $criteria->compare('hbsag', $this->hbsag);
        $criteria->compare('antihiv', $this->antihiv);
        $criteria->compare('antihvc', $this->antihvc);
        $criteria->compare('sifilis', $this->sifilis);
        $criteria->compare('ket_skrining', $this->ket_skrining, true);
        $criteria->compare('hasil_skrining', $this->hasil_skrining, true);
        $criteria->compare('kantongdarah_id', $this->kantongdarah_id);
        $criteria->compare('tglpencatatan', $this->tglpencatatan, true);
        $criteria->compare('no_kantongdarah', $this->no_kantongdarah, true);
        $criteria->compare('kantongdarahdet_id', $this->kantongdarahdet_id);
        $criteria->compare('nomorbarcode', $this->nomorbarcode, true);
        $criteria->compare('nomorbarcode_utama', $this->nomorbarcode_utama, true);
        $criteria->compare('nomorbarcode_sample', $this->nomorbarcode_sample, true);
        $criteria->compare('jeniskantongdarah_id', $this->jeniskantongdarah_id);
        $criteria->compare('nama_jenis', $this->nama_jenis, true);
        $criteria->compare('nama_jenis_sngkt', $this->nama_jenis_sngkt, true);
        $criteria->compare('komponendarah_id', $this->komponendarah_id);
        $criteria->compare('namakomponendrh', $this->namakomponendrh, true);
        $criteria->compare('singkatan_komp', $this->singkatan_komp, true);
        $criteria->compare('daftardonasi_id', $this->daftardonasi_id);
        $criteria->compare('pendonor_id', $this->pendonor_id);
        $criteria->compare('no_pendonor', $this->no_pendonor, true);
        $criteria->compare('jenisidentitas', $this->jenisidentitas, true);
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('nama_lengkap', $this->nama_lengkap, true);
        $criteria->compare('tempat_lahir', $this->tempat_lahir, true);
        $criteria->compare('tgllahir', $this->tgllahir, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin, true);
        $criteria->compare('alamat_lengkap', $this->alamat_lengkap, true);
        $criteria->compare('beratbadan_kg', $this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm', $this->tinggibadan_cm);
        $criteria->compare('notelp_pendonor', $this->notelp_pendonor, true);
        $criteria->compare('nomobile_pendonor', $this->nomobile_pendonor, true);
        $criteria->compare('statusperkawinan', $this->statusperkawinan, true);
        $criteria->compare('gol_darah', $this->gol_darah, true);
        $criteria->compare('rhesus', $this->rhesus, true);
        $criteria->compare('terimakantongdarah_id', $this->terimakantongdarah_id);
        $criteria->compare('tglterimakantong', $this->tglterimakantong, true);
        $criteria->compare('no_terimakantong', $this->no_terimakantong, true);
        $criteria->compare('terimakantongdet_id', $this->terimakantongdet_id);
        $criteria->compare('nobarcodekantong', $this->nobarcodekantong, true);
        $criteria->compare('jmlterima', $this->jmlterima);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Untuk menampilkan data grafik skrining IMLTD
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {
        $criteria = new CDbCriteria();
        if ($this->is_jenis == 1) {
            $criteria->select = "count(hbsag) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
            $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
            $criteria->addCondition("hbsag = true");
            $criteria->addBetweenCondition("DATE(tglskrining)", $this->tgl_awal, $this->tgl_akhir);
        }
        if ($this->is_jenis == 2) {
            $criteria->select = "count(antihiv) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
            $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
            $criteria->addCondition("antihiv = true");
            $criteria->addBetweenCondition("DATE(tglskrining)", $this->tgl_awal, $this->tgl_akhir);
        }
        if ($this->is_jenis == 3) {
            $criteria->select = "count(antihvc) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
            $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
            $criteria->addCondition("antihvc = true");
            $criteria->addBetweenCondition("DATE(tglskrining)", $this->tgl_awal, $this->tgl_akhir);
        }
        if ($this->is_jenis == 4) {
            $criteria->select = "count(sifilis) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
            $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
            $criteria->addCondition("sifilis = true");
            $criteria->addBetweenCondition("DATE(tglskrining)", $this->tgl_awal, $this->tgl_akhir);
        }
        if ($this->is_jenis == 5) {
            $criteria->select = "SUM(COALESCE(CASE WHEN hbsag THEN 1 ELSE 0 END,0) + COALESCE(CASE WHEN antihiv THEN 1 ELSE 0 END,0) + COALESCE(CASE WHEN antihvc THEN 1 ELSE 0 END,0) + COALESCE(CASE WHEN sifilis THEN 1 ELSE 0 END,0)) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
            $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
            $criteria->addBetweenCondition("DATE(tglskrining)", $this->tgl_awal, $this->tgl_akhir);
        }
        if ($this->is_jenis == 6) {
            //$criteria->select = "COUNT(*) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
            $criteria->select = "COUNT(*) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
            $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
            $criteria->condition = '(hbsag = true OR antihiv = true OR antihvc = true OR sifilis = true)';
            $criteria->addBetweenCondition("DATE(tglskrining)", $this->tgl_awal, $this->tgl_akhir);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
