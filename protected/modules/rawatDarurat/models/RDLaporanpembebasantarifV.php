<?php

class RDLaporanpembebasantarifV extends LaporanpembebasantarifV
{
        public $ceklistdaftar, $tgl_awal, $tgl_akhir, $tgldaftar_awal, $tgldaftar_akhir;
        public $jumlah, $tick, $data, $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
        public $dokter_nama;
    
	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
        
	public function searchInformasi(){
            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('date(tglpembebasan)', $this->tgl_awal, $this->tgl_akhir);

            if ($this->ceklistdaftar){
                $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgldaftar_awal, $this->tgldaftar_akhir);
            }

            if(!empty($this->pegawai_id)){
                    $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
            }
            if(!empty($this->komponentarif_id)){
                    $criteria->addCondition('komponentarif_id = '.$this->komponentarif_id);
            }

            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->addCondition('create_ruangan = '.Yii::app()->user->getState('ruangan_id'));
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));	
	}

        public function getDokterLengkap(){
            return $this->gelardepan ." ". $this->nama_pegawai ." ". $this->gelarbelakang_nama;
        }
        
    public function searchGrafik() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        $criteria->select = "count(pasien_id) as jumlah, coalesce(gelardepan, '') || coalesce(nama_pegawai, '') || coalesce(gelarbelakang_nama, '') as data";
        $criteria->group = 'nama_pegawai, gelardepan, gelarbelakang_nama';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    public function searchLaporanTable() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchLaporanPrint() {

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