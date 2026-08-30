<?php

class JadwalDokterController extends Controller {
    
    public $layout = '//layouts/kiosAntrian';
    
    public function actionIndex() {
        $this->layout = '//layouts/kiosAntrian';

        $model = new SEJadwaldokterV();
        $model->unsetAttributes();

        $prov = $model->searchDashboardJadwal();
        $prov->pagination = false;

        $data = array();
        $ruangans = array();

        foreach ($prov->data as $item) {
            $ruangans[$item->ruangan_nama] = $item->ruangan_nama;
        }

        foreach ($prov->data as $item) {
            $days[$item->jadwaldokter_tgl] = $item->jadwaldokter_hari;
        }

        $pegs = array();
        foreach ($prov->data as $item) {
            $ruangan = $item->ruangan_id;
            $hari = $item->jadwaldokter_hari;
            $pegawai_id = $item->pegawai_id;
            $hari_id = Params::getNumberByDays(strtoupper($hari));
            $waktu = date("H:i", strtotime($item->jadwaldokter_mulai)) . '-' . date("H:i", strtotime($item->jadwaldokter_tutup));
            if (empty($pegs[$pegawai_id])) {
                $peg = PegawaiM::model()->findByPk($pegawai_id);
                $pegs[$pegawai_id] = $peg;
            } else {
                $peg = $pegs[$pegawai_id];
            }

            $path = Params::pathPegawaiTumbsDirectory() . "kecil_" . $peg->photopegawai;

            $data['ruangan'][$ruangan]['ruangan_nama'] = $item->ruangan_nama;
            $data['ruangan'][$ruangan]['det'][$pegawai_id]['url_foto'] = !empty($peg->photopegawai) && file_exists($path) ? Params::urlPegawaiTumbsDirectory() . "kecil_" . $peg->photopegawai : null;
            $data['ruangan'][$ruangan]['det'][$pegawai_id]['nama_pegawai'] = (!empty($item->gelardepan) ? ($item->gelardepan != 'null' ? $item->gelardepan : '') : '').$item->nama_pegawai.(empty($item->gelarbelakang_nama) ? "" : (", ".$item->gelarbelakang_nama));
            $data['ruangan'][$ruangan]['det'][$pegawai_id]['jeniskelamin'] = $peg->jeniskelamin;
            $data['ruangan'][$ruangan]['det'][$pegawai_id]['item_id'][$hari_id]['hari'] = $hari;
            if (empty($data['ruangan'][$ruangan]['det'][$pegawai_id]['item_id'][$hari_id]['jam_proto'])) {
                $data['ruangan'][$ruangan]['det'][$pegawai_id]['item_id'][$hari_id]['jam_proto'] = array();
            }
            $data['ruangan'][$ruangan]['det'][$pegawai_id]['item_id'][$hari_id]['jam_proto'][$waktu] = $waktu;
            $data['ruangan'][$ruangan]['det'][$pegawai_id]['item_id'][$hari_id]['jam'] = implode("<br/>", $data['ruangan'][$ruangan]['det'][$pegawai_id]['item_id'][$hari_id]['jam_proto']);
        }


        $this->render('index', array('tabel' => $data));
    }
    
    
}
