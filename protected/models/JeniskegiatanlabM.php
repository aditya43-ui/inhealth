<?php

/**
 * This is the model class for table "jeniskegiatanlab_m".
 *
 * The followings are the available columns in table 'jeniskegiatanlab_m':
 * @property integer $jeniskegiatanlab_id
 * @property string $jeniskegiatanlab_kode
 * @property string $jeniskegiatanlab1
 * @property string $jeniskegiatanlab2
 * @property string $jeniskegiatanlab3
 * @property boolean $jeniskegiatanlab_aktif
 *
 * The followings are the available model relations:
 * @property NilairujukanM[] $nilairujukanMs
 */
class JeniskegiatanlabM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JeniskegiatanlabM the static model class
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
		return 'jeniskegiatanlab_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskegiatanlab_kode, jeniskegiatanlab1, jeniskegiatanlab2, jeniskegiatanlab3', 'required'),
			array('jeniskegiatanlab_kode', 'length', 'max'=>25),
			array('jeniskegiatanlab1, jeniskegiatanlab2, jeniskegiatanlab3', 'length', 'max'=>100),
			array('jeniskegiatanlab_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jeniskegiatanlab_id, jeniskegiatanlab_kode, jeniskegiatanlab1, jeniskegiatanlab2, jeniskegiatanlab3, jeniskegiatanlab_aktif', 'safe', 'on'=>'search'),
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
			'nilairujukanMs' => array(self::HAS_MANY, 'NilairujukanM', 'jeniskegiatanlab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jeniskegiatanlab_id' => 'Jeniskegiatanlab',
			'jeniskegiatanlab_kode' => 'Kode',
			'jeniskegiatanlab1' => 'Jenis kegiatan 1',
			'jeniskegiatanlab2' => 'Jenis kegiatan 2',
			'jeniskegiatanlab3' => 'Jenis kegiatan 3',
			'jeniskegiatanlab_aktif' => 'Aktif',
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

		$criteria->compare('jeniskegiatanlab_id',$this->jeniskegiatanlab_id);
		$criteria->compare('jeniskegiatanlab_kode',$this->jeniskegiatanlab_kode,true);
		$criteria->compare('jeniskegiatanlab1',$this->jeniskegiatanlab1,true);
		$criteria->compare('jeniskegiatanlab2',$this->jeniskegiatanlab2,true);
		$criteria->compare('jeniskegiatanlab3',$this->jeniskegiatanlab3,true);
		$criteria->compare('jeniskegiatanlab_aktif',$this->jeniskegiatanlab_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jeniskegiatanlab_id',$this->jeniskegiatanlab_id);
		$criteria->compare('jeniskegiatanlab_kode',$this->jeniskegiatanlab_kode,true);
		$criteria->compare('jeniskegiatanlab1',$this->jeniskegiatanlab1,true);
		$criteria->compare('jeniskegiatanlab2',$this->jeniskegiatanlab2,true);
		$criteria->compare('jeniskegiatanlab3',$this->jeniskegiatanlab3,true);
		$criteria->compare('jeniskegiatanlab_aktif',$this->jeniskegiatanlab_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false
		));
	}
}