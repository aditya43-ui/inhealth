<?php

/**
 * This is the model class for table "laporanpresensi_r".
 *
 * The followings are the available columns in table 'laporanpresensi_r':
 * @property integer $laporanpresensi_id
 * @property string $tanggal
 * @property integer $hadir
 * @property integer $sakit
 * @property integer $izin
 * @property integer $dinas
 * @property integer $alpa
 */
class SELaporanpresensiR extends LaporanpresensiR {

    public $jns_periode;
    public $periode, $jumlah_hadir, $jumlah_sakit, $jumlah_izin, $jumlah_dinas, $jumlah_alpa;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporanpresensiR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'laporanpresensi_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('hadir, sakit, izin, dinas, alpa', 'numerical', 'integerOnly' => true),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('laporanpresensi_id, tanggal, hadir, sakit, izin, dinas, alpa', 'safe', 'on' => 'search'),
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
            'laporanpresensi_id' => 'Laporanpresensi',
            'tanggal' => 'Tanggal',
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'dinas' => 'Dinas',
            'alpa' => 'Alpa',
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

        if (!empty($this->laporanpresensi_id)) {
            $criteria->addCondition('laporanpresensi_id = ' . $this->laporanpresensi_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->hadir)) {
            $criteria->addCondition('hadir = ' . $this->hadir);
        }
        if (!empty($this->sakit)) {
            $criteria->addCondition('sakit = ' . $this->sakit);
        }
        if (!empty($this->izin)) {
            $criteria->addCondition('izin = ' . $this->izin);
        }
        if (!empty($this->dinas)) {
            $criteria->addCondition('dinas = ' . $this->dinas);
        }
        if (!empty($this->alpa)) {
            $criteria->addCondition('alpa = ' . $this->alpa);
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

}
