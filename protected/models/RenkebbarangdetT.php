<?php

/**
 * This is the model class for table "renkebbarangdet_t".
 *
 * The followings are the available columns in table 'renkebbarangdet_t':
 * @property integer $renkebbarangdet_id
 * @property integer $renkebbarang_id
 * @property integer $barang_id
 * @property string $satuanbarangdet
 * @property integer $jmlpermintaanbarangdet
 * @property double $harga_barangdet
 * @property integer $stokakhir_barangdet
 * @property integer $minstok_barangdet
 * @property integer $makstok_barangdet
 */
class RenkebbarangdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RenkebbarangdetT the static model class
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
		return 'renkebbarangdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('renkebbarang_id, barang_id, satuanbarangdet, jmlpermintaanbarangdet, harga_barangdet, stokakhir_barangdet, minstok_barangdet, makstok_barangdet', 'required'),
			array('renkebbarang_id, barang_id, stokakhir_barangdet, minstok_barangdet, makstok_barangdet', 'numerical', 'integerOnly'=>true),
			array('jmlpermintaanbarangdet', 'numerical'),
			array('harga_barangdet', 'numerical'),
			array('satuanbarangdet', 'length', 'max'=>50),
                        array('persen_ppn, hpp, ppn', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('renkebbarangdet_id, renkebbarang_id, barang_id, satuanbarangdet, jmlpermintaanbarangdet, harga_barangdet, stokakhir_barangdet, minstok_barangdet, makstok_barangdet', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'renkebbarangdet_id' => 'Renkebbarangdet',
			'renkebbarang_id' => 'Renkebbarang',
			'barang_id' => 'Barang',
			'satuanbarangdet' => 'Satuanbarangdet',
			'jmlpermintaanbarangdet' => 'Jmlpermintaanbarangdet',
			'harga_barangdet' => 'Harga Barangdet',
			'stokakhir_barangdet' => 'Stokakhir Barangdet',
			'minstok_barangdet' => 'Minstok Barangdet',
			'makstok_barangdet' => 'Makstok Barangdet',
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

		if(!empty($this->renkebbarangdet_id)){
			$criteria->addCondition('renkebbarangdet_id = '.$this->renkebbarangdet_id);
		}
		if(!empty($this->renkebbarang_id)){
			$criteria->addCondition('renkebbarang_id = '.$this->renkebbarang_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(satuanbarangdet)',strtolower($this->satuanbarangdet),true);
		if(!empty($this->jmlpermintaanbarangdet)){
			$criteria->addCondition('jmlpermintaanbarangdet = '.$this->jmlpermintaanbarangdet);
		}
		$criteria->compare('harga_barangdet',$this->harga_barangdet);
		if(!empty($this->stokakhir_barangdet)){
			$criteria->addCondition('stokakhir_barangdet = '.$this->stokakhir_barangdet);
		}
		if(!empty($this->minstok_barangdet)){
			$criteria->addCondition('minstok_barangdet = '.$this->minstok_barangdet);
		}
		if(!empty($this->makstok_barangdet)){
			$criteria->addCondition('makstok_barangdet = '.$this->makstok_barangdet);
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
        
        public function getSisaRencana($renkebbarang_id){
            $p = PembelianbarangT::model()->findAllByAttributes(array(
                    'renkebbarang_id'=>$renkebbarang_id     
            ));
                                    
            $jum = 0;                        
            $getTerima = '';
            $ok = true;

            if (count((array)$p)>0){                                                                                                        
                foreach ($p as $brg){ 
                     if (!empty($brg->terimapersediaan_id)){
                        $det = TerimapersdetailT::model()->findAll(" terimapersediaan_id = '".$brg->terimapersediaan_id."' ORDER BY barang_id");                                                            
                        foreach($det as $dt){
                            
                            if (isset($jumDt[$dt->barang_id])){
                                $jumDt[$dt->barang_id] = $jumDt[$dt->barang_id] + $dt->jmlterima;    
                            }else{
                                $jumDt[$dt->barang_id]  = $dt->jmlterima;
                            }
                            
                            $getTerima[$dt->barang_id] = array(
                                'barang_id' => $dt->barang_id,
                                'stok' => $jumDt[$dt->barang_id],
                            );
                            
                        }
                        $jum = 0;
                     }
                }

            }

            return $getTerima;
        }
}