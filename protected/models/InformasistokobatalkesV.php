<?php

/**
 * This is the model class for table "informasistokobatalkes_v".
 *
 * The followings are the available columns in table 'informasistokobatalkes_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_kode
 * @property string $jenisobatalkes_nama
 * @property boolean $jenisobatalkes_farmasi
 * @property integer $obatalkes_id
 * @property string $obatalkes_barcode
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_namalain
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $asalbarang_id
 * @property string $asalbarang_nama
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property double $hpp_max
 * @property double $hpp_min
 * @property double $hpp_avg
 * @property double $hargajual_max
 * @property double $hargajual_min
 * @property double $hargajual_avg
 * @property double $qtystok
 * @property double $hargajual
 * @property double $hpp
 * @property integer $lokasiobat_id
 * @property string $lokasiobat_nama
 * @property integer $rakobat_id
 * @property string $rakobat_nama
 * @property string $rakobat_label
 * @property string $nobatch
 * @property string $tglkadaluarsa
 */
class InformasistokobatalkesV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasistokobatalkesV the static model class
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
		return 'informasistokobatalkes_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, jenisobatalkes_id, obatalkes_id, asalbarang_id, satuankecil_id, lokasiobat_id, rakobat_id', 'numerical', 'integerOnly'=>true),
			array('hpp_max, hpp_min, hpp_avg, hargajual_max, hargajual_min, hargajual_avg, qtystok, hargajual, hpp', 'numerical'),
			array('instalasi_nama, ruangan_nama, jenisobatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, asalbarang_nama, satuankecil_nama, nobatch', 'length', 'max'=>50),
			array('jenisobatalkes_kode', 'length', 'max'=>10),
			array('obatalkes_barcode, obatalkes_kode, obatalkes_nama, rakobat_nama', 'length', 'max'=>200),
			array('obatalkes_kadarobat', 'length', 'max'=>20),
			array('lokasiobat_nama', 'length', 'max'=>100),
			array('rakobat_label', 'length', 'max'=>1),
			array('jenisobatalkes_farmasi, tglkadaluarsa', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, jenisobatalkes_id, jenisobatalkes_kode, jenisobatalkes_nama, jenisobatalkes_farmasi, obatalkes_id, obatalkes_barcode, obatalkes_kode, obatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, asalbarang_id, asalbarang_nama, satuankecil_id, satuankecil_nama, hpp_max, hpp_min, hpp_avg, hargajual_max, hargajual_min, hargajual_avg, qtystok, hargajual, hpp, lokasiobat_id, lokasiobat_nama, rakobat_id, rakobat_nama, rakobat_label, nobatch, tglkadaluarsa', 'safe', 'on'=>'search'),
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
                    //'jenisobatalkes' => array(self::BELONGS_TO, 'JenisobatalkesM', 'jenisobatalkes_id'),
                    //'satuanbesar' => array(self::BELONGS_TO, 'SatuanbesarM', 'satuanbesar_id'),
                   // 'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'jenisobatalkes_id' => 'Jenis Obat Alkes',
			'jenisobatalkes_kode' => 'Kode Jenis Obat Alkes',
			'jenisobatalkes_nama' => 'Jenis Obat Alkes',
			'jenisobatalkes_farmasi' => 'Jenis Obat Alkes Farmasi',
			'obatalkes_id' => 'Obat Alkes',
			'obatalkes_barcode' => 'Obat Alkes Barcode',
			'obatalkes_kode' => 'Kode Obat Alkes',
			'obatalkes_nama' => 'Nama Obat Alkes',
			'obatalkes_namalain' => 'Obat Alkes Namalain',
			'obatalkes_golongan' => 'Golongan',
			'obatalkes_kategori' => 'Kategori',
			'obatalkes_kadarobat' => 'Obat Alkes Kadarobat',
			'asalbarang_id' => 'Asal Barang',
			'asalbarang_nama' => 'Nama Asal Barang',
			'satuankecil_id' => 'Satuan Kecil',
			'satuankecil_nama' => 'Satuan Kecil',
			'hpp_max' => 'HPP (Maks)',
			'hpp_min' => 'HPP (Min)',
			'hpp_avg' => 'HPP (Rata-rata)',
			'hargajual_max' => 'Harga Jual (Maks)',
			'hargajual_min' => 'Harga Jual (Min)',
			'hargajual_avg' => 'Harga Jual (Rata-rata)',
			'qtystok' => 'Jumlah Stok',
			'hargajual' => 'Harga Jual',
			'hpp' => 'HPP',
			'lokasiobat_id' => 'Lokasi Obat',
			'lokasiobat_nama' => 'Lokasi Obat',
			'rakobat_id' => 'Rak Obat',
			'rakobat_nama' => 'Nama Rak Obat',
			'rakobat_label' => 'Label Rak Obat',
			'nobatch' => 'No. Batch',
			'tglkadaluarsa' => 'Tanggal Kedaluwarsa',
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

		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('jenisobatalkes_farmasi',$this->jenisobatalkes_farmasi);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->asalbarang_id)){
			$criteria->addCondition('asalbarang_id = '.$this->asalbarang_id);
		}
		$criteria->compare('LOWER(asalbarang_nama)',strtolower($this->asalbarang_nama),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('hpp_max',$this->hpp_max);
		$criteria->compare('hpp_min',$this->hpp_min);
		$criteria->compare('hpp_avg',$this->hpp_avg);
		$criteria->compare('hargajual_max',$this->hargajual_max);
		$criteria->compare('hargajual_min',$this->hargajual_min);
		$criteria->compare('hargajual_avg',$this->hargajual_avg);
		$criteria->compare('qtystok',$this->qtystok);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('hpp',$this->hpp);
		if(!empty($this->lokasiobat_id)){
			$criteria->addCondition('lokasiobat_id = '.$this->lokasiobat_id);
		}
		$criteria->compare('LOWER(lokasiobat_nama)',strtolower($this->lokasiobat_nama),true);
		if(!empty($this->rakobat_id)){
			$criteria->addCondition('rakobat_id = '.$this->rakobat_id);
		}
		$criteria->compare('LOWER(rakobat_nama)',strtolower($this->rakobat_nama),true);
		$criteria->compare('LOWER(rakobat_label)',strtolower($this->rakobat_label),true);
		$criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);

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
		
		public function getAllTglKadaluarsa($obatalkes_id, $ruangan_id=''){
			$data = array();
            $criteria = new CDbCriteria();            
            $criteria->select = " tglkadaluarsa ";
			$criteria->addCondition(" obatalkes_id = ".$obatalkes_id." ");
			if (!empty($ruangan_id)){
				$criteria->addCondition(" ruangan_id = ".$ruangan_id." ");
			}
			$criteria->group = " tglkadaluarsa ";
			$criteria->order = " tglkadaluarsa DESC ";
            
            $models=self::model()->findAll($criteria);
            if(count((array)$models) > 0){
                foreach($models as $model)
                    // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                    $data[$model->tglkadaluarsa]= MyFormatter::formatDateTimeForUser($model->tglkadaluarsa);
            }else{
                $data[""] = array();
            }
            
            return $data;
		}
       
    public function getJenisobatalkesItems()
        {
            return JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC");
        }            
                
}