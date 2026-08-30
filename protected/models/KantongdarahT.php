<?php

/**
 * This is the model class for table "kantongdarah_t".
 * @author   Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author   Elham Budianto <elhambudianto@.com>
 * @version  2.0.0
 * @package application.models
 * @category model
 *
 * The followings are the available columns in table 'kantongdarah_t':
 * @property integer $kantongdarah_id
 * @property integer $pendonor_id
 * @property integer $daftarpendonor_id
 * @property string $tglpencatatan
 * @property string $no_kantongdarah
 * @property integer $petugaspencatat_id
 * @property integer $jeniskantongdarah_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property JeniskantongdarahM $jeniskantongdarah
 * @property KantongdarahdetT[] $kantongdarahdetTs
 */
class KantongdarahT extends CActiveRecord {

    public $tgl_awal, $tgl_akhir;
    public $jeniskomponendarah_id, $pilih;
    public $petugaskoreksi_nama;
    public $ppds_nama, $dpjp_nama;
    public $jeniskantong_nama;
    public $no_urut;    
    public $nama_jenis;
    public $jeniskantongdarah_nama;
    public $petugaspencatat_nama;
    public $bulan, $tahun,$jml_input;
    public $tgl_terima;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KantongdarahT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'kantongdarah_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            /* pendonor_id, daftarpendonor_id dibuat tidak required karena perubahan tabel */
            //array('pendonor_id, daftarpendonor_id, tglpencatatan, no_kantongdarah, petugaspencatat_id, jeniskantongdarah_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),

            array('tglpencatatan, no_kantongdarah, petugaspencatat_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pendonor_id, daftarpendonor_id, petugaspencatat_id, jeniskantongdarah_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('no_kantongdarah', 'length', 'max' => 100),
            array('komponendarah_id, update_time, penerimaandarahpmidet_id, tgl_aftap, tgl_kadaluarsa,bataldonordarah,observasipendonor_id, rhesus, gol_darah', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('komponendarah_id, kantongdarah_id, pendonor_id, daftarpendonor_id, tglpencatatan, no_kantongdarah, petugaspencatat_id, jeniskantongdarah_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'jeniskantongdarah' => array(self::BELONGS_TO, 'JeniskantongdarahM', 'jeniskantongdarah_id'),
            'stokkantongdarahTs' => array(self::HAS_MANY, 'StokkantongdarahT', 'kantongdarah_id'),
            'kantongdarahdetTs' => array(self::HAS_MANY, 'KantongdarahdetT', 'kantongdarah_id'),
            'kirimkantongdarahTs' => array(self::HAS_MANY, 'KirimkantongdarahT', 'kantongdarah_id'),
            'komponendarah' => array(self::BELONGS_TO, 'KomponendarahM', 'komponendarah_id'),
            'pendonor' => array(self::BELONGS_TO, 'PendonorM', 'pendonor_id'),
            'petugaskoreksi' => array(self::BELONGS_TO, 'PegawaiM', 'petugaskoreksi_id'),
            'terimakantongdarah' => array(self::BELONGS_TO, 'TerimakantongdarahT', 'terimakantongdarah_id'),
            'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
            'petugaspencatat' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspencatat_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'kantongdarah_id' => 'Kantongdarah',
            'pendonor_id' => 'Pendonor',
            'daftarpendonor_id' => 'Daftarpendonor',
            'tglpencatatan' => 'Tglpencatatan',
            'no_kantongdarah' => 'No Kantongdarah',
            'petugaspencatat_id' => 'Petugaspencatat',
            'jeniskantongdarah_id' => 'Jenis Kantong Darah',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
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

        $criteria->compare('kantongdarah_id', $this->kantongdarah_id);
        $criteria->compare('pendonor_id', $this->pendonor_id);
        $criteria->compare('daftarpendonor_id', $this->daftarpendonor_id);
        $criteria->compare('tglpencatatan', $this->tglpencatatan, true);
        $criteria->compare('no_kantongdarah', $this->no_kantongdarah, true);
        $criteria->compare('petugaspencatat_id', $this->petugaspencatat_id);
        $criteria->compare('jeniskantongdarah_id', $this->jeniskantongdarah_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Load data komponen darah sesuai dengan relasi jenis kantong darah
     * @param integer $jeniskomponendarah_id
     * @return array
     */
    public static function getKomponenDarah($jeniskomponendarah_id){
        $modJenisKomponen = JeniskomponendarahM::model()->findByPk($jeniskomponendarah_id);
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->with = array('jeniskantongdarah');
        $criteria->compare('LOWER(singkatan_komp)', strtolower($modJenisKomponen->jeniskantongdarah_singkatan), true);
        $criteria->order = "t.jeniskantongdarah_id ASC";
        $criteria->addCondition('komponendarah_aktif IS TRUE');
        $models = KomponendarahM::model()->findAll($criteria);
        if(count((array)$models) > 0){
            foreach($models as $model)
                $data[$model->jeniskantongdarah->jeniskantongdarah_id]= $model->jeniskantongdarah->nama_jenis;
        }

        return $data;
    }

}
