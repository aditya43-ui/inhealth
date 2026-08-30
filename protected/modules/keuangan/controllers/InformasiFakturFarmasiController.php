<?php
class InformasiFakturFarmasiController extends MyAuthController
{
	public $path_view = 'keuangan.views.informasiFakturFarmasi.';
	protected $successSave = true;
  protected $succesSave = true;
  protected $fakturpembeliandetailtersimpan = true;
	protected $pesan = "succes";
  public $path_viewGF = 'gudangFarmasi.views.fakturPembelian.';

	public function actionIndex()
	{
		$model = new KUInformasifakturpembelianV('searchInformasi');
		$format = new MyFormatter();
		$model->tgl_awal=date('Y-m-d');
		$model->tgl_akhir=date('Y-m-d');

		if(isset($_GET['KUInformasifakturpembelianV'])){
			$model->attributes=$_GET['KUInformasifakturpembelianV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_akhir']);
			if($_GET['berdasarkanJatuhTempo'] > 0){
				$model->tgl_awalJatuhTempo = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_awalJatuhTempo']);
				$model->tgl_akhirJatuhTempo = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_akhirJatuhTempo']);
			} else {
				$model->tgl_awalJatuhTempo = null;
				$model->tgl_akhirJatuhTempo = null;
			}
			$model->statusBayar = isset($_GET['KUInformasifakturpembelianV']['statusBayar'])?$_GET['KUInformasifakturpembelianV']['statusBayar']:null;
		}

