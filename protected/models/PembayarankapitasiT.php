<?php

/**
 * This is the model class for table "pembayarankapitasi_t".
 *
 * The followings are the available columns in table 'pembayarankapitasi_t':
 * @property integer $pembayarankapitasi_id
 * @property string $pembayarankapitasi_no
 * @property string $pembayarankapitasi_tgl
 * @property double $pembayarankapitasi_totaltarifkapitasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PembayarankapitasidetailT[] $pembayarankapitasidetailTs
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 */
class PembayarankapitasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayarankapitasiT the static model class
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
		return 'pembayarankapitasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayarankapitasi_no, pembayarankapitasi_tgl, create_time, create_loginpemakai_id', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pembayarankapitasi_totaltarifkapitasi', 'numerical'),
			array('pembayarankapitasi_no', 'length', 'max'=>25),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayarankapitasi_id, pembayarankapitasi_no, pembayarankapitasi_tgl, pembayarankapitasi_totaltarifkapitasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pembayarankapitasidetailTs' => array(self::HAS_MANY, 'PembayarankapitasidetailT', 'pembayarankapitasi_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembayarankapitasi_id' => 'ID',
			'pembayarankapitasi_no' => 'No. Pembayaran Kapitasi',
			'pembayarankapitasi_tgl' => 'Tanggal Pembayaran',
			'pembayarankapitasi_totaltarifkapitasi' => 'Total Tarif Kapitasi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->pembayarankapitasi_id)){
			$criteria->addCondition('pembayarankapitasi_id = '.$this->pembayarankapitasi_id);
		}
		$criteria->compare('LOWER(pembayarankapitasi_no)',strtolower($this->pembayarankapitasi_no),true);
		$criteria->compare('LOWER(pembayarankapitasi_tgl)',strtolower($this->pembayarankapitasi_tgl),true);
		$criteria->compare('pembayarankapitasi_totaltarifkapitasi',$this->pembayarankapitasi_totaltarifkapitasi);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
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