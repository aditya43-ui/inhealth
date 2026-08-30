<?php

/**
 * This is the model class for table "lokasiaset_m".
 *
 * The followings are the available columns in table 'lokasiaset_m':
 * @property integer $lokasi_id
 * @property string $lokasiaset_kode
 * @property string $lokasiaset_namainstalasi
 * @property string $lokasiaset_namabagian
 * @property string $lokasiaset_namalokasi
 * @property boolean $lokasiaset_aktif
 * @property double $garis_latitude
 * @property double $garis_longitude
 *
 * The followings are the available model relations:
 * @property InvtanahT[] $invtanahTs
 * @property InvperalatanT[] $invperalatanTs
 * @property InvgedungT[] $invgedungTs
 * @property InvjalanT[] $invjalanTs
 * @property InvasetlainT[] $invasetlainTs
 */
class LokasiasetM extends CActiveRecord
{
        public $default;
        public $ruangan_nama, $ruangan_lokasi;
        public $instalasi_nama, $gedung_nama, $gedung_id, $instalasi_id, $area_nama, $area_id;
        public $lokasi_wo, $lokasi_aset_pj;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasiasetM the static model class
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
		return 'lokasiaset_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lokasiaset_kode, jenis_lokasi, lokasiaset_namalokasi', 'required'),
			array('garis_latitude, garis_longitude', 'numerical'),
			array('lokasiaset_kode, lokasiaset_namabagian', 'length', 'max'=>50),
			array('lokasiaset_namainstalasi, lokasiaset_namalokasi', 'length', 'max'=>100),
			array('kode_internal, ruangan_id, lokasiaset_aktif, induk_satker, alamat_lokasi, '
                        . 'kodepos_lokasi, kotakab_lokasi, telp_lokasi, deskripsi_lokasi, '
                        . 'jenis_lokasi, ruangan_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
            
			array('jenis_lokasi, lokasi_id, lokasiaset_kode, lokasiaset_namainstalasi, lokasiaset_namabagian, lokasiaset_namalokasi, lokasiaset_aktif, garis_latitude, garis_longitude', 'safe', 'on'=>'search'),
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
			'invtanahTs' => array(self::HAS_MANY, 'InvtanahT', 'lokasi_id'),
			'invperalatanTs' => array(self::HAS_MANY, 'InvperalatanT', 'lokasi_id'),
			'invgedungTs' => array(self::HAS_MANY, 'InvgedungT', 'lokasi_id'),
			'invjalanTs' => array(self::HAS_MANY, 'InvjalanT', 'lokasi_id'),
			'invasetlainTs' => array(self::HAS_MANY, 'InvasetlainT', 'lokasi_id'),
                        'ruangan'=> [self::BELONGS_TO,'RuanganM','ruangan_id']
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lokasi_id' => 'ID',
			'lokasiaset_kode' => 'Aset Kode',
			'lokasiaset_namainstalasi' => 'Nama Instalasi',
			'lokasiaset_namabagian' => 'Nama Bagian',
			'lokasiaset_namalokasi' => 'Nama Lokasi',
			'lokasiaset_aktif' => 'Lokasi Aset Aktif',
			'garis_latitude' => 'Garis Latitude',
			'garis_longitude' => 'Garis Longitude',
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
                $criteria->select = [
                    't.*',
                    'r.ruangan_nama',
                    'r.ruangan_lokasi',
                    'a.area_nama',                    
                    'g.gedung_nama',
                ];
                $criteria->join = " LEFT JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
                                . " LEFT JOIN area_m a ON a.area_id = r.area_id "
                                . " LEFT JOIN gedung_m g ON g.gedung_id = r.gedung_id ";
                if (!empty($this->default)){
                    $criteria->addCondition(" t.lokasi_id IS NULL ");
                }
		if(!empty($this->lokasi_id)){
                    if (is_array($this->lokasi_id)){
                        $criteria->addInCondition('t.lokasi_id',$this->lokasi_id);
                    }else{
                        $criteria->addCondition('t.lokasi_id = '.$this->lokasi_id);
                    }
		}
                if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
                
                if(!empty($this->gedung_id)){
			$criteria->addCondition('g.gedung_id = '.$this->gedung_id);
		}
                
                if(!empty($this->area_id)){
			$criteria->addCondition('r.area_id = '.$this->area_id);
		}
                
                $criteria->compare('LOWER(r.ruangan_nama)',strtolower($this->ruangan_nama),true);
                $criteria->compare('LOWER(r.ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
                $criteria->compare('LOWER(a.area_nama)',strtolower($this->area_nama),true);
                $criteria->compare('LOWER(g.gedung_nama)',strtolower($this->gedung_nama),true);
                
                $criteria->compare('LOWER(t.kode_internal)',strtolower($this->kode_internal),true);
		$criteria->compare('LOWER(t.lokasiaset_kode)',strtolower($this->lokasiaset_kode),true);
		$criteria->compare('LOWER(t.lokasiaset_namainstalasi)',strtolower($this->lokasiaset_namainstalasi),true);
		$criteria->compare('LOWER(t.lokasiaset_namabagian)',strtolower($this->lokasiaset_namabagian),true);
		$criteria->compare('LOWER(t.lokasiaset_namalokasi)',strtolower($this->lokasiaset_namalokasi),true);
		$criteria->compare('LOWER(t.jenis_lokasi)',strtolower($this->jenis_lokasi),true);
		$criteria->compare('LOWER(t.induk_satker)',strtolower($this->induk_satker),true);
		$criteria->compare('LOWER(t.deskripsi_lokasi)',strtolower($this->deskripsi_lokasi),true);
		$criteria->compare('LOWER(t.alamat_lokasi)',strtolower($this->alamat_lokasi),true);
		$criteria->compare('LOWER(t.kotakab_lokasi)',strtolower($this->kotakab_lokasi),true);
		$criteria->compare('LOWER(t.kodepos_lokasi)',strtolower($this->kodepos_lokasi),true);
		$criteria->compare('LOWER(t.telp_lokasi)',strtolower($this->telp_lokasi),true);
		$criteria->compare('t.lokasiaset_aktif',isset($this->lokasiaset_aktif)?$this->lokasiaset_aktif:true);
		$criteria->compare('t.garis_latitude',$this->garis_latitude);
		$criteria->compare('t.garis_longitude',$this->garis_longitude);
                
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
            if ($this->lokasi_wo){
                $criteria->addCondition("t.lokasi_id IN (SELECT lokasi_id FROM workorder_t GROUP by lokasi_id) ");
            }

            if ($this->lokasi_aset_pj){
                $criteria->addCondition("t.lokasi_id IN (SELECT lokasi_id FROM penanggungjawabaset_m WHERE pegawai_id = ".Yii::app()->user->getState('pegawai_id')." GROUP by lokasi_id )  ");
            }            
            
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

        /**
         * Load data untuk dicetak
         * @return \CActiveDataProvider
         */
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
        
        /**
         * Load kode aset dan nama aset
         * @return type
         */
        public function getKodeNama() {
            return $this->lokasiaset_kode." - ".$this->lokasiaset_namalokasi;
        }
}