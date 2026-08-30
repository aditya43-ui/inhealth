<?php

/**
 * This is the model class for table "pemantauankawasantanparokok_t".
 * @author Yudhit Widy WIcaksono <yudhitwicaksono@.com>
 * @package application.models
 * The followings are the available columns in table 'pemantauankawasantanparokok_t':
 * @property integer $pemantauankawasantanparokok_id
 * @property string $tgl_pelaporan
 * @property integer $mengetahui_pegawai_id
 * @property integer $pelapor_id
 * @property string $tgl_inspeksi
 * @property string $lokasi_pemantauan
 * @property integer $unitkerja_pemantauan_id
 * @property string $namapelanggar
 * @property string $jenisidentitas
 * @property string $no_identitas
 * @property string $tempatkejadian_perkara
 * @property string $jenispelanggaran
 * @property string $tindakanyangdiambil
 * @property string $tg_verifikasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 */
class PemantauankawasantanparokokT extends CActiveRecord {

    public $tanggal_awal, $tanggal_awal2, $tanggal_akhir, $tanggal_akhir2, $NamaLengkap, $namaunitkerja;
    public $tipeLapor, $tipeInsiden, $status_verifikasi;
    public $pelapor_nama, $unitkerja_pemantauan_nama, $mengetahui_pegawai_nama, $pegawai_mengetahui1_nama, $pegawai_mengetahui2_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PemantauankawasantanparokokT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pemantauankawasantanparokok_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tgl_pelaporan, mengetahui_pegawai_id, tgl_inspeksi, lokasi_pemantauan, namapelanggar, create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
            array('mengetahui_pegawai_id, pelapor_id, unitkerja_pemantauan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly' => true),
            array('lokasi_pemantauan', 'length', 'max' => 100),
            array('namapelanggar', 'length', 'max' => 150),
            array('jenisidentitas', 'length', 'max' => 20),
            array('no_identitas', 'length', 'max' => 30),
            array('tempatkejadian_perkara, jenispelanggaran', 'length', 'max' => 50),
            array('tindakanyangdiambil, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pemantauankawasantanparokok_id, tgl_pelaporan, mengetahui_pegawai_id, pelapor_id, tgl_inspeksi, lokasi_pemantauan, unitkerja_pemantauan_id, namapelanggar, jenisidentitas, no_identitas, tempatkejadian_perkara, jenispelanggaran, tindakanyangdiambil, tg_verifikasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pegawai_pelapor' => array(self::BELONGS_TO, 'PegawaiM', 'pelapor_id'),
            'pegawai_mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_pegawai_id'),
            'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_pemantauan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pemantauankawasantanparokok_id' => 'Pemantauankawasantanparokok',
            'tgl_pelaporan' => 'Tgl Pelaporan',
            'mengetahui_pegawai_id' => 'Mengetahui Pegawai',
            'pelapor_id' => 'Pelapor',
            'tgl_inspeksi' => 'Tgl Inspeksi',
            'lokasi_pemantauan' => 'Lokasi Pemantauan',
            'unitkerja_pemantauan_id' => 'Unit Kerja Pemantauan',
            'namapelanggar' => 'Nama Pelanggar',
            'jenisidentitas' => 'Jenis Identitas',
            'no_identitas' => 'No Identitas',
            'tempatkejadian_perkara' => 'Tempat Kejadian Perkara',
            'jenispelanggaran' => 'Jenis Pelanggaran',
            'tindakanyangdiambil' => 'Tindakan Yang Diambil',
            'tg_verifikasi' => 'Tg Verifikasi',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan_id' => 'Create Ruangan',
        );
    }

    /**
     * Load search
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;

        $criteria->compare('pemantauankawasantanparokok_id', $this->pemantauankawasantanparokok_id);
        $criteria->compare('tgl_pelaporan', $this->tgl_pelaporan, true);
        $criteria->compare('mengetahui_pegawai_id', $this->mengetahui_pegawai_id);
        $criteria->compare('pelapor_id', $this->pelapor_id);
        $criteria->compare('tgl_inspeksi', $this->tgl_inspeksi, true);
        $criteria->compare('lokasi_pemantauan', $this->lokasi_pemantauan, true);
        $criteria->compare('unitkerja_pemantauan_id', $this->unitkerja_pemantauan_id);
        $criteria->compare('LOWER(namapelanggar)', strtolower($this->namapelanggar), true);
        $criteria->compare('jenisidentitas', $this->jenisidentitas, true);
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('tempatkejadian_perkara', $this->tempatkejadian_perkara, true);
        $criteria->compare('jenispelanggaran', $this->jenispelanggaran, true);
        $criteria->compare('tindakanyangdiambil', $this->tindakanyangdiambil, true);
        $criteria->compare('tg_verifikasi', $this->tg_verifikasi, true);
        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = $this->criteriaSearch();
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
