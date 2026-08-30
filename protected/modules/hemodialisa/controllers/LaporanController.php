<?php

class LaporanController extends MyAuthController {

    public function actionLaporanSensusHarian() {
		$modPasLaporanPasienMeninggalien = new HDPasienM;
        $model = new HDLaporansensusharian('search');
		$modPasien = new HDPasienM();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        if (isset($_GET['HDLaporansensusharian'])) {
            $model->attributes = $_GET['HDLaporansensusharian'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporansensusharian']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial('hemodialisa.views.laporan.sensus._table', array('model'=>$model),true);
			}else{
				$this->render('sensus/adminSensus', array(
				'model' => $model, 'modPasien' => $modPasien
			));
		}
        
    }

    public function actionPrintLaporanSensusHarian() {
        $model = new HDLaporansensusharian('searchPrint');
        $judulLaporan = 'Laporan Sensus Harian Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        if (isset($_REQUEST['HDLaporansensusharian'])) {
            $model->attributes = $_REQUEST['HDLaporansensusharian'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporansensusharian']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'sensus/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikSensusHarian() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporansensusharian();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        
        if (isset($_GET['HDLaporansensusharian'])) {
            $model->attributes = $_GET['HDLaporansensusharian'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporansensusharian']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }  
    
    public function actionLaporanSurveilans() {
        $model = new HDLaporansurveilansV();  
        $format = new MyFormatter();
        $model->tgl_awal = date('d M Y'); 
        $model->tgl_akhir = date('d M Y');  
		$model->jumlah_tampil = 1;
            if(isset($_GET['HDLaporansurveilansV'])) {
                $model->attributes = $_GET['HDLaporansurveilansV'];  
                $model->instalasi_id = $_GET['HDLaporansurveilansV']['instalasi_id'];
               
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporansurveilansV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporansurveilansV']['tgl_akhir']);         
            } 
          
				$this->render('surveilans/adminSurveilans', array(
				'model' => $model, 
				'format'=>$format, 
				
			));
		
        
    } 
    
     public function actionPrintLaporanSurveilans() {
        $model = new HDLaporansurveilansV();
       // $judulLaporan = 'Laporan Surveilans Hais';
        $model->jumlah_tampil = 1;
        //Data Grafik
        $data['title'] = 'Grafik Laporan Surveilans Hais';
        $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        if (isset($_REQUEST['HDLaporansurveilansV'])) {
            $model->attributes = $_REQUEST['HDLaporansurveilansV'];  
           $model->instalasi_id = $_REQUEST['HDLaporansurveilansV']['instalasi_id'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporansurveilansV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporansurveilansV']['tgl_akhir']);
        } 
		if ($_REQUEST['HDLaporansurveilansV']['pilihan_tab'] == 'report') {
			 $judulLaporan = 'Laporan Surveilans Hais';
			 $target = 'surveilans/_print'; 
			 $caraPrint = $_REQUEST['caraPrint'];
					
		} else if($_REQUEST['HDLaporansurveilansV']['pilihan_tab'] == 'rekap') {
			 $judulLaporan = 'Laporan Surveilans Hais'; 
			 $target = 'surveilans/_printRekap'; 
			 $caraPrint = $_REQUEST['caraPrint'];
				
		}
               
//        $caraPrint = $_REQUEST['caraPrint'];
//        $target = 'surveilans/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    } 
    
    public function actionFrameGrafikSurveilans() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporansurveilansV('searchGrafik');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Surveilans';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        
        if (isset($_GET['HDLaporansurveilansV'])) {
            $model->attributes = $_GET['HDLaporansurveilansV']; 
        //    $model->instalasi_id = $_GET['HDLaporansurveilansV']['instalasi_id'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporansurveilansV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporansurveilansV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    } 
	
	 public function actionLaporanIRR() {
        $model = new HDLaporanpreskripsiV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y'); 
        if (isset($_GET['HDLaporanpreskripsiV'])) {
            $model->attributes = $_GET['HDLaporanpreskripsiV']; 
			$model->ruangan_id = $_GET['HDLaporanpreskripsiV']['ruangan_id']; 
			$model->obat_hemapo = $_GET['HDLaporanpreskripsiV']['obat_hemapo']; 
			$model->obat_recormon = $_GET['HDLaporanpreskripsiV']['obat_recormon'];  
			$model->obat_eprex = $_GET['HDLaporanpreskripsiV']['obat_eprex'];  	   
            $model->dialiserke = $_GET['HDLaporanpreskripsiV']['dialiserke'];  	  
			$model->penyulit_teknis = $_GET['HDLaporanpreskripsiV']['penyulit_teknis'];   
			$model->periksahd_penyulit = $_GET['HDLaporanpreskripsiV']['periksahd_penyulit'];  
            $model->heparin_continyu_cek = $_GET['HDLaporanpreskripsiV']['heparin_continyu_cek']; 
            $model->prep_besi_cek = $_GET['HDLaporanpreskripsiV']['prep_besi_cek']; 
            $model->ultrafiltrasi_mode_cek = $_GET['HDLaporanpreskripsiV']['ultrafiltrasi_mode_cek'];
            $model->natrium_mode_cek = $_GET['HDLaporanpreskripsiV']['natrium_mode_cek'];
            $model->lama_uso_uf_cek = $_GET['HDLaporanpreskripsiV']['lama_uso_uf_cek'];
            $model->iso_uf_ml_cek = $_GET['HDLaporanpreskripsiV']['iso_uf_ml_cek'];
            $model->bicarbonat_mode_cek = $_GET['HDLaporanpreskripsiV']['bicarbonat_mode_cek'];
            $model->tanpaheparin_nama_cek = $_GET['HDLaporanpreskripsiV']['tanpaheparin_nama_cek'];
            $model->heparin_lmwh_cek = $_GET['HDLaporanpreskripsiV']['heparin_lmwh_cek'];
            $model->heparin_intermiten_cek = $_GET['HDLaporanpreskripsiV']['heparin_intermiten_cek'];
            $model->kec_darah_qb = $_GET['HDLaporanpreskripsiV']['kec_darah_qb']; 
            $model->obat_renogen = $_GET['HDLaporanpreskripsiV']['obat_renogen']; 
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpreskripsiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpreskripsiV']['tgl_akhir']);
        }
//        if (Yii::app()->request->isAjaxRequest) {
//			echo $this->renderPartial('hemodialisa.views.laporan.iRR._table', array('model'=>$model),true);
//			}else{
				$this->render('iRR/adminIRR', array(
				'model' => $model
			));
	//	}
        
    }

    public function actionPrintLaporanIRR() {
        $model = new HDLaporanpreskripsiV('searchPrint');
        $judulLaporan = 'Laporan IRR';

        //Data Grafik
        $data['title'] = 'Grafik Laporan IRR';
        $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        if (isset($_REQUEST['HDLaporanpreskripsiV'])) {
            $model->attributes = $_REQUEST['HDLaporanpreskripsiV']; 
			$model->ruangan_id = $_GET['HDLaporanpreskripsiV']['ruangan_id']; 
			$model->obat_hemapo = $_GET['HDLaporanpreskripsiV']['obat_hemapo']; 
			$model->lamahd_jam = $_GET['HDLaporanpreskripsiV']['lamahd_jam']; 	 
			$model->obat_recormon = $_GET['HDLaporanpreskripsiV']['obat_recormon'];  
			$model->obat_eprex = $_GET['HDLaporanpreskripsiV']['obat_eprex'];  	 
			$model->penyulit_teknis = $_GET['HDLaporanpreskripsiV']['penyulit_teknis'];   
			$model->periksahd_penyulit = $_GET['HDLaporanpreskripsiV']['periksahd_penyulit']; 
            $model->heparin_continyu_cek = $_GET['HDLaporanpreskripsiV']['heparin_continyu_cek'];
            $model->prep_besi_cek = $_GET['HDLaporanpreskripsiV']['prep_besi_cek']; 
            $model->ultrafiltrasi_mode_cek = $_GET['HDLaporanpreskripsiV']['ultrafiltrasi_mode_cek'];
            $model->natrium_mode_cek = $_GET['HDLaporanpreskripsiV']['natrium_mode_cek'];
            $model->lama_uso_uf_cek = $_GET['HDLaporanpreskripsiV']['lama_uso_uf_cek'];
            $model->iso_uf_ml_cek = $_GET['HDLaporanpreskripsiV']['iso_uf_ml_cek'];
            $model->bicarbonat_mode_cek = $_GET['HDLaporanpreskripsiV']['bicarbonat_mode_cek'];
            $model->tanpaheparin_nama_cek = $_GET['HDLaporanpreskripsiV']['tanpaheparin_nama_cek'];
            $model->heparin_lmwh_cek = $_GET['HDLaporanpreskripsiV']['heparin_lmwh_cek'];
            $model->heparin_intermiten_cek = $_GET['HDLaporanpreskripsiV']['heparin_intermiten_cek'];
            $model->kec_darah_qb = $_GET['HDLaporanpreskripsiV']['kec_darah_qb']; 
            $model->dialiserke = $_GET['HDLaporanpreskripsiV']['dialiserke']; 
            $model->obat_renogen = $_GET['HDLaporanpreskripsiV']['obat_renogen']; 
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporanpreskripsiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporanpreskripsiV']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'iRR/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikIRR() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporanpreskripsiV('searchGrafik');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan IRR';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        
        if (isset($_GET['HDLaporanpreskripsiV'])) {
            $model->attributes = $_GET['HDLaporanpreskripsiV']; 
			$model->ruangan_id = $_GET['HDLaporanpreskripsiV']['ruangan_id'];  
            $model->dialiserke = $_GET['HDLaporanpreskripsiV']['dialiserke'];
			$model->obat_hemapo = $_GET['HDLaporanpreskripsiV']['obat_hemapo']; 
			$model->obat_recormon = $_GET['HDLaporanpreskripsiV']['obat_recormon'];  
			$model->obat_eprex = $_GET['HDLaporanpreskripsiV']['obat_eprex'];  	 
			$model->penyulit_teknis = $_GET['HDLaporanpreskripsiV']['penyulit_teknis'];  
			$model->periksahd_penyulit = $_GET['HDLaporanpreskripsiV']['periksahd_penyulit'];
            $model->obat_renogen = $_GET['HDLaporanpreskripsiV']['obat_renogen']; 
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpreskripsiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpreskripsiV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    } 
	
	
	//Laporan Kunjungan HD 
	
	public function actionLaporanKunjunganHD() {
		$model = new HDLaporankunjunganhdV('search'); 
		$model->tgl_awal = date('Y-m-d');
		$model->tgl_akhir = date('Y-m-d'); 
		$format = new MyFormatter(); 
		
		    if(isset($_GET['HDLaporankunjunganhdV'])) {
				$model->attributes = $_GET['HDLaporankunjunganhdV'];            
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporankunjunganhdV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporankunjunganhdV']['tgl_akhir']);
                $model->carabayar_id = isset($_GET['HDLaporankunjunganhdV']['carabayar_id']) ? $_GET['HDLaporankunjunganhdV']['carabayar_id'] : null;
                $model->penjamin_id = isset($_GET['HDLaporankunjunganhdV']['penjamin_id']) ? $_GET['HDLaporankunjunganhdV']['penjamin_id'] : null;
						
			} 
			 if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.kunjunganHD._tableKunjungan', array('model'=>$model),true);
                }else{
                   $this->render('kunjunganHD/adminKunjungan', array(
                    'model' => $model,
                ));
            }
		
	} 
	
	public function actionPrintLaporanKunjunganHD() {
        $model = new HDLaporankunjunganhdV('search');
        $judulLaporan = 'Laporan Kunjungan Hemodialis';
		$format = new MyFormatter();
		
        //Data Grafik       
        $data['title'] = 'Grafik Laporan Info Kunjungan';
        $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        if (isset($_REQUEST['HDLaporankunjunganhdV'])) {
            $model->attributes = $_REQUEST['HDLaporankunjunganhdV'];
            
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporankunjunganhdV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporankunjunganhdV']['tgl_akhir']);
			$model->carabayar_id = isset($_GET['HDLaporankunjunganhdV']['carabayar_id']) ? $_GET['HDLaporankunjunganhdV']['carabayar_id'] : null;
            $model->penjamin_id = isset($_GET['HDLaporankunjunganhdV']['penjamin_id']) ? $_GET['HDLaporankunjunganhdV']['penjamin_id'] : null;
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'kunjunganHD/_printKunjungan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikKunjunganHD() {
        $this->layout = '//layouts/iframe';
		$format = new MyFormatter();
        $model = new HDLaporankunjunganhdV('searchGrafik');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        //Data Grafik
        $data['title'] = 'Grafik Info Kunjungan';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        if (isset($_GET['HDLaporankunjunganhdV'])) {
            $model->attributes = $_GET['HDLaporankunjunganhdV'];            
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporankunjunganhdV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporankunjunganhdV']['tgl_akhir']);
			$model->carabayar_id = isset($_GET['HDLaporankunjunganhdV']['carabayar_id']) ? $_GET['HDLaporankunjunganhdV']['carabayar_id'] : null;
            $model->penjamin_id = isset($_GET['HDLaporankunjunganhdV']['penjamin_id']) ? $_GET['HDLaporankunjunganhdV']['penjamin_id'] : null;
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanKunjungan() {
        $model = new HDLaporankunjunganrdV('search');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
		$format = new MyFormatter();
		
        if (isset($_GET['HDLaporankunjunganrdV'])) {
            $model->attributes = $_GET['HDLaporankunjunganrdV'];            
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporankunjunganrdV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporankunjunganrdV']['tgl_akhir']);
            $model->carabayar_id = isset($_GET['HDLaporankunjunganrdV']['carabayar_id']) ? $_GET['HDLaporankunjunganrdV']['carabayar_id'] : null;
            $model->penjamin_id = isset($_GET['HDLaporankunjunganrdV']['penjamin_id']) ? $_GET['HDLaporankunjunganrdV']['penjamin_id'] : null;
            $model->propinsi_id = isset($_GET['HDLaporankunjunganrdV']['propinsi_id']) ? $_GET['HDLaporankunjunganrdV']['propinsi_id'] : null;
            $model->kabupaten_id = isset($_GET['HDLaporankunjunganrdV']['kabupaten_id']) ? $_GET['HDLaporankunjunganrdV']['kabupaten_id'] : null;
			$model->pilihanx = isset($_GET['HDLaporankunjunganrdV']['pilihanx']) ? $_GET['HDLaporankunjunganrdV']['pilihanx'] : null;

//			echo "<pre>";
//			print_r($model->tgl_awal."-".$model->tgl_akhir);exit;
        }

        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.kunjungan._tableKunjungan', array('model'=>$model),true);
                }else{
                   $this->render('kunjungan/adminKunjungan', array(
                    'model' => $model,
                ));
            }    
    } 
	
	

    public function actionPrintLaporanKunjungan() {
        $model = new HDLaporankunjunganrdV('search');
        $judulLaporan = 'Laporan Info Kunjungan Pasien Rawat Jalan';
		$format = new MyFormatter();
		
        //Data Grafik       
        $data['title'] = 'Grafik Laporan Info Kunjungan';
        $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        if (isset($_REQUEST['HDLaporankunjunganrdV'])) {
            $model->attributes = $_REQUEST['HDLaporankunjunganrdV'];
            
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporankunjunganrdV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporankunjunganrdV']['tgl_akhir']);
			$model->carabayar_id = isset($_GET['HDLaporankunjunganrdV']['carabayar_id']) ? $_GET['HDLaporankunjunganrdV']['carabayar_id'] : null;
            $model->penjamin_id = isset($_GET['HDLaporankunjunganrdV']['penjamin_id']) ? $_GET['HDLaporankunjunganrdV']['penjamin_id'] : null;
            $model->propinsi_id = isset($_GET['HDLaporankunjunganrdV']['propinsi_id']) ? $_GET['HDLaporankunjunganrdV']['propinsi_id'] : null;
            $model->kabupaten_id = isset($_GET['HDLaporankunjunganrdV']['kabupaten_id']) ? $_GET['HDLaporankunjunganrdV']['kabupaten_id'] : null;
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'kunjungan/_printKunjungan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikKunjungan() {
        $this->layout = '//layouts/iframe';
		$format = new MyFormatter();
        $model = new HDLaporankunjunganrdV('searchGrafik');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        //Data Grafik
        $data['title'] = 'Grafik Info Kunjungan';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        if (isset($_GET['HDLaporankunjunganrdV'])) {
            $model->attributes = $_GET['HDLaporankunjunganrdV'];            
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporankunjunganrdV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporankunjunganrdV']['tgl_akhir']);
			$model->carabayar_id = isset($_GET['HDLaporankunjunganrdV']['carabayar_id']) ? $_GET['HDLaporankunjunganrdV']['carabayar_id'] : null;
            $model->penjamin_id = isset($_GET['HDLaporankunjunganrdV']['penjamin_id']) ? $_GET['HDLaporankunjunganrdV']['penjamin_id'] : null;
            $model->propinsi_id = isset($_GET['HDLaporankunjunganrdV']['propinsi_id']) ? $_GET['HDLaporankunjunganrdV']['propinsi_id'] : null;
            $model->kabupaten_id = isset($_GET['HDLaporankunjunganrdV']['kabupaten_id']) ? $_GET['HDLaporankunjunganrdV']['kabupaten_id'] : null;
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBukuRegister() {
        $model = new HDBukuregisterpasien('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
		$modPasien = new HDPasienM;

        if (isset($_GET['HDBukuregisterpasien'])) {
            $model->attributes = $_GET['HDBukuregisterpasien'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDBukuregisterpasien']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDBukuregisterpasien']['tgl_akhir']);
        }
         if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.bukuRegister._tableBukuRegister', array('model'=>$model),true);
                }else{
                    $this->render('bukuRegister/adminBukuRegister', array(
                    'model' => $model, 'modPasien'=>$modPasien
                ));
            }
    }

    public function actionPrintLaporanBukuRegister() {
        $model = new HDBukuregisterpasien('search');
        $judulLaporan = 'Laporan Buku Register Pasien Rawat Jalan';

        //Data Grafik   
        $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Jalan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDBukuregisterpasien'])) {
            $model->attributes = $_REQUEST['HDBukuregisterpasien'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDBukuregisterpasien']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDBukuregisterpasien']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'bukuRegister/_printBukuRegister';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikBukuRegister() {
        $this->layout = '//layouts/iframe';
        $model = new HDBukuregisterpasien('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Jalan';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDBukuregisterpasien'])) {
            $model->attributes = $_GET['HDBukuregisterpasien'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDBukuregisterpasien']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDBukuregisterpasien']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporan10BesarPenyakit() {
        $model = new HDLaporan10besarpenyakit('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $model->jumlahTampil = 10;

        if (isset($_GET['HDLaporan10besarpenyakit'])) {
            $model->attributes = $_GET['HDLaporan10besarpenyakit'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporan10besarpenyakit']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.10Besar._table10Besar', array('model'=>$model),true);
                }else{
                    $this->render('10Besar/admin10BesarPenyakit', array(
                    'model' => $model,
                ));
            }
    }

    public function actionPrintLaporan10BesarPenyakit() {
        $model = new HDLaporan10besarpenyakit('search');
        $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Gawat Darurat';

        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporan10besarpenyakit'])) {
            $model->attributes = $_REQUEST['HDLaporan10besarpenyakit'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporan10besarpenyakit']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = '10Besar/_print10Besar';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafik10BesarPenyakit() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporan10besarpenyakit('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDLaporan10besarpenyakit'])) {
            $model->attributes = $_GET['HDLaporan10besarpenyakit'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporan10besarpenyakit']['tgl_akhir']);
        }
               
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanCaraMasukPasien() {
        $model = new HDLaporancaramasukpasienrd('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');
        $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'),'asalrujukan_id','asalrujukan_id');
        $model->asalrujukan_id = $asalrujukan;
        if (isset($_GET['HDLaporancaramasukpasienrd'])) {
            $model->attributes = $_GET['HDLaporancaramasukpasienrd'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporancaramasukpasienrd']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporancaramasukpasienrd']['tgl_akhir']);
        }

        $this->render('caraMasuk/adminCaraMasukPasien', array(
            'model' => $model, 'filter'=>$filter
        ));
    }

    public function actionPrintLaporanCaraMasukPasien() {
        $model = new HDLaporancaramasukpasienrd('search');
        $judulLaporan = 'Laporan Cara Masuk Pasien Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporancaramasukpasienrd'])) {
            $model->attributes = $_REQUEST['HDLaporancaramasukpasienrd'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporancaramasukpasienrd']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporancaramasukpasienrd']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'caraMasuk/_printCaraMasuk';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanCaraMasukPasien() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporancaramasukpasienrd('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDLaporancaramasukpasienrd'])) {
            $model->attributes = $_GET['HDLaporancaramasukpasienrd'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporancaramasukpasienrd']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporancaramasukpasienrd']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanTindakLanjut() {
        $model = new HDLaporantindaklanjutrd('search');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $carakeluar = CHtml::listData(CarakeluarM::model()->findAll('carakeluar_id IN(1,4,6,7) AND carakeluar_aktif = true'), 'carakeluar_id', 'carakeluar_id');
        $model->carakeluar_id = $carakeluar;
        
        if (isset($_GET['HDLaporantindaklanjutrd'])) {
            $model->attributes = $_GET['HDLaporantindaklanjutrd'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporantindaklanjutrd']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporantindaklanjutrd']['tgl_akhir']);
			$model->carakeluar_id = $_GET['HDLaporantindaklanjutrd']['carakeluar_id'];
        }
        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.tindakLanjut._tableTindakLanjut', array('model'=>$model),true);
                }else{
                   $this->render('tindakLanjut/adminTindakLanjut', array(
                    'model' => $model,
                ));
            }
        
    }

    public function actionPrintLaporanTindakLanjut() {
        $model = new HDLaporantindaklanjutrd('search');
        $judulLaporan = 'Laporan Tindak Lanjut Pasien Rawat Jalan';
		$carakeluar = CHtml::listData(CarakeluarM::model()->findAll('carakeluar_id IN(1,4,6,7) AND carakeluar_aktif = true'), 'carakeluar_id', 'carakeluar_id');
        $model->carakeluar_id = $carakeluar;
        //Data Grafik
        $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporantindaklanjutrd'])) {
            $model->attributes = $_REQUEST['HDLaporantindaklanjutrd'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporantindaklanjutrd']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporantindaklanjutrd']['tgl_akhir']);
			$model->carakeluar_id = $_GET['HDLaporantindaklanjutrd']['carakeluar_id'];
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'tindakLanjut/_printTindakLanjut';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanTindakLanjut() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporantindaklanjutrd('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
		$carakeluar = CHtml::listData(CarakeluarM::model()->findAll('carakeluar_id IN(1,4,6,7) AND carakeluar_aktif = true'), 'carakeluar_id', 'carakeluar_id');
        $model->carakeluar_id = $carakeluar;
        //Data Grafik 
        $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDLaporantindaklanjutrd'])) {
            $model->attributes = $_GET['HDLaporantindaklanjutrd'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporantindaklanjutrd']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporantindaklanjutrd']['tgl_akhir']);
			$model->carakeluar_id = $_GET['HDLaporantindaklanjutrd']['carakeluar_id'];
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanKonsulAntarPoli() {
        $model = new HDLaporankonsulantarpoli('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');
        $ruanganrawatjalan = CHtml::listData(RuanganrawatjalanV::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
        $model->ruangantujuan_id = $ruanganrawatjalan;
        if (isset($_GET['HDLaporankonsulantarpoli'])) {
            $model->attributes = $_GET['HDLaporankonsulantarpoli'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporankonsulantarpoli']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporankonsulantarpoli']['tgl_akhir']);
        }

        $this->render('konsulPoli/adminKonsulAntarPoli', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanKonsulAntarPoli() {
        $model = new HDLaporankonsulantarpoli('search');
        $judulLaporan = 'Laporan Konsul Antar Poli Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Konsul Antar Poli';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporankonsulantarpoli'])) {
            $model->attributes = $_REQUEST['HDLaporankonsulantarpoli'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporankonsulantarpoli']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporankonsulantarpoli']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'konsulPoli/_printKonsulPoli';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanKonsulAntarPoli() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporankonsulantarpoli('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Konsul Antar Poli';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDLaporankonsulantarpoli'])) {
            $model->attributes = $_GET['HDLaporankonsulantarpoli'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporankonsulantarpoli']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporankonsulantarpoli']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanKepenunjang() {
        $model = new HDLaporankepenunjangrd('search');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');    
        $kepenunjang = CHtml::listData(RuanganpenunjangV::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
        $model->ruanganpenunj_id = $kepenunjang;
        if (isset($_GET['HDLaporankepenunjangrd'])) {
            $model->attributes = $_GET['HDLaporankepenunjangrd'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporankepenunjangrd']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporankepenunjangrd']['tgl_akhir']);
        }
         if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.kepenunjang._tableKepenunjang', array('model'=>$model),true);
                }else{
                    $this->render('kepenunjang/adminKepenunjang', array(
                    'model' => $model,
                ));
            }
    }

    public function actionPrintLaporanKepenunjang() {
        $model = new HDLaporankepenunjangrd('search');
        $judulLaporan = 'Laporan Pasien Masuk Penunjang';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Kepenunjang';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporankepenunjangrd'])) {
            $model->attributes = $_REQUEST['HDLaporankepenunjangrd'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporankepenunjangrd']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporankepenunjangrd']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'kepenunjang/_printKepenunjang';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanKepenunjang() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporankepenunjangrd('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Kepenunjang';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDLaporankepenunjangrd'])) {
            $model->attributes = $_GET['HDLaporankepenunjangrd'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporankepenunjangrd']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporankepenunjangrd']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBiayaPelayanan() {
        $model = new HDLaporanbiayapelayanan('search');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');  
        $filter=null;
        $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        if (isset($_GET['HDLaporanbiayapelayanan'])) {
            $model->attributes = $_GET['HDLaporanbiayapelayanan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanbiayapelayanan']['tgl_akhir']);
            $model->carabayar_id = isset($_GET['HDLaporanbiayapelayanan']['carabayar_id']) ? $_GET['HDLaporanbiayapelayanan']['carabayar_id'] : null;
                $model->penjamin_id = isset($_GET['HDLaporanbiayapelayanan']['penjamin_id']) ? $_GET['HDLaporanbiayapelayanan']['penjamin_id'] : null;
        }
        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.biayaPelayanan._tableBiayaPelayanan', array('model'=>$model),true);
                }else{
                   $this->render('biayaPelayanan/adminBiayaPelayanan', array(
                    'model' => $model, 'filter'=>$filter
                ));
            }
        
    }

    public function actionPrintLaporanBiayaPelayanan() {
        $model = new HDLaporanbiayapelayanan('search');
        $judulLaporan = 'Laporan Biaya Pelayanan Rawat Jalan';

        //Data Grafik        
        $data['title'] = 'Grafik Laporan Biaya Pelayanan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporanbiayapelayanan'])) {
            $model->attributes = $_REQUEST['HDLaporanbiayapelayanan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporanbiayapelayanan']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'biayaPelayanan/_printBiayaPelayanan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanBiayaPelayanan() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporanbiayapelayanan('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Biaya Pelayanan';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDLaporanbiayapelayanan'])) {
            $model->attributes = $_GET['HDLaporanbiayapelayanan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanbiayapelayanan']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPendapatanRuangan() {
        $model = new HDLaporanpendapatanruangan('search');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');  
        $filter=null;
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        if (isset($_GET['HDLaporanpendapatanruangan'])) {
            $model->attributes = $_GET['HDLaporanpendapatanruangan'];
            $model->nama_pegawai = $_GET['HDLaporanpendapatanruangan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpendapatanruangan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpendapatanruangan']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.pendapatanRuangan._tablePendapatanRuangan', array('model'=>$model),true);
                }else{
                    $this->render('pendapatanRuangan/adminPendapatanRuangan', array(
                    'model' => $model, 'filter'=>$filter
                ));
            }
        
    }

    public function actionPrintLaporanPendapatanRuangan() {
        $model = new HDLaporanpendapatanruangan('search');
        $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Rawat Jalan';

        //Data Grafik        
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporanpendapatanruangan'])) {
            $model->attributes = $_REQUEST['HDLaporanpendapatanruangan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporanpendapatanruangan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporanpendapatanruangan']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pendapatanRuangan/_printPendapatanRuangan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanPendapatanRuangan() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporanpendapatanruangan('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDLaporanpendapatanruangan'])) {
            $model->attributes = $_GET['HDLaporanpendapatanruangan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpendapatanruangan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpendapatanruangan']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanJasaInstalasi() {
        $model = new HDLaporanjasainstalasi('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $filter=null;
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $model->tindakansudahbayar_id = CustomFunction::getStatusBayar();
        if (isset($_GET['HDLaporanjasainstalasi'])) {
            $model->attributes = $_GET['HDLaporanjasainstalasi'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanjasainstalasi']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.jasaInstalasi._tableJasaInstalasi', array('model'=>$model),true);
                }else{
                      $this->render('jasaInstalasi/adminJasaInstalasi', array(
                        'model' => $model, 'filter'=>$filter
                    ));
            }
       
    }

    public function actionPrintLaporanJasaInstalasi() {
        $model = new HDLaporanjasainstalasi('search');
        $judulLaporan = 'Laporan Jasa Instalasi Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporanjasainstalasi'])) {
            $model->attributes = $_REQUEST['HDLaporanjasainstalasi'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporanjasainstalasi']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'jasaInstalasi/_printJasaInstalasi';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJasaInstalasi() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporanjasainstalasi('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDLaporanjasainstalasi'])) {
            $model->attributes = $_GET['HDLaporanjasainstalasi'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanjasainstalasi']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionLaporanPemakaiObatAlkes()
    {
        $model = new HDLaporanpemakaiobatalkesV;
        $model->unsetAttributes();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $jenisObat =CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_id');
        $model->jenisobatalkes_id = $jenisObat;
        if(isset($_GET['HDLaporanpemakaiobatalkesV']))
        {
            $model->attributes = $_GET['HDLaporanpemakaiobatalkesV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpemakaiobatalkesV']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.pemakaiObatAlkes._tablePemakaiObatAlkes', array('model'=>$model),true);
                }else{
                     $this->render('pemakaiObatAlkes/adminPemakaiObatAlkes',array('model'=>$model));
            }
       
    }

    public function actionPrintLaporanPemakaiObatAlkes() {
        $model = new HDLaporanpemakaiobatalkesV('search');
        $judulLaporan = 'Laporan Info Pemakai Obat Alkes Rawat Jalan';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporanpemakaiobatalkesV'])) {
            $model->attributes = $_REQUEST['HDLaporanpemakaiobatalkesV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporanpemakaiobatalkesV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemakaiObatAlkes/_printPemakaiObatAlkes';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    

    public function actionFrameGrafikLaporanPemakaiObatAlkes() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporanpemakaiobatalkesV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDLaporanpemakaiobatalkesV'])) {
            $model->attributes = $_GET['HDLaporanpemakaiobatalkesV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpemakaiobatalkesV']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionLaporanPasienMeninggal() {
		$modPasien = new HDPasienM;
        $model = new HDLaporanpasienmeninggalV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        //$caramasuk = CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_id');
        //$model->caramasuk_id = HDLaporanpasienmeninggalV;
        if (isset($_GET['HDLaporanpasienmeninggalV'])) {
            $model->attributes = $_GET['HDLaporanpasienmeninggalV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpasienmeninggalV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpasienmeninggalV']['tgl_akhir']);
        }

         if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.pasienMeninggal._table', array('model'=>$model),true);
                }else{
                     $this->render('pasienMeninggal/index', array(
                    'model' => $model, 'modPasien' => $modPasien
                ));
            }

    }

    public function actionPrintLaporanPasienMeninggal() {
        $model = new HDLaporanpasienmeninggalV('search');
        $judulLaporan = 'Laporan Pasien Meninggal';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Meninggal';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporanpasienmeninggalV'])) {
            $model->attributes = $_REQUEST['HDLaporanpasienmeninggalV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporanpasienmeninggalV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporanpasienmeninggalV']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pasienMeninggal/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPasienMeninggal() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporanpasienmeninggalV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Meninggal';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['HDLaporanpasienmeninggalV'])) {
            $model->attributes = $_GET['HDLaporanpasienmeninggalV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpasienmeninggalV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpasienmeninggalV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionLaporanTriasePasien() {
        $model = new HDLaporantriasepasienV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        //$caramasuk = CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_id');
        //$model->caramasuk_id = HDLaporanpasienmeninggalV;
        $triase = CHtml::listData(Triase::model()->findAll(), 'triase_id', 'triase_id');
        $model->triase_id = $triase;
        if (isset($_GET['HDLaporantriasepasienV'])) {
            $model->attributes = $_GET['HDLaporantriasepasienV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporantriasepasienV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporantriasepasienV']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.triase._table', array('model'=>$model),true);
                }else{
                   $this->render('triase/index', array(
                    'model' => $model,
                    ));
            }

        
    }

    public function actionPrintLaporanTriasePasien() {
        $model = new HDLaporantriasepasienV('search');
        $judulLaporan = 'Laporan Pasien Meninggal';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Meninggal';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporantriasepasienV'])) {
            $model->attributes = $_REQUEST['HDLaporantriasepasienV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporantriasepasienV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporantriasepasienV']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'triase/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikTriasePasien() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporantriasepasienV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Meninggal';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['HDLaporantriasepasienV'])) {
            $model->attributes = $_GET['HDLaporantriasepasienV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporantriasepasienV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporantriasepasienV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionLaporanPasienDirujuk() {
        $model = new HDLaporanpasiendirujukV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        //$caramasuk = CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_id');
        $rujuk = CHtml::listData(RujukankeluarM::model()->findAll(), 'rujukankeluar_id', 'rujukankeluar_id');
        $model->rujukankeluar_id = $rujuk;
        if (isset($_GET['HDLaporanpasiendirujukV'])) {
            $model->attributes = $_GET['HDLaporanpasiendirujukV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpasiendirujukV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpasiendirujukV']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('hemodialisa.views.laporan.pasienDirujuk._table', array('model'=>$model),true);
                }else{
                    $this->render('pasienDirujuk/index', array(
                    'model' => $model,
                    ));
            }


       
    }

    public function actionPrintLaporanPasienDirujuk() {
        $model = new HDLaporanpasiendirujukV('search');
        $judulLaporan = 'Laporan Pasien Dirujuk';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Dirujuk';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporanpasiendirujukV'])) {
            $model->attributes = $_REQUEST['HDLaporanpasiendirujukV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporanpasiendirujukV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporanpasiendirujukV']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pasienDirujuk/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanPasienDirujuk() {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporanpasiendirujukV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Dirujuk';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['HDLaporanpasiendirujukV'])) {
            $model->attributes = $_GET['HDLaporanpasiendirujukV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanpasiendirujukV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanpasiendirujukV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array( 
            'model' => $model,
            'data' => $data,
        ));
    }
	
	public function actionLaporanAustralasianTriage() {
        $model = new HDLaporanaustralasiantriageV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        if (isset($_GET['HDLaporanaustralasiantriageV'])) {
            $model->attributes = $_GET['HDLaporanaustralasiantriageV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanaustralasiantriageV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanaustralasiantriageV']['tgl_akhir']);
        }
		
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition('tgl_pendaftaran', $model->tgl_awal, $model->tgl_akhir);
		$models = HDLaporanaustralasiantriageV::model()->findAll($criteria);

        if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial('hemodialisa.views.laporan.australasianTriage._table', array('model'=>$model,'models'=>$models),true);
		}else{
			$this->render('australasianTriage/adminAustralasianTriage', array(
			'model' => $model,'models'=>$models,
			));
		}

    }
	
	public function actionPrintLaporanAustralasianTriage() {
        $model = new HDLaporanaustralasiantriageV('search');
        $judulLaporan = 'Laporan Australasian Triage';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Australasian Triage';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDLaporanaustralasiantriageV'])) {
            $model->attributes = $_REQUEST['HDLaporanaustralasiantriageV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporanaustralasiantriageV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporanaustralasiantriageV']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'australasianTriage/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);

    }
	
	public function actionFrameGrafikAustralasianTriage() {
        $this->layout = '//layouts/iframe';
		$format = new MyFormatter();
        $model = new HDLaporanaustralasiantriageV('searchGrafik');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Australasian Triage';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        if (isset($_GET['HDLaporanaustralasiantriageV'])) {
            $model->attributes = $_GET['HDLaporanaustralasiantriageV'];            
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporanaustralasiantriageV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporanaustralasiantriageV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    protected function printFunction($model,$data, $caraPrint, $judulLaporan, $target){ // $modDetail untuk apa?
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
//        echo $caraPrint;
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint ));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
    
    protected function parserTanggal($tgl){
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row){
        if (!empty($row)){
            $result[] = $row;
        }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'),'medium',null).' '.$result[1];
        
    }
	   
	public function actionGetPenjaminPasien($encode=false,$model_nama='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $modPasien = new HDPasienM;
		   if($model_nama !=='' && $attr == ''){
			   $carabayar_id = $_POST["$model_nama"]['carabayar_id'];
		   }
			elseif ($model_nama == '' && $attr !== '') {
			   $carabayar_id = $_POST["$attr"];
		   }
		   elseif ($model_nama !== '' && $attr !== '') {
			   $carabayar_id = $_POST["$model_nama"]["$attr"];
		   }
		   $penjamin = null;
		   if($carabayar_id){
			   $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id));
			   $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
		   }

		   if($encode){
			   echo CJSON::encode($penjamin);
		   } else {
			   if(empty($penjamin)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   foreach($penjamin as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
	}
	
	public function actionGetRuanganPasien($encode=false,$model_nama='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   if($model_nama !=='' && $attr == ''){
			   $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
		   }
			elseif ($model_nama == '' && $attr !== '') {
			   $instalasi_id = $_POST["$attr"];
		   }
		   elseif ($model_nama !== '' && $attr !== '') {
			   $instalasi_id = $_POST["$model_nama"]["$attr"];
		   }
		   $ruangan = null;
		   if($instalasi_id){
			   $ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id));
			   $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
		   }

		   if($encode){
			   echo CJSON::encode($ruangan);
		   } else {
			   if(empty($ruangan)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   foreach($ruangan as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
	}
	
	/**
	* Mengatur dropdown kabupaten
	* @param type $encode jika = true maka return array jika false maka set Dropdown 
	* @param type $model_nama
	* @param type $attr
	*/
   public function actionSetDropdownKabupaten($encode=false,$model_nama='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $modPasien = new HDPasienM;
		   if($model_nama !=='' && $attr == ''){
			   $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
		   }
			elseif ($model_nama == '' && $attr !== '') {
			   $propinsi_id = $_POST["$attr"];
		   }
			elseif ($model_nama !== '' && $attr !== '') {
			   $propinsi_id = $_POST["$model_nama"]["$attr"];
		   }
		   $kabupaten = null;
		   if($propinsi_id){
			   $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
			   $kabupaten = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');
		   }
		   if($encode){
			   echo CJSON::encode($kabupaten);
		   } else {
			   if(empty($kabupaten)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   } else {
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   foreach($kabupaten as $value=>$name) {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
   }
   /**
	* Mengatur dropdown kecamatan
	* @param type $encode jika = true maka return array jika false maka set Dropdown 
	* @param type $model_nama
	* @param type $attr
	*/
   public function actionSetDropdownKecamatan($encode=false,$model_nama='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $modPasien = new HDPasienM;
		   if($model_nama !=='' && $attr == ''){
			   $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
		   }
			elseif ($model_nama == '' && $attr !== '') {
			   $kabupaten_id = $_POST["$attr"];
		   }
			elseif ($model_nama !== '' && $attr !== '') {
			   $kabupaten_id = $_POST["$model_nama"]["$attr"];
		   }
		   $kecamatan = null;
		   if($kabupaten_id){
			   $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
			   $kecamatan = CHtml::listData($kecamatan,'kecamatan_id','kecamatan_nama');
		   }

		   if($encode){
			   echo CJSON::encode($kecamatan);
		   } else {
			   if(empty($kecamatan)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   foreach($kecamatan as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
   }
   /**
	* Mengatur dropdown kelurahan
	* @param type $encode jika = true maka return array jika false maka set Dropdown 
	* @param type $model_nama
	* @param type $attr
	*/
   public function actionSetDropdownKelurahan($encode=false,$model_nama='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $modPasien = new HDPasienM;
		   if($model_nama !=='' && $attr == ''){
			   $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
		   }
			elseif ($model_nama == '' && $attr !== '') {
			   $kecamatan_id = $_POST["$attr"];
		   }
		   elseif ($model_nama !== '' && $attr !== '') {
			   $kecamatan_id = $_POST["$model_nama"]["$attr"];
		   }
		   $kelurahan = null;
		   if($kecamatan_id){
			   $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
			   $kelurahan = CHtml::listData($kelurahan,'kelurahan_id','kelurahan_nama');
		   }

		   if($encode){
			   echo CJSON::encode($kelurahan);
		   } else {
			   if(empty($kelurahan)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   foreach($kelurahan as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
	}
	
	public function actionGetPenjaminPasienForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

           if($encode) {
                echo CJSON::encode($penjamin);
           } else {
                if(empty($carabayar_id)){
//                    $penjamin = PenjaminpasienM::model()->findAll();
                    echo '<label>Data Tidak Ditemukan</label>';
                } else {
					$criteria = new CDbCriteria();
					$criteria->addCondition('carabayar_id = '.$carabayar_id);
					$criteria->addCondition('penjamin_aktif is true');
					$criteria->order = 'penjamin_nama ASC';
                    $penjamindata = PenjaminpasienM::model()->findAll($criteria);
                    $penjamin = CHtml::listData($penjamindata,'penjamin_id','penjamin_nama');
                    echo CHtml::hiddenField(''.$namaModel.'[penjamin_id]');
                    echo "<div style='margin-left:0px;'>".CHtml::checkBox('checkAllCaraBayar',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                            'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))." Pilih Semua";
                    echo "</div><br/>";
                    $i = 0;
                    if (count($penjamin) > 0){
                        foreach($penjamin as $value=>$name) {
                            echo '<label class="checkbox">';
                            echo CHtml::checkBox(''.$namaModel.'[penjamin_id][]', true, array('value'=>$value));
                            echo '<label for="'.$namaModel.'_penjamin_id_'.$i.'">'.$name.'</label></label>';

                            $i++;
                        }
                    } else{
                        echo '<label>Data Tidak Ditemukan</label>';
                    }
                }
           }
        }
        Yii::app()->end();
    }
	
	/**
	* untuk menampilkan data dokter pegawai 
	*/
	public function actionAutocompleteDokter()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
			$criteria->limit = 5;
			$models = HDDokterpegawaiV::model()->findAll($criteria);
			if(count($models) > 0){
				foreach ($models as $i => $model) {
					$returnVal[$i] = $model->attributes;
					$returnVal[$i]['label'] = $model->NamaLengkap;
					$returnVal[$i]['value'] = $model->pegawai_id;
					$returnVal[$i]['jabatan_nama'] = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : "";
					$returnVal[$i]['gelarbelakang_nama'] = !empty($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : "";
				}
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
	} 
    
      public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null; 
            if(isset($instalasi_id)) {
            $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');
            }
            if($encode){
                echo CJSON::encode($models);
            } else {
				if(empty($models)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					if(count($models) > 1)
					{
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}
					foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
				}
            }
        }
        Yii::app()->end();
    }


    /*
        * ======================== Tindakan Ruangan ===============================
        */
    public function actionLaporanTindakanRuangan()
    {
        $this->pageTitle = Yii::app()->name . " - Tindakan Ruangan";
        $model = new HDLaporantindakanruangan('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);

        if (isset($_GET['HDLaporantindakanruangan'])) {
        $model->attributes = $_GET['HDLaporantindakanruangan'];
        $model->jns_periode = $_GET['HDLaporantindakanruangan']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporantindakanruangan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporantindakanruangan']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['HDLaporantindakanruangan']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['HDLaporantindakanruangan']['bln_akhir']);
        $model->thn_awal = $_GET['HDLaporantindakanruangan']['thn_awal'];
        $model->thn_akhir = $_GET['HDLaporantindakanruangan']['thn_akhir'];
        $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime(''.$model->bln_akhir));
        $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
        switch ($model->jns_periode) {
            case 'bulan':
            $model->tgl_awal = $model->bln_awal . "-01";
            $model->tgl_akhir = $bln_akhir;
            break;
            case 'tahun':
            $model->tgl_awal = $model->thn_awal . "-01-01";
            $model->tgl_akhir = $thn_akhir;
            break;
            default:
            null;
        }
        $model->tgl_awal = $model->tgl_awal . " 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
        }

        $this->render('tindakanRuangan/adminTindakanRuangan', array(
        'model' => $model, 'filter' => $filter, 'format' => $format
        ));
    }

    public function actionPrintLaporanTindakanRuangan()
    {
        $model = new HDLaporantindakanruangan('search');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Grafik Tindakan Ruangan Hemodialisa';
        $format = new MyFormatter();
        //Data Grafik        
        $data['title'] = 'Grafik Laporan Tindakan Ruangan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['HDLaporantindakanruangan'])) {
        $model->attributes = $_REQUEST['HDLaporantindakanruangan'];
        $model->jns_periode = $_REQUEST['HDLaporantindakanruangan']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDLaporantindakanruangan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDLaporantindakanruangan']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['HDLaporantindakanruangan']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['HDLaporantindakanruangan']['bln_akhir']);
        $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime(''. $model->bln_akhir));
        $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
        switch ($model->jns_periode) {
            case 'bulan':
            $model->tgl_awal = $model->bln_awal . "-01";
            $model->tgl_akhir = $bln_akhir;
            break;
            case 'tahun':
            $model->tgl_awal = $model->thn_awal . "-01-01";
            $model->tgl_akhir = $thn_akhir;
            break;
            default:
            null;
        }
        $model->tgl_awal = $model->tgl_awal . " 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'tindakanRuangan/_printTindakanRuangan';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanTindakanRuangan()
    {
        $this->layout = '//layouts/iframe';
        $model = new HDLaporantindakanruangan('search');
        $model->tgl_awal = date('d M Y H:i:s');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Tindakan Ruangan Hemodialisa';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_GET['HDLaporantindakanruangan'])) {
        $model->attributes = $_GET['HDLaporantindakanruangan'];
        $format = new MyFormatter();
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDLaporantindakanruangan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDLaporantindakanruangan']['tgl_akhir']);
        }

        $this->render('_grafik', array(
        'model' => $model,
        'data' => $data,
        ));
    }

    /*
        * ======================== END Tindakan Ruangan ===========================
        */
    
}
