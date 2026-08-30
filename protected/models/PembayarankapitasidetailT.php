<?php

/**
 * This is the model class for table "pembayarankapitasidetail_t".
 *
 * The followings are the available columns in table 'pembayarankapitasidetail_t':
 * @property integer $pembayarankapitasidetail_id
 * @property integer $pembayarankapitasi_id
 * @property integer $pendaftaran_id
 * @property double $pembayarankapitasidetail_totalpembayaran
 *
 * The followings are the available model relations:
 * @property BayaruangmukaT[] $bayaruangmukaTs
 * @property TandabuktibayarT[] $tandabuktibayarTs
 * @property PembayarankapitasiT $pembayarankapitasi
 * @property PendaftaranT $pendaftaran
 */
class PembayarankapitasidetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayarankapitasidetailT the static model class
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
		return 'pembayarankapitasidetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayarankapitasi_id, pendaftaran_id', 'required'),
			array('pembayarankapitasi_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('pembayarankapitasidetail_totalpembayaran', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayarankapitasidetail_id, pembayarankapitasi_id, pendaftaran_id, pembayarankapitasidetail_totalpembayaran', 'safe', 'on'=>'search'),
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
			'bayaruangmukaTs' => array(self::HAS_MANY, 'BayaruangmukaT', 'pembayarankapitasidetail_id'),
			'tandabuktibayarTs' => array(self::HAS_MANY, 'TandabuktibayarT', 'pembayarankapitasidetail_id'),
			'pembayarankapitasi' => array(self::BELONGS_TO, 'PembayarankapitasiT', 'pembayarankapitasi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembayarankapitasidetail_id' => 'Pembayarankapitasidetail',
			'pembayarankapitasi_id' => 'Pembayarankapitasi',
			'pendaftaran_id' => 'Pendaftaran',
			'pembayarankapitasidetail_totalpembayaran' => 'Pembayarankapitasidetail Totalpembayaran',
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

		if(!empty($this->pembayarankapitasidetail_id)){
			$criteria->addCondition('pembayarankapitasidetail_id = '.$this->pembayarankapitasidetail_id);
		}
		if(!empty($this->pembayarankapitasi_id)){
			$criteria->addCondition('pembayarankapitasi_id = '.$this->pembayarankapitasi_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('pembayarankapitasidetail_totalpembayaran',$this->pembayarankapitasidetail_totalpembayaran);

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