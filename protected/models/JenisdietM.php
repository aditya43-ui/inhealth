<?php

/**
 * This is the model class for table "jenisdiet_m".
 *
 * The followings are the available columns in table 'jenisdiet_m':
 * @property integer $jenisdiet_id
 * @property string $jenisdiet_nama
 * @property string $jenisdiet_namalainnya
 * @property string $jenisdiet_keterangan
 * @property string $jenisdiet_catatan
 * @property boolean $jenisdiet_aktif
 */
class JenisdietM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisdietM the static model class
	 */
    
        public $jenisdietNama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jenisdiet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiet_nama', 'required'),
			array('jenisdiet_nama, jenisdiet_namalainnya', 'length', 'max'=>50),
			array('jenisdiet_keterangan, jenisdiet_catatan, jenisdiet_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisdiet_id, jenisdiet_nama, jenisdiet_namalainnya, jenisdiet_keterangan, jenisdiet_catatan, jenisdiet_aktif', 'safe', 'on'=>'search'),
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
			'jenisdiet_id' => 'ID',
			'jenisdiet_nama' => 'Nama Jenis',
			'jenisdiet_namalainnya' => 'Nama Lainnya',
			'jenisdiet_keterangan' => 'Keterangan',
			'jenisdiet_catatan' => 'Catatan',
			'jenisdiet_aktif' => 'Aktif',
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

		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('LOWER(jenisdiet_namalainnya)',strtolower($this->jenisdiet_namalainnya),true);
		$criteria->compare('LOWER(jenisdiet_keterangan)',strtolower($this->jenisdiet_keterangan),true);
		$criteria->compare('LOWER(jenisdiet_catatan)',strtolower($this->jenisdiet_catatan),true);
		$criteria->compare('jenisdiet_aktif',isset($this->jenisdiet_aktif)?$this->jenisdiet_aktif:true);
//                $criteria->addCondition('jenisdiet_aktif is true');
                $criteria->order="jenisdiet_nama ASC";   
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('LOWER(jenisdiet_namalainnya)',strtolower($this->jenisdiet_namalainnya),true);
		$criteria->compare('LOWER(jenisdiet_keterangan)',strtolower($this->jenisdiet_keterangan),true);
		$criteria->compare('LOWER(jenisdiet_catatan)',strtolower($this->jenisdiet_catatan),true);
		$criteria->compare('jenisdiet_aktif',isset($this->jenisdiet_aktif)?$this->jenisdiet_aktif:true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->order="jenisdiet_nama ASC";   
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}