<?php

class GJPenggajianpegT extends PenggajianpegT
{    
        public static function model($className = __CLASS__) {
            return parent::model($className);
        }
        
        public $tgl_awal, 
				$tgl_akhir, 
				$bln_awal,
				$bln_akhir,
				$thn_awal,
				$thn_akhir,
				$jns_periode,
				$nama_pegawai, 
                $jabatan_id,
                $unitkerja_id;
		public $gajipph;
        public $biayajabatan;
        public $iuranpensiun;
        public $penerimaanpph;
        public $ptkp;
        public $pkp;
        public $pphpersen;
        public $pph21;
        public $periodegaji_info;
        public $lamakerja;
        public $cuti;
        public $alpha;
        public $ijin;
        public $no_temp;
        public $kelompokpegawai_id;
        public $kategoripegawaiasal;
        public $status, $pemotong;
        public $thr_potong_pajak;
        public $mengetahuipt;
        public $kategoripegawai,$namaunitkerja,$pendidikan_nama,$jabatan_nama,$tglditerima;
        public $data_komponen, $id;
        
        public $komponengaji_id, $komponengaji_nama, $ispotongan;


        public function attributeLabels()
        {
                return array(
                        'penggajianpeg_id' => 'Penggajian Pegawai',
                        'pegawai_id' => 'Pegawai',
                        'tglpenggajian' => 'Tanggal Penggajian',
                        'nopenggajian' => 'No. Penggajian',
                        'keterangan' => 'Keterangan',
                        'mengetahui' => 'Mengetahui',
                        'menyetujui' => 'Menyetujui',
                        'totalterima' => 'Total Terima',
                        'totalpajak' => 'Total Pajak',
                        'totalpotongan' => 'Total Potongan',
                        'penerimaanbersih' => 'Penerimaan Bersih',
                        'nomorindukpegawai'=>'NIP',
						'kategoripegawaiasal'=>'Kategori Pegawai Asal',
					
                        
                        'tgl_awal'=>'Tanggal Penggajian',
                        'tgl_akhir'=>'Sampai dengan',
                        'jabatan_id'=>'Jabatan',
                        'unitkerja_id'=>'Unit Kerja',
						'potongan_lainlain'=>'Potongan Lain-Lain',
                );
        }
        
