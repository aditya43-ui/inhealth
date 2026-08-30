<?php

/**
 * This is the model class for table "jenispemeriksaanrad_m".
 *
 * The followings are the available columns in table 'jenispemeriksaanrad_m':
 * @property integer $jenispemeriksaanrad_id
 * @property string $jenispemeriksaanrad_kode
 * @property integer $jenispemeriksaanrad_urutan
 * @property string $jenispemeriksaanrad_nama
 * @property string $jenispemeriksaanrad_namalain
 * @property boolean $jenispemeriksaanrad_aktif
 */
class JenispemeriksaanradM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispemeriksaanradM the static model class
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
		return 'jenispemeriksaanrad_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanrad_kode, jenispemeriksaanrad_urutan, jenispemeriksaanrad_nama, jenispemeriksaanrad_namalain, jenispemeriksaanrad_aktif', 'required'),
			array('jenispemeriksaanrad_urutan', 'numerical', 'integerOnly'=>true),
			array('jenispemeriksaanrad_kode', 'length', 'max'=>10),
			array('jenispemeriksaanrad_nama, jenispemeriksaanrad_namalain', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispemeriksaanrad_id, jenispemeriksaanrad_kode, jenispemeriksaanrad_urutan, jenispemeriksaanrad_nama, jenispemeriksaanrad_namalain, jenispemeriksaanrad_aktif', 'safe', 'on'=>'search'),
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
			'jenispemeriksaanrad_id' => 'Jenis pemeriksaanrad',
			'jenispemeriksaanrad_kode' => 'Jenispemeriksaanrad Kode',
			'jenispemeriksaanrad_urutan' => 'Jenispemeriksaanrad Urutan',
			'jenispemeriksaanrad_nama' => 'Jenispemeriksaanrad Nama',
			'jenispemeriksaanrad_namalain' => 'Jenispemeriksaanrad Namalain',
			'jenispemeriksaanrad_aktif' => 'Jenispemeriksaanrad Aktif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenispemeriksaanrad_id',$this->jenispemeriksaanrad_id);
		$criteria->compare('LOWER(jenispemeriksaanrad_kode)',strtolower($this->jenispemeriksaanrad_kode),true);
		$criteria->compare('jenispemeriksaanrad_urutan',$this->jenispemeriksaanrad_urutan);
		$criteria->compare('LOWER(jenispemeriksaanrad_nama)',strtolower($this->jenispemeriksaanrad_nama),true);
		$criteria->compare('LOWER(jenispemeriksaanrad_namalain)',strtolower($this->jenispemeriksaanrad_namalain),true);
		$criteria->compare('jenispemeriksaanrad_aktif',$this->jenispemeriksaanrad_aktif);

		return $criteria;
	}
        
        
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }


    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
}