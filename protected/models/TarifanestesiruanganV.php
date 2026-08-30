<?php

/**
 * This is the model class for table "tarifanestesiruangan_v".
 *
 * The followings are the available columns in table 'tarifanestesiruangan_v':
 * @property integer $jenisanastesi_id
 * @property string $jenisanastesi_nama
 * @property integer $anastesi_id
 * @property string $anastesi_nama
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property integer $komponenunit_id
 * @property string $komponenunit_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $tindakanmedis_nama
 * @property string $daftartindakan_katakunci
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property double $hargaanestesi
 * @property integer $persencyto_tind
 */
class TarifanestesiruanganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarifanestesiruanganV the static model class
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
		return 'tarifanestesiruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisanastesi_id, anastesi_id, kategoritindakan_id, kelompoktindakan_id, komponenunit_id, daftartindakan_id, instalasi_id, ruangan_id, kelaspelayanan_id, carabayar_id, penjamin_id, jenistarif_id, perdatarif_id, persencyto_tind', 'numerical', 'integerOnly'=>true),
			array('hargaanestesi', 'numerical'),
			array('jenisanastesi_nama, anastesi_nama, kelompoktindakan_nama, instalasi_nama, ruangan_nama, kelaspelayanan_nama, carabayar_nama, penjamin_nama', 'length', 'max'=>50),
			array('kategoritindakan_nama', 'length', 'max'=>150),
			array('komponenunit_nama, daftartindakan_katakunci, ditetapkanoleh, tempatditetapkan', 'length', 'max'=>30),
			array('daftartindakan_kode, noperda', 'length', 'max'=>20),
			array('daftartindakan_nama, tindakanmedis_nama, perdanama_sk', 'length', 'max'=>200),
			array('jenistarif_nama', 'length', 'max'=>25),
			array('tglperda, perdatentang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisanastesi_id, jenisanastesi_nama, anastesi_id, anastesi_nama, kategoritindakan_id, kategoritindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, komponenunit_id, komponenunit_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, tindakanmedis_nama, daftartindakan_katakunci, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, jenistarif_id, jenistarif_nama, perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, hargaanestesi, persencyto_tind', 'safe', 'on'=>'search'),
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
			'jenisanastesi_id' => 'Jenis Anestesi',
			'jenisanastesi_nama' => 'Jenis Anestesi',
			'anastesi_id' => 'Anastesi',
			'anastesi_nama' => 'Anastesi',
			'kategoritindakan_id' => 'Kategori Tindakan',
			'kategoritindakan_nama' => 'Kategori Tindakan',
			'kelompoktindakan_id' => 'Kelompok Tindakan',
			'kelompoktindakan_nama' => 'Kelompok Tindakan',
			'komponenunit_id' => 'Komponen Unit',
			'komponenunit_nama' => 'Komponen Unit',
			'daftartindakan_id' => 'Daftar Tindakan',
			'daftartindakan_kode' => 'Kode Daftar Tindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'tindakanmedis_nama' => 'Uraian Tindakan Medis',
			'daftartindakan_katakunci' => 'Kata Kunci Daftar Tindakan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'jenistarif_id' => 'Jenis Tarif',
			'jenistarif_nama' => 'Jenis Tarif',
			'perdatarif_id' => 'Perda Tarif',
			'perdanama_sk' => 'SK Perda',
			'noperda' => 'No. Perda',
			'tglperda' => 'Tgl. Perda',
			'perdatentang' => 'Tentang Perda',
			'ditetapkanoleh' => 'Ditetapkan Oleh',
			'tempatditetapkan' => 'Tempat Ditetapkan',
			'hargaanestesi' => 'Harga Anestesi',
			'persencyto_tind' => 'Cyto Tindakan (%)',
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

		if(!empty($this->jenisanastesi_id)){
			$criteria->addCondition('jenisanastesi_id = '.$this->jenisanastesi_id);
		}
		$criteria->compare('LOWER(jenisanastesi_nama)',strtolower($this->jenisanastesi_nama),true);
		if(!empty($this->anastesi_id)){
			$criteria->addCondition('anastesi_id = '.$this->anastesi_id);
		}
		$criteria->compare('LOWER(anastesi_nama)',strtolower($this->anastesi_nama),true);
		if(!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id = '.$this->kategoritindakan_id);
		}
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition('kelompoktindakan_id = '.$this->kelompoktindakan_id);
		}
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		if(!empty($this->komponenunit_id)){
			$criteria->addCondition('komponenunit_id = '.$this->komponenunit_id);
		}
		$criteria->compare('LOWER(komponenunit_nama)',strtolower($this->komponenunit_nama),true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		if(!empty($this->perdatarif_id)){
			$criteria->addCondition('perdatarif_id = '.$this->perdatarif_id);
		}
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		$criteria->compare('hargaanestesi',$this->hargaanestesi);
		if(!empty($this->persencyto_tind)){
			$criteria->addCondition('persencyto_tind = '.$this->persencyto_tind);
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