<?php

class SELaporanpenerimaankasirV extends LaporanpenerimaankasirV {
        public $tgl_awal;
        public $tgl_akhir;
        public $bln_awal;
        public $bln_akhir;
        public $thn_awal;
        public $thn_akhir;
        public $jumlahTampil;
        public $jns_periode;
        public $data_2;
        public $jumlah;
    
 

    protected function searchCriteria() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('tglbuktibayar BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
		}
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);			
		}
        $criteria->compare('LOWER(shift_nama)', strtolower($this->shift_nama), true);

        return $criteria;
    }

    public function searchGrafikGaris() {
        $criteria = $this->searchCriteria();
        $tgl_awal = date("Y-m-d",strtotime($this->tgl_awal));
        $tgl_akhir = date("Y-m-d",strtotime($this->tgl_akhir));
        $jmlhari = floor(abs(strtotime($this->tgl_awal)-strtotime($this->tgl_akhir))/(60*60*24));
        if($jmlhari > 30){
            $criteria->select = 'count(ruangan_id) as jumlah, EXTRACT(MONTH FROM tglbuktibayar::timestamp) as data, EXTRACT(YEAR FROM tglbuktibayar::timestamp) as data_2';
            $criteria->group = 'data_2,data';
        }else{
            $criteria->select = 'count(ruangan_id) as jumlah, date(tglbuktibayar) as data';
            $criteria->group = 'data';
        }
        $criteria->order = $criteria->group;
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }


    public function searchGrafikBatangPiePenerimaan() {
        $criteria = $this->searchCriteria();
        $criteria->select = 'count(ruangan_id) as jumlah, ruangan_nama as data';
        $criteria->group = 'ruangan_nama';
        $criteria->order = $criteria->group;
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    public function searchSpeedo() {
        $criteria = $this->searchCriteria();
        $criteria->select = 'count(ruangan_id) as data';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}