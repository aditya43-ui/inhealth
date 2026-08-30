<?php

class TampilAntrianPengambilanObatController extends Controller {
    
    public $layout = '//layouts/kiosAntrian';
    
    public function actionIndex() {
        $this->layout = '//layouts/kiosAntrian';

        $model = new FAInformasipenjualanresepV();
        $model->unsetAttributes();

        $prov = $model->searchDashboardPengambilanResep();
        $prov->pagination = false;

        $data = array();
        foreach ($prov->data as $item) {
            $pasien_id = $item->pasien_id;
            $pendaftaran_id = $item->pendaftaran_id;
            $reseptur_id = $item->reseptur_id;

            $racikan = RacikanM::model()->findByPk($item->racikan_id);
            
            // date('d')
            // if(date("d/m/Y",strtotime($item->tglpenyerahan)) == date('d/m/Y')){
                if(empty($item->tglpenyerahan)){

            if (!empty($pasien_id) || !empty($pendaftaran_id) || !empty($reseptur_id) ){



                

                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['nama_pasien'] = $item->nama_pasien;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['no_rekam_medik'] = $item->no_rekam_medik;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['tanggal_lahir'] = $item->tanggal_lahir;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['tglpenyerahan'] = $item->tglpenyerahan;
                // $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['carabayar_nama'] = $item->carabayar_nama;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['tglambilantrian'] = $item->tglambilantrian;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['tgl_pendaftaran'] = $item->tgl_pendaftaran;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['noantrian'] = $item->noantrian;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['ruanganasal_nama'] = $item->ruanganasal_nama;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['gelardepan'] = $item->gelardepan;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['nama_pegawai'] = $item->nama_pegawai;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['gelarbelakang_nama'] = $item->gelarbelakang_nama;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['statusobat'] = $item->statusobat;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['modelantrian_kode'] = $item->modelantrian_kode;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['modelantrian_singkatan'] = $item->modelantrian_singkatan;
                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['reseptur_id'] = $item->reseptur_id;
             

                $antrianFarmasi = AntrianfarmasiT::model()->findByAttributes(array('reseptur_id'=> $reseptur_id));

                if (!empty($antrianFarmasi)) {
                    $racik = RacikanM::model()->findByPK($antrianFarmasi->racikan_id);
                    $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['racikan_singkatan'] = $item->modelantrian_kode . $item->racikan_singkatan;
                } else {
                    $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['racikan_singkatan'] = " ";
                }



                if (!empty($antrianFarmasi)) {
                    $racik = AntrianfarmasiT::model()->findByPK($antrianFarmasi->antrianfarmasi_id);
                    $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['jumlah_dipanggil'] = $item->jumlah_dipanggil;
                } else {
                    $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['jumlah_dipanggil'] = " ";
                }

                if (empty($data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obat'])) {
                    $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obat'] = array();   
                }

                $data['pasien_id'][$pasien_id.'-'.$item->penjualanresep_id]['obat'][] = array(
                    // 'carabayar_id'=>$item->carabayar_id,
                    // 'carabayar_nama'=>$item->carabayar_nama,
                    'noantrian'=>$item->noantrian,
                    'tglambilantrian'=> $item->tglambilantrian,
                    'tgl_pendaftaran'=> $item->tgl_pendaftaran,
                    'racikan_singkatan'=>$item->racikan_singkatan . $item->modelantrian_kode,
                    'modelantrian_singkatan'=>$item->modelantrian_singkatan,
                    'ruanganasal_nama'=>$item->ruanganasal_nama,
                    'gelardepan'=>$item->gelardepan,
                    'jumlah_dipanggil'=>$item->jumlah_dipanggil,
                    'nama_pegawai'=>$item->nama_pegawai,
                    'gelarbelakang_nama'=>$item->gelarbelakang_nama,
                );
            }
        }
        }


        $this->render('index', array('tabel' => $data));
    }
    
    
}
