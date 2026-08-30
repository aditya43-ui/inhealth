<?php

class ProgramRujukBalikController extends MyAuthController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public function actionTambah()
    {

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['ajax'])) {
                $ajax = $_GET['ajax'];
                if ($ajax == 'daftar-pasien-sep-grid')
                    $path = 'grid/_daftar_pasien_sep';
                else if ($ajax == 'daftar-diagnosa-prb-grid')
                    $path = 'grid/_daftar_diagnosa_prb';
                else if ($ajax == 'daftar-dokter-dpjp-grid')
                    $path = 'grid/_daftar_dokter_dpjp';
                else if ($ajax == 'daftar-obat-prb-grid')
                    $path = 'grid/_daftar_obat_prb';

                $this->renderPartial($path, []);
                exit;
            }
        }

        $model = new ProgramrujukbalikpasienT;

        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->user_pembuat = $peg->namaLengkap ?? null;

        $modObat = new ObatprogramrujukbalikpasienT();

        $modPasienSep = new PPPencarianseprujukankeluarV();

        if (isset($_POST['ProgramrujukbalikpasienT'])) {
            $ok = true;
            $pesan = '';
            $trans = Yii::app()->db->beginTransaction();
            try {
                if ($ok) {
                    // echo "<pre>";
                    // var_dump($_POST);die;
                    $proses = ProgramrujukbalikpasienT::simpanData($model, $_POST['ProgramrujukbalikpasienT']);
                    $ok &= $proses['sukses'];
                    $model = $proses['model'];
                    $pesan .= $proses['pesan'];

                    foreach ($_POST['ObatprogramrujukbalikpasienT'] as $key => $val) {
                        $_POST['ObatprogramrujukbalikpasienT'][$key]['programrujukbalikpasien_id'] = $model->programrujukbalikpasien_id;
                    }


                    $proses = ObatprogramrujukbalikpasienT::simpanData($modObat, $_POST['ObatprogramrujukbalikpasienT'], true);
                    $ok &= $proses['sukses'];
                    $detail = $proses['model'];
                    $pesan .= $proses['pesan'];

                    $sep = PPPencarianseprujukankeluarV::model()->findByAttributes([
                        'sep_id' => $model->sep_id
                    ]);
                    $modDaftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);

                    $dpjp = PegawaiM::model()->findByPk($model->dpjp_id);

                    $detailobat = '';

                    foreach ($detail as $val) {
                        $detailobat .= '
                { 
                    "kdObat":"' . $val->obatprb_bpjskode . '",
                    "signa1":"' . $val->signa . '",
                    "signa2":"' . $val->signa_2 . '",
                    "jmlObat":"' . $val->qty_obat . '"
                },                
            ';
                    }
                    $modUser = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
                    $nama = $modUser->pegawai->nama_pegawai;
                    $arr = [
                        'noSep' => $sep->nosep,
                        'noKartu' => $sep->nokartuasuransi,
                        'alamat' => $sep->alamat_pasien,
                        'email' => $sep->alamatemail ?? "-",
                        'programPRB' => trim($model->programprb_kode),
                        'kodeDPJP' => $dpjp->kodedokter_bpjs,
                        'keterangan' => $model->keterangan,
                        'saran' => $model->saran,
                        'user' => $nama,//Yii::app()->user->getState('pegawai_id'),
                        'detailobat' => $detailobat
                    ];

                    // var_dump($arr, $detailobat); die;

                    $bpjs = new BpjsVklaim;
                    $response = CJSON::decode($bpjs->insert_prb($arr));
                    if ($response['metaData']['code'] != 200) {
                        $trans->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan"."BPJS Error" . $response['metaData']['message']);
                        $this->logBpjs($modDaftar, $response, $bpjs->server_new['insert_prb']);
                    }else{
                        if (!empty($response['metaData']['code'])) {
                            $model['respon_bridging'] = $response['metaData']['message'];
                            if (!empty($response['response']['noSRB'])) {
                                $res = $response['response'];
                                $model->nosrb = $res['noSRB'];
                                $model->tglsrb = $res['tglSRB'];
                            }
                            $model->alamatemail = !empty($sep->alamatemail) ? $sep->alamatemail : $_POST['PPPencarianseprujukankeluarV']['alamatemail'];
                            $model->save();
                        }
                        //update email to sep_t and pasien_m
                        $modSep = SepT::model()->findByPk($_POST['ProgramrujukbalikpasienT']['sep_id']);
                        if (!empty($modSep)) {
                            $modPendaftaran = PendaftaranT::model()->findByPk($_POST['ProgramrujukbalikpasienT']['pendaftaran_id']);
                            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                            $modPasien->alamatemail = $_POST['PPPencarianseprujukankeluarV']['alamatemail'];
                            $modPasien->update(['alamatemail']);
                        }
                        $this->logBpjs($modDaftar, $response, $bpjs->server_new['insert_prb']);
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $trans->commit();
                        $this->redirect(array('admin', 'id' => $model->programrujukbalikpasien_id));
                    }
                    
                    // $ok &= $this->insertPRB($model, $detail, $_POST['PPPencarianseprujukankeluarV']);
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan" . $pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }


        $this->render('tambah/index', array(
            'model' => $model,
            'modObat' => $modObat,
            'modPasienSep' => $modPasienSep,
        ));
    }


    public function actionUbah($id)
    {

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['ajax'])) {
                $ajax = $_GET['ajax'];
                if ($ajax == 'daftar-pasien-sep-grid')
                    $path = 'grid/_daftar_pasien_sep';
                else if ($ajax == 'daftar-diagnosa-prb-grid')
                    $path = 'grid/_daftar_diagnosa_prb';
                else if ($ajax == 'daftar-dokter-dpjp-grid')
                    $path = 'grid/_daftar_dokter_dpjp';
                else if ($ajax == 'daftar-obat-prb-grid')
                    $path = 'grid/_daftar_obat_prb';

                $this->renderPartial($path, []);
                exit;
            }
        }

        $model = ProgramrujukbalikpasienT::model()->findByPk($id);
        $model->tglbuat_prb = date('d/m/Y H:i:s', strtotime($model->tglbuat_prb));
        $model->diagnosabpjskode = $model->programprb_kode . " - " . $model->programprb_nama;

        $dpjp = PegawaiM::model()->findByPk($model->dpjp_id);
        if (!empty($dpjp)) {
            $model->dpjp_nama = $dpjp->namaLengkap;
        }


        // var_dump($model->attributes); die;

        // $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        // $model->user_pembuat = $peg->pegawai_id;

        $modObat = new ObatprogramrujukbalikpasienT();

        $modPasienSep = PPPencarianseprujukankeluarV::model()->findByAttributes(array(
            'sep_id' => $model->sep_id
        ));

        if (isset($_POST['ProgramrujukbalikpasienT'])) {
            $ok = true;
            $pesan = '';
            $trans = Yii::app()->db->beginTransaction();
            try {
                if ($ok) {


                    $proses = ProgramrujukbalikpasienT::simpanData($model, $_POST['ProgramrujukbalikpasienT']);
                    $ok &= $proses['sukses'];
                    $model = $proses['model'];
                    $pesan .= $proses['pesan'];

                    foreach ($_POST['ObatprogramrujukbalikpasienT'] as $key => $val) {
                        $_POST['ObatprogramrujukbalikpasienT'][$key]['obatprogramrujukbalikpasien_id'] = null;
                        $_POST['ObatprogramrujukbalikpasienT'][$key]['programrujukbalikpasien_id'] = $model->programrujukbalikpasien_id;
                    }


                    ObatprogramrujukbalikpasienT::model()->deleteAllByAttributes(array(
                        'programrujukbalikpasien_id' => $model->programrujukbalikpasien_id
                    ));
                    $proses = ObatprogramrujukbalikpasienT::simpanData($modObat, $_POST['ObatprogramrujukbalikpasienT'], true);
                    $ok &= $proses['sukses'];
                    $detail = $proses['model'];
                    $pesan .= $proses['pesan'];

                    $ok &= $this->updatePRB($model, $detail);

                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil diubah.');
                    $trans->commit();
                    $this->redirect(array('admin', 'id' => $model->programrujukbalikpasien_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan" . $pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }


        $this->render('tambah/index', array(
            'model' => $model,
            'modObat' => $modObat,
            'modPasienSep' => $modPasienSep,
        ));
    }

    public function actionAutoCompleteCariSep()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $model = new PPPencarianseprujukankeluarV();
            $model->nosep = $_GET['term'];

            $load = $model->searchPasienSep();

            foreach ($load->data as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }

                $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
                $returnVal[$i]['dpjp_id'] = $pendaftaran->pegawai_id;
                $returnVal[$i]['dpjp_nama'] = $pendaftaran->pegawai->namaLengkap;
                $returnVal[$i]['dpjp_kode'] = $pendaftaran->pegawai->kodedokter_bpjs;

                $sep = SepT::model()->findByPk($model->sep_id);

                if (!empty($sep)) {
                    $returnVal[$i]['programprb_kode'] = $sep->programprb_kode;
                    $returnVal[$i]['programprb_nama'] = $sep->programprb_nama;
                    $returnVal[$i]['diagnosabpjskode'] = "";
                    if (!empty($sep->programprb_kode)) {
                        $returnVal[$i]['diagnosabpjskode'] = $sep->programprb_kode . " - " . $sep->programprb_nama;
                    }
                }

                $returnVal[$i]['label'] = $model->nosep;
                $returnVal[$i]['value'] = $model->sep_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionAutoCompleteDiagnosaPRB()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $model = new ARCustomModel();
            $model->nama = $_GET['term'];

            $load = $model->tabelDiagnosaPrb();

            foreach ($load->data as $i => $model) {
                $attributes = $model;
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$j"] = $attribute;
                }
                $returnVal[$i]['label'] = $model['kode'] . ' - ' . $model['nama'];
                $returnVal[$i]['value'] = $model['nama'];
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionAutoCompleteObatPRB()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $model = new ARCustomModel();
            $model->nama = $_GET['term'];

            $load = $model->tabelObatPrb();

            foreach ($load->data as $i => $model) {
                $attributes = $model;
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$j"] = $attribute;
                }
                $returnVal[$i]['label'] = $model['kode'] . ' - ' . $model['nama'];
                $returnVal[$i]['value'] = $model['nama'];
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionAutoCompleteSigna()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $cri = new CDbCriteria;
            $cri->addCondition(" lookup_type = '" . Params::LOOKUPTYPE_SIGNA_OA . "' AND lookup_aktif = true ");
            $cri->compare("LOWER(lookup_value)", strtolower($_GET['term']), true);
            $cri->order = " lookup_urutan ASC ";
            $cri->limit = 10;
            $load = LookupM::model()->findAll($cri);

            $returnVal = [];
            foreach ($load as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->lookup_value;
                $returnVal[$i]['value'] = $model->lookup_value;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionTambahObat()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $sukses = 0;

            parse_str($_POST['formdata'], $arr);

            $post = $arr['ObatprogramrujukbalikpasienT'];

            $model = new ObatprogramrujukbalikpasienT();
            $model->attributes = $post;
            $model->obatbpjsprb = $post['obatbpjsprb'];
            if (!empty($model->carapenggunaanobat)) {
                $model->carapenggunaanobat = implode(' ', $model->carapenggunaanobat);
            }

            $cariobat = Yii::app()->db->createCommand(" SELECT obatalkes_id, obatalkes_nama FROM obatalkes_m WHERE kodeobatbpjs_prb = '" . $model->obatprb_bpjskode . "' ")->queryRow();

            if (!empty($cariobat['obatalkes_id'])) {
                $sukses = 1;
                $model->obatalkes_id = $cariobat['obatalkes_id'];
                $model->obatalkes_nama = $cariobat['obatalkes_nama'];
            }

            $row = $this->renderPartial('tambah/form/row/_3_detail_obat', ['model' => $model, 'i' => 0], true);

            echo json_encode([
                'row' => $row,
                'sukses' => $sukses
            ]);
            Yii::app()->end();
        }
    }

    public function insertPRB($model, $detail, $post)
    {
        $sep = PPPencarianseprujukankeluarV::model()->findByAttributes([
            'sep_id' => $model->sep_id
        ]);

        $dpjp = PegawaiM::model()->findByPk($model->dpjp_id);

        $detailobat = '';

        foreach ($detail as $val) {
            $detailobat .= '
                { 
                    "kdObat":"' . $val->obatprb_bpjskode . '",
                    "signa1":"' . $val->signa . '",
                    "signa2":"' . $val->signa_2 . '",
                    "jmlObat":"' . $val->qty_obat . '"
                },                
            ';
        }

        $arr = [
            'noSep' => $sep->nosep,
            'noKartu' => $sep->nokartuasuransi,
            'alamat' => $sep->alamat_pasien,
            'email' => $sep->alamatemail ?? "-",
            'programPRB' => trim($model->programprb_kode),
            'kodeDPJP' => $dpjp->kodedokter_bpjs,
            'keterangan' => $model->keterangan,
            'saran' => $model->saran,
            'user' => Yii::app()->user->getState('pegawai_id'),
            'detailobat' => $detailobat
        ];

        // var_dump($arr, $detailobat); die;

        $bpjs = new BpjsVklaim;
        $response = CJSON::decode($bpjs->insert_prb($arr));

        /*
        $response = array(
            'metaData' => array(
                'code' => '200',
                'message' => 'OK',
            ),
            'response' => array(
                'noSRB' => '1234567890',
                'tglSRB' => '2022-11-05',
            )
        );
        // */
        if ($response['metaData']['code'] != 200) {
            Yii::app()->user->setFlash('error', "BPJS Error" . $response['metaData']['message']);
        }
        if (!empty($response['metaData']['code'])) {
            $model['respon_bridging'] = $response['metaData']['message'];
            if (!empty($response['response']['noSRB'])) {
                $res = $response['response'];
                $model->nosrb = $res['noSRB'];
                $model->tglsrb = $res['tglSRB'];
            }
            $model->alamatemail = !empty($sep->alamatemail) ? $sep->alamatemail : $post['alamatemail'];
            return $model->save();
        }

        return true;
    }



    public function updatePRB($model, $detail)
    {
        $sep = PPPencarianseprujukankeluarV::model()->findByAttributes([
            'sep_id' => $model->sep_id
        ]);
        $dpjp = PegawaiM::model()->findByPk($model->dpjp_id);

        $detailobat = '';

        foreach ($detail as $val) {
            $detailobat .= '
                { 
                    "kdObat":"' . $val->obatprb_bpjskode . '",
                    "signa1":"' . $val->signa . '",
                    "signa2":"' . $val->signa_2 . '",
                    "jmlObat":"' . $val->qty_obat . '"
                },                
            ';
        }

        $modUser = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
        $nama = $modUser->pegawai->nama_pegawai;
        $arr = [
            'noSrb' => $model->nosrb,
            'noSep' => $sep->nosep,
            'alamat' => $sep->alamat_pasien,
            'email' => $sep->alamatemail ?? "-",
            'kodeDPJP' => $dpjp->kodedokter_bpjs,
            'keterangan' => $model->keterangan,
            'saran' => $model->saran,
            'user' => $nama,//Yii::app()->user->getState('pegawai_id'),
            'detailobat' => $detailobat
        ];

        // var_dump($arr, $detailobat, $model->attributes); die;

        $bpjs = new BpjsVklaim;
        $response = CJSON::decode($bpjs->update_prb($arr));
        $modDaftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);

        if (!empty($response['metaData']['code'])) {
            $this->logBpjs($modDaftar, $response, $bpjs->server_new['update_prb']);
            $model['respon_bridging'] = $response['metaData']['message'];

            return $model->update();
        }

        return true;
    }

    public function actionAdmin()
    {
        $model = new InfopasienprogramrujukbalikV;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $format = new MyFormatter();

        if (isset($_GET['InfopasienprogramrujukbalikV'])) {
            $model->attributes = $_GET['InfopasienprogramrujukbalikV'];

            $model->tgl_awal = isset($_GET['InfopasienprogramrujukbalikV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['InfopasienprogramrujukbalikV']['tgl_awal']) : null;
            $model->tgl_akhir = isset($_GET['InfopasienprogramrujukbalikV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['InfopasienprogramrujukbalikV']['tgl_akhir']) : null;
        }

        $this->render('admin', [
            'model' => $model
        ]);
    }

    public function actionPrint()
    {
        $model = new InfopasienprogramrujukbalikV;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $format = new MyFormatter();

        if (isset($_GET['InfopasienprogramrujukbalikV'])) {
            $model->attributes = $_GET['InfopasienprogramrujukbalikV'];

            $model->tgl_awal = isset($_GET['InfopasienprogramrujukbalikV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['InfopasienprogramrujukbalikV']['tgl_awal']) : null;
            $model->tgl_akhir = isset($_GET['InfopasienprogramrujukbalikV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['InfopasienprogramrujukbalikV']['tgl_akhir']) : null;
        }


        $judulLaporan = 'Data Program Rujuk Balik';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            // $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 20, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }

    public function actionPrintPRBBPJS($id)
    {

        $model = InfopasienprogramrujukbalikV::model()->findByAttributes([
            'programrujukbalikpasien_id' => $id
        ]);

        $modObat = ObatprogramrujukbalikpasienT::model()->findAll(" programrujukbalikpasien_id = " . $id);

        $this->layout = '//layouts/printWindows';
        $this->render('printBpjs', array(
            'model' => $model,
            'modObat' => $modObat,
            'judulLaporan' => "SURAT RUJUK BALIK (PRB)",
            'caraPrint' => 'PRINT'
        ));
    }

    public function actionDetail($id)
    {
        $model = InfopasienprogramrujukbalikV::model()->findByAttributes([
            'programrujukbalikpasien_id' => $id
        ]);

        $modObat = ObatprogramrujukbalikpasienT::model()->findAll(" programrujukbalikpasien_id = " . $id);

        $this->render('detail/index', [
            'model' => $model,
            'modObat' => $modObat
        ]);
    }

    public function actionPrintDetail($id)
    {
        $model = InfopasienprogramrujukbalikV::model()->findByAttributes([
            'programrujukbalikpasien_id' => $id
        ]);

        $modObat = ObatprogramrujukbalikpasienT::model()->findAll(" programrujukbalikpasien_id = " . $id);

        $judulLaporan = 'SURAT PROGRAM RUJUK BALIK';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('detail/print', array(
                'model' => $model,
                'judulLaporan' => $judulLaporan,
                'caraPrint' => $caraPrint,
                'modObat' => $modObat
            ));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 20, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('detail/print', array(
                'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint,
                'modObat' => $modObat
            ), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }

    public function actionHapus()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $id = $_POST['id'];
        $ok = 1;
        $msg = "Data berhasil di-hapus";
        $trans = Yii::app()->db->beginTransaction();

        try {

            $model = ProgramrujukbalikpasienT::model()->findByPk($id);
            $sep = PPPencarianseprujukankeluarV::model()->findByAttributes([
                'sep_id' => $model->sep_id
            ]);

            ObatprogramrujukbalikpasienT::model()->deleteAllByAttributes(array(
                'programrujukbalikpasien_id' => $id,
            ));

            $modUser = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
            $nama = $modUser->pegawai->nama_pegawai;
            $bpjs = new BpjsVklaim;
            $res = CJSON::decode($bpjs->delete_prb($model->nosrb, $sep->nosep, $nama));
            $modDaftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            if (!empty($res['metaData']['code']) && $res['metaData']['code'] != 200) {
                $msg = "Data berhasil di-hapus, namun ada error di BPJS : " . $res['metaData']['message'];
                $this->logBpjs($modDaftar, $res, $bpjs->server_new['insert_prb']);
            }else{
                $this->logBpjs($modDaftar, $res, $bpjs->server_new['insert_prb']);
            }

            ProgramrujukbalikpasienT::model()->deleteByPk($id);

            $trans->commit();
        } catch (Exception $e) {
            $trans->rollback();
            $msg = "Error : " . $e->getMessage();
            $ok = 0;
        }

        echo CJSON::encode(array(
            'ok' => $ok,
            'msg' => $msg,
        ));
    }

    //save log bpjs
    function logBpjs($model, $reqSep, $api = null)
    {
        $log = new BpjslogR;
        $log->tgl_log = date('Y-m-d H:i:s');
        $log->code = $reqSep['metaData']['code'];
        $log->loginpemakai_id = Yii::app()->user->id;
        if (isset($reqSep['metaData']['message'])) {
            $log->pesan = $reqSep['metaData']['message'];
        }
        if (!empty($reqSep['request_vars'])) {
            $log->json_request_respose = $reqSep['request_vars'];
        }
        $log->pendaftaran_id = $model->pendaftaran_id;
        $request = Yii::app()->request;
        $ipAddress = $request->getUserHostAddress();
        $log->ip_address = $ipAddress;
        $log->api = $api;
        $log->save();
    }
}
