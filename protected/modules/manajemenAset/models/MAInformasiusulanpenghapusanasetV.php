<?php

class MAInformasiusulanpenghapusanasetV extends InformasiusulanpenghapusanasetV
{    
    public $tgl_awal, $tgl_akhir;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
     * fungsi yang digunakan untuk menampilkan isi grid view, pada menu informasi kelengkapan peralatan
     * @return \CArrayDataProvider
     */
    public function searchInformasi(){
        $cri = new CDbCriteria;
        $cri->select = [
            't.*',
            "CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gelar.gelarbelakang_nama) as pegpengusul_nama"
        ];
        $cri->join =  " JOIN pegawai_m peg ON peg.pegawai_id = t.pegpengusul_id "
                    . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id ";        
        $cri->addBetweenCondition("DATE(t.usulanpenghapusanaset_tanggal)", $this->tgl_awal, $this->tgl_akhir);
        $cri->compare('LOWER(t.usulanpenghapusanaset_nomor)', strtolower($this->usulanpenghapusanaset_nomor),true);                
        $cri->compare('LOWER(peg.nama_pegawai)', strtolower($this->pegpengusul_nama),true);                
        $cri->compare('t.lokasi_id',$this->lokasi_id);
        
        if ($this->ada_pj_aset){
            $cri->addCondition("t.lokasi_id IN (SELECT lokasi_id FROM penanggungjawabaset_m WHERE pegawai_id = ".Yii::app()->user->getState('pegawai_id')." GROUP by lokasi_id )  ");
        }
        
        
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$cri,
        ));
    }
}
?>
