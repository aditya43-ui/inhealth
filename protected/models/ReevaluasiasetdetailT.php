<?php

/**
 * This is the model class for table "reevaluasiasetdetail_t".
 *
 * The followings are the available columns in table 'reevaluasiasetdetail_t':
 * @property integer $reevaluasiasetdetail_id
 * @property integer $barang_id
 * @property integer $invtanah_id
 * @property integer $invgedung_id
 * @property integer $invperalatan_id
 * @property integer $invjalan_id
 * @property integer $invasetlain_id
 * @property double $reevaluasiaset_umurekonomis
 * @property double $reevaluasiaset_nilaibuku
 * @property double $reevaluasiaset_hargaperolehan
 * @property double $reevaluasiaset_selisihreevaluasi
 * @property integer $reevaluasiaset_id
 *
 * The followings are the available model relations:
 * @property ReevaluasiasetT $reevaluasiaset
 * @property BarangM $barang
 * @property InvtanahT $invtanah
 * @property InvjalanT $invjalan
 * @property InvgedungT $invgedung
 * @property InvperalatanT $invperalatan
 * @property InvasetlainT $invasetlain
 */
class ReevaluasiasetdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReevaluasiasetdetailT the static model class
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
		return 'reevaluasiasetdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, reevaluasiaset_id', 'required'),
			array('barang_id, invtanah_id, invgedung_id, invperalatan_id, invjalan_id, invasetlain_id, reevaluasiaset_id', 'numerical', 'integerOnly'=>true),
			array('reevaluasiaset_umurekonomis, reevaluasiaset_nilaibuku, reevaluasiaset_hargaperolehan, reevaluasiaset_selisihreevaluasi', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reevaluasiasetdetail_id, barang_id, invtanah_id, invgedung_id, invperalatan_id, invjalan_id, invasetlain_id, reevaluasiaset_umurekonomis, reevaluasiaset_nilaibuku, reevaluasiaset_hargaperolehan, reevaluasiaset_selisihreevaluasi, reevaluasiaset_id', 'safe', 'on'=>'search'),
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
			'reevaluasiaset' => array(self::BELONGS_TO, 'ReevaluasiasetT', 'reevaluasiaset_id'),
			'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
			'invtanah' => array(self::BELONGS_TO, 'InvtanahT', 'invtanah_id'),
			'invjalan' => array(self::BELONGS_TO, 'InvjalanT', 'invjalan_id'),
			'invgedung' => array(self::BELONGS_TO, 'InvgedungT', 'invgedung_id'),
			'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
			'invasetlain' => array(self::BELONGS_TO, 'InvasetlainT', 'invasetlain_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reevaluasiasetdetail_id' => 'Reevaluasiasetdetail',
			'barang_id' => 'Barang',
			'invtanah_id' => 'Invtanah',
			'invgedung_id' => 'Invgedung',
			'invperalatan_id' => 'Invperalatan',
			'invjalan_id' => 'Invjalan',
			'invasetlain_id' => 'Invasetlain',
			'reevaluasiaset_umurekonomis' => 'Reevaluasiaset Umurekonomis',
			'reevaluasiaset_nilaibuku' => 'Reevaluasiaset Nilaibuku',
			'reevaluasiaset_hargaperolehan' => 'Reevaluasiaset Hargaperolehan',
			'reevaluasiaset_selisihreevaluasi' => 'Reevaluasiaset Selisihreevaluasi',
			'reevaluasiaset_id' => 'Reevaluasiaset',
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

		if(!empty($this->reevaluasiasetdetail_id)){
			$criteria->addCondition('reevaluasiasetdetail_id = '.$this->reevaluasiasetdetail_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		$criteria->compare('reevaluasiaset_umurekonomis',$this->reevaluasiaset_umurekonomis);
		$criteria->compare('reevaluasiaset_nilaibuku',$this->reevaluasiaset_nilaibuku);
		$criteria->compare('reevaluasiaset_hargaperolehan',$this->reevaluasiaset_hargaperolehan);
		$criteria->compare('reevaluasiaset_selisihreevaluasi',$this->reevaluasiaset_selisihreevaluasi);
		if(!empty($this->reevaluasiaset_id)){
			$criteria->addCondition('reevaluasiaset_id = '.$this->reevaluasiaset_id);
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