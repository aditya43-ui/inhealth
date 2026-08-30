<?php

/**
 * This is the model class for table "kategoripost_m".
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package application.models
 * The followings are the available columns in table 'kategoripost_m':
 * @property integer $kategoripost_id
 * @property string $kategoripost_nama
 * @property string $kategoripost_namalain
 * @property string $kategoripost_gambar
 * @property boolean $kategoripost_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PostM[] $postMs
 */
class KategoripostM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KategoripostM the static model class
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
		return 'kategoripost_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kategoripost_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kategoripost_nama, kategoripost_namalain', 'length', 'max'=>50),
			array('kategoripost_gambar, kategoripost_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kategoripost_id, kategoripost_nama, kategoripost_namalain, kategoripost_gambar, kategoripost_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'postMs' => array(self::HAS_MANY, 'PostM', 'kategoripost_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kategoripost_id' => 'Kategoripost',
			'kategoripost_nama' => 'Kategoripost Nama',
			'kategoripost_namalain' => 'Kategoripost Namalain',
			'kategoripost_gambar' => 'Kategoripost Gambar',
			'kategoripost_aktif' => 'Kategoripost Aktif',
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

		$criteria->compare('kategoripost_id',$this->kategoripost_id);
		$criteria->compare('lower(kategoripost_nama)',strtolower($this->kategoripost_nama),true);
		$criteria->compare('lower(kategoripost_namalain)',strtolower($this->kategoripost_namalain),true);
		$criteria->compare('kategoripost_gambar',$this->kategoripost_gambar,true);
		$criteria->compare('kategoripost_aktif',$this->kategoripost_aktif);
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
          * digunakan untuk search kategori berita
          * @return \CActiveDataProvider
          */
        public function searchNew()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
		$criteria->compare('lower(kategoripost_nama)',strtolower($this->kategoripost_nama),true);
		$criteria->compare('lower(kategoripost_namalain)',strtolower($this->kategoripost_namalain),true);
		$criteria->compare('kategoripost_aktif',$this->kategoripost_aktif);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}