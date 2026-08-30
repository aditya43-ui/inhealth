<?php

/**
 * This is the model class for table "pencucianlinenumumbahan_t".
 *
 * The followings are the available columns in table 'pencucianlinenumumbahan_t':
 * @property integer $pencucianlinenumumbahan_id
 * @property integer $pencucianlinenumum_id
 * @property integer $bahanperawatan_id
 * @property double $jmlpemakaian
 * @property string $satuanpemakaian
 */
class PencucianlinenumumbahanT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pencucianlinenumumbahan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pencucianlinenumum_id, bahanperawatan_id', 'numerical', 'integerOnly'=>true),
			array('jmlpemakaian', 'numerical'),
			array('satuanpemakaian', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pencucianlinenumumbahan_id, pencucianlinenumum_id, bahanperawatan_id, jmlpemakaian, satuanpemakaian', 'safe', 'on'=>'search'),
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
                    'bahanperawatan'=>[self::BELONGS_TO,'BahanperawatanM','bahanperawatan_id']
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pencucianlinenumumbahan_id' => 'Pencucianlinenumumbahan',
			'pencucianlinenumum_id' => 'Pencucianlinenumum',
			'bahanperawatan_id' => 'Bahanperawatan',
			'jmlpemakaian' => 'Jmlpemakaian',
			'satuanpemakaian' => 'Satuanpemakaian',
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

		$criteria->compare('pencucianlinenumumbahan_id',$this->pencucianlinenumumbahan_id);
		$criteria->compare('pencucianlinenumum_id',$this->pencucianlinenumum_id);
		$criteria->compare('bahanperawatan_id',$this->bahanperawatan_id);
		$criteria->compare('jmlpemakaian',$this->jmlpemakaian);
		$criteria->compare('satuanpemakaian',$this->satuanpemakaian,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PencucianlinenumumbahanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
