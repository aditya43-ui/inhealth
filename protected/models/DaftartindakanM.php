<?php

/** 
 * This is the model class for table "daftartindakan_m".
 *
 * The followings are the available columns in table 'daftartindakan_m':
 * @property integer $daftartindakan_id
 * @property integer $komponenunit_id
 * @property integer $kategoritindakan_id
 * @property integer $kelompoktindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $tindakanmedis_nama
 * @property string $daftartindakan_namalainnya
 * @property string $daftartindakan_katakunci
 * @property boolean $daftartindakan_karcis
 * @property boolean $daftartindakan_visite
 * @property boolean $daftartindakan_konsul
 * @property boolean $daftartindakan_akomodasi
 * @property boolean $daftartindakan_aktif
 */
class DaftartindakanM extends CActiveRecord
{
        // public $komponenunit_nama;
        // public $kategoritindakan_nama;
        // public $kelompoktindakan_nama;
	public $komponenunit_id,$komponenunit_nama;
	public $kategoritindakan_id,$kategoritindakan_nama;
	public $kelompoktindakan_id,$kelompoktindakan_nama;      
	
	public $pilihTindakan;
	public $grouplayanan_id;
	public $grouplayanan_nama;
    public $ruangan_id, $default;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DaftartindakanM the static model class
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
		return 'daftartindakan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_nama, komponenunit_id, kategoritindakan_id', 'required'),
			array('komponenunit_id, kategoritindakan_id, kelompoktindakan_id, kelompoktindakanbpjs_id', 'numerical', 'integerOnly'=>true),
			array('daftartindakan_kode', 'length', 'max'=>20),
			array('daftartindakan_nama, tindakanmedis_nama, daftartindakan_namalainnya', 'length', 'max'=>200),
			array('daftartindakan_katakunci', 'length', 'max'=>30),
			array('daftartindakan_periksa, jeniskegiatan_id, daftartindakan_karcis, daftartindakan_visite, daftartindakan_konsul, daftartindakan_akomodasi, daftartindakan_aktif', 'safe'),
			array('daftartindakan_alatmedis', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('daftartindakan_id, kategoritindakan_nama, kelompoktindakan_nama, komponenunit_id, kategoritindakan_id, kelompoktindakan_nama, kelompoktindakan_id, daftartindakan_kode, daftartindakan_nama, tindakanmedis_nama, daftartindakan_namalainnya, daftartindakan_katakunci, daftartindakan_karcis, daftartindakan_visite, daftartindakan_konsul, daftartindakan_akomodasi, daftartindakan_aktif, kelompoktindakanbpjs_id', 'safe', 'on'=>'search'),
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
                    'komponenunit' => array(self::BELONGS_TO, 'KomponenunitM', 'komponenunit_id'),
                    'kelompoktindakan' => array(self::BELONGS_TO, 'KelompoktindakanM', 'kelompoktindakan_id'),
                    'kategoritindakan' => array(self::BELONGS_TO, 'KategoritindakanM', 'kategoritindakan_id'),
                    'daftartindakan' => array(self::HAS_MANY, 'TariftindakanperdatotalV', 'daftartindakan_nama'),
					//'daftartindakan' => array(self::HAS_MANY, 'TariftindakanperdatotalV', 'daftartindakan_id'),
                    'tariftindakan'=>array(self::HAS_MANY,'TariftindakanM','daftartindakan_id'),
                    'pelayananrek'=>array(self::HAS_MANY,'PelayananrekM','daftartindakan_id'),
					'jeniskegiatan'=> array(self::BELONGS_TO, 'JeniskegiatanM', 'jeniskegiatan_id'),
					'createruangan'=> array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
					'kelompoktindakanbpjs' =>array(self::BELONGS_TO, 'KelompoktindakanbpjsM', 'kelompoktindakanbpjs_id'),
					'pemeriksaanlab' =>array(self::BELONGS_TO, 'PemeriksaanlabM', 'pemeriksaanlab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'daftartindakan_id' => 'Daftar Tindakan',
			'komponenunit_id' => 'Komponen Unit',
			'kategoritindakan_id' => 'Kategori Tindakan',
			'kelompoktindakan_id' => 'Kelompok Tindakan',
                        'komponenunit_nama' => 'Komponen Unit',
			'kategoritindakan_nama' => 'Kategori Tindakan',
			'kelompoktindakan_nama' => 'Kelompok Tindakan',
			'daftartindakan_kode' => 'Kode Tindakan',
			'daftartindakan_nama' => 'Uraian Tindakan',
			'tindakanmedis_nama' => 'Uraian Tindakan Medis ',
			'daftartindakan_namalainnya' => 'Nama Lainnya',
			'daftartindakan_katakunci' => 'Kata Kunci',
			'daftartindakan_karcis' => 'Karcis',
			'daftartindakan_visite' => 'Visite',
			'daftartindakan_konsul' => 'Konsul',
			'daftartindakan_akomodasi' => 'Akomodasi',
			'daftartindakan_aktif' => 'Aktif',
                        'jeniskegiatan_id' => 'Jenis Kegiatan',
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
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('komponenunit.komponenunit_id',$this->komponenunit_id);
		$criteria->compare('kelompoktindakan.kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('kategoritindakan.kategoritindakan_id',$this->kategoritindakan_id);
		// $criteria->compare('LOWER(komponenunit_nama)',strtolower($this->komponenunit_nama),true);
		// $criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		// $criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
        $criteria->compare('LOWER(kelompoktindakan.komponenunit_nama)',strtolower($this->komponenunit_nama),true);
		$criteria->compare('daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('daftartindakan_akomodasi',$this->daftartindakan_akomodasi);
		$criteria->compare('daftartindakan_aktif',isset($this->daftartindakan_aktif)?$this->daftartindakan_aktif:true);
		//$criteria->addCondition('daftartindakan_aktif is true');
		$criteria->with=array('komponenunit','kelompoktindakan','kategoritindakan');
		$criteria->order = 'daftartindakan_kode asc';
		$dataprovider = new CActiveDataProvider(get_class($this));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('komponenunit_id',$this->komponenunit_id);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('daftartindakan_akomodasi',$this->daftartindakan_akomodasi);
//		$criteria->compare('daftartindakan_aktif',$this->daftartindakan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                         'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            $this->daftartindakan_nama = ucwords(strtolower($this->daftartindakan_nama));
            $this->daftartindakan_namalainnya = strtoupper($this->daftartindakan_namalainnya);
            $this->daftartindakan_katakunci = strtoupper($this->daftartindakan_katakunci);

            return parent::beforeSave();
        }
        
        public function getKomponenUnitItems()
        {
            return KomponenunitM::model()->findAllByAttributes(array('komponenunit_aktif'=>true),array('order'=>'komponenunit_nama'));
        }
        
        public function getKelompokTindakanItems()
        {
            return KelompoktindakanM::model()->findAllByAttributes(array('kelompoktindakan_aktif'=>true),array('order'=>'kelompoktindakan_nama'));
        }
        
         public function getKategoriTindakanItems()
        {
            return KategoritindakanM::model()->findAllByAttributes(array('kategoritindakan_aktif'=>true),array('order'=>'kategoritindakan_nama'));
        }
         public function getDaftarTindakanItems()
        {
            return TariftindakanperdatotalV::model()->findAll(array('order'=>'daftartindakan_nama'));
        }
        
        public function getJenisKegiatanItems()
        {
            return JeniskegiatanM::model()->findAllByAttributes(array('jeniskegiatan_aktif'=>TRUE),array('order'=>'jeniskegiatan_nama'));
        }
        
        public function getDaftarTindakanNama($id)
        {
            return $this->model()->findByPk($id)->daftartindakan_nama;
        }
        
        public function getKategoriTindakanNama($id)
        {
            
            return isset($this->model()->findByPk($id)->kategoritindakan_id)?KategoritindakanM::model()->findByPk($this->model()->findByPk($id)->kategoritindakan_id)->kategoritindakan_nama:null;
        }
        public function getAllItems()
        {
            return $this->model()->findAll('daftartindakan_aktif = true order by daftartindakan_nama');
        }
		
		public function searchGrupLayananTindakan()
		{
			
			$getGrup = GrouplayanankasirM::model()->findAll();
			
			$dt = array();
			
			if (count((array)$getGrup)){
				foreach ($getGrup as $gr){
					$dt[] = $gr->daftartindakan_id;
				}
			}
			
			$cri = new CDbCriteria();
			$cri->addCondition(" daftartindakan_aktif = TRUE ");
			$cri->compare(" LOWER(daftartindakan_nama) ",strtolower($this->daftartindakan_nama),true);
			$cri->compare(" LOWER(daftartindakan_kode) ",strtolower($this->daftartindakan_kode),true);
			$cri->addNotInCondition("daftartindakan_id", $dt);
			$cri->order = " daftartindakan_nama ASC ";
					  
			return new CActiveDataProvider($this, array(
				'criteria'=>$cri,
			));
		}
        public function getKomponenUnitItemsAmbulan()
        {
            return KomponenunitM::model()->findAllByAttributes(array('komponenunit_aktif'=>true,'komponenunit_id'=>23),array('order'=>'komponenunit_nama'));
        }
        
        public function searchTindakanRuangan() {
            $prov = $this->search();
            $prov->criteria->with = null;
            $prov->criteria->select = "t.*, kategoritindakan.kategoritindakan_nama";
            $prov->criteria->join = "left join komponenunit_m komponenunit on komponenunit.komponenunit_id = t.komponenunit_id "
                    . "left join kelompoktindakan_m kelompoktindakan on kelompoktindakan.kelompoktindakan_id = t.kelompoktindakan_id "
                    . "left join kategoritindakan_m kategoritindakan on kategoritindakan.kategoritindakan_id = t.kategoritindakan_id "
                    . "join tindakanruangan_m ruangans on ruangans.daftartindakan_id = t.daftartindakan_id";
            $prov->criteria->compare('ruangans.ruangan_id', $this->ruangan_id);
            $prov->sort->defaultOrder = "daftartindakan_nama";

            return $prov;
        }
	


		public function searchTindakan()
		{
			$cri = new CDbCriteria;
			$cri = new CDbCriteria();
			$cri->addCondition(" daftartindakan_aktif = TRUE ");
			$cri->compare(" LOWER(daftartindakan_nama) ",strtolower($this->daftartindakan_nama),true);
			$cri->compare(" LOWER(daftartindakan_kode) ",strtolower($this->daftartindakan_kode),true);
			$cri->order = " daftartindakan_nama ASC ";
	
			return new CActiveDataProvider($this, array(
				'criteria'=>$cri,
				
			));
		}

		public function searchDialog2()
		{
			$criteria = new CDbCriteria;
			$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
			$criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
			$criteria->addCondition(" daftartindakan_aktif = TRUE ");
			$criteria->order = 't.daftartindakan_nama ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                  		));
						
	}
        
		public function searchDialog()
		{
			$criteria = new CDbCriteria;
			$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
			$criteria->compare('komponenunit.komponenunit_id', $this->komponenunit_id);
			$criteria->compare('kelompoktindakan.kelompoktindakan_id', $this->kelompoktindakan_id);
			$criteria->compare('kategoritindakan.kategoritindakan_id', $this->kategoritindakan_id);
			$criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
			$criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
			$criteria->compare('LOWER(tindakanmedis_nama)', strtolower($this->tindakanmedis_nama), true);
			$criteria->compare('LOWER(daftartindakan_namalainnya)', strtolower($this->daftartindakan_namalainnya), true);
			$criteria->compare('LOWER(daftartindakan_katakunci)', strtolower($this->daftartindakan_katakunci), true);
			$criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
			$criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)', strtolower($this->kelompoktindakan_nama), true);
			$criteria->compare('daftartindakan_karcis', $this->daftartindakan_karcis);
			$criteria->compare('daftartindakan_visite', $this->daftartindakan_visite);
			$criteria->compare('daftartindakan_konsul', $this->daftartindakan_konsul);
			$criteria->compare('daftartindakan_akomodasi', $this->daftartindakan_akomodasi);
			$criteria->compare('daftartindakan_aktif', isset($this->daftartindakan_aktif) ? $this->daftartindakan_aktif : true);
			$criteria->with = array('komponenunit', 'kelompoktindakan', 'kategoritindakan');
			$criteria->limit = 10;
	
			$dataprovider = new CActiveDataProvider(get_class($this));
			return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
				'pagination' => FALSE,
			));
		}
}
