<?php

/**
 * This is the model class for table "tariftindakanruangandetail_v".
 *
 * The followings are the available columns in table 'tariftindakanruangandetail_v':
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_namalainnya
 * @property string $daftartindakan_katakunci
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property integer $tariftindakan_id
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $harga_tariftindakan
 * @property integer $persendiskon_tind
 * @property double $hargadiskon_tind
 * @property integer $persencyto_tind
 * @property integer $jeniskelas_id
 * @property string $jeniskelas_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $kelaspelayanan_namalainnya
 * @property integer $daftartindakan_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 */
class TariftindakanruangandetailV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
	public $jns_periode;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanruangandetailV the static model class
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
		return 'tariftindakanruangandetail_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kategoritindakan_id, kelompoktindakan_id, perdatarif_id, jenistarif_id, tariftindakan_id, komponentarif_id, persendiskon_tind, persencyto_tind, jeniskelas_id, kelaspelayanan_id, daftartindakan_id, ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('harga_tariftindakan, hargadiskon_tind', 'numerical'),
			array('kategoritindakan_nama', 'length', 'max'=>150),
			array('kelompoktindakan_nama, kelaspelayanan_nama, kelaspelayanan_namalainnya, ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('daftartindakan_kode, noperda', 'length', 'max'=>20),
			array('daftartindakan_nama, daftartindakan_namalainnya, perdanama_sk', 'length', 'max'=>200),
			array('daftartindakan_katakunci, ditetapkanoleh, tempatditetapkan', 'length', 'max'=>30),
			array('jenistarif_nama, komponentarif_nama, jeniskelas_nama', 'length', 'max'=>25),
			array('tglperda, perdatentang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kategoritindakan_id, kategoritindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, daftartindakan_kode, daftartindakan_nama, daftartindakan_namalainnya, daftartindakan_katakunci, perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, jenistarif_id, jenistarif_nama, tariftindakan_id, komponentarif_id, komponentarif_nama, harga_tariftindakan, persendiskon_tind, hargadiskon_tind, persencyto_tind, jeniskelas_id, jeniskelas_nama, kelaspelayanan_id, kelaspelayanan_nama, kelaspelayanan_namalainnya, daftartindakan_id, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kategoritindakan_id' => 'Kategoritindakan',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'kelompoktindakan_id' => 'Kelompoktindakan',
			'kelompoktindakan_nama' => 'Kelompoktindakan Nama',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'daftartindakan_namalainnya' => 'Daftartindakan Namalainnya',
			'daftartindakan_katakunci' => 'Daftartindakan Katakunci',
			'perdatarif_id' => 'Perdatarif',
			'perdanama_sk' => 'Perdanama Sk',
			'noperda' => 'Noperda',
			'tglperda' => 'Tglperda',
			'perdatentang' => 'Perdatentang',
			'ditetapkanoleh' => 'Ditetapkanoleh',
			'tempatditetapkan' => 'Tempatditetapkan',
			'jenistarif_id' => 'Jenistarif',
			'jenistarif_nama' => 'Jenistarif Nama',
			'tariftindakan_id' => 'Tariftindakan',
			'komponentarif_id' => 'Komponentarif',
			'komponentarif_nama' => 'Komponentarif Nama',
			'harga_tariftindakan' => 'Harga Tariftindakan',
			'persendiskon_tind' => 'Persendiskon Tind',
			'hargadiskon_tind' => 'Hargadiskon Tind',
			'persencyto_tind' => 'Persencyto Tind',
			'jeniskelas_id' => 'Jeniskelas',
			'jeniskelas_nama' => 'Jeniskelas Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kelaspelayanan_namalainnya' => 'Kelaspelayanan Namalainnya',
			'daftartindakan_id' => 'Daftartindakan',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
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

		if(!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id = '.$this->kategoritindakan_id);
		}
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition('kelompoktindakan_id = '.$this->kelompoktindakan_id);
		}
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		if(!empty($this->perdatarif_id)){
			$criteria->addCondition('perdatarif_id = '.$this->perdatarif_id);
		}
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		if(!empty($this->tariftindakan_id)){
			$criteria->addCondition('tariftindakan_id = '.$this->tariftindakan_id);
		}
		if(!empty($this->komponentarif_id)){
			$criteria->addCondition('komponentarif_id = '.$this->komponentarif_id);
		}
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		if(!empty($this->persendiskon_tind)){
			$criteria->addCondition('persendiskon_tind = '.$this->persendiskon_tind);
		}
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		if(!empty($this->persencyto_tind)){
			$criteria->addCondition('persencyto_tind = '.$this->persencyto_tind);
		}
		if(!empty($this->jeniskelas_id)){
			$criteria->addCondition('jeniskelas_id = '.$this->jeniskelas_id);
		}
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);

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