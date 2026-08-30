<?php

class GZInfopasienmasukkamarV extends InfopasienmasukkamarV
{
    public $default; 
	public $ceklis;
	public $AlergiObat;
	public $PindahanDari;
	public $tgl_awall;
	public $tgl_akhirl;
	public  $prefix_pendaftaran;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienrawatinapV the static model class
     */
   
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchRI()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        
		$criteria=new CDbCriteria;
		
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id); 	
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
                $criteria->compare('kamarruangan_id', $this->kamarruangan_id);
                // $criteria->limit = 5;

				//if($this->ceklis == 1)
		//{
			//$criteria->addBetweenCondition('tgladmisi::date',$this->tgl_awal,$this->tgl_akhir);
		//}
		$criteria->addCondition('is_konsul is false');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5),
			
		));
	}
        
	     
	public function getStatusDokumen($pengirimanrm_id,$status,$pendaftaran_id){
		//return $pengirimanrm_id." - ".$status." - ".$pendaftaran_id;
		
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
		
		// return $modPengiriman->pendaftaran_id." - ".$pendaftaran_id;
		
		if(!empty($modPengiriman)){
			$ruanganpenerima_id = $modPengiriman->ruanganpenerima_id;
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
										$statusruangan = " KE- ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
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
?>
