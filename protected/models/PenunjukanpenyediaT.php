<?php

/**
 * This is the model class for table "penunjukanpenyedia_t".
 * 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'penunjukanpenyedia_t':
 * @property integer $penunjukanpenyedia_id
 * @property string $penunjukanpenyedia_nomor
 * @property string $penunjukanpenyedia_tanggal
 * @property integer $supplier_id
 * @property string $nomor_dokumen
 * @property string $dasar_nomor
 * @property string $dasar_tanggal
 * @property double $harga_negosiasi
 * @property string $tanggal_awal
 * @property string $tanggal_akhir
 * @property integer $jangka_pelaksanaan
 * @property integer $persiapanpengadaan_id
 * @property integer $konfigtemplatesurat_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $penawaranpenyedia_id
 * @property string $penawaran_nomor
 * @property string $penawaran_tanggal
 *
 * The followings are the available model relations:
 * @property PenawaranpenyediaT $penawaranpenyedia
 * @property SupplierM $supplier
 * @property PersiapanpengadaanT $persiapanpengadaan
 * @property KonfigtemplatesuratK $konfigtemplatesurat
 */
class PenunjukanpenyediaT extends CActiveRecord
{
        public $supplier_nama, $direktursupplier, $supplier_alamat,
               $supplier_npwp, $dasar, $pejabat_pembuatkomitmen, $cekpenawaran;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenunjukanpenyediaT the static model class
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
		return 'penunjukanpenyedia_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_dokumen,penunjukanpenyedia_nomor, penawaran_nomor, supplier_nama, supplier_id, create_time, create_loginpemakai_id, konfigtemplatesurat_id, create_ruangan', 'required'),
			array('supplier_id, jangka_pelaksanaan, persiapanpengadaan_id, konfigtemplatesurat_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, penawaranpenyedia_id', 'numerical', 'integerOnly'=>true),
			array('harga_negosiasi', 'numerical'),
			array('penunjukanpenyedia_nomor, nomor_dokumen, dasar_nomor, penawaran_nomor', 'length', 'max'=>50),
			array('penunjukanpenyedia_tanggal, dasar_tanggal, tanggal_awal, tanggal_akhir, update_time, penawaran_tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penunjukanpenyedia_id, penunjukanpenyedia_nomor, penunjukanpenyedia_tanggal, supplier_id, nomor_dokumen, dasar_nomor, dasar_tanggal, harga_negosiasi, tanggal_awal, tanggal_akhir, jangka_pelaksanaan, persiapanpengadaan_id, konfigtemplatesurat_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, penawaranpenyedia_id, penawaran_nomor, penawaran_tanggal', 'safe', 'on'=>'search'),
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
			'penawaranpenyedia' => array(self::BELONGS_TO, 'PenawaranpenyediaT', 'penawaranpenyedia_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
			'konfigtemplatesurat' => array(self::BELONGS_TO, 'KonfigtemplatesuratK', 'konfigtemplatesurat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penunjukanpenyedia_id' => 'Penunjukanpenyedia',
			'penunjukanpenyedia_nomor' => 'Nomor Transaksi',
			'penunjukanpenyedia_tanggal' => 'Penunjukanpenyedia Tanggal',
			'supplier_id' => 'Supplier',
			'nomor_dokumen' => 'Nomor Dokumen',
			'dasar_nomor' => 'Dasar Nomor',
			'dasar_tanggal' => 'Dasar Tanggal',
			'harga_negosiasi' => 'Harga Negosiasi',
			'tanggal_awal' => 'Tanggal Awal',
			'tanggal_akhir' => 'Tanggal Akhir',
			'jangka_pelaksanaan' => 'Jangka Pelaksanaan',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'konfigtemplatesurat_id' => 'Template Surat',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'penawaranpenyedia_id' => 'Penawaranpenyedia',
			'penawaran_nomor' => 'Penawaran Nomor',
			'penawaran_tanggal' => 'Penawaran Tanggal',
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

		$criteria->compare('penunjukanpenyedia_id',$this->penunjukanpenyedia_id);
		$criteria->compare('penunjukanpenyedia_nomor',$this->penunjukanpenyedia_nomor,true);
		$criteria->compare('penunjukanpenyedia_tanggal',$this->penunjukanpenyedia_tanggal,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('nomor_dokumen',$this->nomor_dokumen,true);
		$criteria->compare('dasar_nomor',$this->dasar_nomor,true);
		$criteria->compare('dasar_tanggal',$this->dasar_tanggal,true);
		$criteria->compare('harga_negosiasi',$this->harga_negosiasi);
		$criteria->compare('tanggal_awal',$this->tanggal_awal,true);
		$criteria->compare('tanggal_akhir',$this->tanggal_akhir,true);
		$criteria->compare('jangka_pelaksanaan',$this->jangka_pelaksanaan);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('konfigtemplatesurat_id',$this->konfigtemplatesurat_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('penawaranpenyedia_id',$this->penawaranpenyedia_id);
		$criteria->compare('penawaran_nomor',$this->penawaran_nomor,true);
		$criteria->compare('penawaran_tanggal',$this->penawaran_tanggal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}