<?php

/**
 * This is the model class for table "peluang_m".
 *
 * The followings are the available columns in table 'peluang_m':
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>  
 * @author Elham Budianto <elhambudianto1@gmail.com> 
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 * @property integer $peluang_id
 * @property string $peluang_descriptor
 * @property integer $peluang_bobotdescriptor
 * @property string $peluang_deskripsi
 * @property string $peluang_frekuensi
 * @property string $peluang_kemungkinan
 * @property boolean $peluang_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RiskregisterM[] $riskregisterMs
 */
class PeluangM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeluangM the static model class
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
		return 'peluang_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('peluang_bobotdescriptor, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('peluang_descriptor, peluang_frekuensi, peluang_kemungkinan', 'length', 'max'=>45),
			array('peluang_deskripsi, peluang_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('peluang_id, peluang_descriptor, peluang_bobotdescriptor, peluang_deskripsi, peluang_frekuensi, peluang_kemungkinan, peluang_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'riskregisterMs' => array(self::HAS_MANY, 'RiskregisterM', 'peluang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'peluang_id' => 'Peluang',
			'peluang_descriptor' => 'Peluang Descriptor',
			'peluang_bobotdescriptor' => 'Peluang Bobotdescriptor',
			'peluang_deskripsi' => 'Peluang Deskripsi',
			'peluang_frekuensi' => 'Peluang Frekuensi',
			'peluang_kemungkinan' => 'Peluang Kemungkinan',
			'peluang_aktif' => 'Peluang Aktif',
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

		$criteria->compare('peluang_id',$this->peluang_id);
		$criteria->compare('peluang_descriptor',$this->peluang_descriptor,true);
		$criteria->compare('peluang_bobotdescriptor',$this->peluang_bobotdescriptor);
		$criteria->compare('peluang_deskripsi',$this->peluang_deskripsi,true);
		$criteria->compare('peluang_frekuensi',$this->peluang_frekuensi,true);
		$criteria->compare('peluang_kemungkinan',$this->peluang_kemungkinan,true);
		$criteria->compare('peluang_aktif',$this->peluang_aktif);
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
	 * Mencetak dokumen master peluang.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('peluang_id',$this->peluang_id);
		$criteria->compare('peluang_descriptor',$this->peluang_descriptor,true);
		$criteria->compare('peluang_bobotdescriptor',$this->peluang_bobotdescriptor);
		$criteria->compare('peluang_deskripsi',$this->peluang_deskripsi,true);
		$criteria->compare('peluang_frekuensi',$this->peluang_frekuensi,true);
		$criteria->compare('peluang_kemungkinan',$this->peluang_kemungkinan,true);
		$criteria->compare('peluang_aktif',$this->peluang_aktif);
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
         * Load data peluang
         * @return string
         */
        public function getListPeluang() {
            $data = $this->findAll('peluang_aktif = true order by peluang_bobotdescriptor ASC');
            $res = array();
            
            foreach ($data as $item) {
                $res[$item->peluang_id] = $item->peluang_bobotdescriptor.". ".$item->peluang_descriptor." (".$item->peluang_frekuensi.")";
            }
            
            return $res;
        }
}