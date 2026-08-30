<?php

/**
 * This is the model class for table "laporandonorbatalseleksi_v".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'laporandonorbatalseleksi_v':
 * @property integer $pendonor_id
 * @property string $nama_lengkap
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property integer $daftardonasi_id
 * @property string $no_formulir
 * @property string $waktu_pendaftaran
 * @property integer $donasi_ke
 * @property integer $seleksi_umur
 * @property string $kelompok_umur
 * @property string $tglseleksidonor
 * @property boolean $hb_rendah
 * @property boolean $bb_rendah
 * @property boolean $usia_kurang
 * @property boolean $medis_td_rendah
 * @property boolean $medis_tk_tinggi
 * @property boolean $minum_obat
 * @property boolean $medis_pasca_op
 * @property boolean $medis_hb_17
 * @property boolean $medis_vaksin
 * @property boolean $perilakuberesiko_homo
 * @property boolean $perilakuberesiko_tatto
 * @property boolean $perilakuberesiko_freesx
 * @property boolean $perilakuberesiko_penasun
 * @property boolean $perilakuberesiko_napi
 * @property boolean $riwbepergian_endemik
 * @property boolean $riwbepergian_hiv
 * @property boolean $riwbepergian_sapigila
 * @property boolean $lain_lain_tdkkembali
 * @property boolean $lain_lain_donortua
 */
class LaporandonorbatalseleksiV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir, $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $is_gagalseleksi, $pilihanx, $data, $jumlah, $status;
	
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporandonorbatalseleksiV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'laporandonorbatalseleksi_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendonor_id, daftardonasi_id, donasi_ke, seleksi_umur', 'numerical', 'integerOnly' => true),
            array('nama_lengkap', 'length', 'max' => 100),
            array('jenis_kelamin', 'length', 'max' => 20),
            array('no_formulir', 'length', 'max' => 50),
            array('tgllahir, waktu_pendaftaran, kelompok_umur, tglseleksidonor, hb_rendah, bb_rendah, usia_kurang, medis_td_rendah, medis_tk_tinggi, minum_obat, medis_pasca_op, medis_hb_17, medis_vaksin, perilakuberesiko_homo, perilakuberesiko_tatto, perilakuberesiko_freesx, perilakuberesiko_penasun, perilakuberesiko_napi, riwbepergian_endemik, riwbepergian_hiv, riwbepergian_sapigila, lain_lain_tdkkembali, lain_lain_donortua', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pendonor_id, nama_lengkap, tgllahir, jenis_kelamin, daftardonasi_id, no_formulir, waktu_pendaftaran, donasi_ke, seleksi_umur, kelompok_umur, tglseleksidonor, hb_rendah, bb_rendah, usia_kurang, medis_td_rendah, medis_tk_tinggi, minum_obat, medis_pasca_op, medis_hb_17, medis_vaksin, perilakuberesiko_homo, perilakuberesiko_tatto, perilakuberesiko_freesx, perilakuberesiko_penasun, perilakuberesiko_napi, riwbepergian_endemik, riwbepergian_hiv, riwbepergian_sapigila, lain_lain_tdkkembali, lain_lain_donortua', 'safe', 'on' => 'search'),
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
            'pendonor_id' => 'Pendonor',
            'nama_lengkap' => 'Nama Lengkap',
            'tgllahir' => 'Tgllahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'daftardonasi_id' => 'Daftardonasi',
            'no_formulir' => 'No Formulir',
            'waktu_pendaftaran' => 'Waktu Pendaftaran',
            'donasi_ke' => 'Donasi Ke',
            'seleksi_umur' => 'Seleksi Umur',
            'kelompok_umur' => 'Kelompok Umur',
            'tglseleksidonor' => 'Tglseleksidonor',
            'hb_rendah' => 'Hb Rendah',
            'bb_rendah' => 'Bb Rendah',
            'usia_kurang' => 'Usia Kurang',
            'medis_td_rendah' => 'Medis Td Rendah',
            'medis_tk_tinggi' => 'Medis Tk Tinggi',
            'minum_obat' => 'Minum Obat',
            'medis_pasca_op' => 'Medis Pasca Op',
            'medis_hb_17' => 'Medis Hb 17',
            'medis_vaksin' => 'Medis Vaksin',
            'perilakuberesiko_homo' => 'Perilakuberesiko Homo',
            'perilakuberesiko_tatto' => 'Perilakuberesiko Tatto',
            'perilakuberesiko_freesx' => 'Perilakuberesiko Freesx',
            'perilakuberesiko_penasun' => 'Perilakuberesiko Penasun',
            'perilakuberesiko_napi' => 'Perilakuberesiko Napi',
            'riwbepergian_endemik' => 'Riwbepergian Endemik',
            'riwbepergian_hiv' => 'Riwbepergian Hiv',
            'riwbepergian_sapigila' => 'Riwbepergian Sapigila',
            'lain_lain_tdkkembali' => 'Lain Lain Tdkkembali',
            'lain_lain_donortua' => 'Lain Lain Donortua',
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

        $criteria->compare('pendonor_id', $this->pendonor_id);
        $criteria->compare('nama_lengkap', $this->nama_lengkap, true);
        $criteria->compare('tgllahir', $this->tgllahir, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin, true);
        $criteria->compare('daftardonasi_id', $this->daftardonasi_id);
        $criteria->compare('no_formulir', $this->no_formulir, true);
        $criteria->compare('waktu_pendaftaran', $this->waktu_pendaftaran, true);
        $criteria->compare('donasi_ke', $this->donasi_ke);
        $criteria->compare('seleksi_umur', $this->seleksi_umur);
        $criteria->compare('kelompok_umur', $this->kelompok_umur, true);
        $criteria->compare('tglseleksidonor', $this->tglseleksidonor, true);
        $criteria->compare('hb_rendah', $this->hb_rendah);
        $criteria->compare('bb_rendah', $this->bb_rendah);
        $criteria->compare('usia_kurang', $this->usia_kurang);
        $criteria->compare('medis_td_rendah', $this->medis_td_rendah);
        $criteria->compare('medis_tk_tinggi', $this->medis_tk_tinggi);
        $criteria->compare('minum_obat', $this->minum_obat);
        $criteria->compare('medis_pasca_op', $this->medis_pasca_op);
        $criteria->compare('medis_hb_17', $this->medis_hb_17);
        $criteria->compare('medis_vaksin', $this->medis_vaksin);
        $criteria->compare('perilakuberesiko_homo', $this->perilakuberesiko_homo);
        $criteria->compare('perilakuberesiko_tatto', $this->perilakuberesiko_tatto);
        $criteria->compare('perilakuberesiko_freesx', $this->perilakuberesiko_freesx);
        $criteria->compare('perilakuberesiko_penasun', $this->perilakuberesiko_penasun);
        $criteria->compare('perilakuberesiko_napi', $this->perilakuberesiko_napi);
        $criteria->compare('riwbepergian_endemik', $this->riwbepergian_endemik);
        $criteria->compare('riwbepergian_hiv', $this->riwbepergian_hiv);
        $criteria->compare('riwbepergian_sapigila', $this->riwbepergian_sapigila);
        $criteria->compare('lain_lain_tdkkembali', $this->lain_lain_tdkkembali);
        $criteria->compare('lain_lain_donortua', $this->lain_lain_donortua);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian pada laporan donor batal seleksi
     * @return \CActiveDataProvider
     */
    public function searchTable() {
        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('DATE(tglseleksidonor)', $this->tgl_awal, $this->tgl_akhir);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
