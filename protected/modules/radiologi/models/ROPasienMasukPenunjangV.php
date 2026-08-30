<?php
/**
 * model yang digunakan untuk mengakses view pasienmasukpenunjang_v, hanya untuk modul radiologi
 * 
 * @package application.modules.radiologi
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class ROPasienMasukPenunjangV extends PasienmasukpenunjangV
{
    public $bulan;
	public $perawat_id = null; //untuk tindakanpelayanan_t (analis lab)
	public $statushasil;
	public $ceklis = false;
    public $tgl_awall,$tgl_akhirl;
    
    public $tgl_awall2,$tgl_akhirl2;
    public $respondtime;

    public $tgl_pasiendatang, $is_verifikasi, $is_selesai, $jenis_pasien;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
 
    /**
     * pencarian pasien radiologi
     * @return \CActiveDataProvider
     */
    public function searchRAD()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;			
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
     

			if ($this->ceklis) {
			$criteria->addBetweenCondition('DATE(t.tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
			}
			
            if (!empty($this->statusperiksa)){
				$criteria->addCondition(" p.statusperiksa = '".$this->statusperiksa."' ");
			}
			
			if (!empty($this->nama_dokterasal)){
				if (is_array($this->nama_dokterasal)){
					$criteria->addInCondition(" t.nama_dokterasal ",$this->nama_dokterasal);
				}else{
					$criteria->addCondition(" t.nama_dokterasal = '".$this->nama_dokterasal."' ");
				}
			}
			
			if (!empty($this->ruanganasal_id)){
				if (is_array($this->ruanganasal_id)){
					$criteria->addInCondition(" t.ruanganasal_id ",$this->ruanganasal_id);
				}else{
					$criteria->addCondition(" t.ruanganasal_id = '".$this->ruanganasal_id."' ");
				}
			}
			
			if (!empty($this->instalasiasal_id)){
				if (is_array($this->instalasiasal_id)){
					$criteria->addInCondition(" t.instalasiasal_id ",$this->instalasiasal_id);
				}else{
					$criteria->addCondition(" t.instalasiasal_id = '".$this->instalasiasal_id."' ");
				}
			}
			
			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition(" t.carabayar_id ",$this->carabayar_id);
				}else{
					$criteria->addCondition(" t.carabayar_id = '".$this->carabayar_id."' ");
				}
			}
			
			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition(" t.penjamin_id ",$this->penjamin_id);
				}else{
					$criteria->addCondition(" t.penjamin_id = '".$this->penjamin_id."' ");
				}
			}

            if($this->is_selesai == 1) {
                $criteria->addCondition('t.is_selesai is true');
            } else if($this->is_selesai == 2) {
                $criteria->addCondition('t.is_selesai is false or t.is_selesai is null');
            }

            if($this->jenis_pasien == 'aps') {
                $criteria->addCondition('t.pasienkirimkeunitlain_id is null');
            } else  if($this->jenis_pasien == 'rujukan') {
                $criteria->addCondition('t.pasienkirimkeunitlain_id is not null');
            } 


            $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            $batal = "BATAL PERIKSA";
            $criteria->addCondition('t.statusperiksa <> \''.$batal.'\' or t.statusperiksa is null ');
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $this->tgl_awall2 = MyFormatter::formatDateTimeForDb($this->tgl_awall2);
            $this->tgl_akhirl2 = MyFormatter::formatDateTimeForDb($this->tgl_akhirl2);
            
            $criteria->addBetweenCondition('DATE(t.tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
            //  $criteria->addBetweenCondition('DATE(t.tgl_tindakan)', $this->tgl_awall2, $this->tgl_akhirl2);
			//$criteria->addCondition(" EXISTS (select statusperiksahasil from hasilpemeriksaanrad_t WHERE statusperiksahasil='' AND pasienmasukpenunjang_id = t.pasienmasukpenunjang_id) ");
//                $criteria->with=array('pasien','jeniskasuspenyakit','pendaftaran','jeniskasuspenyakit','pegawai','kelaspelayanan','ruangan','pasienadmisi','ruanganasal');
            //$criteria->order = "t.tglmasukpenunjang DESC"; //tgl masuk penunjang = tgl pendaftaran rad
            
            // echo '<pre>'; var_dump($criteria); die;
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'is_cyto desc, tgl_pendaftaran desc',
                )
            ));
    }

    /**
     * pencarian pemeiksaan
     * @return \CActiveDataProvider
     */
    public function searchPemeriksaan(){
        $criteria=new CDbCriteria;
        $criteria->addCondition('instalasiasal_id = '.Params::INSTALASI_ID_RAD);
        $criteria->order='tgl_pendaftaran DESC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));
    }

    /**
     * pencarian apsien radiologi, yang ditampilkan dalam bentuk dialog box
     * @return \CActiveDataProvider
     */
    public function searchDialogRAD()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
            $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
            $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

            $criteria->order = "t.tglmasukpenunjang DESC"; //tgl masuk penunjang = tgl pendaftaran rad
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }

        /**
         * mengenerate nama lengkap dokter
         * @param type $pegawai_id
         * @return type
         */
        public function getNamaLengkapDokter($pegawai_id)
        {
            $dokter = DokterV::model()->findByAttributes(array('pegawai_id'=>$pegawai_id));
            return empty($dokter) ? "" : ($dokter['gelardepan']." ".$dokter['nama_pegawai'].", ".$dokter['gelarbelakang_nama']);
        }
        
        /**
         * mengenerate nama pegawai
         * @param type $pegawai_id
         * @return string
         */
        public function getNamaPegawai($pegawai_id)
        {
            $dokter = PegawaiM::model()->findByAttributes(
                array('pegawai_id'=>$pegawai_id)
            );
            if (empty($dokter)) return "-";
            return $dokter->namaLengkap;
        }


      /**
         * Menghitung TAT
         * @param type $tgl_awal
         * @param type $tgl_akhir
         * @return type
         */
        public static function getTAT($tgl_awal, $tgl_akhir)
        {
            $tgl_awal = MyFormatter::formatDateTimeForDb($tgl_awal);
            $tgl_akhir = MyFormatter::formatDateTimeForDb($tgl_akhir);
            
            $start = new DateTime($tgl_awal);
            $end = new DateTime($tgl_akhir);

            $interval = $start->diff($end);

            $arr_itv = [];

            $tahun = $interval->y;
            $bulan = $interval->m;
            $hari = $interval->d;
            $jam = $interval->h;
            $menit = $interval->i;
            $detik = $interval->s;

            if($tahun > 0) {
                array_push($arr_itv, $tahun . " tahun");
            }

            if ($tahun > 0 || $bulan > 0) {
                array_push($arr_itv, $bulan . " bulan");
            }

            if ($tahun > 0 || $bulan > 0  || $hari > 0) {
                array_push($arr_itv, $hari . " hari");
            }

            if ($tahun > 0 || $bulan > 0  || $hari > 0 || $jam > 0) {
                array_push($arr_itv, $jam . " jam");
            }

            if ($tahun > 0 || $bulan > 0  || $hari > 0 || $jam > 0 || $menit > 0) {
                array_push($arr_itv, $menit . " menit");
            }

            array_push($arr_itv, $detik . " detik");

            return implode(" ", $arr_itv);          

        }
        
        /**
         * menampilkan data terakhir daftar
         */
        public function searchPendaftaranTerakhir()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//                $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);					
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);					
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);					
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);					
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addCondition("instalasiasal_id = ".$this->instalasiasal_id);					
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);					
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('DATE_PART(MONTH,tgl_pendaftaran)',($this->bulan));
                if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PENDAFTARAN){
                    if (!empty($this->ruangan_id)){
                        $criteria->addCondition('ruangan_id ='.$this->ruangan_id);
                    }
                }else{
                    $criteria->addCondition('ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
                }
		$criteria->compare('LOWER(nama_pegawai)',($this->nama_pegawai));
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->order = 'tgl_pendaftaran DESC';
                $criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
        
        /**
         * menampilkan dialog kunjungan
         */
        public function searchDialogKunjungan()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.
                $criteria=new CDbCriteria;
                $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(t.no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
                $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(t.instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
                $criteria->compare('LOWER(t.ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
                $criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
				if(!empty($this->carabayar_id)){
					$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);					
				}
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);					
				}
                $criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
				if(!empty($this->ruangan_id)){
					$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);					
				}
				if(!empty($this->ruanganasal_id)){
					$criteria->addCondition("t.ruanganasal_id = ".$this->ruanganasal_id);					
				}
				if(!empty($this->instalasiasal_id)){
					$criteria->addCondition("t.instalasiasal_id = ".$this->instalasiasal_id);					
				}
                $criteria->compare('LOWER(t.nama_pegawai)',($this->nama_pegawai));
                $criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(t.pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
                $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
                $criteria->order = 't.tglmasukpenunjang DESC';
                
                $criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
                $criteria->addCondition(" p.pasienbatalperiksa_id is null ");
                
                $criteria->limit = 10;
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        //'pagination'=>false,
                ));
        }

        /**
         * mengenerate nama model
         * @return system
         */
        public function getNamaModel()
        {
            return __CLASS__;
        }
		
		/**
		 * perawat_id tindakanpelayanan_t yg sudah ada
		 */
		public function getPerawatId(){
			$loadTindakan = TindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$this->pasienmasukpenunjang_id),"perawat_id IS NOT NULL");
			if(isset($loadTindakan->perawat_id)){
				if(!empty($loadTindakan->perawat_id)){
					return $loadTindakan->perawat_id;
				}else{
					return null;
				}
			}else{
				return null;
			}
		}
        
                public function statusPemeriksaan($pasienmasukpenunjang_id) {
                    $hasil = '';
                    $status = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
                    if(!empty($status->statusperiksahasil)){
                        $hasil = $status->statusperiksahasil;
                    }
                    return $hasil;
                }        
                
                public function pengambilanHasil($pasienmasukpenunjang_id) {
                    $keteranganHasil = '-';
                    $status = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
                    if(!empty($status->tglpengambilanhasil)){
                       $keteranganHasil = "Pengambilan Hasil - ".$status->namapenerimahasil." - ".MyFormatter::formatDateTimeForUser($status->tglpengambilanhasil); 
                    }
                    else{
                        if(!empty($status->tindakanpelayanan_id)){
                            $tindakan = TindakanpelayananT::model()->findByPk($status->tindakanpelayanan_id);
                            if(!empty($tindakan->tindakansudahbayar_id)){
                                $keteranganHasil = '';
                            }
                            else{
                                $keteranganHasil = '(Belum Bayar)';
                            }
                        }
                    }
                    return $keteranganHasil;
                }

                /* mengatur status periksa lab
     * @param type $status
     * @param type $id
     * @param type $pasienmasukpenunjang_id
     * @return string
     */


     public function getKonsulPasien() {
        $model = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $this->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));

        if (!empty($model)) {
            return $model->konsulpoli_id;
        } else {
            return null;
        }
    }

     public function getKePoli()
     {
         $modelA = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $this->pendaftaran_id)); //, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')
         if (!empty($modelA)) {
             $modelB = RuanganM::model()->findByAttributes(array('ruangan_id' => $modelA->ruangan_id));
             // return '<br/>Pasien konsul dari ' .$modelA->konsulpoli_id;
             if (Yii::app()->user->getState('ruangan_id') != $modelA->ruangan_id) {
                 return '<br/><button class="btn nohover" name="yt1" style="color:#424242; background-color:#F0E68C">Pasien konsul ke ' . $modelB->ruangan_nama;
             } else {
                 return null;
             }
         } else {
             return null;
         }
     }
 
     public function getAsalRuangan()
     {
         $modelA = RuangTindakanT::model()->findByAttributes(array('pendaftaran_id' => $this->pendaftaran_id)); //, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')
         if (!empty($modelA)) {
             $modelB = RuanganM::model()->findByAttributes(array('ruangan_id' => $modelA->asalpoliklinikorder_id));
             // return '<br/>Pasien konsul dari ' .$modelA->konsulpoli_id;
             if (Yii::app()->user->getState('ruangan_id') != $modelA->asalpoliklinikorder_id) {
                 return '<br/><button class="btn nohover" name="yt1" style="color:#424242; background-color:#F0E68C">Pasien Tindakan dari ' . $modelB->ruangan_nama;
             } else {
                 return null;
             }
         } else {
             return null;
         }
     }

    public function getStatusRad($status,$id,$pasienmasukpenunjang_id){
        $pendaftaran = PendaftaranT::model()->findByPk($id);  
        $pasienmasukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id); 
        $modHasilPemeriksaan = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id)); 
        $selisih_periksa = 0;
        $selisih = time() - strtotime($pasienmasukpenunjang->tglmasukpenunjang);   
     
                $pulang = PasienpulangT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$id, 
                    'pasienbatalpulang_id' => null,
