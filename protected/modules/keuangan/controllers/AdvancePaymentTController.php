<?php

class AdvancePaymentTController extends MyAuthController {

	protected $successSave;
	public $path_view = 'keuangan.views.advancePaymentT.';
    public $pesan = "";

	public function actionIndex($advancepayment_id = null) {
		$model = new AdvancepaymentT();
		$modTandaBuktiKeluar = new KUTandabuktikeluarT();
		$modApproval = ApprovalotorisasiM::model()->find();
		//initial
		$model->nopengajuan = '---Otomatis---';
		$model->pegawaipemeriksa_id = $modApproval->accountingofficer_id;
		$model->pegawaimenyetujui_id = $modApproval->managerkeuangan_id;
		//officer
		$pemeriksa = PegawaiM::model()->findByPk($modApproval->accountingofficer_id);
		$menyetujui = PegawaiM::model()->findByPk($modApproval->accountingofficer_id);

		$model->pegawaipemeriksa_nama = $pemeriksa ? $pemeriksa->nama_pegawai : '';
		$model->pegawaimenyetujui_nama = $menyetujui ? $menyetujui->nama_pegawai : '';
		//tanda bukti keluar
		$modTandaBuktiKeluar->nokaskeluar = '---Otomatis---';
		$modTandaBuktiKeluar->carabayarkeluar = 'TUNAI';
		$model->jenistransaksi = 'ADVANCE PAYMENT';

		if($advancepayment_id){
			$model = AdvancepaymentT::model()->findByPk($advancepayment_id);
			$model = AdvancepaymentT::model()->findByPk($advancepayment_id);
			$pegawai = PegawaiM::model()->findByPk($model->pegawai_id);

			// $model->;
			$model->pegawaipemeriksa_nama = $pemeriksa ? $pemeriksa->nama_pegawai : '';
			$model->pegawaimenyetujui_nama = $menyetujui ? $menyetujui->nama_pegawai : '';
			$model->jabatan_nama = $pegawai->jabatan->jabatan_nama;
			$modTandaBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array(
				'advancepayment_id' => $advancepayment_id
			));
		}
		if (isset($_POST['AdvancepaymentT'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
			
				$model = $this->saveAdvance($_POST['AdvancepaymentT'],$model, $_POST['nopengajuan']);
				$modTandaBuktiKeluar = $this->saveBuktiKeluar($_POST['KUTandabuktikeluarT'], $model, $modTandaBuktiKeluar);
				

				if($this->successSave){

					if(Yii::app()->user->getState('isjurnalotomatis') == true){
						$model = AdvancepaymentT::model()->findByPk($model->advancepayment_id);
						$modJurnalRekening = $this->saveJurnalRekening($model, $modTandaBuktiKeluar);
						echo 'sss';
						exit();
						//Debit jurnal rekening mengambil dari transaksi faktur
						$rekeningcolumnKasbon = RekeningcolumnM::model()->findByAttributes(array('rekening5_id' => Params::REKENINGCOLUMN_ID_KASBONPEGAWAI));
						if(!empty($rekeningcolumnKasbon)){
							$nourutJurnal = 1;
							// var_dump($rekeningcolumnKasbon->rekening5_id);die;
							$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnKasbon->rekening5_id, $model->jmlpembayaran,'D',$nourutJurnal);
						}

						if($model->tandabuktikeluar->biayaadministrasi > 0){
							$nourutJurnal = 2;
							//Debit administrasi
							$rekeningcolumnBiayaAdmin = RekeningcolumnM::model()->findByAttributes(array('rekening5_id' => Params::REKENINGCOLUMN_ID_BIAYAADMINISTRASI));
							if(isset($rekeningcolumnBiayaAdmin)){
								$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnBiayaAdmin->rekening5_id, $model->tandabuktikeluar->biayaadministrasi,'D',2);
							}
						}

						//Kredit Carabayarkeluar
						if(!empty($model->tandabuktikeluar->carabayarkeluar)){
							$nourutJurnal = 3;
							if($model->tandabuktikeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER){
								$modBankRek = BankrekM::model()->findByAttributes(array('bank_id'=>$model->tandabuktikeluar->bank_id,'debitkredit'=>'K'));
								if(isset($modBankRek)){
									$this->saveJurnalDetail($modJurnalRekening, $modBankRek->rekening5_id, $model->tandabuktikeluar->jmlkaskeluar,'K',$nourutJurnal);
								}
							}else{
								$modCarabayarKeluarrek = CarabayarkeluarrekM::model()->findByAttributes(array('carabayarkeluar'=> $model->tandabuktikeluar->carabayarkeluar));
								if(isset($modCarabayarKeluarrek)){
									$this->saveJurnalDetail($modJurnalRekening, $modCarabayarKeluarrek->rekening5_id, $model->tandabuktikeluar->jmlkaskeluar,'K',$nourutJurnal);
								}
							}
						}
					}

					$transaction->commit();
					Yii::app()->user->setFlash("success", "Transaksi berhasil disimpan.");
					if (isset($_GET['frame'])) {
						$this->redirect(array('index', 'advancepayment_id' => $model->advancepayment_id, 'frame' => 1,'sukses'=>1));
					}else{
						$this->redirect(array('index', 'advancepayment_id' => $model->advancepayment_id, 'sukses'=>1));
					}
				} else {
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					$transaction->rollback();
				}


			} catch (Exception $exc) {
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
				$transaction->rollback();
			}

		}


		$this->render($this->path_view.'index', array(
			'model' => $model,
			'modTandaBuktiKeluar' => $modTandaBuktiKeluar
		));

	}

	protected function saveAdvance($postAdvance, $model,$nopengajuan) {
		$format = new MyFormatter();

		$model->attributes = $postAdvance;
		$model->nopengajuan = $nopengajuan;

        $model->tglpengajuan = isset($postAdvance['tglpengajuan'])?$format->formatDateTimeForDB($postAdvance['tglpengajuan']):null;
		$model->jmlpembayaran = $format->formatNumberForDb($postAdvance['jmlpembayaran']);
		if ($model->validate()) {
			$model->save();
			$this->successSave = true;
		} else {

			// var_dump($model->getErrors());die;
			$this->successSave = false;
		}

		return $model;
	}

	// get pegawai


	//generate no pengajuan noPengajuanAdvancePayment(kode, klinik)

	public function actionAutocompletePegawai()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
			$criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
			$criteria->select = $criteria->group;
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = AGPegawairuanganV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

	public function actionSetBank()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $profilrs_id = isset($_POST['profilrs_id']) ? $_POST['profilrs_id'] : null;

	        $cr = new CDbCriteria();
	        $cr->compare('profilrs_id', $profilrs_id);
	        $cr->addCondition('bank_aktif = true');
	        $cr->addCondition('ispenerimaan = true');
	        $cr->order = 'namabank';
        	$bank_data = BankM::model()->findAll($cr);



	          $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
	          $option_bank = array();

	          foreach ($bank_data as $item) {
				$option_bank[$item->bank_id]['data-norek'] = $item->norekening;


	          }

        $str = '<option value="">-- Pilih --</option>';

        foreach ($bank_data as $item) {
        	// var_dump();die;
			// 'onchange' => 'setKodeAkunBankMulti(this);'
            $str .= '<option value="'.$item->bank_id.'" data-norek="'.$option_bank[$item->bank_id]['data-norek'].'" onchange="setNoRek(this)">'.$item->bankDanAtasNama.'</option>';
        }

        echo CJSON::encode(array(
            'option'=>$str,
        ));

    }

	//generate number

	public function actionGenerateNoPengajuan(){
		if (!Yii::app()->request->isAjaxRequest) {
		   Yii::app()->end();
	   }

	   $klinik = isset($_POST['klinik']) ? $_POST['klinik'] : null;
	   $kode = isset($_POST['kode']) ? $_POST['kode'] : null;
	   $no = MyGenerator::noPengajuanAdvancePayment($kode,$klinik);
	//    $nokas = MyGenerator::noKasKeluar();
	   $res = array();
	   $res['no'] =$no;
	//    $res['no'] =$no;
	   echo CJSON::encode($res);
   }


	/**
	 * method untuk save pembayaran ke supplier
	 * digunakan di
	 * 1. keuangan/PembayaranKeSupplierUmum/index
	 * @param array $postBayarSupplier post request $_POST['KUBayarkesupplierT']
	 * @param obj $modBayar KUBayarkesupplierT
	 * @return object KUBayarkesupplierT
	 */
	protected function saveBayarSupplier($postBayarSupplier, $modBayar) {
		$format = new MyFormatter();

		$modBayar->attributes = $postBayarSupplier;
		$modBayar->terimapersediaan_id = $postBayarSupplier['terimapersediaan_id'];
		$modBayar->terimabahanmakan_id = $postBayarSupplier['terimabahanmakan_id'];

                $modBayar->tgljatuhtempo = (isset($postBayarSupplier['tgljatuhtempo']) || !empty($postBayarSupplier['tgljatuhtempo']))?$format->formatDateTimeForDB($postBayarSupplier['tgljatuhtempo']):null;
		$modBayar->tglbayarkesupplier = $format->formatDateTimeForDB($postBayarSupplier['tglbayarkesupplier']);

		if ($modBayar->validate()) {
			$modBayar->save();
			$this->successSave = true;
		} else {
			$this->successSave = false;
		}

		return $modBayar;
	}

	/**
	 * method untuk save tanda bukti keluar ke supplier
	 * digunakan di
	 * 1. keuangan/PembayaranKeSupplierUmum/index
	 * @param array $postBuktiKeluar post request $_POST['KUTandaBuktiKeluarT']
	 * @param object $modBayarSupplier KUBayarSupplierT
	 * @param object $modBuktiKeluar KUTandaBuktiKeluarT
	 * @return object KUTandaBuktiKeluarT
	 */
	protected function saveBuktiKeluar($postBuktiKeluar, $model, $modBuktiKeluar) {
		$format = new MyFormatter();

		$modBuktiKeluar->attributes = $postBuktiKeluar;
		
		$modBuktiKeluar->advancepayment_id = $model->advancepayment_id;
		$modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDB($postBuktiKeluar['tglkaskeluar']);
		$modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
		$modBuktiKeluar->create_time = date('Y-m-d H:i:s');
		$modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
		$modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();

		$modBuktiKeluar->biayaadministrasi = $format->formatNumberForDb($postBuktiKeluar['biayaadministrasi']);
		$modBuktiKeluar->jmlkaskeluar = $format->formatNumberForDb($postBuktiKeluar['jmlkaskeluar']);
		$modBuktiKeluar->tahun = date('Y');
		
		if ($modBuktiKeluar->validate()) {
			$modBuktiKeluar->save();
			$this->successSave = $this->successSave && true;
            $this->updateAdvancePayment($model, $modBuktiKeluar);
		} else {
			$this->successSave = false;
		}

		return $modBuktiKeluar;
	}

	protected function updateAdvancePayment($model, $modBuktiKeluar) {
		AdvancepaymentT::model()->updateByPk($model->advancepayment_id, array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));
	}

	public function actionPrint($advancepayment_id = null) {
		// $judulKuitansi = '----- Tanda Bukti Bayar Supplier -----';
		$format = new MyFormatter();


        $model = AdvancepaymentT::model()->findByAttributes(array('advancepayment_id' => $advancepayment_id));
        $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('advancepayment_id' => $model->advancepayment_id),array('order'=>'create_time DESC'));

		$judulKuitansi = 'RINCIAN '. $model->jenistransaksi;

		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
        } else {
            $this->layout = '//layouts/iframe';
        }
			$this->render('Print', array(
				'judulKuitansi' => $judulKuitansi,
				'caraPrint' => $caraPrint,
				'modBuktiKeluar' => $modBuktiKeluar,
				'model' => $model,
			));

	}

	public function actionLoadDetailTerima()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$terimapersediaan_id = $_POST['id'];
			//if (!empty($terimapersediaan_id)) {
			$modTerimaPersediaan = KUTerimapersediaanT::model()->findByPk($terimapersediaan_id);
			$modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modTerimaPersediaan->tglterima)));
			$modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modTerimaPersediaan->tglfaktur)));
			$modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modTerimaPersediaan->tglsuratjalan)));
			//$modTerimaPersediaan->supplier_nama = $modTerimaPersediaan->supplier->supplier_nama;
			$sudahBayar = 0;
			$modelBayar = new KUBayarkesupplierT();
			$modBuktiKeluar = new KUTandabuktikeluarT;

			if (!empty($modTerimaPersediaan)) {
				$modDetailPersediaan = KUTerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));

				$modBayar = KUBayarkesupplierT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
				if (count($modBayar) > 0) {
					foreach ($modBayar as $key => $value) {
						$sudahBayar += $value->jmldibayarkan;
					}
				}
			}
			$modelBayar->terimapersediaan_id = $terimapersediaan_id;
			$modelBayar->totaltagihan = $modTerimaPersediaan->totalharga - $sudahBayar;

			$modBuktiKeluar->namapenerima = $modTerimaPersediaan->pembelianbarang->supplier->supplier_nama;
			$modBuktiKeluar->alamatpenerima = $modTerimaPersediaan->pembelianbarang->supplier->supplier_alamat;
			$modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier';


			$totalkeseluruhan = 0;
			if ($modTerimaPersediaan->totalkeseluruhan == 0 || empty($modTerimaPersediaan->totalkeseluruhan)){
				$totalkeseluruhan = $modTerimaPersediaan->totalharga - $modTerimaPersediaan->discount + $modTerimaPersediaan->pajakpph + $modTerimaPersediaan->pajakppn + $modTerimaPersediaan->biayaadministrasi;
				$modTerimaPersediaan->totalkeseluruhan = $totalkeseluruhan;
			}else{
				$totalkeseluruhan = $modTerimaPersediaan->totalkeseluruhan;
			}

			$modelBayar->totaltagihan = $totalkeseluruhan;
			//$modelBayar->totaltagihan = $modTerimaPersediaan->totalharga - $sudahBayar;
			$modelBayar->jmldibayarkan =  $modelBayar->totaltagihan;

			$ii = 1;
			$partial = '';
			foreach ($modDetailPersediaan as $det){
				$partial .= $this->renderPartial($this->path_view.'_rowTerimaDetail', array('detail'=>$det, 'ii'=>$ii), true);
				$ii++;
			}
			//}Bukti Pembayaran Supplier'

			$res = array(
				'tr'=>$partial,
				'modBayarSupplier'=> $modelBayar,
				'modTerima' => $modTerimaPersediaan,
				'modBuktiKeluar' => $modBuktiKeluar
			);


			echo CJSON::encode($res);
		}
		Yii::app()->end();
	}
	public function actionLoadDetailTerimaBahan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$terimabahanmakan_id = $_POST['id'];

			//if (!empty($terimapersediaan_id)) {
            $modTerimaPersediaan = new KUTerimapersediaanT;
			$modTerimaMakanan = TerimabahanmakanT::model()->findByPk($terimabahanmakan_id);


            // var_dump($modTerimaMakanan->attributes); die;

            $modTerimaPersediaan->nopenerimaan = $modTerimaMakanan->nopenerimaanbahan;

			$modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForDb($modTerimaMakanan->tglterimabahan);
			$modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForDb($modTerimaMakanan->tglsurjalan);
			$modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForDb($modTerimaMakanan->tglfaktur);
			$modTerimaPersediaan->nofaktur = $modTerimaMakanan->nofaktur;

            $modTerimaPersediaan->totalharga = $modTerimaMakanan->totalharganetto;
            $modTerimaPersediaan->discount = $modTerimaMakanan->totaldiscount;
            $modTerimaPersediaan->pajakppn = $modTerimaMakanan->biayapajak;
            $modTerimaPersediaan->biayaadministrasi = $modTerimaMakanan->biayapengiriman + $modTerimaMakanan->biayatransportasi;
            $modTerimaPersediaan->totalkeseluruhan = $modTerimaMakanan->totalharganetto + $modTerimaMakanan->biayapengiriman + $modTerimaMakanan->biayatransportasi + $modTerimaMakanan->biayapajak - $modTerimaMakanan->totaldiscount;

			$modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTerimaPersediaan->tglterima)));
			$modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTerimaPersediaan->tglsuratjalan)));
			$modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTerimaPersediaan->tglfaktur)));
			$modTerimaPersediaan->supplier_nama = $modTerimaMakanan->supplier->supplier_nama;
			$modTerimaPersediaan->keterangan_persediaan = $modTerimaMakanan->keterangan_terima_bahan;

            //$modTerimaPersediaan->supplier_nama = $modTerimaPersediaan->supplier->supplier_nama;
			$sudahBayar = 0;
			$modelBayar = new KUBayarkesupplierT();
			$modBuktiKeluar = new KUTandabuktikeluarT;

			if (!empty($modTerimaMakanan)) {
				$modDetailMakanan = TerimabahandetailT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));

				$modBayar = KUBayarkesupplierT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));
				if (count($modBayar) > 0) {
					foreach ($modBayar as $key => $value) {
						$sudahBayar += $value->jmldibayarkan;
					}
				}
			}

			$jumlah = $modTerimaMakanan->totalharganetto + $modTerimaMakanan->biayapengiriman + $modTerimaMakanan->biayatransportasi + $modTerimaMakanan->biayapajak - $modTerimaMakanan->totaldiscount;

			$modelBayar->terimabahanmakan_id = $terimabahanmakan_id;
            $modelBayar->totaltagihan = $jumlah - $sudahBayar;
			//$modelBayar->jmldibayarkan = $modelBayar->totaltagihan - $uangMuka;
			$modBuktiKeluar->namapenerima = $modTerimaMakanan->supplier->supplier_nama;
			$modBuktiKeluar->alamatpenerima = $modTerimaMakanan->supplier->supplier_alamat;
			$modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier Bahan Makanan';

			$totalkeseluruhan = 0;
			if ($jumlah == 0 || empty($jumlah)){
				$totalkeseluruhan = $jumlah;
			}else{
				$totalkeseluruhan = $jumlah;
			}

			$modelBayar->totaltagihan = $totalkeseluruhan;
			$modelBayar->jmldibayarkan =  $modelBayar->totaltagihan;
			//$modBuktiKeluar->biayaadministrasi =  $modTerimaPersediaan->biayaadministrasi;

			$ii = 1;
			$partial = '';
			foreach ($modDetailMakanan as $det){
				$partial .= $this->renderPartial($this->path_view.'_rowTerimaDetailBahan', array('detail'=>$det, 'ii'=>$ii), true);
				$ii++;
			}
			//}




			$res = array(
				'tr'=>$partial,
				'modBayarSupplier'=> $modelBayar,
				'modTerima' => $modTerimaPersediaan,
				'modBuktiKeluar' => $modBuktiKeluar
			);


			echo CJSON::encode($res);
		}
		Yii::app()->end();
	}

    protected function saveJurnalRekening($model, $modBuktiKeluar)
    {
        $period = Yii::app()->user->getState('periode_ids');
        if (is_array($period)) {
            $period = $period[0];
        }
		// var_dump('asdasdasd');die;
        $format = new MyFormatter();
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
        $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglpengajuan);
        $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = $model->nopengajuan;
        $modJurnalRekening->profilrs_id = $model->profilrs_id;
        $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglpengajuan);

        $modJurnalRekening->urianjurnal = $modBuktiKeluar->untukpembayaran;

        $periodeID = $period;
        $modJurnalRekening->rekperiod_id = $periodeID;
        $modJurnalRekening->create_time = date('Y-m-d H:i:s');
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->tandabuktikeluar_id = $model->tandabuktikeluar->tandabuktikeluar_id;
		// var_dump($modJurnalRekening->attributes);die;

        if($modJurnalRekening->validate()){
			// var_dump('simpan');die;
            $modJurnalRekening->save();
            $this->successSave = true;

        } else {
			// var_dump('simpan');die;
            $this->successSave = false;
			// var_dump($modJurnalRekening->getErrors());die;
            $this->pesan = $modJurnalRekening->getErrors();
        }
		// var_dump('simpan');die;

        return $modJurnalRekening;
    }

    public function saveJurnalDetail($modJurnalRekening, $rekening5_id, $nilaisaldo, $typeSaldo, $nourut){

        $valid = true;
        $modJurnalPosting = null;

        $rekening5 = Rekening5M::model()->findByPk($rekening5_id);
        // if (!empty($rekening5)) {
        //     $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
        //     $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
        //     $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);
        // }


        // if(Yii::app()->user->getState('ispostingotomatis'))
        // {
        //     $modJurnalPosting = new JurnalpostingT;
        //     $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
        //     $modJurnalPosting->keterangan = "Posting automatis";
        //     $modJurnalPosting->create_time = date('Y-m-d H:i:s');
        //     $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
        //     $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
        //     if($modJurnalPosting->validate()){
        //         $modJurnalPosting->save();
        //     }else{
		// 		// exit(');
		// 		// var_dump($modJurnalPosting->getErrors());die;
		// 	}
        // }

        $modelJurnalDetail = new JurnaldetailT();
        $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
        $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        if (!empty($rekening5)) {
            $modelJurnalDetail->rekening5_id = $rekening5->rekening5_id;
            // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
            // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
            // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
            // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
        }
        $modelJurnalDetail->nourut = $nourut;
        if($typeSaldo == 'K'){
            $modelJurnalDetail->saldokredit = MyFormatter::formatNumberForDb($nilaisaldo);
            $modelJurnalDetail->saldodebit = 0;
        }else if($typeSaldo == 'D'){
            $modelJurnalDetail->saldodebit =  MyFormatter::formatNumberForDb($nilaisaldo);
            $modelJurnalDetail->saldokredit = 0;
        }

		// var_dump($modelJurnalDetail->attributes);die;
        if($modelJurnalDetail->validate()){
                $modelJurnalDetail->save();
            }else{
				// var_dump( $modelJurnalDetail->getErrors());die;

                $valid = false;
            }

        return $valid;
    }
    //rincian

	public function actionRincian($advancepayment_id) {
		$model = AdvancepaymentT::model()->findByPk($advancepayment_id);
		$modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('advancepayment_id' => $model->advancepayment_id),array('order'=>'create_time DESC'));


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

	/// informasi


	public function actionInformasi() {
		$model = new  AdvancepaymentT('searchInformasi');
		$format = new  MyFormatter();
		// $modTandaBuktiKeluar = new KUTandabuktikeluarT();
		$model->tgl_awal = date('Y-m-d');
		$model->tgl_akhir = date('Y-m-d');

		$model->tgl_awal2 = date('Y-m-d');
		$model->tgl_akhir2 = date('Y-m-d');

		$model->statusbatal = 'BELUM DIBATALKAN';

		if (isset($_GET['AdvancepaymentT'])) {
			// var_dump('asdasdasd');die;
			$model->attributes = $_GET['AdvancepaymentT'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['AdvancepaymentT']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['AdvancepaymentT']['tgl_akhir']);
			$model->tgl_awal2 = $format->formatDateTimeForDb($_GET['AdvancepaymentT']['tgl_awal2']);
			$model->tgl_akhir2 = $format->formatDateTimeForDb($_GET['AdvancepaymentT']['tgl_akhir2']);
			$model->ceklis = $_GET['AdvancepaymentT']['ceklis'];
			$model->profilrs_id = isset($_GET['AdvancepaymentT']['profilrs_id']) ? $_GET['AdvancepaymentT']['profilrs_id'] : null;
			$model->statusbatal = isset($_GET['AdvancepaymentT']['statusbatal']) ? $_GET['AdvancepaymentT']['statusbatal'] : null;
		}


		$this->render($this->path_view.'informasi', array(
			'model' => $model,
			// 'modTandaBuktiKeluar' => $modTandaBuktiKeluar
		));

	}


	public function actionBatal($advancepayment_id){
		$this->layout = '//layouts/iframe';
			$modAdvance= AdvancepaymentT::model()->findByPk($advancepayment_id);
			$modAdvance->tglbatal =date('Y-m-d h:i:s');
			$log = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
			$modPeg = PegawaiM::model()->findByPk($log->pegawai_id);
			$modAdvance->pegawaibatal_id = $log->pegawai_id;
			$modAdvance->pegawaibatal_nama = $modPeg->nama_pegawai;
			if(isset($_POST['AdvancepaymentT'])){
				$modAdvance->attributes = $_POST['AdvancepaymentT'];


				if($modAdvance->save()){
					$tandabukti = TandabuktikeluarT::model()->findByAttributes(array('advancepayment_id' => $modAdvance->advancepayment_id));
					if ($tandabukti) {
						$jurnal = JurnalrekeningT::model()->findByAttributes(array('tandabuktikeluar_id' => $tandabukti->tandabuktikeluar_id));
						if ($jurnal) {
							$delete = JurnaldetailT::model()->deleteAllByAttributes(array('jurnalrekening_id' => $jurnal->jurnalrekening_id));
							if($delete){
								$jurnal->delete();
							}
						}
					}
					// $jurnalRekening = JurnalrekeningT::model()->findByAttributes(array())
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				}
			}
	   $this->render('_batal', array(
		   'modInvoice' => $modAdvance,
	   ));
   }

}
