<?php

/**
 * This is the model class for table "napza_m".
 *
 * The followings are the available columns in table 'napza_m':
 * @property integer $napza_id
 * @property integer $jenisnapza_id
 * @property string $napza_nama
 * @property string $napza_namalain
 * @property boolean $napza_aktif
 */
class NapzaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NapzaM the static model class
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
		return 'napza_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisnapza_id, napza_nama', 'required'),
			array('jenisnapza_id', 'numerical', 'integerOnly'=>true),
			array('napza_nama, napza_namalain', 'length', 'max'=>50),
			array('napza_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('napza_id, jenisnapza_id, napza_nama, napza_namalain, napza_aktif', 'safe', 'on'=>'search'),
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
                    'jenisnapza' => array(self::BELONGS_TO, 'JenisnapzaM', 'jenisnapza_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'napza_id' => 'Napza',
			'jenisnapza_id' => 'Jenis Napza',
			'napza_nama' => 'Nama Napza',
			'napza_namalain' => 'Nama Lainnya',
			'napza_aktif' => 'Napza Aktif',
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

		$criteria->compare('napza_id',$this->napza_id);
		$criteria->compare('jenisnapza_id',$this->jenisnapza_id);
		$criteria->compare('LOWER(napza_nama)',strtolower($this->napza_nama),true);
		$criteria->compare('LOWER(napza_namalain)',strtolower($this->napza_namalain),true);
		$criteria->compare('napza_aktif',isset($this->napza_aktif)?$this->napza_aktif:true);
//                $criteria->addCondition('napza_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('napza_id',$this->napza_id);
		$criteria->compare('jenisnapza_id',$this->jenisnapza_id);
		$criteria->compare('LOWER(napza_nama)',strtolower($this->napza_nama),true);
		$criteria->compare('LOWER(napza_namalain)',strtolower($this->napza_namalain),true);
		//$criteria->compare('napza_aktif',$this->napza_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJenisNapzaItems()
        {
            return JenisnapzaM::model()->findAll('jenisnapza_aktif=TRUE ORDER BY jenisnapza_nama');
        }
}