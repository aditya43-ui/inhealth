<?php

/**
 * This is the model class for table "orderpemeriksaanrad_v".
 *
 * The followings are the available columns in table 'orderpemeriksaanrad_v':
 * @property string $kode_unik
 * @property string $pemeriksaanrad_nama
 * @property integer $jenispemeriksaanrad_id
 * @property string $jenispemeriksaanrad_kode
 * @property string $jenispemeriksaanrad_nama
 * @property boolean $is_paket
 */
class OrderpemeriksaanradV extends CActiveRecord
{
	
	public $jumlah_jenis, $harga_tariftindakan;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orderpemeriksaanrad_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanrad_id', 'numerical', 'integerOnly'=>true),
			array('kode_unik, pemeriksaanrad_nama, jenispemeriksaanrad_kode, jenispemeriksaanrad_nama, is_paket', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kode_unik, pemeriksaanrad_nama, jenispemeriksaanrad_id, jenispemeriksaanrad_kode, jenispemeriksaanrad_nama, is_paket', 'safe', 'on'=>'search'),
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
			'kode_unik' => 'Kode Unik',
			'pemeriksaanrad_nama' => 'Pemeriksaanrad Nama',
			'jenispemeriksaanrad_id' => 'Jenispemeriksaanrad',
			'jenispemeriksaanrad_kode' => 'Jenispemeriksaanrad Kode',
			'jenispemeriksaanrad_nama' => 'Jenispemeriksaanrad Nama',
			'is_paket' => 'Is Paket',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kode_unik',$this->kode_unik,true);
		$criteria->compare('pemeriksaanrad_nama',$this->pemeriksaanrad_nama,true);
		$criteria->compare('jenispemeriksaanrad_id',$this->jenispemeriksaanrad_id);
		$criteria->compare('jenispemeriksaanrad_kode',$this->jenispemeriksaanrad_kode,true);
		$criteria->compare('jenispemeriksaanrad_nama',$this->jenispemeriksaanrad_nama,true);
		$criteria->compare('is_paket',$this->is_paket);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderpemeriksaanradV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
