<?php

/**
 * This is the model class for table "kamarruangan_m".
 *
 * The followings are the available columns in table 'kamarruangan_m':
 * @property integer $kamarruangan_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property string $kamarruangan_nokamar
 * @property integer $kamarruangan_jmlbed
 * @property string $kamarruangan_nobed
 * @property boolean $kamarruangan_status
 * @property boolean $kamarruangan_aktif
 * @property integer $riwayatruangan_id
 * @property string $kamarruangan_image
 * @property strin $keterangan_kamar
 */
class KamarruanganM extends CActiveRecord
{
	public $jumlah_bed;
	public $pernah_dipakai;
	public $kamarTerpakai;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KamarruanganM the static model class
	 */
        public $kelaspelayanan_nama;
        public $ruangan_nama;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kamarruangan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kamarruangan_nokamar, kamarruangan_jmlbed, kamarruangan_nobed', 'required'),
			array('kelaspelayanan_id, ruangan_id, kamarruangan_jmlbed, riwayatruangan_id,  pegawaipenghapusankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes', 'numerical', 'integerOnly'=>true),
			array('kamarruangan_nokamar, kamarruangan_nobed', 'length', 'max'=>100),
			array('kamarruangan_image', 'length', 'max'=>100),
            array('statuspengiriman', 'length', 'max'=>20),
			array('is_bedbayangan, kamarruangan_status, kamarruangan_aktif, keterangan_kamar, tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes, logpenghapusandatakemenkes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelaspelayanan_nama, kamarruangan_id, kelaspelayanan_id, keterangan_kamar, ruangan_id, kamarruangan_nokamar, kamarruangan_jmlbed, kamarruangan_nobed, kamarruangan_status, kamarruangan_aktif, riwayatruangan_id, kamarruangan_image, tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes, pegawaipenghapusankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes, logpenghapusandatakemenkes, statuspengiriman', 'safe', 'on'=>'search'),
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
                    'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kamarruangan_id' => 'Kamar Ruangan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'ruangan_id' => 'Ruangan',
			'kamarruangan_nokamar' => 'Nama Kamar',
			'kamarruangan_jmlbed' => 'Jumlah Bed',
			'kamarruangan_nobed' => 'No. Bed',
			'kamarruangan_status' => 'Terpakai',
			'kamarruangan_aktif' => 'Aktif',
			'riwayatruangan_id' => 'Riwayat Ruangan Id',
			'kamarruangan_image' => 'Photo',
                        'keterangan_kamar'=>'Keterangan Kamar',
						'is_bedbayangan'=>'Bed Bayangan',
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
                
                $criteria->select = 't.kamarruangan_id, t.kelaspelayanan_id, t.kamarruangan_nokamar, t.kamarruangan_jmlbed, t.kamarruangan_nobed, t.kamarruangan_status, t.kamarruangan_aktif, ruangan_m.ruangan_id, instalasi_m.instalasi_id, t.is_bedbayangan';
                $criteria->join = ' JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_id'
                        . ' JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id ';
                $criteria->group = $criteria->select;
                
