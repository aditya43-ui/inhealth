<?php

/**
 * This is the model class for table "kategoritindakan_m".
 *
 * The followings are the available columns in table 'kategoritindakan_m':
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property string $kategoritindakan_namalainnya
 * @property boolean $kategoritindakan_aktif
 */
class KategoritindakanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KategoritindakanM the static model class
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
		return 'kategoritindakan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('kategoritindakan_nama','required'),
			array('kategoritindakan_nama, kategoritindakan_namalainnya', 'length', 'max'=>30),
			array('kategoritindakan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kategoritindakan_id, kategoritindakan_nama, kategoritindakan_namalainnya, kategoritindakan_aktif', 'safe', 'on'=>'search'),
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
			'kategoritindakan_id' => 'ID',
			'kategoritindakan_nama' => 'Kategori',
			'kategoritindakan_namalainnya' => 'Nama Lain',
			'kategoritindakan_aktif' => 'Aktif',
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

		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('LOWER(kategoritindakan_namalainnya)',strtolower($this->kategoritindakan_namalainnya),true);
		$criteria->compare('kategoritindakan_aktif',isset($this->kategoritindakan_aktif)?$this->kategoritindakan_aktif:true);
//                $criteria->addCondition('kategoritindakan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('LOWER(kategoritindakan_namalainnya)',strtolower($this->kategoritindakan_namalainnya),true);
//		$criteria->compare('kategoritindakan_aktif',$this->kategoritindakan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                         'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->kategoritindakan_nama = ucwords(strtolower($this->kategoritindakan_nama));
            $this->kategoritindakan_namalainnya = strtoupper($this->kategoritindakan_namalainnya);

            return parent::beforeSave();
        }
}