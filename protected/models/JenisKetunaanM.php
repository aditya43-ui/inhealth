<?php

/**
 * This is the model class for table "jenisketunaan_m".
 *
 * The followings are the available columns in table 'jenisketunaan_m':
 * @property integer $jenisketunaan_id
 * @property string $jenisketunaan_kode
 * @property string $jenisketunaan_nama
 * @property string $jenisketunaan_namalainnya
 * @property boolean $jenisketunaan_aktif
 */
class JenisKetunaanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisKetunaanM the static model class
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
		return 'jenisketunaan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisketunaan_kode, jenisketunaan_nama', 'required'),
			array('jenisketunaan_kode', 'length', 'max'=>10),
			array('jenisketunaan_nama, jenisketunaan_namalainnya', 'length', 'max'=>100),
			array('jenisketunaan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisketunaan_id, jenisketunaan_kode, jenisketunaan_nama, jenisketunaan_namalainnya, jenisketunaan_aktif', 'safe', 'on'=>'search'),
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
			'jenisketunaan_id' => 'ID',
			'jenisketunaan_kode' => 'Kode Jenis ketunaan ',
			'jenisketunaan_nama' => 'Nama Jenis Ketunaan',
			'jenisketunaan_namalainnya' => 'Nama Lainnya',
			'jenisketunaan_aktif' => 'Aktif',
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

		$criteria->compare('jenisketunaan_id',$this->jenisketunaan_id);
		$criteria->compare('LOWER(jenisketunaan_kode)',strtolower($this->jenisketunaan_kode),true);
		$criteria->compare('LOWER(jenisketunaan_nama)',strtolower($this->jenisketunaan_nama),true);
		$criteria->compare('LOWER(jenisketunaan_namalainnya)',strtolower($this->jenisketunaan_namalainnya),true);
		$criteria->compare('jenisketunaan_aktif',isset($this->jenisketunaan_aktif)?$this->jenisketunaan_aktif:true);
                //$criteria->addCondition('jenisketunaan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenisketunaan_id',$this->jenisketunaan_id);
		$criteria->compare('LOWER(jenisketunaan_kode)',strtolower($this->jenisketunaan_kode),true);
		$criteria->compare('LOWER(jenisketunaan_nama)',strtolower($this->jenisketunaan_nama),true);
		$criteria->compare('LOWER(jenisketunaan_namalainnya)',strtolower($this->jenisketunaan_namalainnya),true);
		$criteria->compare('jenisketunaan_aktif',$this->jenisketunaan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}