<?php

class FAPenjualanResepT extends PenjualanresepT
{
    public $isNewRecord = true; //jika record baru = true
    public $noresep_depan;
    public $noresep_belakang = null;
    public $namaPegawai = null;
    public $antrianfarmasi_id;
    public $no_rekam_medik;
    public $dokter;
    public $is_pasien = 0;
    public $is_pemohon = 0;
    public $is_pegawai = 0;
	public $iter;
    public $nama_paket, $paketobat_id, $printed_by, $kelaspelayanan;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
                return array(
                        array('penjamin_id, carabayar_id, ruangan_id, pasien_id, tglpenjualan, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, ruanganasal_nama, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, jenislayanan_inv, tempatlayanan_inv, kodedokter_inventory', 'required'),
                        array('pasienprofilrs_id, pasieninstalasiunit_id, pasienpegawai_id, reseptur_id, pasienadmisi_id, penjamin_id, carabayar_id, pendaftaran_id, ruangan_id, pegawai_id, kelaspelayanan_id, pasien_id, lamapelayanan, antrianfarmasi_id, permohonanoa_id', 'numerical', 'integerOnly'=>true),
                        array('totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, takaranresep', 'numerical'),
                        array('jenispenjualan, instalasiasal_nama, ruanganasal_nama', 'length', 'max'=>100),
                        array('noresep', 'length', 'max'=>50),
                        array('tglresep, update_time, update_loginpemakai_id,isresepperawatan, keterangan, carabayarpegawai, keterangancarabayar', 'safe'),
                        array('jenislayanan_inv, tempatlayanan_inv, kodedokter_inventory', 'safe'),
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        
                        // The following rule is used by search().
                        // Please remove those attributes that should not be searched.
                        array('antrianfarmasi_id,penjualanresep_id, reseptur_id, pasienadmisi_id, penjamin_id, carabayar_id, pendaftaran_id, ruangan_id, pegawai_id, kelaspelayanan_id, pasien_id, tglpenjualan, jenispenjualan, tglresep, noresep, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, instalasiasal_nama, ruanganasal_nama, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, lamapelayanan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, permohonanoa_id, takaranresep, isresepperawatan', 'safe', 'on'=>'search'),
		);
	}
        
        public function searchTabelServices(){
            
            $criteria = new CDbCriteria();
            $criteria->with = array('pasien','pendaftaran','pegawai');
            $criteria->addBetweenCondition('date(tglresep)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('pasien.no_rekam_medik', $this->no_rekam_medik);
            $criteria->compare('pendaftaran.no_pendaftaran', $this->no_pendaftaran);
            $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
			if(!empty($this->pegawai_id)){
				$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
			}
            $criteria->addSearchCondition('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien));            
            $criteria->addCondition('totaltarifservice>0');
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);						
			}
            
            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
            ));
        }
