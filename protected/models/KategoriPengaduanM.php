<?php

/**
 * This is the model class for table "instalasi_m".
 *
 * The followings are the available columns in table 'instalasi_m':
 * @property integer $kategoripengaduan_id
 * @property string $namakategori
 * @property string $warnakategoripengaduan
 * @property string $estimasipenyelesaian
 * @property boolean $kategoripengaduan_aktif
 *
 * The followings are the available model relations:
 * @property RuanganM[] $ruanganMs
 */
class KategoriPengaduanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KategoriPengaduanM the static model class
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
		return 'kategoripengaduan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('namakategori, warnakategoripengaduan, estimasipenyelesaian', 'required'),
			array('namakategori, warnakategoripengaduan,', 'length', 'max'=>50),
			array('estimasipenyelesaian, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kategoripengaduan_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kategoripengaduan_id, namakategori, warnakategoripengaduan, estimasipenyelesaian, kategoripengaduan_aktif', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		// return array(
		// 	'ruanganMs' => array(self::HAS_MANY, 'RuanganM', 'kategoripengaduan_id'),
		// );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kategoripengaduan_id' => 'ID',
			'namakategori' => 'Kategori Pengaduan',
			'warnakategoripengaduan' => 'Label Warna',
			'estimasipenyelesaian' => 'Estimasi Penyelesaian',
			'kategoripengaduan_aktif' => 'Status',
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
		$criteria->compare('kategoripengaduan_id',$this->kategoripengaduan_id);
		$criteria->compare('LOWER(namakategori)',strtolower($this->namakategori),true);
		$criteria->compare('LOWER(warnakategoripengaduan)',strtolower($this->warnakategoripengaduan),true);
		$criteria->compare('estimasipenyelesaian',$this->estimasipenyelesaian);
		$criteria->compare('kategoripengaduan_aktif',isset($this->kategoripengaduan_aktif)?$this->kategoripengaduan_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kategoripengaduan_id',$this->kategoripengaduan_id);
		$criteria->compare('LOWER(namakategori)',strtolower($this->namakategori),true);
		$criteria->compare('LOWER(warnakategoripengaduan)',strtolower($this->warnakategoripengaduan),true);
		$criteria->compare('estimasipenyelesaian',$this->estimasipenyelesaian);
		$criteria->compare('kategoripengaduan_aktif',$this->kategoripengaduan_aktif);
		$criteria->limit=-1;
		$criteria->order='namakategori';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
        
	public function beforeSave() {
		$this->namakategori = ucwords(strtolower($this->namakategori));
		$this->warnakategoripengaduan = strtoupper($this->warnakategoripengaduan);
		return parent::beforeSave();
	}
        
    public static function getKategoriPengaduanItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('kategoripengaduan_aktif = TRUE');
		$criteria->order = "namakategori";
		$data = self::model()->findAll($criteria);

		return CHtml::listData($data, 'kategoripengaduan_id', 'namakategori');
	}
}