		$criteria->compare('t.kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
                
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
                $criteria->compare('instalasi_m.instalasi_id',$this->instalasi_id);
                
		$criteria->compare('LOWER(t.kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('t.kamarruangan_jmlbed',$this->kamarruangan_jmlbed);
		$criteria->compare('LOWER(t.kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('t.kamarruangan_status',$this->kamarruangan_status);
		$criteria->compare('t.kamarruangan_aktif',isset($this->kamarruangan_aktif)?$this->kamarruangan_aktif:true);
		$criteria->compare('t.riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(t.kamarruangan_image)',strtolower($this->kamarruangan_image),true);
		if ($this->is_bedbayangan == 1) {
			$criteria->addCondition('t.is_bedbayangan = true');
		} else if ($this->is_bedbayangan == 0) {
			$criteria->addCondition('t.is_bedbayangan = false');
		}
                $criteria->compare('LOWER(t.keterangan_kamar)',strtolower($this->keterangan_kamar),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.
				$criteria=new CDbCriteria;

				$criteria->select = 't.kamarruangan_id, t.kelaspelayanan_id, t.kamarruangan_nokamar, t.kamarruangan_jmlbed, t.kamarruangan_nobed, t.kamarruangan_status, t.kamarruangan_aktif, ruangan_m.ruangan_id, instalasi_m.instalasi_id, t.is_bedbayangan';
                $criteria->join = ' JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_id'
                        . ' JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id ';
                $criteria->group = $criteria->select;
                
		$criteria->compare('t.kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
                
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
                $criteria->compare('instalasi_m.instalasi_id',$this->instalasi_id);
                
		$criteria->compare('LOWER(t.kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('t.kamarruangan_jmlbed',$this->kamarruangan_jmlbed);
		$criteria->compare('LOWER(t.kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('t.kamarruangan_status',$this->kamarruangan_status);
		$criteria->compare('t.kamarruangan_aktif',isset($this->kamarruangan_aktif)?$this->kamarruangan_aktif:true);
		$criteria->compare('t.riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(t.kamarruangan_image)',strtolower($this->kamarruangan_image),true);
                $criteria->compare('LOWER(t.keterangan_kamar)',strtolower($this->keterangan_kamar),true);

                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->kamarruangan_nokamar = ($this->kamarruangan_nokamar);
            $this->kamarruangan_nobed = ($this->kamarruangan_nobed);

            return parent::beforeSave();
        }
        
        public function getKelasPelayananItems()
        {
            return SAKelasPelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'kelaspelayanan_nama'));
        }
        
        
        public function getInstalasiItems()
        {
            return SAInstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true),array('order'=>'instalasi_nama'));
        }
        
        
        public function getKelasRuanganItems()
        {
            return KelasruanganM::model()->with('ruangan')->findAll('kelaspelayanan_id='.$this->kelaspelayanan_id.'');
          
        }  
        
        public function getRuanganItems($instalasi=null)
        {
            if($instalasi != null)
            {
                return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
            }
            else{
                return RuanganM::model()->findAll(array('order'=>'ruangan_nama', 'condition'=>'ruangan_aktif = true'));
            }
        }  
		
		public function getRuanganKamarItems()
        {
            $cri = new CDbCriteria();
			$cri->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id ";
			$cri->addCondition(" i.instalasi_adakamar AND i.instalasi_aktif = TRUE ");
			$cri->addCondition(" t.ruangan_aktif = TRUE ");
			$cri->order = " t.ruangan_nama ASC ";
			
			return RuanganM::model()->findAll($cri);
        }  
        
        public function getKamarDanTempatTidur()
        {
        	if(empty($this->keterangan_kamar)){
        		return 'Kamar: '.$this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed;	
        	}else{
        		return 'Kamar: '.$this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed.' ('.strtoupper($this->keterangan_kamar).')';	
        	}
            
        }

				public function getKamarDanTempatTidurDanKelaspelayanan()
        {
					$kelaspel = KelaspelayananM::model()->findByPk($this->kelaspelayanan_id);
					$kelasnama = (!empty($kelaspel)?$kelaspel->kelaspelayanan_nama:"");

        	if(empty($this->keterangan_kamar)){
        		return 'Kamar: '.$this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed .' - Kelas: '.$kelasnama;	
        	}else{
        		return 'Kamar: '.$this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed .' - Kelas: '.$kelasnama.' ('.strtoupper($this->keterangan_kamar).')';	
        	}
            
        }
        
        public function getKamarDanTempatTidurInUse()
        {
                $masukkamar = MasukkamarT::model()->find("tglkeluarkamar IS NULL and kamarruangan_id = '".$this->kamarruangan_id."' ");
                
        	if(empty($this->keterangan_kamar)){
        		return 'Kamar: '.$this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed.' ('.(!empty($masukkamar)?$masukkamar->admisi->pasien->namadepan.' '.$masukkamar->admisi->pasien->nama_pasien:'-').')';	
        	}else{
        		return 'Kamar: '.$this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed.' ('.strtoupper($this->keterangan_kamar).')'.' ('.(!empty($masukkamar)?$masukkamar->admisi->pasien->namadepan.' '.$masukkamar->admisi->pasien->nama_pasien:'-').')';	
        	}
            
        }
		
		public function getKamarDanTempatTidurInUseV2()
        {

			$crMasuk = new CDbCriteria();
			$crMasuk->select = "t.*, p.tglpembayaran";
			$crMasuk->addCondition("tglkeluarkamar IS NULL and t.kamarruangan_id = '".$this->kamarruangan_id."'");
			$crMasuk->order = "t.tglmasukkamar DESC";
			$crMasuk->join = "left join (
				select distinct on (a.pasienadmisi_id) a.pasienadmisi_id, a.tglpembayaran from pembayaranpelayanan_t a
				where a.pasienadmisi_id is not null
				order by a.pasienadmisi_id, a.tglpembayaran asc
			) p on p.pasienadmisi_id = t.pasienadmisi_id";


                $masukkamar = MasukkamarT::model()->find($crMasuk); //find("tglkeluarkamar IS NULL and kamarruangan_id = '".$this->kamarruangan_id."' ORDER BY tglmasukkamar DESC");
				$kelaspelayanan = KelaspelayananM::model()->findByPk($this->kelaspelayanan_id);

			if (!empty($masukkamar->tglpembayaran) && (time() - strtotime($masukkamar->tglpembayaran) > 3600)) {
				$masukkamar = null;
			}

                
        	if(empty($this->keterangan_kamar)){
        		return $this->kamarruangan_nokamar.' - '.$this->kamarruangan_nobed.'-'.$kelaspelayanan->kelaspelayanan_nama.' '.(!empty($masukkamar) && !$this->kamarruangan_status ?'--- '.$masukkamar->admisi->pasien->nama_pasien.'('.$masukkamar->admisi->pasien->jeniskelamin.')':'');	
        	}else{
        		return $this->kamarruangan_nokamar.' - '.$this->kamarruangan_nobed.'-'.$kelaspelayanan->kelaspelayanan_nama.' '.(!empty($masukkamar) && !$this->kamarruangan_status ?'--- '.$masukkamar->admisi->pasien->nama_pasien.'('.$masukkamar->admisi->pasien->jeniskelamin.')':'');	
        	}
            
        }

		public function getKamarDanTempatTidurInUseHemodialisa()
        {
			$masukkamar = KonsulpoliT::model()->find("kamarruangan_id = '".$this->kamarruangan_id."' AND statusperiksa != '" . 'SELESAI TINDAKAN' . "' ORDER BY tglkonsulpoli DESC");
                
        	if(empty($this->keterangan_kamar)){
        		return 'Kamar: '. $this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed.' '.(!empty($masukkamar) && !$this->kamarruangan_status ?' --- '.$masukkamar->pasien->nama_pasien.'('.$masukkamar->pasien->jeniskelamin.')':'Tersedia');	
        	}else{
        		return 'Kamar: '. $this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed.' '.(!empty($masukkamar) && !$this->kamarruangan_status ?' --- '.$masukkamar->pasien->nama_pasien.'('.$masukkamar->pasien->jeniskelamin.')':$this->keterangan_kamar);	
        	}
            
        }
        
        
        public function getKamarDanTempatTidurPolos()
        {
        	return $this->kamarruangan_nokamar.' '.$this->kamarruangan_nobed;	
        }
		
		public  function getTotalBed($kelaspelayanan_id, $ruangan_id, $kamarruangan_nokamar){
			
			$cri = new CDbCriteria();			
			$cri->addCondition(" kelaspelayanan_id = '".$kelaspelayanan_id."' ");
			$cri->addCondition(" ruangan_id = '".$ruangan_id."' ");
			$cri->addCondition(" kamarruangan_nokamar = '".$kamarruangan_nokamar."' ");
			
			$get = KamarruanganM::model()->findAll($cri);
			
			return count((array)$get);
		}
		
		public function LoadKamar($kelaspelayanan_id, $ruangan_id, $kamarruangan_nokamar){
			$cri = new CDbCriteria();			
			$cri->addCondition(" kelaspelayanan_id = '".$kelaspelayanan_id."' ");
			$cri->addCondition(" ruangan_id = '".$ruangan_id."' ");
			$cri->addCondition(" kamarruangan_nokamar = '".$kamarruangan_nokamar."' ");
			$cri->order = " kamarruangan_nobed ASC ";
			
			$get = self::model()->findAll($cri);
			
			return $get;
		}
                
                public function searchKamarHemodialisa() {

                $criteria = new CDbCriteria;

                $criteria->compare('kamarruangan_id', $this->kamarruangan_id);
                $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
                $criteria->compare('ruangan_id', $this->ruangan_id);
                $criteria->compare('LOWER(kamarruangan_nokamar)', strtolower($this->kamarruangan_nokamar), true);
                $criteria->compare('kamarruangan_jmlbed', $this->kamarruangan_jmlbed);
                $criteria->compare('LOWER(kamarruangan_nobed)', strtolower($this->kamarruangan_nobed), true);
                $criteria->compare('kamarruangan_status', $this->kamarruangan_status);
                $criteria->compare('kamarruangan_aktif', isset($this->kamarruangan_aktif) ? $this->kamarruangan_aktif : true);
                $criteria->compare('riwayatruangan_id', $this->riwayatruangan_id);
                $criteria->compare('LOWER(kamarruangan_image)', strtolower($this->kamarruangan_image), true);
                $criteria->compare('LOWER(keterangan_kamar)', strtolower($this->keterangan_kamar), true);
                $criteria->addCondition('ruangan_id IN  (SELECT ruangan_id FROM ruanganhemodialisa_v GROUP BY ruangan_id ) ');
                
                return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
            }
            
            /**
     * Mendapatkan format label no bed dan keterangan
     * @return type string mendapatkan format label no bed dan keterangan
     */
    public function getTempatTidur() {
        if (empty($this->keterangan_kamar)) {
            return $this->kamarruangan_nobed;
        } else {
            return $this->kamarruangan_nobed . ' (' . strtoupper($this->keterangan_kamar) . ')';
        }
    }
}