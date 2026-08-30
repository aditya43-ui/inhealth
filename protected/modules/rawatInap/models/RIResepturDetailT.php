<?php

class RIResepturDetailT extends ResepturdetailT
{
	public $jmlstok,$therapiobat_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function searchDetailTerapi($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
//            var_dump(array($data));exit;
		$criteria=new CDbCriteria;

		$criteria->with = array('obatalkes');
		
		if(!empty($this->resepturdetail_id)){
			$criteria->addCondition("resepturdetail_id = ".$this->resepturdetail_id); 	
		}
		if(!empty($data)){
			$criteria->addCondition("reseptur_id = ".$data); 	
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id); 	
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id); 	
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id); 	
		}
		if(!empty($this->racikan_id)){
			$criteria->addCondition("racikan_id = ".$this->racikan_id); 	
		}
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_reseptur',$this->permintaan_reseptur);
		$criteria->compare('jmlkemasan_reseptur',$this->jmlkemasan_reseptur);
		$criteria->compare('kekuatan_reseptur',$this->kekuatan_reseptur);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('qty_reseptur',$this->qty_reseptur);
		$criteria->compare('hargasatuan_reseptur',$this->hargasatuan_reseptur);
		$criteria->compare('LOWER(signa_reseptur)',strtolower($this->signa_reseptur),true);
		$criteria->compare('harganetto_reseptur',$this->harganetto_reseptur);
		$criteria->compare('hargajual_reseptur',$this->hargajual_reseptur);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /**
         * getDetailObatTerapi untuk menampilkan detail obat terapi (obatalkespasien_t)
         * @param type $idPenjualanResep 
         */
        public function getObatTerapi($idReseptur){
            $modObatTerapi = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$idReseptur));
            return $modObatTerapi;
        }

}