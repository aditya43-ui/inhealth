<?php

class HemodialisisTHDController extends MyAuthController {

	public $layout = '//layouts/column1';
	protected $successSave = false;
	public $reseptur_id;
	public $path_view = 'hemodialisa.views.hemodialisisTHD.';

	public function actionIndex($pendaftaran_id = null, $pasienadmisi_id = null) {
		$this->layout = '//layouts/iframe';
		$modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
		$modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
		$modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modRiwayatHD = array();
		$modPeriksaHD = new HDPeriksahdT;
		$modPeriksaHD->tglpenggunaanawal = date('d M Y');
		$modPeriksaHD->periksahd_tgl = date('d M Y h:i:s'); 
        $modPeriksaHD->teknik_hd='SLEED';
		$jmlDialisat = 1;
		
		if(isset($_GET['periksahd_id'])){
			$modPeriksaHD = HDPeriksahdT::model()->findByPk($_GET['periksahd_id']);
            $jmlDialisat = $modPeriksaHD->dialiserke;
			$modPeriksaHD->perawat = (!empty($modPeriksaHD->pegawai_id)) ? PegawaiM::model()->findByPk($modPeriksaHD->pegawai_id)->nama_pegawai : "";
			$periksahd_penyulit_array = explode(" |", $modPeriksaHD->periksahd_penyulit);
			$penyulit_teknis = explode(" |", $modPeriksaHD->penyulit_teknis);
			$modPeriksaHD->periksahd_penyulit = explode(" |", $modPeriksaHD->periksahd_penyulit);
			$modPeriksaHD->penyulit_teknis = explode(" |", $modPeriksaHD->penyulit_teknis);
			
			$modPeriksaHD->periksahd_penyulitLainnya = '';
			if(in_array('Lainnya', $periksahd_penyulit_array)){
				$modPeriksaHD->periksahd_penyulitLainnya = end($periksahd_penyulit_array);
			}
			
			$modPeriksaHD->penyulit_teknisLainnya = '';
			if(in_array('Lainnya', $penyulit_teknis)){
				$modPeriksaHD->penyulit_teknisLainnya = end($penyulit_teknis);
			}

		}else{
			$criteria = new CDbCriteria();
			$criteria->addCondition('pasien_id='.$modPasien->pasien_id);
			$criteria->order = "periksahd_id DESC";
			$criteria->limit = 1;
			$modJmlDialisat = HDPeriksahdT::model()->findAll($criteria);
			foreach ($modJmlDialisat as $value) {
				$jmlDialisat = ($value->dialiserke + 1);
				$modPeriksaHD->tglpenggunaanawal = MyFormatter::formatDateTimeForUser($value->tglpenggunaanawal);
			}
		}
		
		if (isset($_POST['HDPeriksahdT'])) {

			$transaction = Yii::app()->db->beginTransaction();
			try {
				
				$modPeriksaHD->attributes = $_POST['HDPeriksahdT'];
				$modPeriksaHD->pasien_id = $modPasien->pasien_id;
				$modPeriksaHD->pegawai_id = $_POST['HDPeriksahdT']['pegawai_id']; 
                $modPeriksaHD->kec_darah_qb = $_POST['HDPeriksahdT']['kec_darah_qb'];
				$modPeriksaHD->pendaftaran_id = $modPendaftaran->pendaftaran_id;
				$modPeriksaHD->ruangan_id = Yii::app()->user->getState('ruangan_id');
				$modPeriksaHD->periksahd_tgl = MyFormatter::formatDateTimeForDb($_POST['HDPeriksahdT']['periksahd_tgl']);
				$modPeriksaHD->tglpenggunaanawal = MyFormatter::formatDateTimeForDb($_POST['HDPeriksahdT']['tglpenggunaanawal']); 
				$modPeriksaHD->resephd_id = $_POST['HDPeriksahdT']['jenishd_id']; 
                $modPeriksaHD->teknik_hd = $_POST['HDPeriksahdT']['teknik_hd'];
				$modPeriksaHD->ph_create_time = date('Y-m-d h:i:s');
				$modPeriksaHD->ph_create_loginid =  Yii::app()->user->id;
				$modPeriksaHD->ph_create_ruanganid =  Yii::app()->user->getState('ruangan_id');
				$modPeriksaHD->ph_create_iphost = Yii::app()->request->getUserHostAddress(); 
                $modPeriksaHD->obat_renogen = $_POST['HDPeriksahdT']['obat_renogen']; 
                $modPeriksaHD->obat_renogen_stn = $_POST['HDPeriksahdT']['obat_renogen_stn'];
				
				if(!empty($_POST['HDPeriksahdT']['periksahd_penyulit']) && !empty($_POST['HDPeriksahdT']['periksahd_penyulit'])){
					$modPeriksaHD->periksahd_penyulit = implode(' |', $_POST['HDPeriksahdT']['periksahd_penyulit']);
					$penyulit = $_POST['HDPeriksahdT']['periksahd_penyulit'];
					$penyulitLainnya = '';
					foreach ($penyulit as $key => $val) {
						if($val == 'Lainnya'){
							$penyulitLainnya = $_POST['HDPeriksahdT']['periksahd_penyulitLainnya'];
						}
					}
					$modPeriksaHD->periksahd_penyulit = $modPeriksaHD->periksahd_penyulit.' |'.$penyulitLainnya;
				}else{
					$modPeriksaHD->periksahd_penyulit = '';
				}
				
				if(!empty($_POST['HDPeriksahdT']['penyulit_teknis']) && !empty($_POST['HDPeriksahdT']['penyulit_teknis'])){
					$modPeriksaHD->penyulit_teknis = implode(' |', $_POST['HDPeriksahdT']['penyulit_teknis']);
					$penyulitTeknis = $_POST['HDPeriksahdT']['penyulit_teknis'];
					$teknisLainnya = '';
					foreach ($penyulitTeknis as $key2 => $val2) {
						if($val2 == 'Lainnya'){
							$teknisLainnya = $_POST['HDPeriksahdT']['penyulit_teknisLainnya'];
						}
					}
					$modPeriksaHD->penyulit_teknis = $modPeriksaHD->penyulit_teknis.' |'.$teknisLainnya;
				}else{
					$modPeriksaHD->penyulit_teknis = '';
				}
				
				if($modPeriksaHD->save()){
					$transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Resep berhasil disimpan");
			            if(!empty($pasienadmisi_id)){
                           $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'periksahd_id'=>$modPeriksaHD->periksahd_id, 'sukses'=>1));
                        }else{
                           $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'periksahd_id'=>$modPeriksaHD->periksahd_id, 'sukses'=>1));
                        }
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ");
				}
				
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
			}

		}
		
