<?php

/**
 * This is the model class for table "kelompoktindakan_m".
 *
 * The followings are the available columns in table 'kelompoktindakan_m':
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property string $kelompoktindakan_namalainnya
 * @property integer $kelompoktindakan_persencyto
 * @property integer $kelompoktindakan_urutan
 * @property boolean $kelompoktindakan_aktif
 */
class KelompoktindakanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompoktindakanM the static model class
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
		return 'kelompoktindakan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompoktindakan_nama, kelompoktindakan_persencyto', 'required'),
			array('kelompoktindakan_persencyto, kelompoktindakan_urutan', 'numerical', 'integerOnly'=>true),
			array('kelompoktindakan_nama, kelompoktindakan_namalainnya', 'length', 'max'=>50),
			array('kelompoktindakan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompoktindakan_id, kelompoktindakan_nama, kelompoktindakan_namalainnya, kelompoktindakan_persencyto, kelompoktindakan_urutan, kelompoktindakan_aktif', 'safe', 'on'=>'search'),
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
			'kelompoktindakan_id' => 'ID',
			'kelompoktindakan_nama' => 'Kelompok Tindakan',
			'kelompoktindakan_namalainnya' => 'Nama Lain',
			'kelompoktindakan_persencyto' => 'Persen Cyto',
			'kelompoktindakan_urutan' => 'Urutan Kel Tindakan',
			'kelompoktindakan_aktif' => 'Aktif',
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

		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(kelompoktindakan_namalainnya)',strtolower($this->kelompoktindakan_namalainnya),true);
		$criteria->compare('kelompoktindakan_persencyto',$this->kelompoktindakan_persencyto);
		$criteria->compare('kelompoktindakan_urutan',$this->kelompoktindakan_urutan);
		$criteria->compare('kelompoktindakan_aktif',isset($this->kelompoktindakan_aktif)?$this->kelompoktindakan_aktif:true);
                //$criteria->addCondition('kelompoktindakan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(kelompoktindakan_namalainnya)',strtolower($this->kelompoktindakan_namalainnya),true);
		$criteria->compare('kelompoktindakan_persencyto',$this->kelompoktindakan_persencyto);
		$criteria->compare('kelompoktindakan_urutan',$this->kelompoktindakan_urutan);
//		$criteria->compare('kelompoktindakan_aktif',$this->kelompoktindakan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        
        public function beforeSave() {
            $this->kelompoktindakan_nama = ucwords(strtolower($this->kelompoktindakan_nama));
            $this->kelompoktindakan_namalainnya = ucwords(strtolower($this->kelompoktindakan_namalainnya));
            
            return parent::beforeSave();
        }
}