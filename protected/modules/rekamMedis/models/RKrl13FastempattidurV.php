<?php

class RKrl13FastempattidurV extends Rl13FastempattidurV {

    public $tgl_awal, $tgl_akhir;
    public $bln_awal, $bln_akhir;
    public $thn_awal, $thn_akhir;
    public $jns_periode;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
     public function getSumPelayanan($jeniskasuspenyakit_id, $kelaspelayanan_id, $instalasi_id = null){
         
            
            if (empty($instalasi_id)) {
            	$instalasi_id = Yii::app()->user->getState('instalasi_id');
            }
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
			$criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
			$criteria->addCondition('instalasi_id = '.$instalasi_id);
			$criteria->addCondition('jeniskasuspenyakit_id ='.$jeniskasuspenyakit_id);
			//TIDAK ADA KONDISI WAKTU ?
            $criteria->select = 'sum(jlmtt) AS jlmtt';
            $modTarif = $this->find($criteria);
            if($modTarif){
				return $modTarif->jlmtt;
			}else{
				return "0";
			}
        }

        public function getSumTotal($kelaspelayanan_id, $instalasi_id = null){
          
            
            if (empty($instalasi_id)) {
            	$instalasi_id = Yii::app()->user->getState('instalasi_id');
            }

            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->select = 'sum(jlmtt) AS jlmtt';
			$criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
			$criteria->addCondition('instalasi_id = '.$instalasi_id);
			//TIDAK ADA KONDISI WAKTU ?
            $modTarif = $this->find($criteria);
			if($modTarif){
				return $modTarif->jlmtt;
			}else{
				return "0";
			}
        }
}