//		$modRiwayatHD = HDPeriksahdT::model()->findAllByAttributes(array('pasien_id'=>$modPasien->pasien_id,'pendaftaran_id'=>$pendaftaran_id));
		$modRiwayatHD = HDPeriksahdT::model()->findAllByAttributes(array('pasien_id'=>$modPasien->pasien_id));

		$this->render($this->path_view.'index', array('modPendaftaran' => $modPendaftaran,
			'modPasien' => $modPasien,
			'modAdmisi' => $modAdmisi,
			'modRiwayatHD' => $modRiwayatHD,
			'modPeriksaHD' => $modPeriksaHD,
			'jmlDialisat' => $jmlDialisat,
		));
	}

	public function actionAutoCompletePegawaiPerawat() {
		if (Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$term = explode(';', $_GET['term']);
			$nama_pegawai = isset($term[0]) ? $term[0] : '';

			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $paramedis = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
            $criteria->addCondition('kelompokpegawai_id='.$paramedis);
			$criteria->limit = 5;
			$models = PegawaiM::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$returnVal[$i]['label'] = $model->NamaLengkap;
				$returnVal[$i]['value'] = $model->pegawai_id;
				$returnVal[$i]['nama_pegawai'] = $model->NamaLengkap;
				$returnVal[$i]['pegawai_id'] = $model->pegawai_id;
			}
			echo CJSON::encode($returnVal);
		}
	}
	
	public function actionAjaxDetailHD()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$idHD = $_POST['idHD'];
			$pendaftaran_id = $_POST['pendaftaran_id'];
			$modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
			$modHemodialisa = HDPeriksahdT::model()->findByPk($idHD);
			
			$data['result'] = $this->renderPartial($this->path_view.'_viewDetailHD', array(
				'modHemodialisa'=>$modHemodialisa,
				'modPendaftaran'=>$modPendaftaran,
			), true);

			echo json_encode($data);
			Yii::app()->end();
		}
	}
	
	public function actionPrintHemodialisa($pendaftaran_id,$periksahd_id){
		$this->layout='//layouts/printWindows';
		
		$modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
		$modHemodialisa = HDPeriksahdT::model()->findByPk($periksahd_id);
		$modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
			
		$judul_print = 'PEMERIKSAAN HEMODIALISA';
        $this->render($this->path_view.'print', array(
			'modHemodialisa'=>$modHemodialisa,
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
        ));
	}
    
    public function actionHapusRiwayatHemodialisa(){
        if(Yii::app()->request->isAjaxRequest) {
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $periksahd_id = (isset($_POST['periksahd_id']) && !empty($_POST['periksahd_id'])) ? $_POST['periksahd_id'] : null;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                    $deletePeriksaHD = PeriksahdT::model()->deleteAllByAttributes(array('periksahd_id'=>$periksahd_id));
                    
                    if($deletePeriksaHD){
                        
                        $jmlDialisat = 1;
                        $criteria = new CDbCriteria();
                        $criteria->addCondition('pasien_id='.$_POST['pasien_id']);
                        $criteria->order = "periksahd_id DESC";
                        $criteria->limit = 1;
                        $modJmlDialisat = HDPeriksahdT::model()->findAll($criteria);
                        foreach ($modJmlDialisat as $value) {
                            $jmlDialisat = $jmlDialisat + $value->dialiserke;
                        }
                    
                        $data['pesan'] = "Riwayat Hemodialisa Berhasil Dihapus!";
                        $data['sukses'] = 1;
                        $data['jmlDialisat'] = $jmlDialisat;
                        $transaction->commit();
                    }else{
                        $transaction->rollback();
                        $data['pesan'] = "Gagal Menghapus Hemodialisa";
                        $data['sukses'] = 0;
                        $data['jmlDialisat'] = $jmlDialisat;
                    }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Transaksi Gagal :".MyExceptionMessage::getMessage($exc,true);
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

}
