<?php

class BSRencanaOperasiT extends RencanaoperasiT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RencanaoperasiT the static model class
     */
    public $pasienanastesi;
    public $jenistarif_id,$tarif_tindakan,$daftartindakan_id,$qty_tindakan,$satuantindakan,$tarif_satuan,$operasi_nama;
	public $persencyto_tind,$tarif_cyto,$cyto_tindakan; //untuk cyto di rencana operasi (tabel rencana operasi)
    public $pegmengetahui_nama, $ppds_id, $ppds_nama;
	public $dokterresusitasi_id, $tglkirimpasien, $estimasioperasi, $ruangan_id;
        
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('pasien','pendaftaran');
		$criteria->addBetweenCondition('date(tglrencanaoperasi)',$this->tgl_awal, $this->tgl_akhir,true);
		
		if(!empty($this->rencanaoperasi_id)){
			$criteria->addCondition('rencanaoperasi_id = '.$this->rencanaoperasi_id);
		}
		if(!empty($this->operasi_id)){
			$criteria->addCondition('operasi_id = '.$this->operasi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(norencanaoperasi)',strtolower($this->norencanaoperasi),true);
		$criteria->compare('LOWER(mulaioperasi)',strtolower($this->mulaioperasi),true);
		$criteria->compare('LOWER(selesaioperasi)',strtolower($this->selesaioperasi),true);
		$criteria->compare('LOWER(statusoperasi)',strtolower($this->statusoperasi),true);
		$criteria->compare('LOWER(dokterpelaksana1_id)',strtolower($this->dokterpelaksana1_id),true);
		$criteria->compare('LOWER(dokterpelaksana2_id)',strtolower($this->dokterpelaksana2_id),true);
		$criteria->compare('LOWER(dokteranastesi_id)',strtolower($this->dokteranastesi_id),true);
		$criteria->compare('LOWER(dokterresusitasi_id)',strtolower($this->dokterresusitasi_id),true);
		$criteria->compare('LOWER(dokterdelegasi_id)',strtolower($this->dokterdelegasi_id),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(suster_id)',strtolower($this->suster_id),true);
		$criteria->compare('LOWER(perawat_id)',strtolower($this->perawat_id),true);
		$criteria->compare('LOWER(keterangan_rencana)',strtolower($this->keterangan_rencana),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->order='tglrencanaoperasi DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchTabel(){
		$criteria = new CDbCriteria;
		$criteria->compare('DATE(selesaioperasi)',$this->selesaioperasi);
		$criteria->order = 'selesaioperasi DESC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

    public function getKamarKosongItems($kelaspelayanan_id = null)
    {
        if(!empty($kelaspelayanan_id))
            return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id'=>$kelaspelayanan_id,'ruangan_id'=>Params::RUANGAN_ID_BEDAH,'kamarruangan_status'=>true, 'kamarruangan_aktif'=>true));
        else
            return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>Params::RUANGAN_ID_BEDAH,'kamarruangan_status'=>true, 'kamarruangan_aktif'=>true));
    }
    public function getDokterItems($ruangan_id='')
    {
        if(!empty($ruangan_id)):
			if($ruangan_id == Params::RUANGAN_ID_BEDAH ){
				return PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
					'order'=>'nama_pegawai',
				));
			} else{
				return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id, 'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK), array(
					'order'=>'nama_pegawai',
				));
			}
            
        else:
            return DokterV::model()->findAll('pegawai_id is not null limit 10');
        endif;
    }


    public function getDokterItems3($ruangan_id='')
    {
        if(!empty($ruangan_id)):
			if($ruangan_id == Params::RUANGAN_ID_BEDAH ){
				return PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
					'order'=>'nama_pegawai',
				));
			} else{
				return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
					'order'=>'nama_pegawai',
				));
			}
            
        else:
            return DokterV::model()->findAll('pegawai_id is not null limit 10');
        endif;
    }


	public function getDokterItems2($ruangan_id='')
    {
        if(!empty($ruangan_id)):
			if($ruangan_id == Params::RUANGAN_ID_BEDAH ){
				return PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id, 'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK), array(
					'order'=>'nama_pegawai',
				));
			} else{
				return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id, 'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK), array(
					'order'=>'nama_pegawai',
				));
			}
            
        else:
            return DokterV::model()->findAll('pegawai_id is not null limit 10');
        endif;
    }
    
    public function getDokterParamedisItems($ruangan_id='')
    {
        if(!empty($ruangan_id)):
            $dokter = new CDbCriteria;
            $dokter->with = array('pegawai');
            $dokter->addCondition("t.ruangan_id = '$ruangan_id' ");
            //$dokter->addCondition("pegawai.kelompokpegawai_id IN (".Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.", ".Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN.")");            
			$dokter->addCondition("pegawai.kelompokpegawai_id IN (".Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.")");            
           
			$dokter->order = "kelompokpegawai_id ASC, pegawai.nama_pegawai ASC";
             
            return RuanganpegawaiM::model()->findAll($dokter);
            //return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
              //  'order'=>'nama_pegawai',
            //));
        else:
            return array();
        endif;
    }
    
	public function getParamedisItems($ruangan_id='')
	{
		if(!empty($ruangan_id)):
			return ParamedisV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
                            'order'=>'nama_pegawai',
							
                        ));//
		else:
			return array();
                endif;
	}

	public function getPPDS(){
							
		return PpdsM::model()->findAllByAttributes(array('ppds_aktif'=>true),array('order'=>'ppds_nama ASC'));
	}

	
	public function getBidanItems($ruangan_id='')
	{
		if(!empty($ruangan_id))
			return PegawaiM::model()->findAllByAttributes(array('kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_BIDAN), array(
                            'order'=>'nama_pegawai',
                        ));
		else
			return array();
	}
        
        
}
?>
