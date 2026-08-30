<?php

/**
 * This is the model class for table "rencdetailkeb_t".
 *
 * The followings are the available columns in table 'rencdetailkeb_t':
 * @property integer $rencdetailkeb_id
 * @property integer $obatalkes_id
 * @property integer $sumberdana_id
 * @property integer $satuankecil_id
 * @property integer $rencanakebfarmasi_id
 * @property integer $satuanbesar_id
 * @property double $harganettorenc
 * @property double $persenppn
 * @property double $persenpph
 * @property double $hargatotalrenc
 * @property double $stokakhir
 * @property integer $maksimalstok
 * @property integer $minimalstok
 * @property double $jmlpermintaan
 * @property string $tglkadaluarsa
 * @property double $kemasanbesar
 * @property integer $buffer_stok
 * @property integer $on_order
 * @property integer $x_ratapemakaian
 * @property integer $stokonhand
 * @property string $kategori_abc
 * @property double $persen_abc
 *
 * The followings are the available model relations:
 * @property ObatalkesM $obatalkes
 * @property RencanakebfarmasiT $rencanakebfarmasi
 * @property SatuanbesarM $satuanbesar
 * @property SatuankecilM $satuankecil
 * @property SumberdanaM $sumberdana
 */
class RencdetailkebT extends CActiveRecord
{
        public $stok_awal;
        public $stok_akhirtot, $satuankecil_nama, $satuanbesar_nama, $satuanobat_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencdetailkebT the static model class
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
		return 'rencdetailkeb_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, rencanakebfarmasi_id, harganettorenc, persenppn, persenpph, hargatotalrenc, jmlpermintaan', 'required'),
			array('obatalkes_id, sumberdana_id, satuankecil_id, rencanakebfarmasi_id, satuanbesar_id, maksimalstok, minimalstok, buffer_stok, on_order, x_ratapemakaian, stokonhand', 'numerical', 'integerOnly'=>true),
			array('harganettorenc, persenppn, persenpph, hargatotalrenc, stokakhir, jmlpermintaan, kemasanbesar, persen_abc', 'numerical'),
			array('kategori_abc,ven', 'length', 'max'=>1),
			array('tglkadaluarsa, hpp, ppn', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencdetailkeb_id, obatalkes_id, sumberdana_id, satuankecil_id, rencanakebfarmasi_id, satuanbesar_id, harganettorenc, persenppn, persenpph, hargatotalrenc, stokakhir, maksimalstok, minimalstok, jmlpermintaan, tglkadaluarsa, kemasanbesar, buffer_stok, on_order, x_ratapemakaian, stokonhand, kategori_abc, persen_abc,ven,supplier_id', 'safe', 'on'=>'search'),
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
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'rencanakebfarmasi' => array(self::BELONGS_TO, 'RencanakebfarmasiT', 'rencanakebfarmasi_id'),
			'satuanbesar' => array(self::BELONGS_TO, 'SatuanbesarM', 'satuanbesar_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
			'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencdetailkeb_id' => 'ID',
			'obatalkes_id' => 'Obat ALkes',
			'sumberdana_id' => 'Sumber Dana',
			'satuankecil_id' => 'Satuan Kecil',
			'rencanakebfarmasi_id' => 'ID Rencana Kebutuhan',
			'satuanbesar_id' => 'Satuan Besar',
			'harganettorenc' => 'Harga Netto Rencana',
			'persenppn' => 'PPN',
			'persenpph' => 'PPH',
			'hargatotalrenc' => 'Harga Total Rencana',
			'stokakhir' => 'Stok AKhir',
			'maksimalstok' => 'Maksimal Stok',
			'minimalstok' => 'Minimal Stok',
			'jmlpermintaan' => 'Jumlah Permintaan',
			'tglkadaluarsa' => 'Tanggal Kedaluwarsa',
			'kemasanbesar' => 'Kemasan Besar',
			'buffer_stok' => 'Buffer Stok',
			'on_order' => 'On Order',
			'x_ratapemakaian' => 'X Rata-rata Pemakaian',
			'stokonhand' => 'Stok on Hand',
			'kategori_abc' => 'Kategori ABC',
			'persen_abc' => 'Persen ABC',
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

		if(!empty($this->rencdetailkeb_id)){
			$criteria->addCondition('rencdetailkeb_id = '.$this->rencdetailkeb_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->rencanakebfarmasi_id)){
			$criteria->addCondition('rencanakebfarmasi_id = '.$this->rencanakebfarmasi_id);
		}
		if(!empty($this->satuanbesar_id)){
			$criteria->addCondition('satuanbesar_id = '.$this->satuanbesar_id);
		}
		$criteria->compare('harganettorenc',$this->harganettorenc);
		$criteria->compare('persenppn',$this->persenppn);
		$criteria->compare('persenpph',$this->persenpph);
		$criteria->compare('hargatotalrenc',$this->hargatotalrenc);
		$criteria->compare('stokakhir',$this->stokakhir);
		if(!empty($this->maksimalstok)){
			$criteria->addCondition('maksimalstok = '.$this->maksimalstok);
		}
		if(!empty($this->minimalstok)){
			$criteria->addCondition('minimalstok = '.$this->minimalstok);
		}
		$criteria->compare('jmlpermintaan',$this->jmlpermintaan);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		if(!empty($this->buffer_stok)){
			$criteria->addCondition('buffer_stok = '.$this->buffer_stok);
		}
		if(!empty($this->on_order)){
			$criteria->addCondition('on_order = '.$this->on_order);
		}
		if(!empty($this->x_ratapemakaian)){
			$criteria->addCondition('x_ratapemakaian = '.$this->x_ratapemakaian);
		}
		if(!empty($this->stokonhand)){
			$criteria->addCondition('stokonhand = '.$this->stokonhand);
		}
		$criteria->compare('LOWER(kategori_abc)',strtolower($this->kategori_abc),true);
		$criteria->compare('persen_abc',$this->persen_abc);

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
        
        /**
         * - digunakan untuk mengenerate  jumlah permintaan, ssuai dengan periode ronya
         * @param type $renkebbarang_id
         * @return type
         */
        public function getSisaRencana($renkebbarang_id){
            $p = PermintaanpembelianT::model()->findAllByAttributes(array(
                    'rencanakebfarmasi_id'=>$renkebbarang_id     
            ));
                                    
            $jum = 0;                        
            $getTerima = '';
            $ok = true;

            if (count((array)$p)>0){                                                                                                        
                foreach ($p as $brg){ 
                     if ( (!empty($brg->penerimaanbarang_id)) && ($brg->penerimaanbarang->statuspenerimaan == Params::STATUS_TERIMAOA_DISETUJUI)){
                         
                        $det = PenerimaandetailT::model()->findAll(" penerimaanbarang_id = '".$brg->penerimaanbarang_id."' AND returdetail_id IS NULL ORDER BY obatalkes_id");                                                            
                        foreach($det as $dt){
                            
                            if (isset($jumDt[$dt->obatalkes_id])){
                                $jumDt[$dt->obatalkes_id] = $jumDt[$dt->obatalkes_id] + $dt->jmlterima;    
                            }else{
                                $jumDt[$dt->obatalkes_id]  = $dt->jmlterima;
                            }
                            
                            $getTerima[$dt->obatalkes_id] = array(
                                'obatalkes_id' => $dt->obatalkes_id,
                                'stok' => $jumDt[$dt->obatalkes_id],
                            );
                            
                        }
                        $jum = 0;
                     }
                }

            }

            return $getTerima;
        }
}