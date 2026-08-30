<?php

/**
 * This is the model class for table "tingkatkepuasan_m".
 *
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @category New Feature RSST-8539
 * @author       Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @issue           RSST-8671
 * @package application.models
 * The followings are the available columns in table 'tingkatkepuasan_m':
 * @property integer $tingkatkepuasan_id
 * @property string $tingkatkepuasan_nama
 * @property integer $tingkatkepuasan_bobot
 * @property string $tingkatkepuasan_gambar
 * @property integer $tingkatkepuasan_urutan
 * @property boolean $tingkatkepuasan_aktif
 * @property integer $jenisformsurvey_id
 *
 * The followings are the available model relations:
 * @property JenisformsurveyM $jenisformsurvey
 */
class TingkatkepuasanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TingkatkepuasanM the static model class
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
		return 'tingkatkepuasan_m';
	}
        
        public $jenisformsurvey_nama;
        public $image;

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('tingkatkepuasan_nama', 'required'),
			array('tingkatkepuasan_bobot, tingkatkepuasan_urutan, jenisformsurvey_id', 'numerical', 'integerOnly'=>true),
			array('tingkatkepuasan_nama', 'length', 'max'=>200),
			array('tingkatkepuasan_gambar', 'length', 'max'=>150),
			array('tingkatkepuasan_aktif, image', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tingkatkepuasan_id, tingkatkepuasan_nama, tingkatkepuasan_bobot, tingkatkepuasan_gambar, tingkatkepuasan_urutan, tingkatkepuasan_aktif, jenisformsurvey_id, jenisformsurvey_nama', 'safe', 'on'=>'search'),
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
			'jenisformsurvey' => array(self::BELONGS_TO, 'JenisformsurveyM', 'jenisformsurvey_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tingkatkepuasan_id' => 'ID',
			'tingkatkepuasan_nama' => 'Nama Tingkat Kepuasan',
			'tingkatkepuasan_bobot' => 'Bobot',
			'tingkatkepuasan_gambar' => 'Gambar',
			'tingkatkepuasan_urutan' => 'Urutan',
			'tingkatkepuasan_aktif' => 'Aktif',
			'jenisformsurvey_id' => 'Jenisformsurvey',
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
                
		$criteria->compare('tingkatkepuasan_id',$this->tingkatkepuasan_id);
		$criteria->compare('LOWER(t.tingkatkepuasan_nama)', strtolower($this->tingkatkepuasan_nama),true);
		$criteria->compare('tingkatkepuasan_bobot',$this->tingkatkepuasan_bobot);
		$criteria->compare('tingkatkepuasan_urutan',$this->tingkatkepuasan_urutan);
		$criteria->compare('tingkatkepuasan_aktif',$this->tingkatkepuasan_aktif);
		$criteria->compare('jenisformsurvey_id',$this->jenisformsurvey_id);
                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
		$criteria=new CDbCriteria;
                
		$criteria->compare('tingkatkepuasan_id',$this->tingkatkepuasan_id);
		$criteria->compare('LOWER(t.tingkatkepuasan_nama)', strtolower($this->tingkatkepuasan_nama),true);
		$criteria->compare('tingkatkepuasan_bobot',$this->tingkatkepuasan_bobot);
		$criteria->compare('tingkatkepuasan_urutan',$this->tingkatkepuasan_urutan);
		$criteria->compare('tingkatkepuasan_aktif',$this->tingkatkepuasan_aktif);
		$criteria->compare('jenisformsurvey_id',$this->jenisformsurvey_id);
                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false,
		));
	}
        

        /**
         * digunakan untuk get jenis survey pada ekios
         * @param type string $jenis 
         * @return type array
         */     
        public function getList($jenis=""){
//            $jenis  = !empty($jenis) ? " AND jenisformsurvey_id = '".$jenis."'" : "";
            $jenis="";
            $data   = Yii::app()->db->createCommand()
                    ->select("tingkatkepuasan_nama, tingkatkepuasan_gambar, concat(tingkatkepuasan_id,'_',tingkatkepuasan_nama) As id")
                    ->from('tingkatkepuasan_m')
                    ->where('TRUE AND tingkatkepuasan_aktif = true '.$jenis)
                    ->order('tingkatkepuasan_urutan ASC')
                    ->queryAll();
            $list   = CHtml::listData($data, 'id', 'tingkatkepuasan_gambar');
            return $list;
        }

}