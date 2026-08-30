<?php

/**
 * This is the model class for table "dashboardperjalanandokumenpengadaan_v".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'dashboardperjalanandokumenpengadaan_v':
 * @property string $sumberbiaya
 * @property string $rencanaumumpengadaan_kategori
 * @property integer $periodeanggaran_id
 * @property integer $rencanaumumpengadaan_id
 * @property string $rencanaumumpengadaan_nomor
 * @property string $nomor_rup
 * @property string $tanggal_rup
 * @property double $nominal_rup
 * @property integer $pegawaikpa_id
 * @property string $nama_kpa
 * @property integer $pegawaippk_id
 * @property string $nama_ppk
 * @property integer $pptk_id
 * @property string $nama_pptk
 * @property integer $suratperjanjiankerja_id
 * @property string $nosuratperjanjiankerja
 * @property string $nomor_kontrak
 * @property string $tanggal_kontrak
 * @property double $nominal_kontrak
 * @property integer $suratperjanjiankerjatermin_id
 * @property string $termin_kontrak
 * @property double $jumlah_harga
 * @property integer $baserahterima_id
 * @property string $baserahterima_nomor
 * @property string $termin_bast
 * @property string $nomor_bast
 * @property string $tanggal_bast
 * @property double $nominal_bast
 * @property integer $bapenyerahanbarangjasa_id
 * @property string $bapenyerahanbarangjasa_nomor
 * @property string $termin_bapbj
 * @property string $nomor_bapbj
 * @property string $tanggal_bapbj
 * @property double $nominal_bapbj
 * @property integer $bapemeriksaanadmpphp_id
 * @property string $bapemeriksaanadmpphp_nomor
 * @property string $tanggal_pphp
 * @property double $nominal_pphp
 * @property integer $bapemeriksaanadmpjphp_id
 * @property string $bapemeriksaanadmpjphp_nomor
 * @property string $termin_pjphp
 * @property string $tanggal_pjphp
 * @property double $nominal_pjphp
 * @property integer $notadinaspptk_id
 * @property string $notadinaspptk_nomor
 * @property string $nomor_notadinaspptk
 * @property string $tanggal_notadinaspptk
 * @property double $nominal_notadinaspptk
 * @property integer $invoicemasuk_id
 * @property string $nomor_verifikasi
 * @property string $tanggal_verifikasi
 * @property double $nominal_verifikasi
 * @property string $nomor_realisasi
 * @property string $tanggal_realisasi
 * @property double $nominal_realisasi
 */
class DashboardperjalanandokumenpengadaanV extends CActiveRecord {

