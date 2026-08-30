<?php

/**
 * @author Tantowi J <tantowijaya@.com>
 * Persetujuan tindakan pra anastesi
 */
class PersetujuanTindakanAnastesiController extends MyAuthController
{
    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'bedahSentral.views.persetujuanTindakanAnastesi.';

    public function actionIndex($pasienanastesi_id = null, $pasienkirimkeunitlain_id = null, $pasienmasukpenunjang_id = null, $persetujuananestesi_id = null, $pendaftaran_id = null, $noframe = null)
    {
        if (!empty($noframe)) {
            $this->layout = '//layouts/mainNeonSidebar';
        }

        $format = new MyFormatter();
        $model = new PersetujuananestesiT;
        $model->jenissurat = Params::SURAT_PERSETUJUAN_PERSETUJUAN;

        $informasi = new PemberianinformasiT;

        //dicomment karena modul anastesi belum ada.
        //        $modPasienAnestesi = PasienanastesiT::model()->findByPk($pasienanastesi_id);
        //        $modRencanaOperasi = RencanaoperasiT::model()->findByPk($modPasienAnestesi->rencanaoperasi_id);
        //        $modPendaftaran = PendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
        //        $modPasien = PasienM::model()->findByPk($modPasienAnestesi->pasien_id);

        $modPasienAnestesi = new PasienanastesiT();
        $modRencanaOperasi = new RencanaoperasiT();


        if (!empty($pendaftaran_id)) {
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            if (!empty($persetujuananestesi_id)) {
                $model = PersetujuananestesiT::model()->findByPk($persetujuananestesi_id);

                if (empty($model) || $model->jenissurat != Params::SURAT_PERSETUJUAN_PERSETUJUAN) {
                    $model = new PersetujuananestesiT();
                    $model->jenissurat = Params::SURAT_PERSETUJUAN_PERSETUJUAN;
                }
            }
        } else {

            if (!empty($pasienkirimkeunitlain_id)) {
                $model = PersetujuananestesiT::model()->findByAttributes(array(
                    'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id,
                ));

                if (!empty($model)) {
                    $persetujuananestesi_id = $model->persetujuananestesi_id;
                }
            } else if (!empty($pasienmasukpenunjang_id)) {
                $model = PersetujuananestesiT::model()->findByAttributes(array(
                    'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
                ));
                if (!empty($model)) {
                    $persetujuananestesi_id = $model->persetujuananestesi_id;
                }
            }


            if (!empty($persetujuananestesi_id)) {
                $model = PersetujuananestesiT::model()->findByPk($persetujuananestesi_id);

                if (empty($model) || $model->jenissurat != Params::SURAT_PERSETUJUAN_PERSETUJUAN) {
                    $model = new PersetujuananestesiT();
                    $model->jenissurat = Params::SURAT_PERSETUJUAN_PERSETUJUAN;
                }

                $pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
                $pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;
            } else {
                $model = new PersetujuananestesiT;
                $model->jenissurat = Params::SURAT_PERSETUJUAN_PERSETUJUAN;
            }

            if (!empty($pasienkirimkeunitlain_id)) {
                $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
                $modPendaftaran = PendaftaranT::model()->findByPk($modKirimKeUnitLain->pendaftaran_id);
            } else if (!empty($pasienmasukpenunjang_id)) {
                $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
                $modPendaftaran = PendaftaranT::model()->findByPk($modPasienMasukPenunjang->pendaftaran_id);
            }
        }

        if (!empty($model) && !$model->isNewRecord) {
            $informasi = PemberianinformasiT::model()->findByAttributes(array(
                'persetujuananestesi_id' => $model->persetujuananestesi_id
            ));
        }

        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        /*Ambil diagnosa*/
        $morbiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), array('order' => 'pasienmorbiditas_id DESC'));
        $diagnosa = !empty($morbiditas->diagnosa_id) ? $morbiditas->diagnosa->diagnosa_nama : "";

        if (isset($_POST['PersetujuananestesiT'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['PersetujuananestesiT'];
                //                $model->pasienmasukpenunjang_id = $modPasienAnestesi->pasienmasukpenunjang_id;
                $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
                $model->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');


                if ($model->validate()) {
                    if ($model->save()) {
                        $ok = true;
                        if (isset($_POST['PemberianinformasiT'])) {
                            $informasi = $this->simpanPemberianInformasi($model, $_POST['PemberianinformasiT']);
                            $ok = $ok && !empty($informasi->pemberianinformasi_id);

                            if (isset($_POST['informasi'])) {
                                $ok = $ok && $this->simpanPemberianInformasiDetail($model, $informasi, $_POST['informasi']);
                            }
                        }

                        if ($ok) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', "Surat Persetujuan Tindakan Anastesi berhasil disimpan");
                            //                      $this->redirect(array('Index','pasienanastesi_id'=>$pasienanastesi_id, 'persetujuananestesi_id'=>$model->persetujuananestesi_id,'sukses'=>1));
                            $this->redirect(array(
                                'Index',
                                'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id,
                                'pasinemasukpenunjang_id' => $pasienmasukpenunjang_id,
                                'persetujuananestesi_id' => $model->persetujuananestesi_id,
                                'pendaftaran_id' => $pendaftaran_id,
                                'noframe' => $noframe,
                                'sukses' => 1,
                            ));
                        } else {
                            $transaction->rollback();
                            echo '<pre>'; var_dump($model->getErrors()); die;
                            Yii::app()->user->setFlash('error', "Surat Persetujuan Tindakan Anastesi gagal disimpan ");
                        }
                    }
                } else {
                    $transaction->rollback();
                    // echo '<pre>'; var_dump($model->getErrors()); die;
                    Yii::app()->user->setFlash('error', "Surat Persetujuan Tindakan Anastesi gagal disimpan ");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                echo '<pre>'; var_dump($ex); die;
                Yii::app()->user->setFlash('error', "Transaksi gagal disimpan");
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPasienAnestesi' => $modPasienAnestesi,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'diagnosa' => $diagnosa,
            'modRencanaOperasi' => $modRencanaOperasi,
            'format' => $format,
            'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id,
            'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
            'pendaftaran_id' => $pendaftaran_id,
            'noframe' => $noframe,
            'informasi' => $informasi,
        ));
    }

    public function simpanPemberianInformasi($model, $post)
    {
        $informasi = new PemberianinformasiT;
        $informasi->attributes = $post;
        $informasi->pendaftaran_id = $model->pendaftaran_id;
        $informasi->persetujuananestesi_id = $model->persetujuananestesi_id;
        $informasi->create_time = $model->create_time;
        $informasi->create_loginpemakai_id = $model->create_loginpemakai_id;
        $informasi->create_ruangan = $model->create_ruangan;

        $informasi->save();

        return $informasi;
    }

    public function simpanPemberianInformasiDetail($model, $informasi, $post)
    {
        $ok = true;


        foreach ($post as $jenisinformasi_id => $val) {

            $det = new PemberianinformasidetT;
            $det->attributes = $val;
            $det->pemberianinformasi_id = $informasi->pemberianinformasi_id;
            $det->jenisinformasi_id = $jenisinformasi_id;

            $ok = $ok && $det->save();

            if (isset($val['ceklis'])) {
                foreach ($val['ceklis'] as $item) {
                    $ceklis = new ChecklistpemberianinformasiT;
                    $ceklis->pemberianinformasidet_id = $det->pemberianinformasidet_id;
                    $ceklis->checklistpemberianinformasi_awal = $item['sebelum'];
                    $ceklis->checklistpemberianinformasi_nama = $item['nama'];
                    $ceklis->checklistpemberianinformasi_akhir = $item['sesudah'];
                    if (isset($item['ceklis'])) {
                        $ceklis->checklistpemberianinformasi_ceklis = $item['ceklis'];
                    }

                    $ok = $ok && $ceklis->save();

                    // var_dump($ceklis->attributes);
                }
            }

            // var_dump($det->attributes);
        }
        return $ok;
        // var_dump($ok, $post);
        // die;
    }

    public function actionPenolakan($pasienanastesi_id = null, $pasienkirimkeunitlain_id = null, $pasienmasukpenunjang_id = null, $persetujuananestesi_id = null, $pendaftaran_id = null, $noframe = null)
    {
        if (!empty($noframe)) {
            $this->layout = '//layouts/mainNeonSidebar';
        }

        $format = new MyFormatter();
        $model = new PersetujuananestesiT;
        $model->jenissurat = Params::SURAT_PERSETUJUAN_PENOLAKAN;

        $informasi = new PemberianinformasiT;

        //dicomment karena modul anastesi belum ada.
        //        $modPasienAnestesi = PasienanastesiT::model()->findByPk($pasienanastesi_id);
        //        $modRencanaOperasi = RencanaoperasiT::model()->findByPk($modPasienAnestesi->rencanaoperasi_id);
        //        $modPendaftaran = PendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
        //        $modPasien = PasienM::model()->findByPk($modPasienAnestesi->pasien_id);

        $modPasienAnestesi = new PasienanastesiT();
        $modRencanaOperasi = new RencanaoperasiT();


        if (!empty($pendaftaran_id)) {
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            if (!empty($persetujuananestesi_id)) {
                $model = PersetujuananestesiT::model()->findByPk($persetujuananestesi_id);

                if (empty($model) || $model->jenissurat != Params::SURAT_PERSETUJUAN_PENOLAKAN) {
                    $model = new PersetujuananestesiT();
                    $model->jenissurat = Params::SURAT_PERSETUJUAN_PENOLAKAN;
                }
            }
        } else {

            if (!empty($pasienkirimkeunitlain_id)) {
                $model = PersetujuananestesiT::model()->findByAttributes(array(
                    'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id,
                ));

                if (!empty($model)) {
                    $persetujuananestesi_id = $model->persetujuananestesi_id;
                }
            } else if (!empty($pasienmasukpenunjang_id)) {
                $model = PersetujuananestesiT::model()->findByAttributes(array(
                    'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
                ));
                if (!empty($model)) {
                    $persetujuananestesi_id = $model->persetujuananestesi_id;
                }
            }


            if (!empty($persetujuananestesi_id)) {
                $model = PersetujuananestesiT::model()->findByPk($persetujuananestesi_id);

                if (empty($model) || $model->jenissurat != Params::SURAT_PERSETUJUAN_PENOLAKAN) {
                    $model = new PersetujuananestesiT();
                    $model->jenissurat = Params::SURAT_PERSETUJUAN_PENOLAKAN;
                }

                $pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
                $pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;
            } else {
                $model = new PersetujuananestesiT;
                $model->jenissurat = Params::SURAT_PERSETUJUAN_PENOLAKAN;
            }

            if (!empty($pasienkirimkeunitlain_id)) {
                $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
                $modPendaftaran = PendaftaranT::model()->findByPk($modKirimKeUnitLain->pendaftaran_id);
            } else if (!empty($pasienmasukpenunjang_id)) {
                $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
                $modPendaftaran = PendaftaranT::model()->findByPk($modPasienMasukPenunjang->pendaftaran_id);
            }
        }


        if (!empty($model) && !$model->isNewRecord) {
            $informasi = PemberianinformasiT::model()->findByAttributes(array(
                'persetujuananestesi_id' => $model->persetujuananestesi_id
            ));
        }

        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        /*Ambil diagnosa*/
        $morbiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), array('order' => 'pasienmorbiditas_id DESC'));
        $diagnosa = !empty($morbiditas->diagnosa_id) ? $morbiditas->diagnosa->diagnosa_nama : "";

        if (isset($_POST['PersetujuananestesiT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['PersetujuananestesiT'];
                //                $model->pasienmasukpenunjang_id = $modPasienAnestesi->pasienmasukpenunjang_id;
                $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
                $model->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->jenissurat = Params::SURAT_PERSETUJUAN_PENOLAKAN;


                if ($model->validate()) {
                    if ($model->save()) {
                        $ok = true;
                        if (isset($_POST['PemberianinformasiT'])) {
                            $informasi = $this->simpanPemberianInformasi($model, $_POST['PemberianinformasiT']);
                            $ok = $ok && !empty($informasi->pemberianinformasi_id);

                            if (isset($_POST['informasi'])) {
                                $ok = $ok && $this->simpanPemberianInformasiDetail($model, $informasi, $_POST['informasi']);
                            }
                        }

                        if ($ok) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', "Surat Penolakan Tindakan Anastesi berhasil disimpan");
                            //                      $this->redirect(array('Index','pasienanastesi_id'=>$pasienanastesi_id, 'persetujuananestesi_id'=>$model->persetujuananestesi_id,'sukses'=>1));
                            $this->redirect(array(
                                'penolakan',
                                'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id,
                                'pasinemasukpenunjang_id' => $pasienmasukpenunjang_id,
                                'persetujuananestesi_id' => $model->persetujuananestesi_id,
                                'pendaftaran_id' => $pendaftaran_id,
                                'noframe' => $noframe,
                                'sukses' => 1,
                            ));
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "Surat Penolakan Tindakan Anastesi gagal disimpan ");
                        }
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Surat Penolakan Tindakan Anastesi gagal disimpan ");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Transaksi gagal disimpan");
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPasienAnestesi' => $modPasienAnestesi,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'diagnosa' => $diagnosa,
            'modRencanaOperasi' => $modRencanaOperasi,
            'format' => $format,
            'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id,
            'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
            'pendaftaran_id' => $pendaftaran_id,
            'noframe' => $noframe,
            'informasi' => $informasi,
        ));
    }

    public function actionPrint($pasienanastesi_id = null, $pasienmasukpenunjang_id = null, $persetujuananestesi_id = null)
    {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $model = PersetujuananestesiT::model()->findByPk($persetujuananestesi_id);
        $pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
        $pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;
        //dicomment karena modul anastesi belum ada.
        //        $modPasienAnestesi = PasienanastesiT::model()->findByPk($pasienanastesi_id);
        //        $modRencanaOperasi = RencanaoperasiT::model()->findByPk($modPasienAnestesi->rencanaoperasi_id);
        //        $modPendaftaran = PendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
        //        $modPasien = PasienM::model()->findByPk($modPasienAnestesi->pasien_id);

        $modPasienAnestesi = new PasienanastesiT();
        $modRencanaOperasi = new RencanaoperasiT();
        $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

        $pendaftaran_id = $model->pendaftaran_id;
        if (!empty($pasienkirimkeunitlain_id)) {
            $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
        } else if (!empty($pasienmasukpenunjang_id)) {
            $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
        }

        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);

        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        /*Ambil diagnosa*/
        $morbiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), array('order' => 'pasienmorbiditas_id DESC'));
        $diagnosa = !empty($morbiditas->diagnosa_id) ? $morbiditas->diagnosa->diagnosa_nama : "";

        $caraPrint = $_REQUEST['caraprint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }

        $informasi = PemberianinformasiT::model()->findByAttributes(array(
            'persetujuananestesi_id' => $persetujuananestesi_id,
        ));

        $this->render($this->path_view . 'PrintNew', array(
            'model' => $model,
            'modPasienAnestesi' => $modPasienAnestesi,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'diagnosa' => $diagnosa,
            'modRencanaOperasi' => $modRencanaOperasi,
            'format' => $format,
            'pendaftaran_id' => $pendaftaran_id,
            'informasi' => $informasi,
        ));
    }


    public function actionLoadInformasi()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            return Yii::app()->end();
        }

        $id = $_POST['id'];

        $jenis = JenisinformasiM::model()->findAllByAttributes(array(
            'jenissurat_id' => $id,
        ), array('order' => 'jenisinformasi_urutan asc'));

        $html = "";
        foreach ($jenis as $cnt => $item) {
            $html .= $this->renderPartial($this->path_view . 'informasi._list', array(
                'jenis' => $item,
                'cnt' => $cnt,
                'len' => count($jenis),
            ), true);
        }

        echo CJSON::encode(array('html' => $html, 'count' => count($jenis)));
    }

    public function actionPrintInformasi($persetujuananestesi_id)
    {
        $this->layout = '//layouts/iframe';
        $surat = PersetujuananestesiT::model()->findByPk($persetujuananestesi_id);

        $model = PemberianinformasiT::model()->findByAttributes(array(
            'persetujuananestesi_id' => $persetujuananestesi_id,
        ));
        $detail = PemberianinformasidetT::model()->findAllByAttributes(array(
            'pemberianinformasi_id' => $model->pemberianinformasi_id,
        ), array(
            'order' => 'pemberianinformasidet_id asc',
        ));
        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);

        $caraPrint = $_REQUEST['caraprint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }

        $this->render($this->path_view . '_printInformasi', array(
            'surat' => $surat,
            'model' => $model,
            'detail' => $detail,
            'pendaftaran' => $pendaftaran,
        ));
    }
}
