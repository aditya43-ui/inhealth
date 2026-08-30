<?php

/**
 * This is the model class for table "kegiatanpersalinan_m".
 *
 * The followings are the available columns in table 'kegiatanpersalinan_m':
 * @property integer $kegiatanpersalinan_id
 * @property string $kegiatanpersalinan_nama
 * @property string $kegiatanpersalinan_namalain
 * @property boolean $kegiatanpersalinan_aktif
 */
class KegiatanpersalinanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanpersalinanM the static model class
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
		return 'kegiatanpersalinan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kegiatanpersalinan_nama', 'required'),
			array('kegiatanpersalinan_nama, kegiatanpersalinan_namalain', 'length', 'max'=>100),
			array('kegiatanpersalinan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kegiatanpersalinan_id, kegiatanpersalinan_nama, kegiatanpersalinan_namalain, kegiatanpersalinan_aktif', 'safe', 'on'=>'search'),
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
			'kegiatanpersalinan_id' => 'ID',
			'kegiatanpersalinan_nama' => 'Kegiatan Persalinan',
			'kegiatanpersalinan_namalain' => 'Nama Lain',
			'kegiatanpersalinan_aktif' => 'Aktif',
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

		$criteria->compare('kegiatanpersalinan_id',$this->kegiatanpersalinan_id);
		$criteria->compare('LOWER(kegiatanpersalinan_nama)',strtolower($this->kegiatanpersalinan_nama),true);
		$criteria->compare('LOWER(kegiatanpersalinan_namalain)',strtolower($this->kegiatanpersalinan_namalain),true);
		$criteria->compare('kegiatanpersalinan_aktif',isset($this->kegiatanpersalinan_aktif)?$this->kegiatanpersalinan_aktif:true);
//                $criteria->addCondition('kegiatanpersalinan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kegiatanpersalinan_id',$this->kegiatanpersalinan_id);
		$criteria->compare('LOWER(kegiatanpersalinan_nama)',strtolower($this->kegiatanpersalinan_nama),true);
		$criteria->compare('LOWER(kegiatanpersalinan_namalain)',strtolower($this->kegiatanpersalinan_namalain),true);
		$criteria->compare('kegiatanpersalinan_aktif',$this->kegiatanpersalinan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        
}