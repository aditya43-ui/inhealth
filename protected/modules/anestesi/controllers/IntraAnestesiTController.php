<?php

/**
 * Digunakan untuk transaksi intra anestesi
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 */
class IntraAnestesiTController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'anestesi.views.intraAnestesiT.';
    public $path_tips = 'anestesi.views.tips.';
    public $simpangas = true;
    public $simpanobat = true;
    public $simpankristaloid = true;
    public $simpankolloid = true;
    public $simpandarah = true;
    public $simpanlainnya = true;

    /**
     * Membuat dan menyimpan data baru.
     * @param type $pendaftaran_id
     */
    public function actionIndex($pasienanastesi_id = null, $frame = null) {
        if (!empty($frame)) {
            $this->layout = '//layouts/iframe';
        }
        $format = new MyFormatter();
        $disabled = true;
        $modIntraAnastesi = new ATIntraanastesiT();
        //$modIntraAnastesi->tanggal = MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s"));
        $modIntraAnastesi->tanggal = MyFormatter::formatDateTimeForUser(date("Y-m-d"));
        $modIntraAnastesi->gasflow_gasinhalasi = false;
        //$modIntraAnastesi->jam_masuk_ok = date("H:i:s");
        $modPraAnastesi = new ATPraanestesiT();
        $modObatCairanAnastesi = new ATObatcairanintraanastesiT();

        if (!empty($pasienanastesi_id)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('pasienanastesi_id = ' . $pasienanastesi_id);
            $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);

            $cekIntra = ATIntraanastesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            if (!empty($cekIntra)) {
                $modIntraAnastesi = $cekIntra;
            }
            $disabled = false;
        } else {
            $modKunjungan = new ATInformasipasienanestesiV();
        }

        if (isset($_POST['ATIntraanastesiT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!empty($_POST['ATIntraanastesiT']['intraanastesi_id'])) {
                    $modIntraAnastesi = ATIntraanastesiT::model()->findByPk($_POST['ATIntraanastesiT']['intraanastesi_id']);
                }
                $modIntraAnastesi->attributes = $_POST['ATIntraanastesiT'];
                $modIntraAnastesi->pendaftaran_id = $_POST['ATInformasipasienanestesiV']['pendaftaran_id'];
                $modIntraAnastesi->pasienanastesi_id = $_POST['ATInformasipasienanestesiV']['pasienanastesi_id'];
                $modIntraAnastesi->pasien_id = $_POST['ATInformasipasienanestesiV']['pasien_id'];
                $modIntraAnastesi->tanggal = MyFormatter::formatDateTimeForDb($_POST['ATIntraanastesiT']['tanggal']);
                if (!empty($_POST['ATIntraanastesiT']['jam_masuk_ok'])) {
                    $modIntraAnastesi->jam_masuk_ok = $_POST['ATIntraanastesiT']['jam_masuk_ok'];
                } else {
                    $modIntraAnastesi->jam_masuk_ok = null;
                }
                if (!empty($_POST['ATIntraanastesiT']['jam_ab_profilakasis'])) {
                    $modIntraAnastesi->jam_ab_profilakasis = $_POST['ATIntraanastesiT']['jam_ab_profilakasis'];
                } else {
                    $modIntraAnastesi->jam_ab_profilakasis = null;
                }
                if (!empty($_POST['ATIntraanastesiT']['jam_insisi'])) {
                    $modIntraAnastesi->jam_insisi = $_POST['ATIntraanastesiT']['jam_insisi'];
                } else {
                    $modIntraAnastesi->jam_insisi = null;
                }
                $modIntraAnastesi->pegawai_id = Yii::app()->user->getState('pegawai_id');
                $modIntraAnastesi->create_time = date('Y-m-d H:i:s');
                $modIntraAnastesi->create_loginpemakai_id = Yii::app()->user->id;
                $modIntraAnastesi->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $ok = $ok && $modIntraAnastesi->save();

                if ($ok) {
                    if (isset($_POST['gasinhalasi'])) {
                        foreach ($_POST['gasinhalasi'] as $i => $gasinhalasi) {
                            if ($gasinhalasi['nama'] != '') {
                                $modGasInhalasi = new ATObatcairanintraanastesiT();
                                $cekGas = ATObatcairanintraanastesiT::model()->findByPk($gasinhalasi['id']);
                                if (!empty($cekGas)) {
                                    $modGasInhalasi = $cekGas;
                                }
                                $modGasInhalasi->intraanastesi_id = $modIntraAnastesi->intraanastesi_id;
                                $modGasInhalasi->jenis = Params::OBAT_INTRAANASTESI_GAS_FLOW;
                                $modGasInhalasi->sub_jenis = Params::OBAT_INTRAANASTESI_GAS_FLOW;
                                $modGasInhalasi->tipe = Params::OBAT_INTRAANASTESI_GAS_FLOW;
                                $modGasInhalasi->nama = $gasinhalasi['nama'];
                                $this->simpangas = $modGasInhalasi->save() && true;
                            } else {
                                
                            }
                        }
                    }

                    if (isset($_POST['hapusglasflow'])) {
                        $idDel = array();
                        foreach ($_POST['hapusglasflow'] as $del) {
                            $idDel[] = $del;
                        }

                        $criDel = new CDbCriteria();
                        $criDel->addInCondition("obatcairanintraanastesi_id", $idDel);
                        ATObatcairanintraanastesiT::model()->deleteAll($criDel);
                    }

                    if (isset($_POST['obat'])) {
                        foreach ($_POST['obat'] as $i => $obat) {
                            if ($obat['nama'] != '') {
                                $modObat = new ATObatcairanintraanastesiT();
                                $cekObat = ATObatcairanintraanastesiT::model()->findByPk($obat['id']);
                                if (!empty($cekObat)) {
                                    $modObat = $cekObat;
                                }
                                $modObat->intraanastesi_id = $modIntraAnastesi->intraanastesi_id;
                                $modObat->jenis = Params::OBAT_INTRAANASTESI_OBAT;
                                $modObat->sub_jenis = Params::OBAT_INTRAANASTESI_OBAT;
                                $modObat->tipe = Params::OBAT_INTRAANASTESI_OBAT;
                                $modObat->nama = $obat['nama'];
                                $this->simpanobat = $modObat->save() && true;
                            } else {
                                
                            }
                        }
                    }

                    if (isset($_POST['hapusobat'])) {
                        $idDel = array();
                        foreach ($_POST['hapusobat'] as $del) {
                            $idDel[] = $del;
                        }

                        $criDel = new CDbCriteria();
                        $criDel->addInCondition("obatcairanintraanastesi_id", $idDel);
                        ATObatcairanintraanastesiT::model()->deleteAll($criDel);
                    }

                    if (isset($_POST['kristaloid'])) {
                        foreach ($_POST['kristaloid'] as $i => $kristaloid) {
                            if ($kristaloid['nama'] != '') {
                                $modKritaloid = new ATObatcairanintraanastesiT();
                                $cekKristaloid = ATObatcairanintraanastesiT::model()->findByPk($kristaloid['id']);

                                if (!empty($cekKristaloid)) {
                                    $modKritaloid = $cekKristaloid;
                                }
                                $modKritaloid->intraanastesi_id = $modIntraAnastesi->intraanastesi_id;
                                $modKritaloid->jenis = Params::INTRAANESTESI_KELOMPOK_CAIRAN;
                                $modKritaloid->sub_jenis = Params::KELOMPOK_CAIRAN_INPUT_KRISTALOID;
                                $modKritaloid->tipe = Params::KATEGORI_CAIRAN_INPUT;
                                $modKritaloid->nama = $kristaloid['nama'];
                                $this->simpankristaloid = $modKritaloid->save() && true;
                            } else {
                                
                            }
                        }
                    }

                    if (isset($_POST['hapuskristaloid'])) {
                        $idDel = array();
                        foreach ($_POST['hapuskristaloid'] as $del) {
                            $idDel[] = $del;
                        }

                        $criDel = new CDbCriteria();
                        $criDel->addInCondition("obatcairanintraanastesi_id", $idDel);
                        ATObatcairanintraanastesiT::model()->deleteAll($criDel);
                    }

                    if (isset($_POST['kolloid'])) {
                        foreach ($_POST['kolloid'] as $i => $kolloid) {
                            if ($kolloid['nama'] != '') {
                                $modKolloid = new ATObatcairanintraanastesiT();
                                $cekKoloid = ATObatcairanintraanastesiT::model()->findByPk($kolloid['id']);
                                if (!empty($cekKoloid)) {
                                    $modKolloid = $cekKoloid;
                                }
                                $modKolloid->intraanastesi_id = $modIntraAnastesi->intraanastesi_id;
                                $modKolloid->jenis = Params::INTRAANESTESI_KELOMPOK_CAIRAN;
                                $modKolloid->sub_jenis = Params::KELOMPOK_CAIRAN_INPUT_KOLLOID;
                                $modKolloid->tipe = Params::KATEGORI_CAIRAN_INPUT;
                                $modKolloid->nama = $kolloid['nama'];
                                $this->simpankolloid = $modKolloid->save() && true;
                            } else {
                                
                            }
                        }
                    }

                    if (isset($_POST['hapuskolloid'])) {
                        $idDel = array();
                        foreach ($_POST['hapuskolloid'] as $del) {
                            $idDel[] = $del;
                        }

                        $criDel = new CDbCriteria();
                        $criDel->addInCondition("obatcairanintraanastesi_id", $idDel);
                        ATObatcairanintraanastesiT::model()->deleteAll($criDel);
                    }


                    if (isset($_POST['darah'])) {
                        foreach ($_POST['darah'] as $i => $darah) {
                            if ($darah['nama'] != '') {
                                $modDarah = new ATObatcairanintraanastesiT();
                                $cekDarah = ATObatcairanintraanastesiT::model()->findByPk($darah['id']);
                                if (!empty($cekDarah)) {
                                    $modDarah = $cekDarah;
                                }
                                $modDarah->intraanastesi_id = $modIntraAnastesi->intraanastesi_id;
                                $modDarah->jenis = Params::INTRAANESTESI_KELOMPOK_DARAH;
                                $modDarah->sub_jenis = $darah['subjenis'];
                                $modDarah->tipe = Params::KATEGORI_CAIRAN_INPUT;
                                $modDarah->nama = $darah['nama'];
                                $modDarah->ukuran = $darah['ukuran'];
                                $this->simpandarah = $modDarah->save() && true;
                            } else {
                                
                            }
                        }
                    }

                    if (isset($_POST['hapusdarah'])) {
                        $idDel = array();
                        foreach ($_POST['hapusdarah'] as $del) {
                            $idDel[] = $del;
                        }

                        $criDel = new CDbCriteria();
                        $criDel->addInCondition("obatcairanintraanastesi_id", $idDel);
                        ATObatcairanintraanastesiT::model()->deleteAll($criDel);
                    }


                    if (isset($_POST['lainnya'])) {
                        foreach ($_POST['lainnya'] as $i => $lainnya) {
                            if ($lainnya['nama'] != '') {
                                $modLainnya = new ATObatcairanintraanastesiT();
                                $cekLainnya = ATObatcairanintraanastesiT::model()->findByPk($lainnya['id']);
                                if (!empty($cekLainnya)) {
                                    $modLainnya = $cekLainnya;
                                }
                                $modLainnya->intraanastesi_id = $modIntraAnastesi->intraanastesi_id;
                                $modLainnya->jenis = Params::INTRAANESTESI_KELOMPOK_CAIRAN;
                                $modLainnya->sub_jenis = Params::KELOMPOK_CAIRAN_INPUT_LAINNYA;
                                $modLainnya->tipe = Params::KATEGORI_CAIRAN_INPUT;
                                $modLainnya->nama = $lainnya['nama'];
                                $this->simpanlainnya = $modLainnya->save() && true;
                            } else {
                                
                            }
                        }
                    }

                    if (isset($_POST['hapuslainnya'])) {
                        $idDel = array();
                        foreach ($_POST['hapuslainnya'] as $del) {
                            $idDel[] = $del;
                        }

                        $criDel = new CDbCriteria();
                        $criDel->addInCondition("obatcairanintraanastesi_id", $idDel);
                        ATObatcairanintraanastesiT::model()->deleteAll($criDel);
                    }

                    if (isset($_POST['cairankeluar'])) {
                        foreach ($_POST['cairankeluar'] as $i => $cairankeluar) {
                            if ($cairankeluar['nama'] != '') {
                                $modCairanKeluar = new ATObatcairanintraanastesiT();
                                $cekCairanKeluar = ATObatcairanintraanastesiT::model()->findByPk($cairankeluar['id']);
                                if (!empty($cekCairanKeluar)) {
                                    $modCairanKeluar = $cekCairanKeluar;
                                }
                                $modCairanKeluar->intraanastesi_id = $modIntraAnastesi->intraanastesi_id;
                                $modCairanKeluar->jenis = Params::INTRAANESTESI_KELOMPOK_CAIRAN;
                                $modCairanKeluar->sub_jenis = $cairankeluar['sub_jenis'];
                                $modCairanKeluar->tipe = Params::KATEGORI_CAIRAN_OUTPUT;
                                $modCairanKeluar->nama = $cairankeluar['nama'];
                                $this->simpanlainnya = $modCairanKeluar->save() && true;
                            } else {
                                
                            }
                        }
                    }
                }

                if ($ok && $this->simpangas && $this->simpanobat && $this->simpankristaloid && $this->simpankolloid && $this->simpandarah && $this->simpanlainnya) {
                    $transaction->commit();
                    if (empty($pasienanastesi_id)) {
                        $this->redirect(array('index', 'pasienanastesi_id' => $modIntraAnastesi->pasienanastesi_id, 'intraanastesi_id' => $modIntraAnastesi->intraanastesi_id, 'sukses' => 1));
                    } else {
                        $this->redirect(array('index', 'pasienanastesi_id' => $pasienanastesi_id, 'intraanastesi_id' => $modIntraAnastesi->intraanastesi_id));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Intra Anestesi gagal disimpan !");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
                        . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
                        . "</a>";
                Yii::app()->user->setFlash('error', "Data Intra Anestesi gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'format' => $format,
            'modKunjungan' => $modKunjungan,
            'modIntraAnastesi' => $modIntraAnastesi,
            'modPraAnastesi' => $modPraAnastesi,
            'modObatCairanAnastesi' => $modObatCairanAnastesi,
            'disabled' => $disabled
        ));
    }

    /**
     * Mengurai data kunjungan berdasarkan:
     * - pasienmasukpenunjang_id
     * @throws CHttpException
     */
    public function actionGetDataKunjungan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();

            $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;

            if (!empty($pasienmasukpenunjang_id)) {
                $criteria->addCondition('pasienmasukpenunjang_id =' . $pasienmasukpenunjang_id);
            }
            if (!empty($pendaftaran_id)) {
                $criteria->addCondition('pendaftaran_id =' . $pendaftaran_id);
            }
            if (!empty($pasienanastesi_id)) {
                $criteria->addCondition('pasienanastesi_id = ' . $pasienanastesi_id);
            }

            $model = ATInformasipasienanestesiV::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["tglanastesi"] = $format->formatDateTimeForUser($model->tglanastesi);

            $cekIntra = ATIntraanastesiT::model()->findByAttributes(array('pasienanastesi_id' => $model->pasienanastesi_id));
            $returnVal["jam_ab_profilakasis"] = '';
            $returnVal["jam_insisi"] = '';
            $returnVal["intraanastesi_id"] = '';
            $returnVal["tanggal"] = '';
            $returnVal["jam_masuk_ok"] = '';
            if (!empty($cekIntra)) {
                $returnVal["jam_ab_profilakasis"] = $cekIntra->jam_ab_profilakasis;
                $returnVal["jam_insisi"] = $cekIntra->jam_insisi;
                $returnVal["intraanastesi_id"] = $cekIntra->intraanastesi_id;
                $returnVal["tanggal"] = MyFormatter::formatDateTimeForUser($cekIntra->tanggal);
                $returnVal["jam_masuk_ok"] = $cekIntra->jam_masuk_ok;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionLoadObatIntra() {
        if (Yii::app()->request->isAjaxRequest) {
            $pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;
            if (!empty($pasienanastesi_id)) {
                $cekIntra = ATIntraanastesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            }

            $arrKeluar = array();

            $arr['detGasInhalasi'] = array();
            $arr['detObat'] = array();
            $arr['detKristaloid'] = array();
            $arr['detKolloid'] = array();
            $arr['detLainnya'] = array();
            $arr['detDarah'] = array();
            $arr['detCairanKeluar'] = array();

            $trGasInhalasi = '';
            $trObat = '';
            $trKristaloid = '';
            $trKolloid = '';
            $trLainnya = '';
            $trDarah = '';
            $trCairanKeluar = '';
            $formAwal = '';

            $i_gas = 0;
            $i_obat = 0;
            $i_kristaloid = 0;
            $i_kolloid = 0;
            $i_lainnya = 0;
            $i_darah = 0;
            $new = new ATObatcairanintraanastesiT;

            if (!empty($cekIntra)) {

                $obatIntra = ATObatcairanintraanastesiT::model()->findAllByAttributes(array('intraanastesi_id' => $cekIntra->intraanastesi_id));

                foreach ($obatIntra as $det) {
                    if (strtolower($det->jenis) == strtolower(Params::OBAT_INTRAANASTESI_GAS_FLOW)) {
                        $trGasInhalasi .= $this->renderPartial($this->path_view . '_rowGasInhalasi', array('det' => $det, 'i' => $i_gas), true);
                        $i_gas++;
                    } elseif (strtolower($det->jenis) == strtolower(Params::OBAT_INTRAANASTESI_OBAT)) {
                        $trObat .= $this->renderPartial($this->path_view . '_rowObat', array('det' => $det, 'i' => $i_obat), true);
                        $i_obat++;
                    } elseif (strtolower($det->jenis) == strtolower(Params::INTRAANESTESI_KELOMPOK_CAIRAN)) {
                        if (strtolower($det->sub_jenis) == strtolower(Params::KELOMPOK_CAIRAN_INPUT_KRISTALOID) && strtolower($det->tipe) == strtolower(Params::KATEGORI_CAIRAN_INPUT)) {
                            $trKristaloid .= $this->renderPartial($this->path_view . '_rowKristaloid', array('det' => $det, 'i' => $i_kristaloid), true);
                            $i_kristaloid++;
                        } elseif (strtolower($det->sub_jenis) == strtolower(Params::KELOMPOK_CAIRAN_INPUT_KOLLOID) && strtolower($det->tipe) == strtolower(Params::KATEGORI_CAIRAN_INPUT)) {
                            $trKolloid .= $this->renderPartial($this->path_view . '_rowKolloid', array('det' => $det, 'i' => $i_kolloid), true);
                            $i_kolloid++;
                        } elseif (strtolower($det->sub_jenis) == strtolower(Params::KELOMPOK_CAIRAN_INPUT_LAINNYA)) {
                            $trLainnya .= $this->renderPartial($this->path_view . '_rowLainnya', array('det' => $det, 'i' => $i_lainnya), true);
                            $i_lainnya++;
                        } elseif (strtolower($det->tipe) == strtolower(Params::KATEGORI_CAIRAN_OUTPUT)) {
                            $arrKeluar[strtoupper($det->tipe)][strtoupper($det->sub_jenis)]['nama'] = $det->nama;
                            $arrKeluar[strtoupper($det->tipe)][strtoupper($det->sub_jenis)]['id'] = $det->obatcairanintraanastesi_id;
                        }
                    } elseif (strtolower($det->jenis) == strtolower(Params::INTRAANESTESI_KELOMPOK_DARAH)) {
                        $trDarah .= $this->renderPartial($this->path_view . '_rowDarah', array('det' => $det, 'i' => $i_darah), true);
                        $i_darah++;
                    }
                }
            }

            if (empty($trGasInhalasi)) {
                $trGasInhalasi = $this->renderPartial($this->path_view . '_rowGasInhalasi', array('det' => $new, 'i' => 0), true);
            }
            if (empty($trObat)) {
                $trObat = $this->renderPartial($this->path_view . '_rowObat', array('det' => $new, 'i' => 0), true);
            }
            if (empty($trKristaloid)) {
                $trKristaloid = $this->renderPartial($this->path_view . '_rowKristaloid', array('det' => $new, 'i' => 0), true);
            }
            if (empty($trKolloid)) {
                $trKolloid = $this->renderPartial($this->path_view . '_rowKolloid', array('det' => $new, 'i' => 0), true);
            }
            if (empty($trLainnya)) {
                $trLainnya = $this->renderPartial($this->path_view . '_rowLainnya', array('det' => $new, 'i' => 0), true);
            }

            if (empty($trDarah)) {
                $trDarah .= $this->renderPartial($this->path_view . '_rowDarah', array('det' => $new, 'i' => 0), true);
            }

            $trCairanKeluar = $this->renderPartial($this->path_view . '_rowCairanKeluar', array('det' => $arrKeluar, 'i' => 0), true);

            $formAwal = $this->renderPartial($this->path_view . '_rowAwal', array('modIntraAnastesi' => !empty($cekIntra) ? $cekIntra : new ATIntraanastesiT), true);

            $arr['detGasInhalasi'] = $trGasInhalasi;
            $arr['detObat'] = $trObat;
            $arr['detKristaloid'] = $trKristaloid;
            $arr['detKolloid'] = $trKolloid;
            $arr['detLainnya'] = $trLainnya;
            $arr['detDarah'] = $trDarah;
            $arr['detCairanKeluar'] = $trCairanKeluar;
            $arr['formAwal'] = $formAwal;
            $arr['sukses'] = 1;

            echo json_encode($arr);
            Yii::app()->end();
        }
    }

}
