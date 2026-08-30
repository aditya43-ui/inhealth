<?php
class SettlementPaymentTController extends MyAuthController {
    //public $layout = '//layouts/iframe';
	// public $init = "KU";

    // public $succesSave;
	public $succesSave = true;
	public $path_view = 'keuangan.views.settlementPaymentT.';
    public $pesan = "";

	public function actionIndex($advancepayment_id = null,$settlementpayment_id=null) {
		$model = new SettlementpaymentT();
		$modTandaBuktiKeluar = new KUTandabuktikeluarT();
		$modBuktiKeluar = new TandabuktikeluarT();
		$modApproval = ApprovalotorisasiM::model()->find();
		// $model->profilrs
		$modSettlementPaymentDetails = null;
		$modSettlementPaymentDetail = new SettlementpaymentdetT();
		$modSettlementPaymentLamps = null;
		$modSettlementPaymentLamp = new SettlementpaymentlampT();
		$modTandaBuktiBayar = new KUTandabuktibayarT();

		$modTandaBuktiBayar->carapembayaran = 'CASH';
		$modTandaBuktiBayar->nobuktibayar = '---Otomatis---';

		//bukti keluar
		$modBuktiKeluar->carabayarkeluar = 'TUNAI';
		$modBuktiKeluar->nokaskeluar = '---Otomatis---';
		$login = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
		// var_dump($login)
		// OMDC-SAP/MAMPANG/2021/4/0001
		if ($advancepayment_id) {
			$modAdvancePayment = AdvancepaymentT::model()->findByPk($advancepayment_id);
			$modAdvancePayment->nama_rumahsakit = $modAdvancePayment->profilrs->nama_rumahsakit;
			$modAdvancePayment->tglkaskeluar = $modAdvancePayment->tandabuktikeluar->tglkaskeluar;
			$modAdvancePayment->nokaskeluar = $modAdvancePayment->tandabuktikeluar->nokaskeluar;
			//
			$model->profilrs_id = $modAdvancePayment->profilrs_id;
			$model->nosettlement = MyGenerator::noSettlement($model->profilrs_id);
			$model->terimadari = $modAdvancePayment->pegawai->namaLengkap;
			$model->jmladvance = $modAdvancePayment->jmlpembayaran;
			//
			$model->pegawai_id = $modAdvancePayment->pegawai_id;
			$model->pegawaisettlement_id = $login->pegawai_id;

			$modAdvancePayment->pegawai_nama = $modAdvancePayment->pegawai->namaLengkap;
			$modAdvancePayment->pegawaipemeriksa_nama = $modAdvancePayment->pegawaipemeriksa->namaLengkap;
			$modAdvancePayment->pegawaimenyetujui_nama = $modAdvancePayment->pegawaimenyetujui->namaLengkap;
			$modAdvancePayment->tglpengajuan2 = $modAdvancePayment->tglpengajuan;
			
			$modAdvancePayment->tglpengajuan = MyFormatter::formatDateTimeForUser($modAdvancePayment->tglpengajuan);
			$modAdvancePayment->tglkaskeluar = MyFormatter::formatDateTimeForUser($modAdvancePayment->tglkaskeluar);
			$modTandaBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('advancepayment_id' => $advancepayment_id));
		}else{
			$modAdvancePayment = new AdvancepaymentT();
		}
		if ($settlementpayment_id) {
			$model = SettlementpaymentT::model()->findByPk($settlementpayment_id);

			$modSettlementPaymentDetails = SettlementpaymentdetT::model()->findAllByAttributes(array('settlementpayment_id'=>$settlementpayment_id));
			foreach($modSettlementPaymentDetails as $det){
				if($det['jenispengeluaran_id']){
					$det->jenispengeluaran_nama = JenispengeluaranM::model()->findByPk($det['jenispengeluaran_id'])->jenispengeluaran_nama;
				}
				if($det['rekening5_id']){
					$det->rekening5_nama = RekeningakuntansiV::model()->findByAttributes(array('rekening5_id'=>$det['rekening5_id']))->nmrekening5;
				}
			}
			$modSettlementPaymentLamps = SettlementpaymentlampT::model()->findAllByAttributes(array('settlementpayment_id'=>$settlementpayment_id));
		}
		if (isset($_POST['SettlementpaymentT'])) {

			// var_dump($_POST);die;
			$transaction = Yii::app()->db->beginTransaction();
			try {	
				$modAdvance = AdvancepaymentT::model()->findByPk($advancepayment_id);
				$model = $this->saveSettlement($_POST['SettlementpaymentT'], $modAdvance);
				
				// step 1
				if (isset($_POST['SettlementpaymentdetT'])) {
                    $modSettlementPaymentDetails = $this->saveUraianSettlement($_POST['SettlementpaymentdetT'], $model);
                }
				// step 2
				if (isset($_POST['SettlementpaymentlampT'])) {
                    $modSettlementPaymentDetails = $this->saveLampiranSettlement($_POST['SettlementpaymentlampT'], $model);
                }

				if (isset($_POST['KUTandabuktibayarT']) && $_POST['KUTandabuktibayarT']['uangditerima'] > 0) {
                    $modTandaBuktiBayar = $this->saveTandaBuktiBayar($_POST['KUTandabuktibayarT'], $model);
                }

				if (isset($_POST['TandabuktikeluarT']) && $_POST['TandabuktikeluarT']['jmlkaskeluar'] > 0 ) {
                    $modBuktiKeluar = $this->saveTandaBuktiKeluar($_POST['TandabuktikeluarT'], $model);
                }

				if(!empty($model)){
					if(Yii::app()->user->getState('isjurnalotomatis') == true){
						$model = SettlementpaymentT::model()->findByPk($model->settlementpayment_id);
						if($model){
						$modJurnalRekening = $this->saveJurnalRekening($model, $modTandaBuktiBayar);

							//Debit jurnal rekening mengambil dari transaksi faktur
						if($modJurnalRekening){
							$modSettlementPaymentDetails = SettlementpaymentdetT::model()->findAllByAttributes(array('settlementpayment_id'=>$model->settlementpayment_id));
							$nourut=1;
							foreach($modSettlementPaymentDetails as $det){

								// print_r($det['rekening5_id']);exit;
								$this->saveJurnalDetail($modJurnalRekening, $det['rekening5_id'], $det['totalharga'],'D',$nourut);
								$nourut++;
								
							}

							$rekeningcolumnKasbon = RekeningcolumnM::model()->findByAttributes(array('rekening5_id' => Params::REKENINGCOLUMN_ID_KASBONPEGAWAI));
							if(!empty($rekeningcolumnKasbon)){
								$nourutJurnal = 100;
								$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnKasbon->rekening5_id, $model->jmladvance,'K',$nourutJurnal);
							}

							// piutang
							if($model->totalpiutang > 0){
								$rekeningcolumnPiutang = RekeningcolumnM::model()->findByAttributes(array(
									'table_name' => 'settlementpayment_t' ,
									'column_name'=> 'totalpiutang',
									'debitkredit' => 'D'
								));
								if(!empty($rekeningcolumnPiutang)){
									$nourutJurnal = 53;
									$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnPiutang->rekening5_id, $model->totalpiutang,'D',$nourutJurnal);
								}
							}
							// hutang
							if($model->totalhutang > 0){
								$rekeningcolumnHutang = RekeningcolumnM::model()->findByAttributes(array(
									'table_name' => 'settlementpayment_t' ,
									'column_name'=> 'totalhutang',
									'debitkredit' => 'K'
								));
								if(!empty($rekeningcolumnHutang)){
									$nourutJurnal = 30;
									$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnHutang->rekening5_id, $model->totalhutang,'K',$nourutJurnal);
								}
							}

							if ($model->sisapengembalian > 0 && $model->totalpiutang <= 0) {
								$rekeningcolumnPotongan = RekeningcolumnM::model()->findByAttributes(array(
									// 'rekening5_id' => Params::REKENINGCOLUMN_ID_BIAYAADMINISTRASI
									'table_name' => 'settlementpayment_t' ,
									'column_name'=> 'totalpotongan',
									'debitkredit' => 'D'
								));

								$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnPotongan->rekening5_id, $model->sisapengembalian,'D',50);
								
							}
							if(isset($modBuktiKeluar)){
								if($modBuktiKeluar->biayaadministrasi){
									$rekeningcolumnKeluarBiayaAdmin = RekeningcolumnM::model()->findByAttributes(array(
						
										'table_name' => 'tandabuktikeluar_t' ,
										'column_name'=> 'tandabuktikeluar_biayaadmin',
										'debitkredit' => 'D'
									));

									if(isset($rekeningcolumnKeluarBiayaAdmin)){
										$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnKeluarBiayaAdmin->rekening5_id, $modBuktiKeluar->biayaadministrasi,'D',10);
									}
								}

								
									if($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER){
										$bankRek = BankrekM::model()->findByAttributes(
											array(
												'bank_id'=>$modBuktiKeluar->bank_id,
												'debitkredit'=>'K'));
										if(isset($bankRek)){
											// var_dump('asdasdasd');die;
											$this->saveJurnalDetail($modJurnalRekening, $bankRek->rekening5_id, $modBuktiKeluar->jmlkaskeluar,'K',51);
										}else{
											// var_dump($modBuktiKeluar->bank_id);die;

										}
									}else{
										if($modBuktiKeluar->jmlkaskeluar > 0){
											$this->saveJurnalDetail($modJurnalRekening, 1, $modBuktiKeluar->jmlkaskeluar,'K',51);
										}
									}

							}
							if(isset($modTandaBuktiBayar)  && $modTandaBuktiBayar->biayaadministrasi > 0){
								$nourutJurnal = 2;
								// var_dump('junal');die;
								//Debit administrasi
								$rekeningcolumnBiayaAdmin = RekeningcolumnM::model()->findByAttributes(array(
									// 'rekening5_id' => Params::REKENINGCOLUMN_ID_BIAYAADMINISTRASI
									'table_name' => 'tandabuktibayar_t' ,
									'column_name'=> 'biayaadministrasi',
									'debitkredit' => 'D'
								));
								if(isset($rekeningcolumnBiayaAdmin)){
									$this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnBiayaAdmin->rekening5_id, $modTandaBuktiBayar->biayaadministrasi,'D',2);
								}
							}
						
