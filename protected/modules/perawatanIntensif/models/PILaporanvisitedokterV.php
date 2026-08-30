<?php
class PILaporanvisitedokterV extends LaporanvisitedokterV
{
    public $tgl_awal, $tgl_akhir, $nursestation_id;
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function criteriaSearch() {
            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition('tgl_tindakan', $this->tgl_awal, $this->tgl_akhir);
            if($this->nursestation_id == 1 && Yii::app()->user->getState('nursestation_id') != null){ //RSKG-864
                $ruangan = array();
                $modNurseRuangan = NursestationruanganM::model()->findAll('nursestation_id='.Yii::app()->user->getState('nursestation_id'));
                if(count((array)$modNurseRuangan)>0){
                    foreach ($modNurseRuangan as $value) {
                        $ruangan[] = $value->ruangan_id;
                    }
                }
                $criteria->addInCondition('ruangan_id', $ruangan);
            }else{
                $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
            }
            return $criteria;
        }
        
    public function functionCriteriaDPJP(){
        $criteria = new CDbCriteria();
        $criteria = $this->criteriaSearch();
        $criteria->select = 'pegawai_id, dpjp';
        $criteria->group = 'pegawai_id, dpjp';
        return $criteria;
    }
    
     public function functionCriteriaPegawai(){
        $criteria = new CDbCriteria();
        $criteria = $this->criteriaSearch();
        $criteria->select = 'dokterpemeriksa1_id, nama_pegawai';
        $criteria->group = 'dokterpemeriksa1_id, nama_pegawai';
        return $criteria;
    }
    
    public function jumlahDpjp($pegawai_id=null, $penjamin_id, $dokterpemeriksa1_id=null) {
        $criteria = new CDbCriteria();
        $criteria = $this->criteriaSearch();
        $criteria->select = 'pasien_id';
        $criteria->group = 'pasien_id';
        if(!empty($pegawai_id)){
           $criteria->addCondition('pegawai_id = '.$pegawai_id); 
        }
        else{
            $criteria->addCondition('dokterpemeriksa1_id = '.$dokterpemeriksa1_id); 
        }
        
        $criteria->addCondition('penjamin_id = '.$penjamin_id);
        return $criteria;
    }
    public function jumlahVisite($pegawai_id=null, $penjamin_id, $kelompoktindakan_id, $dokterpemeriksa1_id=null) {
        $criteria = new CDbCriteria();
        $criteria = $this->criteriaSearch();
        $criteria->select = 'pasien_id';
        $criteria->group = 'pasien_id';
        if(!empty($pegawai_id)){
           $criteria->addCondition('pegawai_id = '.$pegawai_id); 
        }
        else{
            $criteria->addCondition('dokterpemeriksa1_id = '.$dokterpemeriksa1_id); 
        }
        $criteria->addCondition('penjamin_id = '.$penjamin_id);
        $criteria->addCondition('kelompoktindakan_id = '.$kelompoktindakan_id);
        return $criteria;
    }
    public function jumlahKonsul($pegawai_id=null, $kelompoktindakan_id, $dokterpemeriksa1_id=null) {
        $criteria = new CDbCriteria();
        $criteria = $this->criteriaSearch();
        $criteria->select = 'pasien_id';
        $criteria->group = 'pasien_id';
        if(!empty($pegawai_id)){
           $criteria->addCondition('pegawai_id = '.$pegawai_id); 
        }
        else{
            $criteria->addCondition('dokterpemeriksa1_id = '.$dokterpemeriksa1_id); 
        }
        $criteria->addCondition('kelompoktindakan_id = '.$kelompoktindakan_id);
        return $criteria;
    }
    
    
    
    
}
