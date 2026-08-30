<?php

/**
 * This is the model class for table "pemilikbarang_m".
 *
 * The followings are the available columns in table 'pemilikbarang_m':
 * @property integer $pemilikbarang_id
 * @property string $pemilikbarang_kode
 * @property string $pemilikbarang_nama
 * @property string $pemilikbarang_namalainnya
 * @property boolean $pemilikbarang_aktif
 */
class PemilikbarangM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemilikbarangM the static model class
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
		return 'pemilikbarang_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemilikbarang_kode, pemilikbarang_nama', 'required'),
			array('pemilikbarang_kode', 'length', 'max'=>20),
			array('pemilikbarang_nama, pemilikbarang_namalainnya', 'length', 'max'=>100),
			array('pemilikbarang_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemilikbarang_id, pemilikbarang_kode, pemilikbarang_nama, pemilikbarang_namalainnya, pemilikbarang_aktif', 'safe', 'on'=>'search'),
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
			'pemilikbarang_id' => 'ID',
			'pemilikbarang_kode' => ' Kode Pemilik Barang',
			'pemilikbarang_nama' => ' Nama Pemilik Barang',
			'pemilikbarang_namalainnya' => ' Nama Lainnya',
			'pemilikbarang_aktif' => 'Aktif',
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

		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('LOWER(pemilikbarang_kode)',strtolower($this->pemilikbarang_kode),true);
		$criteria->compare('LOWER(pemilikbarang_nama)',strtolower($this->pemilikbarang_nama),true);
		$criteria->compare('LOWER(pemilikbarang_namalainnya)',strtolower($this->pemilikbarang_namalainnya),true);
		$criteria->compare('pemilikbarang_aktif',isset($this->pemilikbarang_aktif)?$this->pemilikbarang_aktif:true);
//                $criteria->addCondition('pemilikbarang_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('LOWER(pemilikbarang_kode)',strtolower($this->pemilikbarang_kode),true);
		$criteria->compare('LOWER(pemilikbarang_nama)',strtolower($this->pemilikbarang_nama),true);
		$criteria->compare('LOWER(pemilikbarang_namalainnya)',strtolower($this->pemilikbarang_namalainnya),true);
		//$criteria->compare('pemilikbarang_aktif',$this->pemilikbarang_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}