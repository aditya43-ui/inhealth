<?php

class PengajuanKasbonController extends MyAuthController
{
    public $path_view = 'keuangan.views.pengajuanKasbon.';
    public $path_tips = 'sistemAdministrator.views.tips.';

    /**
     * Tambah Data dan Edit Pengajuan
     */
    public function actionIndex($id = null)
    {
        $model = new PengajuankasbonT();
        $model->no_pengajuan = '-- Otomatis --';
        $model->tgl_pengajuan = date("d M Y H:i:s");
        $model->status_persetujuan = Params::STATUS_PENGAJUAN_KASBON_PENGAJUAN;
        $model->status_validasi = Params::STATUS_VALIDASI_KASBON_BELUM_DIVERIFIKASI;
        $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
        // $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->status = 0;
        // if (!empty($modPegawai)) {
            // $model->pegawai_mengajukan_id = $modPegawai->pegawai_id;
            // $model->pegawai_mengajukan_nama = $modPegawai->namaLengkap;
            // $model->unitkerja_nama = $modPegawai->unitkerja->namaunitkerja;
            // $model->nip = $modPegawai->nomorindukpegawai;
            
        // }

        $modPegMenyetujui = PegawaiM::model()->findByPk(4);
        if (!empty($modPegMenyetujui)) {
            $model->pegawai_menyetujui2_id = $modPegMenyetujui->pegawai_id;
            $model->pegawai_menyetujui2_nama = $modPegMenyetujui->namaLengkap;
        }

        // $modPengajuan = PengajuankasbonT::model()->findByAttributes([
        //                 'pegawai_mengajukan_id' => $modPegawai->pegawai_id,
        //                 'status_persetujuan' => Params::STATUS_PENGAJUAN_KASBON_DISETUJUI,
        //                 'status_validasi' => Params::STATUS_VALIDASI_KASBON_TERVERIFIKASI
        //                 ],['order'=>'pengajuankasbon_id DESC']);
        // if (empty($id)) {
        //     if (!empty($modPengajuan)) {
        //         $i = 1;
        //         $modLPJ = LpjT::model()->findByAttributes(['pengajuankasbon_id' => $modPengajuan['pengajuankasbon_id']]);
        //         if (!empty($modLPJ)) {
        //            $i = 0; // Jika ada, nilainya ganti 0
        //         } 
        //         $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        //         $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        //         $link = Yii::app()->createUrl($module."/".$controller.'/informasi', array(
        //             'PengajuankasbonT[tgl_awal]' => MyFormatter::formatDateTimeForUser($model->tgl_pengajuan),
        //             'PengajuankasbonT[tgl_akhir]' => MyFormatter::formatDateTimeForUser($model->tgl_pengajuan),
        //             'PengajuankasbonT[no_pengajuan]' => $modPengajuan->no_pengajuan,
        //           ));
        //         $model->status = $i;
        //         $model->url = $link;
        //     }
        // }

        if (!empty($id)) {
            $model = PengajuankasbonT::model()->findByPk($id);
            $model->tgl_pengajuan = MyFormatter::formatDateTimeForUser($model->tgl_pengajuan);

            $modPegawai = PegawaiM::model()->findByPk($model->pegawai_mengajukan_id);
            if (!empty($modPegawai)) {
                $model->pegawai_mengajukan_id = $modPegawai->pegawai_id;
                $model->pegawai_mengajukan_nama = $modPegawai->namaLengkap;
                $model->unitkerja_nama = (!empty($modPegawai->unitkerja)?$modPegawai->unitkerja->namaunitkerja:"");
                $model->nip = $modPegawai->nomorindukpegawai;
                $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
            }

            $model->pegawai_mengetahui_nama = $model->pegawaimengetahui->namaLengkap;
            $model->pegawai_menyetujui1_nama = $model->pegawaimenyetujui1->namaLengkap;
            $model->pegawai_menyetujui2_nama = $model->pegawaimenyetujui2->namaLengkap;
        }


        if (isset($_POST['PengajuankasbonT'])) {
            $ok = true;
            $pesan = '';
            $trans = Yii::app()->db->beginTransaction();
            try {
                $proses = PengajuankasbonT::simpan_data($model, $_POST['PengajuankasbonT']);
                $model = $proses['model'];
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];

                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('index', 'id' => $model->pengajuankasbon_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>" . $pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'index', [
            'model' => $model
        ]);
    }

