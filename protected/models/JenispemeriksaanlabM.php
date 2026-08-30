<?php

/**
 * This is the model class for table "jenispemeriksaanlab_m".
 *
 * The followings are the available columns in table 'jenispemeriksaanlab_m':
 * @property integer $jenispemeriksaanlab_id
 * @property string $jenispemeriksaanlab_kode
 * @property integer $jenispemeriksaanlab_urutan
 * @property string $jenispemeriksaanlab_nama
 * @property string $jenispemeriksaanlab_namalainnya
 * @property string $jenispemeriksaanlab_kelompok
 * @property boolean $jenispemeriksaanlab_aktif
 */
class JenispemeriksaanlabM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispemeriksaanlabM the static model class
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
		return 'jenispemeriksaanlab_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanlab_kode, jenispemeriksaanlab_nama', 'required'),
			array('jenispemeriksaanlab_urutan', 'numerical', 'integerOnly'=>true),
			array('jenispemeriksaanlab_kode', 'length', 'max'=>10),
			array('jenispemeriksaanlab_nama, jenispemeriksaanlab_namalainnya', 'length', 'max'=>30),
			array('jenispemeriksaanlab_kelompok', 'length', 'max'=>100),
			array('jenispemeriksaanlab_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispemeriksaanlab_id, jenispemeriksaanlab_kode, jenispemeriksaanlab_urutan, jenispemeriksaanlab_nama, jenispemeriksaanlab_namalainnya, jenispemeriksaanlab_kelompok, jenispemeriksaanlab_aktif', 'safe', 'on'=>'search'),
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
			'jenispemeriksaanlab_id' => 'ID',
			'jenispemeriksaanlab_kode' => 'Kode',
			'jenispemeriksaanlab_urutan' => 'Urutan',
			'jenispemeriksaanlab_nama' => 'Nama',
			'jenispemeriksaanlab_namalainnya' => 'Nama Lainnya',
			'jenispemeriksaanlab_kelompok' => 'Kelompok',
			'jenispemeriksaanlab_aktif' => 'Aktif',

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

		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('LOWER(jenispemeriksaanlab_kode)',strtolower($this->jenispemeriksaanlab_kode),true);
		$criteria->compare('jenispemeriksaanlab_urutan',$this->jenispemeriksaanlab_urutan);
		$criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		$criteria->compare('LOWER(jenispemeriksaanlab_namalainnya)',strtolower($this->jenispemeriksaanlab_namalainnya),true);
		$criteria->compare('LOWER(jenispemeriksaanlab_kelompok)',strtolower($this->jenispemeriksaanlab_kelompok),true);
		$criteria->compare('jenispemeriksaanlab_aktif',isset($this->jenispemeriksaanlab_aktif)?$this->jenispemeriksaanlab_aktif:true);
//                $criteria->order='jenispemeriksaanlab_id';
//                $criteria->addCondition('jenispemeriksaanlab_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('LOWER(jenispemeriksaanlab_kode)',strtolower($this->jenispemeriksaanlab_kode),true);
		$criteria->compare('jenispemeriksaanlab_urutan',$this->jenispemeriksaanlab_urutan);
		$criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		$criteria->compare('LOWER(jenispemeriksaanlab_namalainnya)',strtolower($this->jenispemeriksaanlab_namalainnya),true);
		$criteria->compare('LOWER(jenispemeriksaanlab_kelompok)',strtolower($this->jenispemeriksaanlab_kelompok),true);
//		$criteria->compare('jenispemeriksaanlab_aktif',$this->jenispemeriksaanlab_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}