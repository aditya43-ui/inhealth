<?php

/**
 * This is the model class for table "informasirenkebbarang_v".
 *
 * The followings are the available columns in table 'informasirenkebbarang_v':
 * @property integer $renkebbarang_id
 * @property string $renkebbarang_tgl
 * @property integer $ro_barang_bulan
 * @property string $barang_nama
 * @property string $satuanbarangdet
 * @property integer $jmlpermintaanbarangdet
 * @property double $harga_barangdet
 * @property integer $stokakhir_barangdet
 * @property integer $minstok_barangdet
 * @property integer $makstok_barangdet
 * @property integer $pegmengetahui_id
 * @property integer $pegmenyetujui_id
 * @property string $renkebbarang_no
 */
class InformasirenkebbarangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasirenkebbarangV the static model class
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
		return 'informasirenkebbarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('renkebbarang_id, ro_barang_bulan, jmlpermintaanbarangdet, stokakhir_barangdet, minstok_barangdet, makstok_barangdet, pegmengetahui_id, pegmenyetujui_id, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('harga_barangdet', 'numerical'),
			array('barang_nama', 'length', 'max'=>100),
			array('satuanbarangdet, renkebbarang_no, sumberdana_nama', 'length', 'max'=>50),
			array('renkebbarang_tgl, sumberdana_id, sumberdana_nama', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('renkebbarang_id, renkebbarang_tgl, ro_barang_bulan, barang_nama, satuanbarangdet, jmlpermintaanbarangdet, harga_barangdet, stokakhir_barangdet, minstok_barangdet, makstok_barangdet, pegmengetahui_id, pegmenyetujui_id, renkebbarang_no, tglmenyetujui, sumberdana_id, sumberdana_nama', 'safe', 'on'=>'search'),
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
			'pegawaimenyetujui'=>array(self::BELONGS_TO, 'PegawaiM', 'pegmenyetujui_id'),
			'pegawaimengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'renkebbarang_id' => 'Renkebbarang',
			'renkebbarang_tgl' => 'Tanggal Rencana Kebutuhan Barang',
			'ro_barang_bulan' => 'Recomended Order (RO)',
			'barang_nama' => 'Barang Nama',
			'satuanbarangdet' => 'Satuanbarangdet',
			'jmlpermintaanbarangdet' => 'Jmlpermintaanbarangdet',
			'harga_barangdet' => 'Harga Barangdet',
			'stokakhir_barangdet' => 'Stokakhir Barangdet',
			'minstok_barangdet' => 'Minstok Barangdet',
			'makstok_barangdet' => 'Makstok Barangdet',
			'pegmengetahui_id' => 'Pegmengetahui',
			'pegmenyetujui_id' => 'Pegmenyetujui',
			'renkebbarang_no' => 'No. Rencana',
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

		if(!empty($this->renkebbarang_id)){
			$criteria->addCondition('renkebbarang_id = '.$this->renkebbarang_id);
		}
		$criteria->compare('LOWER(renkebbarang_tgl)',strtolower($this->renkebbarang_tgl),true);
		if(!empty($this->ro_barang_bulan)){
			$criteria->addCondition('ro_barang_bulan = '.$this->ro_barang_bulan);
		}
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
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
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegmenyetujui_id)){
			$criteria->addCondition('pegmenyetujui_id = '.$this->pegmenyetujui_id);
		}
		$criteria->compare('LOWER(renkebbarang_no)',strtolower($this->renkebbarang_no),true);

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