<?php

/**
 * This is the model class for table "informed_to_consent_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'informed_to_consent_t':
 * @property integer $informed_to_consent_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $diagnosa_id
 * @property string $diagnosa_nama
 * @property string $dasar_diagnosis
 * @property string $jenis_kemoterapi
 * @property string $indikasi_kemoterapi
 * @property string $tata_cara
 * @property string $tujuan
 * @property string $resiko_komplikasi
 * @property integer $dpjp_id
 * @property integer $ppds_id
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property string $update_time
 * @property integer $update_loginpemakai_id
 * @property integer $update_ruangan_id
 *
 * The followings are the available model relations:
 * @property DiagnosaM $diagnosa
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 */
class InformedToConsentT extends CActiveRecord {

    public $ppds_nama, $dpjp_nama, $diagnosa_kode;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformedToConsentT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'informed_to_consent_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('diagnosa_id, diagnosa_nama, dpjp_id, create_time, create_loginpemakai_id, create_ruangan_id, dasar_diagnosis, jenis_kemoterapi, indikasi_kemoterapi, tata_cara, tujuan, resiko_komplikasi', 'required'),
            array('pasien_id, pendaftaran_id, diagnosa_id, dpjp_id, ppds_id, create_loginpemakai_id, create_ruangan_id, update_loginpemakai_id, update_ruangan_id', 'numerical', 'integerOnly' => true),
            array('dasar_diagnosis, jenis_kemoterapi, indikasi_kemoterapi, tata_cara, tujuan, resiko_komplikasi, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('informed_to_consent_id, pasien_id, pendaftaran_id, diagnosa_id, diagnosa_nama, dasar_diagnosis, jenis_kemoterapi, indikasi_kemoterapi, tata_cara, tujuan, resiko_komplikasi, dpjp_id, ppds_id, create_time, create_loginpemakai_id, create_ruangan_id, update_time, update_loginpemakai_id, update_ruangan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'informed_to_consent_id' => 'Informed To Consent',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'diagnosa_id' => 'Diagnosa',
            'diagnosa_nama' => '1. Diagnosis',
            'dasar_diagnosis' => '2. Dasar Diagnosis',
            'jenis_kemoterapi' => '3. Jenis Kemoterapi',
            'indikasi_kemoterapi' => '4. Indikasi Kemoterapi',
            'tata_cara' => '5. Tata Cara',
            'tujuan' => '6. Tujuan',
            'resiko_komplikasi' => '7. Resiko / Komplikasi yang mungkin',
            'dpjp_id' => 'DPJP',
            'ppds_id' => 'PPDS',
            'create_time' => 'Create Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'create_ruangan_id' => 'Create Ruangan',
            'update_time' => 'Update Time',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'update_ruangan_id' => 'Update Ruangan',
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

        $criteria->compare('informed_to_consent_id', $this->informed_to_consent_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('diagnosa_id', $this->diagnosa_id);
        $criteria->compare('diagnosa_nama', $this->diagnosa_nama, true);
        $criteria->compare('dasar_diagnosis', $this->dasar_diagnosis, true);
        $criteria->compare('jenis_kemoterapi', $this->jenis_kemoterapi, true);
        $criteria->compare('indikasi_kemoterapi', $this->indikasi_kemoterapi, true);
        $criteria->compare('tata_cara', $this->tata_cara, true);
        $criteria->compare('tujuan', $this->tujuan, true);
        $criteria->compare('resiko_komplikasi', $this->resiko_komplikasi, true);
        $criteria->compare('dpjp_id', $this->dpjp_id);
        $criteria->compare('ppds_id', $this->ppds_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('create_ruangan_id', $this->create_ruangan_id);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('update_ruangan_id', $this->update_ruangan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian riwayat asesmen awal keperawatan rj
     * @return \CActiveDataProvider
     */
    public function searchRiwayat() {

        $criteria = new CDbCriteria;
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->order = ('create_time DESC');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
    public function searchDialog()
    {
        $cri = new CDbCriteria();
        
        $cri->order = 'diagnosa_nama ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $cri,
            'pagination' => false,
        ));
    }

}
