<?php

class RKLaporanindikatorpelayananrsV extends LaporanindikatorpelayananrsV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getNamaModel()
        {
            return __CLASS__;
        }
        
        public function searchTable() {
            $cri = $this->functionSearch();
            $cri->select = " profilrs_id ";
            $cri->group = 'profilrs_id ';
            $cri->limit = 10;
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$cri,
		));
        }
        
        public function searchTablePrint() {
            $cri = $this->functionSearch();
            $cri->select = " profilrs_id ";
            $cri->group = 'profilrs_id ';
            $cri->limit = -1;
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$cri,
		));
        }
        
        public function searchGrafik() {
            $cri = $this->functionSearch();
            $cri->select = " kelaspelayanan_nama as data, kelaspelayanan_id, profilrs_id, count(pasienadmisi_id) as jumlah ";            
            $cri->group = ' kelaspelayanan_nama, kelaspelayanan_id, profilrs_id ';
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$cri,
		));
        }
        
        public function functionSearch() {
            $cri = new CDbCriteria();
            
            $cri->addBetweenCondition("(tgl_laporan)", $this->tgl_awal, $this->tgl_akhir);
            
            
            return $cri;
        }
        
        

}