<?php

/**
 * This is the model class for table "informasipermohonanpinjaman_v".
 *
 * The followings are the available columns in table 'informasipermohonanpinjaman_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $agama
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property string $kode_pos
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $keanggotaan_id
 * @property string $tglkeanggotaaan
 * @property string $nokeanggotaan
 * @property integer $permohonanpinjaman_id
 * @property string $tglpermohonanpinjaman
 * @property string $nopermohonan
 * @property string $jenispinjaman_permohonan
 * @property double $jmlpinjaman
 * @property integer $jangkawaktu_pinj_bln
 * @property double $jasapinjaman_bln
 * @property string $untukkeperluan
 * @property double $jmlinsentif
 * @property double $jmlsimpanan
 * @property double $jmlpenghasilanlain
 * @property double $jmltunggakanuangpinj
 * @property double $jmltunggakanbrgpinj
 * @property double $batasplafon
 * @property integer $petugas_id
 * @property integer $pinjaman_id
 * @property string $no_pinjaman
 * @property string $tglpinjaman
 * @property integer $approval_id
 * @property string $tglapproval
 * @property string $keteranganapproval
 * @property integer $appr_diperiksaoleh_id
 * @property string $appr_tgldiperiksa
 * @property integer $appr_disetujuioleh_id
 * @property string $appr_tgldisetujui
 * @property boolean $status_disetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InformasipermohonanpinjamanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipermohonanpinjamanV the static model class
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
		return 'informasipermohonanpinjaman_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, kelurahan_id, golonganpegawai_id, pangkat_id, jabatan_id, keanggotaan_id, permohonanpinjaman_id, jangkawaktu_pinj_bln, petugas_id, pinjaman_id, approval_id, appr_diperiksaoleh_id, appr_disetujuioleh_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmlpinjaman, jasapinjaman_bln, jmlinsentif, jmlsimpanan, jmlpenghasilanlain, jmltunggakanuangpinj, jmltunggakanbrgpinj, batasplafon', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, kelurahan_nama, golonganpegawai_nama, pangkat_nama, nokeanggotaan, nopermohonan, jenispinjaman_permohonan, no_pinjaman', 'length', 'max'=>50),
			array('jeniskelamin, agama, statusperkawinan', 'length', 'max'=>20),
			array('kode_pos', 'length', 'max'=>15),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglkeanggotaaan, tglpermohonanpinjaman, untukkeperluan, tglpinjaman, tglapproval, keteranganapproval, appr_tgldiperiksa, appr_tgldisetujui, status_disetujui, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, agama, statusperkawinan, alamat_pegawai, kelurahan_id, kelurahan_nama, kode_pos, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, pangkat_id, pangkat_nama, jabatan_id, jabatan_nama, keanggotaan_id, tglkeanggotaaan, nokeanggotaan, permohonanpinjaman_id, tglpermohonanpinjaman, nopermohonan, jenispinjaman_permohonan, jmlpinjaman, jangkawaktu_pinj_bln, jasapinjaman_bln, untukkeperluan, jmlinsentif, jmlsimpanan, jmlpenghasilanlain, jmltunggakanuangpinj, jmltunggakanbrgpinj, batasplafon, petugas_id, pinjaman_id, no_pinjaman, tglpinjaman, approval_id, tglapproval, keteranganapproval, appr_diperiksaoleh_id, appr_tgldiperiksa, appr_disetujuioleh_id, appr_tgldisetujui, status_disetujui, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'agama' => 'Agama',
			'statusperkawinan' => 'Statusperkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kode_pos' => 'Kode Pos',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'tglkeanggotaaan' => 'Tglkeanggotaaan',
			'nokeanggotaan' => 'No Keanggotaan',
			'permohonanpinjaman_id' => 'Permohonanpinjaman',
			'tglpermohonanpinjaman' => 'Tglpermohonanpinjaman',
			'nopermohonan' => 'No Permohonan',
			'jenispinjaman_permohonan' => 'Jenis Pinjaman',
			'jmlpinjaman' => 'Jumlah Pinjaman',
			'jangkawaktu_pinj_bln' => 'Jangkawaktu Pinj Bln',
			'jasapinjaman_bln' => 'Jasapinjaman Bln',
			'untukkeperluan' => 'Untuk Keperluan',
			'jmlinsentif' => 'Jmlinsentif',
			'jmlsimpanan' => 'Jmlsimpanan',
			'jmlpenghasilanlain' => 'Jmlpenghasilanlain',
			'jmltunggakanuangpinj' => 'Tunggakan Pinjaman Uang',
			'jmltunggakanbrgpinj' => 'Tunggakan Pinjaman Barang',
			'batasplafon' => 'Batas Plafon',
			'petugas_id' => 'Petugas',
			'pinjaman_id' => 'Pinjaman',
			'no_pinjaman' => 'No Pinjaman',
			'tglpinjaman' => 'Tglpinjaman',
			'approval_id' => 'Approval',
			'tglapproval' => 'Tglapproval',
			'keteranganapproval' => 'Keteranganapproval',
			'appr_diperiksaoleh_id' => 'Appr Diperiksaoleh',
			'appr_tgldiperiksa' => 'Appr Tgldiperiksa',
			'appr_disetujuioleh_id' => 'Appr Disetujuioleh',
			'appr_tgldisetujui' => 'Disetujui Oleh',
			'status_disetujui' => 'Status Disetujui',
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
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kode_pos',$this->kode_pos,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('tglkeanggotaaan',$this->tglkeanggotaaan,true);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('permohonanpinjaman_id',$this->permohonanpinjaman_id);
		$criteria->compare('tglpermohonanpinjaman',$this->tglpermohonanpinjaman,true);
		$criteria->compare('nopermohonan',$this->nopermohonan,true);
		$criteria->compare('jenispinjaman_permohonan',$this->jenispinjaman_permohonan,true);
		$criteria->compare('jmlpinjaman',$this->jmlpinjaman);
		$criteria->compare('jangkawaktu_pinj_bln',$this->jangkawaktu_pinj_bln);
		$criteria->compare('jasapinjaman_bln',$this->jasapinjaman_bln);
		$criteria->compare('untukkeperluan',$this->untukkeperluan,true);
		$criteria->compare('jmlinsentif',$this->jmlinsentif);
		$criteria->compare('jmlsimpanan',$this->jmlsimpanan);
		$criteria->compare('jmlpenghasilanlain',$this->jmlpenghasilanlain);
		$criteria->compare('jmltunggakanuangpinj',$this->jmltunggakanuangpinj);
		$criteria->compare('jmltunggakanbrgpinj',$this->jmltunggakanbrgpinj);
		$criteria->compare('batasplafon',$this->batasplafon);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('no_pinjaman',$this->no_pinjaman,true);
		$criteria->compare('tglpinjaman',$this->tglpinjaman,true);
		$criteria->compare('approval_id',$this->approval_id);
		$criteria->compare('tglapproval',$this->tglapproval,true);
		$criteria->compare('keteranganapproval',$this->keteranganapproval,true);
		$criteria->compare('appr_diperiksaoleh_id',$this->appr_diperiksaoleh_id);
		$criteria->compare('appr_tgldiperiksa',$this->appr_tgldiperiksa,true);
		$criteria->compare('appr_disetujuioleh_id',$this->appr_disetujuioleh_id);
		$criteria->compare('appr_tgldisetujui',$this->appr_tgldisetujui,true);
		$criteria->compare('status_disetujui',$this->status_disetujui);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}