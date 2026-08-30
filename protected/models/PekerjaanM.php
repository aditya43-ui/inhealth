<?php

/**
 * This is the model class for table "pekerjaan_m".
 *
 * The followings are the available columns in table 'pekerjaan_m':
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property string $pekerjaan_namalainnya
 * @property boolean $pekerjaan_aktif
 */
class PekerjaanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PekerjaanM the static model class
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
		return 'pekerjaan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pekerjaan_nama', 'required'),
			array('pekerjaan_nama, pekerjaan_namalainnya', 'length', 'max'=>50),
			array('pekerjaan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pekerjaan_id, pekerjaan_nama, pekerjaan_namalainnya, pekerjaan_aktif', 'safe', 'on'=>'search'),
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
			'pekerjaan_id' => 'ID',
			'pekerjaan_nama' => 'Pekerjaan',
			'pekerjaan_namalainnya' => 'Nama Lainnya',
			'pekerjaan_aktif' => 'Aktif',
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

		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(pekerjaan_namalainnya)',strtolower($this->pekerjaan_namalainnya),true);
		$criteria->compare('pekerjaan_aktif',isset($this->pekerjaan_aktif)?$this->pekerjaan_aktif:true);
               // $criteria->addCondition('pekerjaan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(pekerjaan_namalainnya)',strtolower($this->pekerjaan_namalainnya),true);
//		$criteria->compare('pekerjaan_aktif',$this->pekerjaan_aktif);
                $criteria->order='pekerjaan_id';
                $criteria->limit=-1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
         public function beforeSave() {
            $this->pekerjaan_nama = ucwords(strtolower($this->pekerjaan_nama));
            $this->pekerjaan_namalainnya = strtoupper($this->pekerjaan_namalainnya);
            return parent::beforeSave();
        }
        
        public function getPekerjaanItems()
        {
            return $this->findAll(array('order'=>'pekerjaan_nama'));
        }
}