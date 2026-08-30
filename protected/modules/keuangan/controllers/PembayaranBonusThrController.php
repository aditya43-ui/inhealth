<?php

class PembayaranBonusThrController extends MyAuthController {

	public $path_view = 'keuangan.views.pembayaranBonusThr.';
	public $tandabuktikeluartersimpan = false;
	public $pengeluaranumumtersimpan = false;
	public $pembayarankesuppliertersimpan = false;
	public $succesSave = true;
	public $pesan = '';

	public function actionIndex() {
            $format = new MyFormatter();
            $model = new PembbonusthrT();
            $modBuktiKeluar = new KUTandabuktikeluarT;
            $modBuktiKeluar->nokaskeluar = "Otomatis";
						$model->jenisgaji = "THR";

            $model->nopembayaran = MyGenerator::noPembayaranBonusThr($model->jenisgaji);
            $modBuktiKeluar->untukpembayaran = "Pembayaran ".$model->jenisgaji." Pegawai - ".$model->nopembayaran;

            if (isset($_POST['PembbonusthrT']) && isset($_POST['KUTandabuktikeluarT'])){
                $transaction = Yii::app()->db->beginTransaction();
								// echo '<pre>';
								// print_r($_POST);
								// exit();
                try {

                    if(isset($_POST['KUTandabuktikeluarT'])){
                        $modBuktiKeluar->attributes = $_POST['KUTandabuktikeluarT'];
                        $modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDb($_POST['KUTandabuktikeluarT']['tglkaskeluar']);
                        $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
                        $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
                        $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
                        $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
                        $modBuktiKeluar->tahun = date('Y');

                        if ($modBuktiKeluar->validate()) {
                            if($modBuktiKeluar->save()){
                                $this->tandabuktikeluartersimpan = true;
																$simpanPembayaran = false;
																$saveDetail = true;

																if(isset($_POST['PembbonusthrT'])){
																	$model = new PembbonusthrT();
																	$model->attributes = $_POST['PembbonusthrT'];
																	$model->nopembayaran = MyGenerator::noPembayaranBonusThr($model->jenisgaji);
																	$model->tglpembayaran = MyFormatter::formatDateTimeForDb($_POST['PembbonusthrT']['tglpembayaran']);
																	$model->create_time = date('Y-m-d H:i:s');
					                        $model->create_loginpemakai = Yii::app()->user->id;
					                        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
																	$model->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
																	$model->pegawai_id = Yii::app()->user->getState('pegawai_id');
																	$model->periode = $_POST['tahunperiode'].'-01-01';

																	if($model->save()){
																			$simpanPembayaran = true;

																			if(isset($_POST['PengbonusthrT']) && count((array)$_POST['PengbonusthrT']) > 0){

			                                     foreach ($_POST['PengbonusthrT'] as $detailData){
			                                         if($detailData['checklist'] == 1){
			                                            $modelDet = new PembbonusthrdetT();
																									$modelDet->pembbonusthr_id = $model->pembbonusthr_id;
																									$modelDet->pengbonusthr_id = $detailData['pengbonusthr_id'];
																									$modelDet->jmlhutang = $detailData['totalpajak'];
																									$modelDet->jmldibayarkan = $detailData['jmldibayarkan'];
																									$modelDet->jmlsisahutang = $detailData['jmlsisahutang'];
																									$modelDet->keterangan = $detailData['keterangan'];
			                                            $modelDet->create_time = date('Y-m-d H:i:s');
			                                            $modelDet->create_loginpemakai_id = Yii::app()->user->id;
			                                            $modelDet->create_ruangan = Yii::app()->user->getState('ruangan_id');

			                                             if($modelDet->save()){
			                                                $saveDetail = true;
			                                            }
			                                         }
			                                     }
			                                }

																			if(Yii::app()->user->getState('isjurnalotomatis') == true){
																				$modJurnalRekening = $this->saveJurnalRekening($modBuktiKeluar, $model);
																				$nourutJurnal = 2;

																				//Debit jurnal rekening
																				if($model->totaldibayarkan > 0){
																						$nourutJurnal = 3;
																						if($model->jenisgaji == 'THR'){
																								$rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name'=>Params::REKENINGCOLUMN_TABLE_PEMBBONUSTHRT, 'column_name'=>Params::REKENINGCOLUMN_COLUMN_TOTALHUTANGTHR,'debitkredit'=>'D'));
																						}else{
																							$rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name'=>Params::REKENINGCOLUMN_TABLE_PEMBBONUSTHRT, 'column_name'=>Params::REKENINGCOLUMN_COLUMN_TOTALHUTANGBONUS,'debitkredit'=>'D'));
																						}

																						if(isset($rekeningcolumn)){
																								$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $model->totaldibayarkan,'D',1);
																						}
																				}

																				if(!empty($rekeningkreditfaktur_id)){
																						$this->saveJurnalDetail($modJurnalRekening, $rekeningkreditfaktur_id, $jmlpembayaran,'D',1);
																				}

																				if($modBuktiKeluar->biayaadministrasi > 0){
																						$nourutJurnal = 3;
																						//Debit administrasi
																						$rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name'=>Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART, 'column_name'=>Params::REKENINGCOLUMN_COLUMN_BIAYAADMINISTRASI,'debitkredit'=>'D'));
																						if(isset($rekeningcolumn)){
																								$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modBuktiKeluar->biayaadministrasi,'D',2);
																						}
																				}

																				//Kredit Pembayaran
																				if(!empty($modBuktiKeluar->carabayarkeluar)){
																						if($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER){
																								$modBankRek = BankrekM::model()->findByAttributes(array('bank_id'=>$modBuktiKeluar->bank_id,'debitkredit'=>'K'));
																								if(isset($modBankRek)){
																										$this->saveJurnalDetail($modJurnalRekening, $modBankRek->rekening5_id, $modBuktiKeluar->jmlkaskeluar,'K',$nourutJurnal);
																								}
																						}else{
																								$modCarabayarKeluarrek = CarabayarkeluarrekM::model()->findByAttributes(array('carabayarkeluar'=> $modBuktiKeluar->carabayarkeluar));
																								if(isset($modCarabayarKeluarrek)){
																										$this->saveJurnalDetail($modJurnalRekening, $modCarabayarKeluarrek->rekening5_id, $modBuktiKeluar->jmlkaskeluar,'K',$nourutJurnal);
																								}
																						}
																				}
			                                }
																	}
																}

                                if($saveDetail == true && $simpanPembayaran == true){
                                    $transaction->commit();
                                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                                    $this->redirect(array('index', 'tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id, 'sukses' => 1));
                                }else{
                                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                                    $transaction->rollback();
                                }
                            }
                        }else{
                            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                            $transaction->rollback();
                        }
                    }
                } catch (Exception $exc) {
                        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                        $transaction->rollback();
                }
            }
		$this->render($this->path_view.'index', array('model' => $model,
			'modBuktiKeluar' => $modBuktiKeluar,
		));
	}

