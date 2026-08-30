<?php

/**
 * This is the model class for table "kelompokmodul_k".
 *
 * The followings are the available columns in table 'kelompokmodul_k':
 * @property integer $kelompokmodul_id
 * @property string $kelompokmodul_nama
 * @property string $kelompokmodul_namalainnya
 * @property string $kelompokmodul_fungsi
 * @property boolean $kelompokmodul_aktif
 */
class KelompokmodulK extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokmodulK the static model class
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
		return 'kelompokmodul_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokmodul_nama, kelompokmodul_aktif','required'),
			array('kelompokmodul_nama, kelompokmodul_namalainnya', 'length', 'max'=>50),
			array('kelompokmodul_fungsi', 'safe'),
                        array('kelompokmodul_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompokmodul_id, kelompokmodul_nama, kelompokmodul_namalainnya, kelompokmodul_fungsi, kelompokmodul_aktif', 'safe', 'on'=>'search'),
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
			'kelompokmodul_id' => 'ID',
			'kelompokmodul_nama' => 'Kelompok Modul',
			'kelompokmodul_namalainnya' => 'Nama Lainnya',
			'kelompokmodul_fungsi' => 'Fungsi',
			'kelompokmodul_aktif' => 'Aktif',
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

		$criteria->compare('kelompokmodul_id',$this->kelompokmodul_id);
		$criteria->compare('LOWER(kelompokmodul_nama)',strtolower($this->kelompokmodul_nama),true);
		$criteria->compare('LOWER(kelompokmodul_namalainnya)',strtolower($this->kelompokmodul_namalainnya),true);
		$criteria->compare('LOWER(kelompokmodul_fungsi)',strtolower($this->kelompokmodul_fungsi),true);
		$criteria->compare('kelompokmodul_aktif',$this->kelompokmodul_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
         public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;

		$criteria->compare('kelompokmodul_id',$this->kelompokmodul_id);
		$criteria->compare('LOWER(kelompokmodul_nama)',strtolower($this->kelompokmodul_nama),true);
		$criteria->compare('LOWER(kelompokmodul_namalainnya)',strtolower($this->kelompokmodul_namalainnya),true);
		$criteria->compare('LOWER(kelompokmodul_fungsi)',strtolower($this->kelompokmodul_fungsi),true);
		$criteria->compare('kelompokmodul_aktif',$this->kelompokmodul_aktif);
//		$criteria->compare('kelmenu_aktif',$this->kelmenu_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                         'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->kelompokmodul_nama = strtoupper($this->kelompokmodul_nama);
            $this->kelompokmodul_namalainnya = strtoupper($this->kelompokmodul_namalainnya);
            return parent::beforeSave();
        }
}