<?php

class ManagerPelayananPasienController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.managerPelayananPasien.';

    public function actionIndex($pendaftaran_id) {
        $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);

        if (isset($_GET['typeinstalasi']) && !empty($_GET['typeinstalasi'])) {
            if ($_GET['typeinstalasi'] == 'RD') {
                $modPendaftaran = RKInfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            } else if ($_GET['typeinstalasi'] == 'RJ') {
                $modPendaftaran = RKInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            } else if ($_GET['typeinstalasi'] == 'RI') {
                $modPendaftaran = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            }
        }
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        
        
        $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruangan_id'=>$modPendaftaran->ruangan_id));
        $diagnosaUtama = "";
        $diagnosaTambahan = "";
        $diagnosa_id = null;

        if(count($pasienMorbid) >0){
            $indexKel2=0;
            $indexKel3=0;

            foreach ($pasienMorbid as $datamorbid){
              $diagnosa_id = $datamorbid->diagnosa_id;
                if($datamorbid->kelompokdiagnosa_id == 2){
                    if($indexKel2 > 0){
                        $diagnosaUtama .= ", ";
                    }
                    $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel2++;
                }

                if($datamorbid->kelompokdiagnosa_id == 3){
                    if($indexKel3 > 0){
                        $diagnosaTambahan .= ", ";
                    }
                    $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel3++;
                }
            }
        }
        $diagnosa_nama = "Diagnosa Utama: ".$diagnosaUtama." \n\n Diagnosa Tambahan: ".$diagnosaTambahan;
        
        

        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'diagnosa_nama' => $diagnosa_nama,
        ));
    }

    public function getUrlSkrinning() {
        return $this->module->id . '/SkrinningT/index';
    }

    public function getUrlEvaluasiAwal() {
        return $this->module->id . '/EvaluasiAwal/index';
    }

    public function getUrlCatatanImplementasi() {
        return $this->module->id . '/CatatanImplementasi/index';
    }

}
