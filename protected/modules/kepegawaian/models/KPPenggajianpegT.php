<?php

class KPPenggajianpegT extends PenggajianpegT
{    
        public static function model($className = __CLASS__) {
            return parent::model($className);
        }
        
        public $tgl_awal, $tgl_akhir, $nama_pegawai, $jabatan_id;
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
                        
                        'tgl_awal'=>'Tanggal Penggajian',
                        'tgl_akhir'=>'Sampai dengan',
                        'jabatan_id'=>'Jabatan',
                );
        }
        
        public function searchInfo() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;
            $criteria->with = 'pegawai';
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('tglpenggajian', $this->tgl_awal, $this->tgl_akhir);
            }
            $criteria->compare('tglpenggajian::date', $this->tglpenggajian);
            $criteria->compare('LOWER(pegawai.nama_pegawai)', strtolower($this->nama_pegawai), true);

            $criteria->addCondition('tgl_mengetahui is not null');
            $criteria->addCondition('tgl_menyetujui is not null');

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }

    public function criteriaLaporan()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->with = 'pegawai';
                $criteria->addBetweenCondition('tglpenggajian',$this->tgl_awal,$this->tgl_akhir);
                $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('pegawai.jabatan_id',$this->jabatan_id);
                
                return $criteria;
        }
		
		public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
			$criteria->with = 'pegawai';
			if(!empty($this->nomorindukpegawai)){
				$criteria->compare("LOWER(pegawai.nomorindukpegawai)",strtolower($this->nomorindukpegawai),true);
			}
			if(!empty($this->nama_pegawai)){
				$criteria->compare("LOWER(pegawai.nama_pegawai)",strtolower($this->nama_pegawai),true);
			}
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchLaporan()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteriaLaporan(),
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
				$total = Yii::app()->db->createCommand('SELECT COUNT(komponengaji_id) AS totalcolumn FROM komponengaji_m WHERE ispotongan=TRUE')->queryAll();
			} else if ($potongan=='gaji') {
				$total = Yii::app()->db->createCommand('SELECT COUNT(komponengaji_id) AS totalcolumn FROM komponengaji_m WHERE ispotongan=FALSE')->queryAll();
			}
                
                return $total[0]['totalcolumn'];
        }
        
        public function getColumnKomponen($potongan)
        {
			$column='';
			if ($potongan=='potongan') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=TRUE");
			} else if ($potongan=='gaji') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=FALSE");
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
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=TRUE");
			} else if ($potongan=='gaji') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=FALSE");
			}
			foreach ($modKomponengaji as $key => $komponengaji)
			{
				$komponengaji_id = $komponengaji->komponengaji_id;
				$column .= "<td>".$this->getValue($komponengaji_id, $penggajianpeg_id)."</td>";
			}
            
            return $column;
        }
        
        public function getValue($komponengaji_id, $penggajianpeg_id)
        {
			$jumlah = 0;
			if((!empty($komponengaji_id))&&(!empty($penggajianpeg_id))){
				$query = Yii::app()->db->createCommand(
						"SELECT jumlah
						FROM penggajiankomp_t
						WHERE
							komponengaji_id=11
							AND
							penggajianpeg_id=12"
				)->queryAll();
				if(!empty($jumlah)){
					$jumlah = number_format($query[0]['jumlah'],0,"",".");
				}
			}
            return $jumlah;
        }
        
        public function getFooterKomponen($potongan)
        {
			$column = '';
			if ($potongan=='potongan') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=TRUE");
			} else if ($potongan=='gaji') {
				$modKomponengaji = KomponengajiM::model()->findAll("ispotongan=FALSE");
			}
			foreach ($modKomponengaji as $komponengaji)
			{
				$sql = Yii::app()->db->createCommand(
						"SELECT SUM(jumlah) AS totalkomponen
						FROM penggajiankomp_t, penggajianpeg_t
						WHERE
							komponengaji_id=$komponengaji->komponengaji_id
							AND
							penggajianpeg_t.tglpenggajian BETWEEN '$this->tgl_awal' AND '$this->tgl_akhir'
							AND
							penggajianpeg_t.penggajianpeg_id=penggajiankomp_t.penggajianpeg_id"
				)->queryAll();
				$totalkomponen = $sql[0]['totalkomponen'];
				$komponengaji_id = $komponengaji->komponengaji_id;
				$column .= "<td>".number_format($totalkomponen,0,'','.')."</td>";
			}
            
            return $column;
        }
        
        public function getJabatanItems()
        {
            return JabatanM::model()->findAll('jabatan_aktif=TRUE ORDER BY jabatan_nama');
        }
        
        public function getTotalgaji()
        {
			$totalgajipokok = 0;
            $modPenggajian = PenggajianpegT::model()->findAll($this->criteriaLaporan());
            foreach ($modPenggajian as $dataPenggajian)
            {
                $totalgajipokok += $dataPenggajian->totalterima;
            }
            
            return number_format($totalgajipokok,0,"",".");
        }
        
        public function thr($id) {
            $jmlThr = 0;
            $kom = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id'=>$id, 'komponengaji_id'=>101));
            if(!empty($kom)){
                $jmlThr = $kom->jumlah;
            }
            return $jmlThr;
        }
        
        public function bonus($id) {
            $jml = 0;
//            $kom = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id'=>$id, 'komponengaji_id'=>103));
            $kom = PenggajiankompT::model()->findAll(" penggajianpeg_id=".$id." AND (komponengaji_id = 103 OR komponengaji_id = 106 OR komponengaji_id = 107 OR komponengaji_id = 108)");
            if(!empty($kom)){
                foreach ($kom as $key => $val) {
                    $jml += $val->jumlah;
                }
            }
            return $jml;
        }
        
        public function fungsional($id) {
            $jml = 0;
            $kom = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id'=>$id, 'komponengaji_id'=>4)); //"Tunjangan Fungsional"
            if(!empty($kom)){
                $jml = $kom->jumlah;
            }
            $kom2 = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id'=>$id, 'komponengaji_id'=>2)); //"Tunjangan Jabatan"
            if(!empty($kom2)){
                $jml += $kom2->jumlah;
            }
            return $jml;
        }
        
        public function lembur($id) {
            $jml = 0;
            $kom = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id'=>$id, 'komponengaji_id'=>102));
            if(!empty($kom)){
                $jml = $kom->jumlah;
            }
            return $jml;
        }
}
?>
