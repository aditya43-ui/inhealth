<?php

/**
 * -menghilangkan relasi pejabatpembuatkomitmen
 * @author  Andyka Putra <andykaputra@.com>
 * @author Yusuf Putra Anugrah<yusufputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * 
 * This is the model class for table "periodeanggaran_k".
 *
 * The followings are the available columns in table 'periodeanggaran_k':
 * @property integer $periodeanggaran_id
 * @property string $tahunanggaran
 * @property string $anggaran_nama
 * @property string $tglanggaran
 * @property string $sd_tglanggaran
 * @property string $tglrevisianggaran
 * @property string $sd_tglrevisianggaran
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $isclosing_rencanaanggaran
 * @property boolean $isclosing_closinganggaran
 */
class PeriodeanggaranK extends CActiveRecord {

    public $nama_jabatan;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PeriodeanggaranK the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'periodeanggaran_k';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tahunanggaran, anggaran_nama, tglanggaran, sd_tglanggaran, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pegawaipengesahan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('tahunanggaran', 'length', 'max' => 4),
            array('anggaran_nama', 'length', 'max' => 100),
            array('tglrevisianggaran, sd_tglrevisianggaran, tgl_pengesahandpa, update_time, isclosing_rencanaanggaran, isclosing_closinganggaran', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('periodeanggaran_id, tahunanggaran, anggaran_nama, tglanggaran, sd_tglanggaran, tglrevisianggaran, sd_tglrevisianggaran, pegawaipengesahan_id, tgl_pengesahandpa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, isclosing_rencanaanggaran, isclosing_closinganggaran', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipengesahan_id'),
            'pejabatpenggunaanggaran' => array(self::BELONGS_TO, 'PegawaiM', 'pejabatpenggunaanggaran_id'),
            'kuasapenggunaanggaran' => array(self::BELONGS_TO, 'PegawaiM', 'kuasapenggunaanggaran_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'periodeanggaran_id' => 'Periode Anggaran',
            'tahunanggaran' => 'Tahun Anggaran',
            'anggaran_nama' => 'Nama Anggaran',
            'tglanggaran' => 'Tgl Anggaran',
            'sd_tglanggaran' => 'Sd Tgl Anggaran',
            'tglrevisianggaran' => 'Tgl Revisi Anggaran',
            'sd_tglrevisianggaran' => 'Sd Tgl Revisi Anggaran',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'isclosing_rencanaanggaran' => 'Isclosing Rencanaanggaran',
            'isclosing_closinganggaran' => 'Isclosing Closinganggaran',
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

        $criteria->compare('periodeanggaran_id', $this->periodeanggaran_id);
        $criteria->compare('tahunanggaran', $this->tahunanggaran, true);
        $criteria->compare('anggaran_nama', $this->anggaran_nama, true);
        $criteria->compare('tglanggaran', $this->tglanggaran, true);
        $criteria->compare('sd_tglanggaran', $this->sd_tglanggaran, true);
        $criteria->compare('tglrevisianggaran', $this->tglrevisianggaran, true);
        $criteria->compare('sd_tglrevisianggaran', $this->sd_tglrevisianggaran, true);
        $criteria->compare('pegawaipengesahan_id', $this->pegawaipengesahan_id);
        $criteria->compare('tgl_pengesahandpa', $this->tgl_pengesahandpa, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('isclosing_rencanaanggaran', $this->isclosing_rencanaanggaran);
        $criteria->compare('isclosing_closinganggaran', $this->isclosing_closinganggaran);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * menampilkan custom nama periode
     * @return type
     */
    public function getNamaPeriode() {
        return $this->tahunanggaran . ' - ' . $this->anggaran_nama;
    }
    
    /**
     * Set data untuk tahun ini dan tahun depan 
     * @return array $data option untuk dropdown
     */
    public function getPeriodeAnggaran(){
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "tahunanggaran ASC";
        $criteria->addCondition('isclosing_rencanaanggaran IS TRUE');
        $criteria->addCondition('isclosing_closinganggaran IS FALSE');
        $models = PeriodeanggaranK::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                $data[$model->periodeanggaran_id]= ($model->tahunanggaran." - ".$model->anggaran_nama);
        }

        return $data;
    }
}
