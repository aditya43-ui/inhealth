<?php

/**
 * This is the model class for table "caraambilsampel_m".
 *
 * The followings are the available columns in table 'caraambilsampel_m':
 * @property integer $caraambilsampel_id
 * @property string $jenispemeriksaanlab_kelompok
 * @property integer $jenispemeriksaanlab_id
 * @property string $caraambilsampel_nama
 * @property string $jenispemeriksaanlab_nama
 * @property string $caraambilsampel_kode
 * @property string $caraambilsampel_urutan
 * @property boolean $caraambilsampel_aktif
 * @property integer $samplelab_id
 * @property string $samplelab_nama
 */
class CaraambilsampelM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'caraambilsampel_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanlab_kelompok,caraambilsampel_nama', 'required'),
			array('jenispemeriksaanlab_id, samplelab_id,', 'numerical', 'integerOnly'=>true),
			array('jenispemeriksaanlab_kelompok', 'length', 'max'=>50),
			array('caraambilsampel_nama, jenispemeriksaanlab_nama, samplelab_nama', 'length', 'max'=>100),
			array('caraambilsampel_kode, caraambilsampel_urutan', 'length', 'max'=>20),
			array('caraambilsampel_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('caraambilsampel_id, jenispemeriksaanlab_kelompok, jenispemeriksaanlab_id, caraambilsampel_nama, jenispemeriksaanlab_nama, caraambilsampel_kode, caraambilsampel_urutan, caraambilsampel_aktif, samplelab_id, samplelab_nama', 'safe', 'on'=>'search'),
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
			'caraambilsampel_id' => 'Caraambilsampel',
			'jenispemeriksaanlab_kelompok' => 'Jenispemeriksaanlab Kelompok',
			'jenispemeriksaanlab_id' => 'Jenispemeriksaanlab',
			'caraambilsampel_nama' => 'Cara Ambil Sampel',
			'jenispemeriksaanlab_nama' => 'Jenispemeriksaanlab Nama',
			'caraambilsampel_kode' => ' Kode',
			'caraambilsampel_urutan' => ' Urutan',
			'caraambilsampel_aktif' => 'Caraambilsampel Aktif',
			'samplelab_id' => 'Samplelab',
			'samplelab_nama' => 'Samplelab Nama',
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

		$criteria->compare('caraambilsampel_id',$this->caraambilsampel_id);
		$criteria->compare('jenispemeriksaanlab_kelompok',$this->jenispemeriksaanlab_kelompok,true);
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('caraambilsampel_nama',$this->caraambilsampel_nama,true);
		$criteria->compare('jenispemeriksaanlab_nama',$this->jenispemeriksaanlab_nama,true);
		$criteria->compare('caraambilsampel_kode',$this->caraambilsampel_kode,true);
		$criteria->compare('caraambilsampel_urutan',$this->caraambilsampel_urutan,true);
		$criteria->compare('caraambilsampel_aktif',$this->caraambilsampel_aktif);
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('samplelab_nama',$this->samplelab_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CaraambilsampelM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
