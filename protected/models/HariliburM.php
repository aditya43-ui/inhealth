<?php

/**
 * This is the model class for table "harilibur_m".
 *
 * The followings are the available columns in table 'harilibur_m':
 * @property integer $harilibur_id
 * @property string $tglharilibur
 * @property string $namaharilibur
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $harilibur_aktif
 * @property string $keterangan_harilibur
 */
class HariliburM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HariliburM the static model class
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
		return 'harilibur_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglharilibur, namaharilibur, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('namaharilibur', 'length', 'max'=>100),
			array('update_time, harilibur_aktif, keterangan_harilibur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('harilibur_id, tglharilibur, namaharilibur, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, harilibur_aktif, keterangan_harilibur', 'safe', 'on'=>'search'),
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
			'harilibur_id' => 'Id Hari Libur',
			'tglharilibur' => 'Tanggal Hari Libur',
			'namaharilibur' => 'Nama Hari Libur',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'harilibur_aktif' => 'Status',
			'keterangan_harilibur' => 'Keterangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->harilibur_id)){
			$criteria->addCondition('harilibur_id = '.$this->harilibur_id);
		}
		$criteria->compare('LOWER(tglharilibur)',strtolower($this->tglharilibur),true);
		$criteria->compare('LOWER(namaharilibur)',strtolower($this->namaharilibur),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		$criteria->compare('harilibur_aktif',$this->harilibur_aktif);
		$criteria->compare('LOWER(keterangan_harilibur)',strtolower($this->keterangan_harilibur),true);

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