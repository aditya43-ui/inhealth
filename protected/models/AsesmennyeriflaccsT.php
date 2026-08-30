<?php

/**
 * This is the model class for table "asesmennyeriflaccs_t".
 *
 * The followings are the available columns in table 'asesmennyeriflaccs_t':
 * @property integer $asesmennyericcs_id
 * @property integer $pemeriksaanfisik_id
 * @property integer $skalanyeriflaccs_id
 *
 * The followings are the available model relations:
 * @property PemeriksaanfisikT $pemeriksaanfisik
 * @property SkalanyeriflaccsM $skalanyeriflaccs
 */
class AsesmennyeriflaccsT extends CActiveRecord
{
	public $ispilih;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmennyeriflaccsT the static model class
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
		return 'asesmennyeriflaccs_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanfisik_id, skalanyeriflaccs_id', 'required'),
			array('pemeriksaanfisik_id, skalanyeriflaccs_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmennyericcs_id, pemeriksaanfisik_id, skalanyeriflaccs_id', 'safe', 'on'=>'search'),
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
			'skalanyeriflaccs' => array(self::BELONGS_TO, 'SkalanyeriflaccsM', 'skalanyeriflaccs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmennyericcs_id' => 'Asesmennyericcs',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'skalanyeriflaccs_id' => 'Skalanyeriflaccs',
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

		$criteria->compare('asesmennyericcs_id',$this->asesmennyericcs_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('skalanyeriflaccs_id',$this->skalanyeriflaccs_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}