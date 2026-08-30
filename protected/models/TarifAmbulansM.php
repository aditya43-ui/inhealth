<?php

/**
 * This is the model class for table "tarifambulans_m".
 *
 * The followings are the available columns in table 'tarifambulans_m':
 * @property integer $tarifambulans_id
 * @property integer $daftartindakan_id
 * @property string $tarifambulans_kode
 * @property string $kepropinsi_nama
 * @property string $kekabupaten_nama
 * @property string $kekecamatan_nama
 * @property string $kekelurahan_nama
 * @property double $jmlkilometer
 * @property double $tarifperkm
 * @property double $tarifambulans
 */
class TarifAmbulansM extends CActiveRecord
{
        public $daftartindakan_nama;
	public $kabupaten_id;
	public $kecamatan_id;
	public $propinsi_id;
	public $kelurahan_id;
	public $carabayar_id;              
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarifAmbulansM the static model class
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
		return 'tarifambulans_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, tarifambulans_kode', 'required'),
			array('daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('jmlkilometer, tarifperkm, tarifambulans', 'numerical'),
			array('tarifambulans_kode', 'length', 'max'=>20),
			array('kepropinsi_nama, kekabupaten_nama, kekecamatan_nama, kekelurahan_nama', 'length', 'max'=>100),
                        array('penjamin_id','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tarifambulans_id, daftartindakan_nama, daftartindakan_id, tarifambulans_kode, kepropinsi_nama, kekabupaten_nama, kekecamatan_nama, kekelurahan_nama, jmlkilometer, tarifperkm, tarifambulans', 'safe', 'on'=>'search'),
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
                                    'daftartindakan'=>array(self::BELONGS_TO,'DaftartindakanM','daftartindakan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tarifambulans_id' => 'ID',
			'daftartindakan_id' => 'Daftar Tindakan',
			'tarifambulans_kode' => 'Kode Tarif',
			'kepropinsi_nama' => 'Ke Propinsi',
			'kekabupaten_nama' => 'Ke Kabupaten',
			'kekecamatan_nama' => 'Ke Kecamatan',
			'kekelurahan_nama' => 'Ke Kelurahan',
			'jmlkilometer' => 'Jumlah Kilometer',
			'tarifperkm' => 'Tarif / KM',
			'tarifambulans' => 'Tarif Ambulan',
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

                $criteria->with=array('daftartindakan');
		$criteria->compare('t.tarifambulans_id',$this->tarifambulans_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(t.tarifambulans_kode)',strtolower($this->tarifambulans_kode),true);
		$criteria->compare('LOWER(t.kepropinsi_nama)',strtolower($this->kepropinsi_nama),true);
		$criteria->compare('LOWER(t.kekabupaten_nama)',strtolower($this->kekabupaten_nama),true);
		$criteria->compare('LOWER(t.kekecamatan_nama)',strtolower($this->kekecamatan_nama),true);
		$criteria->compare('LOWER(t.kekelurahan_nama)',strtolower($this->kekelurahan_nama),true);
		$criteria->compare('t.jmlkilometer',  $this->jmlkilometer);
		$criteria->compare('t.tarifperkm', str_replace('.','',$this->tarifperkm));
		$criteria->compare('t.tarifambulans', str_replace('.','',$this->tarifambulans));
                $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchTarifPrint() {
            $provider = $this->search();
            $provider->criteria->order = "tarifambulans_kode ASC, kepropinsi_nama ASC, kekabupaten_nama ASC, kekecamatan_nama ASC, kekelurahan_nama ASC";
            $provider->criteria->limit = -1;
            $provider->pagination = false;
            
            return $provider;
        }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tarifambulans_id',$this->tarifambulans_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(tarifambulans_kode)',strtolower($this->tarifambulans_kode),true);
		$criteria->compare('LOWER(kepropinsi_nama)',strtolower($this->kepropinsi_nama),true);
		$criteria->compare('LOWER(kekabupaten_nama)',strtolower($this->kekabupaten_nama),true);
		$criteria->compare('LOWER(kekecamatan_nama)',strtolower($this->kekecamatan_nama),true);
		$criteria->compare('LOWER(kekelurahan_nama)',strtolower($this->kekelurahan_nama),true);
		$criteria->compare('jmlkilometer',$this->jmlkilometer);
		$criteria->compare('tarifperkm',$this->tarifperkm);
		$criteria->compare('tarifambulans',$this->tarifambulans);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getDaftartindakanItems()
        {
            return DaftartindakanM::model()->findAll("daftartindakan_aktif = TRUE ORDER BY daftartindakan_nama ASC");
        }
		
        /**
         * Mengambil daftar semua propinsi
         * @return CActiveDataProvider 
         */
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
        }
        /**
         * Mengambil daftar semua kabupaten berdasarkan propinsi
         * @return CActiveDataProvider 
         */
        public function getKabupatenItems($propinsi_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($propinsi_id)){
				$criteria->addCondition("propinsi_id = ".$propinsi_id); 			
			}
            $criteria->compare('kabupaten_aktif', true);
            $criteria->order='kabupaten_nama';
            $models = KabupatenM::model()->findAll($criteria);
            return $models;
        }
        /**
        
        /**
         * Mengambil daftar semua kelurahan berdasarkan kecamatan
         * @return CActiveDataProvider 
         */
        public function getKelurahanItems($kecamatan_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$kecamatan_id); 			
			}
            $criteria->compare('kelurahan_aktif', true);
            $criteria->order='kelurahan_nama';
            $models = KelurahanM::model()->findAll($criteria);
            return $models;
        }
        
        public function getKabupatenItemsNew($propinsi_nama=null)
	{
		$criteria = new CDbCriteria();
                $criteria->with=array('propinsi');
		$criteria->compare('LOWER(propinsi.propinsi_nama)',strtolower($propinsi_nama),true);
		$criteria->compare('t.kabupaten_aktif', true);
		$criteria->order='t.kabupaten_nama';
		$models = KabupatenM::model()->findAll($criteria);
		return $models;
	}
	
        public function getKecamatanItemsNew($kabupaten_nama=null)
	{
		$criteria = new CDbCriteria();
		$criteria->with=array('kabupaten');
		$criteria->compare('LOWER(kabupaten.kabupaten_nama)',strtolower($kabupaten_nama),true);
		$criteria->compare('t.kecamatan_aktif', true);
		$criteria->order='t.kecamatan_nama';
		$models = KecamatanM::model()->findAll($criteria);
		return $models;
	}
	
        public function getKelurahanItemsNew($kecamatan_nama=null)
	{
		$criteria = new CDbCriteria();
		$criteria->with=array('kecamatan');
		$criteria->compare('LOWER(kecamatan.kecamatan_nama)',strtolower($kecamatan_nama),true);
		$criteria->compare('t.kelurahan_aktif', true);
		$criteria->order='t.kelurahan_nama';
		$models = KelurahanM::model()->findAll($criteria);
		return $models;
	}
        
        /**
	* Mengambil daftar semua carabayar
	* @return CActiveDataProvider 
	*/
	public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
	
	/**
	* Mengambil daftar semua penjamin
	* @return CActiveDataProvider 
	*/
	public function getPenjaminItems($carabayar_id=null)
	{
	   if(!empty($carabayar_id))
			   return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
	   else
			   return array();
	}
}