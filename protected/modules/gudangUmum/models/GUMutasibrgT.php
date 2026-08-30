<?php

class GUMutasibrgT extends MutasibrgT {

    public $tgl_awal,$tgl_akhir;
     public $idPesanbarang;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getNamaModel() {
        return __CLASS__;
    }

    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('date(tglmutasibrg)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->mutasibrg_id)){
			$criteria->addCondition("mutasibrg_id = ".$this->mutasibrg_id);			
		}
		if(!empty($this->pesanbarang_id)){
			$criteria->addCondition("pesanbarang_id = ".$this->pesanbarang_id);			
		}
        $criteria->compare('LOWER(nomutasibrg)', strtolower($this->nomutasibrg), true);
        $criteria->compare('LOWER(keterangan_mutasi)', strtolower($this->keterangan_mutasi), true);
		if(!empty($this->pegpengirim_id)){
			$criteria->addCondition("pegpengirim_id = ".$this->pegpengirim_id);			
		}
        $criteria->compare('totalhargamutasi', $this->totalhargamutasi);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition("pegmengetahui_id = ".$this->pegmengetahui_id);			
		}
		// if(!empty($this->ruangantujuan_id) && trim($this->ruangantujuan_id) != ""){
		//	$criteria->addCondition("ruangantujuan_id = ".$this->ruangantujuan_id);			
		// }
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('ruangantujuan_id', $this->ruangantujuan_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
       // $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
      //  if(!empty($this->create_ruangan)){
        // $criteria->addCondition("create_ruangan = ".Yii::app()->user->getState('ruangan_id'));			
		//}
        
        
        
        $con_masuk = "ruangantujuan_id = ".Yii::app()->user->getState('ruangan_id');		
        $con_keluar = "create_ruangan = ".Yii::app()->user->getState('ruangan_id');	
        
        // pencarian mutasi masuk/keluar
        if ($this->masukkeluar == 1) { // mutasi keluar
            $criteria->addCondition($con_keluar);
        } else if ($this->masukkeluar == 2) { // mutasi masuk
            $criteria->addCondition($con_masuk);
        } else {
            $criteria->addCondition("(".$con_masuk." or ".$con_keluar.")");
        }
        
        $criteria->order = "tglmutasibrg DESC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchInformasiGudang() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('date(tglmutasibrg)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->mutasibrg_id)){
			$criteria->addCondition("mutasibrg_id = ".$this->mutasibrg_id);			
		}
		if(!empty($this->pesanbarang_id)){
			$criteria->addCondition("pesanbarang_id = ".$this->pesanbarang_id);			
		}
        $criteria->compare('LOWER(nomutasibrg)', strtolower($this->nomutasibrg), true);
        $criteria->compare('LOWER(keterangan_mutasi)', strtolower($this->keterangan_mutasi), true);
		if(!empty($this->pegpengirim_id)){
			$criteria->addCondition("pegpengirim_id = ".$this->pegpengirim_id);			
		}
        $criteria->compare('totalhargamutasi', $this->totalhargamutasi);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition("pegmengetahui_id = ".$this->pegmengetahui_id);			
		}
		if(!empty($this->ruangantujuan_id)){
			$criteria->addCondition("ruangantujuan_id = ".$this->ruangantujuan_id);			
		}
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        $criteria->order = "tglmutasibrg DESC";
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
     public function getPegawaiRuangan()
        {
            $cr = new CDbCriteria();
            $cr->addCondition(" ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            $cr->addCondition(" pegawai_aktif= TRUE ");
            $cr->order = "nama_pegawai ASC";
            
            return PegawairuanganV::model()->findAll($cr);
        }

}