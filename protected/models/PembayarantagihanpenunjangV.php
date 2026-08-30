<?php

/**
 * This is the model class for table "rinciantagihapasienpenunjang_v".
 *
 * The followings are the available columns in table 'rinciantagihapasienpenunjang_v':
 * @property integer $profilrs_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $photopasien
 * @property string $alamatemail
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property string $namaperusahaan
 * @property string $tglselesaiperiksa
 * @property integer $tindakanpelayanan_id
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $tgl_tindakan
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property integer $tipepaket_id
 * @property string $tipepaket_nama
 * @property boolean $daftartindakan_karcis
 * @property boolean $daftartindakan_visite
 * @property boolean $daftartindakan_konsul
 * @property double $tarif_rsakomodasi
 * @property double $tarif_medis
 * @property double $tarif_paramedis
 * @property double $tarif_bhp
 * @property double $tarif_satuan
 * @property double $tarif_tindakan
 * @property string $satuantindakan
 * @property integer $qty_tindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property double $discount_tindakan
 * @property double $pembebasan_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $subsidipemerintah_tindakan
 * @property double $subsisidirumahsakit_tindakan
 * @property double $iurbiaya_tindakan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $pembayaranpelayanan_id
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $ruanganpendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property integer $ruanganpenunjang_id
 * @property integer $tindakansudahbayar_id
 */
class PembayarantagihanpenunjangV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir, $totaltagihan, $statusBayar, $pasienadmisi_id;
    public $statusperiksa;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RinciantagihanpasienpenunjangV the static model class
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
        return 'pembayarantagihanpenunjang_v';
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendaftaran_id, instalasipenunjang_id, pembayaranpelayanan_id, instalasi_id', 'numerical', 'integerOnly' => true),
            array('tgl_pendaftaran, no_pendaftaran, no_rekam_medik, namadepan, nama_pasien, nama_bin, carabayar_nama, 
            penjamin_nama, statusperiksa, ruangan_nama, instalasi_nama, totaltagihan, is_sudahbayar', 'safe', 'on' => 'search'),
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
            'pendaftaran' => array(self::HAS_ONE, 'PendaftaranT', 'pendaftaran_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pendaftaran_id' => 'Profilrs',
            'instalasipenunjang_id' => 'Pasien',
            'pembayaranpelayanan_id' => 'No. Rekam Medik',
            'instalasi_id' => 'No. Rekam Medik',
            'tgl_pendaftaran' => 'Tanggal Rekam Medik',
            'no_pendaftaran' => 'Jenisidentitas',
            'no_rekam_medik' => 'No. Identitas Pasien',
            'namadepan' => 'Namadepan',
            'nama_pasien' => 'Nama Pasien',
        );
    }
}
