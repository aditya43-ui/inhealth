<?php

/**
 * This is the model class for table "pengajuansterlilisasidet_t".
 *
 * The followings are the available columns in table 'pengajuansterlilisasidet_t':
 * @property integer $pengajuansterlilisasidet_id
 * @property integer $barang_id
 * @property integer $pengajuansterlilisasi_id
 * @property integer $linen_id
 * @property integer $pengajuansterlilisasidet_jml
 * @property string $pengajuansterlilisasidet_ket
 */
class PengajuansterlilisasidetT extends CActiveRecord
{
    public $keadaanperalatan;
    public $jenisperalatan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuansterlilisasidetT the static model class
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
		return 'pengajuansterlilisasidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('peralatansterilisasi_id, pengajuansterlilisasi_id, pengajuansterlilisasidet_jml', 'required'),
			array('peralatansterilisasi_id, pengajuansterlilisasi_id, linen_id, pengajuansterlilisasidet_jml', 'numerical', 'integerOnly'=>true),
			array('pengajuansterlilisasidet_ket', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuansterlilisasidet_id, barang_id, pengajuansterlilisasi_id, linen_id, pengajuansterlilisasidet_jml, pengajuansterlilisasidet_ket', 'safe', 'on'=>'search'),
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
            'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id'),
			'barang'=>array(self::BELONGS_TO,'BarangM','barang_id'),
			'pengajuan'=>array(self::BELONGS_TO,'PengajuansterlilisasiT','pengajuansterlilisasi_id'),
            'peralatansterilisasi'=>array(self::BELONGS_TO, 'PeralatansterilisasiM', 'peralatansterilisasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuansterlilisasidet_id' => 'Pengajuansterlilisasidet',
			'barang_id' => 'Barang',
			'pengajuansterlilisasi_id' => 'Pengajuansterlilisasi',
			'linen_id' => 'Linen',
			'pengajuansterlilisasidet_jml' => 'Jumlah',
			'pengajuansterlilisasidet_ket' => 'Keterangan',
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

		if(!empty($this->pengajuansterlilisasidet_id)){
			$criteria->addCondition('pengajuansterlilisasidet_id = '.$this->pengajuansterlilisasidet_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->pengajuansterlilisasi_id)){
			$criteria->addCondition('pengajuansterlilisasi_id = '.$this->pengajuansterlilisasi_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->pengajuansterlilisasidet_jml)){
			$criteria->addCondition('pengajuansterlilisasidet_jml = '.$this->pengajuansterlilisasidet_jml);
		}
		$criteria->compare('LOWER(pengajuansterlilisasidet_ket)',strtolower($this->pengajuansterlilisasidet_ket),true);

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