		$this->render($this->path_view.'index',array('model'=>$model));
	}


	public function actionDetailsFaktur($idFakturPembelian)
	{
		$this->layout='//layouts/iframe';
		$modFakturPembelian = KUFakturpembelianT::model()->findByPk($idFakturPembelian);
		$modFakturPembelianDetails = KUFakturdetailT::model()->findAll('fakturpembelian_id='.$idFakturPembelian.'');

		$this->render('detailsFaktur',array('modFakturPembelian'=>$modFakturPembelian,
											'modFakturPembelianDetails'=>$modFakturPembelianDetails));

	}

    public function actionPrint(){
        $model = new KUInformasifakturpembelianV('searchLaporan');
        $format = new MyFormatter();
		$model->tgl_awal=date('Y-m-d');
		$model->tgl_akhir=date('Y-m-d');
        $judulLaporan = 'Informasi Faktur Pembelian Farmasi';
        //Data Grafik
        $data['title'] = 'Informasi Faktur Pembelian Farmasi';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if(isset($_GET['KUInformasifakturpembelianV'])){
            $model->attributes=$_GET['KUInformasifakturpembelianV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_akhir']);
            if($_GET['berdasarkanJatuhTempo'] > 0){
                    $model->tgl_awalJatuhTempo = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_awalJatuhTempo']);
                    $model->tgl_akhirJatuhTempo = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_akhirJatuhTempo']);
            } else {
                    $model->tgl_awalJatuhTempo = null;
                    $model->tgl_akhirJatuhTempo = null;
            }
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

	protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if(empty($model->tgl_awal)){
            $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        }
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
           // //$mpdf->useOddEven = 2;
            //$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10),true));
			//$mpdf->SetHTMLFooter('{PAGENO}');
            ////$mpdf->useOddEven = 1;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);

            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

	public function actionRetur($idFakturPembelian)
	{
		$this->layout='//layouts/frameDialog';
		$modFaktur = BKFakturPembelianT::model()->findByPk($idFakturPembelian);
		$modFakturDetail = BKFakturDetailT::model()->findAll('fakturpembelian_id='.$idFakturPembelian.'');
		$modRetur = new BKReturPembelianT;
		$modRetur->fakturpembelian_id=$modFaktur->fakturpembelian_id;
		$modRetur->noretur=  Generator::noRetur();
		$modRetur->totalretur=0;
		$modRetur->tglretur=date('Y-m-d H:i:s');
		$modRetur->supplier_id=$modFaktur->supplier_id;
		$modRetur->create_loginpemakai_id = Yii::app()->user->id;
		$modRetur->update_loginpemakai_id = Yii::app()->user->id;
		$modRetur->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modRetur->create_time = date('Y-m-d H:i:s');
		$modRetur->update_time = date('Y-m-d H:i:s');
		$modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modReturDetails = new BKReturDetailT;
		$tersimpan=false;
		$modRetur->is_posting = 'retur';

		if(isset($_POST['BKReturPembelianT'])){
			$modRetur->attributes = $_POST['BKReturPembelianT'];
			$modRetur->penerimaanbarang_id = $modFaktur->penerimaanbarang_id;

		$transaction = Yii::app()->db->beginTransaction();
		try {
			$jumlahCekList=0;
			$jumlahSave=0;
			$modRetur = new BKReturPembelianT;

			$modRetur->attributes=$_POST['BKReturPembelianT'];
			$modRetur->ruangan_id=Yii::app()->user->getState('ruangan_id');
			$modRetur->penerimaanbarang_id = $modFaktur->penerimaanbarang_id;
			$modRetur->create_loginpemakai_id = Yii::app()->user->id;
			$modRetur->update_loginpemakai_id = Yii::app()->user->id;
			$modRetur->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modRetur->create_time = date('Y-m-d H:i:s');
			$modRetur->update_time = date('Y-m-d H:i:s');

			if($modRetur->save()){

			$modJurnalRekening = $this->saveJurnalRekening($modRetur, $_POST['BKReturPembelianT']);
			if($_POST['BKReturPembelianT']['is_posting']=='posting')
			{
				$modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
			}else{
				$modJurnalPosting = null;
			}

			$noUrut = 0;
			foreach($_POST['RekeningakuntansiV'] AS $i => $post){
				$modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, $modJurnalPosting);
				$noUrut ++;
			}


			$jumlahObat=COUNT($_POST['BKReturDetailT']['obatalkes_id']);
				for($i=0; $i<=$jumlahObat; $i++){
				   if($_POST['checkList'][$i]=='1'){
						$jumlahCekList++;
						$modReturDetails = new BKReturDetailT;
						$modReturDetails->penerimaandetail_id=$_POST['BKReturDetailT']['penerimaandetail_id'][$i];
						$modReturDetails->obatalkes_id=$_POST['BKReturDetailT']['obatalkes_id'][$i];
						$modReturDetails->satuanbesar_id=$_POST['BKReturDetailT']['satuanbesar_id'][$i];
						$modReturDetails->fakturdetail_id=$_POST['BKReturDetailT']['fakturdetail_id'][$i];
						$modReturDetails->sumberdana_id=$_POST['BKReturDetailT']['sumberdana_id'][$i];
						$modReturDetails->returpembelian_id=$modRetur->returpembelian_id;
						$modReturDetails->satuankecil_id=$_POST['BKReturDetailT']['satuankecil_id'][$i];
						$modReturDetails->jmlretur=$_POST['BKReturDetailT']['jmlretur'][$i];
						$modReturDetails->harganettoretur=$_POST['BKReturDetailT']['harganettoretur'][$i];
						$modReturDetails->hargappnretur=$_POST['BKReturDetailT']['hargappnretur'][$i];
						$modReturDetails->hargapphretur=$_POST['BKReturDetailT']['hargapphretur'][$i];
						$modReturDetails->jmldiscount=$_POST['BKReturDetailT']['jmldiscount'][$i];
						$modReturDetails->hargasatuanretur=$_POST['BKReturDetailT']['hargasatuanretur'][$i];

						//ini digunakan untuk mendapatkan jumalah terima dari tabel faktur detail
						$fd = FakturdetailT::model()->findByPk($modReturDetails->fakturdetail_id);
						$idfd = $fd->fakturdetail_id;
						$jum1 = $fd->jmlterima;
						$jum2 = $modReturDetails->jmlretur;
						$jumupdate = $jum1-$jum2;

						if($modReturDetails->save()){
							$jumlahSave++;
							PenerimaandetailT::model()->updateByPk($modReturDetails->penerimaandetail_id,
																	array('returdetail_id'=>$modReturDetails->returdetail_id));

							//ini digunakan untuk mengupdata tabel faktur detail dan penerimaan detail ketika terjadi retur
							FakturdetailT::model()->updateByPk($idfd, array('jmlterima'=>$jumupdate));
							PenerimaandetailT::model()->updateByPk($modReturDetails->penerimaandetail_id, array('jmlterima'=>$jumupdate));
							//========================================================

							$idStokObatAlkes=PenerimaandetailT::model()->findByPk($modReturDetails->penerimaandetail_id)->stokobatalkes_id;

							$stokObatAlkesIN=StokobatalkesT::model()->findByPk($idStokObatAlkes)->qtystok_in;
							$stokCurrent=StokobatalkesT::model()->findByPk($idStokObatAlkes)->qtystok_current;

							$stokINBaru=$stokObatAlkesIN - $modReturDetails->jmlretur;
							$stokCurrentBaru=$stokCurrent - $modReturDetails->jmlretur;
							StokobatalkesT::model()->updateByPk($idStokObatAlkes,array('qtystok_in'=>$stokINBaru,
																						 'qtystok_current'=>$stokCurrentBaru));
						}

					}
				}//endfor

			 }

			 if(($jumlahCekList==$jumlahSave) and ($jumlahCekList>0)){
				 $transaction->commit();
					Yii::app()->user->setFlash('success',"Data Berhasil Disimpan ");
					$tersimpan=true;

			 }else{
					Yii::app()->user->setFlash('error',"Data gagal disimpan ");
					$transaction->rollback();
			 }
		 }catch(Exception $exc){
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
				}

		}

		$this->render($this->path_view.'retur',array('modFaktur'=>$modFaktur,
						'modFakturDetail'=>$modFakturDetail,
						'modRetur'=>$modRetur,
						'modReturDetails'=>$modReturDetails,
						'tersimpan'=>$tersimpan
					));
	}

    protected function saveJurnalRekening($modRetur, $postPenUmum)
    {
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->tglbuktijurnal = $modRetur->tglretur;
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modRetur->tglretur, "JUB");
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = 0;
        $modJurnalRekening->tglreferensi = $modRetur->tglretur;
        $modJurnalRekening->nobku = "";
        $modJurnalRekening->urianjurnal = "Retur ".$postPenUmum['noretur'];

        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
        $periodeID = Yii::app()->session['periodeID'];
        $modJurnalRekening->rekperiod_id = $periodeID[0];
        $modJurnalRekening->create_time = $modRetur->tglretur;
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if($modJurnalRekening->validate()){
            $modJurnalRekening->save();
            $this->successSave = true;
        } else {
            $this->successSave = false;
            $this->pesan = $modJurnalRekening->getErrors();
        }

        return $modJurnalRekening;
    }

    public function saveJurnalDetail($modJurnalRekening, $post, $noUrut=0, $modJurnalPosting=null){
        $modJurnalDetail = new JurnaldetailT();
        $modJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
        $modJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $modJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $modJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
        $modJurnalDetail->saldodebit = $post['saldodebit'];
        $modJurnalDetail->saldokredit = $post['saldokredit'];
        $modJurnalDetail->nourut = $noUrut;
        $modJurnalDetail->rekening5_id = $post['rincianobyek_id'];
        $modJurnalDetail->catatan = "";

        if($modJurnalDetail->validate()){
            $modJurnalDetail->save();
        }
        return $modJurnalDetail;
    }

    protected function saveJurnalPosting($arrJurnalPosting)
    {
        $modJurnalPosting = new JurnalpostingT;
        $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
        $modJurnalPosting->keterangan = "Posting automatis";
        $modJurnalPosting->create_time = date('Y-m-d H:i:s');
        $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
        $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if($modJurnalPosting->validate()){
            $modJurnalPosting->save();
            $this->successSave = true;
        } else {
            $this->successSave = false;
            $this->pesan = $modJurnalPosting->getErrors();
        }
        return $modJurnalPosting;
    }

    public function actionMenyetujui($fakturpembelian_id,$approve=false,$tolak=false)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
                $modTerima = FakturpembelianT::model()->findByPk($fakturpembelian_id);
        $modDetailTerima = FakturdetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));
		if($approve){
                    $modAppr = ApprovalotorisasiM::model()->find();
                    $pegawaid = "";

                    if(isset($modAppr)){
                         $sumber = "";
                            $penerimaan = PenerimaanbarangT::model()->findByPk($modTerima->penerimaanbarang_id);
                            if(isset($penerimaan)){
                                $permintaan = PermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id'=>$penerimaan->permintaanpembelian_id));

                                if(isset($permintaan)){
                                    $sumber = $permintaan->sumberdana_id;
                                }
                            }
                        if($sumber == Params::SUMBERDANA_ID_PT){
                            $pegawaid = $modAppr->managerkeuanganpt_id;
                        }else{
                            $pegawaid = $modAppr->managerkeuangan_id;
                        }
                    }
			$update = FakturpembelianT::model()->updateByPk($fakturpembelian_id,array('tgl_menyetujuikeuangan'=>date("Y-m-d"),'pegawaimenyetujuikeuangan_id'=>$pegawaid));
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('menyetujui','fakturpembelian_id'=>$fakturpembelian_id,'sukses'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
        $judulLaporan = 'Faktur Pembelian Farmasi';
		$deskripsi = '';
        $this->render('menyetujui', array(
				'format'=>$format,
				'modFakturPembelian'=>$modTerima,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modFakturPembelianDetails'=>$modDetailTerima
		));

	}

	public function actionPrintMenyetujui($fakturpembelian_id)
    {
		$format = new MyFormatter();
		$modTerima = FakturpembelianT::model()->findByPk($fakturpembelian_id);
        $modDetailTerima = FakturdetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));
		$judulLaporan = 'Faktur Pembelian Farmasi';
		$deskripsi = '';
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printMenyetujui',array('format'=>$format,'modFakturPembelian'=>$modTerima,'modFakturPembelianDetails'=>$modDetailTerima,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printMenyetujui',array('format'=>$format,'modFakturPembelian'=>$modTerima,'modFakturPembelianDetails'=>$modDetailTerima,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('', $ukuranKertasPDF);
                        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
                        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
                        $mpdf->WriteHTML($formatkonten, 1);
                        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
                        $mpdf->WriteHTML($stylesheet, 1);

			$mpdf->WriteHTML($this->renderPartial('printMenyetujui',array('format'=>$format,'modFakturPembelian'=>$modTerima,'modFakturPembelianDetails'=>$modDetailTerima,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }

    public function actionUbahFaktur($fakturpembelian_id){
        $format = new MyFormatter();

        $modFakturPembelian = KUFakturpembelianT::model()->findByPk($fakturpembelian_id);
        $modPenerimaanBarang = PenerimaanbarangT::model()->findByPk($modFakturPembelian->penerimaanbarang_id);
        $modDetails = KUFakturdetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));
        $modPenerimaanBarang->nopermintaan = (isset($modPenerimaanBarang->permintaanpembelian)? $modPenerimaanBarang->permintaanpembelian->nopermintaan : "");
        $modPenerimaanBarang->pegawai_nama = (!empty($modPenerimaanBarang->pegawai_id)?$modPenerimaanBarang->pegawai->namaLengkap:"");
        $modPenerimaanBarang->mengetahui_nama = (!empty($modPenerimaanBarang->pegawaimengetahui_id)?$modPenerimaanBarang->pegawaimengetahui->namaLengkap:"");
        $modPenerimaanBarang->supplier_nama = (!empty($modPenerimaanBarang->supplier_id)?$modPenerimaanBarang->supplier->supplier_nama:"");
        $modFakturPembelian->pajak_nama = (isset($modFakturPembelian->pajak)? $modFakturPembelian->pajak->pajak_nama : "");

        $modUangmuka = new UangmukabeliT();

         if(!empty($modPenerimaanBarang->permintaanpembelian_id)){
            $modUangmuka = UangmukabeliT::model()->findByAttributes(array('permintaanpembelian_id'=>$modPenerimaanBarang->permintaanpembelian_id));
            if(isset($modUangmuka)){
                $modUangmuka->tgluangmukabeli = MyFormatter::formatDateTimeForUser($modUangmuka->tgluangmukabeli);
            }else{
							$modUangmuka = new UangmukabeliT();
						}
        }


        if (isset($_POST['KUFakturpembelianT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
            $modFakturPembelian->attributes = $_POST['KUFakturpembelianT'];
            $modFakturPembelian->update_loginpemakai_id = Yii::app()->user->id;
            $modFakturPembelian->update_time = date('Y-m-d H:i:s');
            $modFakturPembelian->tglfaktur = $format->formatDateTimeForDB($modFakturPembelian->tglfaktur);
            $modFakturPembelian->tgljatuhtempo = $format->formatDateTimeForDB($modFakturPembelian->tgljatuhtempo);

            if ($modFakturPembelian->validate()) {

                    $success = true;
                    if($modFakturPembelian->save()){

                        $updatePenerimaanBarang = PenerimaanbarangT::model()->findByPk($modFakturPembelian->penerimaanbarang_id);
                    if(isset($updatePenerimaanBarang)){
                        $updatePenerimaanBarang->fakturpembelian_id = $modFakturPembelian->fakturpembelian_id;
                        $updatePenerimaanBarang->tglterimafaktur = $modFakturPembelian->tglfaktur;

                        if($updatePenerimaanBarang->harganetto != $modFakturPembelian->totharganetto){
                            $updatePenerimaanBarang->harganetto = $modFakturPembelian->totharganetto;
                        }

                         if($updatePenerimaanBarang->jmldiscount != $modFakturPembelian->jmldiscount){
                            $updatePenerimaanBarang->jmldiscount = $modFakturPembelian->jmldiscount;
                        }

                        if($updatePenerimaanBarang->persendiscount != $modFakturPembelian->persendiscount){
                            $updatePenerimaanBarang->persendiscount = $modFakturPembelian->persendiscount;
                        }

                        if($updatePenerimaanBarang->totalpajakppn != $modFakturPembelian->totalpajakppn){
                            $updatePenerimaanBarang->totalpajakppn = $modFakturPembelian->totalpajakppn;
                        }

                        if($updatePenerimaanBarang->totalharga != $modFakturPembelian->totalhargabruto){
                            $updatePenerimaanBarang->totalharga = $modFakturPembelian->totalhargabruto;
                        }
                        $updatePenerimaanBarang->save();
                    }

                    if(isset($_POST['KUFakturdetailT'])){
                        if(count($_POST['KUFakturdetailT'])>0){
                            foreach ($_POST['KUFakturdetailT'] as $i => $dataFaktrDetail) {
                                $modDetails[$i] = $this->simpanFakturDetail($dataFaktrDetail,$modFakturPembelian);
                            }
                        }
                    }
                        if ($success == true) {
                            if(Yii::app()->user->getState('isjurnalotomatis') == true){

                                $checkDatadetail = 0;
                                $modDetailFaktur = FakturdetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id));

                                if(count($modDetailFaktur)>0){
                                    foreach ($modDetailFaktur as $dtFakturDetail){
                                        $modObatAlkesM = ObatalkesM::model()->findByPk($dtFakturDetail->obatalkes_id);
                                        if(isset($modObatAlkesM)){
                                            $modJenisObatRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id'=>$modObatAlkesM->jenisobatalkes_id, 'ispenerimaanoa'=>true));

                                            if(count($modJenisObatRek)>0){
                                                $checkDatadetail++;
                                            }else{
                                                if($checkDatadetail > 1){
                                                    $checkDatadetail--;
                                                }
                                            }
                                        }
                                    }
                                }

                                if($checkDatadetail > 0){
                                    $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id));

                                    if (isset($modJurnalBefore)){
                                        if(count($modJurnalBefore)>0){
                                            foreach ($modJurnalBefore as $jurnalBef){
                                                $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id'=>$jurnalBef->jurnalrekening_id));

                                                if(count($jurnaldetail)>0){
                                                    foreach ($jurnaldetail as $jurnaldetBefor) {
                                                        $jurnaldetBefor->delete();
                                                    }
                                                }
                                                $jurnalBef->delete();
                                            }
                                        }
                                    }

                                    foreach ($modDetailFaktur as $dtFakturDetail){
                                        $modObatAlkesM = ObatalkesM::model()->findByPk($dtFakturDetail->obatalkes_id);
                                        if(isset($modObatAlkesM)){
                                            $modJenisObatRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id'=>$modObatAlkesM->jenisobatalkes_id, 'ispenerimaanoa'=>true));
                                            if(count($modJenisObatRek) >0){
                                                $modJurnalRekening = $this->saveJurnalRekeningFaktur($modFakturPembelian, $dtFakturDetail);
                                                foreach ($modJenisObatRek as $dtJenisrek){
                                                    $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $dtJenisrek);
                                                }
                                                if($modFakturPembelian->totalpajakppn > 0){
                                                    $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '".Params::REKENINGCOLUMN_TABLE_FAKTURDETAILT."' AND column_name = '".Params::REKENINGCOLUMN_COLUMN_OBATALKESID."'");
                                                    if(isset($rekeningcolumn)){
                                                        $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $rekeningcolumn,true);
                                                    }
                                                }

                                                if($modFakturPembelian->totalpajakpph > 0){
                                                    $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '".Params::REKENINGCOLUMN_TABLE_FAKTURDETAILT."' AND column_name = '".Params::REKENINGCOLUMN_COLUMN_PERSENPPHFAKTUR."'");
                                                    if(isset($rekeningcolumn)){
                                                        $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $rekeningcolumn,null,true);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $modJurnalFaktuAfter = JurnalrekeningT::model()->findAllByAttributes(array('fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id));

                                if(count($modJurnalFaktuAfter) > 0){
                                    $rekening_id = null;

                                    foreach ($modJurnalFaktuAfter as $dataFakturAf){
                                        $criteriaJud = new CDbCriteria();
                                        $criteriaJud->addCondition('jurnalrekening_id = '.$dataFakturAf->jurnalrekening_id);
                                        $criteriaJud->addCondition('saldokredit > 0');
                                        $criteriaJud->order = "nourut DESC";
                                        $criteriaJud->limit=1;
                                        $modFakturJurDetAfter = JurnaldetailT::model()->find($criteriaJud);

                                        if(isset($modFakturJurDetAfter)){
                                            $rekening_id = $modFakturJurDetAfter->rekening5_id;
                                        }
                                    }

                                    if(!empty($modFakturPembelian->jmluangmukabeli) && $modFakturPembelian->jmluangmukabeli > 0){
                                        $modJurnalRekening = $this->saveJurnalRekeningUangMuka($modFakturPembelian);

                                        $modRekening5 = Rekening5M::model()->findByPk($rekening_id);

                                        if(isset($modRekening5)){
                                            $this->saveJurnalDetailUangMuka($modJurnalRekening, $modRekening5, $modFakturPembelian->jmluangmukabeli,'D', 1);
                                        }

                                        $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name'=> Params::REKENINGCOLUMN_TABLE_FAKTURPEMBELIANT,'column_name'=>Params::REKENINGCOLUMN_COLUMN_JMLUANGMUKABELI));
                                        if (isset($rekeningcolumn)) {
                                            $this->saveJurnalDetailUangMuka($modJurnalRekening, $rekeningcolumn, $modFakturPembelian->jmluangmukabeli,'K', 2);
                                        }

                                    }
                                }
                            }
                        }

                        if ($success == true) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('ubahFaktur', 'fakturpembelian_id' => $modFakturPembelian->fakturpembelian_id, 'sukses'=>1));
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                        }
                    }
                }else{
                    Yii::app()->user->setFlash('error', "Data gagal disimpan. ");
                }
            } catch (Exception $ex) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan<br/>" . $ex->getMessage() ."<br/>" . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('ubahFaktur', array(
            'modFakturPembelian' => $modFakturPembelian,
            'modPenerimaanBarang' => $modPenerimaanBarang,
            'modDetails' => $modDetails,
            'format' => $format,
            'modUangmuka'=>$modUangmuka
        ));
    }

    public function simpanFakturDetail($postFakturDetail,$modFakturPembelian){
        $format = new MyFormatter();

        $modFakturDetail = KUFakturdetailT::model()->findByPk($postFakturDetail['fakturdetail_id']);
        $modStok = StokobatalkesT::model()->findByAttributes(array('penerimaandetail_id'=>$postFakturDetail['penerimaandetail_id']));

        $modFakturDetail->attributes = $postFakturDetail;
        $modFakturDetail->penerimaandetail_id = $postFakturDetail['penerimaandetail_id'];
        $modFakturDetail->fakturpembelian_id = $modFakturPembelian->fakturpembelian_id;
//        $modFakturDetail->harganettofaktur = $postFakturDetail['harganettoper'];
//        $modFakturDetail->persenppnfaktur = $postFakturDetail['persenppn'];
//        $modFakturDetail->persenpphfaktur = $postFakturDetail['persenpph'];
//        $modFakturDetail->persendiscount = $postFakturDetail['persendiscount'];
//        $modFakturDetail->jmldiscount = $postFakturDetail['jmldiscount'];
//        $modFakturDetail->hargasatuan = $postFakturDetail['hargasatuanper'];
        $modFakturDetail->kemasanbesar = (isset($postFakturDetail['kemasanbesar'])?$postFakturDetail['kemasanbesar']:1);
        $modFakturDetail->tglkadaluarsa = $format->formatDateTimeForDb($modFakturDetail['tglkadaluarsa']);
        $modFakturDetail->jmldiscount = $format->formatRupiahForDb($modFakturDetail['jmldiscount']);
        $modFakturDetail->hargasatuan = $format->formatRupiahForDb($modFakturDetail['hargasatuan']);
        $modFakturDetail->harganettofaktur = $format->formatRupiahForDb($modFakturDetail['harganettofaktur']);

        if($modFakturDetail->validate()) {
            if($modFakturDetail->save()){
                $updatePenerimaan = PenerimaandetailT::model()->findByPk($modFakturDetail->penerimaandetail_id);

                if(isset($updatePenerimaan)){
                    $updatePenerimaan->fakturdetail_id = $modFakturDetail->fakturdetail_id;

                    if($updatePenerimaan->persendiscount != $modFakturDetail->persendiscount){
                        $updatePenerimaan->persendiscount = $modFakturDetail->persendiscount;
                    }

                    if($updatePenerimaan->jmldiscount != $modFakturDetail->jmldiscount){
                        $updatePenerimaan->jmldiscount = $modFakturDetail->jmldiscount;
                    }

                    if($updatePenerimaan->harganettoper != $modFakturDetail->harganettofaktur){
                        $updatePenerimaan->harganettoper = $modFakturDetail->harganettofaktur;
                    }

                    if($updatePenerimaan->persenppn != $modFakturDetail->persenppnfaktur){
                        $updatePenerimaan->persenppn = $modFakturDetail->persenppnfaktur;
                    }

                    if($updatePenerimaan->hargasatuanper != $modFakturDetail->hargasatuan){
                        $updatePenerimaan->hargasatuanper = $modFakturDetail->hargasatuan;
                    }

                    if($updatePenerimaan->save()){

                        $loadObatAlkes = ObatalkesM::model()->findByPk($updatePenerimaan->obatalkes_id);
                        $harganettolama = $loadObatAlkes->harganetto;
                        $hargajuallama = $loadObatAlkes->hargajual;
                        $hargaBerubah = false;
                         $updateHarganetto = false;

                        if ($loadObatAlkes->harganetto != round($updatePenerimaan->harganettoper)){
                            $hargaBerubah = true;
                            if($postFakturDetail['hppcheck']>0){
                                $updateHarganetto = true;
                            }
                        }

                        if ($loadObatAlkes->ppn_persen != round($updatePenerimaan->persenppn)){
                            $loadObatAlkes->ppn_persen = $updatePenerimaan->persenppn;
                            $hargaBerubah = true;
                        }

                        if ($loadObatAlkes->discount != round($updatePenerimaan->jmldiscount)){
                            $loadObatAlkes->discount = $updatePenerimaan->jmldiscount;
                            $hargaBerubah = true;
                        }
                        if($hargaBerubah){
                            if($updateHarganetto){
                                $loadObatAlkes->harganetto = $updatePenerimaan->harganettoper;
                                $judul = 'Perubahan Harga Netto Obat Alkes';
                                $isi = $loadObatAlkes->obatalkes_nama;
                                CustomFunction::broadcastNotif($judul, $isi, array(
                                    array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=> Params::RUANGAN_ID_GUDANG_FARMASI, 'modul_id'=>Params::MODUL_ID_GUDANGFARMASI),
                                ));
                            }


                            $loadObatAlkes->hpp = round($loadObatAlkes->JumHPP);
                            $hargajual = round($loadObatAlkes->hpp + ($loadObatAlkes->hpp * $loadObatAlkes->margin / 100));
                            if($hargajual > $loadObatAlkes->hargamaksimum){
                                $loadObatAlkes->hargamaksimum = round($hargajual);
                            }
                            if($loadObatAlkes->hargaminimum <= 0 || round($hargajual) < $loadObatAlkes->hargaminimum){
                                $loadObatAlkes->hargaminimum = round($hargajual);
                            }
                            if($loadObatAlkes->hargaaverage > 0 && round($hargajual) > 0){
                                $loadObatAlkes->hargaaverage = round(($loadObatAlkes->hargaaverage + round($hargajual)) / 2);
                            }else{
                                $loadObatAlkes->hargaaverage = round($hargajual);
                            }

                            $loadObatAlkes->hargajual = round($hargajual);
                            $loadObatAlkes->hjaresep = round($loadObatAlkes->hpp + ($loadObatAlkes->hpp * $loadObatAlkes->marginresep / 100));
                            $loadObatAlkes->hjanonresep = round($loadObatAlkes->hpp + ($loadObatAlkes->hpp * $loadObatAlkes->marginnonresep / 100));

                            if($loadObatAlkes->save()){

                                $ubah = new UbahhargaobatR();
                                $ubah->obatalkes_id = $loadObatAlkes->obatalkes_id;
                                $ubah->loginpemakai_id = Yii::app()->user->id;
                                $ubah->sumberdana_id = $loadObatAlkes->sumberdana_id;
                                $ubah->tglperubahan = date('Y-m-d');
                                $ubah->alasanperubahan = "Penerimaan Supplier ".$updatePenerimaan->penerimaanbarang->supplier->supplier_nama." - ".$updatePenerimaan->penerimaanbarang->noterima;
                                $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                $ubah->disetujuioleh = $peg->namaLengkap;
                                $ubah->create_time = date('Y-m-d H:i:s');
                                $ubah->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $ubah->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $ubah->harganettoasal = $harganettolama;
                                $ubah->harganettoperubahan = $loadObatAlkes->harganetto;
                                $ubah->hargajualasal = $hargajuallama;
                                $ubah->hargajualperubahan = $loadObatAlkes->hargajual;

                                if ($ubah->validate()) {
                                    $ubah->save();

                                }
                            }
                        }
                    }
                }

                $modStok->tglkadaluarsa = !empty($modFakturDetail->tglkadaluarsa) ? $format->formatDateTimeForDb($modFakturDetail->tglkadaluarsa) : null;
                $modStok->nobatch = "";

                $jmlKms = 0;

                if(!empty($modFakturDetail->satuanbesar_id)){
                    if($modFakturDetail->kemasanbesar > 0){
                        $jmlKms = ($modFakturDetail->jmlterima * $modFakturDetail->kemasanbesar);
                    }else{
                        $jmlKms = $modFakturDetail->jmlterima;
                    }
                }else{
                   $jmlKms = $modFakturDetail->jmlterima;
                }

                $modStok->qtystok_in = $jmlKms;
                $modStok->qtystok_out = 0;
                $modStok->tglstok_in = date("Y-m-d H:i:s");
                $modStok->tglstok_out = null;
                $modStok->harganetto = $modFakturDetail->harganettofaktur;
                $modStok->persendiscount = $modFakturDetail->persendiscount;
                $modStok->jmldiscount = $modFakturDetail->jmldiscount;
                $modStok->persenppn = $modFakturDetail->persenppnfaktur;
                $modStok->persenpph = $modFakturDetail->persenpphfaktur;
                $jmlmargin = $modFakturDetail->hargasatuan * ($modStok->persenmargin/100);
                $modStok->jmlmargin = round($jmlmargin);

                $modStok->update_time = date('Y-m-d H:i:s');
                $modStok->update_loginpemakai_id = Yii::app()->user->id;
                $modStok->save();
            }
        } else {
            $this->fakturpembeliandetailtersimpan &= false;
        }
        return $modFakturDetail;
    }

    protected function saveJurnalRekeningFaktur($modPenUmum, $dtFakturDetail)
        {
            $period = Yii::app()->user->getState('periode_ids');
            if (is_array($period)) {
                $period = $period[0];
            }

            $format = new MyFormatter();
            $modJurnalRekening = new JurnalrekeningT;
            $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_HUTANG;
            $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($modPenUmum->tglfaktur);
            $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
            $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
            $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
            $modJurnalRekening->noreferensi = $modPenUmum->nofaktur;
            $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modPenUmum->tglfaktur);
            $modJurnalRekening->nobku = "";
            $modJurnalRekening->urianjurnal = 'Faktur Pembelian '. (!empty($dtFakturDetail->obatalkes->jenisobatalkes_id)?$dtFakturDetail->obatalkes->jenisobatalkes->jenisobatalkes_nama:"") ." " .$dtFakturDetail->obatalkes->obatalkes_nama ." - ". $modPenUmum->supplier->supplier_nama ." - ". $modPenUmum->nofaktur;

            $periodeID = $period;
            $modJurnalRekening->rekperiod_id = $periodeID;
            $modJurnalRekening->create_time = $format->formatDateTimeForDB($modPenUmum->tglfaktur);
            $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
            $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modJurnalRekening->ruangan_id = $modPenUmum->ruangan_id;
            $modJurnalRekening->fakturpembelian_id = $modPenUmum->fakturpembelian_id;

            if($modJurnalRekening->validate()){
                $modJurnalRekening->save();
                $this->succesSave = true;
            } else {
                $this->succesSave = false;
                $this->pesan = $modJurnalRekening->getErrors();
            }
            return $modJurnalRekening;
        }

        public function saveJurnalDetailFaktur($modJurnalRekening, $postRekenings, $modJenisObatRek, $isPPN=null, $ispph=null){
            $valid = true;
//            $modJurnalPosting = null;
            $jmlTerima = 0;
//            $modFaktur = FakturpembelianT::model()->findByAttributes(array('fakturpembelian_id'=>$postRekenings->fakturpembelian_id));
//            if(Yii::app()->user->getState('ispostingotomatis'))
//            {
//                $modJurnalPosting = new JurnalpostingT;
//                $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
//                $modJurnalPosting->keterangan = "Posting automatis";
//                $modJurnalPosting->create_time = date('Y-m-d H:i:s');
//                $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
//                $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
//                if($modJurnalPosting->validate()){
//                    $modJurnalPosting->save();
//                }
//            }

            $modelJurnalDetail = new JurnaldetailT();
//            $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
            $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
            $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
            $modelJurnalDetail->rekening5_id = $modJenisObatRek->rekening5_id;
            $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

            if(!empty($postRekenings->satuanbesar_id)){
                $jmlTerima = ($postRekenings->jmlterima * $postRekenings->kemasanbesar);
            }else{
                $jmlTerima = $postRekenings->jmlterima;
            }

            $jmlHargaQty = ($postRekenings->harganettofaktur * $jmlTerima);
            $jmlDiskon = ($jmlHargaQty * ($postRekenings->persendiscount/100));
            $hargaNettoDiskon = ($jmlHargaQty - $jmlDiskon);
            $jmlPPn = ($hargaNettoDiskon * ($postRekenings->persenppnfaktur/100));
            $jmlPPh = ($hargaNettoDiskon * ($postRekenings->persenpphfaktur/100));
            $jmlAll = ($hargaNettoDiskon + $jmlPPn - $jmlPPh);

            if($modJenisObatRek->debitkredit == 'K'){
                if(!empty($isPPN)){
                    $modelJurnalDetail->nourut = 3;
                    $modelJurnalDetail->saldokredit = $jmlPPn;
                }

                if(!empty($ispph)){
                    $modelJurnalDetail->nourut = 4;
                    $modelJurnalDetail->saldokredit = $jmlPPh;
                }

                if(empty($isPPN) && empty($ispph)){
                  $modelJurnalDetail->nourut = 5;
                  $modelJurnalDetail->saldokredit = $jmlAll;
                }

                  $modelJurnalDetail->saldodebit = 0;
            }else if($modJenisObatRek->debitkredit == 'D'){
                if(!empty($isPPN)){
                    $modelJurnalDetail->nourut = 2;
                    $modelJurnalDetail->saldodebit = $jmlPPn;
                }

                if(!empty($ispph)){
                    $modelJurnalDetail->nourut = 3;
                    $modelJurnalDetail->saldodebit = $jmlPPh;
                }
                if(empty($isPPN) && empty($ispph)){
                    $modelJurnalDetail->nourut = 1;
                    $modelJurnalDetail->saldodebit = $hargaNettoDiskon;
                }

             $modelJurnalDetail->saldokredit = 0;
            }

            if($modelJurnalDetail->validate()){
                $modelJurnalDetail->save();
            }else{
//                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
                $valid = false;
            }

            return $valid;
        }

        public function actionBatalFaktur()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $transaction = Yii::app()->db->beginTransaction();
            $pesan = 'success';
            $status = 'ok';
            $keterangan = "";

            $fakturpembelian_id = isset($_POST['fakturpembelian_id'])?$_POST['fakturpembelian_id']:null;
            $tglbatal = isset($_POST['tglbatal'])?$_POST['tglbatal']:null;
            $pegawaibatal = isset($_POST['pegawaibatal'])?$_POST['pegawaibatal']:null;
            $keterangan_batal = isset($_POST['keterangan_batal'])?$_POST['keterangan_batal']:null;

            $model = FakturpembelianT::model()->findByPk($fakturpembelian_id);

            try{
                if(isset($model)){
                    $sukses = true;

                    $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('fakturpembelian_id'=>$model->fakturpembelian_id));

                    if (isset($modJurnalBefore)){
                        if(count($modJurnalBefore)>0){
                            foreach ($modJurnalBefore as $jurnalBef){
                                $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id'=>$jurnalBef->jurnalrekening_id));

                                if(count($jurnaldetail)>0){
                                    foreach ($jurnaldetail as $jurnaldetBefor) {
                                        $jurnaldetBefor->delete();
                                    }
                                }
                                $jurnalBef->delete();
                            }
                        }
                    }

                    $modDetail = FakturdetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));
                    if(count($modDetail)>0){
                        foreach ($modDetail as $datadet){
                            $datadet->delete();
                        }
                    }
                    $moddelete = FakturpembelianT::model()->deleteByPk($model->fakturpembelian_id);

                    if(!$moddelete){
                        $sukses = false;
                    }

                    if($sukses){
                        $keterangan = "Data Berhasil Dibatalkan! ";
                        $status = 'ok';
                        $transaction->commit();
                    }else{
                        $keterangan = "Data Gagal Dibatalkan! ";
                        $status = 'not';
                        $transaction->rollback();
                    }
                }
            } catch (Exception $ex) {
                $keterangan = "Data Gagal Dibatalkan! ".print_r($ex);
                $status = 'not';
                $transaction->rollback();
            }

            $data['pesan'] = $pesan;
            $data['status'] = $status;
            $data['keterangan'] = $keterangan;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

     public function actionLoadJatuhTempo()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $tglfaktur = (isset($_POST['tgl_faktur'])? MyFormatter::formatDateTimeForDb($_POST['tgl_faktur']):date('Y-m-d H:i:s'));
            $supplier_id = $_POST['supplier_id'];

            $dateJatuhTempo = date('d/m/Y H:i:s');
            $termin = 0;

            $modSupplier = SupplierM::model()->findByPk($supplier_id);

            if(isset($modSupplier)){
                $termin = $modSupplier->terminpembayaran;
            }
            if($termin > 0){
                $dateJatuhTempo = date('d/m/Y H:i:s',strtotime('+'.$termin.' days', strtotime($tglfaktur)));
            }
            echo CJSON::encode(array('value'=>$dateJatuhTempo));
            Yii::app()->end();
        }
    }

    protected function saveJurnalRekeningUangMuka($model) {
        $period = Yii::app()->user->getState('periode_ids');
        if (is_array($period)) {
            $period = $period[0];
        }

        $format = new MyFormatter();
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
        $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglfaktur);
        $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = $model->nofaktur;
        $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglfaktur);
        $modJurnalRekening->nobku = "";
        $modJurnalRekening->urianjurnal = 'Pengurangan Hutang Usaha dari Uang Muka';

        $periodeID = $period;
        $modJurnalRekening->rekperiod_id = $periodeID;
        $modJurnalRekening->create_time = $format->formatDateTimeForDB($model->tglfaktur);
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->ruangan_id = $model->create_ruangan;
        $modJurnalRekening->fakturpembelian_id = $model->fakturpembelian_id;

        if ($modJurnalRekening->validate()) {
            $modJurnalRekening->save();
            $this->successSave = true;
        } else {
            $this->successSave = false;
            $this->pesan = $modJurnalRekening->getErrors();
        }
        return $modJurnalRekening;
    }

    public function saveJurnalDetailUangMuka($modJurnalRekening, $modelRek, $nilai, $saldonormal, $nourut) {
        $valid = true;

        if (empty($modelRek)) {
            return true;
        }

        $modelJurnalDetail = new JurnaldetailT();
        $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
        $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
        $modelJurnalDetail->nourut = $nourut;
        if($saldonormal == 'K'){
            $modelJurnalDetail->saldokredit = $nilai;
            $modelJurnalDetail->saldodebit = 0;
        }else{
            $modelJurnalDetail->saldokredit = 0;
            $modelJurnalDetail->saldodebit = $nilai;
        }

        if ($modelJurnalDetail->validate()) {
            $modelJurnalDetail->save();
        } else {
//                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
            $valid = false;
        }

        return $valid;
    }
}
?>
