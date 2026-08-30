<?php

/**
 * This is the model class for table "tariftindakanperdaruangan_v".
 *
 * The followings are the available columns in table 'tariftindakanperdaruangan_v':
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
 * @property boolean $daftartindakan_karcis
 * @property boolean $daftartindakan_visite
 * @property boolean $daftartindakan_konsul
 * @property boolean $daftartindakan_akomodasi
 */
class TariftindakanperdaruanganV extends CActiveRecord
{    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
    
         public $menudiet_nama, $menudiet_namalain, $ukuranrumahtangga;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tariftindakanperdaruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kategoritindakan_id, kelompoktindakan_id, perdatarif_id, jenistarif_id, tariftindakan_id, komponentarif_id, persendiskon_tind, persencyto_tind, jeniskelas_id, kelaspelayanan_id, daftartindakan_id, ruangan_id, instalasi_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('harga_tariftindakan, hargadiskon_tind, hargacyto_tind, totaltarifakhir_cyto', 'numerical'),
			array('kategoritindakan_nama, daftartindakan_katakunci, ditetapkanoleh, tempatditetapkan', 'length', 'max'=>30),
			array('kelompoktindakan_nama, kelaspelayanan_nama, kelaspelayanan_namalainnya, ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('daftartindakan_kode, noperda', 'length', 'max'=>20),
			array('daftartindakan_nama, daftartindakan_namalainnya, perdanama_sk', 'length', 'max'=>200),
			array('jenistarif_nama, komponentarif_nama, jeniskelas_nama', 'length', 'max'=>25),
			array('tglperda, perdatentang, daftartindakan_karcis, daftartindakan_visite, daftartindakan_konsul, daftartindakan_akomodasi, komponenunit_id, jeniswaktukerja', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kategoritindakan_id, kategoritindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, daftartindakan_kode, daftartindakan_nama, daftartindakan_namalainnya, daftartindakan_katakunci, perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, jenistarif_id, jenistarif_nama, tariftindakan_id, komponentarif_id, komponentarif_nama, harga_tariftindakan, persendiskon_tind, hargadiskon_tind, persencyto_tind, jeniskelas_id, jeniskelas_nama, kelaspelayanan_id, kelaspelayanan_nama, kelaspelayanan_namalainnya, daftartindakan_id, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, daftartindakan_karcis, daftartindakan_visite, daftartindakan_konsul, daftartindakan_akomodasi, penjamin_id, komponenunit_id, hargacyto_tind, totaltarifakhir_cyto, jeniswaktukerja', 'safe', 'on'=>'search'),
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
                    'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
                    'kategoritindakan' => array(self::BELONGS_TO, 'KategoritindakanM', 'kategoritindakan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'carabayar_nama'=> 'Jenis Penjamin',
			'penjamin_nama'=> 'Penjamin',
			'kategoritindakan_id' => 'Kategori Tindakan',
			'kategoritindakan_nama' => 'Kategori Tindakan',
			'kelompoktindakan_id' => 'Kelompok Tindakan',
			'kelompoktindakan_nama' => 'Kelompok Tindakan',
			'daftartindakan_kode' => 'Kode Tindakan',
			'daftartindakan_nama' => 'Uraian Tindakan',
			'daftartindakan_namalainnya' => 'Nama Lain Daftar Tindakan',
			'daftartindakan_katakunci' => 'Kata Kunci Daftar Tindakan',
			'perdatarif_id' => 'Tarif Perda',
			'perdanama_sk' => 'Nama Perda',
			'noperda' => 'No. Perda',
			'tglperda' => 'Tanggal Perda',
			'perdatentang' => 'Perda Tentang',
			'ditetapkanoleh' => 'Ditetapkan Oleh',
			'tempatditetapkan' => 'Tempat Ditetapkan',
			'jenistarif_id' => 'Jenis Tarif',
			'jenistarif_nama' => 'Jenis Tarif',
			'tariftindakan_id' => 'Nominal Tarif',
			'komponentarif_id' => 'Komponen Tarif',
			'komponentarif_nama' => 'Nama Komponen Tarif',
			'harga_tariftindakan' => 'Harga Nominal Tarif',
			'persendiskon_tind' => 'Keringanan (%)',
			'hargadiskon_tind' => 'Harga Keringanan Tindakan',
			'persencyto_tind' => 'Cyto (%)',
			'jeniskelas_id' => 'Jenis Kelas',
			'jeniskelas_nama' => 'Nama Jenis Kelas',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'kelaspelayanan_namalainnya' => 'Nama Lain Kelas Pelayanan',
			'daftartindakan_id' => 'Daftar Tindakan',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'daftartindakan_karcis' => 'Karcis Daftar Tindakan',
			'daftartindakan_visite' => 'Visite Daftar Tindakan',
			'daftartindakan_konsul' => 'Konsul Daftar Tindakan',
			'daftartindakan_akomodasi' => 'Daftar Tindakan Akomodasi',
                        'komponenunit_id' => 'Komponen Unit',
                        'komponenunit_nama' => 'Komponen Unit',
			'kegiatanoperasi_id' => 'Nama Kegiatan Operasi',
			'operasi_id' => 'Nama Operasi',
                        'menudiet_nama' => 'Nama Menu Diet',
                        'menudiet_namalain' => 'Nama Lain Menu Diet',
                        'ukuranrumahtangga' => 'Ukuran Rumah Tangga',
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
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_id),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('daftartindakan_akomodasi',$this->daftartindakan_akomodasi);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchTindakan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = ' kelaspelayanan_id, daftartindakan_id, kategoritindakan_nama, daftartindakan_kode,
		daftartindakan_nama, kelaspelayanan_nama,harga_tariftindakan ';
		$criteria->group = $criteria->select;

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
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_id),true);
		$criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('daftartindakan_akomodasi',$this->daftartindakan_akomodasi);

