<?php

/**
 * This is the model class for table "tindakanruangan_m".
 *
 * The followings are the available columns in table 'tindakanruangan_m':
 * @property integer $ruangan_id
 * @property integer $daftartindakan_id
 */
class TindakanruanganM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanruanganM the static model class
	 */
    
	public $ruangan_nama,$daftartindakan_nama,$kategoritindakan_nama,$daftartindakan_kode,$harga_tariftindakan,$kategoritindakan_id,$nama_pelayanan;
	public $kelompoktindakan_nama, $komponenunit_id,$komponenunit_nama;
	public $instalasi_id, $modul_id;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tindakanruangan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, daftartindakan_id', 'required'),
			array('ruangan_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
                        array('daftartindakan_id','cekData','on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, daftartindakan_id, daftartindakan_nama, kelompoktindakan_id', 'safe', 'on'=>'search'),
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
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruangan_id' => 'Ruangan',
			'daftartindakan_id' => 'Daftar Tindakan',
			//'ruangan_nama' => 'Nama Ruangan',
			'kelompoktindakan_id' => 'kelompok Tindakan',
			'kelompoktindakan_nama' => 'kelompok Tindakan',
			'kategoritindakan_nama' => 'Kategori Tindakan',
                        'komponenunit_nama' => 'Komponen Unit',
			'daftartindakan_kode' => 'Kode Tindakan',
			'daftartindakan_nama' => 'Uraian Tindakan',
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
//
//                $criteria->select = 'ruangan_m.ruangan_nama, ruangan_m.ruangan_id, daftartindakan_m.daftartindakan_id,daftartindakan_m.daftartindakan_kode,
//                                    daftartindakan_m.daftartindakan_nama, kategoritindakan_m.kategoritindakan_id, 
//                                    kategoritindakan_m.kategoritindakan_nama, t.ruangan_id, t.daftartindakan_id, tariftindakan_m.harga_tariftindakan';
//                $criteria->group = 'ruangan_m.ruangan_nama, ruangan_m.ruangan_id, daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode,
//                                    daftartindakan_m.daftartindakan_nama, kategoritindakan_m.kategoritindakan_id,
//                                    kategoritindakan_m.kategoritindakan_nama, t.ruangan_id, t.daftartindakan_id, tariftindakan_m.harga_tariftindakan';
		
//                $criteria->join = 'RIGHT JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_id RIGHT JOIN daftartindakan_m 
//                                    ON daftartindakan_m.daftartindakan_id = t.daftartindakan_id RIGHT JOIN kategoritindakan_m ON
//                                    kategoritindakan_m.kategoritindakan_id = daftartindakan_m.kategoritindakan_id RIGHT JOIN tariftindakan_m 
//                                    ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id';
		
		$criteria=new CDbCriteria;
                $criteria->with = array('ruangan','daftartindakan','daftartindakan.kategoritindakan');
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
                $criteria->compare('LOWER(ruangan.ruangan_nama)',  strtolower($this->ruangan_nama), true);
                $criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)',  strtolower($this->kategoritindakan_nama), true);
                $criteria->compare('LOWER(komponenunit.komponenunit_nama)',  strtolower($this->komponenunit_nama), true);
                $criteria->compare('LOWER(daftartindakan.daftartindakan_kode)',  strtolower($this->daftartindakan_kode), true);
                $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',  strtolower($this->daftartindakan_nama), true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
     
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getDaftarTindakanItems()
        {
           return DaftartindakanM::model()->findAll("daftartindakan_aktif = true ORDER BY daftartindakan_nama ASC");
        }
        
         public function getRuanganItems()
        {
            return RuanganM::model()->findAll("ruangan_aktif = true ORDER BY ruangan_nama ASC");
        }
        
        public function searchPelRek(){
            
            $criteria = new CDbCriteria;
//            $criteria->with = array('kategoritindakan_m');
            $criteria->compare('t.ruangan_id',$this->ruangan_id);
            $criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
            $criteria->compare('kategoritindakan_m.kategoritindakan_id',$this->kategoritindakan_id);
            $criteria->compare('LOWER(kategoritindakan_m.kategoritindakan_nama)', strtolower($this->kategoritindakan_nama),true);
            $criteria->compare('LOWER(daftartindakan_m.daftartindakan_kode)', strtolower($this->daftartindakan_kode),true);
            $criteria->compare('LOWER(daftartindakan_m.daftartindakan_nama)', strtolower($this->daftartindakan_nama),true);
            $criteria->select = 'kategoritindakan_m.*, t.*,daftartindakan_m.*, ruangan_m.*';
            $criteria->join = 'JOIN daftartindakan_m ON t.daftartindakan_id=daftartindakan_m.daftartindakan_id 
                               JOIN ruangan_m ON t.ruangan_id = ruangan_m.ruangan_id
                               JOIN kategoritindakan_m ON daftartindakan_m.kategoritindakan_id = kategoritindakan_m.kategoritindakan_id';
            $criteria->addCondition("(t.ruangan_id, t.daftartindakan_id) not in(select ruangan_id, daftartindakan_id from pelayananrek_m) ");
//            $criteria->join = 'JOIN kategoritindakan_m ON kategoritindakan_m.kategoritindakan_id = daftartindakan.kategoritindakan_id';
            if(isset($this->ruangan_nama))
	        {
	            $criteria_satu = new CDbCriteria;
	            
	                $criteria_satu->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->ruangan_nama),true); 
	            
	            $record = TindakanruanganM::model()->with("ruangan")->findAll($criteria_satu);
	            $data = array();
	            foreach($record as $value)
	            {
	                $data[] = $value->ruangan_id;
	            }
	            if(count((array)$data)>0){
	            	$condition = 't.ruangan_id IN ('. implode(',', $data) .')';
	           		$criteria->addCondition($condition);	
	            } 
	           
	        }

            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
			));
        }
        
        public function cekData()
        {
            $cek = TindakanruanganM::model()->findAll("daftartindakan_id = '".$this->daftartindakan_id."' AND  ruangan_id = '".$this->ruangan_id."' ");
           
            if(count((array)$cek)>0){
                $this->addError('daftartindakan_id','Maaf, Daftar Tindakan '.$this->daftartindakan->daftartindakan_nama.' sudah ada pada ruangan '.$this->ruangan->ruangan_nama);
                return false;
            }else{
                return true;
            }     
        }
        
        public function getNamaTindakan()
        {
            return $this->daftartindakan->daftartindakan_nama;
        }
        
       
}