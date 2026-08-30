<?php

/**
 * This is the model class for table "tariftindakan_m".
 *
 * The followings are the available columns in table 'tariftindakan_m':
 * @property integer $tariftindakan_id
 * @property integer $jenistarif_id
 * @property integer $daftartindakan_id
 * @property integer $komponentarif_id
 * @property integer $perdatarif_id
 * @property double $harga_tariftindakan
 * @property integer $persendiskon_tind
 * @property double $hargadiskon_tind
 * @property integer $persencyto_tind
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class TariftindakanM extends CActiveRecord
{
    public $jenistarif_nama,$jeniswaktukerja;
    public $komponentarif_nama;
    public $kelaspelayanan_nama;
    public $daftartindakan_kode;
    public $daftartindakan_nama;
    public $tindakanmedis_nama;
	public $perdanama_sk;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanM the static model class
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
		return 'tariftindakan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('harga_tariftindakan, persendiskon_tind, hargadiskon_tind, persencyto_tind,kelaspelayanan_id, jenistarif_id', 'required'),
			array('jenistarif_id, daftartindakan_id, komponentarif_id, perdatarif_id, persencyto_tind,create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
            array('harga_tariftindakan, hargadiskon_tind, persendiskon_tind, total_tarifakhir, hargacyto_tind, totaltarifakhir_cyto', 'numerical'),
            array('kelaspelayanan_id, jeniswaktukerja', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tariftindakan_id, jenistarif_id, kelaspelayanan_nama, daftartindakan_nama, daftartindakan_kode, tindakanmedis_nama, daftartindakan_id, komponentarif_id, perdatarif_id, harga_tariftindakan, persendiskon_tind, hargadiskon_tind, persencyto_tind,kelaspelayanan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, total_tarifakhir, hargacyto_tind, totaltarifakhir_cyto', 'safe', 'on'=>'search'),
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
                                    'perdatarif' => array(self::BELONGS_TO, 'PerdatarifM', 'perdatarif_id'),
                                    'jenistarif' => array(self::BELONGS_TO, 'JenistarifM', 'jenistarif_id'),
                                    'komponentarif' => array(self::BELONGS_TO, 'KomponentarifM', 'komponentarif_id'),
                                    'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
                                    'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
                                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tariftindakan_id' => 'ID',
			'jenistarif_id' => 'Jenis Tarif',
			'daftartindakan_id' => 'Daftar Tindakan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'komponentarif_id' => 'Komponen Tarif',
			'perdatarif_id' => 'SK Tarif',
			'harga_tariftindakan' => 'Harga Tindakan',
			'persendiskon_tind' => 'Persen Keringanan',
			'hargadiskon_tind' => 'Harga Keringanan',
			'persencyto_tind' => 'Persen Cyto',
            'jeniswaktukerja' => 'Jenis Waktu Kerja',
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

		$criteria->compare('tariftindakan_id',$this->tariftindakan_id);
		$criteria->compare('t.jenistarif_id',$this->jenistarif_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('t.komponentarif_id',$this->komponentarif_id);
		$criteria->compare('t.perdatarif_id',$this->perdatarif_id);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
		
        $criteria->with=array('perdatarif','jenistarif','komponentarif','daftartindakan','kelaspelayanan');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

			$criteria=new CDbCriteria;
			$criteria->compare('tariftindakan_id',$this->tariftindakan_id);
			$criteria->compare('jenistarif_id',$this->jenistarif_id);
			$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
			$criteria->compare('komponentarif_id',$this->komponentarif_id);
			$criteria->compare('perdatarif_id',$this->perdatarif_id);
			$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
			$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
			$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
			$criteria->compare('persencyto_tind',$this->persencyto_tind);
            $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
            $criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
        }
        
        public function searchTarifDiet()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
//                $criteria->join = 'LEFT JOIN daftartindakan_m on daftartindakan_m.daftartindakan_id = t.daftartindakan_id
//                                   LEFT JOIN kategoritindakan_m on kategoritindakan_m.kategoritindakan_id = daftartindakan_m.kategoritindakan_id';
                //$criteria->with=array('daftartindakan');
                $criteria->join = 'LEFT JOIN daftartindakan_m daftartindakan on daftartindakan.daftartindakan_id = t.daftartindakan_id';
		$criteria->compare('t.tariftindakan_id',$this->tariftindakan_id);
		$criteria->compare('t.jenistarif_id',$this->jenistarif_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('t.komponentarif_id',$this->komponentarif_id);
		$criteria->compare('t.perdatarif_id',$this->perdatarif_id);
		$criteria->compare('t.harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('t.persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('t.hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('t.persencyto_tind',$this->persencyto_tind);
                $criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
                // $criteria->compare('LOWER(kelaspelayanan.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
                $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
                $criteria->compare('LOWER(daftartindakan.tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
                $criteria->compare('LOWER(daftartindakan.daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
                $criteria->compare('daftartindakan.kelompoktindakan_id',Params::DEFAULT_KELOMPOKTINDAKAN_GIZI);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                    
                        'sort' => array(
                            'attributes' => array(
                                'daftartindakan_nama' => array(
                                    'asc' => 'daftartindakan.daftartindakan_nama ASC',
                                    'desc' => 'daftartindakan.daftartindakan_nama DESC',
                                ),
                                 'tindakanmedis_nama' => array(
                                    'asc' => 'daftartindakan.tindakanmedis_nama ASC',
                                    'desc' => 'daftartindakan.tindakanmedis_nama DESC',
                                ), /*
                                 'kelaspelayanan_nama' => array(
                                    'asc' => 'kelaspelayanan.kelaspelayanan_nama ASC',
                                    'desc' => 'kelaspelayanan.kelaspelayanan_nama DESC',
                                ), */
                                '*',
                            )
                        )
                ));
        }
        
        public function searchTarifDiet2() {
            $provider = $this->searchTarifDiet();
            
            $provider->criteria->group = 't.daftartindakan_id';
            $provider->criteria->select = $provider->criteria->group;
            $provider->sort = false;
            
            return $provider;
        }
        
        /**
        * Mengambil daftar semua Jenis Tarif
        * @return CActiveDataProvider 
        */
        public function getJenisTarifItems()
        {
            return JenistarifM::model()->findAll('jenistarif_aktif=true ORDER BY jenistarif_nama');
        }
        
        /**
        * Mengambil daftar semua Jenis Tarif
        * @return CActiveDataProvider 
        */
        public function getDaftarTindakanItems()
        {
            return DaftartindakanM::model()->findAll('daftartindakan_aktif=true ORDER BY daftartindakan_nama');
        }
        
        /**
        * Mengambil daftar semua Perda Tarif
        * @return CActiveDataProvider 
        */
        public function getPerdaTarifItems()
        {
            return PerdatarifM::model()->findAll('perda_aktif=true ORDER BY perdanama_sk');
        }
        
        /**
        * Mengambil daftar semua Kategori Tindakan
        * @return CActiveDataProvider 
        */
        public function getKategoriTindakanItems()
        {
            return KategoritindakanM::model()->findAll('kategoritindakan_aktif=true ORDER BY kategoritindakan_nama');
        }
        
        /**
        * Mengambil daftar semua KelasPelayanan
        * @return CActiveDataProvider 
        */
        public function getKelasPelayananItems()
        {
            return KelaspelayananM::model()->findAll('kelaspelayanan_aktif=true ORDER BY kelaspelayanan_nama');
        }
        
        /**
        * Mengambil daftar semua Komponen Tarif
        * @return CActiveDataProvider 
        */
        public function getKomponenTarifItems()
        {
            return KomponentarifM::model()->findAll('komponentarif_aktif=true ORDER BY komponentarif_nama');
        }
        
        /**
         * Mencari tariftindakan_m berdasarkan atribut-atribut yang bersangkutan
         * @param type $jenistarif_id integer
         * @param type $daftartindakan_id integer
         * @param type $komponentarif_id integer
         */
        public function findTarifTindakan($jenistarif_id = '',$kelaspelayanan_id = '' , $daftartindakan_id = '',$komponentarif_id = '',$status = '')
        {
            if(!empty ($jenistarif_id) && !empty ($kelaspelayanan_id)  && !empty ($daftartindakan_id) && !empty ($komponentarif_id) && $status == "ALL")
            {
                 return $this->model()->findAllByAttributes(array('jenistarif_id'=>$jenistarif_id,'daftartindakan_id'=>$daftartindakan_id,'komponentarif_id'=>$komponentarif_id,'kelaspelayanan_id'=>$kelaspelayanan_id));
            }
            
            if(!empty ($jenistarif_id) && !empty ($kelaspelayanan_id)  && !empty ($daftartindakan_id) && !empty ($komponentarif_id) && $status == "BY")
            {
                 return $this->model()->findByAttributes(array('jenistarif_id'=>$jenistarif_id,'daftartindakan_id'=>$daftartindakan_id,'komponentarif_id'=>$komponentarif_id,'kelaspelayanan_id'=>$kelaspelayanan_id));
            }
            
            if(!empty ($komponentarif_id) && !empty ($kelaspelayanan_id)  && !empty ($daftartindakan_id) && empty ($jenistarif_id) && $status == "BY")
            {
                 return $this->model()->findByAttributes(array('daftartindakan_id'=>$daftartindakan_id,'komponentarif_id'=>$komponentarif_id,'kelaspelayanan_id'=>$kelaspelayanan_id));
            }
            
            if(empty ($komponentarif_id) && !empty ($kelaspelayanan_id)  && !empty ($daftartindakan_id) && !empty ($jenistarif_id) && $status == "ALL")
            {
                 return $this->model()->findAllByAttributes(array('daftartindakan_id'=>$daftartindakan_id,'jenistarif_id'=>$jenistarif_id,'kelaspelayanan_id'=>$kelaspelayanan_id));
                 //,'kelaspelayanan_id != :kelaspelayanan_id',array(':kelaspelayanan_id'=>$kelaspelayanan_id)
            }
        }
}