<?php

/**
 * This is the model class for table "dashboardperjalanandokumenpengadaanjumlah_v".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'dashboardperjalanandokumenpengadaanjumlah_v':
 * @property string $rencanaumumpengadaan_kategori
 * @property double $nominal_rup
 * @property string $total_rup
 * @property integer $pptk_id
 * @property integer $pegawaippk_id
 * @property integer $pegawaikpa_id
 * @property integer $periodeanggaran_id
 * @property double $nominal_kontrak
 * @property string $total_kontrak
 * @property double $nominal_bast
 * @property string $total_bast
 * @property double $nominal_bapbj
 * @property string $total_bapbj
 * @property double $nominal_pjphp
 * @property string $total_pjphp
 * @property double $nominal_notadinaspptk
 * @property string $total_notadinas
 * @property double $nominal_verifikasi
 * @property string $total_verifikasi
 * @property double $nominal_realisasi
 * @property string $total_realisasi
 */
class DashboardperjalanandokumenpengadaanjumlahV extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DashboardperjalanandokumenpengadaanjumlahV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dashboardperjalanandokumenpengadaanjumlah_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pptk_id, pegawaippk_id, pegawaikpa_id, periodeanggaran_id', 'numerical', 'integerOnly' => true),
            array('nominal_rup, nominal_kontrak, nominal_bast, nominal_bapbj, nominal_pjphp, nominal_notadinaspptk, nominal_verifikasi, nominal_realisasi', 'numerical'),
            array('rencanaumumpengadaan_kategori', 'length', 'max' => 20),
            array('total_rup, total_kontrak, total_bast, total_bapbj, total_pjphp, total_notadinas, total_verifikasi, total_realisasi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rencanaumumpengadaan_kategori, nominal_rup, total_rup, pptk_id, pegawaippk_id, pegawaikpa_id, periodeanggaran_id, nominal_kontrak, total_kontrak, nominal_bast, total_bast, nominal_bapbj, total_bapbj, nominal_pjphp, total_pjphp, nominal_notadinaspptk, total_notadinas, nominal_verifikasi, total_verifikasi, nominal_realisasi, total_realisasi', 'safe', 'on' => 'search'),
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
            'rencanaumumpengadaan_kategori' => 'Rencanaumumpengadaan Kategori',
            'nominal_rup' => 'Nominal Rup',
            'total_rup' => 'Total Rup',
            'pptk_id' => 'Pptk',
            'pegawaippk_id' => 'Pegawaippk',
            'pegawaikpa_id' => 'Pegawaikpa',
            'periodeanggaran_id' => 'Periodeanggaran',
            'nominal_kontrak' => 'Nominal Kontrak',
            'total_kontrak' => 'Total Kontrak',
            'nominal_bast' => 'Nominal Bast',
            'total_bast' => 'Total Bast',
            'nominal_bapbj' => 'Nominal Bapbj',
            'total_bapbj' => 'Total Bapbj',
            'nominal_pjphp' => 'Nominal Pjphp',
            'total_pjphp' => 'Total Pjphp',
            'nominal_notadinaspptk' => 'Nominal Notadinaspptk',
            'total_notadinas' => 'Total Notadinas',
            'nominal_verifikasi' => 'Nominal Verifikasi',
            'total_verifikasi' => 'Total Verifikasi',
            'nominal_realisasi' => 'Nominal Realisasi',
            'total_realisasi' => 'Total Realisasi',
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

        $criteria->compare('rencanaumumpengadaan_kategori', $this->rencanaumumpengadaan_kategori, true);
        $criteria->compare('nominal_rup', $this->nominal_rup);
        $criteria->compare('total_rup', $this->total_rup, true);
        $criteria->compare('pptk_id', $this->pptk_id);
        $criteria->compare('pegawaippk_id', $this->pegawaippk_id);
        $criteria->compare('pegawaikpa_id', $this->pegawaikpa_id);
        $criteria->compare('periodeanggaran_id', $this->periodeanggaran_id);
        $criteria->compare('nominal_kontrak', $this->nominal_kontrak);
        $criteria->compare('total_kontrak', $this->total_kontrak, true);
        $criteria->compare('nominal_bast', $this->nominal_bast);
        $criteria->compare('total_bast', $this->total_bast, true);
        $criteria->compare('nominal_bapbj', $this->nominal_bapbj);
        $criteria->compare('total_bapbj', $this->total_bapbj, true);
        $criteria->compare('nominal_pjphp', $this->nominal_pjphp);
        $criteria->compare('total_pjphp', $this->total_pjphp, true);
        $criteria->compare('nominal_notadinaspptk', $this->nominal_notadinaspptk);
        $criteria->compare('total_notadinas', $this->total_notadinas, true);
        $criteria->compare('nominal_verifikasi', $this->nominal_verifikasi);
        $criteria->compare('total_verifikasi', $this->total_verifikasi, true);
        $criteria->compare('nominal_realisasi', $this->nominal_realisasi);
        $criteria->compare('total_realisasi', $this->total_realisasi, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
