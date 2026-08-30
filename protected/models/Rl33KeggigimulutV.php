<?php

/**
 * This is the model class for table "rl3_3_keggigimulut_v".
 *
 * The followings are the available columns in table 'rl3_3_keggigimulut_v':
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $kategoritindakan_nama
 * @property string $kategoritindakan_namalainnya
 * @property string $jmlpelayanan
 */
class Rl33KeggigimulutV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl33KeggigimulutV the static model class
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
		return 'rl3_3_keggigimulut_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama', 'length', 'max'=>50),
			array('kategoritindakan_nama, kategoritindakan_namalainnya', 'length', 'max'=>150),
			array('jmlpelayanan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, ruangan_nama, kategoritindakan_nama, kategoritindakan_namalainnya, jmlpelayanan', 'safe', 'on'=>'search'),
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
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'kategoritindakan_namalainnya' => 'Kategoritindakan Namalainnya',
			'jmlpelayanan' => 'Jmlpelayanan',
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

		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kategoritindakan_nama',$this->kategoritindakan_nama,true);
		$criteria->compare('kategoritindakan_namalainnya',$this->kategoritindakan_namalainnya,true);
		$criteria->compare('jmlpelayanan',$this->jmlpelayanan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}