<?php

/**
 * This is the model class for table "detailnapza_m".
 *
 * The followings are the available columns in table 'detailnapza_m':
 * @property integer $detailnapza_id
 * @property integer $napza_id
 * @property string $detailnapza_nama
 * @property string $detailnapza_namalain
 * @property boolean $detailnapza_aktif
 */
class DetailnapzaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DetailnapzaM the static model class
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
		return 'detailnapza_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('napza_id, detailnapza_nama', 'required'),
			array('napza_id', 'numerical', 'integerOnly'=>true),
			array('detailnapza_nama, detailnapza_namalain', 'length', 'max'=>100),
			array('detailnapza_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('detailnapza_id, napza_id, detailnapza_nama, detailnapza_namalain, detailnapza_aktif', 'safe', 'on'=>'search'),
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
                    'napza' => array(self::BELONGS_TO, 'NapzaM', 'napza_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'detailnapza_id' => 'ID',
			'napza_id' => 'ID Napza',
			'detailnapza_nama' => 'Nama Detail Napza',
			'detailnapza_namalain' => 'Nama Lainnya',
			'detailnapza_aktif' => 'Aktif',
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

		$criteria->compare('detailnapza_id',$this->detailnapza_id);
		$criteria->compare('napza_id',$this->napza_id);
		$criteria->compare('LOWER(detailnapza_nama)',strtolower($this->detailnapza_nama),true);
		$criteria->compare('LOWER(detailnapza_namalain)',strtolower($this->detailnapza_namalain),true);
		$criteria->compare('detailnapza_aktif',isset($this->detailnapza_aktif)?$this->detailnapza_aktif:true);
//                $criteria->addCondition('detailnapza_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('detailnapza_id',$this->detailnapza_id);
		$criteria->compare('napza_id',$this->napza_id);
		$criteria->compare('LOWER(detailnapza_nama)',strtolower($this->detailnapza_nama),true);
		$criteria->compare('LOWER(detailnapza_namalain)',strtolower($this->detailnapza_namalain),true);
		//$criteria->compare('detailnapza_aktif',$this->detailnapza_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        public function getNapzaItems()
        {
            return NapzaM::model()->findAll('napza_aktif=TRUE ORDER BY napza_nama');
        }
}