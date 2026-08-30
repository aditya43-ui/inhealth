<?php
/**
 * custom model, tidak mengambil data dari tabel tertentu
 * 
 * @package application.modules.smsCenter
 * @subpackage models  
 * @author      Yusuf Putra Anugrah <yusufputra@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class SCustomModel extends CFormModel
{	
    public $tgl_awal;
    public $tgl_akhir;
    public $penelitian_nomor;
    
    public function rules()
    {
        return array(
            array('tgl_awal, tgl_akhir','safe','on'=>'search')
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
    
    /**
     * untuk mengenerate data grafik
     */
    public function generateBeranda(){
        $criteria = new CDbCriteria();
        $criteria->select = "t.golonganlainnya, t.jenislainnya, t.kategorilainnya ,t.judul_penelitian, t.penelitian_id, t.penelitian_nomor, gol.golonganpenelitian_nama, jenis.jenispenelitian_nama, ins.instalasi_nama, kat.kategoripenelitian_nama, peg.peneliti_nama as penelitian_ketua, surat.suratijinpenelitian_nomor, program.programpenelitian_nama, t.programlainnya, t.penelitian_aktif, smf.smf_nama, surat.suratijinberlakumulai, surat.suratijinberakhir, t.jenismonev, t.jumlahsubjek";
        $criteria->join = " LEFT JOIN golonganpenelitian_m gol ON gol.golonganpenelitian_id = t.golonganpenelitian_id "
                        . " LEFT JOIN jenispenelitian_m jenis ON jenis.jenispenelitian_id = t.jenispenelitian_id "
                        . " LEFT JOIN programpenelitian_m program ON program.programpenelitian_id = t.programpenelitian_id "                        
                        . " LEFT JOIN smf_m smf ON smf.smf_id = t.smf_id "                        
                        . " LEFT JOIN anggotapenelitian_m ketua ON ( (ketua.penelitian_id = t.penelitian_id) AND anggotapenelitian_ketua = TRUE) "
                        . " LEFT JOIN peneliti_m peg ON peg.peneliti_id = ketua.peneliti_id "
                        . " LEFT JOIN instalasi_m ins ON ins.instalasi_id = peg.instalasi_id "
                        . " LEFT JOIN kategoripenelitian_penelitian_m katdet ON katdet.penelitian_id = t.penelitian_id "
                        . " LEFT JOIN kategoripenelitian_m kat ON kat.kategoripenelitian_id = katdet.kategoripenelitian_id "
                        . " LEFT JOIN suratijinpenelitian_m surat ON surat.penelitian_id = t.penelitian_id ";
        $criteria->addCondition(" t.penelitian_aktif = TRUE ");        
        
        $criteria->order = 't.penelitian_nomor DESC';                        
        
        $penelitianAktif = PenelitianM::model()->findAll($criteria);    
        
        //$criteria->addCondition(" ( ( tanggalmulai >= '".$this->tgl_awal."' ) AND ( tanggalakhir <= '".$this->tgl_akhir."' ) ) OR (  ( tanggalakhir >= '".$this->tgl_awal."' ) AND ( tanggalakhir <= '".$this->tgl_akhir."' )  ) ");
        $criteria->addCondition(" '".$this->tgl_akhir."' >= tanggalmulai  AND '".$this->tgl_akhir."' <= tanggalakhir  ");
        
                
        $penelitian = PenelitianM::model()->findAll($criteria);
        
                   
        
        $cri = new CDbCriteria();
        $cri->addBetweenCondition(" DATE(addendumpenelitian_tanggal) ",$this->tgl_awal,$this->tgl_akhir);
        $cri->addCondition(" verifikasi_tanggal is null ");
        $addendum = AddendumpenelitianT::model()->findAll($cri);
        
        
        $cri = new CDbCriteria();
        $cri->addCondition(" (status_monev ilike '".Params::STATUS_REALISASI_MONEV_DISETUJUI."') OR (status_monev is null) ");
        $cri->addBetweenCondition(" DATE(realisasimonev_tanggal) ",$this->tgl_awal,$this->tgl_akhir);
        $monev = RealisasimonevT::model()->findAll($cri);
        
        $tileAktif = array();
        $grafikPie['program'] = array();                
        
                
        foreach($penelitian as $det){
            $tileAktif[$det->penelitian_id]['id'] = $det->penelitian_id;                        
        }
        
        $program = array();
        $golongan = array();
        $jenis = array();
        $status = array();
        $kategori = array();
                
        
        foreach($penelitian as $det){            
            $program[$det->programpenelitian_nama]['program'] = $det->programpenelitian_nama;
            $program[$det->programpenelitian_nama]['det'][$det->penelitian_id]['id'] = $det->penelitian_id;            
            if (!empty($det->programlainnya)){
                $program[$det->programlainnya]['program'] = $det->programlainnya;
                $program[$det->programlainnya]['det'][$det->penelitian_id]['id'] = $det->penelitian_id;
            }
            
            $golongan[$det->golonganpenelitian_nama]['golongan'] = $det->golonganpenelitian_nama;
            $golongan[$det->golonganpenelitian_nama]['det'][$det->penelitian_id]['id'] = $det->penelitian_id;            
            if (!empty($det->golonganlainnya)){
                $golongan[$det->golonganlainnya]['golongan'] = $det->golonganlainnya;
                $golongan[$det->golonganlainnya]['det'][$det->penelitian_id]['id'] = $det->penelitian_id;
            }
            
            $jenis[$det->jenispenelitian_nama]['jenis'] = $det->jenispenelitian_nama;
            $jenis[$det->jenispenelitian_nama]['det'][$det->penelitian_id]['id'] = $det->penelitian_id;            
            if (!empty($det->jenislainnya)){
                $jenis[$det->jenislainnya]['jenis'] = $det->jenislainnya;
                $jenis[$det->jenislainnya]['det'][$det->penelitian_id]['id'] = $det->penelitian_id;
            }
            
            $kategori[$det->kategoripenelitian_nama]['kategori'] = $det->kategoripenelitian_nama;
            $kategori[$det->kategoripenelitian_nama]['det'][$det->penelitian_id]['id'] = $det->penelitian_id;            
            if (!empty($det->kategorilainnya)){
                $kategori[$det->kategorilainnya]['kategori'] = $det->kategorilainnya;
                $kategori[$det->kategorilainnya]['det'][$det->penelitian_id]['id'] = $det->penelitian_id;
            }
            
            $st = ($det->penelitian_aktif)?'ONGOING':'SELESAI';
            
            $status[$st]['status'] = $st;
            $status[$st]['det'][$det->penelitian_id]['id'] = $det->penelitian_id;                        
        } 
        
        
        $tk2 = array();
        $tk3 = array();
        
        $crijadwal = new CDbCriteria();
        $crijadwal->select = " t.jenismonev, ren.rencanamonev_id, t.penelitian_id ";
        $crijadwal->join = "   JOIN rencanamonev_t  ren ON ren.penelitian_id = t.penelitian_id "
                        .   "   JOIN rencanamonevwaktu_t renwaktu ON renwaktu.rencanamonev_id = ren.rencanamonev_id ";
        $crijadwal->addBetweenCondition(" DATE(renwaktu.rencanamonevwaktu_tanggal) ",$this->tgl_awal,$this->tgl_akhir);
        $jadwalmonev = PenelitianM::model()->findAll($crijadwal);
        
        foreach($jadwalmonev as $det){
            if ($det->jenismonev == Params::JENIS_MONEV_PASIF){
                $tk2[$det->rencanamonev_id] = $det->rencanamonev_id;
            }
            
            if ($det->jenismonev == Params::JENIS_MONEV_AKTIF){
                $tk3[$det->rencanamonev_id] = $det->rencanamonev_id;
            }
        }
                
        foreach ($program as $det){
            $grafikPie['program']['datasets'][0]['data'][] = count($det['det']);
            $grafikPie['program']['datasets'][0]['backgroundColor'][] = '#'.substr(md5(rand()), 0, 6);            
            $grafikPie['program']['labels'][] = $det['program'];
        }
        
        foreach ($golongan as $det){
            $grafikPie['golongan']['datasets'][0]['data'][] = count($det['det']);
            $grafikPie['golongan']['datasets'][0]['backgroundColor'][] = '#'.substr(md5(rand()), 0, 6);            
            $grafikPie['golongan']['labels'][] = $det['golongan'];
        }
        
        foreach ($jenis as $det){
            $grafikPie['jenis']['datasets'][0]['data'][] = count($det['det']);
            $grafikPie['jenis']['datasets'][0]['backgroundColor'][] = '#'.substr(md5(rand()), 0, 6);            
            $grafikPie['jenis']['labels'][] = $det['jenis'];
        }
        
        foreach ($status as $det){
            $grafikPie['status']['datasets'][0]['data'][] = count($det['det']);
            $grafikPie['status']['datasets'][0]['backgroundColor'][] = '#'.substr(md5(rand()), 0, 6);            
            $grafikPie['status']['labels'][] = $det['status'];
        }
        
        foreach ($kategori as $det){
            $grafikPie['kategori']['datasets'][0]['data'][] = count($det['det']);
            $grafikPie['kategori']['datasets'][0]['backgroundColor'][] = '#'.substr(md5(rand()), 0, 6);            
            $grafikPie['kategori']['labels'][] = $det['kategori'];
        }
        
        $tableHuman['human'] = array();
        $idpenelitian = array();
        
        foreach($penelitianAktif as $hm){
            $idpenelitian[] = $hm->penelitian_id;
            $tableHuman['human'][$hm->penelitian_id]['penelitian_id'] = $hm->penelitian_id;
            $tableHuman['human'][$hm->penelitian_id]['suratijinpenelitian_nomor'] = $hm->suratijinpenelitian_nomor;
            $tableHuman['human'][$hm->penelitian_id]['suratijinberlakumulai'] = MyFormatter::formatDateTimeForUser($hm->suratijinberlakumulai);
            $tableHuman['human'][$hm->penelitian_id]['suratijinberakhir'] = MyFormatter::formatDateTimeForUser($hm->suratijinberakhir);
            $tableHuman['human'][$hm->penelitian_id]['judul_penelitian'] = $hm->judul_penelitian;
            $tableHuman['human'][$hm->penelitian_id]['penelitian_ketua'] = $hm->penelitian_ketua;
            $tableHuman['human'][$hm->penelitian_id]['smf_nama'] = $hm->smf_nama;
            $tableHuman['human'][$hm->penelitian_id]['jenismonev'] = $hm->jenismonev;                        
            $tableHuman['human'][$hm->penelitian_id]['jumlahsubjek'] = $hm->jumlahsubjek; 
        }
        
        $cri = new CDbCriteria();
        $cri->addInCondition("penelitian_id", $idpenelitian);        
        $sampleHuman = SampelhumansubjectT::model()->findAll($cri);
        
        foreach($sampleHuman as $s){            
            if ($s->penelitian_id == $tableHuman['human'][$hm->penelitian_id]['penelitian_id']){
                $tableHuman['human'][$hm->penelitian_id]['sampelhuman'][$s->sampelhumansubject_id]['id'] = $s->sampelhumansubject_id;
            }
        }
                        
        $table['human'] = new CArrayDataProvider($tableHuman['human'], array(
            'keyField'=>'penelitian_id',			
            'id'=>'data_laporan',
                'totalItemCount'=>count($tableHuman['human']),
                'pagination' => array(
                    'pageSize' => 10,
                    'pageVar' => 'page'
                ),			
        ));
        
        
        
        $tile = array();                                
        
        $tile['aktif'] = count($tileAktif);
        $tile['addendum'] = count($addendum);
        $tile['monev'] = count($monev);
        $tile['jadwalmonevtk2'] = count($tk2);
        $tile['jadwalmonevtk3'] = count($tk3);
        
        $data['tile'] = $tile;
        $data['grafik'] = $grafikPie;                
        $data['tabel'] = $table;
        
        return $data;
        
    }
	
}
