<?php

/**
 * This is the model class for table "tiperesiko_m".
 *
 * The followings are the available columns in table 'tiperesiko_m':
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>  
 * @author Elham Budianto <elhambudianto1@gmail.com> 
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 * @property integer $tiperesiko_id
 * @property string $tiperesiko_nama
 * @property string $tiperesiko_namalain
 * @property string $tiperesiko_kode
 * @property string $tiperesiko_keterangan
 * @property boolean $tiperesiko_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RiskregisterM[] $riskregisterMs
 */
class TiperesikoM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TiperesikoM the static model class
	 */
        public $subtiperesiko_nama, $subtiperesiko_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tiperesiko_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tiperesiko_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tiperesiko_nama, tiperesiko_namalain, tiperesiko_kode', 'length', 'max'=>255),
			array('tiperesiko_keterangan, tiperesiko_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tiperesiko_id, tiperesiko_nama, tiperesiko_namalain, tiperesiko_kode, tiperesiko_keterangan, tiperesiko_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'riskregisterMs' => array(self::HAS_MANY, 'RiskregisterM', 'tiperesiko_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tiperesiko_id' => 'Tiperesiko',
			'tiperesiko_nama' => 'Tiperesiko Nama',
			'tiperesiko_namalain' => 'Tiperesiko Namalain',
			'tiperesiko_kode' => 'Tiperesiko Kode',
			'tiperesiko_keterangan' => 'Tiperesiko Keterangan',
			'tiperesiko_aktif' => 'Tiperesiko Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('tiperesiko_id',$this->tiperesiko_id);
		$criteria->compare('tiperesiko_nama',$this->tiperesiko_nama,true);
		$criteria->compare('tiperesiko_namalain',$this->tiperesiko_namalain,true);
		$criteria->compare('tiperesiko_kode',$this->tiperesiko_kode,true);
		$criteria->compare('tiperesiko_keterangan',$this->tiperesiko_keterangan,true);
		$criteria->compare('tiperesiko_aktif',$this->tiperesiko_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
	 * Digunakan untuk mencetak dokumen master.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tiperesiko_id',$this->tiperesiko_id);
		$criteria->compare('tiperesiko_nama',$this->tiperesiko_nama,true);
		$criteria->compare('tiperesiko_namalain',$this->tiperesiko_namalain,true);
		$criteria->compare('tiperesiko_kode',$this->tiperesiko_kode,true);
		$criteria->compare('tiperesiko_keterangan',$this->tiperesiko_keterangan,true);
		$criteria->compare('tiperesiko_aktif',$this->tiperesiko_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
                $criteria->limit=-1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}