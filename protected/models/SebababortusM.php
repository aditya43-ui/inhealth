<?php

/**
 * This is the model class for table "sebababortus_m".
 *
 * The followings are the available columns in table 'sebababortus_m':
 * @property integer $sebababortus_id
 * @property integer $kelsebababortus_id
 * @property string $sebababortus_nama
 * @property string $sebababortus_namalain
 * @property boolean $sebababortus_aktif
 */
class SebababortusM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SebababortusM the static model class
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
		return 'sebababortus_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelsebababortus_id, sebababortus_nama', 'required'),
			array('kelsebababortus_id', 'numerical', 'integerOnly'=>true),
			array('sebababortus_nama, sebababortus_namalain', 'length', 'max'=>100),
			array('sebababortus_aktif, sebababortus_deskripsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sebababortus_id, kelsebababortus_id, sebababortus_nama, sebababortus_namalain, sebababortus_aktif, sebababortus_deskripsi', 'safe', 'on'=>'search'),
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
                    'kelsebababortus' => array(self::BELONGS_TO, 'KelsebababortusM', 'kelsebababortus_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sebababortus_id' => 'ID',
			'kelsebababortus_id' => 'Kelompok Sebab Abortus',
			'sebababortus_nama' => 'Sebab Abortus',
			'sebababortus_namalain' => 'Nama Lain',
                        'sebababortus_deskripsi' => 'Deskripsi',
			'sebababortus_aktif' => 'Aktif',
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

		$criteria->compare('sebababortus_id',$this->sebababortus_id);
		$criteria->compare('kelsebababortus_id',$this->kelsebababortus_id);
		$criteria->compare('LOWER(sebababortus_nama)',strtolower($this->sebababortus_nama),true);
		$criteria->compare('LOWER(sebababortus_namalain)',strtolower($this->sebababortus_namalain),true);
		$criteria->compare('sebababortus_aktif',isset($this->sebababortus_aktif)?$this->sebababortus_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('sebababortus_id',$this->sebababortus_id);
		$criteria->compare('kelsebababortus_id',$this->kelsebababortus_id);
		$criteria->compare('LOWER(sebababortus_nama)',strtolower($this->sebababortus_nama),true);
		$criteria->compare('LOWER(sebababortus_namalain)',strtolower($this->sebababortus_namalain),true);
//		$criteria->compare('sebababortus_aktif',$this->sebababortus_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
         public function getKelSebabAbortusItems()
        {
            return KelsebababortusM::model()->findAll('kelsebababortus_aktif=true ORDER BY kelsebababortus_nama');
        }
}