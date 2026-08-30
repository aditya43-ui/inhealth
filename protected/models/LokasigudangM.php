<?php

/**
 * This is the model class for table "lokasigudang_m".
 *
 * The followings are the available columns in table 'lokasigudang_m':
 * @property integer $lokasigudang_id
 * @property string $lokasigudang_nama
 * @property string $lokasigudang_namalain
 * @property boolean $lokasigudang_aktif
 * @property boolean $lokasigudang_farmasi
 */
class LokasigudangM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasigudangM the static model class
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
		return 'lokasigudang_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lokasigudang_nama', 'required'),
			array('lokasigudang_nama, lokasigudang_namalain', 'length', 'max'=>100),
			array('lokasigudang_aktif, lokasigudang_farmasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lokasigudang_id, lokasigudang_farmasi, lokasigudang_nama, lokasigudang_namalain, lokasigudang_aktif', 'safe', 'on'=>'search'),
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
			'lokasigudang_id' => 'ID',
			'lokasigudang_nama' => 'Nama',
			'lokasigudang_namalain' => 'Nama Lainnya',
			'lokasigudang_aktif' => 'Aktif',
                        'lokasigudang_farmasi'=>'Lokasi Gudang Farmasi'
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

		$criteria->compare('lokasigudang_id',$this->lokasigudang_id);
		$criteria->compare('LOWER(lokasigudang_nama)',strtolower($this->lokasigudang_nama),true);
		$criteria->compare('LOWER(lokasigudang_namalain)',strtolower($this->lokasigudang_namalain),true);
		$criteria->compare('lokasigudang_aktif',isset($this->lokasigudang_aktif)?$this->lokasigudang_aktif:true);
                $criteria->compare('lokasigudang_farmasi',$this->lokasigudang_farmasi);
//                $criteria->addCondition('lokasigudang_farmasi is true and lokasigudang_aktif is true');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('lokasigudang_id',$this->lokasigudang_id);
		$criteria->compare('LOWER(lokasigudang_nama)',strtolower($this->lokasigudang_nama),true);
		$criteria->compare('LOWER(lokasigudang_namalain)',strtolower($this->lokasigudang_namalain),true);
		$criteria->compare('lokasigudang_aktif',$this->lokasigudang_aktif);
                $criteria->order='lokasigudang_nama';
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
          public function beforeSave() {
            $this->lokasigudang_nama = ucwords(strtolower($this->lokasigudang_nama));
            $this->lokasigudang_namalain = strtoupper($this->lokasigudang_namalain);
            return parent::beforeSave();
        }
}