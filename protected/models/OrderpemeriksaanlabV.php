<?php

/**
 * This is the model class for table "orderpemeriksaanlab_v".
 *
 * The followings are the available columns in table 'orderpemeriksaanlab_v':
 * @property string $kode_unik
 * @property string $pemeriksaanlab_nama
 * @property integer $jenispemeriksaanlab_id
 * @property string $jenispemeriksaanlab_kode
 * @property string $jenispemeriksaanlab_nama
 * @property string $jenispemeriksaanlab_kelompok
 * @property boolean $is_paket
 */
class OrderpemeriksaanlabV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orderpemeriksaanlab_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanlab_id', 'numerical', 'integerOnly'=>true),
			array('kode_unik, pemeriksaanlab_nama, jenispemeriksaanlab_kode, jenispemeriksaanlab_nama, jenispemeriksaanlab_kelompok, is_paket', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kode_unik, pemeriksaanlab_nama, jenispemeriksaanlab_id, jenispemeriksaanlab_kode, jenispemeriksaanlab_nama, jenispemeriksaanlab_kelompok, is_paket', 'safe', 'on'=>'search'),
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
			'pemeriksaanlab_nama' => 'Pemeriksaanlab Nama',
			'jenispemeriksaanlab_id' => 'Jenispemeriksaanlab',
			'jenispemeriksaanlab_kode' => 'Jenispemeriksaanlab Kode',
			'jenispemeriksaanlab_nama' => 'Jenispemeriksaanlab Nama',
			'jenispemeriksaanlab_kelompok' => 'Jenispemeriksaanlab Kelompok',
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
		$criteria->compare('pemeriksaanlab_nama',$this->pemeriksaanlab_nama,true);
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('jenispemeriksaanlab_kode',$this->jenispemeriksaanlab_kode,true);
		$criteria->compare('jenispemeriksaanlab_nama',$this->jenispemeriksaanlab_nama,true);
		$criteria->compare('jenispemeriksaanlab_kelompok',$this->jenispemeriksaanlab_kelompok,true);
		$criteria->compare('is_paket',$this->is_paket);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderpemeriksaanlabV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
