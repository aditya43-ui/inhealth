<?php

/**
 * This is the model class for table "pasienmasukpenunjang_v".
 *
 * The followings are the available columns in table 'pasienmasukpenunjang_v':
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $pendaftaran_id
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $keadaanmasuk
 * @property string $statuspasien
 * @property boolean $alihstatus
 * @property string $statusmasuk
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property integer $shift_id
 * @property integer $golonganumur_id
 * @property string $golonganumur_nama
 * @property string $no_rujukan
 * @property string $nama_perujuk
 * @property string $tanggal_rujukan
 * @property string $diagnosa_rujukan
 * @property integer $asalrujukan_id
 * @property string $asalrujukan_nama
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $hubungankeluarga
 * @property string $nama_pj
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $instalasiasal_id
 * @property string $instalasiasal_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $gelardokterasal
 * @property string $nama_dokterasal
 * @property string $gelarbelakang_nama
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $no_urutperiksa
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $pegawai_id
 */
class RMMasukPenunjangV extends PasienmasukpenunjangV
{
        public $ceklis = false; 
        public $statusperiksahasil='';
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienmasukpenunjangV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */	
        public function searchRM()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.


		$criteria=new CDbCriteria;
		
		if (!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		if (!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id ='.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if (!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if (!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if (!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if (!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
		}
		if (!empty($this->pekerjaan_id)){
			$criteria->addCondition('pekerjaan_id ='.$this->pekerjaan_id);
		}
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                
                if($this->ceklis)
                {
                    $criteria->addCondition('date(tglmasukpenunjang) BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
                }
                
		$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if (!empty($this->caramasuk_id)){
			$criteria->addCondition('caramasuk_id ='.$this->caramasuk_id);
		}
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		if (!empty($this->shift_id)){
			$criteria->addCondition('shift_id ='.$this->shift_id);
		}
		if (!empty($this->golonganumur_id)){
			$criteria->addCondition('golonganumur_id ='.$this->golonganumur_id);
		}
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
		$criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
		$criteria->compare('LOWER(tanggal_rujukan)',strtolower($this->tanggal_rujukan),true);
		$criteria->compare('LOWER(diagnosa_rujukan)',strtolower($this->diagnosa_rujukan),true);
		if (!empty($this->asalrujukan_id)){
			$criteria->addCondition('asalrujukan_id ='.$this->asalrujukan_id);
		}
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		if (!empty($this->penanggungjawab_id)){
			$criteria->addCondition('penanggungjawab_id ='.$this->penanggungjawab_id);
		}
		$criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		if (!empty($this->ruanganasal_id)){
			$criteria->addCondition('ruanganasal_id ='.$this->ruanganasal_id);
		}
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if (!empty($this->instalasiasal_id)){
			$criteria->addCondition('instalasiasal_id ='.$this->instalasiasal_id);
		}
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		if (!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id ='.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(gelardokterasal)',strtolower($this->gelardokterasal),true);
		$criteria->compare('LOWER(nama_dokterasal)',strtolower($this->nama_dokterasal),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$ruangan_id = Yii::app()->user->getState('ruangan_id');
		if (!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if (!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id ='.$this->pasienadmisi_id);
		}
		if (!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id ='.$this->pasienmasukpenunjang_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if (!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id ='.$this->pegawai_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Mengambil daftar semua dokter ruangan
         * @return CActiveDataProvider 
         */
        public function getDokterItems()
        {
            return DokterV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id')),array('order'=>'nama_pegawai'));
        }
        
        /**
         * mengenerate kamar kosong
         * @param type $ruangan_id
         * @return type
         */
        public function getKamarKosongItems($ruangan_id = '')
        {
            if(!empty($ruangan_id))
                return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
            else
                return array();
        }
        
        /**
         * mengenerate data paramedis
         * @param type $ruangan_id
         * @return type
         */
        public function getParamedisItems($ruangan_id='')
        {
            if(!empty($ruangan_id))
                return ParamedisV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
            else
                return array();
        }

		public function getStatusDokumen($pengirimanrm_id,$status,$pendaftaran_id){
            //return $pengirimanrm_id." - ".$status." - ".$pendaftaran_id;
            
		$status_dokumen = '';
		$statusruangan = '';
		$tombol = '';
		$status_dok = $status;
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
		if(empty($status) && empty($pengirimanrm_id)){
			$status = Params::STATUSDOKRMKIRIM_BELUM;
		}else if(empty($status) || !empty($pengirimanrm_id)){
			$status = Params::STATUSDOKRMKIRIM_SUDAH;
		}
		// return $pengirimanrm_id;
		if(!empty($pengirimanrm_id)){
			$modPengiriman = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id),array('order'=>'pengirimanrm_id desc'));
			$ruanganpenerima_id = $modPengiriman->ruanganpenerima_id;
            
            // return $modPengiriman->pendaftaran_id." - ".$pendaftaran_id;
            
			if(count($modPengiriman) > 0){
				if(!empty($modPengiriman->ruangan_id) && $modPengiriman->ruanganpenerima_id == Yii::app()->user->getState('ruangan_id')){
					$statusruangan = " DARI ".strtoupper($modPengiriman->ruanganpengirim->ruangan_nama);
					$status = Params::STATUSDOKRMKIRIM_SUDAH.$statusruangan;
					$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="verifikasiKirimanRM('.$pendaftaran_id.','.$pengirimanrm_id.')">'.$status.'</button>';
					$tombol = "";
				}else if(!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id != Yii::app()->user->getState('ruangan_id')){
                                        if (!empty($modPengiriman->tglterimadokrm)) {
                                            $statusruangan = " OLEH ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
                                            $status = Params::STATUSDOKRMTERIMA_SUDAH.' '.$statusruangan;
                                            $func = 'return false;';
                                        } else {
                                            $statusruangan = " KE- ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
                                            $status = Params::STATUSDOKRMKIRIM_SUDAH.$statusruangan;
                                            $func = 'setPenerimaan(this,'.$pengirimanrm_id.','.$ruanganpenerima_id.',\''.$status_dok.'\','.$pendaftaran_id.')';
                                        }
					$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="'.$func.'">'.$status.'</button>';
				} //else if (!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id == Yii::app()->user->getState('ruangan_id') && !empty($modPengiriman->tglterimadokrm)) {
                                 //       $statusruangan = " DARI ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
				//	$status = 'SUDAH DITERIMA'.$statusruangan;
                                //        $status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="return false;">'.$status.'</button>';
                                //}
			}
		}
		
		if(count($modPendaftaran) > 0){
			if(!empty($modPendaftaran->pengirimanrm_id)){
//				$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="setStatusDokumen(this,'.$pengirimanrm_id.',\''.$status.'\','.$pendaftaran_id.')">'.$status.'</button>';
				$status_dokumen = $status_dokumen;
			}else{
				$status_dokumen = '<button id="green" class="btn btn-danger" name="yt1">'.$status.'</button>';
			}
		}		
		return $status_dokumen;
   }
                
}