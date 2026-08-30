<?php

/**
 * This is the model class for table "jeniskecelakaan_m".
 *
 * The followings are the available columns in table 'jeniskecelakaan_m':
 * @property integer $jeniskecelakaan_id
 * @property string $jeniskecelakaan_nama
 * @property string $jeniskecelakaan_singkatan
 * @property boolean $jeniskecelakaan_aktif
 */
class JeniskecelakaanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JeniskecelakaanM the static model class
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
		return 'jeniskecelakaan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskecelakaan_nama, jeniskecelakaan_singkatan', 'required'),
			array('jeniskecelakaan_nama', 'length', 'max'=>100),
			array('jeniskecelakaan_singkatan', 'length', 'max'=>50),
			array('jeniskecelakaan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jeniskecelakaan_id, jeniskecelakaan_nama, jeniskecelakaan_singkatan, jeniskecelakaan_aktif', 'safe', 'on'=>'search'),
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
			'jeniskecelakaan_id' => 'Jeniskecelakaan',
			'jeniskecelakaan_nama' => 'Jeniskecelakaan Nama',
			'jeniskecelakaan_singkatan' => 'Jeniskecelakaan Singkatan',
			'jeniskecelakaan_aktif' => 'Jeniskecelakaan Aktif',
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

		$criteria->compare('jeniskecelakaan_id',$this->jeniskecelakaan_id);
		$criteria->compare('LOWER(jeniskecelakaan_nama)',strtolower($this->jeniskecelakaan_nama),true);
		$criteria->compare('LOWER(jeniskecelakaan_singkatan)',strtolower($this->jeniskecelakaan_singkatan),true);
		$criteria->compare('jeniskecelakaan_aktif',$this->jeniskecelakaan_aktif);
                $criteria->addCondition('jeniskecelakaan_aktif is true');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jeniskecelakaan_id',$this->jeniskecelakaan_id);
		$criteria->compare('LOWER(jeniskecelakaan_nama)',strtolower($this->jeniskecelakaan_nama),true);
		$criteria->compare('LOWER(jeniskecelakaan_singkatan)',strtolower($this->jeniskecelakaan_singkatan),true);
		$criteria->compare('jeniskecelakaan_aktif',$this->jeniskecelakaan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}