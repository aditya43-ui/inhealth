<?php

/**
 * This is the model class for table "retensirekammedik_v".
 *
 * The followings are the available columns in table 'retensirekammedik_v':
 * @property integer $pasien_id
 * @property string $tgl_rekam_medik
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $tanggal_lahir
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $dokrekammedis_id
 * @property string $nodokumenrm
 * @property string $tglrekammedis
 * @property string $statusrekammedis
 * @property string $tgl_in_aktif
 * @property string $tglpemusnahan
 * @property integer $subrak_id
 * @property string $subrak_nama
 * @property integer $lokasirak_id
 * @property string $lokasirak_nama
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $daftarinstalasiakhir_id
 * @property string $daftar_instalasiakhir_nama
 * @property integer $daftarruanganakhir_id
 * @property string $daftar_ruanganakhir_nama
 * @property integer $pengirimanrm_id
 * @property string $tglpengirimanrm
 * @property integer $instalasikhir_dokrmkirim_id
 * @property string $instalasikhir_dokrmkirim_nama
 * @property integer $ruangakhir_dokrmkirim_id
 * @property string $ruangakhir_dokrmkirim_nama
 * @property integer $penerimaanrm_id
 * @property string $tglterimadokrm
 * @property integer $instalasikhir_dokrmterima_id
 * @property string $instalasikhir_dokrmterima_nama
 * @property integer $ruangakhir_dokrmterima_id
 * @property string $ruangakhir_dokrmterima_nama
 * @property integer $peminjamanrm_id
 * @property string $tglpeminjamanrm
 * @property integer $instalasikhir_dokrmpinjam_id
 * @property string $instalasikhir_dokrmpinjam_nama
 * @property integer $ruangakhir_dokrmpinjam_id
 * @property string $ruangakhir_dokrmpinjam_nama
 * @property integer $kembalirm_id
 * @property string $tglkembali
 * @property integer $instalasikhir_dokrmkembali_id
 * @property string $instalasikhir_dokrmkembali_nama
 * @property integer $ruangakhir_dokrmkembali_id
 * @property string $ruangakhir_dokrmkembali_nama
 *   
 * @package application.models 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class RetensirekammedikV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
    public $inaktifrekammedis_id, $no_rekam_medik_akhir;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RetensirekammedikV the static model class
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
        return 'retensirekammedik_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, dokrekammedis_id, subrak_id, lokasirak_id, pendaftaran_id, daftarinstalasiakhir_id, daftarruanganakhir_id, pengirimanrm_id, instalasikhir_dokrmkirim_id, ruangakhir_dokrmkirim_id, penerimaanrm_id, instalasikhir_dokrmterima_id, ruangakhir_dokrmterima_id, peminjamanrm_id, instalasikhir_dokrmpinjam_id, ruangakhir_dokrmpinjam_id, kembalirm_id, instalasikhir_dokrmkembali_id, ruangakhir_dokrmkembali_id', 'numerical', 'integerOnly' => true),
            array('no_rekam_medik, statusrekammedis', 'length', 'max' => 10),
            array('nama_pasien, daftar_instalasiakhir_nama, daftar_ruanganakhir_nama, instalasikhir_dokrmkirim_nama, ruangakhir_dokrmkirim_nama, instalasikhir_dokrmterima_nama, ruangakhir_dokrmterima_nama, instalasikhir_dokrmpinjam_nama, ruangakhir_dokrmpinjam_nama, instalasikhir_dokrmkembali_nama, ruangakhir_dokrmkembali_nama', 'length', 'max' => 50),
            array('jeniskelamin, nodokumenrm, no_pendaftaran', 'length', 'max' => 20),
            array('subrak_nama', 'length', 'max' => 30),
            array('lokasirak_nama', 'length', 'max' => 100),
            array('tgl_rekam_medik, tanggal_lahir, alamat_pasien, tglrekammedis, tgl_in_aktif, tglpemusnahan, tgl_pendaftaran, tglpengirimanrm, tglterimadokrm, tglpeminjamanrm, tglkembali', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pasien_id, tgl_rekam_medik, no_rekam_medik, nama_pasien, tanggal_lahir, jeniskelamin, alamat_pasien, dokrekammedis_id, nodokumenrm, tglrekammedis, statusrekammedis, tgl_in_aktif, tglpemusnahan, subrak_id, subrak_nama, lokasirak_id, lokasirak_nama, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, daftarinstalasiakhir_id, daftar_instalasiakhir_nama, daftarruanganakhir_id, daftar_ruanganakhir_nama, pengirimanrm_id, tglpengirimanrm, instalasikhir_dokrmkirim_id, instalasikhir_dokrmkirim_nama, ruangakhir_dokrmkirim_id, ruangakhir_dokrmkirim_nama, penerimaanrm_id, tglterimadokrm, instalasikhir_dokrmterima_id, instalasikhir_dokrmterima_nama, ruangakhir_dokrmterima_id, ruangakhir_dokrmterima_nama, peminjamanrm_id, tglpeminjamanrm, instalasikhir_dokrmpinjam_id, instalasikhir_dokrmpinjam_nama, ruangakhir_dokrmpinjam_id, ruangakhir_dokrmpinjam_nama, kembalirm_id, tglkembali, instalasikhir_dokrmkembali_id, instalasikhir_dokrmkembali_nama, ruangakhir_dokrmkembali_id, ruangakhir_dokrmkembali_nama', 'safe', 'on' => 'search'),
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
            'pasien_id' => 'Pasien',
            'tgl_rekam_medik' => 'Tgl. Rekam Medik',
            'no_rekam_medik' => 'No. Rekam Medik',
            'nama_pasien' => 'Nama Pasien',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jeniskelamin' => 'Jenis Kelamin',
            'alamat_pasien' => 'Alamat Pasien',
            'dokrekammedis_id' => 'Dok. Rekam Medis',
            'nodokumenrm' => 'No. Dokumen RM',
            'tglrekammedis' => 'Tgl. Rekam Medis',
            'statusrekammedis' => 'Statusrekammedis',
            'tgl_in_aktif' => 'Tgl. In Aktif',
            'tglpemusnahan' => 'Tgl. Pemusnahan',
            'subrak_id' => 'Subrak',
            'subrak_nama' => 'Subrak Nama',
            'lokasirak_id' => 'Lokasirak',
            'lokasirak_nama' => 'Lokasirak Nama',
            'pendaftaran_id' => 'Pendaftaran',
            'no_pendaftaran' => 'No. Pendaftaran',
            'tgl_pendaftaran' => 'Tgl. Pendaftaran',
            'daftarinstalasiakhir_id' => 'Daftarinstalasiakhir',
            'daftar_instalasiakhir_nama' => 'Daftar Instalasiakhir Nama',
            'daftarruanganakhir_id' => 'Daftarruanganakhir',
            'daftar_ruanganakhir_nama' => 'Daftar Ruanganakhir Nama',
            'pengirimanrm_id' => 'Pengirimanrm',
            'tglpengirimanrm' => 'Tglpengirimanrm',
            'instalasikhir_dokrmkirim_id' => 'Instalasikhir Dokrmkirim',
            'instalasikhir_dokrmkirim_nama' => 'Instalasikhir Dokrmkirim Nama',
            'ruangakhir_dokrmkirim_id' => 'Ruangakhir Dokrmkirim',
            'ruangakhir_dokrmkirim_nama' => 'Ruangakhir Dokrmkirim Nama',
            'penerimaanrm_id' => 'Penerimaanrm',
            'tglterimadokrm' => 'Tglterimadokrm',
            'instalasikhir_dokrmterima_id' => 'Instalasikhir Dokrmterima',
            'instalasikhir_dokrmterima_nama' => 'Instalasikhir Dokrmterima Nama',
            'ruangakhir_dokrmterima_id' => 'Ruangakhir Dokrmterima',
            'ruangakhir_dokrmterima_nama' => 'Ruangakhir Dokrmterima Nama',
            'peminjamanrm_id' => 'Peminjamanrm',
            'tglpeminjamanrm' => 'Tglpeminjamanrm',
            'instalasikhir_dokrmpinjam_id' => 'Instalasikhir Dokrmpinjam',
            'instalasikhir_dokrmpinjam_nama' => 'Instalasikhir Dokrmpinjam Nama',
            'ruangakhir_dokrmpinjam_id' => 'Ruangakhir Dokrmpinjam',
            'ruangakhir_dokrmpinjam_nama' => 'Ruangakhir Dokrmpinjam Nama',
            'kembalirm_id' => 'Kembalirm',
            'tglkembali' => 'Tglkembali',
            'instalasikhir_dokrmkembali_id' => 'Instalasikhir Dokrmkembali',
            'instalasikhir_dokrmkembali_nama' => 'Instalasikhir Dokrmkembali Nama',
            'ruangakhir_dokrmkembali_id' => 'Ruangakhir Dokrmkembali',
            'ruangakhir_dokrmkembali_nama' => 'Ruangakhir Dokrmkembali Nama',
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

        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('tgl_rekam_medik', $this->tgl_rekam_medik, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('jeniskelamin', $this->jeniskelamin, true);
        $criteria->compare('alamat_pasien', $this->alamat_pasien, true);
        $criteria->compare('dokrekammedis_id', $this->dokrekammedis_id);
        $criteria->compare('nodokumenrm', $this->nodokumenrm, true);
        $criteria->compare('tglrekammedis', $this->tglrekammedis, true);
        $criteria->compare('statusrekammedis', $this->statusrekammedis, true);
        $criteria->compare('tgl_in_aktif', $this->tgl_in_aktif, true);
        $criteria->compare('tglpemusnahan', $this->tglpemusnahan, true);
        $criteria->compare('subrak_id', $this->subrak_id);
        $criteria->compare('subrak_nama', $this->subrak_nama, true);
        $criteria->compare('lokasirak_id', $this->lokasirak_id);
        $criteria->compare('lokasirak_nama', $this->lokasirak_nama, true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('no_pendaftaran', $this->no_pendaftaran, true);
        $criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran, true);
        $criteria->compare('daftarinstalasiakhir_id', $this->daftarinstalasiakhir_id);
        $criteria->compare('daftar_instalasiakhir_nama', $this->daftar_instalasiakhir_nama, true);
        $criteria->compare('daftarruanganakhir_id', $this->daftarruanganakhir_id);
        $criteria->compare('daftar_ruanganakhir_nama', $this->daftar_ruanganakhir_nama, true);
        $criteria->compare('pengirimanrm_id', $this->pengirimanrm_id);
        $criteria->compare('tglpengirimanrm', $this->tglpengirimanrm, true);
        $criteria->compare('instalasikhir_dokrmkirim_id', $this->instalasikhir_dokrmkirim_id);
        $criteria->compare('instalasikhir_dokrmkirim_nama', $this->instalasikhir_dokrmkirim_nama, true);
        $criteria->compare('ruangakhir_dokrmkirim_id', $this->ruangakhir_dokrmkirim_id);
        $criteria->compare('ruangakhir_dokrmkirim_nama', $this->ruangakhir_dokrmkirim_nama, true);
        $criteria->compare('penerimaanrm_id', $this->penerimaanrm_id);
        $criteria->compare('tglterimadokrm', $this->tglterimadokrm, true);
        $criteria->compare('instalasikhir_dokrmterima_id', $this->instalasikhir_dokrmterima_id);
        $criteria->compare('instalasikhir_dokrmterima_nama', $this->instalasikhir_dokrmterima_nama, true);
        $criteria->compare('ruangakhir_dokrmterima_id', $this->ruangakhir_dokrmterima_id);
        $criteria->compare('ruangakhir_dokrmterima_nama', $this->ruangakhir_dokrmterima_nama, true);
        $criteria->compare('peminjamanrm_id', $this->peminjamanrm_id);
        $criteria->compare('tglpeminjamanrm', $this->tglpeminjamanrm, true);
        $criteria->compare('instalasikhir_dokrmpinjam_id', $this->instalasikhir_dokrmpinjam_id);
        $criteria->compare('instalasikhir_dokrmpinjam_nama', $this->instalasikhir_dokrmpinjam_nama, true);
        $criteria->compare('ruangakhir_dokrmpinjam_id', $this->ruangakhir_dokrmpinjam_id);
        $criteria->compare('ruangakhir_dokrmpinjam_nama', $this->ruangakhir_dokrmpinjam_nama, true);
        $criteria->compare('kembalirm_id', $this->kembalirm_id);
        $criteria->compare('tglkembali', $this->tglkembali, true);
        $criteria->compare('instalasikhir_dokrmkembali_id', $this->instalasikhir_dokrmkembali_id);
        $criteria->compare('instalasikhir_dokrmkembali_nama', $this->instalasikhir_dokrmkembali_nama, true);
        $criteria->compare('ruangakhir_dokrmkembali_id', $this->ruangakhir_dokrmkembali_id);
        $criteria->compare('ruangakhir_dokrmkembali_nama', $this->ruangakhir_dokrmkembali_nama, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
