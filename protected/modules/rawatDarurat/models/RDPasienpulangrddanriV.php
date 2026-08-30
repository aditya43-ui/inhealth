<?php


class RDPasienpulangrddanriV extends PasienpulangrddanriV
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienpulangrddanriV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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

		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);				
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
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);				
		}
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id);				
		}
		$criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
		}
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id);				
		}
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		if(!empty($this->pasienbatalpulang_id)){
			$criteria->addCondition("pasienbatalpulang_id = ".$this->pasienbatalpulang_id);				
		}
		if(!empty($this->rujukankeluar_id)){
			$criteria->addCondition("rujukankeluar_id = ".$this->rujukankeluar_id);				
		}
		$criteria->compare('LOWER(rumahsakitrujukan)',strtolower($this->rumahsakitrujukan),true);
		$criteria->compare('LOWER(alamatrsrujukan)',strtolower($this->alamatrsrujukan),true);
		$criteria->compare('LOWER(telp_fax)',strtolower($this->telp_fax),true);
		$criteria->compare('LOWER(nosuratrujukan)',strtolower($this->nosuratrujukan),true);
		$criteria->compare('LOWER(tgldirujuk)',strtolower($this->tgldirujuk),true);
		$criteria->compare('LOWER(kepadayth)',strtolower($this->kepadayth),true);
		$criteria->compare('LOWER(dirujukkebagian)',strtolower($this->dirujukkebagian),true);
		$criteria->compare('LOWER(alasandirujuk)',strtolower($this->alasandirujuk),true);
		$criteria->compare('LOWER(hasilpemeriksaan_ruj)',strtolower($this->hasilpemeriksaan_ruj),true);
		$criteria->compare('LOWER(diagnosasementara_ruj)',strtolower($this->diagnosasementara_ruj),true);
		$criteria->compare('LOWER(pengobatan_ruj)',strtolower($this->pengobatan_ruj),true);
		$criteria->compare('LOWER(lainlain_ruj)',strtolower($this->lainlain_ruj),true);
		$criteria->compare('LOWER(catatandokterperujuk)',strtolower($this->catatandokterperujuk),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public function searchRD()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.
                $criteria=new CDbCriteria;
                $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->prefix_pendaftaran.$this->no_pendaftaran),true);
                $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
                $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(t.keterangan_kamar)',strtolower($this->keterangan_kamar),true);
                $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                //if(($this->ceklis)==true){ 
                    $criteria->addBetweenCondition('DATE(t.tglpasienpulang)',$this->tgl_awal,$this->tgl_akhir);
                //}
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);				
				}
				if(!empty($this->carabayar_id)){
					$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);				
				}

                $criteria->join = "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
                $criteria->compare('p.pegawai_id', $this->pegawai_id);
                                
                return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
                    'sort'=>array(
                        'defaultOrder'=>'tglpasienpulang desc',
                    )
				));
        }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
				
				if(!empty($this->pasien_id)){
					$criteria->addCondition("pasien_id = ".$this->pasien_id);				
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
				if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
				}
				$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
				if(!empty($this->pendaftaran_id)){
					$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
				}
				$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
				$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
				$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
				$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
				$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
				$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
				$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
				$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
				$criteria->compare('alihstatus',$this->alihstatus);
				$criteria->compare('byphone',$this->byphone);
				$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
				$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
				$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
				$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
				$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
				$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
				if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
				}
				$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
				}
				$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
				if(!empty($this->shift_id)){
					$criteria->addCondition("shift_id = ".$this->shift_id);				
				}
				if(!empty($this->penanggungjawab_id)){
					$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id);				
				}
				$criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
				$criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
				$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
				if(!empty($this->ruangan_id)){
					$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
				}
				$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
				if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
				}
				$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
				if(!empty($this->jeniskasuspenyakit_id)){
					$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
				}
				$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
				if(!empty($this->rujukan_id)){
					$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
				}
				$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
				$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
				if(!empty($this->pasienpulang_id)){
					$criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id);				
				}
				$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
				$criteria->compare('lamarawat',$this->lamarawat);
				$criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
				$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
				$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
				$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
				$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
				$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
				$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
				if(!empty($this->pasienbatalpulang_id)){
					$criteria->addCondition("pasienbatalpulang_id = ".$this->pasienbatalpulang_id);				
				}
				if(!empty($this->rujukankeluar_id)){
					$criteria->addCondition("rujukankeluar_id = ".$this->rujukankeluar_id);				
				}
				$criteria->compare('LOWER(rumahsakitrujukan)',strtolower($this->rumahsakitrujukan),true);
				$criteria->compare('LOWER(alamatrsrujukan)',strtolower($this->alamatrsrujukan),true);
				$criteria->compare('LOWER(telp_fax)',strtolower($this->telp_fax),true);
				$criteria->compare('LOWER(nosuratrujukan)',strtolower($this->nosuratrujukan),true);
				$criteria->compare('LOWER(tgldirujuk)',strtolower($this->tgldirujuk),true);
				$criteria->compare('LOWER(kepadayth)',strtolower($this->kepadayth),true);
				$criteria->compare('LOWER(dirujukkebagian)',strtolower($this->dirujukkebagian),true);
				$criteria->compare('LOWER(alasandirujuk)',strtolower($this->alasandirujuk),true);
				$criteria->compare('LOWER(hasilpemeriksaan_ruj)',strtolower($this->hasilpemeriksaan_ruj),true);
				$criteria->compare('LOWER(diagnosasementara_ruj)',strtolower($this->diagnosasementara_ruj),true);
				$criteria->compare('LOWER(pengobatan_ruj)',strtolower($this->pengobatan_ruj),true);
				$criteria->compare('LOWER(lainlain_ruj)',strtolower($this->lainlain_ruj),true);
				$criteria->compare('LOWER(catatandokterperujuk)',strtolower($this->catatandokterperujuk),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        public function getKelasPelayanan(){
            $modPendaftaran= PendaftaranT::model()->findByPk($this->pendaftaran_id);
            $model=  KelaspelayananM::model()->findByPK($modPendaftaran->kelaspelayanan_id);
            if (!empty($model)){
                return $model->kelaspelayanan_nama;
            }else{
                return Null;
                
            }
        }
		
		public function getStatusDokumen($pengirimanrm_id,$status,$pendaftaran_id){
			$status_dokumen = '';
			$statusruangan = '';
			$tombol = '';
			$status_dok = $status;
			$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
			if(empty($status) && empty($pengirimanrm_id)){
					$status = 'BELUM DIKIRIM';
			}else if(empty($status) || !empty($pengirimanrm_id)){
					$status = 'SUDAH DIKIRIM';
			}
			// return $pengirimanrm_id;
			if(!empty($pengirimanrm_id)){
					$modPengiriman = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id),array('order'=>'pengirimanrm_id desc'));
					$ruanganpenerima_id = $modPengiriman->ruanganpenerima_id;
					if(!empty($modPengiriman)){
							if(!empty($modPengiriman->ruangan_id) && $modPengiriman->ruanganpenerima_id == Yii::app()->user->getState('ruangan_id')){
									$statusruangan = " DARI ".strtoupper($modPengiriman->ruanganpengirim->ruangan_nama);
									$status = 'SUDAH DIKIRIM'.$statusruangan;
									$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="verifikasiKirimanRM('.$pendaftaran_id.','.$pengirimanrm_id.')">'.$status.'</button>';
									$tombol = "";
							}else if(!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id != Yii::app()->user->getState('ruangan_id')){
									if (!empty($modPengiriman->tglterimadokrm)) {
										$statusruangan = " OLEH ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
										$status = 'SUDAH DITERIMA '.$statusruangan;
										$func = 'return false;';
									} else {
										$statusruangan = " KE ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
										$status = 'SUDAH DIKIRIM'.$statusruangan;
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

			if(!empty($modPendaftaran)){
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