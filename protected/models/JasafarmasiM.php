<?php

/**
 * This is the model class for table "jasafarmasi_m".
 *
 * The followings are the available columns in table 'jasafarmasi_m':
 * @property integer $jasafarmasi_id
 * @property integer $instalasi_id
 * @property integer $penjamin_id
 * @property double $tarif_jasa
 *
 * The followings are the available model relations:
 * @property InstalasiM $instalasi
 * @property PenjaminpasienM $penjamin
 */
class JasafarmasiM extends CActiveRecord
{
	public $carabayar_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JasafarmasiM the static model class
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
		return 'jasafarmasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('tarif_jasa', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jasafarmasi_id, instalasi_id, penjamin_id, tarif_jasa', 'safe', 'on'=>'search'),
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
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jasafarmasi_id' => 'Jasafarmasi',
			'instalasi_id' => 'Instalasi',
			'penjamin_id' => 'Penjamin',
			'tarif_jasa' => 'Tarif Jasa',
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

		$criteria->compare('jasafarmasi_id',$this->jasafarmasi_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('tarif_jasa',$this->tarif_jasa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}