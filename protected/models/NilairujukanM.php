<?php

/**
 * This is the model class for table "nilairujukan_m".
 *
 * The followings are the available columns in table 'nilairujukan_m':
 * @property integer $nilairujukan_id
 * @property integer $kelkumurhasillab_id
 * @property string $kelompokdet
 * @property string $namapemeriksaandet
 * @property string $nilairujukan_jeniskelamin
 * @property string $nilairujukan_nama
 * @property double $nilairujukan_min
 * @property double $nilairujukan_max
 * @property string $nilairujukan_satuan
 * @property string $nilairujukan_metode
 * @property string $nilairujukan_keterangan
 * @property boolean $nilairujukan_aktif
 *
 * The followings are the available model relations:
 * @property PemeriksaanlabdetM[] $pemeriksaanlabdetMs
 */
class NilairujukanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NilairujukanM the static model class
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
		return 'nilairujukan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelkumurhasillab_id, namapemeriksaandet, nilairujukan_jeniskelamin, nilairujukan_nama', 'required'),
			array('kelkumurhasillab_id, jeniskegiatanlab_id', 'numerical', 'integerOnly'=>true),
			array('nilairujukan_min, nilairujukan_max', 'numerical'),
			array('kelompokdet, nilairujukan_jeniskelamin, nilairujukan_satuan', 'length', 'max'=>50),
			array('namapemeriksaandet', 'length', 'max'=>200),
			array('nilairujukan_nama', 'length', 'max'=>100),
			array('nilairujukan_metode', 'length', 'max'=>30),
			array('nilairujukan_keterangan, nilairujukan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nilairujukan_id, kelkumurhasillab_id, kelompokdet, namapemeriksaandet, nilairujukan_jeniskelamin, nilairujukan_nama, nilairujukan_min, nilairujukan_max, nilairujukan_satuan, nilairujukan_metode, nilairujukan_keterangan, nilairujukan_aktif, jeniskegiatanlab_id', 'safe', 'on'=>'search'),
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
			'pemeriksaanlabdetMs' => array(self::HAS_MANY, 'PemeriksaanlabdetM', 'nilairujukan_id'),
			'kelkumurhasillab' => array(self::BELONGS_TO, 'KelkumurhasillabM', 'kelkumurhasillab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nilairujukan_id' => 'Nilai Rujukan',
			'kelkumurhasillab_id' => 'Kelompok Umur',
			'kelompokdet' => 'Kelompok Detail',
			'namapemeriksaandet' => 'Nama Detail Pemeriksaan',
			'nilairujukan_jeniskelamin' => 'Jenis Kelamin',
			'nilairujukan_nama' => 'Nilai Rujukan',
			'nilairujukan_min' => 'Nilai Minimum',
			'nilairujukan_max' => 'Nilai Maksimum',
			'nilairujukan_satuan' => 'Satuan',
			'nilairujukan_metode' => 'Metode',
			'nilairujukan_keterangan' => 'Keterangan',
			'nilairujukan_aktif' => 'Status Aktif',
			'jeniskegiatanlab_id'=>'Jenis Kegiatan Lab'
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

		if(!empty($this->nilairujukan_id)){
			$criteria->addCondition('nilairujukan_id = '.$this->nilairujukan_id);
		}
		if(!empty($this->kelkumurhasillab_id)){
			$criteria->addCondition('kelkumurhasillab_id = '.$this->kelkumurhasillab_id);
		}
		$criteria->compare('LOWER(kelompokdet)',strtolower($this->kelompokdet),true);
		$criteria->compare('LOWER(namapemeriksaandet)',strtolower($this->namapemeriksaandet),true);
		$criteria->compare('LOWER(nilairujukan_jeniskelamin)',strtolower($this->nilairujukan_jeniskelamin),true);
		$criteria->compare('LOWER(nilairujukan_nama)',strtolower($this->nilairujukan_nama),true);
		$criteria->compare('nilairujukan_min',$this->nilairujukan_min);
		$criteria->compare('nilairujukan_max',$this->nilairujukan_max);
		$criteria->compare('LOWER(nilairujukan_satuan)',strtolower($this->nilairujukan_satuan),true);
		$criteria->compare('LOWER(nilairujukan_metode)',strtolower($this->nilairujukan_metode),true);
		$criteria->compare('LOWER(nilairujukan_keterangan)',strtolower($this->nilairujukan_keterangan),true);
		$criteria->compare('nilairujukan_aktif',$this->nilairujukan_aktif);

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