    /**
     * Halaman Informasi 
     */
    public function actionInformasi()
    {
        $model = new PengajuankasbonT('searchInformasi');
        $model->unsetAttributes();  // clear any default values
        $format = new MyFormatter();
        $model->tgl_awal = date("Y-m-01");
        $model->tgl_akhir = date("Y-m-d");

        if (isset($_GET['PengajuankasbonT'])) {
            $model->attributes = $_GET['PengajuankasbonT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PengajuankasbonT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PengajuankasbonT']['tgl_akhir']);
        }

        $this->render($this->path_view . 'informasi/index', array(
            'model' => $model,
            'format' => $format,
        ));
    }

    /**
     * Hapus Pengajuan Kasbon
     */
    public function actionBatalKasbon($id = null)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if ($id == null) {
                $id = isset($_POST['id']) ? $_POST['id'] : null;
            }
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {

                $ok = PengajuankasbonT::model()->deleteByPk($id);

                if ($ok) {
                    $trans->commit();
                    $data['sukses'] = 1;
                } else {
                    $trans->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = '';
                }
            } catch (Exception $ex) {
                $trans->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = $ex->getMessage();
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionVerifikasi($id = null, $jenis = null)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if ($id == null) {
                $id = isset($_POST['id']) ? $_POST['id'] : null;
            }
            if ($jenis == null) {
                $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            }
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model = PengajuankasbonT::model()->findByPk($id);
                $model[$jenis] = date("Y-m-d H:i:s");
                $model->status_persetujuan = Params::STATUS_PENGAJUAN_KASBON_PERSETUJUAN;
                if ($jenis == "tgl_pegawai_mengetahui") {
                    $model->status_persetujuan = Params::STATUS_PENGAJUAN_KASBON_DISETUJUI;
                }
                $ok &= $model->update();

                if ($ok) {
                    $trans->commit();
                    $data['sukses'] = 1;
                } else {
                    $trans->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = '';
                }
            } catch (Exception $ex) {
                $trans->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = $ex->getMessage();
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionPrint($id)
    {
        $model = PengajuankasbonT::model()->findByPk($id);
        $namaFile = $model->no_pengajuan; 

        $ukuranKertas = Params::getUkuranKertas();                  //Ukuran Kertas Pdf
        //$ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
        $posisi = Params::DEFAULT_KERTAS_POSISI_LANDSCAPE;                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertas['A5']);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial(
                $this->path_view . 'informasi/printRincian',
                array(
                    'model' => $model, 
                ),
                true
            )
        );
        $mpdf->Output($namaFile . '.pdf', 'I');
    }

    /**
     * Cetak Data Informasi 
     */
    public function actionPrintInfo() {
        $model = new PengajuankasbonT;

        if (isset($_GET['PengajuankasbonT'])) {
            $model->attributes = $_GET['PengajuankasbonT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PengajuankasbonT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PengajuankasbonT']['tgl_akhir']);
        }

        $judulLaporan = 'Data Pengajuan Kasbon';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'informasi/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'informasi/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 20, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'informasi/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }

    /**
     * Pembuatan LPJ oleh unit kasir 
     */
    public function actionBuatlpj($id = null)
    {
        $modLPJ = new LpjT(); 
        $model = PengajuankasbonT::model()->findByPk($id);
        $model->tgl_pengajuan = MyFormatter::formatDateTimeForUser($model->tgl_pengajuan);
        $model->nominal_kasbon = MyFormatter::formatNumberForPrint($model->nominal_kasbon);
        $modPegawai = PegawaiM::model()->findByPk($model->pegawai_mengajukan_id);
        if (!empty($modPegawai)) {
            $model->pegawai_mengajukan_id = $modPegawai->pegawai_id;
            $model->pegawai_mengajukan_nama = $modPegawai->namaLengkap;
            $model->unitkerja_nama = empty($modPegawai->unitkerja) ? "-" : $modPegawai->unitkerja->namaunitkerja;
            $model->nip = $modPegawai->nomorindukpegawai;
            $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
        }

        $model->pegawai_mengetahui_nama = $model->pegawaimengetahui->namaLengkap;
        $model->pegawai_menyetujui1_nama = $model->pegawaimenyetujui1->namaLengkap;
        $model->pegawai_menyetujui2_nama = $model->pegawaimenyetujui2->namaLengkap;

        if (isset($_POST['PengajuankasbonT'])) {
            $ok = true;
            $pesan = '';
            $trans = Yii::app()->db->beginTransaction();
            try {
                $proses = PengajuankasbonT::simpan_data($model, $_POST['PengajuankasbonT'], $is_lpj = true);
                $model = $proses['model'];
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];

                $proses2 = LpjT::simpan_data($model, $_POST['LpjT']);
                $modPengajuan = $proses2['model'];
                $ok &= $proses2['sukses'];
                $pesan .= $proses2['pesan'];
                if ($ok) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('buatLpj', 'id' => $model->pengajuankasbon_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>" . $pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'lpj/index', [
            'model' => $model,
            'modLPJ' => $modLPJ
        ]);
    }

    public function actionPrintLpj($id)
    {
        $model = PengajuankasbonT::model()->findByPk($id);
        $namaFile = $model->no_pengajuan; 
        $modLPJ = LpjT::model()->findAllByAttributes(['pengajuankasbon_id' => $model->pengajuankasbon_id]);

        $ukuranKertas = Params::getUkuranKertas();                  //Ukuran Kertas Pdf
        //$ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
        $posisi = Params::DEFAULT_KERTAS_POSISI_LANDSCAPE;                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertas['A5']);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial(
                $this->path_view . 'informasi/print_lpj',
                array(
                    'model' => $model, 
                    'modLPJ' => $modLPJ,
                ),
                true
            )
        );
        $mpdf->Output($namaFile . '.pdf', 'I');
    }

    public function actionVerifikasiKasir($id = null, $jenis = null)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if ($id == null) {
                $id = isset($_POST['id']) ? $_POST['id'] : null;
            }
            if ($jenis == null) {
                $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            }
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model = PengajuankasbonT::model()->findByPk($id);
                $model->status_validasi = Params::STATUS_VALIDASI_KASBON_TERVERIFIKASI;
                $ok &= $model->update();

                if ($ok) {
                    $trans->commit();
                    $data['sukses'] = 1;
                } else {
                    $trans->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = '';
                }
            } catch (Exception $ex) {
                $trans->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = $ex->getMessage();
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionPengeluaranKas($id = null) {
        // var_dump(Yii::app()->user->getState('ruangan_id')); die;

        $this->pageTitle = Yii::app()->name . " - Pengeluaran Kas (Kasbon)";

        $model = PengajuankasbonT::model()->findByPk($id);


        if (!empty($model)) {

            $model->tgl_pengajuan = MyFormatter::formatDateTimeForUser($model->tgl_pengajuan);
            $model->nominal_kasbon = MyFormatter::formatNumberForPrint($model->nominal_kasbon);
            $modPegawai = PegawaiM::model()->findByPk($model->pegawai_mengajukan_id);
            if (!empty($modPegawai)) {
                $model->pegawai_mengajukan_id = $modPegawai->pegawai_id;
                $model->pegawai_mengajukan_nama = $modPegawai->namaLengkap;
                $model->unitkerja_nama = empty($modPegawai->unitkerja) ? "-" : $modPegawai->unitkerja->namaunitkerja;
                $model->nip = $modPegawai->nomorindukpegawai;
                $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
            }

            $model->pegawai_mengetahui_nama = $model->pegawaimengetahui->namaLengkap;
            $model->pegawai_menyetujui1_nama = $model->pegawaimenyetujui1->namaLengkap;
            $model->pegawai_menyetujui2_nama = $model->pegawaimenyetujui2->namaLengkap;
        } else {
            $model = new PengajuankasbonT;
        } 

        


        $modPengUmum = new KUPengeluaranumumT;
        $modPengUmum->volume = 1;
        $modPengUmum->hargasatuan = $model->nominal_kasbon;
        $modPengUmum->totalharga = $model->nominal_kasbon;
        $modPengUmum->persenppn = 0;
        $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
        $modUraian[0] = new KUUraiankeluarumumT;
        $modUraian[0]->uraiantransaksi = strip_tags($model->keperluan);
        $modUraian[0]->volume = 1;
        $modUraian[0]->hargasatuan = $model->nominal_kasbon;
        $modUraian[0]->totalharga = $model->nominal_kasbon;
        $modBuktiKeluar = new KUTandabuktikeluarT;
        $modBuktiKeluar->tahun = date('Y');
        $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
        $modBuktiKeluar->biayaadministrasi = 0;
        $modBuktiKeluar->jmlkaskeluar = 0;

        $modJurnalRekening = new KUJurnalrekeningT;
        $modJurnalDetail = new KUJurnaldetailT;
        $modJurnalPosting = new KUJurnalpostingT;
        
        $modPengUmum->pegawaimengetahui_id = $model->pegawai_mengetahui_id;
        $modPengUmum->keterangankeluar = strip_tags($model->keperluan);
        $modPengUmum->satuanvol = "Kali";
        $modPengUmum->kelompoktransaksi = "KAS";
        $modPengUmum->jenispengeluaran_id = Params::JENISPENGELUARAN_ID_KASBON;
        $modPengUmum->jenisKodeNama = $modPengUmum->jenispengeluaran->jenispengeluaran_nama;

        // var_dump($model->attributes, $modPengUmum->attributes); die;

        if (isset($_POST['KUPengeluaranumumT'])) { die;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $modBuktiKeluar = $this->saveTandaBuktiKeluar($_POST['KUTandabuktikeluarT']);

            $modPengUmum = $this->savePengeluaranUmum($_POST['KUPengeluaranumumT'], $modBuktiKeluar);
            $this->updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum);

            if ($modPengUmum->isurainkeluarumum && isset($_POST['KUUraiankeluarumumT'])) {
            $modUraian = $this->saveUraian($_POST['KUUraiankeluarumumT'], $modPengUmum);
            }

            if ($this->succesSave) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Nomor Pengeluaran berhasil disimpan");
            } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
        } catch (Exception $exc) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
        }

        if(empty($linkHalaman)) $linkHalaman = $this->createUrl('informasi');

        $this->render($this->path_view . 'pengeluaran/index', array(
            'modPengUmum' => $modPengUmum,
            'modUraian' => $modUraian,
            'modBuktiKeluar' => $modBuktiKeluar,
            'modJurnalRekening' => $modJurnalRekening,
            'modJurnalDetail' => $modJurnalDetail,
            'modJurnalPosting' => $modJurnalPosting,
            'linkHalaman' => $linkHalaman,
            'model' => $model,
        ));
    }

    public function actionGetDataRekeningByJnsPengeluaran() {

        Yii::import("keuangan.controllers.PengeluaranUmumController");

        $con = new PengeluaranUmumController('PengajuanKasbon', Yii::app()->getModule('keuangan'));
        $con->actionGetDataRekeningByJnsPengeluaran();
    }

    public function actionSimpanPengeluaran()
    {
        if (Yii::app()->request->isAjaxRequest) {
        parse_str($_REQUEST['data'], $data_parsing);
        $modJurnalPosting = null;
        $format = new MyFormatter();

        if (isset($data_parsing['KUPengeluaranumumT'])) {

            Yii::import("keuangan.controllers.PengeluaranUmumController");

            $model = PengajuankasbonT::model()->findByPk($data_parsing['PengajuankasbonT']['pengajuankasbon_id']);

            $con = new PengeluaranUmumController('PengajuanKasbon', Yii::app()->getModule('keuangan'));

            // var_dump($data_parsing); die;
            $transaction = Yii::app()->db->beginTransaction();
            try {
            $modBuktiKeluar = $con->saveTandaBuktiKeluar($data_parsing['KUTandabuktikeluarT']);
            $data_parsing['KUPengeluaranumumT']['tglpengeluaran'] = $format->formatDateTimeForDb($data_parsing['KUPengeluaranumumT']['tglpengeluaran']);
            $modPengUmum = $con->savePengeluaranUmum($data_parsing['KUPengeluaranumumT'], $modBuktiKeluar);
            if (isset($data_parsing['KUPengeluaranumumT']['isurainkeluarumum'])) {
                $modUraian = $con->saveUraian($data_parsing['KUUraiankeluarumumT'], $modPengUmum);
            }
            // var_dump($modPengUmum->errors); die;
            $modPengUmum->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
            $modPengUmum->update();
            $modBuktiKeluar->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
            $modBuktiKeluar->update();
            $model->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
            $model->save(false);



            //var_dump($modPengUmum->attributes);
            //var_dump($modBuktiKeluar->attributes); die;

            $modJurnalRekening = $con->saveJurnalRekening($modPengUmum, $data_parsing['KUPengeluaranumumT']);
            $params = array(
                'modJurnalRekening' => $modJurnalRekening,
                'jenis_simpan' => $_REQUEST['jenis_simpan'],
                'RekeningakuntansiV' => $data_parsing['RekeningakuntansiV'] ?? array()
            );
            //                        $insertDetailJurnal = $this->insertDetailJurnal($params);
            //                        $this->succesSave = $insertDetailJurnal;

            $modJurnalDetail = $con->saveJurnalDetail(
                $data_parsing['KUPengeluaranumumT'],
                $modJurnalRekening,
                null,
                $data_parsing['RekeningakuntansiV'] ?? array()
            );

            /* dibuka comment karena RND-8514 */
            if ($_REQUEST['jenis_simpan'] == 'posting') {
                $res = Yii::app()->db
                ->createCommand("select ins_jurnalpostingotomatisbilling_fix_jurnal(" . $modJurnalRekening->jurnalrekening_id . ") as simpan")
                ->queryRow();

                if (!empty($res)) {
                $con->succesSave = $con->succesSave && $res['simpan'];
                }
            }


            $con->notifPengeluaranKas($modPengUmum, $modBuktiKeluar);
            // var_dump($con->succesSave); die;
            if ($con->succesSave) {
                $transaction->commit();
                // Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                $con->pesan = array(
                'nopengeluaran' => MyGenerator::noPengeluaranUmum(),
                'nokaskeluar' => MyGenerator::noKasKeluar()
                );
            } else {
                $transaction->rollback();
                // Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
            } catch (Exception $exc) {
            print_r($exc);
            $con->pesan = $exc;
            $con->succesSave = false;
            $transaction->rollback();
            }
        }
        $result = array(
            'action' => $con->is_action,
            'id' => empty($modPengUmum) ? "" : $modPengUmum->pengeluaranumum_id,
            'pesan' => $con->pesan,
            'status' => ($con->succesSave == true ? 'ok' : 'not'),
        );
        echo json_encode($result);
        Yii::app()->end();
        }
    }


    public function actionRealisasi($id = null)
    {
        $this->pageTitle = Yii::app()->name . " - Penerimaan Kas (Kasbon)";

        $model = PengajuankasbonT::model()->findByPk($id);


        if (!empty($model)) {

            $model->tgl_pengajuan = MyFormatter::formatDateTimeForUser($model->tgl_pengajuan);
            $model->nominal_kasbon = MyFormatter::formatNumberForPrint($model->nominal_kasbon);
            $modPegawai = PegawaiM::model()->findByPk($model->pegawai_mengajukan_id);
            if (!empty($modPegawai)) {
                $model->pegawai_mengajukan_id = $modPegawai->pegawai_id;
                $model->pegawai_mengajukan_nama = $modPegawai->namaLengkap;
                $model->unitkerja_nama = empty($modPegawai->unitkerja) ? "-" : $modPegawai->unitkerja->namaunitkerja;
                $model->nip = $modPegawai->nomorindukpegawai;
                $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
            }

            $model->pegawai_mengetahui_nama = $model->pegawaimengetahui->namaLengkap;
            $model->pegawai_menyetujui1_nama = $model->pegawaimenyetujui1->namaLengkap;
            $model->pegawai_menyetujui2_nama = $model->pegawaimenyetujui2->namaLengkap;
        } else {
            $model = new PengajuankasbonT;
        } 

        $modPenUmum = new KUPenerimaanUmumT;
        $modPenUmum->volume = 1;
        $modPenUmum->hargasatuan = $model->nominal_kasbon;
        $modPenUmum->totalharga = $model->nominal_kasbon;
        $modPenUmum->persenppn = 0;
        $modPenUmum->nomor = '-- Otomatis --';
        $modPenUmum->nopenerimaan = MyGenerator::noPenerimaanUmum();
        $modUraian[0] = new KUUraianpenumumT;
        $modUraian[0]->volume = 1;
        $modUraian[0]->hargasatuan = $model->nominal_kasbon;
        $modUraian[0]->totalharga = $model->nominal_kasbon;
        $modUraian[0]->uraiantransaksi = strip_tags($model->keperluan);

        $modTandaBukti = new KUTandabuktibayarT;
        $modTandaBukti->jmlpembulatan = 0;
        $modTandaBukti->biayaadministrasi = 0;
        $modTandaBukti->biayamaterai = 0;
        $modTandaBukti->jmlpembayaran = $modPenUmum->totalharga;
        $modTandaBukti->carapembayaran = Params::CARAPEMBAYARAN_TUNAI;
        $modJurnalRekening = array();
        $modJurnalDetail = array();
        $modJUrnalPosting = array();

        $modPenUmum->keterangan_penerimaan = strip_tags($model->keperluan);
        $modPenUmum->satuanvol = "Kali";
        $modPenUmum->kelompoktransaksi = "KAS";
        $modPenUmum->jenispenerimaan_id = Params::JENISPENERIMAAN_ID_KASBON;
        $modPenUmum->jenisKodeNama = $modPenUmum->jenispenerimaan->jenispenerimaan_nama;

        // var_dump($model->attributes, $modUraian[0]->attributes); die;

        // $modPengUmum->pegawaimengetahui_id = $model->pegawai_mengetahui_id;


        if (isset($_POST['KUPenerimaanUmumT'])) {

            var_dump($_POST); die;

        $transaction = Yii::app()->db->beginTransaction();
        try {

            $modTandaBukti = $this->saveTandaBukti($_POST['KUTandabuktibayarT']);
            $modPenUmum = $this->savePenerimaan($_POST['KUPenerimaanUmumT'], $modTandaBukti);

            if ($modPenUmum->isuraintransaksi && isset($_POST['KUUraianpenumumT'])) {
            $modUraian = $this->saveUraian($_POST['KUUraianpenumumT'], $modPenUmum);
            }

            if ($this->succesSave) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
        } catch (Exception $exc) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
        }

        $this->render(
        $this->path_view . 'realisasi/index',
        array(
            'modPenUmum' => $modPenUmum,
            'modUraian' => $modUraian,
            'modTandaBukti' => $modTandaBukti,
            'modJurnalRekening' => $modJurnalRekening,
            'modJurnalDetail' => $modJurnalDetail,
            'modJurnalPosting' => $modJUrnalPosting,
            'modUraian' => $modUraian,
            'model' => $model,
        )
        );
    }

    public function actionPrintPengeluaran($id)
    {
        $kasbon = PengajuankasbonT::model()->findByPk($id);

        $model = KUPengeluaranumumT::model()->findByPk($kasbon->pengeluaranumum_id);
        $modTandaBukti = KUTandabuktikeluarT::model()->findByPk($model->tandabuktikeluar_id);
        $modUraian = array(); //KUUraianpenumumT::model()->findAllByAttributes(array('penerimaanumum_id' => $model->penerimaanumum_id));

        $judulLaporan = '--- Detail Pengeluaran Kas ---';
        $caraPrint = "PDF";
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'pengeluaran/Print', array('kasbon'=>$kasbon, 'model' => $model, 'modTandaBukti'=>$modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'pengeluaran/Print', array('kasbon'=>$kasbon, 'model' => $model, 'modTandaBukti'=>$modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            //$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'pengeluaran/Print', array('kasbon'=>$kasbon, 'model' => $model, 'modTandaBukti'=>$modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

    public function actionSimpanPenerimaan()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $modPenUmum = new KUPenerimaanUmumT;
        $modTandaBukti = new KUTandabuktibayarT;
        $modJurnalPosting = null;
        parse_str($_REQUEST['data'], $data_parsing);
        $format = new MyFormatter();

        if (isset($data_parsing['KUPenerimaanUmumT'])) {

            $model = PengajuankasbonT::model()->findByPk($data_parsing['PengajuankasbonT']['pengajuankasbon_id']);

            Yii::import("keuangan.controllers.PenerimaanUmumController");
            $con = new PenerimaanUmumController('PengajuanKasbon', Yii::app()->getModule('keuangan'));

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modTandaBukti = $con->saveTandaBukti($data_parsing['KUTandabuktibayarT']);
                // var_dump($modTandaBukti->errors); die;
                $data_parsing['KUPenerimaanUmumT']['tglpenerimaan'] = $format->formatDateTimeForDb($data_parsing['KUPenerimaanUmumT']['tglpenerimaan']);

                $modPenUmum = $con->savePenerimaan($data_parsing['KUPenerimaanUmumT'], $modTandaBukti);
                $model->penerimaanumum_id = $modPenUmum->penerimaanumum_id;
                $model->save(false);

                if (isset($data_parsing['KUUraianpenumumT'])) {
                    $modUraian = $this->saveUraian($data_parsing['KUUraianpenumumT'], $modPenUmum, $model, $con);
                }

                $modJurnalRekening = $con->saveJurnalRekening($modPenUmum, $data_parsing['KUPenerimaanUmumT']);


                $modJurnalDetail = $con->saveJurnalDetail(
                    $data_parsing['KUPenerimaanUmumT'],
                    $modJurnalRekening,
                    null,
                    $data_parsing['RekeningakuntansiV'] ?? array()
                );

                if ($_REQUEST['jenis_simpan'] == 'posting') {
                    $res = Yii::app()->db
                    ->createCommand("select ins_jurnalpostingotomatisbilling_fix_jurnal(" . $modJurnalRekening->jurnalrekening_id . ") as simpan")
                    ->queryRow();

                    if (!empty($res)) {
                        $con->succesSave = $con->succesSave && $res['simpan'];
                    }
                    //$modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
                }

                $con->notifPenerimaanKas($modPenUmum, $modTandaBukti);

                // var_dump($con->succesSave); die;
                if ($con->succesSave) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $con->pesan = array(
                        'nopenerimaan' => MyGenerator::noPenerimaanUmum(),
                        'id' => $modPenUmum->penerimaanumum_id,
                    );
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                $con->pesan = $exc;
                $con->succesSave = false;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $result = array(
            'action' => $con->is_action,
            'pesan' => $con->pesan,
            'status' => ($con->succesSave == true ? 'ok' : 'not'),
        );

        echo json_encode($result);
        Yii::app()->end();
        }
    }

    protected function saveUraian($arrPostUraian, $modPenUmum, $model, $con)
    {
        $valid = false;
        $modUraian = array();

        LpjT::model()->deleteAllByAttributes(array(
            'pengajuankasbon_id'=>$model->pengajuankasbon_id
        ));

        for ($i = 0; $i < count((array)$arrPostUraian); $i++) {
            if (strlen($arrPostUraian[$i]['uraiantransaksi']) > 0) {
                $modUraian[$i] = new KUUraianpenumumT;
                $modUraian[$i]->attributes = $arrPostUraian[$i];
                $modUraian[$i]->penerimaanumum_id = $modPenUmum->penerimaanumum_id;
                if ($modUraian[$i]->validate()) {
                    $modUraian[$i]->save();
                    $valid = true;
                } else {
                    $this->pesan = $modUraian[$i]->getErrors();
                }

                $modLPJ = new LpjT();
                $modLPJ->pengajuankasbon_id = $model->pengajuankasbon_id;
                $modLPJ->keterangan_lpj = strip_tags($model->keperluan);
                $modLPJ->tgl_buat_lpj = date('Y-m-d H:i:s');
                $modLPJ->kategori_lpj = "Persetujuan";
                $modLPJ->jumlah = $modUraian[$i]->volume;
                $modLPJ->harga_satuan = $modUraian[$i]->hargasatuan;
                $modLPJ->sub_total = $modUraian[$i]->totalharga;
                $modLPJ->perincian_pembayaran_lpj = $modUraian[$i]->uraiantransaksi;

                $modLPJ->create_time = $modLPJ->update_time = date('Y-m-d H:i:s');
                $modLPJ->create_loginpemakai_id = $modLPJ->update_loginpemakai_id = Yii::app()->user->id;
                $modLPJ->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $modLPJ->save();

                // var_dump($modLPJ->attributes);

                // var_dump($modUraian[$i]->attributes);
            }
        }

        $con->succesSave = $valid;
        return $modUraian;
    }

    public function actionPrintPenerimaan($id)
    {
        $kasbon = PengajuankasbonT::model()->findByPk($id);

        $model = KUPenerimaanUmumT::model()->findByPk($kasbon->penerimaanumum_id);
        $modTandaBukti = KUTandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
        $modUraian = array(); //KUUraianpenumumT::model()->findAllByAttributes(array('penerimaanumum_id' => $model->penerimaanumum_id));
        // var_dump($model->attributes); die;
        $judulLaporan = '--- Detail Penerimaan Kas ---';
        $caraPrint = "PDF";
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'realisasi/Print', array('kasbon'=>$kasbon, 'model' => $model, 'modTandaBukti'=>$modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'realisasi/Print', array('kasbon'=>$kasbon, 'model' => $model, 'modTandaBukti'=>$modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            //$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'realisasi/Print', array('kasbon'=>$kasbon, 'model' => $model, 'modTandaBukti'=>$modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }
}
