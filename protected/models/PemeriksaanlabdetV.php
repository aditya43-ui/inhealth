<?php

/**
 * This is the model class for table "pemeriksaanlabdet_v".
 *
 * The followings are the available columns in table 'pemeriksaanlabdet_v':
 * @property string $daftartindakan_nama
 * @property integer $pemeriksaanlab_id
 * @property string $pemeriksaanlab_kode
 * @property integer $pemeriksaanlab_urutan
 * @property string $pemeriksaanlab_nama
 * @property integer $nilairujukan_id
 * @property string $namapemeriksaandet
 * @property string $nilairujukan_jeniskelamin
 * @property string $nilairujukan_nama
 * @property double $nilairujukan_min
 * @property double $nilairujukan_max
 * @property string $nilairujukan_satuan
 * @property string $nilairujukan_metode
 * @property string $nilairujukan_keterangan
 * @property integer $pemeriksaanlabdet_nourut
 * @property string $kelkumurhasillabnama
 * @property integer $umurminlab
 * @property integer $umurmakslab
 * @property string $satuankelumur
 * @property integer $hariminlab
 * @property integer $harimakslab
 * @property integer $kelkumurhasillab_urutan
 * @property integer $kelkumurhasillab_id
 * @property integer $pemeriksaanlabdet_id
 * @property integer $daftartindakan_id
 */
class PemeriksaanlabdetV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabdetV the static model class
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
		return 'pemeriksaanlabdet_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanlab_id, pemeriksaanlab_urutan, nilairujukan_id, pemeriksaanlabdet_nourut, umurminlab, umurmakslab, hariminlab, harimakslab, kelkumurhasillab_urutan, kelkumurhasillab_id, pemeriksaanlabdet_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('nilairujukan_min, nilairujukan_max', 'numerical'),
			array('daftartindakan_nama, namapemeriksaandet', 'length', 'max'=>200),
			array('pemeriksaanlab_kode', 'length', 'max'=>10),
			array('pemeriksaanlab_nama', 'length', 'max'=>500),
			array('nilairujukan_jeniskelamin, nilairujukan_satuan, kelkumurhasillabnama', 'length', 'max'=>50),
			array('nilairujukan_nama', 'length', 'max'=>100),
			array('nilairujukan_metode', 'length', 'max'=>30),
			array('satuankelumur', 'length', 'max'=>20),
			array('nilairujukan_keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('daftartindakan_nama, pemeriksaanlab_id, pemeriksaanlab_kode, pemeriksaanlab_urutan, pemeriksaanlab_nama, nilairujukan_id, namapemeriksaandet, nilairujukan_jeniskelamin, nilairujukan_nama, nilairujukan_min, nilairujukan_max, nilairujukan_satuan, nilairujukan_metode, nilairujukan_keterangan, pemeriksaanlabdet_nourut, kelkumurhasillabnama, umurminlab, umurmakslab, satuankelumur, hariminlab, harimakslab, kelkumurhasillab_urutan, kelkumurhasillab_id, pemeriksaanlabdet_id, daftartindakan_id', 'safe', 'on'=>'search'),
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
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'pemeriksaanlab_kode' => 'Pemeriksaanlab Kode',
			'pemeriksaanlab_urutan' => 'Pemeriksaanlab Urutan',
			'pemeriksaanlab_nama' => 'Pemeriksaanlab Nama',
			'nilairujukan_id' => 'Nilairujukan',
			'namapemeriksaandet' => 'Namapemeriksaandet',
			'nilairujukan_jeniskelamin' => 'Nilairujukan Jeniskelamin',
			'nilairujukan_nama' => 'Nilairujukan Nama',
			'nilairujukan_min' => 'Nilairujukan Min',
			'nilairujukan_max' => 'Nilairujukan Max',
			'nilairujukan_satuan' => 'Nilairujukan Satuan',
			'nilairujukan_metode' => 'Nilairujukan Metode',
			'nilairujukan_keterangan' => 'Nilairujukan Keterangan',
			'pemeriksaanlabdet_nourut' => 'Pemeriksaanlabdet Nourut',
			'kelkumurhasillabnama' => 'Kelkumurhasillabnama',
			'umurminlab' => 'Umurminlab',
			'umurmakslab' => 'Umurmakslab',
			'satuankelumur' => 'Satuankelumur',
			'hariminlab' => 'Hariminlab',
			'harimakslab' => 'Harimakslab',
			'kelkumurhasillab_urutan' => 'Kelkumurhasillab Urutan',
			'kelkumurhasillab_id' => 'Kelkumurhasillab',
			'pemeriksaanlabdet_id' => 'Pemeriksaanlabdet',
			'daftartindakan_id' => 'Daftartindakan',
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

		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
		}
		$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
		if(!empty($this->pemeriksaanlab_urutan)){
			$criteria->addCondition('pemeriksaanlab_urutan = '.$this->pemeriksaanlab_urutan);
		}
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
		if(!empty($this->nilairujukan_id)){
			$criteria->addCondition('nilairujukan_id = '.$this->nilairujukan_id);
		}
		$criteria->compare('LOWER(namapemeriksaandet)',strtolower($this->namapemeriksaandet),true);
		$criteria->compare('LOWER(nilairujukan_jeniskelamin)',strtolower($this->nilairujukan_jeniskelamin),true);
		$criteria->compare('LOWER(nilairujukan_nama)',strtolower($this->nilairujukan_nama),true);
		$criteria->compare('nilairujukan_min',$this->nilairujukan_min);
		$criteria->compare('nilairujukan_max',$this->nilairujukan_max);
		$criteria->compare('LOWER(nilairujukan_satuan)',strtolower($this->nilairujukan_satuan),true);
		$criteria->compare('LOWER(nilairujukan_metode)',strtolower($this->nilairujukan_metode),true);
		$criteria->compare('LOWER(nilairujukan_keterangan)',strtolower($this->nilairujukan_keterangan),true);
		if(!empty($this->pemeriksaanlabdet_nourut)){
			$criteria->addCondition('pemeriksaanlabdet_nourut = '.$this->pemeriksaanlabdet_nourut);
		}
		$criteria->compare('LOWER(kelkumurhasillabnama)',strtolower($this->kelkumurhasillabnama),true);
		if(!empty($this->umurminlab)){
			$criteria->addCondition('umurminlab = '.$this->umurminlab);
		}
		if(!empty($this->umurmakslab)){
			$criteria->addCondition('umurmakslab = '.$this->umurmakslab);
		}
		$criteria->compare('LOWER(satuankelumur)',strtolower($this->satuankelumur),true);
		if(!empty($this->hariminlab)){
			$criteria->addCondition('hariminlab = '.$this->hariminlab);
		}
		if(!empty($this->harimakslab)){
			$criteria->addCondition('harimakslab = '.$this->harimakslab);
		}
		if(!empty($this->kelkumurhasillab_urutan)){
			$criteria->addCondition('kelkumurhasillab_urutan = '.$this->kelkumurhasillab_urutan);
		}
		if(!empty($this->kelkumurhasillab_id)){
			$criteria->addCondition('kelkumurhasillab_id = '.$this->kelkumurhasillab_id);
		}
		if(!empty($this->pemeriksaanlabdet_id)){
			$criteria->addCondition('pemeriksaanlabdet_id = '.$this->pemeriksaanlabdet_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}

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