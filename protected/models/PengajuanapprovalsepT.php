<?php

/**
 * This is the model class for table "pengajuanapprovalsep_t".
 *
 * The followings are the available columns in table 'pengajuanapprovalsep_t':
 * @property integer $pengajuanapprovalsep_id
 * @property integer $pendaftaran_id
 * @property string $no_kartu_bpjs
 * @property string $namapeserta_bpjs
 * @property string $jenispeserta_bpjs_kode
 * @property string $jenispeserta_bpjs_nama
 * @property string $tgl_sep
 * @property string $kode_ppk_pelayanan
 * @property string $nama_ppk_pelayanan
 * @property string $jenis_pelayanan
 * @property string $kelas_tanggungan
 * @property string $asal_rujukan
 * @property string $no_rujukan
 * @property string $kode_ppk_rujukan
 * @property string $nama_ppk_rujukan
 * @property string $tgl_rujukan
 * @property integer $jenisrujukan
 * @property string $diagnosa_awal
 * @property string $diagnosa_awal_nama
 * @property string $politujuan
 * @property string $politujuan_nama
 * @property boolean $poli_eksekutif
 * @property boolean $cob
 * @property boolean $lakalantas
 * @property string $penjamin
 * @property string $lokasilakalantas
 * @property string $no_telepon_pasien
 * @property string $userpembuat_bpjs
 * @property string $catatan
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property boolean $is_approval
 * @property integer $sep_id
 * @property string $user_approval_bpjs
 * @property string $namaasuransi_cob
 * @property string $no_asuransi_cob
 * @property string $propinsi_lakalantas_nama
 * @property string $kabupaten_lakalantas_nama
 * @property string $kecamatan_lakalantas_nama
 * @property integer $suplesi_jasaraharja
 * @property string $no_suplesi
 * @property string $keterangan_kejadian
 * @property string $no_surat
 * @property string $kode_dpjp
 * @property string $nama_dpjp
 * @property string $tanggal_kejadian
 * @property string $propinsi_lakalantas_id
 * @property string $kabupaten_lakalantas_id
 * @property string $kecamatan_lakalantas_id
 * @property integer $katarak
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property SepT $sep
 */
