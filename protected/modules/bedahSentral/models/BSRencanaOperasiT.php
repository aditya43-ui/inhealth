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
	public $dokterresusitasi_id, $tglkirimpasien, $estimasioperasi, $ruangan_id, $persentase_dokteroperator, $persentase_dokteranestesi, $persentasi_tarif;
	public $kamarruangan1_id;
        
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
            return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id'=>$kelaspelayanan_id,'ruangan_id'=>Params::RUANGAN_ID_BEDAH, 'kamarruangan_aktif'=>true), array('order'=>'kamarruangan_id ASC'));
        else
            return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>Params::RUANGAN_ID_BEDAH, 'kamarruangan_aktif'=>true), array('order'=>'kamarruangan_id ASC'));
    }

    public function getKamarKosongItemsRujukanBS($kelaspelayanan_id = null)
    {
		$ruangan = Yii::app()->user->getState('ruangan_id');

		$cd_ruangan = "(57, 59)";

		if($ruangan == 57) {
			$cd_ruangan = "(57)";
		} else if($ruangan_id == 59) {
			$cd_ruangan = "(59)";
		}
        if(!empty($kelaspelayanan_id))
            return $kamarKosong = KamarruanganM::model()->findAll('kelaspelayanan_id = ' . $kelaspelayanan_id . ' and ruangan_id = ' . Params::RUANGAN_ID_BEDAH . ' and kamarruangan_status = true and kamarruangan_aktif is = true and ruangan_id in ' . $cd_ruangan . ' order by kamarruangan_nobed ASC');
        else
		return $kamarKosong = KamarruanganM::model()->findAll('ruangan_id = ' . Params::RUANGAN_ID_BEDAH . ' and kamarruangan_status = true and kamarruangan_aktif is true and ruangan_id in ' . $cd_ruangan . ' order by kamarruangan_nobed ASC');
    }

    public function getDokterItems($ruangan_id='')
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
                        ));//, 'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN
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

	public function getOperatorItems($ruangan_id=null){
		$criteria = new CDbCriteria();
		$criteria->addInCondition('t.kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
		$criteria->addCondition("t.pegawai_aktif = TRUE");
		$criteria->join = "join ruanganpegawai_m r on r.pegawai_id = t.pegawai_id";
		if (!empty($ruangan_id)) {
			$criteria->compare('r.ruangan_id', $ruangan_id);
		} else {
			$criteria->compare('r.ruangan_id', Yii::app()->user->getState('ruangan_id'));
		}

		$criteria->order = 't.nama_pegawai';
		return PegawaiM::model()->findAll($criteria);
	}
        
}
?>
