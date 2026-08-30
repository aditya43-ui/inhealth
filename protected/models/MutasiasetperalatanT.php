<?php

/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 * 
 * This is the model class for table "mutasiasetperalatan_t".
 *
 * The followings are the available columns in table 'mutasiasetperalatan_t':
 * @property integer $invperalatan_id
 * @property integer $mutasiaset_id
 * @property string $mutasi_keaadaan
 * @property string $ket_mutasi
 *
 * The followings are the available model relations:
 * @property MutasiasetT $mutasiaset
 */
class MutasiasetperalatanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutasiasetperalatanT the static model class
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
		return 'mutasiasetperalatan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invperalatan_id, mutasiaset_id, mutasi_keadaan', 'required'),
			array('invperalatan_id, mutasiaset_id', 'numerical', 'integerOnly'=>true),
			array('mutasi_keadaan', 'length', 'max'=>50),
			array('ket_mutasi', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invperalatan_id, mutasiaset_id, mutasi_keadaan, ket_mutasi', 'safe', 'on'=>'search'),
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
			'mutasiaset' => array(self::BELONGS_TO, 'MutasiasetT', 'mutasiaset_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invperalatan_id' => 'Invperalatan',
			'mutasiaset_id' => 'Mutasiaset',
			'mutasi_keaadaan' => 'Mutasi Keaadaan',
			'ket_mutasi' => 'Ket Mutasi',
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

		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('mutasiaset_id',$this->mutasiaset_id);
		$criteria->compare('mutasi_keaadaan',$this->mutasi_keaadaan,true);
		$criteria->compare('ket_mutasi',$this->ket_mutasi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}