<?php

class STPembersihanT extends PembersihanT
{
   public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchInformasi() {
                $criteria=new CDbCriteria;
                
                $criteria->addBetweenCondition('DATE(tgl_pembersihan)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pembersihan_id)){
			$criteria->addCondition('pembersihan_id = '.$this->pembersihan_id);
		}
		if(!empty($this->dekontaminasi_id)){
			$criteria->addCondition('dekontaminasi_id = '.$this->dekontaminasi_id);
		}
		$criteria->compare('LOWER(statusproses)',strtolower($this->statusproses),true);
		$criteria->compare('LOWER(programpembersihan)',strtolower($this->programpembersihan),true);
		if(!empty($this->namamesin_id)){
			$criteria->addCondition('namamesin_id = '.$this->namamesin_id);
		}
		$criteria->compare('LOWER(siklusmesin)',strtolower($this->siklusmesin),true);
		$criteria->compare('LOWER(mulaipembersiha)',strtolower($this->mulaipembersiha),true);
		$criteria->compare('LOWER(selesaipembersihan)',strtolower($this->selesaipembersihan),true);
		$criteria->compare('iscuciulang',$this->iscuciulang);
		if(!empty($this->cuciulang_id)){
			$criteria->addCondition('cuciulang_id = '.$this->cuciulang_id);
		}
		$criteria->compare('LOWER(ind_visual)',strtolower($this->ind_visual),true);
		$criteria->compare('LOWER(ind_kimia)',strtolower($this->ind_kimia),true);
		$criteria->compare('LOWER(ind_protein)',strtolower($this->ind_protein),true);
		$criteria->compare('LOWER(ind_character)',strtolower($this->ind_character),true);
		if(!empty($this->petugaspemb_id)){
			$criteria->addCondition('petugaspemb_id = '.$this->petugaspemb_id);
		}
		$criteria->compare('LOWER(statuspembersihan)',strtolower($this->statuspembersihan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
                
                $criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));      
        }
        
        public function getNoPenerimaan($id){
            $hasil='';
            if(isset($id)) {
                $modDekontaminasiDetail = DekontaminasidetailT::model()->findByAttributes(array('dekontaminasi_id'=>$id));
            if(isset($modDekontaminasiDetail)) {
                $modPenerimaan = PenerimaansterilisasiT::model()->findByPk($modDekontaminasiDetail->penerimaansterilisasi_id);
            
                if(isset($modPenerimaan)) {
                    $hasil = $modPenerimaan->penerimaansterilisasi_no;
                }
            }                
            }
            return $hasil;           
        }
}