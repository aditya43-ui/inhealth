<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ROLaporan10besarpenyakit
 *
 * @author sujana
 */
class ROLaporanPemeriksaanRujukanV extends LaporanpemeriksaanrujukanV {

    public $jns_periode;
    public $tgl_awal, $tgl_akhir;
    public $bln_awal, $bln_akhir;
    public $thn_awal, $thn_akhir;
    public $jumlah, $data, $tick, $tot_tarif;
    public $tgl_pendaftaran, $namaperujuk;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchLapPemeriksaanRujukRAD() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionLapPemeriksaanRujukRADCriteria();
        $criteria->order = 'tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchLapPemeriksaanRujukRADPrint() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionLapPemeriksaanRujukRADCriteria();
        $criteria->order = 'tgl_pendaftaran DESC';
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    protected function functionLapPemeriksaanRujukRADCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = "JOIN pendaftaran_t p ON t.pendaftaran_id = p.pendaftaran_id";     
        $criteria->select = 'p.tgl_pendaftaran, t.no_pendaftaran, t.daftartindakan_nama, t.asalrujukan_nama, t.nama_perujuk';
        $criteria->addBetweenCondition('p.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);                       
        $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran), TRUE);
        
        if (!empty($this->namaperujuk)){
            $criteria->addInCondition('nama_perujuk', $this->namaperujuk);
        }else{
            if (!empty($this->asalrujukan_id)){
                $criteria->addInCondition('asalrujukan_id', $this->asalrujukan_id);
            }
        }
    
        $criteria->addCondition(" t.create_ruangan = ".Yii::app()->user->getState('ruangan_id'));
        
        


        return $criteria;
    }

     public function searchLapPemeriksaanRujukRADGrafik()
     {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->join = "JOIN pendaftaran_t p ON t.pendaftaran_id = p.pendaftaran_id";     
            $criteria->select = 'count(t.no_pendaftaran) as jumlah, t.asalrujukan_nama as data';
            $criteria->addBetweenCondition('p.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);                       
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran), TRUE);

            if (!empty($this->namaperujuk)){
                $criteria->addInCondition('nama_perujuk', $this->namaperujuk);
            }else{
                if (!empty($this->asalrujukan_id)){
                    $criteria->addInCondition('asalrujukan_id', $this->asalrujukan_id);
                }
            }

            $criteria->addCondition(" t.create_ruangan = ".Yii::app()->user->getState('ruangan_id'));
            $criteria->group = 't.asalrujukan_nama';


            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }       
    
    public function getNamaModel()
    {
        return __CLASS__;
    }

}

?>
