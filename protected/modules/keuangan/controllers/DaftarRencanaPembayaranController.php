<?php

class DaftarRencanaPembayaranController extends MyAuthController {

	public $layout = '//layouts/column1';
	public $defaultAction = 'Index';
	public $tips = 'sistemAdministrator.views.';
	public $success = true;
	public $path_view = 'keuangan.views.daftarRencanaPembayaran.';

	public function actionIndex() {
		$format = new MyFormatter();
		$model = new KUDaftarrencanapembayaranV('searchInformasi');
		$model->tgl_awal = date('d M Y');
		$model->tgl_akhir = date('d M Y');

		if (isset($_GET['KUDaftarrencanapembayaranV'])) {
			$model->attributes = $_GET['KUDaftarrencanapembayaranV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['KUDaftarrencanapembayaranV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUDaftarrencanapembayaranV']['tgl_akhir']);
//			$model->no_mr = $_GET['KUInformasipengelompokanrekeningV']['no_mr'];
//			$model->no_reg = $_GET['KUInformasipengelompokanrekeningV']['no_reg'];
		}

		$modVer = new KUDaftarrencanapembayaranT();
		$modVer->diskon = "0";

		
		if (isset($_REQUEST['KUDaftarrencanapembayaranT'])) {
                    
			$transaction = Yii::app()->db->beginTransaction();
			try {
                            
                            $daftarrenacnaIdArray = array();
                            $index = 0;
                     
                            if(count($_REQUEST['KUDaftarrencanapembayaranT'])>0){
                                
                                foreach ($_REQUEST['KUDaftarrencanapembayaranT'] as $dataValue){
                                    $model = new KUDaftarrencanapembayaranT();
                                
                                    $model->attributes = $dataValue;
                                    $model->tgl_voucher = $format->formatDateTimeForDb($dataValue['tgl_voucher']);
                                
                                    if($model->save()){
                                        $daftarrenacnaIdArray[$index]=$model->daftarrencanapembayaran_id;
                                        $index++;
                                    }
                                }
                                
                            }
                            
                            if($index > 0){
                               $this->success = true; 
                            }
                            
                            if ($this->success) {
                                    $transaction->commit();
                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                    $this->redirect(array('index', 'sukses' => 1,'daftarrencanapembayaran_id'=>$daftarrenacnaIdArray));
                            } else {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                            }
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan! " . MyExceptionMessage::getMessage($e, true));
			}
		}

		$this->render('index', array(
			'format' => $format,
			'modVer' => $modVer,
			'model' => $model
		));
	}

	public function actionAutocompletePegawaiMenyetujui() {
		if (Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$criteria = new CDbCriteria();
			$criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
			$criteria->select = $criteria->group;
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
			$criteria->limit = 5;
			$models = PegawairuanganV::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
				$returnVal[$i]['value'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionPrint($id, $caraPrint = null) {
		$format = new MyFormatter;
                 $content = "";
//		$model = VRVerpenerimaanT::model()->findByPk($bkupengembalianuangmuka_id);
//		$modDetail = VRVerpenerimaandetT::model()->findAllByAttributes(array('bkupengembalianuangmuka_id' => $bkupengembalianuangmuka_id));
                
                $daftarrencana = explode(',', $id);
                $countRencana = count($daftarrencana);
                $sumNetto = 0;
                $htmlBody = "";
                if(count($daftarrencana) >0){
                    foreach ($daftarrencana as $dtRencana){
                        $model = DaftarrencanapembayaranT::model()->findByPk($dtRencana);
                        if(isset($model)){
                            $kodebank = "";
                            $namabank = "";
                            $ket = "";
                            
                            $bank = BankM::model()->findByPk($model->bank_id);
                            if(isset($bank)){
                                $kodebank = "";
                                $namabank = $bank->namabank;
                            }
                            
                            $verif = VerpengeluaranT::model()->findByPk($model->verpengeluaran_id);
                            if(isset($verif)){
                                $ket = $verif->untukkeperluan;
                            }
                            
                            $sumNetto += $model->netto;
                            $htmlBody .= $model->no_rekening.";".$model->nama_perusahaan.";Jakarta;;;IDR;".$model->netto.";".$model->no_voucher.";;".$model->kode_lbu.";".$kodebank.";".$namabank.";Jakarta;;;;N;;;;;;;;;;;;;;;;;;;;;;BEN;;".$ket;
                        }
                    }
                }
                
		$judul_print = 'DAFTAR RENCANA PEMBAYARAN';
		$deskripsi = "";
                
                if($caraPrint == "PRINT"){
                    $this->layout = '//layouts/printWindows';
                    $this->render('print', array(
			'format' => $format,
			'judulLaporan' => $judul_print,
//			'model' => $model,
//			'modDetail' => $modDetail,
			'caraPrint' => $caraPrint,
			'deskripsi' => $deskripsi
                    ));
                }else if($caraPrint == "CSV"){
                    $content .= "P;".date('Ymd').";1160099041080;".$countRencana.";".$sumNetto.";;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;";
                    $content .= "\n";
                    $content .= $htmlBody;
                    Yii::app()->getRequest()->sendFile($judul_print . '-' . date("Y/m/d") . '.csv', $content, "text/csv", false);
                }

		
	}

	public function actionAutocompleteJenisPengeluaran() {
		if (Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(jenispengeluaran_nama)', strtolower($_GET['term']), true);
			$criteria->limit = 5;
			$models = JenispengeluaranM::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->jenispengeluaran_nama;
				$returnVal[$i]['value'] = $model->jenispengeluaran_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	protected function saveJurnalRekening($modVer) {
		$modJurnalRekening = new JurnalrekeningT;
		$modJurnalRekening->tglbuktijurnal = $modVer->tgl_bku;
		$modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
		$modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
		$modJurnalRekening->noreferensi = $modVer->no_bku;
		$modJurnalRekening->tglreferensi = $modVer->tgl_bku;
		$modJurnalRekening->nobku = "";
		$modJenisPenerimaan = JenispengeluaranM::model()->findByPk($modVer->jenispengeluaran_id);
		$modJurnalRekening->urianjurnal = $modJenisPenerimaan->jenispengeluaran_nama;
		$modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
		$modJurnalRekening->rekperiod_id = Yii::app()->user->getState('periode_ids');
		$modJurnalRekening->create_time = $modVer->tgl_bku;
		$modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
		$modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
		if ($modJurnalRekening->validate()) {
			$modJurnalRekening->save();
			$this->success = true;
		} else {
			$this->success = false;
			$this->pesan = $modJurnalRekening->getErrors();
		}
		return $modJurnalRekening;
	}

	public function actionGetRincianTindakan() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$value = isset($_POST['value']) ? $_POST['value'] : null;
			$type = isset($_POST['type']) ? $_POST['type'] : null;

			$model = RinciantindakanT::model()->findAllByAttributes(array("pengembalianuangmukadet_id" => $value));
			$html = "";
			$htmlFoot = "";
			if (count($model) > 0) {
				$totalQty = 0;
				$totalJumlah = 0;
				$total = 0;
				$tarifpiutang = 0;
				foreach ($model as $data) {
					$totalQty += $data['qty'];
					$totalJumlah += $data['tarif'];
					$total += ($data['qty'] * $data['tarif']);
					$tarifpiutang += $data['tarif_piutang'];

					$html .= "<tr>";
					$html .= "<td>";
					$html .= $data['ds_yan'];
					$html .= "</td>";
					$html .= "<td style='text-align:right;'>";
					$html .= $data['qty'];
					$html .= "</td>";
					$html .= "<td style='text-align:right;'>";
					$html .= number_format($data['tarif']);
					$html .= "</td>";
					$html .= "<td style='text-align:right;'>";
					$html .= number_format(($data['qty'] * $data['tarif']));
					$html .= "</td>";
					$html .= "<td style='text-align:right;'>";
					$html .= isset($data['tarif_piutang']) ? number_format($data['tarif_piutang']) : 0;
					$html .= "</td>";
					$html .= "</tr>";
				}
				$htmlFoot .= "<tr>";
				$htmlFoot .= "<td>";
				$htmlFoot .= "<b>Total</b>";
				$htmlFoot .= "</td>";
				$htmlFoot .= "<td style='text-align:right;'>";
				$htmlFoot .= $totalQty;
				$htmlFoot .= "</td>";
				$htmlFoot .= "<td style='text-align:right;'>";
				$htmlFoot .= number_format($totalJumlah);
				$htmlFoot .= "</td>";
				$htmlFoot .= "<td style='text-align:right;'>";
				$htmlFoot .= number_format($total);
				$htmlFoot .= "</td>";
				$htmlFoot .= "<td style='text-align:right;'>";
				$htmlFoot .= number_format($tarifpiutang);
				$htmlFoot .= "</td>";
				$htmlFoot .= "</tr>";
			}

			echo json_encode(array('html' => $html, 'htmlFoot' => $htmlFoot));
			Yii::app()->end();
		}
	}

	public function actionGetNoRekening() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$format = new MyFormatter();
			$bank_id = isset($_POST['bank_id']) ? $_POST['bank_id'] : null;

			$model = BankM::model()->findByPk($bank_id);
                        $data = null;
                        if(isset($model)){
                            $norekening = $model->norekening;
                            $data = array('norekening' => $norekening,'kode_bank' => $model->kode_bank);
                        }

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

}
