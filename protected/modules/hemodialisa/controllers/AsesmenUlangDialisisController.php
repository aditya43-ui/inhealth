<?php

class AsesmenUlangDialisisController extends MyAuthController{
    
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
        
    public function actionIndex(){
        $pendaftaran_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
        $modPendaftaran = [];
        $modPenyulitHD = [];
        $modTransfusi = [];
        $modGizi = [];
        $modAwalDialisis = [];
        $grafik = array();
        $modPemeriksaanLab= new HDInfoKunjunganRDV(); 
        if (isset($_GET['HDInfoKunjunganRDV'])) {
            $modPemeriksaanLab->attributes = $_GET['HDInfoKunjunganRDV'];
            $modPemeriksaanLab->no_pendaftaran = isset($_GET['HDInfoKunjunganRDV']['no_pendaftaran']) ? $_GET['HDInfoKunjunganRDV']['no_pendaftaran'] : null;
            $modPemeriksaanLab->instalasi_nama = isset($_GET['HDInfoKunjunganRDV']['instalasi_nama']) ? $_GET['HDInfoKunjunganRDV']['instalasi_nama'] : null;
            $modPemeriksaanLab->pegawai_id = isset($_GET['HDInfoKunjunganRDV']['pegawai_id']) ? $_GET['HDInfoKunjunganRDV']['pegawai_id'] : null;
            $modPemeriksaanLab->pemeriksaanlab_nama = isset($_GET['HDInfoKunjunganRDV']['pemeriksaanlab_nama']) ? $_GET['HDInfoKunjunganRDV']['pemeriksaanlab_nama'] : null;
            $modPemeriksaanLab->hasilpemeriksaan = isset($_GET['HDInfoKunjunganRDV']['hasilpemeriksaan']) ? $_GET['HDInfoKunjunganRDV']['hasilpemeriksaan'] : null;
            $modPemeriksaanLab->nilairujukan = isset($_GET['HDInfoKunjunganRDV']['nilairujukan']) ? $_GET['HDInfoKunjunganRDV']['nilairujukan'] : null;
            $modPemeriksaanLab->hasilpemeriksaan_satuan = isset($_GET['HDInfoKunjunganRDV']['hasilpemeriksaan_satuan']) ? $_GET['HDInfoKunjunganRDV']['hasilpemeriksaan_satuan'] : null;
            $modPemeriksaanLab->namapemeriksaandet = isset($_GET['HDInfoKunjunganRDV']['namapemeriksaandet']) ? $_GET['HDInfoKunjunganRDV']['namapemeriksaandet'] : null;
        }
        
        if(!empty($pendaftaran_id)){
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            
            $cri1 = new CDbCriteria();
            $cri1->select = "b.tanggal, t.jam_observasi, b.dpjp_id, b.creale_login, t.penyulit_hd_id";
            $cri1->join = "JOIN monitoring_intra_hd_t b ON b.monitoring_intra_hd_id = t.monitoring_intra_hd_id ".
                         "JOIN perkembangan_terintegrasi_pasien_t c ON t.monitoring_intra_hd_det_id=c.monitoring_intra_hd_det_id";
            $cri1->addCondition("b.pendaftaran_id = ".$pendaftaran_id);
            $cri1->addCondition("t.penyulit_hd_id IS NOT NULL ");
            $modPenyulitHD = MonitoringIntraHdDetT::model()->findAll($cri1);
            
            $crit = new CDbCriteria();
            $crit->select = "t.create_time, t.pegawai_id, t.create_loginpemakai_id, b.kantong_transfusi_darah_det_id";
            $crit->join = "JOIN kantong_transfusi_darah_det_t b USING(kantong_transfusi_darah_id)";
            $crit->addCondition('t.pendaftaran_id = '.$pendaftaran_id);
            $modTransfusi = KantongTransfusiDarahT::model()->findAll($crit);
            
            $modGizi = AsesmenawalgiziT::model()->findAll('pendaftaran_id = '.$pendaftaran_id);
            $cri = new CDbCriteria();
            $cri->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $cri->order = "tgl_pemeriksaan";
            $modAwalDialisis = AsesmenAwalMedisT::model()->findAll($cri);
            
            $tampung = [];
            $data = [];
            
            foreach($modAwalDialisis as $no=>$row){
                $init = date('d M Y', strtotime($row->tgl_pemeriksaan));
                if (!empty($row->suhu)){
                    $tampung[$init]['tgl'] = $init;
                    $tampung[$init]['suhu'] = $row->suhu;
                    $tampung[$init]['nadi'] = $row->nadi;
                    $tampung[$init]['sistolik'] = $row->tekanandarah_sistolok;
                    $tampung[$init]['diastolik'] = $row->tekanandarah_diastolik;
                    $tampung[$init]['respirasi'] = $row->pernafasan;
                }
            }
            
            foreach($tampung as $det){
                $grafik['labels'][] = $det['tgl'];   
                $grafik['datasets'][0]['backgroundColor'] = 'blue';        
                $grafik['datasets'][0]['borderColor'] = 'blue';        
                $grafik['datasets'][0]['data'][] = $det['suhu'];      
                $grafik['datasets'][0]['label'] = 'Suhu';
                $grafik['datasets'][0]['fill'] = false;
                
                $grafik['datasets'][1]['backgroundColor'] = 'yellow';        
                $grafik['datasets'][1]['borderColor'] = 'yellow';        
                $grafik['datasets'][1]['data'][] = $det['nadi'];      
                $grafik['datasets'][1]['label'] = 'Nadi';
                $grafik['datasets'][1]['fill'] = false;
                
                $grafik['datasets'][2]['backgroundColor'] = 'red';        
                $grafik['datasets'][2]['borderColor'] = 'red';        
                $grafik['datasets'][2]['data'][] = $det['sistolik'];      
                $grafik['datasets'][2]['label'] = 'Sistolik';
                $grafik['datasets'][2]['fill'] = false;
                
                $grafik['datasets'][3]['backgroundColor'] = 'green';        
                $grafik['datasets'][3]['borderColor'] = 'green';        
                $grafik['datasets'][3]['data'][] = $det['diastolik'];      
                $grafik['datasets'][3]['label'] = 'Diastolik';
                $grafik['datasets'][3]['fill'] = false;
                
                $grafik['datasets'][4]['backgroundColor'] = 'grey';        
                $grafik['datasets'][4]['borderColor'] = 'grey';        
                $grafik['datasets'][4]['data'][] = $det['respirasi'];      
                $grafik['datasets'][4]['label'] = 'Respirasi';
                $grafik['datasets'][4]['fill'] = false;
                
            }
        }
        
        $this->render('index', [
            'modPendaftaran'=>$modPendaftaran,
            'modPenyulitHD'=>$modPenyulitHD,
            'modTransfusi'=>$modTransfusi,
            'modGizi'=>$modGizi,
            'modAwalDialisis'=>$modAwalDialisis,
            'grafik'=>$grafik,
            'modPemeriksaanLab' => $modPemeriksaanLab
        ]);
    }
    
    public function actionSetDataPasien(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $_POST['id'];
            $mod = PendaftaranT::model()->findByPk($id);
            $data['no_pendaftaran'] = $mod->no_pendaftaran;
            $data['tgl_pendaftaran'] = $mod->tgl_pendaftaran;
            $data['umur'] = $mod->umur;
            $data['dokter_pemeriksa'] = $mod->dokter->nama_pegawai;
            $data['no_rm'] = $mod->pasien->no_rekam_medik;
            $data['nama_pasien'] = $mod->pasien->nama_pasien;
            $data['jk'] = $mod->pasien->jeniskelamin;
            $data['cara_bayar'] = $mod->carabayar->carabayar_nama;
            $data['penjamin'] = $mod->penjamin->penjamin_nama;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
}

