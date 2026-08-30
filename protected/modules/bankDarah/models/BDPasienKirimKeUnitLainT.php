<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class BDPasienKirimKeUnitLainT extends PasienkirimkeunitlainT
{


    public $tgl_awal, $tgl_akhir, $tglren_transfusi, $sd_tglrentransfusi;
    public $alamat_pasien, $nama_pasien, $jeniskelamin, $no_rekam_medik, $ruangan_nama, $nama_pegawai, $no_pendaftaran, $tgl_pendaftaran, $create_time, $penjamin_id, $carabayar_id;
public $golongandarah, $rhesus, $no_permintaandarah,$tglpermintaan,$is_pasiensama,$permintaandarah_id;
    public $umur;
    public $ujidarahpasien_id, $ujikompatibilitas_id, $penyiapandarah_id, $penyerahandarah_id;
    public $tglujikompabilitas, $tglpenyiapandarah, $tglpenyerahan;
    public $uji, $komp, $penyiapandarah;
    public $ruanganpemesan_id, $instalasi_asal;
    public $kelaspelayanan_nama;
    public $penjamin_nama,$tanggal_lahir;
    public $dpjp_nama, $ujidarahslide_id, $ujidarahtube_id;
    public $diagnosis;
    public $count_det;
    public $permintaandarahdet_id;
    public $gelardepan, $gelarbelakang_nama, $totaldet;
    public $rilis;
    public $ujikompatibilitas_ke, $penyiapandarah_ke, $penyerahandarah_ke;        
    public $kesimpulan_uji,$noperminatanpenujang,$tglpermintaankepenunjang;
    public $pegpemesan_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }


    public function searchInformasiKirimUnitLainT()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria= new CDbCriteria;  
      
        $criteria->addBetweenCondition('DATE(tgl_kirimpasien)', $this->tgl_awal, $this->tgl_akhir);
    
       // $criteria->group = "pen.*,daftar.*,pas.*";
        $criteria->select =  "t.*, ins.instalasi_nama,daftar.*,pas.*,ru.*,car.*,penj.*, peg.*";
        $criteria->join = ''
        .' JOIN pendaftaran_t daftar ON daftar.pendaftaran_id = t.pendaftaran_id '
        .' JOIN pasien_m pas ON pas.pasien_id = daftar.pasien_id '
        .' JOIN ruangan_m ru ON ru.ruangan_id = t.ruangan_id '
        .' JOIN instalasi_m ins ON ins.instalasi_id = t.instalasi_id '
        .' JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id '
       
        . 'JOIN carabayar_m car ON car.carabayar_id = daftar.carabayar_id '
        . 'JOIN penjaminpasien_m penj ON penj.penjamin_id = daftar.penjamin_id ';

        // $criteria->limit=10;           
        // $criteria->order = 'pen.tglpermintaankepenunjang ASC';
        $criteria->compare("LOWER(pas.nama_pasien)", strtolower($this->nama_pasien),true);
        $criteria->compare("LOWER(pas.no_rekam_medik)", strtolower($this->no_rekam_medik),true);
        $criteria->compare("LOWER(pas.rhesus)", strtolower($this->rhesus),true);
        $criteria->compare("LOWER(ujidarahslide.kesimpulan_uji)", strtolower($this->kesimpulan_uji),true);
       
        if($this->noperminatanpenujang){
            $criteria->compare("LOWER(no_perminataan)", strtolower($this->noperminatanpenujang),true);
        }

      
        $criteria->addCondition("t.ruangan_id =". Params::RUANGAN_ID_BANK_DARAH);
      
       
       if($this->instalasi_id){
        $criteria->compare("ins.instalasi_id", $this->instalasi_id);
      
       }
        $criteria->compare("ru.ruangan_nama", strtolower($this->ruangan_nama),true);
        $criteria->compare("car.carabayar_id", $this->carabayar_id);
        $criteria->compare("penj.penjamin_id", $this->penjamin_id);
       
        
        $criteria->compare("peg.pegawai_id", $this->pegawai_id);
         $criteria->compare("pas.pasien_id", $this->pasien_id);
        $criteria->compare("daftar.pendaftaran_id ", $this->pendaftaran_id);
        $criteria->addCondition("t.is_titipdarah is not false");
        // echo '<pre>';var_dump($criteria);die;
        $criteria->order = 'tgl_kirimpasien DESC';
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }



}
?>
