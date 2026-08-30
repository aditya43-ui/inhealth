<?php

class RIRuangTindakan extends RuangTindakanT
{
	public $instalasi_id, $instalasi_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasiendirujukkeluarT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	public function searchDetail($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
		if(!empty($this->ruangtindakan_id)){
			$criteria->addCondition("ruangtindakan_id = ".$this->ruangtindakan_id);		
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);		
		}

		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);		
		}

		if(!empty($this->modul_id)){
			$criteria->addCondition("modul_id = ".$this->modul_id);		
		}

		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);		
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);		
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);		
		}
		$criteria->compare('LOWER(tglordertindakan)',strtolower($this->tglordertindakan),true);
		$criteria->compare('LOWER(asalpoliklinikorder_id)',strtolower($this->asalpoliklinikorder_id),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(catatan_dokter_konsul)',strtolower($this->catatan_dokter_konsul),true);
		$criteria->compare('LOWER(subjective)',strtolower($this->subjective),true);
		$criteria->compare('LOWER(objective)',strtolower($this->objective),true);
		$criteria->compare('LOWER(assessment)',strtolower($this->assessment),true);
		$criteria->compare('LOWER(planning)',strtolower($this->planning),true);
		$criteria->compare('LOWER(subjektif_jawaban)',strtolower($this->subjektif_jawaban),true);
		$criteria->compare('LOWER(objektif_jawaban)',strtolower($this->objektif_jawaban),true);
		$criteria->compare('LOWER(assesment_jawaban)',strtolower($this->assesment_jawaban),true);
		$criteria->compare('LOWER(planning_jawaban)',strtolower($this->planning_jawaban),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}        
	

    public function getDokterItems($ruangan_id=null, $instalasi_id = null){
        if (Yii::app()->user->getState('dokterruangan')==true){
            if(empty($ruangan_id && $instalasi_id))
                $ruangan_id = Yii::app()->user->getState('ruangan_id');
				$instalasi_id = Yii::app()->user->getState('instalasi_id');
            if(!empty($ruangan_id) && !empty($instalasi_id))
                return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id,'instalasi_id'=>$instalasi_id),array('order'=>'nama_pegawai'));
            else
                return array();
        }else{
            //criteria disamakan dengan dokter_v
            $criteria = new CDbCriteria();
            if(!empty($ruangan_id)){
                $criteria->addCondition("ruangan_id= ".$ruangan_id);			
            }

			if(!empty($instalasi_id)){
                $criteria->addCondition("instalasi_id= ".$instalasi_id);			
            }
            //$criteria->addCondition(" ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            $criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
            $criteria->addCondition("pegawai_aktif = TRUE");
            $criteria->order = 'nama_pegawai';
            return PegawaiM::model()->findAll($criteria);
        }
    }
    

		/**
         * Mengambil daftar semua ruangan 
         * @return CActiveDataProvider 
         */
        public function getRuanganInstalasi()
        {
			return RuanganM::model()->findAll();
        }

		public function riwayatTindakan($pendaftaran_id){
            $criteria=new CDbCriteria;
            
            $criteria->with = array('ruangasal','ruangtujuan');
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

		public function getRuanganInstalasiItems($idInstalasi,$kecuali=false,$idRuangan='')
        {
            $criteria = new CDbCriteria();
            if($kecuali)
                $criteria->addCondition('ruangan_id !='.Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'ruangan_nama';
            
            if(!empty($idRuangan))
                $idInstalasi = RuanganM::model()->findByPk($idRuangan)->instalasi_id;
            
            if(!empty($idInstalasi))
                return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$idInstalasi,'ruangan_aktif'=>true),$criteria);
            else
                return RuanganM::model()->findAllByAttributes(array('ruangan_id'=>$this->asalpoliklinikorder_id));
        }
}
?>
