<?php

/**
 * This is the model class for table "konsekuensi_m".
 *
 * The followings are the available columns in table 'konsekuensi_m':
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>  
 * @author Elham Budianto <elhambudianto1@gmail.com> 
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 * @property integer $konsekuensi_id
 * @property string $konsekuensi_domain
 * @property integer $konsekuensi_bobot
 * @property string $konsekuensi_namabobot
 * @property string $konsekuensi_deskripsi
 * @property boolean $konsekuensi_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RiskregisterM[] $riskregisterMs
 */
class KonsekuensiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KonsekuensiM the static model class
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
		return 'konsekuensi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konsekuensi_domain, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('konsekuensi_bobot, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('konsekuensi_domain, konsekuensi_namabobot', 'length', 'max'=>255),
			array('konsekuensi_deskripsi, konsekuensi_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('konsekuensi_id, konsekuensi_domain, konsekuensi_bobot, konsekuensi_namabobot, konsekuensi_deskripsi, konsekuensi_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'riskregisterMs' => array(self::HAS_MANY, 'RiskregisterM', 'konsekuensi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'konsekuensi_id' => 'Konsekuensi',
			'konsekuensi_domain' => 'Konsekuensi Domain',
			'konsekuensi_bobot' => 'Konsekuensi Bobot',
			'konsekuensi_namabobot' => 'Konsekuensi Namabobot',
			'konsekuensi_deskripsi' => 'Konsekuensi Deskripsi',
			'konsekuensi_aktif' => 'Konsekuensi Aktif',
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

		$criteria->compare('konsekuensi_id',$this->konsekuensi_id);
		$criteria->compare('konsekuensi_domain',$this->konsekuensi_domain,true);
		$criteria->compare('konsekuensi_bobot',$this->konsekuensi_bobot);
		$criteria->compare('konsekuensi_namabobot',$this->konsekuensi_namabobot,true);
		$criteria->compare('konsekuensi_deskripsi',$this->konsekuensi_deskripsi,true);
		$criteria->compare('konsekuensi_aktif',$this->konsekuensi_aktif);
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
	 * Mencetak dokumen konsekuensi
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('konsekuensi_id',$this->konsekuensi_id);
		$criteria->compare('konsekuensi_domain',$this->konsekuensi_domain,true);
		$criteria->compare('konsekuensi_bobot',$this->konsekuensi_bobot);
		$criteria->compare('konsekuensi_namabobot',$this->konsekuensi_namabobot,true);
		$criteria->compare('konsekuensi_deskripsi',$this->konsekuensi_deskripsi,true);
		$criteria->compare('konsekuensi_aktif',$this->konsekuensi_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        /**
         * Load data nama konsekuensi
         * @return string
         */
        public function getListNamaKonsekuensi() {
            $data = $this->findAll('konsekuensi_aktif = true order by konsekuensi_bobot ASC');
            $res = array();
            
            foreach ($data as $item) {
                $res[$item->konsekuensi_id] = $item->konsekuensi_bobot.". ".$item->konsekuensi_namabobot;
            }
            
            return $res;
        }
}