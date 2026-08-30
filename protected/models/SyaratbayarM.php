<?php

/**
 * This is the model class for table "syaratbayar_m".
 *
 * The followings are the available columns in table 'syaratbayar_m':
 * @property integer $syaratbayar_id
 * @property string $syaratbayar_nama
 * @property string $syaratbayar_namalain
 * @property boolean $syaratbayar_aktif
 */
class SyaratbayarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SyaratbayarM the static model class
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
		return 'syaratbayar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('syaratbayar_nama', 'required'),
			array('syaratbayar_nama, syaratbayar_namalain', 'length', 'max'=>50),
			array('syaratbayar_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('syaratbayar_id, syaratbayar_nama, syaratbayar_namalain, syaratbayar_aktif', 'safe', 'on'=>'search'),
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
			'syaratbayar_id' => 'Syaratbayar',
			'syaratbayar_nama' => 'Syaratbayar Nama',
			'syaratbayar_namalain' => 'Syaratbayar Namalain',
			'syaratbayar_aktif' => 'Syaratbayar Aktif',
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

		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
		$criteria->compare('LOWER(syaratbayar_nama)',strtolower($this->syaratbayar_nama),true);
		$criteria->compare('LOWER(syaratbayar_namalain)',strtolower($this->syaratbayar_namalain),true);
		$criteria->compare('syaratbayar_aktif',$this->syaratbayar_aktif);
                $criteria->addCondition('syaratbayar_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
		$criteria->compare('LOWER(syaratbayar_nama)',strtolower($this->syaratbayar_nama),true);
		$criteria->compare('LOWER(syaratbayar_namalain)',strtolower($this->syaratbayar_namalain),true);
		$criteria->compare('syaratbayar_aktif',$this->syaratbayar_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}