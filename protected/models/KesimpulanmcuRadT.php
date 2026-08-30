<?php

/**
 * This is the model class for table "kesimpulanmcu_rad_t".
 *
 * The followings are the available columns in table 'kesimpulanmcu_rad_t':
 * @property integer $kesimpulanmcu_rad_id
 * @property integer $kesimpulanmcu_id
 * @property integer $pemeriksaanrad_id
 * @property integer $hasilpemeriksaanrad_id
 * @property string $namapemeriksaanrad
 * @property string $keteranganhasil
 *
 * The followings are the available model relations:
 * @property HasilpemeriksaanradT $hasilpemeriksaanrad
 * @property KesimpulanmcuT $kesimpulanmcu
 * @property PemeriksaanradM $pemeriksaanrad
 */
class KesimpulanmcuRadT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kesimpulanmcu_rad_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kesimpulanmcu_id, pemeriksaanrad_id, hasilpemeriksaanrad_id', 'numerical', 'integerOnly'=>true),
			array('namapemeriksaanrad', 'length', 'max'=>150),
			array('keteranganhasil', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kesimpulanmcu_rad_id, kesimpulanmcu_id, pemeriksaanrad_id, hasilpemeriksaanrad_id, namapemeriksaanrad, keteranganhasil', 'safe', 'on'=>'search'),
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
			'hasilpemeriksaanrad' => array(self::BELONGS_TO, 'HasilpemeriksaanradT', 'hasilpemeriksaanrad_id'),
			'kesimpulanmcu' => array(self::BELONGS_TO, 'KesimpulanmcuT', 'kesimpulanmcu_id'),
			'pemeriksaanrad' => array(self::BELONGS_TO, 'PemeriksaanradM', 'pemeriksaanrad_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kesimpulanmcu_rad_id' => 'Kesimpulanmcu Rad',
			'kesimpulanmcu_id' => 'Kesimpulanmcu',
			'pemeriksaanrad_id' => 'Pemeriksaanrad',
			'hasilpemeriksaanrad_id' => 'Hasilpemeriksaanrad',
			'namapemeriksaanrad' => 'Namapemeriksaanrad',
			'keteranganhasil' => 'Keteranganhasil',
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

		$criteria->compare('kesimpulanmcu_rad_id',$this->kesimpulanmcu_rad_id);
		$criteria->compare('kesimpulanmcu_id',$this->kesimpulanmcu_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('hasilpemeriksaanrad_id',$this->hasilpemeriksaanrad_id);
		$criteria->compare('namapemeriksaanrad',$this->namapemeriksaanrad,true);
		$criteria->compare('keteranganhasil',$this->keteranganhasil,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KesimpulanmcuRadT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
