<?php

/**
 * This is the model class for table "integumen_t".
 *
 * The followings are the available columns in table 'integumen_t':
 * @property integer $integumen_id
 * @property integer $pemeriksaanfisik_id
 * @property string $warna
 * @property string $tugor
 * @property string $integritas
 * @property integer $norton_kondisifisik
 * @property integer $norton_statusmental
 * @property integer $norton_aktifitas
 * @property integer $norton_mobilitas
 * @property integer $norton_inkontinesia
 * @property integer $norton_totalskor
 * @property string $kesimpulan
 *
 * The followings are the available model relations:
 * @property PemeriksaanfisikT $pemeriksaanfisik
 */
class IntegumenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntegumenT the static model class
	 */
	public $integumen;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'integumen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanfisik_id, norton_kondisifisik, norton_statusmental, norton_aktifitas, norton_mobilitas, norton_inkontinesia, norton_totalskor', 'numerical', 'integerOnly'=>true),
			array('warna, tugor, integritas, kesimpulan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('integumen_id, pemeriksaanfisik_id, warna, tugor, integritas, norton_kondisifisik, norton_statusmental, norton_aktifitas, norton_mobilitas, norton_inkontinesia, norton_totalskor, kesimpulan', 'safe', 'on'=>'search'),
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
			'pemeriksaanfisik' => array(self::BELONGS_TO, 'PemeriksaanfisikT', 'pemeriksaanfisik_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'integumen_id' => 'Integumen',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'warna' => 'Warna',
			'tugor' => 'Turgor',
			'integritas' => 'Integritas',
			'norton_kondisifisik' => 'Norton Kondisifisik',
			'norton_statusmental' => 'Norton Statusmental',
			'norton_aktifitas' => 'Norton Aktifitas',
			'norton_mobilitas' => 'Norton Mobilitas',
			'norton_inkontinesia' => 'Norton Inkontinesia',
			'norton_totalskor' => 'Norton Totalskor',
			'kesimpulan' => 'Kesimpulan',
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

		$criteria->compare('integumen_id',$this->integumen_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('warna',$this->warna,true);
		$criteria->compare('tugor',$this->tugor,true);
		$criteria->compare('integritas',$this->integritas,true);
		$criteria->compare('norton_kondisifisik',$this->norton_kondisifisik);
		$criteria->compare('norton_statusmental',$this->norton_statusmental);
		$criteria->compare('norton_aktifitas',$this->norton_aktifitas);
		$criteria->compare('norton_mobilitas',$this->norton_mobilitas);
		$criteria->compare('norton_inkontinesia',$this->norton_inkontinesia);
		$criteria->compare('norton_totalskor',$this->norton_totalskor);
		$criteria->compare('kesimpulan',$this->kesimpulan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}