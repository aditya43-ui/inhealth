<?php

/**
 * This is the model class for table "perintahmulaikerja_t".
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'perintahmulaikerja_t':
 * @property integer $perintahmulaikerja_id
 * @property string $perintahmulaikerja_nomor
 * @property string $perintahmulaikerja_tanggal
 * @property string $nomor_dokumen
 * @property integer $supplier_id
 * @property string $nama_direktur
 * @property integer $pegppk_id
 * @property integer $suratperjanjiankerja_id
 * @property integer $konfigtemplatesurat_id
 * @property integer $persiapanpengadaan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PersiapanpengadaanT $persiapanpengadaan
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property SupplierM $supplier
 * @property PegawaiM $pegppk
 * @property KonfigtemplatesuratK $konfigtemplatesurat
 */
class PerintahmulaikerjaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerintahmulaikerjaT the static model class
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
		return 'perintahmulaikerja_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_dokumen,perintahmulaikerja_nomor, perintahmulaikerja_tanggal, pegppk_id, suratperjanjiankerja_id, konfigtemplatesurat_id, persiapanpengadaan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('supplier_id, pegppk_id, suratperjanjiankerja_id, konfigtemplatesurat_id, persiapanpengadaan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('perintahmulaikerja_nomor, nomor_dokumen', 'length', 'max'=>50),
			array('nama_direktur', 'length', 'max'=>255),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perintahmulaikerja_id, perintahmulaikerja_nomor, perintahmulaikerja_tanggal, nomor_dokumen, supplier_id, nama_direktur, pegppk_id, suratperjanjiankerja_id, konfigtemplatesurat_id, persiapanpengadaan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'pegppk' => array(self::BELONGS_TO, 'PegawaiM', 'pegppk_id'),
			'konfigtemplatesurat' => array(self::BELONGS_TO, 'KonfigtemplatesuratK', 'konfigtemplatesurat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perintahmulaikerja_id' => 'Perintahmulaikerja',
			'perintahmulaikerja_nomor' => 'Nomor Transaksi',
			'perintahmulaikerja_tanggal' => 'Perintahmulaikerja Tanggal',
			'nomor_dokumen' => 'Nomor Dokumen',
			'supplier_id' => 'Supplier',
			'nama_direktur' => 'Nama Direktur',
			'pegppk_id' => 'Pegppk',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'konfigtemplatesurat_id' => 'Template Surat',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
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

		$criteria->compare('perintahmulaikerja_id',$this->perintahmulaikerja_id);
		$criteria->compare('perintahmulaikerja_nomor',$this->perintahmulaikerja_nomor,true);
		$criteria->compare('perintahmulaikerja_tanggal',$this->perintahmulaikerja_tanggal,true);
		$criteria->compare('nomor_dokumen',$this->nomor_dokumen,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('nama_direktur',$this->nama_direktur,true);
		$criteria->compare('pegppk_id',$this->pegppk_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('konfigtemplatesurat_id',$this->konfigtemplatesurat_id);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
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