    public $rup, $spk, $total_rup, $total_kontrak, $total_bapbj, $total_bast, $total_pjphp, $total_notadinas, $total_verifikasi, $total_realisasi;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DashboardperjalanandokumenpengadaanV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dashboardperjalanandokumenpengadaan_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('periodeanggaran_id, rencanaumumpengadaan_id, pegawaikpa_id, pegawaippk_id, pptk_id, suratperjanjiankerja_id, suratperjanjiankerjatermin_id, baserahterima_id, bapenyerahanbarangjasa_id, bapemeriksaanadmpphp_id, bapemeriksaanadmpjphp_id, notadinaspptk_id, invoicemasuk_id', 'numerical', 'integerOnly' => true),
            array('nominal_rup, nominal_kontrak, jumlah_harga, nominal_bast, nominal_bapbj, nominal_pphp, nominal_pjphp, nominal_notadinaspptk, nominal_verifikasi, nominal_realisasi', 'numerical'),
            array('sumberbiaya', 'length', 'max' => 255),
            array('rencanaumumpengadaan_kategori, rencanaumumpengadaan_nomor, nomor_realisasi', 'length', 'max' => 20),
            array('nomor_rup, nama_kpa, nama_ppk, nama_pptk, baserahterima_nomor, nomor_bast, bapenyerahanbarangjasa_nomor, nomor_bapbj, bapemeriksaanadmpphp_nomor, bapemeriksaanadmpjphp_nomor, notadinaspptk_nomor, nomor_notadinaspptk, tanggal_notadinaspptk, nomor_verifikasi', 'length', 'max' => 50),
            array('nosuratperjanjiankerja, nomor_kontrak', 'length', 'max' => 100),
            array('termin_kontrak, termin_bast, termin_bapbj, termin_pjphp', 'length', 'max' => 5),
            array('tanggal_rup, tanggal_kontrak, tanggal_bast, tanggal_bapbj, tanggal_pphp, tanggal_pjphp, tanggal_verifikasi, tanggal_realisasi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('sumberbiaya, rencanaumumpengadaan_kategori, periodeanggaran_id, rencanaumumpengadaan_id, rencanaumumpengadaan_nomor, nomor_rup, tanggal_rup, nominal_rup, pegawaikpa_id, nama_kpa, pegawaippk_id, nama_ppk, pptk_id, nama_pptk, suratperjanjiankerja_id, nosuratperjanjiankerja, nomor_kontrak, tanggal_kontrak, nominal_kontrak, suratperjanjiankerjatermin_id, termin_kontrak, jumlah_harga, baserahterima_id, baserahterima_nomor, termin_bast, nomor_bast, tanggal_bast, nominal_bast, bapenyerahanbarangjasa_id, bapenyerahanbarangjasa_nomor, termin_bapbj, nomor_bapbj, tanggal_bapbj, nominal_bapbj, bapemeriksaanadmpphp_id, bapemeriksaanadmpphp_nomor, tanggal_pphp, nominal_pphp, bapemeriksaanadmpjphp_id, bapemeriksaanadmpjphp_nomor, termin_pjphp, tanggal_pjphp, nominal_pjphp, notadinaspptk_id, notadinaspptk_nomor, nomor_notadinaspptk, tanggal_notadinaspptk, nominal_notadinaspptk, invoicemasuk_id, nomor_verifikasi, tanggal_verifikasi, nominal_verifikasi, nomor_realisasi, tanggal_realisasi, nominal_realisasi', 'safe', 'on' => 'search'),
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
            'sumberbiaya' => 'Sumberbiaya',
            'rencanaumumpengadaan_kategori' => 'Rencanaumumpengadaan Kategori',
            'periodeanggaran_id' => 'Periodeanggaran',
            'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
            'rencanaumumpengadaan_nomor' => 'Rencanaumumpengadaan Nomor',
            'nomor_rup' => 'Nomor Rup',
            'tanggal_rup' => 'Tanggal Rup',
            'nominal_rup' => 'Nominal Rup',
            'pegawaikpa_id' => 'Pegawaikpa',
            'nama_kpa' => 'Nama Kpa',
            'pegawaippk_id' => 'Pegawaippk',
            'nama_ppk' => 'Nama Ppk',
            'pptk_id' => 'Pptk',
            'nama_pptk' => 'Nama Pptk',
            'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
            'nosuratperjanjiankerja' => 'Nosuratperjanjiankerja',
            'nomor_kontrak' => 'Nomor Kontrak',
            'tanggal_kontrak' => 'Tanggal Kontrak',
            'nominal_kontrak' => 'Nominal Kontrak',
            'suratperjanjiankerjatermin_id' => 'Suratperjanjiankerjatermin',
            'termin_kontrak' => 'Termin Kontrak',
            'jumlah_harga' => 'Jumlah Harga',
            'baserahterima_id' => 'Baserahterima',
            'baserahterima_nomor' => 'Baserahterima Nomor',
            'termin_bast' => 'Termin Bast',
            'nomor_bast' => 'Nomor Bast',
            'tanggal_bast' => 'Tanggal Bast',
            'nominal_bast' => 'Nominal Bast',
            'bapenyerahanbarangjasa_id' => 'Bapenyerahanbarangjasa',
            'bapenyerahanbarangjasa_nomor' => 'Bapenyerahanbarangjasa Nomor',
            'termin_bapbj' => 'Termin Bapbj',
            'nomor_bapbj' => 'Nomor Bapbj',
            'tanggal_bapbj' => 'Tanggal Bapbj',
            'nominal_bapbj' => 'Nominal Bapbj',
            'bapemeriksaanadmpphp_id' => 'Bapemeriksaanadmpphp',
            'bapemeriksaanadmpphp_nomor' => 'Bapemeriksaanadmpphp Nomor',
            'tanggal_pphp' => 'Tanggal Pphp',
            'nominal_pphp' => 'Nominal Pphp',
            'bapemeriksaanadmpjphp_id' => 'Bapemeriksaanadmpjphp',
            'bapemeriksaanadmpjphp_nomor' => 'Bapemeriksaanadmpjphp Nomor',
            'termin_pjphp' => 'Termin Pjphp',
            'tanggal_pjphp' => 'Tanggal Pjphp',
            'nominal_pjphp' => 'Nominal Pjphp',
            'notadinaspptk_id' => 'Notadinaspptk',
            'notadinaspptk_nomor' => 'Notadinaspptk Nomor',
            'nomor_notadinaspptk' => 'Nomor Notadinaspptk',
            'tanggal_notadinaspptk' => 'Tanggal Notadinaspptk',
            'nominal_notadinaspptk' => 'Nominal Notadinaspptk',
            'invoicemasuk_id' => 'Invoicemasuk',
            'nomor_verifikasi' => 'Nomor Verifikasi',
            'tanggal_verifikasi' => 'Tanggal Verifikasi',
            'nominal_verifikasi' => 'Nominal Verifikasi',
            'nomor_realisasi' => 'Nomor Realisasi',
            'tanggal_realisasi' => 'Tanggal Realisasi',
            'nominal_realisasi' => 'Nominal Realisasi',
        );
    }

    /**
     * Load data pencarian 
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;

        $criteria->compare('sumberbiaya', $this->sumberbiaya, true);
        $criteria->compare('rencanaumumpengadaan_kategori', $this->rencanaumumpengadaan_kategori, true);
        $criteria->compare('periodeanggaran_id', $this->periodeanggaran_id);
        $criteria->compare('rencanaumumpengadaan_id', $this->rencanaumumpengadaan_id);
        $criteria->compare('rencanaumumpengadaan_nomor', $this->rencanaumumpengadaan_nomor, true);
        $criteria->compare('lower(nomor_rup)', strtolower($this->nomor_rup), true);
        $criteria->compare('tanggal_rup', $this->tanggal_rup, true);
        $criteria->compare('nominal_rup', $this->nominal_rup);
        $criteria->compare('pegawaikpa_id', $this->pegawaikpa_id);
        $criteria->compare('nama_kpa', $this->nama_kpa, true);
        $criteria->compare('pegawaippk_id', $this->pegawaippk_id);
        $criteria->compare('nama_ppk', $this->nama_ppk, true);
        $criteria->compare('pptk_id', $this->pptk_id);
        $criteria->compare('nama_pptk', $this->nama_pptk, true);
        $criteria->compare('suratperjanjiankerja_id', $this->suratperjanjiankerja_id);
        $criteria->compare('nosuratperjanjiankerja', $this->nosuratperjanjiankerja, true);
        $criteria->compare('lower(nomor_kontrak)', strtolower($this->nomor_kontrak), true);
        $criteria->compare('tanggal_kontrak', $this->tanggal_kontrak, true);
        $criteria->compare('nominal_kontrak', $this->nominal_kontrak);
        $criteria->compare('suratperjanjiankerjatermin_id', $this->suratperjanjiankerjatermin_id);
        $criteria->compare('termin_kontrak', $this->termin_kontrak, true);
        $criteria->compare('jumlah_harga', $this->jumlah_harga);
        $criteria->compare('baserahterima_id', $this->baserahterima_id);
        $criteria->compare('baserahterima_nomor', $this->baserahterima_nomor, true);
        $criteria->compare('termin_bast', $this->termin_bast, true);
        $criteria->compare('lower(nomor_bast)', strtolower($this->nomor_bast), true);
        $criteria->compare('tanggal_bast', $this->tanggal_bast, true);
        $criteria->compare('nominal_bast', $this->nominal_bast);
        $criteria->compare('bapenyerahanbarangjasa_id', $this->bapenyerahanbarangjasa_id);
        $criteria->compare('bapenyerahanbarangjasa_nomor', $this->bapenyerahanbarangjasa_nomor, true);
        $criteria->compare('termin_bapbj', $this->termin_bapbj, true);
        $criteria->compare('lower(nomor_bapbj)', strtolower($this->nomor_bapbj), true);
        $criteria->compare('tanggal_bapbj', $this->tanggal_bapbj, true);
        $criteria->compare('nominal_bapbj', $this->nominal_bapbj);
        $criteria->compare('bapemeriksaanadmpphp_id', $this->bapemeriksaanadmpphp_id);
        $criteria->compare('lower(bapemeriksaanadmpphp_nomor)', strtolower($this->bapemeriksaanadmpphp_nomor), true);
        $criteria->compare('lower(bapemeriksaanadmpjphp_nomor)', strtolower($this->bapemeriksaanadmpphp_nomor), true);
        $criteria->compare('tanggal_pphp', $this->tanggal_pphp, true);
        $criteria->compare('nominal_pphp', $this->nominal_pphp);
        $criteria->compare('bapemeriksaanadmpjphp_id', $this->bapemeriksaanadmpjphp_id);
        $criteria->compare('termin_pjphp', $this->termin_pjphp, true);
        $criteria->compare('tanggal_pjphp', $this->tanggal_pjphp, true);
        $criteria->compare('nominal_pjphp', $this->nominal_pjphp);
        $criteria->compare('notadinaspptk_id', $this->notadinaspptk_id);
        $criteria->compare('notadinaspptk_nomor', $this->notadinaspptk_nomor, true);
        $criteria->compare('strtolower(nomor_notadinaspptk)', strtolower($this->nomor_notadinaspptk), true);
        $criteria->compare('tanggal_notadinaspptk', $this->tanggal_notadinaspptk, true);
        $criteria->compare('nominal_notadinaspptk', $this->nominal_notadinaspptk);
        $criteria->compare('invoicemasuk_id', $this->invoicemasuk_id);
        $criteria->compare('strtolower(nomor_verifikasi)', strtolower($this->nomor_verifikasi), true);
        $criteria->compare('tanggal_verifikasi', $this->tanggal_verifikasi, true);
        $criteria->compare('nominal_verifikasi', $this->nominal_verifikasi);
        $criteria->compare('strtolower(nomor_realisasi)', strtolower($this->nomor_realisasi), true);
        $criteria->compare('tanggal_realisasi', $this->tanggal_realisasi, true);
        $criteria->compare('nominal_realisasi', $this->nominal_realisasi);
        $criteria->order = "rencanaumumpengadaan_kategori asc, nomor_rup asc, nomor_kontrak asc, "
                        . "nomor_bast asc, nomor_bapbj asc, bapemeriksaanadmpphp_nomor asc, bapemeriksaanadmpjphp_nomor asc, "
                        . "nomor_notadinaspptk asc, nomor_verifikasi asc, nomor_realisasi asc";

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
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data dashboard
     * @return \CActiveDataProvider
     */
    public function searchDashboard() {
        $criteria = $this->criteriaSearch();
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data cetak 
     * @return \CActiveDataProvider
     */
    public function searchDashboardPrint() {
        $criteria = $this->criteriaSearch();
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}
