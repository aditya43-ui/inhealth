<?php

/**
 * This is the model class for table "kelsebababortus_m".
 *
 * The followings are the available columns in table 'kelsebababortus_m':
 * @property integer $kelsebababortus_id
 * @property string $kelsebababortus_nama
 * @property string $kelsebababortus_namalain
 * @property boolean $kelsebababortus_aktif
 */
class KelsebababortusM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelsebababortusM the static model class
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
		return 'kelsebababortus_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelsebababortus_nama', 'required'),
			array('kelsebababortus_nama, kelsebababortus_namalain', 'length', 'max'=>100),
			array('kelsebababortus_aktif, kelsebababortus_deskripsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelsebababortus_id, kelsebababortus_nama, kelsebababortus_deskripsi, kelsebababortus_namalain, kelsebababortus_aktif', 'safe', 'on'=>'search'),
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
			'kelsebababortus_id' => 'ID',
			'kelsebababortus_nama' => 'Kelompok Sebab Abortus',
			'kelsebababortus_namalain' => 'Nama Lain',
			'kelsebababortus_aktif' => 'Aktif',
                        'kelsebababortus_deskripsi' => 'Deskripsi',
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

		$criteria->compare('kelsebababortus_id',$this->kelsebababortus_id);
		$criteria->compare('LOWER(kelsebababortus_nama)',strtolower($this->kelsebababortus_nama),true);
		$criteria->compare('LOWER(kelsebababortus_namalain)',strtolower($this->kelsebababortus_namalain),true);
		$criteria->compare('kelsebababortus_aktif',isset($this->kelsebababortus_aktif)?$this->kelsebababortus_aktif:true);
//                $criteria->addCondition('kelsebababortus_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kelsebababortus_id',$this->kelsebababortus_id);
		$criteria->compare('LOWER(kelsebababortus_nama)',strtolower($this->kelsebababortus_nama),true);
		$criteria->compare('LOWER(kelsebababortus_namalain)',strtolower($this->kelsebababortus_namalain),true);
		$criteria->compare('kelsebababortus_aktif',$this->kelsebababortus_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->kelsebababortus_nama = ucwords(strtolower($this->kelsebababortus_nama));
            $this->kelsebababortus_namalain = strtoupper($this->kelsebababortus_namalain);
            return parent::beforeSave();
        }
}