<?php
class TindakanAkomodasiPelayananController extends MyAuthController
{
    public $path_view = "billingKasir.views.tindakanAkomodasiPelayanan.";
    public function actionIndex() {
        $modPendaftaran = new BKPendaftaranT();
        $modPasien = new BKPasienM();
        $this->render($this->path_view."index", array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,

        ));
    }

    public function getJsonKunjungan($data)
  {
    $res = $data->attributes;

    $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
    $pj = PenanggungjawabM::model()->findByPk($pendaftaran->penanggungjawab_id);

    $dokterpenerima = "";
    $dpjp1 = "";
    $dpjp2 = "";
    $dpjp3 = "";

    if (!empty($data->pasienadmisi_id)) {
      $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);

      if (!empty($admisi->dokterpenerima_id)) {
        $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
        $dokterpenerima = $peg->namaLengkap;
      }
      if (!empty($admisi->pegawai_id)) {
        $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
        $dpjp1 = $peg->namaLengkap;
      }
      if (!empty($admisi->dpjp2_id)) {
        $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
        $dpjp2 = $peg->namaLengkap;
      }
      if (!empty($admisi->dpjp3_id)) {
        $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
        $dpjp3 = $peg->namaLengkap;
      }
    }

    $res['dpjp1'] = $dpjp1;
    $res['dpjp2'] = $dpjp2;
    $res['dpjp3'] = $dpjp3;
    $res['dokterpenerima'] = $dokterpenerima;

    $res['jeniskasuspenyakit'] = $data->jeniskasuspenyakit_nama;
    $res['namainstalasi'] = $data->instalasi_nama;
    $res['namaruangan'] = $data->ruangan_nama;

    $res['namapasien'] = $data->nama_pasien;
    $res['tanggal_lahir'] = MyFormatter::formatDateTimeForUser($data->tanggal_lahir);

    $kelas = KelaspelayananM::model()->findByPk($data->kelaspelayanan_id);

    $res['kelaspelayanan_id'] = $kelas->kelaspelayanan_nama;
    $res['kelastanggungan'] = null;

    $res['tgl_pendaftaran'] = MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);

    if (!empty($data->no_rekam_medik)) {
      $res['norekammedik'] = $data->no_rekam_medik;
    }

    if (!empty($pendaftaran->asuransipasien_id)) {

      $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);
      
      $kelaspelayanan = Params::KELASPELAYANAN_ID_TANPA_KELAS;
      if(isset($asuransi->kelastanggunganasuransi_id)) {
        $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
        $kelaspelayanan = $kelas->kelaspelayanan_nama;;

      }

      $res['kelastanggungan'] = $kelaspelayanan;
    }

    $res['nama_pj'] = null;
    if (!empty($pj)) {
      $res['nama_pj'] = $pj->nama_pj;
    }


    /*

        $('#FAPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#FAPasienM_nama_pasien').val(data.namapasien);
        $('#FAPasienM_nama_bin').val(data.namabin);
        $('#FAPendaftaranT_carabayar_nama').val(data.carabayar_nama);
        $('#FAPendaftaranT_penjamin_nama').val(data.penjamin_nama);
         */

    return $res;
  }

  function actionCekValidasiPJA() {
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $status = 1;
    if(!empty($pendaftaran_id)) {
      $tindakan = TindakanpelayananT::model()->findByAttributes(array(
        'pendaftaran_id'=>$pendaftaran_id,
        'isapprovaltindaklanjut'=>true,
      ));

      $oa = ObatalkespasienT::model()->findByAttributes(array(
        'pendaftaran_id'=>$pendaftaran_id,
        'isapprovaltindaklanjut'=>true,
      ));

      if (empty($tindakan) && empty($oa)) {
        $status = 0;
      }
    }

    echo json_encode(['status' => $status]);
  }
}