class PengajuanapprovalsepT extends CActiveRecord
{
    public $cob_status,$namaasuransi_cob,$no_asuransi_cob;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanapprovalsepT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pengajuanapprovalsep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_kartu_bpjs, namapeserta_bpjs, jenispeserta_bpjs_kode, jenispeserta_bpjs_nama, tgl_sep, nama_ppk_pelayanan, userpembuat_bpjs, create_time, create_loginpemakai_id', 'required'),
			array('pendaftaran_id, jenisrujukan, create_loginpemakai_id, sep_id, suplesi_jasaraharja, katarak', 'numerical', 'integerOnly'=>true),
			array('no_kartu_bpjs, jenispeserta_bpjs_kode, kode_ppk_pelayanan, jenis_pelayanan, kode_ppk_rujukan, userpembuat_bpjs, user_approval_bpjs, namaasuransi_cob, no_asuransi_cob', 'length', 'max'=>50),
			array('namapeserta_bpjs, jenispeserta_bpjs_nama, nama_ppk_pelayanan, asal_rujukan, no_rujukan, nama_ppk_rujukan, penjamin, no_suplesi, no_surat, kode_dpjp, nama_dpjp', 'length', 'max'=>100),
			array('kelas_tanggungan, propinsi_lakalantas_id, kabupaten_lakalantas_id, kecamatan_lakalantas_id', 'length', 'max'=>10),
			array('diagnosa_awal, diagnosa_awal_nama, politujuan, politujuan_nama', 'length', 'max'=>250),
			array('lokasilakalantas, propinsi_lakalantas_nama, kabupaten_lakalantas_nama, kecamatan_lakalantas_nama', 'length', 'max'=>200),
			array('no_telepon_pasien, jnspengajuan_approvalsep', 'length', 'max'=>20),
			array('responbridging_pengajuan', 'safe'),
			array('tgl_rujukan, poli_eksekutif, cob, lakalantas, catatan, is_approval, keterangan_kejadian, tanggal_kejadian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanapprovalsep_id, pendaftaran_id, no_kartu_bpjs, namapeserta_bpjs, jenispeserta_bpjs_kode, jenispeserta_bpjs_nama, tgl_sep, kode_ppk_pelayanan, nama_ppk_pelayanan, jenis_pelayanan, kelas_tanggungan, asal_rujukan, no_rujukan, kode_ppk_rujukan, nama_ppk_rujukan, tgl_rujukan, jenisrujukan, diagnosa_awal, diagnosa_awal_nama, politujuan, politujuan_nama, poli_eksekutif, cob, lakalantas, penjamin, lokasilakalantas, no_telepon_pasien, userpembuat_bpjs, catatan, create_time, create_loginpemakai_id, is_approval, sep_id, user_approval_bpjs, namaasuransi_cob, no_asuransi_cob, propinsi_lakalantas_nama, kabupaten_lakalantas_nama, kecamatan_lakalantas_nama, suplesi_jasaraharja, no_suplesi, keterangan_kejadian, no_surat, kode_dpjp, nama_dpjp, tanggal_kejadian, propinsi_lakalantas_id, kabupaten_lakalantas_id, kecamatan_lakalantas_id, katarak, jnspengajuan_approvalsep', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'sep' => array(self::BELONGS_TO, 'SepT', 'sep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanapprovalsep_id' => 'Pengajuanapprovalsep',
			'pendaftaran_id' => 'Pendaftaran',
			'no_kartu_bpjs' => 'No Kartu Bpjs',
			'namapeserta_bpjs' => 'Namapeserta Bpjs',
			'jenispeserta_bpjs_kode' => 'Jenispeserta Bpjs Kode',
			'jenispeserta_bpjs_nama' => 'Jenispeserta Bpjs Nama',
			'tgl_sep' => 'Tgl Sep',
			'kode_ppk_pelayanan' => 'Kode Ppk Pelayanan',
			'nama_ppk_pelayanan' => 'Nama Ppk Pelayanan',
			'jenis_pelayanan' => 'Jenis Pelayanan',
			'kelas_tanggungan' => 'Kelas Tanggungan',
			'asal_rujukan' => 'Asal Rujukan',
			'no_rujukan' => 'No Rujukan',
			'kode_ppk_rujukan' => 'Kode Ppk Rujukan',
			'nama_ppk_rujukan' => 'Nama Ppk Rujukan',
			'tgl_rujukan' => 'Tgl Rujukan',
			'jenisrujukan' => 'Jenisrujukan',
			'diagnosa_awal' => 'Diagnosa Awal',
			'diagnosa_awal_nama' => 'Diagnosa Awal Nama',
			'politujuan' => 'Politujuan',
			'politujuan_nama' => 'Politujuan Nama',
			'poli_eksekutif' => 'Poli Eksekutif',
			'cob' => 'Cob',
			'lakalantas' => 'Lakalantas',
			'penjamin' => 'Penjamin',
			'lokasilakalantas' => 'Lokasilakalantas',
			'no_telepon_pasien' => 'No Telepon Pasien',
			'userpembuat_bpjs' => 'Userpembuat Bpjs',
			'catatan' => 'Catatan',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'is_approval' => 'Is Approval',
			'sep_id' => 'Sep',
			'user_approval_bpjs' => 'User Approval Bpjs',
			'namaasuransi_cob' => 'Namaasuransi Cob',
			'no_asuransi_cob' => 'No Asuransi Cob',
			'propinsi_lakalantas_nama' => 'Propinsi Lakalantas Nama',
			'kabupaten_lakalantas_nama' => 'Kabupaten Lakalantas Nama',
			'kecamatan_lakalantas_nama' => 'Kecamatan Lakalantas Nama',
			'suplesi_jasaraharja' => 'Suplesi Jasaraharja',
			'no_suplesi' => 'No Suplesi',
			'keterangan_kejadian' => 'Keterangan Kejadian',
			'no_surat' => 'No Surat',
			'kode_dpjp' => 'Kode Dpjp',
			'nama_dpjp' => 'Nama Dpjp',
			'tanggal_kejadian' => 'Tanggal Kejadian',
			'propinsi_lakalantas_id' => 'Propinsi Lakalantas',
			'kabupaten_lakalantas_id' => 'Kabupaten Lakalantas',
			'kecamatan_lakalantas_id' => 'Kecamatan Lakalantas',
			'katarak' => 'Katarak',
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

		$criteria=new CDbCriteria;

		$criteria->compare('pengajuanapprovalsep_id',$this->pengajuanapprovalsep_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_kartu_bpjs',$this->no_kartu_bpjs,true);
		$criteria->compare('namapeserta_bpjs',$this->namapeserta_bpjs,true);
		$criteria->compare('jenispeserta_bpjs_kode',$this->jenispeserta_bpjs_kode,true);
		$criteria->compare('jenispeserta_bpjs_nama',$this->jenispeserta_bpjs_nama,true);
		$criteria->compare('tgl_sep',$this->tgl_sep,true);
		$criteria->compare('kode_ppk_pelayanan',$this->kode_ppk_pelayanan,true);
		$criteria->compare('nama_ppk_pelayanan',$this->nama_ppk_pelayanan,true);
		$criteria->compare('jenis_pelayanan',$this->jenis_pelayanan,true);
		$criteria->compare('kelas_tanggungan',$this->kelas_tanggungan,true);
		$criteria->compare('asal_rujukan',$this->asal_rujukan,true);
		$criteria->compare('no_rujukan',$this->no_rujukan,true);
		$criteria->compare('kode_ppk_rujukan',$this->kode_ppk_rujukan,true);
		$criteria->compare('nama_ppk_rujukan',$this->nama_ppk_rujukan,true);
		$criteria->compare('tgl_rujukan',$this->tgl_rujukan,true);
		$criteria->compare('jenisrujukan',$this->jenisrujukan);
		$criteria->compare('diagnosa_awal',$this->diagnosa_awal,true);
		$criteria->compare('diagnosa_awal_nama',$this->diagnosa_awal_nama,true);
		$criteria->compare('politujuan',$this->politujuan,true);
		$criteria->compare('politujuan_nama',$this->politujuan_nama,true);
		$criteria->compare('poli_eksekutif',$this->poli_eksekutif);
		$criteria->compare('cob',$this->cob);
		$criteria->compare('lakalantas',$this->lakalantas);
		$criteria->compare('penjamin',$this->penjamin,true);
		$criteria->compare('lokasilakalantas',$this->lokasilakalantas,true);
		$criteria->compare('no_telepon_pasien',$this->no_telepon_pasien,true);
		$criteria->compare('userpembuat_bpjs',$this->userpembuat_bpjs,true);
		$criteria->compare('catatan',$this->catatan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('is_approval',$this->is_approval);
		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('user_approval_bpjs',$this->user_approval_bpjs,true);
		$criteria->compare('namaasuransi_cob',$this->namaasuransi_cob,true);
		$criteria->compare('no_asuransi_cob',$this->no_asuransi_cob,true);
		$criteria->compare('propinsi_lakalantas_nama',$this->propinsi_lakalantas_nama,true);
		$criteria->compare('kabupaten_lakalantas_nama',$this->kabupaten_lakalantas_nama,true);
		$criteria->compare('kecamatan_lakalantas_nama',$this->kecamatan_lakalantas_nama,true);
		$criteria->compare('suplesi_jasaraharja',$this->suplesi_jasaraharja);
		$criteria->compare('no_suplesi',$this->no_suplesi,true);
		$criteria->compare('keterangan_kejadian',$this->keterangan_kejadian,true);
		$criteria->compare('no_surat',$this->no_surat,true);
		$criteria->compare('kode_dpjp',$this->kode_dpjp,true);
		$criteria->compare('nama_dpjp',$this->nama_dpjp,true);
		$criteria->compare('tanggal_kejadian',$this->tanggal_kejadian,true);
		$criteria->compare('propinsi_lakalantas_id',$this->propinsi_lakalantas_id,true);
		$criteria->compare('kabupaten_lakalantas_id',$this->kabupaten_lakalantas_id,true);
		$criteria->compare('kecamatan_lakalantas_id',$this->kecamatan_lakalantas_id,true);
		$criteria->compare('katarak',$this->katarak);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}