        public function criteriaLaporan()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->with = 'pegawai';
                if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                    $criteria->addBetweenCondition('tglpenggajian',$this->tgl_awal,$this->tgl_akhir);
                }
                $criteria->compare('tglpenggajian::date',$this->tglpenggajian);
                $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('pegawai.jabatan_id',$this->jabatan_id);
                $criteria->compare('pegawai.unitkerja_id',$this->unitkerja_id);
                
                return $criteria;
        }
		
		public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            if(!empty($this->periodegaji)){
                $this->periodegaji = MyFormatter::formatMonthForDB($this->periodegaji);
            }

            $criteria=$this->criteriaSearch();
			$criteria->with = 'pegawai';
			if(!empty($this->nomorindukpegawai)){
				$criteria->compare("LOWER(pegawai.nomorindukpegawai)",strtolower($this->nomorindukpegawai),true);
			}
			if(!empty($this->nama_pegawai)){
				$criteria->compare("LOWER(pegawai.nama_pegawai)",strtolower($this->nama_pegawai),true);
			}
            
			if(!empty($this->kelompokpegawai_id)){
				$criteria->compare("pegawai.kelompokpegawai_id",$this->kelompokpegawai_id);
			}
            
			if(!empty($this->jabatan_id)){
				$criteria->compare("pegawai.jabatan_id",$this->jabatan_id);
            }
            if(!empty($this->unitkerja_id)){
                $criteria->compare("pegawai.unitkerja_id", $this->unitkerja_id);
            }
	
            $criteria->compare('LOWER(pegawai.kategoripegawaiasal)', strtolower($this->kategoripegawaiasal));
            
            $criteria->addCondition("(case when periodegaji is null then tglpenggajian else periodegaji end)::date between '". 
                $this->periodegaji."-01' and '".date('Y-m-t', strtotime($this->periodegaji.'-01'))."'");
            

            if ($this->status == 1) {
                $criteria->addCondition('pengeluaranumum_id is null');
            } else if ($this->status == 2) {
                $criteria->addCondition('pengeluaranumum_id is not null');
            }
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'tglpenggajian',
                ),
            ));
        }
        
        public function searchLaporan()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteriaLaporan(),
                        'sort'=>array(
                            'defaultOrder'=>'t.tglpenggajian',
                        ),
                        'pagination'=>array(
                            'pageSize'=>10,
                        )
                ));
        }
        
        public function searchLaporanprint()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteriaLaporan(),
                        'pagination'=>false,
                        'sort'=>array(
                            'defaultOrder'=>'t.tglpenggajian',
                        ),
                ));
        }
        
         
        
		/**
		 * Retrieves a list of models based on the current search/filter conditions.
		 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
		 */
		public function searchGaji()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			
			$criteria->addBetweenCondition('DATE(tglpenggajian)', $this->tgl_awal,  $this->tgl_akhir);
			$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);
			$criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
			$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
			$criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
			$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
			$criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
			$criteria->compare('penerimaanbersih',$this->penerimaanbersih);
			$criteria->compare('totalpajak',$this->totalpajak);
			$criteria->compare('pegawai_id',$this->pegawai_id);
			$criteria->addCondition('pegawai_id ='.Yii::app()->user->getState('pegawai_id'));
			$criteria->order = 'tglpenggajian desc';
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
		
        public function getTotalColumnKomponen($potongan)
        {
			if ($potongan=='potongan') {
				$total = Yii::app()->db->createCommand('SELECT COUNT(komponengaji_id) AS totalcolumn FROM komponengaji_m WHERE ispotongan=TRUE and komponengaji_aktif = true')->queryAll();
			} else if ($potongan=='gaji') {
				$total = Yii::app()->db->createCommand('SELECT COUNT(komponengaji_id) AS totalcolumn FROM komponengaji_m WHERE ispotongan=FALSE and komponengaji_aktif = true')->queryAll();
			}
                
                return $total[0]['totalcolumn'];
        }
        
        public function getColumnKomponen($potongan)
        {
			$column='';
			if ($potongan=='potongan') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=TRUE and komponengaji_aktif = true");
			} else if ($potongan=='gaji') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=FALSE and komponengaji_aktif = true");
			}
			foreach ($modKomponengaji as $komponengaji)
			{
				$column .= "<th id='childcolumn'>$komponengaji->komponengaji_nama</th>";
			}
            
            return $column;
        }
        
        public function getValueKomponen($potongan, $penggajianpeg_id)
        {
			$column='';
			if ($potongan=='potongan') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=TRUE and komponengaji_aktif = true");
			} else if ($potongan=='gaji') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=FALSE and komponengaji_aktif = true");
			}
			foreach ($modKomponengaji as $key => $komponengaji)
			{
				$komponengaji_id = $komponengaji->komponengaji_id;
                $total_komponen = $this->getValue($komponengaji_id, $penggajianpeg_id);
				$column .= "<td>".((isset($_GET['caraPrint']) && $_GET['caraPrint'] == 'EXCEL') ? $total_komponen : MyFormatter::formatNumberForPrint($total_komponen))."</td>";
			}
            
            return $column;
        }
        
        public function getValue($komponengaji_id, $penggajianpeg_id)
        {
			$jumlah = 0;
			if((!empty($komponengaji_id))&&(!empty($penggajianpeg_id))){
				$kom = PenggajiankompT::model()->findByAttributes(array(
                    'komponengaji_id'=>$komponengaji_id,
                    'penggajianpeg_id'=>$penggajianpeg_id
                ));
                
                if (!empty($kom))
                    $jumlah = $kom->jumlah;
			}
            return $jumlah;
        }
        
        public function getFooterKomponen($potongan)
        {
			$column = '';
			if ($potongan=='potongan') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=TRUE and komponengaji_aktif = true");
			} else if ($potongan=='gaji') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=FALSE and komponengaji_aktif = true");
			}
			foreach ($modKomponengaji as $komponengaji)
			{
				$sql = Yii::app()->db->createCommand(
						"SELECT SUM(jumlah) AS totalkomponen
						FROM penggajiankomp_t, penggajianpeg_t
						WHERE
							komponengaji_id=$komponengaji->komponengaji_id
							AND
							penggajianpeg_t.tglpenggajian::date = '$this->tglpenggajian'
							AND
							penggajianpeg_t.penggajianpeg_id=penggajiankomp_t.penggajianpeg_id"
				)->queryAll();
				$totalkomponen = $sql[0]['totalkomponen'];
				$komponengaji_id = $komponengaji->komponengaji_id;
                
                if (empty($totalkomponen))
                    $totalkomponen = 0;
                
				$column .= "<td>".((isset($_GET['caraPrint']) && $_GET['caraPrint'] == 'EXCEL') ? $totalkomponen : MyFormatter::formatNumberForPrint($totalkomponen))."</td>";
			}
            
            return $column;
        }
        
        public function getJabatanItems()
        {
            return JabatanM::model()->findAll('jabatan_aktif=TRUE ORDER BY jabatan_nama');
        }

        public function getUnitKerjaItems()
        {
            return UnitkerjaM::model()->findAll('unitkerja_aktif=TRUE ORDER BY namaunitkerja');
        }
        
        public function getTotalgaji()
        {
			$totalgajipokok = 0;
            $modPenggajian = GJPenggajianpegT::model()->findAll($this->criteriaLaporan());
            foreach ($modPenggajian as $dataPenggajian)
            {
                $totalgajipokok += $dataPenggajian->totalterima;
            }
            
            return number_format($totalgajipokok,0,"",".");
        }
        
        public function searchLaporanSelisihGaji() {
            
            $tgl_awal = new DateTime($this->bln_awal."-01");
            $tgl_akhir = new DateTime(date('Y-m-t', strtotime($this->bln_akhir."-01")));
            
            $interval = new DateInterval("P1M");
            
            $periode = new DatePeriod($tgl_awal, $interval, $tgl_akhir);
            
            $res_periode = array();
            foreach($periode as $item) {
                $res_periode[] = $item->format("Y-m-01");
            }
            
            
            $criteria = new CDbCriteria();
            $criteria->join = "join pegawai_m pegawai on pegawai.pegawai_id = t.pegawai_id";
            $criteria->compare("t.periodegaji", $res_periode);
            $criteria->compare('t.tglpenggajian::date',$this->tglpenggajian);
            $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('pegawai.jabatan_id',$this->jabatan_id);
            $criteria->compare('pegawai.unitkerja_id',$this->unitkerja_id);
            
            $criteria2 = clone $criteria;
            
            $prov = new CActiveDataProvider($this, array('criteria'=>$criteria2, 'sort'=>array(
                'defaultOrder'=>"pegawai.nama_pegawai, t.periodegaji",
            )));
            $prov->pagination = false;
            
            
            $criteria->join .= " join penggajiankomp_t k on k.penggajianpeg_id = t.penggajianpeg_id"
                    . " join komponengaji_m kk on kk.komponengaji_id = k.komponengaji_id";
            
            
            $criteria->group = $criteria->select = "k.komponengaji_id, kk.nourutgaji, kk.komponengaji_nama, kk.ispotongan";
            $criteria->order = "kk.nourutgaji, kk.komponengaji_nama, kk.ispotongan";
            $komponen = self::model()->findAll($criteria);
            
            $res_kom = $komponen;
            
            $res_final = array();
            foreach ($prov->data as $item) {
                
                $sub = array();
                
                foreach ($komponen as $item2) {
                    $sub[$item2->komponengaji_id] = array(
                        'potongan'=>$item2->ispotongan,
                        'nilai'=>0,
                    );
                }
                
                $komp = PenggajiankompT::model()->findAllByAttributes(array(
                    'penggajianpeg_id'=>$item->penggajianpeg_id,
                ));
                
                foreach ($komp as $item2) {
                    $sub[$item2->komponengaji_id]['nilai'] = $item2->jumlah;
                }
                
                $item->data_komponen = $sub;
                $res_final[] = $item;
            }
            
            return array(
                'prov' => new CArrayDataProvider($res_final, array(
                    'id'=>'penggajian_data',
                )),
                'komponen' => $res_kom,
                'periode' => $periode,
            );
            
            
            
            //var_dump($cr); die;
            
        }
        
        public function searchPrintLaporanSelisihGaji() {
            $prov_dat = $this->searchLaporanSelisihGaji();
            $prov_dat['prov']->pagination = false;
            
            var_dump($prov_dat['komponen']); die;
            
            /*
            foreach ($prov_dat['prov']->data as $item) {
                var_dump($item->attributes);
            }*/
            
            die;
            
        }
        
        public function getNilaiKomponenGajiDariKode($kode, $ispotongan=null) {
            $cr = new CDbCriteria;
            $cr->join = "join komponengaji_m k on k.komponengaji_id = t.komponengaji_id";
            $cr->compare('k.komponengaji_kode', $kode);
            $cr->compare('t.penggajianpeg_id', $this->penggajianpeg_id);
            
            if(isset($ispotongan) && !empty($ispotongan)){
                if($ispotongan){
                   $cr->addCondition('ispotongan = true'); 
                }
            }
            
            $komp = PenggajiankompT::model()->find($cr);
            
            return empty($komp) ? 0 : $komp->jumlah;
        }
        
}
?>
