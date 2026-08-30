<?php
class PPInfokunjunganmcuV extends InfokunjunganmcuV
{
	public $jumlah;
	public $data;
	public $tick;
	public $adaKarcis = false;
	public $Jenis_kasus_nama_penyakit;
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public $tgl_awal, $tgl_akhir;
    public $tgl_awall, $tgl_akhirl;
    public $ceklis;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganRj the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDaftarPasienMcu() {
        $criteria = new CDbCriteria;
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        }
        if (!empty($this->ceklis) && !empty($this->tgl_awall) && !empty($this->tgl_akhirl)) {
            $criteria->addBetweenCondition('DATE(t.tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
        }
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->compare('t.carabayar_id', $this->carabayar_id);
        $criteria->compare('t.penjamin_id', $this->penjamin_id);
//        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->with = array('pendaftaran');
		//$criteria->join = 'left JOIN permintaanmcu_t ON permintaanmcu_t.pendaftaran_id = t.pendaftaran_id';
        if(!isset($_GET[get_class($this)."_sort"])){ //jika tidak diklik sorting dari header table
            $criteria->order = 't.no_urutantri ASC';
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchDaftarPasienMCUDialog() {
        $prov = $this->searchDaftarPasienMcu();
        
        $prov->criteria->addCondition("t.statusperiksa <> '".Params::STATUSPERIKSA_SUDAH_PULANG."'");
        
        return $prov;
    }
    
    /**
	 * menampilkan data terakhir daftar
	*/
	public function searchPendaftaranTerakhir()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
                if (!empty($this->ruangan_id)){
                    $criteria->addCondition("ruangan_id = '".$this->ruangan_id."' ");
                }
		$criteria->order = 'tgl_pendaftaran DESC';
                $criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
    
    
        
	public function getNamaAlias()
	{
		if(!empty($this->nama_bin)){
			return $this->nama_pasien.' Alias '.$this->nama_bin;
		}else{
			return $this->nama_pasien;
		}

	}

	public function primaryKey() {
		return 'pendaftaran_id';
	}

	public function getNamaModel()
	{
		return __CLASS__;
	}
    
    /**
     * load status periksa pasien
     * @param type $status
     * @param type $id
     * @return string
     */
    public function getStatus($status,$id){
        
        
	   if($status == "SEDANG PERIKSA"){
		   $status = '<button id="red" class="btn btn-gold nohover" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';

	   }else if($status == "ANTRIAN"){
		   $status = '<button id="green" class="btn btn-black nohover" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
	   }else if($status == "SUDAH PULANG"){
		   $status = '<button id="blue" class="btn btn-green nohover" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
	   }else if($status == "SUDAH DI PERIKSA"){
		   $status = '<button id="orange" class="btn btn-blue nohover"  name="yt1">'.$status.'</button>';
       }else if($status == "SEDANG DIRAWAT INAP"){
		   $status = '<button id="orange" class="btn btn-purple nohover"  name="yt1">'.$status.'</button>';
       }else if($status == "MENUNGGU ADMISI PASIEN"){
		   $status = '<button id="orange" class="btn btn-orange nohover"  name="yt1">'.$status.'</button>';
       }
       else{
		   $status = '<button id="orange" class="btn btn-blue nohover"  name="yt1">'.$status.'</button>';
	   }
	   return $status;
   }
   
   /**
     * laod list data ruangan
     * @param type $instalasi_id
     * @return type
     */
	public function getRuanganItems($instalasi_id=null)
	{
		if($instalasi_id==null){
			return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama'));
		}else{
			return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama'));   
		}
	}
        
        public function ambilHasil($pendaftaran_id) {
            $tgl = '';
            $status = KesimpulanmcuT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            if(!empty($status->tglpengambilanhasil)){
                $tgl = MyFormatter::formatDateTimeForUser($status->tglpengambilanhasil);
            }
            return $tgl;
        }    
}