		$criteria->order = 'daftartindakan_nama';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('daftartindakan_akomodasi',$this->daftartindakan_akomodasi);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getInstalasiItems()
        {
            return InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_nama');
        }
        
        public function getRuanganItems()
        {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE AND instalasi_id='.$this->instalasi_id.'  ORDER BY ruangan_nama');
        }
        
     
        public function getKelasPelayananItems()
		{
			return KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC");
		} 
                
        public function getKategoritindakanItems()
		{
			return KategoritindakanM::model()->findAll("kategoritindakan_aktif = TRUE ORDER BY kategoritindakan_nama ASC");
		}     
        /**
         * menampilkan kategori tindakan
         */
        public function getKategoriTarifTindakan(){
            $criteria = new CDbCriteria();
            $criteria->group = "kategoritindakan_id, kategoritindakan_nama";
            $criteria->select = $criteria->group;
            $criteria->addCondition('kategoritindakan_id is not null');
            $criteria->order = 'kategoritindakan_nama';
            $criteria->limit = 50;
            return $this->model()->findAll($criteria);
        }
        /**
         * menampilkan kelas pelayanan
         */
        public function getKelasPelayananTarifTindakan(){
            $criteria = new CDbCriteria();
            $criteria->group = "kelaspelayanan_id, kelaspelayanan_nama";
            $criteria->select = $criteria->group;
            $criteria->addCondition('kelaspelayanan_id is not null');
            $criteria->order = 'kelaspelayanan_nama';
            $criteria->limit = 50;
            return $this->model()->findAll($criteria);
        }
        
        public function getKelompokTindakanItems()
        {
            return KelompoktindakanM::model()->findAll("kelompoktindakan_aktif = TRUE ORDER BY kelompoktindakan_nama ASC");
        }
        
        public function getKomponenUnitItems()
        {
            return KomponenunitM::model()->findAll("komponenunit_aktif = TRUE ORDER BY komponenunit_nama ASC");
        }
        
       
}