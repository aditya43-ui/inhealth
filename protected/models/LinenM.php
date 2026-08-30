<?php

/**
 * This is the model class for table "linen_m".
 *
 * The followings are the available columns in table 'linen_m':
 * @property integer $linen_id
 * @property integer $jenislinen_id
 * @property integer $ruangan_id
 * @property integer $rakpenyimpanan_id
 * @property integer $bahanlinen_id
 * @property integer $barang_id
 * @property string $kodelinen
 * @property string $tglregisterlinen
 * @property string $noregisterlinen
 * @property string $namalinen
 * @property string $namalainnya
 * @property string $merklinen
 * @property integer $beratlinen
 * @property string $warna
 * @property string $tahunbeli
 * @property string $gambarlinen
 * @property integer $jmlcucilinen
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $linen_aktif
 * @property string $satuanlinen
 */
class LinenM extends CActiveRecord
{
        public $barang_nama;
        public $bahanlinen_nama;
        public $tempPhoto;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LinenM the static model class
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
		return 'linen_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenislinen_id, ruangan_id, rakpenyimpanan_id, bahanlinen_id, barang_id, kodelinen, tglregisterlinen, noregisterlinen, namalinen, namalainnya, jmlcucilinen, create_time, create_loginpemakai_id, create_ruangan, linen_aktif', 'required'),
			array('jenislinen_id, ruangan_id, rakpenyimpanan_id, bahanlinen_id, barang_id, beratlinen, jmlcucilinen, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kodelinen, noregisterlinen, merklinen, satuanlinen', 'length', 'max'=>50),
			array('namalinen, namalainnya', 'length', 'max'=>200),
			array('warna', 'length', 'max'=>20),
			array('tahunbeli', 'length', 'max'=>6),
			array('tempphoto, gambarlinen, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('linen_id, jenislinen_id, ruangan_id, rakpenyimpanan_id, bahanlinen_id, barang_id, kodelinen, tglregisterlinen, noregisterlinen, namalinen, namalainnya, merklinen, beratlinen, warna, tahunbeli, gambarlinen, jmlcucilinen, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, linen_aktif, satuanlinen', 'safe', 'on'=>'search'),
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
            'bahan' => array(self::BELONGS_TO, 'BahanlinenM', 'bahanlinen_id'),
            'jenis' => array(self::BELONGS_TO, 'JenislinenM', 'jenislinen_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'rak' => array(self::BELONGS_TO, 'RakpenyimpananM', 'rakpenyimpanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'linen_id' => 'Linen',
			'jenislinen_id' => 'Jenis',
			'ruangan_id' => 'Ruangan',
			'rakpenyimpanan_id' => 'Rak Penyimpanan',
			'bahanlinen_id' => 'Bahan',
			'barang_id' => 'Linen Nama',
			'kodelinen' => 'Kode',
			'tglregisterlinen' => 'Tanggal Register',
			'noregisterlinen' => 'No. Register',
			'namalinen' => 'Nama',
			'namalainnya' => 'Nama Lainnya',
			'merklinen' => 'Merk',
			'beratlinen' => 'Berat',
			'warna' => 'Warna',
			'tahunbeli' => 'Tahun Beli',
			'gambarlinen' => 'Gambar',
			'jmlcucilinen' => 'Jumlah Cuci',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'linen_aktif' => 'Linen Aktif',
			'satuanlinen' => 'Satuan',
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
                $criteria->with = array('barang');
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->jenislinen_id)){
			$criteria->addCondition('jenislinen_id = '.$this->jenislinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->rakpenyimpanan_id)){
			$criteria->addCondition('rakpenyimpanan_id = '.$this->rakpenyimpanan_id);
		}
		if(!empty($this->bahanlinen_id)){
			$criteria->addCondition('bahanlinen_id = '.$this->bahanlinen_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(kodelinen)',strtolower($this->kodelinen),true);
		$criteria->compare('LOWER(tglregisterlinen)',strtolower($this->tglregisterlinen),true);
		$criteria->compare('LOWER(noregisterlinen)',strtolower($this->noregisterlinen),true);
		$criteria->compare('LOWER(namalinen)',strtolower($this->namalinen),true);
		$criteria->compare('LOWER(namalainnya)',strtolower($this->namalainnya),true);
		$criteria->compare('LOWER(merklinen)',strtolower($this->merklinen),true);
		if(!empty($this->beratlinen)){
			$criteria->addCondition('beratlinen = '.$this->beratlinen);
		}
		$criteria->compare('LOWER(warna)',strtolower($this->warna),true);
		$criteria->compare('LOWER(tahunbeli)',strtolower($this->tahunbeli),true);
		$criteria->compare('LOWER(gambarlinen)',strtolower($this->gambarlinen),true);
		if(!empty($this->jmlcucilinen)){
			$criteria->addCondition('jmlcucilinen = '.$this->jmlcucilinen);
		}
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
		$criteria->compare('linen_aktif',isset($this->linen_aktif)?$this->linen_aktif:true);
		$criteria->compare('LOWER(satuanlinen)',strtolower($this->satuanlinen),true);
                $criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);

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
            //$criteria->join = " left join barang_m b on t.barang_id = b.barang_id";
           // $criteria->compare('lower(b.barang_nama)', strtolower($this->barang_nama), true);
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