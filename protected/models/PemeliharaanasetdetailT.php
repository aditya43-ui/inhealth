<?php

/**
 * This is the model class for table "pemeliharaanasetdet_t".
 *
 * The followings are the available columns in table 'pemeliharaanasetdet_t':
 * @property integer $pemeliharaanasetdet_id
 * @property integer $invgedung_id
 * @property integer $invasetlain_id
 * @property integer $inventarisasi_id
 * @property integer $invperalatan_id
 * @property integer $barang_id
 * @property integer $asalaset_id
 * @property integer $pemeliharaanaset_id
 * @property string $pemeliharaanasetdet_tgl
 * @property string $kondisiaset
 * @property string $keteranganaset
 */
class PemeliharaanasetdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeliharaanasetdetailT the static model class
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
		return 'pemeliharaanasetdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeliharaanaset_id, pemeliharaanasetdet_tgl, kondisiaset', 'required'),
			array('invgedung_id, invasetlain_id, inventarisasi_id, invperalatan_id, barang_id, asalaset_id, pemeliharaanaset_id', 'numerical', 'integerOnly'=>true),
			array('kondisiaset', 'length', 'max'=>100),
			array('keteranganaset', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeliharaanasetdet_id, invgedung_id, invasetlain_id, inventarisasi_id, invperalatan_id, barang_id, asalaset_id, pemeliharaanaset_id, pemeliharaanasetdet_tgl, kondisiaset, keteranganaset', 'safe', 'on'=>'search'),
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
			'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
			'kondisiasset' => array(self::BELONGS_TO, 'LookupM', 'kondisiaset'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeliharaanasetdet_id' => 'Pemeliharaanasetdet',
			'invgedung_id' => 'Invgedung',
			'invasetlain_id' => 'Invasetlain',
			'inventarisasi_id' => 'Inventarisasi',
			'invperalatan_id' => 'Invperalatan',
			'barang_id' => 'Barang',
			'asalaset_id' => 'Asalaset',
			'pemeliharaanaset_id' => 'Pemeliharaanaset',
			'pemeliharaanasetdet_tgl' => 'Pemeliharaanasetdet Tgl',
			'kondisiaset' => 'Kondisiaset',
			'keteranganaset' => 'Keteranganaset',
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

		if(!empty($this->pemeliharaanasetdet_id)){
			$criteria->addCondition('pemeliharaanasetdet_id = '.$this->pemeliharaanasetdet_id);
		}
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		if(!empty($this->inventarisasi_id)){
			$criteria->addCondition('inventarisasi_id = '.$this->inventarisasi_id);
		}
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->asalaset_id)){
			$criteria->addCondition('asalaset_id = '.$this->asalaset_id);
		}
		if(!empty($this->pemeliharaanaset_id)){
			$criteria->addCondition('pemeliharaanaset_id = '.$this->pemeliharaanaset_id);
		}
		$criteria->compare('LOWER(pemeliharaanasetdet_tgl)',strtolower($this->pemeliharaanasetdet_tgl),true);
		$criteria->compare('LOWER(kondisiaset)',strtolower($this->kondisiaset),true);
		$criteria->compare('LOWER(keteranganaset)',strtolower($this->keteranganaset),true);

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