	protected function saveJurnalRekening($modBuktiKeluar, $model)
	 {
			 $period = Yii::app()->user->getState('periode_ids');
			 if (is_array($period)) {
					 $period = $period[0];
			 }

			 $format = new MyFormatter();
			 $modJurnalRekening = new JurnalrekeningT;
			 $modJurnalRekening->jenisjurnal_id = 2;
			 $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDb($modBuktiKeluar->tglkaskeluar);
			 $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
			 $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
			 $modJurnalRekening->noreferensi = $model->nopembayaran;
			 $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modBuktiKeluar->tglkaskeluar);
			 $modJurnalRekening->nobku = "";
			 $modJurnalRekening->urianjurnal = "Pembayaran ".$model->jenisgaji.' Pegawai - '.$model->nopembayaran;

			 $periodeID = $period;
			 $modJurnalRekening->rekperiod_id = $periodeID;
			 $modJurnalRekening->create_time = date('Y-m-d H:i:s');
			 $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
			 $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
			 $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
			 $modJurnalRekening->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;

			 if($modJurnalRekening->validate()){
					 $modJurnalRekening->save();
					 $this->succesSave = true;

			 } else {
					 $this->succesSave = false;
					 $this->pesan = $modJurnalRekening->getErrors();
			 }
			 return $modJurnalRekening;
	 }

	 public function saveJurnalDetail($modJurnalRekening, $rekening5_id, $nilaisaldo, $typeSaldo, $nourut){
			 $valid = true;

			 $modelJurnalDetail = new JurnaldetailT();
			 $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
			 $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
			 $modelJurnalDetail->rekening5_id = $rekening5_id;
			 $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
			 $modelJurnalDetail->nourut = $nourut;
			 if($typeSaldo == 'K'){
					 $modelJurnalDetail->saldokredit = $nilaisaldo;
					 $modelJurnalDetail->saldodebit = 0;
			 }else if($typeSaldo == 'D'){
					 $modelJurnalDetail->saldodebit = $nilaisaldo;
					 $modelJurnalDetail->saldokredit = 0;
			 }

			 if($modelJurnalDetail->validate()){
							 $modelJurnalDetail->save();
					 }else{
							 $valid = false;
					 }

			 return $valid;
	 }


	public function actionPrint($id) {
		$modBuktiKeluar = TandabuktikeluarT::model()->findByPk($id);
		$model = PembbonusthrT::model()->findByAttributes(array('tandabuktikeluar_id'=>$modBuktiKeluar->tandabuktikeluar_id));
		$modDetail = PembbonusthrdetT::model()->findAllByAttributes(array('pembbonusthr_id'=>$model->pembbonusthr_id));

		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'print', array(
                            'caraPrint' => $caraPrint,
                            'modBuktiKeluar' => $modBuktiKeluar,
                            'modDetail' => $modDetail,
                            'model' => $model

			));
		}
	}

    public function actionSetFromPengajuan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $form = "";
            $pesan = "";
            $periodetahun = isset($_POST['periodetahun']) ? $_POST['periodetahun'] : null;
						$jenisgaji = isset($_POST['jenisgaji']) ? $_POST['jenisgaji'] : null;

            $criteria = new CDbCriteria();
            $criteria->select = "t.pengbonusthr_id, t.tglpengajuan, t.jenisgaji, t.periodebonusthr, sum(case when t.jenisgaji = 'THR' then pd.thp_thr else pd.thp_bonus end) as totalpajak";
            $criteria->group = "t.pengbonusthr_id,t.tglpengajuan, t.jenisgaji, t.periodebonusthr";
            $criteria->join = "JOIN pengbonusthrdetail_t pd ON pd.pengbonusthr_id = t.pengbonusthr_id";
            $criteria->addCondition("date_part('year',t.periodebonusthr) = '".$periodetahun."'");
						$criteria->addCondition("t.jenisgaji = '".$jenisgaji."'");
            // $criteria->addCondition('pd.jurnalrekening_id IS NULL');
            $dataDetail = PengbonusthrT::model()->findAll($criteria);

            if(count((array)$dataDetail) > 0){
                $no = 1;
                foreach($dataDetail as $i=>$data){
                    $pajakNilai = 0;

										$oriPembayaran = PembbonusthrdetT::model()->findAllByAttributes(array('pengbonusthr_id'=>$data->pengbonusthr_id));

										if(count((array)$oriPembayaran) > 0){
											foreach($oriPembayaran as $pmb){
												if(isset($pmb->pembbonusthr) && empty($pmb->pembbonusthr->pegawaibatal_id)){
														$pajakNilai += $pmb->jmldibayarkan;
												}
											}
										}

                    $data->totalpajak = ($data->totalpajak - $pajakNilai);

                    if($data->totalpajak > 0){
                        $form .= $this->renderPartial($this->path_view.'_rowSetoran', array('modDetail'=>$data, 'index'=>$no), true);
                        $no++;
                    }
                }
            }else{
                    $pesan = 'Data tidak ditemukan';
            }

            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end();
        }
    }

     public function actionGetMasterBank()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $bank_id = isset($_GET['bank_id']) ? $_GET['bank_id'] : null;

            $model = BankM::model()->findByPk($bank_id);
            $data = array();

            if(isset($model)){
                $data['norekening'] = $model->norekening;
                $data['namabank'] = $model->namabank;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

		public function actionGetJenisTransaksi() {
				if (Yii::app()->getRequest()->getIsAjaxRequest()) {
						$jenistransaksi = isset($_POST['jenistransaksi']) ? $_POST['jenistransaksi'] : null;
						$nopembayaran = MyGenerator::noPembayaranBonusThr($jenistransaksi);

						echo CJSON::encode($nopembayaran);
						Yii::app()->end();
				}
		}
}
