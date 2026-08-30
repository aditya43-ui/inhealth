<?php

/**
 * @author rusdiyanto <rusdiyanto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 */
class GrafikMonitoringIntraAnastesiController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $path_view = 'anestesi.views.grafikMonitoringIntraAnastesi.';

    /**
     * Halaman transaksi grafik monitoring intra anastesi
     * @param type $pasienanastesi_id
     */
    public function actionIndex($pasienanastesi_id = null, $frame = null) {
        if (!empty($frame)) {
            $this->layout = '//layouts/iframe';
        }
        $model = new IntraanastesiT();
        $modKunjungan = new ATInformasipasienanestesiV();
        $modIntraAnestesi = new ATIntraanastesiT();
        $format = new MyFormatter();
        $modObat = new ObatcairanintraanastesiT();
        $getMonitoring = array();
        if (!empty($pasienanastesi_id)) {
            $modMonitoring = MonitoringintraanastesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            $getMonitoring = $modMonitoring;
            $modKunjungan = ATInformasipasienanestesiV::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
        } else {
            $modMonitoring = new MonitoringintraanastesiT();
        }
        $cekIntraAnestesi = ATIntraanastesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));        
        if (!empty($cekIntraAnestesi)) {            
            $model = $cekIntraAnestesi;
            if ($model->kondisifisik_bugar == false) {
                $model->cek_kondisi_fisik = 'Tidak Bugar';
            } else {
                $model->cek_kondisi_fisik = 'Bugar';
            }
            
        }
        $model->tanggal_selesai = date('d M Y H:i:s');
        if (isset($_POST['ATInformasipasienanestesiV'])) {
            if (isset($_POST['IntraanastesiT'])) {
                $model->attributes = $_POST['IntraanastesiT'];

                $model->jam_selesai_ok = date('H:i:s', strtotime($_POST['IntraanastesiT']['jam_selesai_ok']));
                $model->jam_selesai_anastesi = date('H:i:s', strtotime($_POST['IntraanastesiT']['jam_selesai_anastesi']));
                $model->bayi_lahir_jam = date('H:i:s', strtotime($_POST['IntraanastesiT']['bayi_lahir_jam']));
                if ($_POST['IntraanastesiT']['cek_kondisi_fisik'] == 'Tidak Bugar') {
                    $model->kondisifisik_bugar = false;
                    $model->kondisifisik_tidakbugar = true;
                } else {
                    $model->kondisifisik_bugar = true;
                    $model->kondisifisik_tidakbugar = false;
                }
                if ($model->save()) {
                    $modPasienAnastesi = PasienanastesiT::model()->findByPk($model->pasienanastesi_id);
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'pasienanastesi_id' => $model->pasienanastesi_id, 'pendaftaran_id' => $model->pendaftaran_id, 'pasienmasukpenunjang_id' => $modPasienAnastesi->pasienmasukpenunjang_id, 'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'format' => $format,
            'modKunjungan' => $modKunjungan,
            'modObat' => $modObat,
            'modIntraAnestesi' => $modIntraAnestesi,
            'modMonitoring' => $modMonitoring,
            'getMonitoring' => $getMonitoring,
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

            $cekIntraAnastesi = IntraanastesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            $returnVal["intraanastesi_id"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->intraanastesi_id : '';
            $returnVal["pegawai_id"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->pegawai_id : '';
            $cekPegawai = PegawaiM::model()->findByPk(!empty($cekIntraAnastesi) ? $cekIntraAnastesi->pegawai_id : null);
            $returnVal["nama_pegawai"] = !empty($cekPegawai) ? $cekPegawai->nama_pegawai : '';
            $returnVal["ventilasi_circuit"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->ventilasi_circuit : '';
            $returnVal["ventilasi_spontan"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->ventilasi_spontan : '';
            $returnVal["ventilasi_assisted"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->ventilasi_assisted : '';
            $returnVal["ventilasi_cmv"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->ventilasi_cmv : '';
            $returnVal["ventilasi_pcv"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->ventilasi_pcv : '';
            $returnVal["ventilasi_tv"] = !empty($cekIntraAnastesi) ? 'TV / ' . $cekIntraAnastesi->ventilasi_tv : '';
            $returnVal["ventilasi_rate"] = !empty($cekIntraAnastesi) ? 'Rate / ' . $cekIntraAnastesi->ventilasi_rate : '';
            $returnVal["ventilasi_peep"] = !empty($cekIntraAnastesi) ? 'Peep / ' . $cekIntraAnastesi->ventilasi_peep : '';
            $returnVal["gasflow_n2o_keterangan"] = !empty($cekIntraAnastesi->gasflow_n2o) ? 'N20 / ' . $cekIntraAnastesi->gasflow_n2o_keterangan : '';
            $returnVal["gasflow_o2_keterangan"] = !empty($cekIntraAnastesi->gasflow_o2) ? 'O2 / ' . $cekIntraAnastesi->gasflow_o2_keterangan : '';
            $returnVal["gasflow_air_keterangan"] = !empty($cekIntraAnastesi->gasflow_air) ? 'Air / ' . $cekIntraAnastesi->gasflow_air_keterangan : '';
            $returnVal["gasflow_n2o"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->gasflow_n2o : '';
            $returnVal["gasflow_o2"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->gasflow_o2 : '';
            $returnVal["gasflow_air"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->gasflow_air : '';
            $returnVal["gasflow_gasinhalasi"] = !empty($cekIntraAnastesi) ? $cekIntraAnastesi->gasflow_gasinhalasi : '';
            if (!empty($cekIntraAnastesi)) {
                $tabelgasinhalasi = "";
                if ($cekIntraAnastesi->gasflow_gasinhalasi == true) {
                    $gas_inhalasi = ObatcairanintraanastesiT::model()->findAllByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'jenis' => 'GASFLOW'));
                    $tabelgasinhalasi .= "<tbody>";
                    foreach ($gas_inhalasi as $row) {
                        $tabelgasinhalasi .= "<tr>";
                        $tabelgasinhalasi .= "<td><input readonly='readonly' type='text' value='Gas Inhalasi / " . $row->nama . "' style='margin-bottom:8px'><br> </td>";
                        $tabelgasinhalasi .= "</tr>";
                    }
                    $tabelgasinhalasi .= "</tbody>";

                    $returnVal['tabelgasinhalasi'] = $tabelgasinhalasi;
                }

                $tabelkristaloid = "";
                $kristaloid = ObatcairanintraanastesiT::model()->findAllByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'sub_jenis' => 'KRISTALOID'));
                if (!empty($kristaloid)) {
                    $tabelkristaloid .= "<tbody>";
                    foreach ($kristaloid as $row) {
                        $tabelkristaloid .= "<tr>";
                        $tabelkristaloid .= "<td><input readonly='readonly' type='text' value='" . $row->nama . "' style='margin-bottom:8px'><br> </td>";
                        $tabelkristaloid .= "</tr>";
                    }
                    $tabelkristaloid .= "</tbody>";

                    $returnVal['tabelkristaloid'] = $tabelkristaloid;
                } else {
                    $returnVal['tabelkristaloid'] = '';
                }

                $tabelkolloid = "";
                $kolloid = ObatcairanintraanastesiT::model()->findAllByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'sub_jenis' => 'KOLLOID'));
                if (!empty($kolloid)) {
                    $tabelkolloid .= "<tbody>";
                    foreach ($kolloid as $row) {
                        $tabelkolloid .= "<tr>";
                        $tabelkolloid .= "<td><input readonly='readonly' type='text' value='" . $row->nama . "' style='margin-bottom:8px'><br> </td>";
                        $tabelkolloid .= "</tr>";
                    }
                    $tabelkolloid .= "</tbody>";

                    $returnVal['tabelkolloid'] = $tabelkolloid;
                } else {
                    $returnVal['tabelkolloid'] = '';
                }
                //WB
                $tabeldarah_wb = "";
                $wb = ObatcairanintraanastesiT::model()->findAllByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'jenis' => 'DARAH', 'sub_jenis' => 'WB'));
                if (!empty($wb)) {
                    $tabeldarah_wb .= "<tbody>";
                    foreach ($wb as $row) {
                        $tabeldarah_wb .= "<tr>";
                        $tabeldarah_wb .= "<td><input readonly='readonly' type='text' value='" . $row->nama . "' style='margin-bottom:8px'>&nbsp;<label>CC</label><br> </td>";
                        $tabeldarah_wb .= "</tr>";
                    }
                    $tabeldarah_wb .= "</tbody>";

                    $returnVal['tabeldarah_wb'] = $tabeldarah_wb;
                } else {
                    $returnVal['tabeldarah_wb'] = '';
                }
                //PRC
                $tabeldarah_prc = "";
                $prc = ObatcairanintraanastesiT::model()->findAllByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'jenis' => 'DARAH', 'sub_jenis' => 'PRC'));
                if (!empty($prc)) {
                    $tabeldarah_prc .= "<tbody>";
                    foreach ($prc as $row) {
                        $tabeldarah_prc .= "<tr>";
                        $tabeldarah_prc .= "<td><input readonly='readonly' type='text' value='" . $row->nama . "' style='margin-bottom:8px'>&nbsp;<label>CC</label><br> </td>";
                        $tabeldarah_prc .= "</tr>";
                    }
                    $tabeldarah_prc .= "</tbody>";

                    $returnVal['tabeldarah_prc'] = $tabeldarah_prc;
                } else {
                    $returnVal['tabeldarah_prc'] = '';
                }
                //FFP
                $tabeldarah_ffp = "";
                $ffp = ObatcairanintraanastesiT::model()->findAllByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'jenis' => 'DARAH', 'sub_jenis' => 'FFP'));
                if (!empty($ffp)) {
                    $tabeldarah_ffp .= "<tbody>";
                    foreach ($ffp as $row) {
                        $tabeldarah_ffp .= "<tr>";
                        $tabeldarah_ffp .= "<td><input readonly='readonly' type='text' value='" . $row->nama . "' style='margin-bottom:8px'>&nbsp;<label>CC</label><br> </td>";
                        $tabeldarah_ffp .= "</tr>";
                    }
                    $tabeldarah_ffp .= "</tbody>";

                    $returnVal['tabeldarah_ffp'] = $tabeldarah_ffp;
                } else {
                    $returnVal['tabeldarah_ffp'] = '';
                }
                //TC
                $tabeldarah_tc = "";
                $tc = ObatcairanintraanastesiT::model()->findAllByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'jenis' => 'DARAH', 'sub_jenis' => 'TC'));
                if (!empty($tc)) {
                    $tabeldarah_tc .= "<tbody>";
                    foreach ($tc as $row) {
                        $tabeldarah_tc .= "<tr>";
                        $tabeldarah_tc .= "<td><input readonly='readonly' type='text' value='" . $row->nama . "' style='margin-bottom:8px'>&nbsp;<label>CC</label><br> </td>";
                        $tabeldarah_tc .= "</tr>";
                    }
                    $tabeldarah_tc .= "</tbody>";

                    $returnVal['tabeldarah_tc'] = $tabeldarah_tc;
                } else {
                    $returnVal['tabeldarah_tc'] = '';
                }
                //PPR
                $tabeldarah_ppr = "";
                $ppr = ObatcairanintraanastesiT::model()->findAllByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'jenis' => 'DARAH', 'sub_jenis' => 'PPR'));
                if (!empty($ppr)) {
                    $tabeldarah_ppr .= "<tbody>";
                    foreach ($ppr as $row) {
                        $tabeldarah_ppr .= "<tr>";
                        $tabeldarah_ppr .= "<td><input readonly='readonly' type='text' value='" . $row->nama . "' style='margin-bottom:8px'>&nbsp;<label>CC</label><br> </td>";
                        $tabeldarah_ppr .= "</tr>";
                    }
                    $tabeldarah_ppr .= "</tbody>";

                    $returnVal['tabeldarah_ppr'] = $tabeldarah_ppr;
                } else {
                    $returnVal['tabeldarah_ppr'] = '';
                }

                $cekEBL = ObatcairanintraanastesiT::model()->findByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'sub_jenis' => "EBL"));
                if (!empty($cekEBL)) {
                    $returnVal["ebl"] = $cekEBL->nama;
                }

                $cekUrin = ObatcairanintraanastesiT::model()->findByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'sub_jenis' => "URIN"));
                if (!empty($cekUrin)) {
                    $returnVal["urin"] = $cekUrin->nama;
                }

                $cekDarah = ObatcairanintraanastesiT::model()->findByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'sub_jenis' => "DARAH"));
                if (!empty($cekDarah)) {
                    $returnVal["darah"] = $cekDarah->nama;
                }

                $cekSI = ObatcairanintraanastesiT::model()->findByAttributes(array('intraanastesi_id' => $cekIntraAnastesi->intraanastesi_id, 'sub_jenis' => "S&I"));
                if (!empty($cekSI)) {
                    $returnVal["s_dan_i"] = $cekSI->nama;
                }
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk menampilkan seluruh data monitoring berdasarkan pasien anastesi yang dipilih
     */
    public function actionSetTableMonitoring() {
        if (Yii::app()->request->isAjaxRequest) {
            $pasienanastesi_id = isset($_POST['id']) ? $_POST['id'] : " ";
            $frame = isset($_POST['frame']) ? $_POST['frame'] : " ";
            $tr = '';
            if (isset($pasienanastesi_id)) {
                $modMonitoring = MonitoringintraanastesiT::model()->findAllByAttributes(array('pasienanastesi_id' => $pasienanastesi_id), array('order' => 'menit_ke ASC'));
                $cekKunjungan = ATInformasipasienanestesiV::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
                if (isset($modMonitoring)) {
                    if (count($modMonitoring) > 0) {
                        $i = 0;
                        foreach ($modMonitoring as $data) {
                            $tr .= $this->renderPartial($this->path_view . '_rowTableMonitoring', array(
                                'data' => $data, 'cekKunjungan' => $cekKunjungan, 'i' => $i++, 'frame' => $frame
                                    ), true);
                        }
                    }
                }
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk menampilkan tombol tambah monitoring berdasarkan pasien anastesi yang dipilih
     */
    public function actionSetTombolTambah() {
        if (Yii::app()->request->isAjaxRequest) {
            $pasienanastesi_id = isset($_POST['id']) ? $_POST['id'] : " ";
            $frame = isset($_POST['frame']) ? $_POST['frame'] : " ";
            $tr = '';
            if (isset($pasienanastesi_id)) {
                $modMonitoring = MonitoringintraanastesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
                $tr .= $this->renderPartial($this->path_view . '_rowTombolTambah', array('model' => $modMonitoring, 'frame' => $frame), true);
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk menghapus baris data pada tabel monitoring intraanestesi
     * @param type $id
     */
    public function actionDelete($id) {

        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;

            if (MonitoringintraanastesiT::model()->deleteByPk($id)) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

}
