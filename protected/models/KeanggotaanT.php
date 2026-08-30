<?php

/**
 * This is the model class for table "keanggotaan_t".
 *
 * The followings are the available columns in table 'keanggotaan_t':
 * @property integer $keanggotaan_id
 * @property integer $pegawai_id
 * @property string $tglkeanggotaaan
 * @property string $nokeanggotaan
 * @property string $tglberhentikeanggotaan
 * @property string $catatanpengurus
 * @property string $nosuratpersetujuan
 * @property string $tgldisetujui
 * @property string $disetujuioleh
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 */
class KeanggotaanT extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'keanggotaan_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pegawai_id, tglkeanggotaaan, nokeanggotaan, create_time, create_loginpemakai_id', 'required'),
            array('pegawai_id', 'numerical', 'integerOnly' => true),
            array('nokeanggotaan', 'length', 'max' => 50),
            array('nosuratpersetujuan, disetujuioleh, create_loginpemakai_id, update_loginpemakai_id', 'length', 'max' => 100),
            array('tglberhentikeanggotaan, catatanpengurus, tgldisetujui, update_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('keanggotaan_id, pegawai_id, tglkeanggotaaan, nokeanggotaan, tglberhentikeanggotaan, catatanpengurus, nosuratpersetujuan, tgldisetujui, disetujuioleh, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'keanggotaan_id' => 'Keanggotaan',
            'pegawai_id' => 'Pegawai',
            'tglkeanggotaaan' => 'Tgl. Keanggotaaan',
            'nokeanggotaan' => 'No. Keanggotaan',
            'tglberhentikeanggotaan' => 'Tgl. Berhenti Keanggotaan',
            'catatanpengurus' => 'Catatan Pengurus',
            'nosuratpersetujuan' => 'No Surat Persetujuan',
            'tgldisetujui' => 'Tgl. Disetujui',
            'disetujuioleh' => 'Disetujui Oleh',
            'create_time' => 'Ang Create Time',
            'update_time' => 'Ang Update Time',
            'create_loginpemakai_id' => 'Ang Create Login',
            'update_loginpemakai_id' => 'Ang Update Login',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->keanggotaan_id)) $criteria->addCondition('keanggotaan_id = ' . $this->keanggotaan_id);
        //$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
        if (!empty($this->pegawai_id)) $criteria->addCondition('pegawai_id = ' . $this->pegawai_id);
        //$criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('tglkeanggotaaan', $this->tglkeanggotaaan, true);
        $criteria->compare('nokeanggotaan', $this->nokeanggotaan, true);
        $criteria->compare('tglberhentikeanggotaan', $this->tglberhentikeanggotaan, true);
        $criteria->compare('catatanpengurus', $this->catatanpengurus, true);
        $criteria->compare('nosuratpersetujuan', $this->nosuratpersetujuan, true);
        $criteria->compare('tgldisetujui', $this->tgldisetujui, true);
        $criteria->compare('disetujuioleh', $this->disetujuioleh, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public $nomorindukpegawai, $no_kartupegawainegerisipil, $noidentitas, $nama_pegawai, $tempatlahir_pegawai;
    public $jeniskelamin, $alamat_pegawai, $unit_id, $golonganpegawai_id;

    public function searchAnggota()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('pegawai');
        if (!empty($this->unit_id)) $criteria->addCondition('pegawai.unit_id = ' . $this->unit_id);
        //$criteria->compare('pegawai.unit_id', $this->unit_id);
        if (!empty($this->golonganpegawai_id)) $criteria->addCondition('pegawai.golonganpegawai_id = ' . $this->golonganpegawai_id);
        //$criteria->compare('pegawai.golonganpegawai_id', $this->golonganpegawai_id);
        $criteria->compare('lower(pegawai.jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('lower(pegawai.alamat_pegawai)', strtolower($this->alamat_pegawai), true);
        $criteria->compare('lower(pegawai.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('lower(pegawai.no_kartupegawainegerisipil)', strtolower($this->no_kartupegawainegerisipil), true);
        $criteria->compare('lower(pegawai.noidentitas)', strtolower($this->noidentitas), true);
        $criteria->compare('lower(pegawai.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('lower(pegawai.tempatlahir_pegawai)', strtolower($this->tempatlahir_pegawai), true);
        $criteria->compare('lower(nokeanggotaan)', strtolower($this->nokeanggotaan), true);
        $criteria->order = 'pegawai.nama_pegawai';
        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return KeanggotaanT the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /* Generator */
    public function generateNoAnggota()
    {
        $date = date('Y');
        $sql = "select cast(max(substr(nokeanggotaan, 5, 4)) as integer) as urut from keanggotaan_t where substr(nokeanggotaan, 1, 4) ilike '%" . $date . "%'";
        $dat =  Yii::app()->db->createCommand($sql)->queryRow();

        $cnt = str_pad(($dat['urut'] + 1), 4, '0', STR_PAD_LEFT);
        return $date . $cnt;
    }
}
