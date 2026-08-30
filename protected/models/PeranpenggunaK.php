<?php

/**
 * This is the model class for table "peranpengguna_k".
 *
 * The followings are the available columns in table 'peranpengguna_k':
 * @property integer $peranpengguna_id
 * @property string $peranpenggunanama
 * @property string $peranpenggunanamalain
 * @property boolean $peranpengguna_aktif
 */
class PeranpenggunaK extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeranpenggunaK the static model class
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
		return 'peranpengguna_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('peranpenggunanama, peranpengguna_aktif', 'required'),
			array('peranpenggunanama, peranpenggunanamalain', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('peranpengguna_id, peranpenggunanama, peranpenggunanamalain, peranpengguna_aktif', 'safe', 'on'=>'search'),
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
			'peranpengguna_id' => 'ID',
			'peranpenggunanama' => 'Nama Peran Pengguna',
			'peranpenggunanamalain' => 'Nama Lainnya',
			'peranpengguna_aktif' => 'Aktif',
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

		$criteria->compare('peranpengguna_id',$this->peranpengguna_id);
		$criteria->compare('LOWER(peranpenggunanama)',strtolower($this->peranpenggunanama),true);
		$criteria->compare('LOWER(peranpenggunanamalain)',strtolower($this->peranpenggunanamalain),true);
		$criteria->compare('peranpengguna_aktif',$this->peranpengguna_aktif);
		if (!Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))){				
			$criteria->addNotInCondition("peranpengguna_id", Params::getAllVendor());
		}

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