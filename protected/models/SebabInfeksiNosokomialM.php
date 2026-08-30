<?php

/**
 * This is the model class for table "sebabin_m".
 *
 * The followings are the available columns in table 'sebabin_m':
 * @property integer $sebabin_id
 * @property string $sebabin_nama
 * @property string $sebabin_namalainnya
 * @property boolean $sebabin_aktif
 */
class SebabInfeksiNosokomialM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SebabInfeksiNosokomialM the static model class
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
		return 'sebabin_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sebabin_nama', 'required'),
			array('sebabin_nama, sebabin_namalainnya', 'length', 'max'=>100),
			array('sebabin_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sebabin_id, sebabin_nama, sebabin_namalainnya, sebabin_aktif', 'safe', 'on'=>'search'),
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
			'sebabin_id' => 'ID',
			'sebabin_nama' => 'Nama Sebab Infeksi Nosokomial',
			'sebabin_namalainnya' => 'Nama Lainnya',
			'sebabin_aktif' => 'Sebabin Aktif',
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

		$criteria->compare('sebabin_id',$this->sebabin_id);
		$criteria->compare('LOWER(sebabin_nama)',strtolower($this->sebabin_nama),true);
		$criteria->compare('LOWER(sebabin_namalainnya)',strtolower($this->sebabin_namalainnya),true);
		$criteria->compare('sebabin_aktif',isset($this->sebabin_aktif)?$this->sebabin_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('sebabin_id',$this->sebabin_id);
		$criteria->compare('LOWER(sebabin_nama)',strtolower($this->sebabin_nama),true);
		$criteria->compare('LOWER(sebabin_namalainnya)',strtolower($this->sebabin_namalainnya),true);
		$criteria->compare('sebabin_aktif',$this->sebabin_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}