<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PPRuanganM
 *
 * @author sujana
 */
class PPRuanganM extends RuanganM{
    
    public $jumlahkunjungan, $jumlahkunjunganlama, $jumlahkunjunganbaru, $pendaftaran_id;
    
    public $dokter_nama;
    
    public $tick, $data, $jumlah;
    public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir,$tgl_awal,$tgl_akhir;
    public $tipe;
	public $create_loginpemakai_id, $nama_perujuk, $jeniskasuspenyakit_nama;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function relations()
   {
       return array(
           'tindakanruangan'=>array(self::HAS_MANY,'PPTindakanruanganM','ruangan_id'),
           'daftartindakan'=>array(self::HAS_MANY,'PPDaftartindakanM',array('daftartindakan_id'=>'daftartindakan_id'),'through'=>'tindakanruangan'),
           'tariftindakan'=>array(self::HAS_MANY,'PPTariftindakan',array('daftartindakan_id'=>'daftar_tindakan_id'),'through'=>'daftartindakan'),
           'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
       );
   }
   
	public function searchUnitPelayanan(){
             
                $criteria = new CDbCriteria();
                $bln_awal = explode('-',$this->bln_awal);
                $bln_akhir = explode('-',$this->bln_akhir);
		$criteria->select = 't.ruangan_nama ,t.ruangan_id, '
				. 'COUNT(pendaftaran_t.kunjungan) AS jumlahkunjungan, '
				. 'COUNT(CASE pendaftaran_t.kunjungan WHEN \'KUNJUNGAN BARU\' THEN 1 ELSE NULL END) AS jumlahkunjunganbaru, '
				. 'COUNT(CASE pendaftaran_t.kunjungan WHEN \'KUNJUNGAN LAMA\' THEN 1 ELSE NULL END) AS jumlahkunjunganlama';
		$criteria->group = 't.ruangan_nama,t.ruangan_id, t.instalasi_id';
		$criteria->order='t.instalasi_id';
                
		$criteria->join ='LEFT JOIN pendaftaran_t ON pendaftaran_t.ruangan_id = t.ruangan_id';
                if (isset($this->tipe)){
                    if ($this->tipe == 'penunjang'){
                        $criteria->addInCondition('t.instalasi_id',Params::getArrayInstalasiPenunjang());
                    }elseif ($this->tipe == 'rawatjalan'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RJ));
                    }elseif ($this->tipe == 'rawatdarurat'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RD));
                    }elseif ($this->tipe == 'rawatinap'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RI));
                        $criteria->join ='left join pasienadmisi_t ON pasienadmisi_t.ruangan_id = t.ruangan_id '
                                . 'left join pendaftaran_t on pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id';
                    }
                }else{
                    $criteria->addInCondition('t.instalasi_id',array(2,3,4));
                }
		$criteria->addCondition(" pendaftaran_t.statusperiksa != '".Params::STATUSPERIKSA_BATAL_PERIKSA."' AND pendaftaran_t.pasienbatalperiksa_id IS NULL ");
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(pendaftaran_t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',pendaftaran_t.tgl_pendaftaran)",$bln_awal[1],$bln_akhir[1]);
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
                
                if (!empty($this->ruangan_id)){
                    if (is_array($this->ruangan_id)){
                        $criteria->addInCondition('t.ruangan_id', $this->ruangan_id);
                    }
                }else{
                    if (!empty($this->instalasi_id)){
                        if (is_array($this->instalasi_id)){
                            $ins = new CDbCriteria();
                            $ins->addInCondition(" instalasi_id ", $this->instalasi_id);
                            $ins->addCondition(" ruangan_aktif = TRUE ");                        
                            $ruangan = RuanganM::model()->findAll($ins);
                        }else{
                            $ruangan = RuanganM::model()->findAll("instalasi_id = '".$this->instalasi_id."' AND ruangan_aktif = TRUE ");
                        }
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('t.ruangan_id', $r);
                    }
                }
                
                if (!empty($this->dokter_nama)){
                    $id = DokterpegawaiV::model()->find("nama_pegawai iLIKE '%".$this->dokter_nama."%' ");
                    
                    if (!empty($id)){
                        $criteria->addCondition('pendaftaran_t.pegawai_id = '.$id->pegawai_id);
                    }else{
                        $tes = '99999';
                        $criteria->addCondition('pendaftaran_t.pegawai_id = '.$tes);
                    }
                }
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
	public function searchUnitPelayananPrint(){

		$criteria = new CDbCriteria();
                $bln_awal = explode('-',$this->bln_awal);
                $bln_akhir = explode('-',$this->bln_akhir);
		$criteria->select = 't.ruangan_nama ,t.ruangan_id, '
				. 'COUNT(pendaftaran_t.kunjungan) AS jumlahkunjungan, '
				. 'COUNT(CASE pendaftaran_t.kunjungan WHEN \'KUNJUNGAN BARU\' THEN 1 ELSE NULL END) AS jumlahkunjunganbaru, '
				. 'COUNT(CASE pendaftaran_t.kunjungan WHEN \'KUNJUNGAN LAMA\' THEN 1 ELSE NULL END) AS jumlahkunjunganlama';
		$criteria->group = 't.ruangan_nama,t.ruangan_id, t.instalasi_id';
		$criteria->order='t.instalasi_id';
		$criteria->join ='LEFT JOIN pendaftaran_t ON pendaftaran_t.ruangan_id = t.ruangan_id';
                if (isset($this->tipe)){
                    if ($this->tipe == 'penunjang'){
                        $criteria->addInCondition('t.instalasi_id',Params::getArrayInstalasiPenunjang());
                    }elseif ($this->tipe == 'rawatjalan'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RJ));
                    }elseif ($this->tipe == 'rawatdarurat'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RD));
                    }elseif ($this->tipe == 'rawatinap'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RI));
                        $criteria->join ='left join pasienadmisi_t ON pasienadmisi_t.ruangan_id = t.ruangan_id '
                                . 'left join pendaftaran_t on pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id';
                    }
                }else{
                    $criteria->addInCondition('t.instalasi_id',array(2,3,4));
                }
		$criteria->addCondition(" pendaftaran_t.statusperiksa != '".Params::STATUSPERIKSA_BATAL_PERIKSA."' AND pendaftaran_t.pasienbatalperiksa_id IS NULL ");
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(pendaftaran_t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',pendaftaran_t.tgl_pendaftaran)",$bln_awal[1],$bln_akhir[1]);
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
                
                if (!empty($this->ruangan_id)){
                    if (is_array($this->ruangan_id)){
                        $criteria->addInCondition('t.ruangan_id', $this->ruangan_id);
                    }
                }else{
                    if (is_array($this->instalasi_id)){
                        $criIns = new CDbCriteria();
                        $criIns->addInCondition("instalasi_id", $this->instalasi_id);
                        $criIns->addCondition(" ruangan_aktif = TRUE ");
                        $criIns->order = " ruangan_nama ASC ";
                        $ruangan = RuanganM::model()->findAll($criIns);
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('t.ruangan_id', $r);
                    }
                }
                
                if (!empty($this->dokter_nama)){
                    $id = DokterpegawaiV::model()->find("nama_pegawai iLIKE '%".$this->dokter_nama."%' ");
                    
                    if (!empty($id)){
                        $criteria->addCondition('pendaftaran_t.pegawai_id = '.$id->pegawai_id);
                    }else{
                        $tes = '99999';
                        $criteria->addCondition('pendaftaran_t.pegawai_id = '.$tes);
                    }
                }

		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	 }
  
	public function searchGrafikUnitPelayanan(){

		$criteria = new CDbCriteria();
		$format = new MyFormatter();
		if(isset($_GET['PPRuanganM'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
			$tgl_awal = $tgl_awal." 00:00:00";
			$tgl_akhir = $tgl_akhir." 23:59:59";
		}
		
		$bln_awal = explode('-',$this->bln_awal);
        $bln_akhir = explode('-',$this->bln_akhir);
		$criteria->select = 't.ruangan_nama as data ,t.ruangan_id, count(pendaftaran_t.statuspasien) as jumlah';
		$criteria->group = 't.ruangan_nama,t.ruangan_id';
		$criteria->order='t.ruangan_id';
		$criteria->join ='LEFT JOIN pendaftaran_t ON pendaftaran_t.ruangan_id = t.ruangan_id';
                if (isset($this->tipe)){
                    if ($this->tipe == 'penunjang'){
                        $criteria->addInCondition('t.instalasi_id',Params::getArrayInstalasiPenunjang());
                    }elseif ($this->tipe == 'rawatjalan'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RJ));
                    }elseif ($this->tipe == 'rawatdarurat'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RD));
                    }elseif ($this->tipe == 'rawatinap'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RI));
                        $criteria->join ='left join pasienadmisi_t ON pasienadmisi_t.ruangan_id = t.ruangan_id '
                                . 'left join pendaftaran_t on pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id';
                    }
                }else{
                    $criteria->addInCondition('t.instalasi_id',array(2,3,4));
                }
		$criteria->addCondition(" pendaftaran_t.statusperiksa != '".Params::STATUSPERIKSA_BATAL_PERIKSA."' AND pendaftaran_t.pasienbatalperiksa_id IS NULL ");
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(pendaftaran_t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',pendaftaran_t.tgl_pendaftaran)",$bln_awal[1],$bln_akhir[1]);
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}else{
			$criteria->addBetweenCondition('DATE(pendaftaran_t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		}
                
                if (!empty($this->ruangan_id)){
                    if (is_array($this->ruangan_id)){
                        $criteria->addInCondition('t.ruangan_id', $this->ruangan_id);
                    }
                }else{
                    if (is_array($this->instalasi_id)){
                        $criIns = new CDbCriteria();
                        $criIns->addInCondition("instalasi_id", $this->instalasi_id);
                        $criIns->addCondition(" ruangan_aktif = TRUE ");
                        $criIns->order = " ruangan_nama ASC ";
                        $ruangan = RuanganM::model()->findAll($criIns);
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('t.ruangan_id', $r);
                    }
                }
                
                if (!empty($this->dokter_nama)){
                    $id = DokterpegawaiV::model()->find("nama_pegawai iLIKE '%".$this->dokter_nama."%' ");
                    
                    if (!empty($id)){
                        $criteria->addCondition('pendaftaran_t.pegawai_id = '.$id->pegawai_id);
                    }else{
                        $tes = '99999';
                        $criteria->addCondition('pendaftaran_t.pegawai_id = '.$tes);
                    }
                }
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
		
	public function getRuanganItems()
	{
		return RuanganM::model()->findAll(array('order'=>'ruangan_nama'));
	}

	public function getNamaModel() 
	{
		return __CLASS__;
	}
       
	public function Criteria()
	{
		$criteria = new CDbCriteria;

		return $criteria;
	}
                
	public function getKunjunganbaru($ruangan_id)
	{
		$criteria=$this->Criteria();
		$bln_awal = explode('-',$this->bln_awal);
        $bln_akhir = explode('-',$this->bln_akhir);
		
		$criteria->select = 'count(pendaftaran_t.statuspasien) as jumlahkunjunganbaru, pendaftaran_t.statuspasien, t.ruangan_nama ';
		$criteria->group = 'pendaftaran_t.statuspasien, t.ruangan_nama, t.instalasi_id';
		$criteria->order='t.instalasi_id';
		if (isset($this->tipe)){
                    if ($this->tipe == 'penunjang'){
                        $criteria->addInCondition('t.instalasi_id',Params::getArrayInstalasiPenunjang());
                    }elseif ($this->tipe == 'rawatjalan'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RJ));
                    }elseif ($this->tipe == 'rawatdarurat'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RD));
                    }elseif ($this->tipe == 'rawatinap'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RI));
                    }
                }else{
                    $criteria->addInCondition('t.instalasi_id',array(2,3,4));
                }
		if(!empty($ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$ruangan_id);			
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(pendaftaran_t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',pendaftaran_t.tgl_pendaftaran)",$bln_awal[1],$bln_akhir[1]);
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		$criteria->join ='LEFT JOIN pendaftaran_t ON pendaftaran_t.ruangan_id = t.ruangan_id';
		$criteria->compare('pendaftaran_t.statuspasien',"PENGUNJUNG BARU");
		return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
	}
	public function getKunjunganlama($ruangan_id)
	{
		$criteria=$this->Criteria();
		$bln_awal = explode('-',$this->bln_awal);
		$bln_akhir = explode('-',$this->bln_akhir);
		
		$criteria->select = 'count(pendaftaran_t.statuspasien) as jumlahkunjunganbaru, pendaftaran_t.statuspasien, t.ruangan_nama ';
		$criteria->group = 'pendaftaran_t.statuspasien, t.ruangan_nama, t.instalasi_id';
		$criteria->order='t.instalasi_id';
		if (isset($this->tipe)){
                    if ($this->tipe == 'penunjang'){
                        $criteria->addInCondition('t.instalasi_id',Params::getArrayInstalasiPenunjang());
                    }elseif ($this->tipe == 'rawatjalan'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RJ));
                    }elseif ($this->tipe == 'rawatdarurat'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RD));
                    }elseif ($this->tipe == 'rawatinap'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RI));
                    }
                }else{
                    $criteria->addInCondition('t.instalasi_id',array(2,3,4));
                }
		if(!empty($ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$ruangan_id);			
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(pendaftaran_t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',pendaftaran_t.tgl_pendaftaran)",$bln_awal[1],$bln_akhir[1]);
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		$criteria->join ='LEFT JOIN pendaftaran_t ON pendaftaran_t.ruangan_id = t.ruangan_id';
		$criteria->compare('pendaftaran_t.statuspasien',"PENGUNJUNG LAMA");
		return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
	}
	public function getKunjungan($statuspasien,$ruangan_id)
	{
		$format = new MyFormatter();
		$criteria=$this->Criteria();
		$bln_awal = explode('-',$this->bln_awal);
		$bln_akhir = explode('-',$this->bln_akhir);
		$tgl_awal = '';
		$tgl_akhir = '';
		if(isset($_GET['PPRuanganM'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
			$tgl_awal = $tgl_awal." 00:00:00";
			$tgl_akhir = $tgl_akhir." 23:59:59";
		}

		$criteria->select = 'count(pendaftaran_t.statuspasien) as jumlahkunjunganbaru, pendaftaran_t.statuspasien, t.ruangan_nama ';
		$criteria->group = 'pendaftaran_t.statuspasien, t.ruangan_nama, t.instalasi_id';
		$criteria->order='t.instalasi_id';
		if (isset($this->tipe)){
                    if ($this->tipe == 'penunjang'){
                        $criteria->addInCondition('t.instalasi_id',Params::getArrayInstalasiPenunjang());
                    }elseif ($this->tipe == 'rawatjalan'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RJ));
                    }elseif ($this->tipe == 'rawatdarurat'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RD));
                    }elseif ($this->tipe == 'rawatinap'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RI));
                    }
                }else{
                    $criteria->addInCondition('t.instalasi_id',array(2,3,4));
                }
		if(!empty($ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$ruangan_id);			
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(pendaftaran_t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',pendaftaran_t.tgl_pendaftaran)",$bln_awal[1],$bln_akhir[1]);
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		$criteria->join ='LEFT JOIN pendaftaran_t ON pendaftaran_t.ruangan_id = t.ruangan_id';
		$criteria->compare('pendaftaran_t.statuspasien',$statuspasien);
		$criteria->compare('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		$query = PPRuanganM::model()->findAll($criteria);

		$jml = 0;
		foreach($query as $i=>$data){
			if(!empty($data->jumlahkunjunganbaru)){
				$jml += number_format($data->jumlahkunjunganbaru,0,"",".");
			}else{
				$jml = 0;
			}
		}
		return $jml;
//            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
	}
        
	public function getJmlKunjungan($ruangan_id)
	{

		$format = new MyFormatter();
		$criteria=$this->Criteria();
		
		$bln_awal = explode('-',$this->bln_awal);
		$bln_akhir = explode('-',$this->bln_akhir);
		$tgl_awal = '';
		$tgl_akhir = '';
		if(isset($_GET['PPRuanganM'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
			$tgl_awal = $tgl_awal." 00:00:00";
			$tgl_akhir = $tgl_akhir." 23:59:59";
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(pendaftaran_t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',pendaftaran_t.tgl_pendaftaran)",$bln_awal[1],$bln_akhir[1]);
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',pendaftaran_t.tgl_pendaftaran)",$this->thn_awal,$this->thn_akhir);
		}
		$criteria->select = 'count(pendaftaran_t.statuspasien) as jumlahkunjunganbaru, pendaftaran_t.statuspasien, t.ruangan_nama ';
		$criteria->group = 'pendaftaran_t.statuspasien, t.ruangan_nama, t.instalasi_id';
		$criteria->order='t.instalasi_id';
		if (isset($this->tipe)){
                    if ($this->tipe == 'penunjang'){
                        $criteria->addInCondition('t.instalasi_id',Params::getArrayInstalasiPenunjang());
                    }elseif ($this->tipe == 'rawatjalan'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RJ));
                    }elseif ($this->tipe == 'rawatdarurat'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RD));
                    }elseif ($this->tipe == 'rawatinap'){
                        $criteria->addInCondition('t.instalasi_id',array(Params::INSTALASI_ID_RI));
                    }
                }else{
                    $criteria->addInCondition('t.instalasi_id',array(2,3,4));
                }
		if(!empty($ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$ruangan_id);			
		}
		$criteria->join ='LEFT JOIN pendaftaran_t ON pendaftaran_t.ruangan_id = t.ruangan_id';
		$criteria->compare('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		$query = PPRuanganM::model()->findAll($criteria);

		$jml = 0;
		foreach($query as $i=>$data){
			if(!empty($data->jumlahkunjunganbaru)){
				$jml += number_format($data->jumlahkunjunganbaru,0,"",".");
			}else{
				$jml = 0;
			}
		}
		return $jml;
	}
}

?>
