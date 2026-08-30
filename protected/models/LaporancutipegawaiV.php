<?php

/**
 * This is the model class for table "laporancutipegawai_v".
 *
 * The followings are the available columns in table 'laporancutipegawai_v':
 * @property integer $pegawaicuti_id
 * @property integer $jeniscuti_id
 * @property string $jeniscuti_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $tglmulaicuti
 * @property string $tglakhircuti
 * @property string $lamacuti
 * @property string $noskcuti
 * @property string $tglditetapkanskcuti
 * @property string $keterangan
 * @property string $keperluancuti
 * @property integer $pejabatmengetahui
 * @property string $gelardepan_mengetahui
 * @property string $nama_mengetahui
 * @property string $gelarbelakang_mengetahui
 * @property integer $pejabatmenyetujui
 * @property string $gelardepan_menyetujui
 * @property string $nama_menyetujui
 * @property string $gelarbelakang_menyetujui
 * @property string $tgl_menyetujui
 * @property integer $pegpengganti_id
 * @property string $gelardepan_pengganti
 * @property string $nama_pengganti
 * @property string $gelarbelakang_pengganti
 * @property string $status_cuti
 */
class LaporancutipegawaiV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;

    public function primaryKey()
    {
        return "pegawaicuti_id";
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporancutipegawaiV the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'laporancutipegawai_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pegawaicuti_id, jeniscuti_id, pegawai_id, pejabatmengetahui, pejabatmenyetujui, pegpengganti_id', 'numerical', 'integerOnly' => true),
            array('jeniscuti_nama', 'length', 'max' => 100),
            array('gelardepan, lamacuti, noskcuti, tglditetapkanskcuti, gelardepan_mengetahui, gelardepan_menyetujui, gelardepan_pengganti', 'length', 'max' => 10),
            array('nama_pegawai, nama_mengetahui, nama_menyetujui, nama_pengganti, status_cuti', 'length', 'max' => 50),
            array('gelarbelakang_nama, gelarbelakang_mengetahui, gelarbelakang_menyetujui, gelarbelakang_pengganti', 'length', 'max' => 15),
            array('tgl_awal, tgl_akhir, tglmulaicuti, tglakhircuti, keterangan, keperluancuti, tgl_menyetujui', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tgl_awal, tgl_akhir, pegawaicuti_id, jeniscuti_id, jeniscuti_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, tglmulaicuti, tglakhircuti, lamacuti, noskcuti, tglditetapkanskcuti, keterangan, keperluancuti, pejabatmengetahui, gelardepan_mengetahui, nama_mengetahui, gelarbelakang_mengetahui, pejabatmenyetujui, gelardepan_menyetujui, nama_menyetujui, gelarbelakang_menyetujui, tgl_menyetujui, pegpengganti_id, gelardepan_pengganti, nama_pengganti, gelarbelakang_pengganti, status_cuti', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pegawaicuti_id' => 'Pegawaicuti',
            'jeniscuti_id' => 'Jeniscuti',
            'jeniscuti_nama' => 'Jenis Cuti',
            'pegawai_id' => 'Pegawai Cuti',
            'gelardepan' => 'Gelardepan',
            'nama_pegawai' => 'Pegawai Cuti',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
            'tglmulaicuti' => 'Tgl. Mulai',
            'tglakhircuti' => 'Tgl. Akhir',
            'lamacuti' => 'Lama Cuti',
            'noskcuti' => 'SK Cuti',
            'tglditetapkanskcuti' => 'Tgl. Ditetapkan',
            'keterangan' => 'Keterangan',
            'keperluancuti' => 'Keperluan',
            'pejabatmengetahui' => 'Pejabatmengetahui',
            'gelardepan_mengetahui' => 'Gelardepan Mengetahui',
            'nama_mengetahui' => 'Mengetahui',
            'gelarbelakang_mengetahui' => 'Gelarbelakang Mengetahui',
            'pejabatmenyetujui' => 'Pejabatmenyetujui',
            'gelardepan_menyetujui' => 'Gelardepan Menyetujui',
            'nama_menyetujui' => 'Menyetujui',
            'gelarbelakang_menyetujui' => 'Gelarbelakang Menyetujui',
            'tgl_menyetujui' => 'Tgl. Menyetujui',
            'pegpengganti_id' => 'Pegpengganti',
            'gelardepan_pengganti' => 'Gelardepan Pengganti',
            'nama_pengganti' => 'Pegawai Pengganti',
            'gelarbelakang_pengganti' => 'Gelarbelakang Pengganti',
            'status_cuti' => 'Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('pegawaicuti_id', $this->pegawaicuti_id);
        $criteria->compare('jeniscuti_id', $this->jeniscuti_id);
        $criteria->compare('jeniscuti_nama', $this->jeniscuti_nama, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('tglmulaicuti', $this->tglmulaicuti, true);
        $criteria->compare('tglakhircuti', $this->tglakhircuti, true);
        $criteria->compare('lamacuti', $this->lamacuti, true);
        $criteria->compare('noskcuti', $this->noskcuti, true);
        $criteria->compare('tglditetapkanskcuti', $this->tglditetapkanskcuti, true);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('keperluancuti', $this->keperluancuti, true);
        $criteria->compare('pejabatmengetahui', $this->pejabatmengetahui);
        $criteria->compare('gelardepan_mengetahui', $this->gelardepan_mengetahui, true);
        $criteria->compare('nama_mengetahui', $this->nama_mengetahui, true);
        $criteria->compare('gelarbelakang_mengetahui', $this->gelarbelakang_mengetahui, true);
        $criteria->compare('pejabatmenyetujui', $this->pejabatmenyetujui);
        $criteria->compare('gelardepan_menyetujui', $this->gelardepan_menyetujui, true);
        $criteria->compare('nama_menyetujui', $this->nama_menyetujui, true);
        $criteria->compare('gelarbelakang_menyetujui', $this->gelarbelakang_menyetujui, true);
        $criteria->compare('tgl_menyetujui', $this->tgl_menyetujui, true);
        $criteria->compare('pegpengganti_id', $this->pegpengganti_id);
        $criteria->compare('gelardepan_pengganti', $this->gelardepan_pengganti, true);
        $criteria->compare('nama_pengganti', $this->nama_pengganti, true);
        $criteria->compare('gelarbelakang_pengganti', $this->gelarbelakang_pengganti, true);

        if (is_array($this->status_cuti)) {
            $criteria->addInCondition(" status_cuti ", $this->status_cuti);
            $cur = '';
            foreach ($this->status_cuti as $st) {
                if (strtolower($st) == strtolower(Params::STATUS_CUTI_PENGAJUAN)) {
                    $criteria->addCondition("status_cuti = '' OR status_cuti IS NULL ", 'OR');
                }
            }
        }

        $criteria->addCondition("tglmulaicuti::date between '" . $this->tgl_awal . "'::date and '" . $this->tgl_akhir . "'::date");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('pegawaicuti_id', $this->pegawaicuti_id);
        $criteria->compare('jeniscuti_id', $this->jeniscuti_id);
        $criteria->compare('jeniscuti_nama', $this->jeniscuti_nama, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('tglmulaicuti', $this->tglmulaicuti, true);
        $criteria->compare('tglakhircuti', $this->tglakhircuti, true);
        $criteria->compare('lamacuti', $this->lamacuti, true);
        $criteria->compare('noskcuti', $this->noskcuti, true);
        $criteria->compare('tglditetapkanskcuti', $this->tglditetapkanskcuti, true);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('keperluancuti', $this->keperluancuti, true);
        $criteria->compare('pejabatmengetahui', $this->pejabatmengetahui);
        $criteria->compare('gelardepan_mengetahui', $this->gelardepan_mengetahui, true);
        $criteria->compare('nama_mengetahui', $this->nama_mengetahui, true);
        $criteria->compare('gelarbelakang_mengetahui', $this->gelarbelakang_mengetahui, true);
        $criteria->compare('pejabatmenyetujui', $this->pejabatmenyetujui);
        $criteria->compare('gelardepan_menyetujui', $this->gelardepan_menyetujui, true);
        $criteria->compare('nama_menyetujui', $this->nama_menyetujui, true);
        $criteria->compare('gelarbelakang_menyetujui', $this->gelarbelakang_menyetujui, true);
        $criteria->compare('tgl_menyetujui', $this->tgl_menyetujui, true);
        $criteria->compare('pegpengganti_id', $this->pegpengganti_id);
        $criteria->compare('gelardepan_pengganti', $this->gelardepan_pengganti, true);
        $criteria->compare('nama_pengganti', $this->nama_pengganti, true);
        $criteria->compare('gelarbelakang_pengganti', $this->gelarbelakang_pengganti, true);

        if (is_array($this->status_cuti)) {
            $criteria->addInCondition(" status_cuti ", $this->status_cuti);
            $cur = '';
            foreach ($this->status_cuti as $st) {
                if (strtolower($st) == strtolower(Params::STATUS_CUTI_PENGAJUAN)) {
                    $criteria->addCondition("status_cuti = '' OR status_cuti IS NULL ", 'OR');
                }
            }
        }

        $criteria->addCondition("tglmulaicuti::date between '" . $this->tgl_awal . "'::date and '" . $this->tgl_akhir . "'::date");
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }


    /**
     * - digunakan untuk menampilkan nama pegawai cuti beserta gelarnya
     * @return type
     */
    public function getNamaLengkap()
    {
        return $this->gelardepan . ' ' . $this->nama_pegawai . ' ' . $this->gelarbelakang_nama;
    }

    /**
     * - digunakan untuk menampilkan nama pegawai menyetujui beserta gelarnya
     * @return type
     */
    public function getNamaLengkapMenyetujui()
    {
        return $this->gelardepan_menyetujui . ' ' . $this->nama_menyetujui . ' ' . $this->gerlarbelakang_menyetujui;
    }

    /**
     * - digunakan untuk menampilkan nama pegawai pengganti beserta gelarnya
     * @return type
     */
    public function getNamaLengkapPengganti()
    {
        return $this->gelardepan_pengganti . ' ' . $this->nama_pengganti . ' ' . $this->gerlarbelakang_pengganti;
    }
}
