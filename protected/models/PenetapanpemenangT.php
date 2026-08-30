<?php

/**
 * This is the model class for table "penetapanpemenang_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'penetapanpemenang_t':
 * @property integer $penetapanpemenang_id
 * @property string $penetapanpemenang_nomor
 * @property string $penetapanpemenang_tanggal
 * @property string $nomor_dokumen
 * @property string $dasar_nomor
 * @property string $dasar_tanggal
 * @property integer $persiapanpengadaan_id
 * @property integer $penawaranpenyedia_id
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
 * @property PenawaranpenyediaT $penawaranpenyedia
 * @property PenyediaM $penyedia
 * @property PegawaiM $pegawai
 * @property PersiapanpengadaanT $persiapanpengadaan
 * @property PengumumanpemenangT[] $pengumumanpemenangTs
 */
class PenetapanpemenangT extends CActiveRecord
{
        public $nama_pegawai, $jabatan, $pegawai_nama, $nomorindukpegawai,
               $npwp, $harga_negosisasi, $supplier_nama, $supplier_alamat,
               $direktursupplier, $supplier_npwp, $dasar, $infoumumpengadaan_id, $cekpenawaran;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenetapanpemenangT the static model class
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
		return 'penetapanpemenang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_dokumen,penetapanpemenang_nomor, penetapanpemenang_tanggal, persiapanpengadaan_id, nama_pekerjaan, harga_negosiasi, konfigtemplatesurat_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('persiapanpengadaan_id, supplier_id, penawaranpenyedia_id, penyedia_id, pegawai_id, konfigtemplatesurat_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('penetapanpemenang_nomor, nomor_dokumen, dasar_nomor', 'length', 'max'=>50),
			array('nama_pekerjaan', 'length', 'max'=>500),
			array('peg_jabatan', 'length', 'max'=>100),
			array('dasar_tanggal, penawaran_nomor, penawaran_tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penetapanpemenang_id, penetapanpemenang_nomor, penetapanpemenang_tanggal, nomor_dokumen, dasar_nomor, dasar_tanggal, persiapanpengadaan_id, penawaranpenyedia_id, penyedia_id, nama_pekerjaan, harga_negosiasi, pegawai_id, peg_jabatan, konfigtemplatesurat_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'penawaranpenyedia' => array(self::BELONGS_TO, 'PenawaranpenyediaT', 'penawaranpenyedia_id'),
			'penyedia' => array(self::BELONGS_TO, 'PenyediaM', 'penyedia_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
			'pengumumanpemenangTs' => array(self::HAS_MANY, 'PengumumanpemenangT', 'penetapanpemenang_id'),
                        'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penetapanpemenang_id' => 'Penetapanpemenang',
			'penetapanpemenang_nomor' => 'Nomor Transaksi',
			'penetapanpemenang_tanggal' => 'Penetapanpemenang Tanggal',
			'nomor_dokumen' => 'Nomor Dokumen',
			'dasar_nomor' => 'Dasar Nomor',
			'dasar_tanggal' => 'Dasar Tanggal',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'penawaranpenyedia_id' => 'Penawaranpenyedia',
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
			'supplier_id' => 'Supplier',
		);
	}
        
        public function criteriaSearch(){
            // Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('penetapanpemenang_id',$this->penetapanpemenang_id);
		$criteria->compare('penetapanpemenang_nomor',$this->penetapanpemenang_nomor,true);
		$criteria->compare('penetapanpemenang_tanggal',$this->penetapanpemenang_tanggal,true);
		$criteria->compare('nomor_dokumen',$this->nomor_dokumen,true);
		$criteria->compare('dasar_nomor',$this->dasar_nomor,true);
		$criteria->compare('dasar_tanggal',$this->dasar_tanggal,true);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('penawaranpenyedia_id',$this->penawaranpenyedia_id);
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
                return $criteria;
        }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
            $criteria = $this->criteriaSearch();
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
        
        /**
         * Load data penetapan pemenang
         * @return \CActiveDataProvider
         */
        public function searchDialogPenetapan(){
            $criteria = $this->criteriaSearch();
            $criteria->limit = 10;
            $criteria->select = "t.*, sup.supplier_nama, sup.supplier_alamat, sup.direktursupplier, "
                                . "sup.supplier_npwp, peg.pegawai_id, "
                                . "peg.nama_pegawai, peg.nomorindukpegawai, jab.jabatan_nama AS jabatan";
            $criteria->join = "LEFT JOIN supplier_m sup ON sup.supplier_id = t.supplier_id "
                            . "LEFT JOIN pegawai_m peg ON t.pegawai_id = peg.pegawai_id "
                            . "LEFT JOIN jabatan_m jab ON peg.jabatan_id = jab.jabatan_id";
            $criteria->addCondition('persiapanpengadaan_id = '.$_GET['id']);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
            
        }
}