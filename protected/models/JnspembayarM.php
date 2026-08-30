<?php

/**
 * This is the model class for table "jnspembayar_m".
 *
 * The followings are the available columns in table 'jnspembayar_m':
 * @property integer $jnspembayar_id
 * @property string $jnspembayar_nama
 * @property string $jnspembayar_namalain
 * @property integer $jatuhtempo
 * @property string $jnspembayar_cp
 * @property string $jnspembayar_nomobile
 * @property boolean $jnspembayar_aktif
 * @property boolean $ispiutangbank
 * @property boolean $ispembayarandigital
 *
 * The followings are the available model relations:
 * @property JnspembrekM[] $jnspembrekMs
 */
class JnspembayarM extends CActiveRecord
{
	public $bank_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JnspembayarM the static model class
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
		return 'jnspembayar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jnspembayar_nama, jnspembayar_namalain', 'required'),
			array('jatuhtempo', 'numerical', 'integerOnly'=>true),
			array('jnspembayar_nama, jnspembayar_namalain', 'length', 'max'=>100),
			array('jnspembayar_cp, jnspembayar_nomobile', 'length', 'max'=>50),
			array('jnspembayar_aktif, ispiutangbank, ispembayarandigital', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jnspembayar_id, jnspembayar_nama, jnspembayar_namalain, jatuhtempo, jnspembayar_cp, jnspembayar_nomobile, jnspembayar_aktif, ispiutangbank, ispembayarandigital', 'safe', 'on'=>'search'),
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
			'jnspembrekMs' => array(self::HAS_MANY, 'JnspembrekM', 'jnspembayar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jnspembayar_id' => 'Jnspembayar',
			'jnspembayar_nama' => 'Nama Jenis Pembayaran',
			'jnspembayar_namalain' => 'Nama Lainnya',
			'jatuhtempo' => 'Jatuh Tempo',
			'jnspembayar_cp' => 'Pembayaran CP',
			'jnspembayar_nomobile' => 'Pembayaran No. Mobile',
			'jnspembayar_aktif' => 'Aktif',
			'ispiutangbank' => 'Piutaang Bank',
			'bank_id' => 'Bank',
			'ispembayarandigital' => 'Pembayaran Digital',
		);
	}

	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->jnspembayar_id)){
			$criteria->addCondition('jnspembayar_id = '.$this->jnspembayar_id);
		}
		$criteria->compare('LOWER(jnspembayar_nama)',strtolower($this->jnspembayar_nama),true);
		$criteria->compare('LOWER(jnspembayar_namalain)',strtolower($this->jnspembayar_namalain),true);
		if(!empty($this->bank_id)){
			$criteria->addCondition('bank_id = '.$this->bank_id);
		}
		if(!empty($this->jatuhtempo)){
			$criteria->addCondition('jatuhtempo = '.$this->jatuhtempo);
		}
		$criteria->compare('LOWER(jnspembayar_cp)',strtolower($this->jnspembayar_cp),true);
		$criteria->compare('LOWER(jnspembayar_nomobile)',strtolower($this->jnspembayar_nomobile),true);
		$criteria->compare('jnspembayar_aktif',$this->jnspembayar_aktif);
		$criteria->compare('ispiutangbank',$this->ispiutangbank);
		$criteria->compare('ispembayarandigital',$this->ispembayarandigital);

		return $criteria;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=$this->criteriaSearch();
			$criteria->limit=-1;

			return new CActiveDataProvider($this, array(
							'criteria'=>$criteria,
							'pagination'=>false,
			));
	}
}
