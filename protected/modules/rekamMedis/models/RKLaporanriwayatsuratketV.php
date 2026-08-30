<?php

class RKLaporanriwayatsuratketV extends LaporanriwayatsuratketV
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
            $cri->limit = 10;
            $cri->order = "tglsurat ASC";
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$cri,
		));
        }
        
        public function searchPrint() {
            $cri = $this->functionSearch();            
            $cri->limit = -1;
            $cri->order = "tglsurat ASC";
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$cri,
		));
        }
        
        public function searchGrafik() {
            $cri = $this->functionSearch();     
            $cri->select = " judulsurat as data, count(suratketerangan_id) as jumlah ";
            $cri->group = " data ";
            $cri->order = "jumlah DESC";
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$cri,
		));
        }
        
        public function functionSearch() {
            $cri = new CDbCriteria();
            
            $cri->addBetweenCondition("DATE(tglsurat)", $this->tgl_awal, $this->tgl_akhir);
            $cri->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien));
            $cri->compare("LOWER(no_rekam_medik)", strtolower($this->no_rekam_medik));            
            
            return $cri;
        }
        
        

}