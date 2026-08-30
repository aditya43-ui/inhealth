<?php

/**
 * This is the model class for table "morfologineoplasma_m".
 *
 * The followings are the available columns in table 'morfologineoplasma_m':
 * @property integer $morfologineoplasma_id
 * @property string $morfologineoplasma_nama
 * @property string $morfologineoplasma_namalainnya
 * @property boolean $morfologineoplasma_aktif
 */
class MorfologiNeoplasmaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MorfologiNeoplasmaM the static model class
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
		return 'morfologineoplasma_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('morfologineoplasma_nama', 'required'),
			array('morfologineoplasma_nama, morfologineoplasma_namalainnya', 'length', 'max'=>100),
			array('morfologineoplasma_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('morfologineoplasma_id, morfologineoplasma_nama, morfologineoplasma_namalainnya, morfologineoplasma_aktif', 'safe', 'on'=>'search'),
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
			'morfologineoplasma_id' => 'ID',
			'morfologineoplasma_nama' => 'Nama Morfologi Neoplasma',
			'morfologineoplasma_namalainnya' => 'Nama Lainnya',
			'morfologineoplasma_aktif' => 'Aktif',
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

		$criteria->compare('morfologineoplasma_id',$this->morfologineoplasma_id);
		$criteria->compare('LOWER(morfologineoplasma_nama)',strtolower($this->morfologineoplasma_nama),true);
		$criteria->compare('LOWER(morfologineoplasma_namalainnya)',strtolower($this->morfologineoplasma_namalainnya),true);
		$criteria->compare('morfologineoplasma_aktif',isset($this->morfologineoplasma_aktif)?$this->morfologineoplasma_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('morfologineoplasma_id',$this->morfologineoplasma_id);
		$criteria->compare('LOWER(morfologineoplasma_nama)',strtolower($this->morfologineoplasma_nama),true);
		$criteria->compare('LOWER(morfologineoplasma_namalainnya)',strtolower($this->morfologineoplasma_namalainnya),true);
		$criteria->compare('morfologineoplasma_aktif',$this->morfologineoplasma_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}