//                    'kondisikeluar_id'=>Params::KONDISIKELUAR_ID_RAWATINAP,
                   ));


                   if (!empty($pulang)) {  
                        $format = new MyFormatter();
                        $tgl_pulang = $format->formatDateTimeForDb($pulang->tglpasienpulang);
                        $selisih = time() - strtotime($tgl_pulang);
                    } 
                    
                    if ($selisih < 60) {
                        $selisih = $selisih."d";
                       }
                    else if ($selisih < 3600) {
                        $selisih = floor($selisih/60)."m";
                       }
                    else if ($selisih < (3600 * 24)) {
                        $selisih = floor($selisih/3600)."j";
                       }
                    else { 
                        $selisih = floor($selisih/(3600 * 24))."h";
                       }
 
            if(empty($pasienmasukpenunjang->pasienkirimkeunitlain_id)) {
                //$selisih_periksa = time() - strtotime($pasienmasukpenunjang->waktumulaiperiksa); 
                $selisih_periksa = 0;
                // untuk periksa pasien
                if ($selisih_periksa < 60) {
                        $selisih_periksa = $selisih_periksa."d";
                    }
                    else if ($selisih_periksa < 3600) {
                        $selisih_periksa = floor($selisih_periksa/60)."m";
                    }
                    else if ($selisih_periksa < (3600 * 24)) {
                        $selisih_periksa = floor($selisih_periksa/3600)."j";
                    }
                    else { 
                        $selisih_periksa = floor($selisih_periksa/(3600 * 24))."h";
                    } 
                // end 
            }else{ 
                //$selisih_periksa = time() - strtotime($pendaftaran->waktumulaiperiksa); 
                $selisih_periksa = 0;
                // untuk periksa pasien di ambil dari pendaftaran_t karena pasien rujukan dari modul lain
                if ($selisih_periksa < 60) {
                        $selisih_periksa = $selisih_periksa."d";
                    }
                    else if ($selisih_periksa < 3600) {
                        $selisih_periksa = floor($selisih_periksa/60)."m";
                    }
                    else if ($selisih_periksa < (3600 * 24)) {
                        $selisih_periksa = floor($selisih_periksa/3600)."j";
                    }
                    else { 
                        $selisih_periksa = floor($selisih_periksa/(3600 * 24))."h";
                    } 
                // end        
            } 
              
                    
             $status = $pasienmasukpenunjang->statusperiksa;
             if ($pasienmasukpenunjang->ruangan_id != $pendaftaran->ruangan_id) {
                 $status = $pendaftaran->statusperiksa;
             }
        
        
        $status = trim($status);
        $badge = '';
        if($status == "SEDANG PERIKSA"){
             //$badge = '<span class="badge badge-info pull-right badge-status">'.$selisih_periksa.'</span>';
             $status = '<button id="red" class="btn btn-gold nohover btn-status" name="yt1">'.$status.'</button>';
             $status = '<div class="button-status">'.$badge.$status.'</div>';
        }else if($status == "ANTRIAN"){
             //$badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
             $status = '<button id="green" class="btn btn-black nohover btn-status" name="yt1">'.$status.'</button>';
             $status = '<div class="button-status">'.$badge.$status.'</div>';
        }else if($status == "SUDAH PULANG"){
             $status = '<button id="blue" class="btn btn-green nohover btn-status" name="yt1">'.$status.'</button>';
        }else if($status == "SUDAH DI PERIKSA"){
             $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">'.$status.'</button>';
        }else if($status == "SEDANG DIRAWAT INAP"){
             $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$id));
             $selisih = ceil((time() - strtotime($admisi->tgladmisi)) / (3600 * 24))."h";
             //$badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
             $status = '<button id="orange" class="btn btn-purple nohover btn-status"  name="yt1">'.$status.'</button>';
             $status = '<div class="button-status">'.$badge.$status.'</div>';
        }else if($status == "MENUNGGU ADMISI PASIEN"){
             //$badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
             $status = '<button id="orange" class="btn btn-orange nohover btn-status"  name="yt1">'.$status.'</button>';
             $status = '<div class="button-status">'.$badge.$status.'</div>';
        }else{
             $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">'.$status.'</button>';
        }
        return $status;
    }

}
?>
