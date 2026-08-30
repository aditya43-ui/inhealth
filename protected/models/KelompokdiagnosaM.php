<?php

/**
 * This is the model class for table "kelompokdiagnosa_m".
 *
 * The followings are the available columns in table 'kelompokdiagnosa_m':
 * @property integer $kelompokdiagnosa_id
 * @property string $kelompokdiagnosa_nama
 * @property string $kelompokdiagnosa_namalainnya
 * @property boolean $kelompokdiagnosa_aktif
 */
class KelompokdiagnosaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokdiagnosaM the static model class
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
		return 'kelompokdiagnosa_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokdiagnosa_nama', 'required'),
			array('kelompokdiagnosa_nama, kelompokdiagnosa_namalainnya', 'length', 'max'=>50),
			array('kelompokdiagnosa_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompokdiagnosa_id, kelompokdiagnosa_nama, kelompokdiagnosa_namalainnya, kelompokdiagnosa_aktif', 'safe', 'on'=>'search'),
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
			'kelompokdiagnosa_id' => 'ID',
			'kelompokdiagnosa_nama' => 'Kelompok Diagnosa',
			'kelompokdiagnosa_namalainnya' => 'Nama Lain',
			'kelompokdiagnosa_aktif' => 'Aktif',
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

		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('LOWER(kelompokdiagnosa_nama)',strtolower($this->kelompokdiagnosa_nama),true);
		$criteria->compare('LOWER(kelompokdiagnosa_namalainnya)',strtolower($this->kelompokdiagnosa_namalainnya),true);
		$criteria->compare('kelompokdiagnosa_aktif',isset($this->kelompokdiagnosa_aktif)?$this->kelompokdiagnosa_aktif:true);
//                $criteria->addCondition('kelompokdiagnosa_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('LOWER(kelompokdiagnosa_nama)',strtolower($this->kelompokdiagnosa_nama),true);
		$criteria->compare('LOWER(kelompokdiagnosa_namalainnya)',strtolower($this->kelompokdiagnosa_namalainnya),true);
                $criteria->compare('kelompokdiagnosa_aktif',isset($this->kelompokdiagnosa_aktif)?$this->kelompokdiagnosa_aktif:true);
//		$criteria->compare('kelompokdiagnosa_aktif',$this->kelompokdiagnosa_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                         'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->kelompokdiagnosa_nama = ucwords(strtolower($this->kelompokdiagnosa_nama));
            $this->kelompokdiagnosa_namalainnya = ucwords(strtolower($this->kelompokdiagnosa_namalainnya));
            return parent::beforeSave();
        }
}