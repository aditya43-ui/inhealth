<?php
class GZBatalpermintaanpembelianT extends BatalpermintaanpembelianT
{
        public $tgl_awal,$tgl_akhir, $tglbatal_awal, $tglbatal_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasifakturpembelianV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi()
	{
            $criteria=new CDbCriteria;
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('DATE(tglpermintaanpembelian)',$this->tgl_awal,$this->tgl_akhir);
            }
             if (!empty($this->tglbatal_awal) && !empty($this->tglbatal_akhir)) {
                $criteria->addBetweenCondition('DATE(tglbatalpermintaan)',$this->tglbatal_awal,$this->tglbatal_akhir);
            }
//		$criteria->addBetweenCondition('DATE(tglbatalpermintaan)',$this->tglbatal_awal,$this->tglbatal_akhir,true);
//                $criteria->addBetweenCondition('DATE(tglpermintaanpembelian)',$this->tgl_awal,$this->tgl_akhir,true);
//                $criteria->addCondition("date(tglbatalpermintaan) = '".$this->tglbatalpermintaan."'");
//                $criteria->addCondition("date(tglpermintaanpembelian) = '".$this->tglpermintaanpembelian."'");
                
		
		$criteria->compare('lower(nopermintaan)', strtolower($this->nopermintaan),true);
                $criteria->compare('lower(supplier_nama)', strtolower($this->supplier_nama),true);
		
		if(!empty($this->ruangan_id)){
                    if(is_array($this->ruangan_id)){
                        $criteria->addInCondition('ruangan_id',$this->ruangan_id);
                    }else{
                        $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
                    }
			
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}