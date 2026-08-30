<?php

/**
 * This is the model class for table "pengkajiannyeriskalaflaccs_t".
 *
 * The followings are the available columns in table 'pengkajiannyeriskalaflaccs_t':
 * @property integer $pengkajiannyeriskalaflaccs_t
 * @property integer $pengkajiannyeri_id
 * @property integer $skalanyeriflaccs_id
 *
 * The followings are the available model relations:
 * @property PengkajiannyeriT $pengkajiannyeri
 * @property SkalanyeriflaccsM $skalanyeriflaccs
 */
class PengkajiannyeriskalaflaccsT extends CActiveRecord
{
    public $ispilih;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengkajiannyeriskalaflaccsT the static model class
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
		return 'pengkajiannyeriskalaflaccs_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengkajiannyeri_id, skalanyeriflaccs_id', 'required'),
			array('pengkajiannyeri_id, skalanyeriflaccs_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengkajiannyeriskalaflaccs_t, pengkajiannyeri_id, skalanyeriflaccs_id', 'safe', 'on'=>'search'),
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
			'pengkajiannyeri' => array(self::BELONGS_TO, 'PengkajiannyeriT', 'pengkajiannyeri_id'),
			'skalanyeriflaccs' => array(self::BELONGS_TO, 'SkalanyeriflaccsM', 'skalanyeriflaccs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengkajiannyeriskalaflaccs_t' => 'Asesmennyericcs',
			'pengkajiannyeri_id' => 'Pengkajiannyeri',
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

		$criteria->compare('pengkajiannyeriskalaflaccs_t',$this->pengkajiannyeriskalaflaccs_t);
		$criteria->compare('pengkajiannyeri_id',$this->pengkajiannyeri_id);
		$criteria->compare('skalanyeriflaccs_id',$this->skalanyeriflaccs_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}