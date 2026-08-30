<?php

/**
 * This is the model class for table "pengumumanpemenang_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'pengumumanpemenang_t':
 * @property integer $pengumumanpemenang_t
 * @property string $pengumumanpemenang_nomor
 * @property string $pengumumanpemenang_tanggal
 * @property string $nomor_dokumen
 * @property integer $penetapanpemenang_id
 * @property integer $penyedia_id
 * @property string $nama_pekerjaan
 * @property string $harga_negosiasi
 * @property integer $pegawai_id
 * @property string $peg_jabatan
 * @property integer $konfigtemplatesurat_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property KonfigtemplatesuratK $konfigtemplatesurat
 * @property PegawaiM $pegawai
 * @property PenyediaM $penyedia
 * @property PenetapanpemenangT $penetapanpemenang
 */
class PengumumanpemenangT extends CActiveRecord
{
        public $persiapanpengadaan_id, $penyedia_nama, $penyedia_alamat, $penyedia_direktur,
               $penetapanpemenang_tanggal, $pegawai_nama, $jabatan, 
               $nomorindukpegawai, $penetapanpemenang_nomor, $dasar, $cekPenetapan,
               $npwp, $supplier_nama, $supplier_npwp, $supplier_alamat, $direktursupplier;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengumumanpemenangT the static model class
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
		return 'pengumumanpemenang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_dokumen,pengumumanpemenang_nomor, pengumumanpemenang_tanggal, penetapanpemenang_id, nama_pekerjaan, harga_negosiasi, konfigtemplatesurat_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('penetapanpemenang_id, supplier_id, penyedia_id, pegawai_id, konfigtemplatesurat_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pengumumanpemenang_nomor, nomor_dokumen', 'length', 'max'=>50),
			array('nama_pekerjaan', 'length', 'max'=>500),
			array('peg_jabatan', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengumumanpemenang_t, pengumumanpemenang_nomor, pengumumanpemenang_tanggal, update_time, nomor_dokumen, penetapanpemenang_id, penyedia_id, nama_pekerjaan, harga_negosiasi, pegawai_id, peg_jabatan, konfigtemplatesurat_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'konfigtemplatesurat' => array(self::BELONGS_TO, 'KonfigtemplatesuratK', 'konfigtemplatesurat_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'penyedia' => array(self::BELONGS_TO, 'PenyediaM', 'penyedia_id'),
			'penetapanpemenang' => array(self::BELONGS_TO, 'PenetapanpemenangT', 'penetapanpemenang_id'),
                        'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengumumanpemenang_t' => 'Pengumumanpemenang T',
			'pengumumanpemenang_nomor' => 'Nomor Transaksi',
			'pengumumanpemenang_tanggal' => 'Pengumumanpemenang Tanggal',
			'nomor_dokumen' => 'Nomor Dokumen',
			'penetapanpemenang_id' => 'Penetapanpemenang',
			'penyedia_id' => 'Penyedia',
			'nama_pekerjaan' => 'Nama Pekerjaan',
			'harga_negosiasi' => 'Harga Negosiasi',
			'pegawai_id' => 'Pegawai',
			'peg_jabatan' => 'Peg Jabatan',
			'konfigtemplatesurat_id' => 'Template Surat',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('pengumumanpemenang_t',$this->pengumumanpemenang_t);
		$criteria->compare('pengumumanpemenang_nomor',$this->pengumumanpemenang_nomor,true);
		$criteria->compare('pengumumanpemenang_tanggal',$this->pengumumanpemenang_tanggal,true);
		$criteria->compare('nomor_dokumen',$this->nomor_dokumen,true);
		$criteria->compare('penetapanpemenang_id',$this->penetapanpemenang_id);
		$criteria->compare('penyedia_id',$this->penyedia_id);
		$criteria->compare('nama_pekerjaan',$this->nama_pekerjaan,true);
		$criteria->compare('harga_negosiasi',$this->harga_negosiasi,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('peg_jabatan',$this->peg_jabatan,true);
		$criteria->compare('konfigtemplatesurat_id',$this->konfigtemplatesurat_id);
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