<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SuratRujukanController extends MyAuthController
{

    public $deleterujukan = false;

    public function actionIndex($id = null)
    {
        $format = new MyFormatter();
        $model = new PasiendirujukkeluarT;
        $model->tgldirujuk = date('d/m/Y');
        $modInfoKunjungan = new PencarianseprujukankeluarV;
        $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
        if (isset($modLogin->user_pemakai_bpjs) && !empty($modLogin->user_pemakai_bpjs)) {
            $model->userinput_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->user_pemakai_bpjs;
        } else {
            $model->userinput_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->nama_pemakai;
        }
        $model->nosuratrujukan = "-Otomatis-";
        $model->jenisfaskes = 2;
        $model->tglbuat_rujukan = date('d/m/Y');

        if (!empty($id)) {
            $model = PasiendirujukkeluarT::model()->findByPk($id);
        //    $model->ppkrujukan = $model->ppkrujukan;
            $model->ppkrujukan = $model->kepadayth_kode;
            
            $model->ppkrujukan_nama = $model->kepadayth;
            $model->dirujukkebagian_nama = $model->dirujukkebagian;
            $model->dirujukkebagian = $model->dirujukkebagian_kode;
            $modInfoKunjungan = PencarianseprujukankeluarV::model()->findByAttributes(array('sep_id' => $model->sep_id));
        }

        if (isset($_POST['PasiendirujukkeluarT'])) {
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['PasiendirujukkeluarT'];
                $modPasien = PendaftaranT::model()->findByAttributes(array('sep_id' => $_POST['sep_id']));
                if (!empty($modPasien->pasienadmisi_id)) {
                    $ruangan_id = PasienadmisiT::model()->findByPk($modPasien->pasienadmisi_id)->ruangan_id;
                    $model->pasienadmisi_id = $modPasien->pasienadmisi_id;
                } else {
                    $ruangan_id = $modPasien->ruangan_id;
                }

                $model->pasien_id = $modPasien->pasien_id;
                $model->pegawai_id = $modPasien->pegawai_id;
                $model->pendaftaran_id = $modPasien->pendaftaran_id;
                $model->tgldirujuk = $format->formatDateTimeForDb($_POST['PasiendirujukkeluarT']['tgldirujuk']);
                $model->dirujukkebagian = (!empty($_POST['PasiendirujukkeluarT']['dirujukkebagian_nama']) ? $_POST['PasiendirujukkeluarT']['dirujukkebagian_nama'] : null);
                $model->dirujukkebagian_kode = (!empty($_POST['PasiendirujukkeluarT']['dirujukkebagian']) ? $_POST['PasiendirujukkeluarT']['dirujukkebagian'] : null);
                $model->alasandirujuk = $_POST['PasiendirujukkeluarT']['catatandokterperujuk'];
                $model->jenispelayanan_bpjs = $_POST['PasiendirujukkeluarT']['jenispelayanan_bpjs'];
                $model->tiperujukan_bpjs = $_POST['PasiendirujukkeluarT']['tiperujukan_bpjs'];
                $model->kepadayth_kode = $_POST['PasiendirujukkeluarT']['ppkrujukan'];
               // $model->ppkrujukan = $_POST['PasiendirujukkeluarT']['ppkrujukan'];
                
                $model->ruanganasal_id = $ruangan_id;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->tglberlakusurat = $model->catatandokterperujuk;
                $model->tglberlakusurat = $model->tgldirujuk;
                $model->tglrencanakunjungan_bpjs = $format->formatDateTimeForDb($_POST['PasiendirujukkeluarT']['tglrencanakunjungan_bpjs']);;
                $model->tglbuat_rujukan = MyFormatter::formatDateTimeForDb($model->tglbuat_rujukan);
                $model->kepadayth = $_POST['PasiendirujukkeluarT']['ppkrujukan_nama'];
                $model->sampaidengan = date("Y-m-d", strtotime("+1 month", strtotime($model->tgldirujuk)));
                $model->dokterpemeriksa = PegawaiM::model()->findByPk($model->pegawai_id)->nama_pegawai;
                $model->sep_id = $_POST['sep_id'];
                $modRujukan = RujukankeluarM::model()->findByAttributes(array('kodeppk_dirujuk' => $_POST['PasiendirujukkeluarT']['ppkrujukan']));
              
                // echo '<pre>';
                // var_dump($_POST); die;
                if(empty($modRujukan->kodeppk_dirujuk)){
                    $modRujukan->kodeppk_dirujuk =  $_POST['PasiendirujukkeluarT']['ppkrujukan'];
                    $modRujukan->update();
                }
                  if (empty($modRujukan)){
                    $modRujukan =  new RujukankeluarM();
                    $modRujukan->rumahsakitrujukan = $_POST['PasiendirujukkeluarT']['ppkrujukan_nama'];
                    $modRujukan->kodeppk_dirujuk =  $_POST['PasiendirujukkeluarT']['ppkrujukan'];
                    $modRujukan->rujukankeluar_aktif = True;
                
                    $modRujukan->save();
                  }
            
                  $model->rujukankeluar_id = $modRujukan->rujukankeluar_id;
                
                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data rujukan berhasil disimpan");
                        $this->redirect(array('index', 'id' => $model->pasiendirujukkeluar_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data rujukan gagal disimpan ! ");
                    }
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data rujukan gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array(
            'model' => $model,
            'modInfoKunjungan' => $modInfoKunjungan,
        ));
    }

    public function actionUpdate($id = null)
    {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $model = new PasiendirujukkeluarT;
        $modInfoKunjungan = new PencarianseprujukankeluarV;
        $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
        if (isset($modLogin->user_pemakai_bpjs) && !empty($modLogin->user_pemakai_bpjs)) {
            $model->userinput_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->user_pemakai_bpjs;
        } else {
            $model->userinput_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->nama_pemakai;
        }
        $model->nosuratrujukan = "-Otomatis-";
        $model->jenisfaskes = 2;

        if (!empty($id)) {
            $model = PasiendirujukkeluarT::model()->findByPk($id);
            $model->ppkrujukan = $model->kepadayth_kode;
            $model->ppkrujukan_nama = $model->kepadayth;
            $model->dirujukkebagian_nama = $model->dirujukkebagian;
            $model->dirujukkebagian = $model->dirujukkebagian_kode;
            $modInfoKunjungan = PencarianseprujukankeluarV::model()->findByAttributes(array('sep_id' => $model->sep_id));

            // get default poli tujuan kode dan nama
            $modSep = SepT::model()->findByPk($model->sep_id);
            $bpjs = new BpjsVklaim;

            $dataRujukan = json_decode($bpjs->search_rujukan_rs_no_bpjs($modSep->nokartuasuransi));
            if ($dataRujukan->metaData->code != 200) {
                $dataRujukan = json_decode($bpjs->search_rujukan_no_bpjs($modSep->nokartuasuransi));
            }
            $model->dirujukkebagian_nama = $model->dirujukkebagian; //$dataRujukan->response->rujukan->poliRujukan->nama;
            $model->dirujukkebagian = $model->dirujukkebagian_kode; //$dataRujukan->response->rujukan->poliRujukan->kode;
            if(empty($model->kodediagnosasementara_ruj)){
                $model->diagnosasementara_ruj = "";
            }
            
        }
        $transaction = Yii::app()->db->beginTransaction();
        if (isset($_POST['PasiendirujukkeluarT'])) {
            try {
                $model->attributes = $_POST['PasiendirujukkeluarT'];
                $modPasien = PendaftaranT::model()->findByAttributes(array('sep_id' => $_POST['sep_id']));
                if (!empty($modPasien->pasienadmisi_id)) {
                    $ruangan_id = PasienadmisiT::model()->findByPk($modPasien->pasienadmisi_id)->ruangan_id;
                    $model->pasienadmisi_id = $modPasien->pasienadmisi_id;
                } else {
                    $ruangan_id = $modPasien->ruangan_id;
                }

                $model->pasien_id = $modPasien->pasien_id;
                $model->pegawai_id = $modPasien->pegawai_id;
                $model->pendaftaran_id = $modPasien->pendaftaran_id;
                $model->tgldirujuk = $format->formatDateTimeForDb($_POST['PasiendirujukkeluarT']['tgldirujuk']);
                $model->tglrencanakunjungan_bpjs = $format->formatDateTimeForDb($_POST['PasiendirujukkeluarT']['tglrencanakunjungan_bpjs']);
                $model->dirujukkebagian = $_POST['PasiendirujukkeluarT']['dirujukkebagian_nama'];
                $model->dirujukkebagian_kode = $_POST['PasiendirujukkeluarT']['dirujukkebagian'];
                $model->alasandirujuk = $_POST['PasiendirujukkeluarT']['catatandokterperujuk'];
                $model->jenispelayanan_bpjs = $_POST['PasiendirujukkeluarT']['jenispelayanan_bpjs'];
                $model->tiperujukan_bpjs = $_POST['PasiendirujukkeluarT']['tiperujukan_bpjs'];
                $model->kepadayth_kode = $_POST['PasiendirujukkeluarT']['ppkrujukan'];
                $model->ruanganasal_id = $ruangan_id;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->tglberlakusurat = $model->catatandokterperujuk;
                $model->tglberlakusurat = $model->tgldirujuk;
                $model->kepadayth = $_POST['PasiendirujukkeluarT']['ppkrujukan_nama'];
                $model->sampaidengan = date("Y-m-d", strtotime("+1 month", strtotime($model->tgldirujuk)));
                $model->dokterpemeriksa = PegawaiM::model()->findByPk($model->pegawai_id)->nama_pegawai;
                $model->sep_id = $_POST['sep_id'];
                $modRujukan = RujukankeluarM::model()->findByAttributes(array('kodeppk_dirujuk' => $_POST['PasiendirujukkeluarT']['ppkrujukan']));

                if (isset($modRujukan->rujukankeluar_id)) {
                    $model->rujukankeluar_id = $modRujukan->rujukankeluar_id;
                } else {
                    Yii::app()->user->setFlash('error', "Ppk Rujukan belum terdaftar di database ! ");
                }

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data rujukan berhasil disimpan");
                        $this->redirect(array('update', 'id' => $model->pasiendirujukkeluar_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data rujukan gagal disimpan ! ");
                    }
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data rujukan gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'modInfoKunjungan' => $modInfoKunjungan,
        ));
    }

    public function actionAdmin()
    {
        $format = new MyFormatter();
        $model = new ARInformasirujukankeluarbpjsV;
        $model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        if (isset($_GET['ARInformasirujukankeluarbpjsV'])) {
            $model->attributes = $_GET['ARInformasirujukankeluarbpjsV'];
            $model->nosuratrujukan = $_GET['ARInformasirujukankeluarbpjsV']['nosuratrujukan'];
            $model->nosep = $_GET['ARInformasirujukankeluarbpjsV']['nosep'];
            $model->nokartuasuransi = $_GET['ARInformasirujukankeluarbpjsV']['nokartuasuransi'];
            $model->no_rekam_medik = $_GET['ARInformasirujukankeluarbpjsV']['no_rekam_medik'];
            $model->nama_pasien = $_GET['ARInformasirujukankeluarbpjsV']['nama_pasien'];
            $model->tgl_awal = isset($_GET['ARInformasirujukankeluarbpjsV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['ARInformasirujukankeluarbpjsV']['tgl_awal']) : null;
            $model->tgl_akhir = isset($_GET['ARInformasirujukankeluarbpjsV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['ARInformasirujukankeluarbpjsV']['tgl_akhir']) : null;
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionGetDataInfoSEP()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nosep = isset($_GET['nosep']) ? $_GET['nosep'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nosep)', strtolower($nosep), true);
            $criteria->order = 'nosep, nama_pasien';
            $criteria->limit = 5;
            $models = PencarianseprujukankeluarV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nosep . ' - ' . $model->nama_pasien  . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
                $returnVal[$i]['value'] = $model->sep_id;
                $returnVal[$i]['tglsep'] = date('d/m/Y H:i:s', strtotime($model->tglsep));
            }
            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    public function actionSetFormPoli()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $poliList = $_POST['poliList'] ?? null;
            $form = '';
            $pesan = '';
            if (count((array)$poliList) > 0) {
                foreach ($poliList as $i => $poli) {
                    $kdPoli = $poli['kodeSpesialis'];
                    $nmPoli = $poli['namaSpesialis'];
                    $kapasitas = $poli['kapasitas'];
                    $jumlahRujukan = $poli['jumlahRujukan'];
                    $form .=
                        "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" if (" . $kapasitas . " > 0){ $('#PasiendirujukkeluarT_dirujukkebagian').val('" . $kdPoli . "');$('#PasiendirujukkeluarT_dirujukkebagian_nama').val('" . $nmPoli . "');$('#dialogPoli').dialog('close'); }else{toastr.error('Kapsitas habis','Perhatian!')} \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>" . $kdPoli . "</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>" . $nmPoli . "</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][kapasitas]'>" . $kapasitas . "</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][jumlahRujukan]'>" . $jumlahRujukan . "</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }


    public function actionSetFormDiagnosa()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $diagnosaList = $_POST['diagnosaList'];
            $form = '';
            $pesan = '';
            if (count((array)$diagnosaList) > 0) {
                foreach ($diagnosaList as $i => $diagnosa) {
                    $kddiagnosa = $diagnosa['kode'];
                    $nmdiagnosa = str_replace($kddiagnosa . ' - ', "", $diagnosa['nama']);
                    $form .=
                        "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#PasiendirujukkeluarT_kodediagnosasementara_ruj').val('" . $kddiagnosa . "');$('#PasiendirujukkeluarT_diagnosasementara_ruj').val('" . $nmdiagnosa . "');$('#PasiendirujukkeluarT_diagnosa_awal').val('" . $kddiagnosa . ' - ' . $nmdiagnosa . "');$('#dialogDiagnosaBpjs').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>" . $kddiagnosa . "</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>" . $nmdiagnosa . "</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    public function actionSetFormFaskes()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $faskesList = $_POST['faskesList'];
            $form = '';
            $pesan = '';
            if (count((array)$faskesList) > 0) {
                foreach ($faskesList as $i => $faskes) {
                    $kdfaskes = $faskes['kode'];
                    $nmfaskes = $faskes['nama'];
                    $form .=
                        "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#PasiendirujukkeluarT_ppkrujukan').val('" . $kdfaskes . "');$('#PasiendirujukkeluarT_ppkrujukan_nama').val('" . $nmfaskes . "');$('#ppk_terdaftar').val('');cekFaskesRujukan('" . $kdfaskes . "');if (typeof addRujukanKeluar == 'function') { addRujukanKeluar(); }$('#dialogPpk').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>" . $kdfaskes . "</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>" . $nmfaskes . "</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    /**
     * set bpjs Interface
     */
    public function actionBpjsInterface()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (empty($_GET['param']) or $_GET['param'] === '') {
                die('param can\'not empty value');
            } else {
                $param = $_GET['param'];
            }
            $jenis_rujukan = isset($_GET['jenis_rujukan']) ? $_GET['jenis_rujukan'] : 1;

            $bpjs = new BpjsVklaim();

            switch ($param) {
                case '1':
                    $noSep = $_GET['noSep'];
                    $tglRujukan = MyFormatter::formatDateTimeForDb($_GET['tglRujukan']);
                    $tglRencana = MyFormatter::formatDateTimeForDb($_GET['tglRencana']);
                    $ppkDirujuk = $_GET['ppkDirujuk'];
                    $jnsPelayanan = $_GET['jnsPelayanan'];
                    $catatan = $_GET['catatan'];
                    $diagRujukan = $_GET['diagRujukan'];
                    $tipeRujukan = $_GET['tipeRujukan'];
                    $poliRujukan = $_GET['poliRujukan'];
                    $user = $_GET['user'];

                    print_r($bpjs->insert_rujukan_bpjs_new($noSep, $tglRujukan, $tglRencana, $ppkDirujuk, $jnsPelayanan, $catatan, $diagRujukan, $tipeRujukan, $poliRujukan, $user, $tglRencana));
                    break;

                case '2':
                    $noSep = $_GET['noSep'];
                    $noRujukan = $_GET['noRujukan'];
                    $tglRujukan = date("Y-m-d", strtotime($_GET['tglRujukan'])); //MyFormatter::formatDateTimeForDb($_GET['tglRujukan']);
                    $tglRencana = MyFormatter::formatDateTimeForDb($_GET['tglRencana']);
                    $ppkDirujuk = $_GET['ppkDirujuk'];
                    $jnsPelayanan = $_GET['jnsPelayanan'];
                    $catatan = $_GET['catatan'];
                    $diagRujukan = $_GET['diagRujukan'];
                    $tipeRujukan = $_GET['tipeRujukan'];
                    $poliRujukan = $_GET['poliRujukan'];
                    $user = $_GET['user'];

                    print_r($bpjs->update_rujukan_bpjs_2($noRujukan, $tglRujukan, $tglRencana, $ppkDirujuk, $jnsPelayanan, $catatan, $diagRujukan, $tipeRujukan, $poliRujukan, $user));
                    break;
                case '5':
                    $kodeppk = $_GET['kodeppk'];
                    $tgl = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($_GET['tgl'])));

                    print_r($bpjs->search_rujukan_spesialistik($kodeppk, $tgl));
                    break;
                default:
                    die('error number, please check your parameter option');
                    break;
            }
            Yii::app()->end();
        }
    }

    public function actionPrintRujukan($id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $model = PasiendirujukkeluarT::model()->findByPk($id);
        $modSep = ARSepT::model()->findByPk($model->sep_id);
        $judul_print = 'SURAT RUJUKAN';
        $this->render('printRujukan', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'model' => $model,
            'modSep' => $modSep,
        ));
    }

    public function actionCekFaskes()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $ppkDirujuk = $_GET['ppkDirujuk'];
            $id = 0;
            $modRujukan = RujukankeluarM::model()->findByAttributes(array('kodeppk_dirujuk' => $ppkDirujuk));
            if (count((array)$modRujukan) > 0) {
                $id = $modRujukan->rujukankeluar_id;
            }

            echo CJSON::encode(array('id' => $id));
            Yii::app()->end();
        }
    }

    public function actionPrint()
    {
        $model = new InformasirujukankeluarbpjsV;
        $format = new MyFormatter;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        if (isset($_REQUEST['ARInformasirujukankeluarbpjsV'])) {
            $model->attributes = $_REQUEST['ARInformasirujukankeluarbpjsV'];
            $model->nosuratrujukan = $_REQUEST['ARInformasirujukankeluarbpjsV']['nosuratrujukan'];
            $model->nosep = $_REQUEST['ARInformasirujukankeluarbpjsV']['nosep'];
            $model->nokartuasuransi = $_REQUEST['ARInformasirujukankeluarbpjsV']['nokartuasuransi'];
            $model->no_rekam_medik = $_REQUEST['ARInformasirujukankeluarbpjsV']['no_rekam_medik'];
            $model->nama_pasien = $_REQUEST['ARInformasirujukankeluarbpjsV']['nama_pasien'];
            $model->tgl_awal = isset($_REQUEST['ARInformasirujukankeluarbpjsV']['tgl_awal']) ? $format->formatDateTimeForDb($_REQUEST['ARInformasirujukankeluarbpjsV']['tgl_awal']) : null;
            $model->tgl_akhir = isset($_REQUEST['ARInformasirujukankeluarbpjsV']['tgl_akhir']) ? $format->formatDateTimeForDb($_REQUEST['ARInformasirujukankeluarbpjsV']['tgl_akhir']) : null;
        }

        $judulLaporan = 'Data Rujukan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * Menghapus data Rujukan
     */
    public function actionHapusRujukan($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $data['status'] = '';
            $model = PasiendirujukkeluarT::model()->findByPk($id);
            $modUser = LoginpemakaiK::model()->findByPk($model->create_loginpemakai_id);
            $nama = (isset($modUser->user_pemakai_bpjs) && !empty($modUser->user_pemakai_bpjs)) ? $modUser->user_pemakai_bpjs : $modUser->nama_pemakai;
            $bpjs = new BpjsVklaim();
            $transaction = Yii::app()->db->beginTransaction();
            $reqRujukan = json_decode($bpjs->delete_rujukan($model->nosuratrujukan, $nama), true);
            if ($reqRujukan['metaData']['code'] == 200) {
                if ($model->delete()) {
                    $this->deleterujukan = true;
                    $transaction->commit();
                    $data['sukses'] = 1;
                }
            } else {
                $this->deleterujukan = false;
                $transaction->rollback();
            }

            if ($this->deleterujukan == false) {
                $data['status'] = 'Data gagal dihapus karena ' . $reqRujukan['metaData']['message'];
            } else {
                $data['status'] = 'Data Rujukan berhasil dihapus';
            }

            echo CJSON::encode($data);
        }
    }

    public function actionAddRujukanKeluar()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $kode = isset($_POST['kode']) ? $_POST['kode'] : null;
            $nama = isset($_POST['nama']) ? $_POST['nama'] : null;

            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            $sukses = 1;
            $new = false;
            $pesan = '';
            try {

                $model = RujukankeluarM::model()->findByAttributes([
                    'kodeppk_dirujuk' => $kode
                ]);
                if (empty($model)) {
                    $new = true;
                    $model = new RujukankeluarM;
                    $model->attributes = [
                        'kodeppk_dirujuk' => $kode,
                        'rumahsakitrujukan' => $nama,
                        'rujukankeluar_aktif' => true
                    ];

                    $ok &= $model->save();

                    if ($ok) {
                        $trans->commit();
                        $sukses = 1;
                    } else {
                        $trans->rollback();
                        $pesan .= 'Data gagal disimpan. <br/>' . MyExceptionMessage::getErrorMessage($model);
                        $sukses = 0;
                    }
                }
            } catch (Exception $e) {
                $sukses = 0;
                $trans->rollback();
            }

            echo json_encode([
                'sukses' => $sukses,
                'databaru' => ($new) ? 'ya' : 'tidak',
                'pesan' => $pesan
            ]);
            exit;
        }
    }


    public function actionGetDataFaskes($jenis, $term = "")
    {
        if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
            Yii::app()->end();
        }

        $query1 = $jenis;
        $query2 = $term;
        $query = $query2 . '/' . $query1;
        $start = 1;
        $limit = 10;

        $bpjs = new BpjsVklaim();


        $res = CJSON::decode($bpjs->fasilitas_kesehatan($query, $start, $limit));
        $val = array();

        if (!empty($res['response']['faskes'])) {
            foreach ($res['response']['faskes'] as $item) {
                $val[] = array(
                    'label' => $item['kode'] . " - " . $item['nama'],
                    'value' => $item['kode'],
                    'kode' => $item['kode'],
                    'nama' => $item['nama']
                );
            }
        }

        echo CJSON::encode($val);
    }
}
