<?php

/**
 * This is the model class for table "jenisin_m".
 *
 * The followings are the available columns in table 'jenisin_m':
 * @property integer $jenisin_id
 * @property string $jenisin_nama
 * @property string $jenisin_namalainnya
 * @property boolean $jenisin_aktif
 */
class JenisInfeksiNosokomialM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisInfeksiNosokomialM the static model class
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
		return 'jenisin_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisin_nama', 'required'),
			array('jenisin_nama, jenisin_namalainnya', 'length', 'max'=>50),
			array('jenisin_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisin_id, jenisin_nama, jenisin_namalainnya, jenisin_aktif', 'safe', 'on'=>'search'),
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
			'jenisin_id' => 'ID',
			'jenisin_nama' => 'Nama Jenis Infeksi Nosokomial',
			'jenisin_namalainnya' => 'Nama Lainnya',
			'jenisin_aktif' => 'Aktif',
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

		$criteria->compare('jenisin_id',$this->jenisin_id);
		$criteria->compare('LOWER(jenisin_nama)',strtolower($this->jenisin_nama),true);
		$criteria->compare('LOWER(jenisin_namalainnya)',strtolower($this->jenisin_namalainnya),true);
		$criteria->compare('jenisin_aktif',isset($this->jenisin_aktif)?$this->jenisin_aktif:true);
                //$criteria->addCondition('jenisin_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenisin_id',$this->jenisin_id);
		$criteria->compare('LOWER(jenisin_nama)',strtolower($this->jenisin_nama),true);
		$criteria->compare('LOWER(jenisin_namalainnya)',strtolower($this->jenisin_namalainnya),true);
		$criteria->compare('jenisin_aktif',$this->jenisin_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}