<?php

/**
 * This is the model class for table "alatmakanan_m".
 * digunakan untuk Master Alat Makanan
 * RSST-3459
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.models
 * The followings are the available columns in table 'alatmakanan_m':
 * @property integer $alatmakanan_id
 * @property string $alatmakanan_nama
 * @property string $alatmakanan_namalainnya
 * @property boolean $alatmakanan_aktif
 * @property string $image_alatmakanan
 * @property integer $kelaspelayanan_id
 *
 * The followings are the available model relations:
 * @property KelaspelayananM $kelaspelayanan
 * @property PesanmenudietR[] $pesanmenudietRs
 */
class AlatmakananM extends CActiveRecord
{
    public $alatmakanan_namacheck,$alatmakanan_namanew;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlatmakananM the static model class
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
		return 'alatmakanan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelaspelayanan_id', 'required'),
			array('kelaspelayanan_id', 'numerical', 'integerOnly'=>true),
			array('alatmakanan_nama, alatmakanan_namalainnya', 'length', 'max'=>250),
			array('image_alatmakanan', 'length', 'max'=>500),
			array('alatmakanan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('alatmakanan_id, alatmakanan_nama, alatmakanan_namalainnya, alatmakanan_aktif, image_alatmakanan, kelaspelayanan_id', 'safe', 'on'=>'search'),
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
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'pesanmenudietRs' => array(self::HAS_MANY, 'PesanmenudietR', 'alatmakanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'alatmakanan_id' => 'Alatmakanan',
			'alatmakanan_nama' => 'Alatmakanan Nama',
			'alatmakanan_namalainnya' => 'Alatmakanan Namalainnya',
			'alatmakanan_aktif' => 'Alatmakanan Aktif',
			'image_alatmakanan' => 'Image Alatmakanan',
			'kelaspelayanan_id' => 'Kelaspelayanan',
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

		$criteria->compare('alatmakanan_id',$this->alatmakanan_id);
		$criteria->compare('LOWER(alatmakanan_nama)',strtolower($this->alatmakanan_nama),true);
		$criteria->compare('alatmakanan_namalainnya',$this->alatmakanan_namalainnya,true);
		$criteria->compare('alatmakanan_aktif',$this->alatmakanan_aktif);
		$criteria->compare('image_alatmakanan',$this->image_alatmakanan,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}