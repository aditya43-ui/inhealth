<?php
/**
 * custom model, tidak mengambil data dari tabel tertentu
 * issue RSST-2633
 * @package application.modules.penelitianKesehatan
 * @subpackage models  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class ASCustomModel extends CFormModel
{	
    public $tgl_awal;
    public $tgl_akhir;
    public $penelitian_nomor;
    public $smf_nama;
    public $smf_id;
    public $nama_pegawai;
    public $pegawai_id;
    public $arrGrafik = array();
    public $arrlistTooltipVal = array();
    public $arrListMaster = array();         
    
    public function rules()
    {
        return array(
            array('smf_nama, nama_pegawai, tgl_awal, tgl_akhir','safe','on'=>'search')
        );
    }

    /**
     * menambahkan label pada attibutenya
     * @return type
     */
    public function attributeLabels()
    {
        return array(

        );
    }
    
    
    public function generateDashboardOPPE(){
        $tgl_awal = date('Y-m-01', strtotime(MyFormatter::formatMonthForDb($this->tgl_awal)));
        $tgl_akhir = date('Y-m-t', strtotime(MyFormatter::formatMonthForDb($this->tgl_akhir)));        
        
        $sel = 'u.namaunitkerja';
        if (!empty($this->smf_id)){
            $sel = 't.nama_perawat';
        }
        
        $cri = new CDbCriteria();
        $cri->join =  " JOIN indikatoroppekeperawatan_m ind ON ind.indikatoroppekeperawatan_id = t.indikatoroppekeperawatan_id "
                    . " JOIN unitkerja_m u ON u.unitkerja_id = t.perawat_unitkerja_id "
                    . " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id ";
        
        $cri->group = " ind.rekomendasi, ind.golongan_indikator, ind.standar_nilai, ind.nama_indikator, ind.indikatoroppekeperawatan_id, ".$sel." ";
        $cri->select = $cri->group.", SUM(t.nilai_rata) as capaian, count(t.oppeperilaku_id) as jumlah, ".$sel." as smf_nama ";        
        $cri->compare("LOWER(nama_pegawai)", strtolower($this->nama_pegawai),true);
        $cri->compare("LOWER(namaunitkerja)", strtolower($this->smf_nama),true);        
        if (!empty($this->pegawai_id)){
            $cri->addCondition("t.pegawai_id = ".$this->pegawai_id);
        }
        if (!empty($this->smf_id)){
            $cri->addCondition("t.unitkerja_id = ".$this->smf_id);
        }
        $cri->order = " smf_nama ASC ";
        
        $criPelatihan = clone $cri;        
        $criClinical = clone $cri;  
        
        $cri->addCondition(" ind.golongan_indikator ilike '".Params::GOLONGAN_INDIKATOR_PERILAKU."' ");
        $cri->addBetweenCondition("DATE(bulan_pencatatan)", $tgl_awal, $tgl_akhir);                
        $perilaku = OppeperilakuT::model()->findAll($cri);
                                
        $i = 0;
        
        $arrGrafik = array();    
        $list_master = array();
        $list_tooltip_val = array();
        
        foreach($perilaku as $vit){   
            $this->get_grafik($vit);
        } 
                   
                       
        $criPelatihan->addCondition(" ind.golongan_indikator ilike '".Params::GOLONGAN_INDIKATOR_PERTUMBUHAN_PROFESI."' ");                
        $criCaring = clone $criPelatihan;
        $criBimbingan = clone $criPelatihan;
        $criKehadiran = clone $criPelatihan;
        $criKepatuhan = clone $criPelatihan;        
        $criPelatihan->select = $criPelatihan->group.", SUM(t.skor) as capaian, count(t.oppepelatihan_id) as jumlah, ".$sel." as smf_nama ";        
        $criPelatihan->addBetweenCondition("DATE(bulan_pelatihan)", $tgl_awal, $tgl_akhir);                
        $pelatihan = OppepelatihanT::model()->findAll($criPelatihan);
        
        foreach($pelatihan as $vit){   
            $this->get_grafik($vit);
        }
                        
        $criCaring->select = $criCaring->group.", SUM(t.nilai_rata) as capaian, count(t.oppecaring_id) as jumlah, ".$sel." as smf_nama ";        
        $criCaring->addBetweenCondition("DATE(bulan_caring)", $tgl_awal, $tgl_akhir);                
        $caring = OppecaringT::model()->findAll($criCaring);
        
        foreach($caring as $vit){               
            $this->get_grafik($vit);
        }
                      
        $criBimbingan->select = $criBimbingan->group.", SUM(t.skor) as capaian, count(t.oppebimbingan_id) as jumlah, ".$sel." as smf_nama ";        
        $criBimbingan->addBetweenCondition("DATE(bulan_bimbingan)", $tgl_awal, $tgl_akhir);                
        $bimbingan = OppebimbinganT::model()->findAll($criBimbingan);
        
        foreach($bimbingan as $vit){   
           $this->get_grafik($vit);
        }
               
        $criKehadiran->select = $criKehadiran->group.", SUM(t.prosentase_kehadiran) as capaian, count(t.oppekehadiran_id) as jumlah, ".$sel." as smf_nama ";        
        $criKehadiran->addBetweenCondition("DATE(bulan_kehadiran)", $tgl_awal, $tgl_akhir);                
        $kehadiran = OppekehadiranT::model()->findAll($criKehadiran);
        
        foreach($kehadiran as $vit){   
            $this->get_grafik($vit);
        }
                
        $criKepatuhan->select = $criKepatuhan->group.", SUM(t.prosentase_asesmen) as capaian, count(t.oppeasesmen_id) as jumlah, ".$sel." as smf_nama ";        
        $criKepatuhan->addBetweenCondition("DATE(bulan_asesmen)", $tgl_awal, $tgl_akhir);                
        $kepatuhan = OppeasesmenT::model()->findAll($criKepatuhan);
        
        foreach($kepatuhan as $vit){   
            $this->get_grafik($vit);
        }
                
        $criClinical->addCondition(" ind.golongan_indikator ilike '".Params::GOLONGAN_INDIKATOR_CLINICAL_RESULT."' ");        
        $criClinical->select = $criClinical->group.", SUM(t.prosentase_clinicalcare) as capaian, count(t.oppeclinicalcare_id) as jumlah, ".$sel." as smf_nama ";        
        $criClinical->addBetweenCondition("DATE(bulan_clinicalcare)", $tgl_awal, $tgl_akhir);                
        $clinical = OppeclinicalcareT::model()->findAll($criClinical);
        
        foreach($clinical as $vit){   
            $this->get_grafik($vit);
        }
                        
        $data['grafik'] = $this->arrGrafik;
        $data['list'] = $this->arrListMaster;
        $data['tooltip'] = $this->arrlistTooltipVal;                 
    
        return $data;
    }
	
    
    public function get_grafik($vit){                
        $iden = strtolower(str_replace(" ","_",$vit->golongan_indikator));
        $color = '#'.substr(md5(rand()), 0, 6);
        $color2 = '#'.substr(md5(rand()), 0, 6);
        
        $smf = ($vit->standar_nilai > ($vit->capaian/$vit->jumlah))?('Membutuhkan '.$vit->rekomendasi):'';        
        $this->arrlistTooltipVal[$iden][$vit->indikatoroppekeperawatan_id]['title'][] = $smf;
        
        $this->arrListMaster[$iden][$vit->indikatoroppekeperawatan_id] = $vit->nama_indikator;
        
        $this->arrGrafik[$iden][$vit->indikatoroppekeperawatan_id]['labels'][] = !empty($vit->smf_nama)?$vit->smf_nama:'Tidak Diketahui';            
        $this->arrGrafik[$iden][$vit->indikatoroppekeperawatan_id]['datasets'][0]['data'][] = $vit->standar_nilai;                
        $this->arrGrafik[$iden][$vit->indikatoroppekeperawatan_id]['datasets'][0]['backgroundColor'][] = $color;        
        $this->arrGrafik[$iden][$vit->indikatoroppekeperawatan_id]['datasets'][0]['label'] = 'Standar Nilai';
        
        $this->arrGrafik[$iden][$vit->indikatoroppekeperawatan_id]['datasets'][1]['data'][] =$vit->capaian/$vit->jumlah;
        $this->arrGrafik[$iden][$vit->indikatoroppekeperawatan_id]['datasets'][1]['backgroundColor'][] = $color2;        
        $this->arrGrafik[$iden][$vit->indikatoroppekeperawatan_id]['datasets'][1]['label'] = 'Capaian';                                          
    
    }
}