//	RND-9072	menggunakan table view : laporanpejulanresepdokter_v.
//         public function searchTabel(){
//            
//            $criteria = new CDbCriteria();
//            $criteria->addBetweenCondition('date(tglresep)',$this->tgl_awal,$this->tgl_akhir);
//            $criteria->compare('pendaftaran.no_pendaftaran', $this->no_pendaftaran);
//            $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
////          BELUM BISA KARENA NoFaktur ADALAH FUNGSI>>  $criteria->compare('LOWER(NoFaktur)',strtolower($this->NoFaktur),true);
//			if(!empty($this->pegawai_id)){
//				$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
//			}
//            $criteria->addSearchCondition('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien));            
//            $criteria->addCondition('totaltarifservice>0');
//            
//            return  new CActiveDataProvider($this, array(
//                        'criteria'=>$criteria,
//            ));
//        }
//        
//        public function searchPrintServices(){
//            
//            $criteria = new CDbCriteria();
//            $criteria->with = array('pasien','pendaftaran','pegawai');
//            $criteria->addBetweenCondition('date(tglresep)',$this->tgl_awal,$this->tgl_akhir);
//            $criteria->compare('pasien.no_rekam_medik', $this->no_rekam_medik);
//            $criteria->compare('pendaftaran.no_pendaftaran', $this->no_pendaftaran);
//            $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
//			if(!empty($this->pegawai_id)){
//				$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
//			}
//            $criteria->addSearchCondition('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien));            
//            $criteria->addCondition('totaltarifservice>0');
//            
//            return  new CActiveDataProvider($this, array(
//                        'criteria'=>$criteria,
//                        'pagination'=>false,
//            ));
//        }
        /**
         * searchPrintServices digunakan pada laporan Jasa Racikan & print
         * @return \CActiveDataProvider
         */
        public function searchPrintJasaRacikan(){
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
            $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('date(tglresep)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('pendaftaran.no_pendaftaran', $this->no_pendaftaran);
            $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
//          BELUM BISA KARENA NoFaktur ADALAH FUNGSI>>  $criteria->compare('LOWER(NoFaktur)',strtolower($this->NoFaktur),true);
            if(!empty($this->pegawai_id)){
				$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
			}
            $criteria->addSearchCondition('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien));            
            $criteria->addCondition('totaltarifservice>0');
            
            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
            ));
        }
        /**
         * searchPrintJasaDokter digunakan pada laporan Jasa Dokter Resep & print
         * @return \CActiveDataProvider
         */
        public function searchTabelJasaDokter(){
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
            $criteria->with = array('pegawai');
            
            $criteria->addBetweenCondition('date(tglresep)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('pendaftaran.no_pendaftaran', $this->no_pendaftaran);
            $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
            if(!empty($this->pegawai_id)){
				$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
			}
//            $criteria->addSearchCondition('LOWER(pegawai.nama_pegawai)',  strtolower($this->namaPegawai));
            $criteria->addCondition('jasadokterresep>0');
            
            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
            ));
        }
        /**
         * searchPrintJasaDokter digunakan pada laporan Jasa Dokter Resep & print
         * @return \CActiveDataProvider
         */
        public function searchPrintJasaDokter(){
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
            $criteria->with = array('pegawai');
            $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('date(tglresep)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('pendaftaran.no_pendaftaran', $this->no_pendaftaran);
            $criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
            if(!empty($this->pegawai_id)){
				$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
			}
//            $criteria->addSearchCondition('LOWER(pegawai.nama_pegawai)',  strtolower($this->namaPegawai));
            $criteria->addCondition('jasadokterresep>0');
            
            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
            ));
        }
        
        public function searchGrafik(){
            
            $criteria = new CDbCriteria();
//            $criteria->with = array('pasien','pendaftaran');
            $criteria->join = 'JOIN pasien_m as pasien ON pasien.pasien_id=t.pasien_id 
                               JOIN pendaftaran_t as pendaftaran on pendaftaran.pendaftaran_id=t.pendaftaran_id 
                               JOIN ruangan_m as ruangan on ruangan.ruangan_id=t.ruangan_id';
            $criteria->addBetweenCondition('date(t.tglresep)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('pasien.no_rekam_medik', $this->no_rekam_medik);
            $criteria->compare('pendaftaran.no_pendaftaran', $this->no_pendaftaran);
			if(!empty($this->penjualanresep_id)){
				$criteria->addCondition("t.penjualanresep_id = ".$this->penjualanresep_id);						
			}
            $criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
			if(!empty($this->pegawai_id)){
				$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
			}
            $criteria->addSearchCondition('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien));            
            $criteria->addCondition('totaltarifservice>0');
            $criteria->select = 'count(t.totaltarifservice) as jumlah, ruangan.ruangan_nama as data';
            $criteria->group = 'ruangan.ruangan_nama';
            
            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                'pagination'=>false,
            ));
        }

        public function getProfilRs()
        {
            return ProfilrumahsakitM::model()->findAll();
        }
        
        //Menampilkan nama lengkap dokter + gelar
        public function getDokter(){
            $modDokter = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$this->pegawai_id));
            if(!empty($modDokter->nama_pegawai))
                return isset($modDokter->nama_pegawai) ? $modDokter->nama_pegawai:'';
            else
                return null;
        }
        
        
        public static function getListTakaran(){
            $takaran = array();
            $takaran[1]="1";
            $takaran[2]="1/2";
            $takaran[3]="1/3";
            return $takaran;
        }
        
        public function functionCriteria(){
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
            $criteria->with = array('pegawai');
            $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('date(tglresep)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('pendaftaran.no_pendaftaran', $this->no_pendaftaran);
            $criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
            if(!empty($this->pegawai_id)){
				$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
			}
//            $criteria->addSearchCondition('LOWER(pegawai.nama_pegawai)',  strtolower($this->namaPegawai));
            $criteria->addCondition('jasadokterresep>0');
            
            return $criteria;
        }
        
         public function getTotal($kolom = null)
         {
             $total = 0;
             $criteria=$this->functionCriteria();
             $criteria->select = 'SUM('.$kolom.')';
             $total =  $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
             
             return number_format($total,0,",",".");
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
		
		/**
		 * update karena ada perubahan di obatalkespasien_t
		 */
		public function updateByObatalkespasienT($penjualanresep_id = null){
			$sukses = false;
			if(empty($penjualanresep_id)){
				$penjualanresep_id = $this->penjualanresep_id;
			}
			$update = self::model()->findByPk($penjualanresep_id);
			$criteria = new CDbCriteria();
			$criteria->select = "penjualanresep_id, SUM(qty_oa * harganetto_oa) AS harganetto_oa, SUM(qty_oa * hargasatuan_oa) AS hargasatuan_oa ";
			$criteria->group = "penjualanresep_id";
			$criteria->addCondition("penjualanresep_id = ".$penjualanresep_id);
			$modOaPasien = ObatalkespasienT::model()->find($criteria);
			if($modOaPasien){
				$update->totharganetto = $modOaPasien->harganetto_oa; //SUM
				$update->totalhargajual = $modOaPasien->hargasatuan_oa; //SUM
				// $konfig_pembulatan = Yii::app()->user->getState('pembulatanharga');
				// $duadigit = substr($update->totalhargajual,-2);
                                /*
				if($duadigit == 50){
					$pembulatan = $update->totalhargajual;
				}else if($update->totalhargajual>0){
					$pembulatan = round($update->totalhargajual/$konfig_pembulatan)*$konfig_pembulatan;
				}else{
					$pembulatan = 0;
				}
				$update->pembulatanharga = $pembulatan - $update->totalhargajual;
                                */
                                
                                // var_dump($update->attributes); die;
                                
				if($update->validate()){
					$sukses = $update->update();
				}
			}
			return $sukses;
		}

        public function getPeriksaRad(){
            $cri = new CDbCriteria();
            $cri->addCondition("pegawai_id =".Yii::app()->user->getState('pegawai_id'));
            $cri->order = "nama_pegawai";
            
            return PegawaiM::model()->findAll($cri);
        }

        public function getNamaLengkapPegawai($pegawai_id)
    {
		$modPegawai = PegawaiM::model()->findByPk($pegawai_id);
        return (isset($modPegawai->gelardepan) ? $modPegawai->gelardepan : "").' '.$modPegawai->nama_pegawai.(isset($modPegawai->gelarbelakang_id) ? ', '.$modPegawai->gelarbelakang->gelarbelakang_nama : "");
    }

    public function searchRiwayatPenjualan() {
        $criteria = new CDbCriteria;
        if(!empty($this->pendaftaran_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        } else {
            $criteria->addCondition('pendaftaran_id = ' . 0);
        }
     
        $criteria->order = "tglresep desc";

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
}