							// // Kredit Carabayarkeluar
							if(isset($modTandaBuktiBayar) && $modTandaBuktiBayar->carapembayaran ){
								$nourutJurnal = 3;
								if($modTandaBuktiBayar->carapembayaran == Params::CARAPEMBAYARAN_TRANSFER){
									$modBankRek = BankrekM::model()->findByAttributes(array('bank_id'=>$model->tandabuktibayar->bank_id,'debitkredit'=>'D'));
									if(isset($modBankRek)){
										$this->saveJurnalDetail($modJurnalRekening, $modBankRek->rekening5_id, $modTandaBuktiBayar->uangditerima,'D',$nourutJurnal);
									}
								}else{
									if($modTandaBuktiBayar->uangditerima > 0){
										$this->saveJurnalDetail($modJurnalRekening, 1, $modTandaBuktiBayar->uangditerima,'D',51);
									}
								}
							}
						}
					}
						
						
					}
					// var_dump($model);die;
					$transaction->commit();
					Yii::app()->user->setFlash("success", "Transaksi berhasil disimpan.");
					if (isset($_GET['frame'])) {
						$this->redirect(array('index', 'advancepayment_id' => $advancepayment_id,'settlementpayment_id'=>$model->settlementpayment_id, 'frame' => 1,'sukses'=>1));
					}else{
						$this->redirect(array('index', 'advancepayment_id' => $model->advancepayment_id,'settlementpayment_id'=>$model->settlementpayment_id, 'sukses'=>1));
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

		// var_dump($modSettlementPaymentDetails);die;
		$this->render($this->path_view.'index', array(
			'model' => $model,
			'modAdvancePayment' => $modAdvancePayment,
			'modTandaBuktiKeluar' => $modTandaBuktiKeluar,
			'modSettlementPaymentDetail' => $modSettlementPaymentDetail,
			'modSettlementPaymentDetails' => $modSettlementPaymentDetails,
			'modSettlementPaymentLamps' => $modSettlementPaymentLamps,
			'modSettlementPaymentLamp' => $modSettlementPaymentLamp,
			'modTandaBuktiBayar' => $modTandaBuktiBayar,
			'modBuktiKeluar' =>$modBuktiKeluar
		));

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

	public function actionSetBankKeluar()
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
            $str .= '<option value="'.$item->bank_id.'" data-norek="'.$option_bank[$item->bank_id]['data-norek'].'" onchange="setNoRekKeluar(this)">'.$item->bankDanAtasNama.'</option>';
        }
        
        echo CJSON::encode(array(
            'option'=>$str,
        ));
    
    } 

	protected function saveSettlement($post, $postAdvance){

		// var_dump($post);die;
		$model = new SettlementpaymentT();
		$model->attributes = $post;
		$model->advancepayment_id = $postAdvance->advancepayment_id;
		$model->tandabuktikeluar_id = $postAdvance->tandabuktikeluar_id;
		$model->jmladvance = MyFormatter::formatNumberForDb($post['jmladvance']);
		$model->realisasipembelian = MyFormatter::formatNumberForDb($post['realisasipembelian']);
		$model->sisarealisasi = MyFormatter::formatNumberForDb($post['sisarealisasi']);
		$model->sisapengembalian = MyFormatter::formatNumberForDb($post['sisapengembalian']);
		$model->kekuranganrealisasi = isset($post['kekuranganrealisasi']) ?  MyFormatter::formatNumberForDb($post['kekuranganrealisasi']) : 0;
		$model->sisakekurangan = isset($post['sisakekurangan']) ?  MyFormatter::formatNumberForDb($post['sisakekurangan']) : 0;
		$model->totalhutang = isset($post['totalhutang']) ?  MyFormatter::formatNumberForDb($post['totalhutang']) : 0;
		$model->totalpiutang = isset($post['totalpiutang']) ?  MyFormatter::formatNumberForDb($post['totalpiutang']) : 0;
		$model->tglsettlement = MyFormatter::formatDateTimeForDb($post['tglsettlement']);
		$model->tgljatuhtempo = isset($post['tgljatuhtempo']) ? MyFormatter::formatDateTimeForDb($post['tgljatuhtempo']) : null;
		$model->sebagaipembayaran = $model->terimadari.' - '.$model->nosettlement;
		// $model->advancepayment_id = 
		if(isset($post['jmlpembayaran2'])){
			$model->jmlpembayaran = MyFormatter::formatNumberForDb($post['jmlpembayaran2']);
		}else{
			$model->jmlpembayaran = MyFormatter::formatNumberForDb($post['jmlpembayaran']);
		}
		if (isset($post['ispotonggaji']) && $post['ispotonggaji'] == 1 &&  $model->sisapengembalian > 0) {

			$str = explode(" ", $post['periodegaji']);
			$monthInt = MyFormatter::getMonthDb($str[0]);

			$model->periodegaji = date('Y-m-d', strtotime($str[1].'-'.$monthInt.'-'.'01'));
			// var_dump($model->periodegaji);die;
			
			$model->totalpotongan = $model->sisapengembalian;
			$model->komponengaji_id = 105;
		}else{
			$model->periodegaji = null;
			$model->totalpotongan=0;
		}
		if($model->totalpiutang > 0 || $model->totalhutang > 0){
			// $model->totalpiutang = MyFormatter::formatNumberForDb($model->totalpiutang);
			$model->tgljatuhtempo = MyFormatter::formatDateTimeForDb($model->tgljatuhtempo);
		}else{
			// $model->totalpiutang = 0;
			$model->tgljatuhtempo = null;
		}
		if($model->totalhutang > 0){
			$model->ishutang = true;
		}
		if($model->totalpiutang > 0){
			$model->ispiutang = true;
		}
		if ($model->validate()) {
			$model->save();
			$this->succesSave = true;
			// var_dump($model->getErrors());die;
		}else{
			// var_dump($model->getErrors());die;
			$this->succesSave = false;
		}
		// var_dump($model->attributes);die;
		return $model;
	}
	protected function saveAdvance($postAdvance, $model) {
		$format = new MyFormatter();
		
		$model->attributes = $postAdvance;
		
        $model->tglpengajuan = isset($postAdvance['tglpengajuan'])?$format->formatDateTimeForDB($postAdvance['tglpengajuan']):null;
		$model->jmlpembayaran = $format->formatNumberForDb($postAdvance['jmlpembayaran']);
		if ($model->validate()) {
			$model->save();
			$this->succesSave = true;
		} else {

			// var_dump($model->getErrors());die;
			$this->succesSave = false;
		}
                
		return $model;
	}

	// get pegawai

	protected function saveUraianSettlement($arrPostUraian, $settlement) {

		// var_dump($arrPostUraian);die;
        $valid = false;
        $modUraian = array();
        for ($i = 0; $i < count($arrPostUraian); $i++) {
            	$modUraian[$i] = new SettlementpaymentdetT();
                $modUraian[$i]->attributes = $arrPostUraian[$i];
                $modUraian[$i]->hargasatuan = MyFormatter::formatNumberForDb($arrPostUraian[$i]['hargasatuan']);
                $modUraian[$i]->totalharga =   $modUraian[$i]->hargasatuan * $modUraian[$i]->volume;
                $modUraian[$i]->tgltransaksi = MyFormatter::formatDateTimeForDb($arrPostUraian[$i]['tgltransaksi']);
                $modUraian[$i]->settlementpayment_id = $settlement->settlementpayment_id;
                if ($modUraian[$i]->validate()) {
                    $modUraian[$i]->save();
                    $valid = true;
                } else {
                    $this->pesan = $modUraian[$i]->getErrors();
                }
        }
        $this->succesSave = $valid;
        return $modUraian;
    }

	protected function saveLampiranSettlement($arrPostUraian, $settlement) {
        $valid = false;
        $modUraian = array();

		foreach($arrPostUraian as $i => $post){
			$modUraian = new SettlementpaymentlampT();
            $modUraian->attributes = $_POST['SettlementpaymentlampT'][$i];
            $modUraian->settlementpayment_id = $settlement->settlementpayment_id;
				// var_du);die;
				if (!empty(CUploadedFile::getInstance($modUraian, '[' . $i . ']lampiran'))) {

					// var_dump('asdasd');die;
					$modUraian->lampiran = CUploadedFile::getInstance($modUraian, '[' . $i . ']lampiran');
					$gambar = $modUraian->lampiran;
					// var_dump($gambar);die;
					Yii::import("ext.EPhpThumb.EPhpThumb");
					$thumb = new EPhpThumb();
					$thumb->init(); //this is needed
					$random = rand(0000000, 9999999);
					$fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $random . $gambar));
					$fullImgSource = Params::pathSettlementDirectory() . $fullImgName;
					// $fullThumbSource = Params::pathRuanganTumbsDirectory() . 'kecil_' . $fullImgName;
					$modUraian->lampiran = $fullImgName;
				}
				// var_dump($modUraian->attributes);die;
				if ($modUraian->validate()) {
					if (!empty($gambar)) {
						 $gambar->saveAs($fullImgSource);
					}
					// var_dump('sadasd');die;
						$modUraian->save();
				} else {
					// var_dump($modUraian->getErrors());
					$this->pesan = $modUraian->getErrors();
				}

		}

        $this->succesSave = $valid;
        // return $modUraian;
    }

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
	 * method untuk save tanda bukti keluar ke supplier 
	 * digunakan di
	 * 1. keuangan/PembayaranKeSupplierUmum/index
	 * @param array $postBuktiKeluar post request $_POST['KUTandaBuktiKeluarT']
	 * @param object $modBayarSupplier KUBayarSupplierT
	 * @param object $modBuktiBayar KUTandaBuktiKeluarT
	 * @return object KUTandaBuktiKeluarT
	 */
	protected function saveTandaBuktiBayar($postTandaBukti, $model) {
		$format = new MyFormatter();
		// $format = new MyFormatter();
        $modBuktiBayar = new KUTandabuktibayarT;
        $modBuktiBayar->attributes = $postTandaBukti;
        $modBuktiBayar->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modBuktiBayar->nourutkasir = MyGenerator::noUrutKasir($modBuktiBayar->ruangan_id);
        $modBuktiBayar->nobuktibayar = MyGenerator::noBuktiBayar();

        $modBuktiBayar->jmlpembulatan = 0;
        $modBuktiBayar->biayaadministrasi = MyFormatter::formatNumberForDb($postTandaBukti['biayaadministrasi']);
        $modBuktiBayar->biayamaterai = 0;
        $modBuktiBayar->carapembayaran = $postTandaBukti['carapembayaran'];
		$modBuktiBayar->sebagaipembayaran_bkm = $model->terimadari.' - '.$model->nosettlement;
		$modBuktiBayar->darinama_bkm = $model->terimadari;
        $modBuktiBayar->uangditerima = MyFormatter::formatNumberForDb($postTandaBukti['uangditerima']);
        $modBuktiBayar->jmlpembayaran = $modBuktiBayar->uangditerima + $modBuktiBayar->biayaadministrasi;
        
		$modBuktiBayar->settlementpayment_id = $model->settlementpayment_id;
		$modBuktiBayar->uangkembalian = $modBuktiBayar->jmlpembayaran - $modBuktiBayar->uangditerima;
        $modBuktiBayar->shift_id = Yii::app()->user->getState('shift_id');
        $modBuktiBayar->profilrs_id = $model->profilrs_id;
        $modBuktiBayar->tglbuktibayar = date('Y-m-d H:i:s');
        $modBuktiBayar->create_time = date('Y-m-d H:i:s');
        $modBuktiBayar->create_loginpemakai_id = Yii::app()->user->id;
        $modBuktiBayar->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modBuktiBayar->validate()) {
            $modBuktiBayar->save();
            $this->succesSave = true;
        } else {
            $this->succesSave = false;
			// var_dump($modBuktiBayar->getErrors());die;
            $this->pesan = $modBuktiBayar->getErrors();
        }

		$this->updateSettlementPayment($model,$modBuktiBayar);
		return $modBuktiBayar;
	}

	protected function saveTandaBuktiKeluar($postTandaBukti, $model) {
		$format = new MyFormatter();
		// $format = new MyFormatter();
		$modBuktiKeluar = new KUTandabuktikeluarT;
        $modBuktiKeluar->attributes = $postTandaBukti;
        $modBuktiKeluar->tahun = date('Y');
        $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
        $modBuktiKeluar->biayaadministrasi = $format::formatNumberForDb($postTandaBukti['biayaadministrasi']);
        $modBuktiKeluar->jmlkaskeluar = $format::formatNumberForDb($postTandaBukti['jmlkaskeluar']);
        // $modBuktiKeluar->jmlkaskeluar = 0;
        $modBuktiKeluar->namapenerima = !empty($postBuktiKeluar['namapenerima']) ? $postBuktiKeluar['namapenerima'] : "-";
        $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modBuktiKeluar->tahun = date('Y');
        $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
        $modBuktiKeluar->settlementpayment_id = $model->settlementpayment_id;
        $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
        $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
        $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modBuktiKeluar->tglkaskeluar = MyFormatter::formatDateTimeForDb($postTandaBukti['tglkaskeluar']);
        $this->succesSave = false;
        if($modBuktiKeluar->validate()){
            $modBuktiKeluar->save();
            $this->succesSave = true;
        } else {
            $this->succesSave = false;
            $this->pesan = $modBuktiKeluar->getErrors();
        }

        return $modBuktiKeluar;
	}

	protected function updateSettlementPayment($model, $modBuktiBayar) {
		SettlementpaymentT::model()->updateByPk($model->settlementpayment_id, array('tandabuktibayar_id' => $modBuktiBayar->tandabuktibayar_id));
	}
	public function actionPrint($settlementpayment_id = null) {
		// $judulKuitansi = '----- Tanda Bukti Bayar Supplier -----';
		$format = new MyFormatter();
        
    
        $model = SettlementpaymentT::model()->findByPk($settlementpayment_id);
        $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('advancepayment_id' => $model->advancepayment_id),array('order'=>'create_time DESC'));
        $modTandaBuktiKeluar = TandabuktikeluarT::model()->findByAttributes(array('settlementpayment_id' => $model->settlementpayment_id),array('order'=>'create_time DESC'));
        $modBuktiBayar = KUTandabuktibayarT::model()->findByAttributes(array('tandabuktibayar_id' => $model->tandabuktibayar_id),array('order'=>'create_time DESC'));
		$modDetails = SettlementpaymentdetT::model()->findAllByAttributes(array('settlementpayment_id'=>$model->settlementpayment_id));

		$judulKuitansi = 'RINCIAN SETTLEMENT ADVANCE PAYMENT';
		
		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
        } else {
			// var_dump('sadasd');die;
            $this->layout = '//layouts/iframe';
        }
			$this->render('Print', array(
				'judulKuitansi' => $judulKuitansi,
				'caraPrint' => $caraPrint,
				'modBuktiKeluar' => $modBuktiKeluar,
				'modBuktiBayar' => $modBuktiBayar,
				'model' => $model,
				'modDetails' => $modDetails,
				'modTandaBuktiKeluar'=>$modTandaBuktiKeluar
			));
		
	}


    protected function saveJurnalRekening($model, $modBuktiBayar)
    {
        $period = Yii::app()->user->getState('periode_ids');
		// var_dump($period);die;

        if (is_array($period)) {
            $period = $period[0];
        }
		// var_dump($model->sebagaipembayaran);die;
        $format = new MyFormatter();
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
        $modJurnalRekening->tglbuktijurnal = $model ? $format->formatDateTimeForDB($model->tglsettlement) : date('Y-m-d H:i:s');
        $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = $model->nosettlement;
        $modJurnalRekening->profilrs_id = $model->profilrs_id;
        $modJurnalRekening->tglreferensi = $model ? $format->formatDateTimeForDB($model->tglsettlement) : date('Y-m-d H:i:s');
       
        $modJurnalRekening->urianjurnal = $model->sebagaipembayaran;

        $periodeID = $period;
        $modJurnalRekening->rekperiod_id = $periodeID;
        $modJurnalRekening->create_time = date('Y-m-d H:i:s');
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->settlementpayment_id = $model->settlementpayment_id;
		if($model->tandabuktibayar){
			$modJurnalRekening->tandabuktibayar_id = $model->tandabuktibayar->tandabuktibayar_id;
		}
		if($model->tandabuktikeluar){
			$modJurnalRekening->tandabuktikeluar_id = $model->tandabuktikeluar->tandabuktikeluar_id;
		}
		
		// var_dump($modJurnalRekening->attributes);die;

        if($modJurnalRekening->validate()){
			// var_dump('simpan');die;
            $modJurnalRekening->save();
            $this->succesSave = true;
       
        } else {
			// var_dump('simpan');die;
            $this->succesSave = false;
			var_dump($modJurnalRekening->getErrors());die;
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
            $modelJurnalDetail->saldokredit = MyFormatter::formatRupiahForDB($nilaisaldo);
            $modelJurnalDetail->saldodebit = 0;
        }else if($typeSaldo == 'D'){
            $modelJurnalDetail->saldodebit =  MyFormatter::formatRupiahForDB($nilaisaldo);
            $modelJurnalDetail->saldokredit = 0;
        }

		// var_dump($modJurnalRekening);die;
        if($modelJurnalDetail->validate()){
                $modelJurnalDetail->save();
            }else{
				// var_dump($modJurnalRekening,$rekening5_id, $nilaisaldo, $typeSaldo, $nourut);
				// // var_dump( $nilaisaldo);die;
				
				// var_dump( $modelJurnalDetail->nourut );die;
				// var_dump( $modelJurnalDetail->getErrors());die;

                $valid = false;
            }

        return $valid;        
    } 
    //rincian

	public function actionRincian($advancepayment_id) {
		$model = SettlementpaymentT::model()->findByPk($advancepayment_id);
		$modBuktiBayar = KUTandabuktikeluarT::model()->findByAttributes(array('advancepayment_id' => $model->advancepayment_id),array('order'=>'create_time DESC'));

		
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
		$model = new  KUSettlementpaymentT('searchInformasi');
		$format = new  MyFormatter();
		// $modBuktiBayarKeluar = new KUTandabuktikeluarT();
		$model->tgl_awal = date('Y-m-d');
		$model->tgl_akhir = date('Y-m-d');
		
		$model->tgl_awal2 = date('Y-m-d');
		$model->tgl_akhir2 = date('Y-m-d');

		$model->statusbatal = 'BELUM DIBATALKAN';

		if (isset($_GET['KUSettlementpaymentT'])) {
			// var_dump('asdasdasd');die;
			$model->attributes = $_GET['KUSettlementpaymentT'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['KUSettlementpaymentT']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUSettlementpaymentT']['tgl_akhir']);
			$model->tgl_awal2 = $format->formatDateTimeForDb($_GET['KUSettlementpaymentT']['tgl_awal2']);
			$model->tgl_akhir2 = $format->formatDateTimeForDb($_GET['KUSettlementpaymentT']['tgl_akhir2']);
			$model->ceklis = $_GET['KUSettlementpaymentT']['ceklis'];
			$model->profilrs_id = isset($_GET['KUSettlementpaymentT']['profilrs_id']) ? $_GET['KUSettlementpaymentT']['profilrs_id'] : null;
			$model->statusbatal = isset($_GET['KUSettlementpaymentT']['statusbatal']) ? $_GET['KUSettlementpaymentT']['statusbatal'] : null;
			$model->statussettlement = isset($_GET['KUSettlementpaymentT']['statussettlement']) ? $_GET['KUSettlementpaymentT']['statussettlement'] : null;
		}

		
		$this->render($this->path_view.'informasi', array(
			'model' => $model,
			// 'modBuktiBayarKeluar' => $modBuktiBayarKeluar
		));

	}


	public function actionBatal($settlementpayment_id){
		$this->layout = '//layouts/iframe';
			$model= SettlementpaymentT::model()->findByPk($settlementpayment_id);
			$model->tglpembatalan =date('Y-m-d h:i:s');
			$log = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
			$modPeg = PegawaiM::model()->findByPk($log->pegawai_id);
			$model->pegawaibatal_id = $log->pegawai_id;
			$model->pegawaibatal_nama = $modPeg->nama_pegawai;
			if(isset($_POST['SettlementpaymentT'])){
				$model->attributes = $_POST['SettlementpaymentT'];
				

				if($model->save()){
					$tandabukti = TandabuktikeluarT::model()->findByAttributes(array('settlementpayment_id' => $model->settlementpayment_id));
					$tandabayar = TandabuktibayarT::model()->findByAttributes(array('settlementpayment_id' => $model->settlementpayment_id));
					if ($tandabukti) {
						$jurnal = JurnalrekeningT::model()->findByAttributes(array('tandabuktikeluar_id' => $tandabukti->tandabuktikeluar_id));
						if ($jurnal) {
							$delete = JurnaldetailT::model()->deleteAllByAttributes(array('jurnalrekening_id' => $jurnal->jurnalrekening_id));
							if($delete){
								$jurnal->delete();
							}
						}
						$tandabukti->delete();
					}
					if ($tandabayar) {
						$jurnal = JurnalrekeningT::model()->findByAttributes(array('tandabuktibayar_id' => $tandabukti->tandabuktibayar_id));
						if ($jurnal) {
							$delete = JurnaldetailT::model()->deleteAllByAttributes(array('jurnalrekening_id' => $jurnal->jurnalrekening_id));
							if($delete){
								$jurnal->delete();
							}
						}
						$tandabayar->delete();
					}
					$jurnal = JurnalrekeningT::model()->findByAttributes(array('settlementpayment_id' => $model->settlementpayment_id));
					if($jurnal){
						$delete = JurnaldetailT::model()->deleteAllByAttributes(array('jurnalrekening_id' => $jurnal->jurnalrekening_id));
							if($delete){
								$jurnal->delete();
							}
					}
					// $jurnalRekening = JurnalrekeningT::model()->findByAttributes(array())
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				}
			}
	   $this->render('_batal', array(
		   'modInvoice' => $model,
	   ));
   }

   public function actionDaftarJenisPengeluaran()
   {
	   if(Yii::app()->request->isAjaxRequest) {
		//    if (!isset($_GET['term'])){
		// 	   $_GET['term'] = null;
		//    }
		    $returnVal = array();
		    // $jenispengeluaran_id = isset($_GET['jenispengeluaran_id']) ? $_GET['jenispengeluaran_id'] : Yii::app()->user->getState('ruangan_id'); // RND-6244

			$criteria = new CDbCriteria();
			$criteria->select = 't.jenispengeluaran_id, t.jenispengeluaran_nama, r.rekening5_id, r.kdrekening5,r.nmrekening5';
			$criteria->join = 'LEFT JOIN jnspengeluaranrek_m j ON t.jenispengeluaran_id = j.jenispengeluaran_id 
							   LEFT JOIN rekening5_m r ON j.rekening5_id = r.rekening5_id';
			// $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
			if (isset($_GET['jenispengeluaran_id'])){
				if(!empty($_GET['jenispengeluaran_id'])){
					$criteria->addCondition("t.jenispengeluaran_id = ".$_GET['jenispengeluaran_id']);						
				}
			}
		
			$criteria->order = 'jenispengeluaran_nama';
			$models = JenispengeluaranM::model()->findAll($criteria);
			if(isset($models)){
				foreach($models as $i=>$model)
				{
					$attributes = $model->attributeNames();
					foreach($attributes as $j=>$attribute) {
						$returnVal[$i]["$attribute"] = $model->$attribute;
					}
					$returnVal[$i]['label'] = $model->jenispengeluaran_nama;
					$returnVal[$i]['value'] = $model->jenispengeluaran_id;
					$returnVal[$i]['rekening5_id'] = $model->rekening5_id;
					$returnVal[$i]['nmrekening5'] = $model->nmrekening5;
					$returnVal[$i]['kdrekening5'] = $model->kdrekening5;
				}
			}

			   echo CJSON::encode($returnVal);
		//    }
	   }
	   Yii::app()->end();
   } 

   public function actionDaftarRekeningDebit()
   {
	   if(Yii::app()->request->isAjaxRequest) {
		//    if (!isset($_GET['term'])){
		// 	   $_GET['term'] = null;
		//    }
		    $returnVal = array();
		    $rekening5_id = isset($_GET['rekening5_id']) ? $_GET['rekening5_id'] : Yii::app()->user->getState('ruangan_id'); // RND-6244

			$criteria = new CDbCriteria();
			// $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
			if (isset($_GET['rekening5_id'])){
				if(!empty($_GET['rekening5_id'])){
					$criteria->addCondition("rekening5_id = ".$_GET['rekening5_id']);						
				}
			}
		
			$criteria->order = 'nmrekening5';
			$models = Rekening5M::model()->findAll($criteria);
			if(isset($models)){
				foreach($models as $i=>$model)
				{
					$attributes = $model->attributeNames();
					foreach($attributes as $j=>$attribute) {
						$returnVal[$i]["$attribute"] = $model->$attribute;
					}
					$returnVal[$i]['label'] = $model->nmrekening5;
					$returnVal[$i]['value'] = $model->rekening5_id;
				}
			}

			   echo CJSON::encode($returnVal);
		//    }
	   }
	   Yii::app()->end();
   } 

}

?>
