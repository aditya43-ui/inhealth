<?php

/**
 * This is the model class for table "jenisdiklat_m".
 *
 * The followings are the available columns in table 'jenisdiklat_m':
 * @property integer $jenisdiklat_id
 * @property string $jenisdiklat_nama
 * @property string $jenisdiklat_namalainnya
 * @property boolean $jenisdiklat_aktif
 */
class JenisdiklatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisdiklatM the static model class
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
		return 'jenisdiklat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiklat_aktif, jenisdiklat_nama', 'required'),
			array('jenisdiklat_nama, jenisdiklat_namalainnya', 'length', 'max'=>50),
                        array('jenisdiklat_deskripsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisdiklat_id, jenisdiklat_nama, jenisdiklat_namalainnya, jenisdiklat_aktif', 'safe', 'on'=>'search'),
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
			'jenisdiklat_id' => 'Id Jenis Diklat',
			'jenisdiklat_nama' => 'Nama Jenis Diklat',
			'jenisdiklat_namalainnya' => 'Nama Lainnya',
			'jenisdiklat_aktif' => 'Aktif',
                        'jenisdiklat_deskripsi' => 'Deskripsi',
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

		$criteria->compare('jenisdiklat_id',$this->jenisdiklat_id);
		$criteria->compare('LOWER(jenisdiklat_nama)',strtolower($this->jenisdiklat_nama),true);
		$criteria->compare('LOWER(jenisdiklat_namalainnya)',strtolower($this->jenisdiklat_namalainnya),true);
		$criteria->compare('jenisdiklat_aktif',$this->jenisdiklat_aktif);
		if (!isset($this->jenisdiklat_aktif)){
			$criteria->addCondition('jenisdiklat_aktif is true');
		}	
//		$criteria->addCondition('jenisdiklat_aktif is true');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenisdiklat_id',$this->jenisdiklat_id);
		$criteria->compare('LOWER(jenisdiklat_nama)',strtolower($this->jenisdiklat_nama),true);
		$criteria->compare('LOWER(jenisdiklat_namalainnya)',strtolower($this->jenisdiklat_namalainnya),true);
		$criteria->compare('jenisdiklat_aktif',$this->jenisdiklat_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}