<?php

class BKInformasipiutangpenjaminV extends InformasipiutangpenjaminV {

    public $tgl_awal, $tgl_akhir;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchInformasi() {
        $criteria = new CDbCriteria;
        $criteria->select = "pembayaranpelayanan_id, tglbuktibayar, nobuktibayar, instalasi_nama, ruangan_nama, no_pendaftaran, no_rekam_medik, nama_pasien, penjamin_nama, totalbiayapelayanan, totalpiutang, tgljatuhtempo, tglpengajuanklaimanklaim, sum(totalbayar_tunai) as totalbayar_tunai, sum(totalbayar_nontunai) as totalbayar_nontunai, pengajuanklaimpiutang_id";
        $criteria->group = "pembayaranpelayanan_id, tglbuktibayar, nobuktibayar, instalasi_nama, ruangan_nama, no_pendaftaran, no_rekam_medik, nama_pasien, penjamin_nama, totalbiayapelayanan, totalpiutang, tgljatuhtempo, tglpengajuanklaimanklaim, pengajuanklaimpiutang_id";
        $criteria->addCondition('carabayar_id <> '.Params::CARABAYAR_ID_MEMBAYAR);
        
        $criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('lower(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('lower(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('lower(nama_pasien)', strtolower($this->nama_pasien), true);
        
        if (!empty($this->carabayar_id)) {
            $criteria->addCondition('carabayar_id = ' . $this->carabayar_id);
        }
        if (!empty($this->penjamin_id)) {
            $criteria->addCondition('penjamin_id = ' . $this->penjamin_id);
        }
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
    
    
    public function getUmurHutang($tgljatuhtempo, $tglpengajuan){
        $umurHutang = "-";
        if(!empty($tgljatuhtempo) || !empty($tglpengajuan)){
            $tglpengajuan = date('Y-m-d', strtotime($tglpengajuan));
            $tgljatuhtempo = (!empty($tgljatuhtempo)?date('Y-m-d', strtotime($tgljatuhtempo)):date('Y-m-d H:i:s'));
            
            $dob=$tglpengajuan; 
            $jatuhtempo=$tgljatuhtempo;
            list($y,$m,$d)=explode('-',$dob);
            list($ty,$tm,$td)=explode('-',$jatuhtempo);
            if($td-$d<0){
                    $day=($td+30)-$d;
                    $tm--;
            }
            else{
                    $day=$td-$d;
            }
            if($tm-$m<0){
                    $month=($tm+12)-$m;
                    $ty--;
            }
            else{
                    $month=$tm-$m;
            }
            $year=$ty-$y;

            $umurHutang = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
        }
                return $umurHutang;
    }
}
