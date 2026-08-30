<?php

/**
 * This is the model class for table "infoumumpengadaan_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * The followings are the available columns in table 'infoumumpengadaan_t':
 * @property integer $infoumumpengadaan_id
 * @property integer $persiapanpengadaan_id
 * @property integer $supplier_id
 * @property integer $pegpa_id
 * @property integer $pegkpa_id
 * @property integer $pegppk_id
 * @property integer $pegpengadaan_id
 * @property string $jabatan_pengadaan
 * @property string $no_sk
 * @property string $tgl_sk
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SupplierM $supplier
 * @property PegawaiM $pegpengadaan
 * @property PegawaiM $pegppk
 * @property PegawaiM $pegkpa
 * @property PegawaiM $pegpa
 * @property PersiapanpengadaanT $persiapanpengadaan
 */
class InfoumumpengadaanT extends CActiveRecord
{
        public $pegpa_nama, $pegkpa_nama, $pegppk_nama, $pegpengadaan_nama, $temp_file, 
               $supplier_kode, $supplier_nama, $nama_pekerjaan, $persiapanpengadaan_nomor, $keterangan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoumumpengadaanT the static model class
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
		return 'infoumumpengadaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persiapanpengadaan_id, pegpa_id, pegkpa_id, pegppk_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('persiapanpengadaan_id, supplier_id, pegpa_id, pegkpa_id, pegppk_id, pegpengadaan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jabatan_pengadaan', 'length', 'max'=>100),
			array('no_sk', 'length', 'max'=>50),
			array('pegpengadaan_id, jabatan_pengadaan, no_sk, tgl_sk, infoumumpengadaan_status, nomor_referensi, dokumen_pendukung, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('infoumumpengadaan_id, persiapanpengadaan_id, supplier_id, pegpa_id, pegkpa_id, pegppk_id, pegpengadaan_id, jabatan_pengadaan, no_sk, tgl_sk, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'pegpengadaan' => array(self::BELONGS_TO, 'PegawaiM', 'pegpengadaan_id'),
			'pegppk' => array(self::BELONGS_TO, 'PegawaiM', 'pegppk_id'),
			'pegkpa' => array(self::BELONGS_TO, 'PegawaiM', 'pegkpa_id'),
			'pegpa' => array(self::BELONGS_TO, 'PegawaiM', 'pegpa_id'),
			'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'infoumumpengadaan_id' => 'Infoumumpengadaan',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'supplier_id' => 'Supplier',
			'pegpa_id' => 'Pegpa',
			'pegkpa_id' => 'Pegkpa',
			'pegppk_id' => 'Pegppk',
			'pegpengadaan_id' => 'Pegpengadaan',
			'jabatan_pengadaan' => 'Jabatan Pengadaan',
			'no_sk' => 'No Sk',
			'tgl_sk' => 'Tgl Sk',
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

		$criteria->compare('infoumumpengadaan_id',$this->infoumumpengadaan_id);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('pegpa_id',$this->pegpa_id);
		$criteria->compare('pegkpa_id',$this->pegkpa_id);
		$criteria->compare('pegppk_id',$this->pegppk_id);
		$criteria->compare('pegpengadaan_id',$this->pegpengadaan_id);
		$criteria->compare('jabatan_pengadaan',$this->jabatan_pengadaan,true);
		$criteria->compare('no_sk',$this->no_sk,true);
		$criteria->compare('tgl_sk',$this->tgl_sk,true);
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