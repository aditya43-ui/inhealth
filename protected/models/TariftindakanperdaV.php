<?php

/**
 * This is the model class for table "tariftindakanperda_v".
 *
 * The followings are the available columns in table 'tariftindakanperda_v':
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
 */
class TariftindakanperdaV extends CActiveRecord
{
    public $is_pilih;
    public $tipepaket_id;
    public $ruangan_id;
    public $ruangan_nama, $menudiet_id, $menudiet_nama, $jenisdiet_id, $ukuranrumahtangga;
    public $jenisdiet_nama, $menudiet_namalain, $jml_porsi, $tipediet_nama;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaV the static model class
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
		return 'tariftindakanperda_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('kategoritindakan_id, kelompoktindakan_id, perdatarif_id, jenistarif_id, tariftindakan_id, komponentarif_id, persendiskon_tind, persencyto_tind, jeniskelas_id, kelaspelayanan_id, daftartindakan_id, komponenunit_id, carabayar_id, penjamin_id', 'numerical', 'integerOnly'=>true),
            array('harga_tariftindakan, hargadiskon_tind, hargacyto_tind, totaltarifakhir_cyto', 'numerical'),
            array('kategoritindakan_nama', 'length', 'max'=>150),
            array('kelompoktindakan_nama, kelaspelayanan_nama, kelaspelayanan_namalainnya, carabayar_nama, penjamin_nama', 'length', 'max'=>50),
            array('daftartindakan_kode, noperda', 'length', 'max'=>20),
            array('daftartindakan_nama, daftartindakan_namalainnya, perdanama_sk', 'length', 'max'=>200),
            array('daftartindakan_katakunci, ditetapkanoleh, tempatditetapkan, komponenunit_nama', 'length', 'max'=>30),
            array('jenistarif_nama, komponentarif_nama, jeniskelas_nama', 'length', 'max'=>25),
            array('jeniswaktukerja, tglperda, perdatentang, daftartindakan_karcis, daftartindakan_visite, daftartindakan_konsul, daftartindakan_akomodasi, jeniswaktukerja', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('jeniswaktukerja, kategoritindakan_id, kategoritindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, daftartindakan_kode, daftartindakan_nama, daftartindakan_namalainnya, daftartindakan_katakunci, perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, jenistarif_id, jenistarif_nama, tariftindakan_id, komponentarif_id, komponentarif_nama, harga_tariftindakan, persendiskon_tind, hargadiskon_tind, persencyto_tind, jeniskelas_id, jeniskelas_nama, kelaspelayanan_id, kelaspelayanan_nama, kelaspelayanan_namalainnya, daftartindakan_id, komponenunit_id, komponenunit_nama, daftartindakan_karcis, daftartindakan_visite, daftartindakan_konsul, daftartindakan_akomodasi, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, hargacyto_tind, totaltarifakhir_cyto, jeniswaktukerja', 'safe', 'on'=>'search'),
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
			'kategoritindakan_id' => 'Kategori Tindakan',
			'kategoritindakan_nama' => 'Nama Kelompok Tindakan',
			'kelompoktindakan_id' => 'Kelompok Tindakan',
			'kelompoktindakan_nama' => 'Nama Kelompok Tindakan',
			'daftartindakan_kode' => 'Kode Daftar Tindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'daftartindakan_namalainnya' => 'Nama Lain Daftar Tindakan',
			'daftartindakan_katakunci' => 'Kata Kunci Daftar Tindakan',
			'perdatarif_id' => 'Perda Tarif',
			'perdanama_sk' => 'SK Perda Nama',
			'noperda' => 'No. Perda',
			'tglperda' => 'Tanggal Perda',
			'perdatentang' => 'Tentang Perda',
			'ditetapkanoleh' => 'Ditetapkan Oleh',
			'tempatditetapkan' => 'Tempat Ditetapkan',
			'jenistarif_id' => 'Jenis Tarif',
			'jenistarif_nama' => 'Nama Jenis Tarif',
			'tariftindakan_id' => 'Nominal Tarif',
			'komponentarif_id' => 'Komponen Tarif',
			'komponentarif_nama' => 'Nama Komponen Tarif',
			'harga_tariftindakan' => 'Harga Nominal Tarif',
			'persendiskon_tind' => 'Persen Keringanan',
			'hargadiskon_tind' => 'Harga Keringanan',
			'persencyto_tind' => 'Persen Cyto',
			'daftartindakan_id' => 'Daftar Tindakan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('tariftindakan_id',$this->tariftindakan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('jeniswaktukerja',$this->jeniswaktukerja);
		if (!empty($this->penjamin_id)){
			$criteria->addCondition(" penjamin_id = ".$this->penjamin_id." ");
		}
                $criteria->order = 'daftartindakan_id ASC';
		// $criteria->limit=10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			// 'pagination'=>false
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('tariftindakan_id',$this->tariftindakan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->order = " daftartindakan_nama ASC, kelaspelayanan_nama ASC, kategoritindakan_nama ASC, penjamin_nama ASC ";
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
		/**
		 * mengecek komponen total yang valid
		 * @return boolean
		 */
		public function getIsKomponenValid(){
			$valid = true;
			$tariftotal = 0;
			$komponentotal = 0; 
			$sql_tarif = "SELECT *
						FROM tariftindakan_m 
						WHERE daftartindakan_id = ".$this->daftartindakan_id."
						 AND kelaspelayanan_id = ".$this->kelaspelayanan_id."
						 AND jenistarif_id = ".$this->jenistarif_id."
						";
			$tarifKomponens = Yii::app()->db->createCommand($sql_tarif)->queryAll();
			if(count((array)$tarifKomponens) > 0){
				foreach($tarifKomponens AS $i => $komponen){
					if($komponen['komponentarif_id'] == Params::KOMPONENTARIF_ID_TOTAL){
						$komponentotal = $komponen['harga_tariftindakan'];
					}else{
						$tariftotal += $komponen['harga_tariftindakan'];
					}
				}
			}
			if($tariftotal != $komponentotal){
				$valid = false;
			}
			return $valid;
		}
}