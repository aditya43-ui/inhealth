<?php

/**
 * Bridging Pemanggilan via DB untuk Sysmex
 * @author Deni Hamdani <denihamdani@.com>
 */
class Sysmex {

    const ORDER_CONTROL_TRANSAKSI_BARU = 'NW';
    const ORDER_CONTROL_UPDATE_TRANSAKTI = 'RP';
    const ORDER_CONTROL_BATAL = 'CA';

    const PTYPE_RAWAT_INAP = 'IP';
    const PTYPE_RAWAT_JALAN = 'OP';

    const PRIORITAS_RUTIN = 'R';
    const PRIORITAS_CYTO = 'U';

    public function kirim_tambah($hasilpemeriksaanlab_id, $order_control = null, $dokterperujuk_id = null) {

        if (empty($order_control)) {
            $order_control = Sysmex::ORDER_CONTROL_TRANSAKSI_BARU;
        }

        $cekPeriksa = TrxSysOrder::model()->findByAttributes(array(
            'ono'=>$hasilpemeriksaanlab_id,
        ));

        if ($order_control == Sysmex::ORDER_CONTROL_UPDATE_TRANSAKTI && empty($cekPeriksa)) {
            $order_control = Sysmex::ORDER_CONTROL_TRANSAKSI_BARU;
        }

        $hasil = HasilpemeriksaanlabV::model()->findByAttributes(array(
            'hasilpemeriksaanlab_id'=>$hasilpemeriksaanlab_id,
        ));
        $detail = TindakanpelayananT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$hasil->pasienmasukpenunjang_id
        ));
        $penunjang = PasienmasukpenunjangT::model()->findByPk($hasil->pasienmasukpenunjang_id);
        $kirim = PasienkirimkeunitlainT::model()->findByPk($penunjang->pasienkirimkeunitlain_id);

        $hasil->tglhasilpemeriksaanlab = MyFormatter::formatDateTimeForDB($hasil->tglhasilpemeriksaanlab);

        $res = new TrxSysOrder;
        $res->message_dt = date("YmdHis", strtotime($hasil->tglhasilpemeriksaanlab));
        $res->request_dt = date("YmdHis", strtotime($hasil->tglhasilpemeriksaanlab));
        $res->order_control = $order_control;
        $res->pid = $hasil->no_rekam_medik;
        $res->apid = $hasil->pasien_id;
        $res->pname = $hasil->nama_pasien;
        $res->ptype = empty($hasil->pasienadmisi_id) ? Sysmex::PTYPE_RAWAT_JALAN : Sysmex::PTYPE_RAWAT_INAP;
        $res->birth_dt = date("Ymd", strtotime(MyFormatter::formatDateTimeForDB($hasil->tanggal_lahir)));
        $res->visitno = $hasil->no_pendaftaran;
        $res->priority = Sysmex::PRIORITAS_RUTIN;
        $res->ono = $hasil->hasilpemeriksaanlab_id;  

        // jenis kelamin
        $res->sex = 0;        
        if ($hasil->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
            $res->sex = 1;
        }
        if ($hasil->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN) {
            $res->sex = 2;
        }

        // diagnosa
        $diag = PasienmorbiditasT::model()->findByAttributes(array(
            'pendaftaran_id'=>$hasil->pendaftaran_id,
            'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA,
        ), array(
            'order'=>'pasienmorbiditas_id desc',
        ));
        if (!empty($diag)) {
            $res->comment = strtoupper($diag->diagnosa->diagnosa_kode." - ".$diag->diagnosa->diagnosa_nama);
        }

        // prioritas
        if (!empty($kirim)) {
            $res->request_dt = date("YmdHis", strtotime($kirim->tgl_kirimpasien));
            if ($kirim->is_cyto) {
                $res->priority = Sysmex::PRIORITAS_CYTO;
            }
        }

        // source
        if (!empty($hasil->ruanganasal_id)) {
            $ruangan_source = RuanganM::model()->findByPk($hasil->ruanganasal_id);
        } else {
            $ruangan_source = RuanganM::model()->findByPk($hasil->ruangan_id);
        }
        $res->source = strtoupper($ruangan_source->ruangan_sysmex."^".$ruangan_source->ruangan_nama);
        $res->room_no = $penunjang->ruangan_id;

        // clinician
        /*
        $peg = PegawaiM::model()->findByPk($hasil->pegawai_id);
        if (!empty($peg)) {
            $res->clinician = strtoupper($hasil->pegawai_id."^".trim($peg->namaLengkap));
        }
        */

        if (!empty($kirim)) {
            $peg_rujuk = PegawaiM::model()->findByPk($kirim->pegawai_id);
            $res->clinician = strtoupper($peg_rujuk->kode_sysmex."^".trim($penunjang->dokter_perujuk));
        } else {

            if (empty($dokterperujuk_id)) {
                $dokterperujuk_id = "0";
            }

            if (!empty($penunjang->dokter_perujuk)) {
                $kode_rujuk = "0";

                if ($dokterperujuk_id != 0) {
                    $peg_rujuk = PegawaiM::model()->findByPk($dokterperujuk_id);
    
                    if (!empty($peg_rujuk)) {
                        $kode_rujuk = $peg_rujuk->kode_sysmex;
                    }
                }
                

                $res->clinician = $kode_rujuk."^".strtoupper($penunjang->dokter_perujuk);
            } else {
                $res->clinician = "00^KOSONG";
            }
        }

        // var_dump($res->clinician); die;

        // hitung alamat
        $alamat = str_split($hasil->alamat_pasien, 50);
        $res->address1 = $alamat[0] ?? "";
        $res->address2 = $alamat[1] ?? "";
        $res->address3 = $alamat[2] ?? "";
        $res->address4 = $alamat[3] ?? "";


        // detail hasil
        $kode = array();
        foreach ($detail as $item) {
            // var_dump($item->attributes);
            $periksalab = PemeriksaanlabM::model()->findByAttributes(array(
                'daftartindakan_id'=>$item->daftartindakan_id,
            ));

            if (!empty($periksalab)) {
                if (!in_array($periksalab->pemeriksaanlab_kode, $kode)) {
                    $kode[] = $periksalab->pemeriksaanlab_kode;
                }
            }
        }
        $res->order_testid = implode("~", $kode);
        
        $res->save();

        // var_dump($res->attributes, $res->errors); die;
        // var_dump($penunjang->attributes, $hasil->attributes, $kirim->attributes, count($detail)); die;
    }

    public function loadDetailHasilPeriksa($hasilpemeriksaanlab_id, &$detail) {
        $sysHasil = TrxSysResDt::model()->findAllByAttributes(array(
            'ono'=>$hasilpemeriksaanlab_id
        ));

        foreach ($detail as $item_det) {

            if (!empty($item_det->hasilpemeriksaan) && trim($item_det->hasilpemeriksaan) != "") {
                continue;
            }

            $periksa_det = PemeriksaanlabdetM::model()->findByPk($item_det->pemeriksaanlabdet_id);
            $nilai = NilairujukanM::model()->findByPk($periksa_det->nilairujukan_id);  
            
            if (empty($nilai)) {
                continue;
            }

            foreach ($sysHasil as $item_sys) {
                if ($nilai->trx_sys_kode == $item_sys->test_cd) {
                    $item_det->hasilpemeriksaan = $item_sys->result_value;
                    // var_dump($item_det->attributes, $item_sys->attributes);
                }
            }
        }
    }

}