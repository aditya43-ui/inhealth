<?php

/**
 * This is the model class for table "piutangasuransi_t".
 *
 * The followings are the available columns in table 'piutangasuransi_t':
 * @property integer $piutangasuransi_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property double $jmlpiutangasuransi
 *
 * The followings are the available model relations:
 * @property CarabayarM $carabayar
 * @property PembayaranpelayananT $pembayaranpelayanan
 * @property PenjaminpasienM $penjamin
 */
class PiutangasuransiT extends CActiveRecord
{
	public $jmltindakanasuransi, $jmloaasuransi;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PiutangasuransiT the static model class
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
		return 'piutangasuransi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayaranpelayanan_id, penjamin_id, carabayar_id', 'numerical', 'integerOnly'=>true),
			array('jmlpiutangasuransi', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('piutangasuransi_id, pembayaranpelayanan_id, penjamin_id, carabayar_id, jmlpiutangasuransi', 'safe', 'on'=>'search'),
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
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'pembayaranpelayanan' => array(self::BELONGS_TO, 'PembayaranpelayananT', 'pembayaranpelayanan_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'piutangasuransi_id' => 'Piutangasuransi',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Carabayar',
			'jmlpiutangasuransi' => 'Jmlpiutangasuransi',
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

		if(!empty($this->piutangasuransi_id)){
			$criteria->addCondition('piutangasuransi_id = '.$this->piutangasuransi_id);
		}
		if(!empty($this->pembayaranpelayanan_id)){
			$criteria->addCondition('pembayaranpelayanan_id = '.$this->pembayaranpelayanan_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('jmlpiutangasuransi',$this->jmlpiutangasuransi);

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