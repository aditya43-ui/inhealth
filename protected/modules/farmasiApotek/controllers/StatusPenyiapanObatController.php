<?php

class StatusPenyiapanObatController extends Controller {
    
    public $layout = '//layouts/kiosAntrian';
    
    public function actionIndex() {
        $this->layout = '//layouts/kiosAntrian';

        $model = new FAInformasipenjualanresepV();
        $model->unsetAttributes();

        $prov = $model->searchDashboardStatus();
        $prov->pagination = false;

        $data = array();
        foreach ($prov->data as $item) {
            $pasien_id = $item->pasien_id;

            $racikan = RacikanM::model()->findByPk($item->racikan_id);
            
            if (!empty($pasien_id)){
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['nama_pasien'] = $item->nama_pasien;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['antrianfarmasi_id'] = $item->antrianfarmasi_id;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['no_rekam_medik'] = $item->no_rekam_medik;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['tanggal_lahir'] = $item->tanggal_lahir;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obatalkes_nama'] = $item->obatalkes_nama;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['racikan_nama'] = $racikan->racikan_nama;
                //$data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['qty_oa'] = $item->qty_oa;
                //$data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['signa_oa'] = $item->signa_oa;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['statusobat'] = $item->statusobat;

                if (empty($data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obat'])) {
                    $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obat'] = array();   
                }

                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obat'][] = array(
                    'obatalkes_id'=>$item->obatalkes_id,
                    'obatalkes_nama'=>$item->obatalkes_nama,
                    'qty_oa'=>$item->qty_oa,
                    'signa_oa'=>$item->signa_oa,
                    'statusobat'=>$item->statusobat,
                );
            }
        }


        $this->render('index', array('tabel' => $data));
    }
    
    
}
