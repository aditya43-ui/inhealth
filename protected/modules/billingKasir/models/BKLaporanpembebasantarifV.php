<?php

class BKLaporanpembebasantarifV extends LaporanpembebasantarifV {

    public $jumlah, $tick, $data, $jns_periode, $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $dokter_nama;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchGrafik() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        $criteria->select = 'count(pasien_id) as jumlah, nama_pegawai as data';
        $criteria->group = 'nama_pegawai';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    public function searchTable() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchPrint() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }

    protected function functionCriteria() {
        $format = new MyFormatter();
        
        $criteria = new CDbCriteria();
        if(!empty($this->pegawai_id)){
                $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
		
		if (is_array($this->nama_pegawai)){
			$criteria->addInCondition("nama_pegawai" , $this->nama_pegawai);
		}
        //$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), TRUE);
        //$criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('create_ruangan', $this->ruangan_id);
        //var_dump($this->tgl_akhir);
        $criteria->addBetweenCondition('tglpembebasan', $format->formatDateTimeForDb(date("Y-m-d", strtotime($this->tgl_awal))).' 00:00:00', $format->formatDateTimeForDb(date("Y-m-d", strtotime($this->tgl_akhir))).' 23:59:59');

        return $criteria;
    }
      
}