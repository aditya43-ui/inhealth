<?php

/**
 * This is the model class for table "tindakandokter_m".
 *
 * The followings are the available columns in table 'tindakandokter_m':
 * @property integer $tindakandokter_id
 * @property integer $pegawai_id
 * @property integer $daftartindakan_id
 *
 * The followings are the available model relations:
 * @property DaftartindakanM $daftartindakan
 * @property PegawaiM $pegawai
 */
class TindakandokterM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakandokterM the static model class
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
		return 'tindakandokter_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, daftartindakan_id', 'required'),
			array('pegawai_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakandokter_id, pegawai_id, daftartindakan_id', 'safe', 'on'=>'search'),
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
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakandokter_id' => 'Tindakandokter',
			'pegawai_id' => 'Pegawai',
			'daftartindakan_id' => 'Daftartindakan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that

		$criteria=new CDbCriteria;
                $criteria->with = array('pegawai','daftartindakan','daftartindakan.kategoritindakan');
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
                $criteria->compare('LOWER(pegawai.pegawai_nama)',  strtolower($this->pegawai_nama), true);
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
		$criteria->compare('pegawai_id',$this->pegawai_id);
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
        
         public function getpegawaiItems()
        {
            return pegawaiM::model()->findAll("pegawai_aktif = true ORDER BY pegawai_nama ASC");
        }
        
        public function searchPelRek(){
            
            $criteria = new CDbCriteria;
//            $criteria->with = array('kategoritindakan_m');
            $criteria->compare('t.pegawai_id',$this->pegawai_id);
            $criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
            $criteria->compare('kategoritindakan_m.kategoritindakan_id',$this->kategoritindakan_id);
            $criteria->compare('LOWER(kategoritindakan_m.kategoritindakan_nama)', strtolower($this->kategoritindakan_nama),true);
            $criteria->compare('LOWER(daftartindakan_m.daftartindakan_kode)', strtolower($this->daftartindakan_kode),true);
            $criteria->compare('LOWER(daftartindakan_m.daftartindakan_nama)', strtolower($this->daftartindakan_nama),true);
            $criteria->select = 'kategoritindakan_m.*, t.*,daftartindakan_m.*, pegawai_m.*';
            $criteria->join = 'JOIN daftartindakan_m ON t.daftartindakan_id=daftartindakan_m.daftartindakan_id 
                               JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id
                               JOIN kategoritindakan_m ON daftartindakan_m.kategoritindakan_id = kategoritindakan_m.kategoritindakan_id';
            $criteria->addCondition("(t.pegawai_id, t.daftartindakan_id) not in(select pegawai_id, daftartindakan_id from pelayananrek_m) ");
//            $criteria->join = 'JOIN kategoritindakan_m ON kategoritindakan_m.kategoritindakan_id = daftartindakan.kategoritindakan_id';
            if(isset($this->pegawai_nama))
	        {
	            $criteria_satu = new CDbCriteria;
	            
	                $criteria_satu->compare('LOWER(pegawai.pegawai_nama)', strtolower($this->pegawai_nama),true); 
	            
	            $record = TindakanpegawaiM::model()->with("pegawai")->findAll($criteria_satu);
	            $data = array();
	            foreach($record as $value)
	            {
	                $data[] = $value->pegawai_id;
	            }
	            if(COUNT($data)>0){
	            	$condition = 't.pegawai_id IN ('. implode(',', $data) .')';
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
            $cek = TindakanpegawaiM::model()->findAll("daftartindakan_id = '".$this->daftartindakan_id."' AND  pegawai_id = '".$this->pegawai_id."' ");
           
            if(count($cek)>0){
                $this->addError('daftartindakan_id','Maaf, Daftar Tindakan '.$this->daftartindakan->daftartindakan_nama.' sudah ada pada pegawai '.$this->pegawai->pegawai_nama);
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