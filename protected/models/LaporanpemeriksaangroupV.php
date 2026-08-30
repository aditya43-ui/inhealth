<?php

/**
 * This is the model class for table "laporanpemeriksaangroup_v".
 *
 * The followings are the available columns in table 'laporanpemeriksaangroup_v':
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_katakunci
 * @property integer $pasienmasukpenunjang_id
 * @property string $no_masukpenunjang
 * @property double $tarif_satuan
 * @property integer $qty_tindakan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $tindakansudahbayar_id
 * @property string $tgl_tindakan
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tglmasukpenunjang
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property double $jmlbayar_tindakan
 * @property double $jmlsisabayar_tindakan
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property double $tarif_tindakan
 * @property string $tgl_pendaftaran
 */
class LaporanpemeriksaangroupV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpemeriksaangroupV the static model class
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
		return 'laporanpemeriksaangroup_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakanpelayanan_id, daftartindakan_id, pasienmasukpenunjang_id, qty_tindakan, tindakansudahbayar_id, pendaftaran_id, carabayar_id, penjamin_id, pasien_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('tarif_satuan, jmlbayar_tindakan, jmlsisabayar_tindakan, tarif_tindakan', 'numerical'),
			array('daftartindakan_kode, no_masukpenunjang, no_pendaftaran, jeniskelamin', 'length', 'max'=>20),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('daftartindakan_katakunci', 'length', 'max'=>30),
			array('carabayar_nama, penjamin_nama, nama_pasien, ruangan_nama', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tempat_lahir', 'length', 'max'=>25),
			array('create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_tindakan, tglmasukpenunjang, tanggal_lahir, alamat_pasien, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanpelayanan_id, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, daftartindakan_katakunci, pasienmasukpenunjang_id, no_masukpenunjang, tarif_satuan, qty_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tindakansudahbayar_id, tgl_tindakan, pendaftaran_id, no_pendaftaran, tglmasukpenunjang, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, pasien_id, no_rekam_medik, nama_pasien, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, jmlbayar_tindakan, jmlsisabayar_tindakan, ruangan_id, ruangan_nama, tarif_tindakan, tgl_pendaftaran', 'safe', 'on'=>'search'),
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
			'tindakanpelayanan_id' => 'Tindakan Pelayanan',
			'daftartindakan_id' => 'Daftar Tindakan',
			'daftartindakan_kode' => 'Kode Daftar Tindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'daftartindakan_katakunci' => 'Kata Kunci',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'no_masukpenunjang' => 'No. Masuk Penunjang',
			'tarif_satuan' => 'Tarif Satuan',
			'qty_tindakan' => 'Jumlah Tindakan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tindakansudahbayar_id' => 'Tindakan Sudah Bayar',
			'tgl_tindakan' => 'Tanggal Tindakan',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tglmasukpenunjang' => 'Tanggal Masuk Penunjang',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'jmlbayar_tindakan' => 'Jumlah Bayar Tindakan',
			'jmlsisabayar_tindakan' => 'Jumlah Sisa Bayar Tindakan',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'tarif_tindakan' => 'Nominal Tarif',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
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

		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('daftartindakan_katakunci',$this->daftartindakan_katakunci,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('tgl_tindakan',$this->tgl_tindakan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tglmasukpenunjang',$this->tglmasukpenunjang,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('jmlbayar_tindakan',$this->jmlbayar_tindakan);
		$criteria->compare('jmlsisabayar_tindakan',$this->jmlsisabayar_tindakan);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}