<?php

class HL7 {

    public $is_hl7 = false;
    public $base_url = "";

    public function __construct() {
        $konfig = KonfigsystemK::model()->find();

        if (!empty($konfig) && $konfig->hl7broker_aktif) {
            $this->is_hl7 = true;
            $this->base_url = $konfig->hl7broker_api_url;
        }
    }

    public function tambahPasien($pasienmasukpenunjang_id, $komentar = "") {

        if (!$this->is_hl7) {
            return true;
        }



        $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
            "pasienmasukpenunjang_id"=>$pasienmasukpenunjang_id,
        ));


        $pemeriksaan = HasilpemeriksaanradT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
        ));

        $peg = PegawaiM::model()->findByPk($penunjang->pegawai_id);

        // var_dump(count($pemeriksaan)); die;

        $ok = true;

        foreach ($pemeriksaan as $item) {

            $rad = PemeriksaanradM::model()->findByPk($item->pemeriksaanrad_id);

            if (empty($rad)) {
                continue;
            }

            $jenis = JenispemeriksaanradM::model()->findByPk($rad->jenispemeriksaanrad_id);

            $data = array(
                "no_rekam_medik"=>empty($penunjang) ? "" : $penunjang->no_rekam_medik,
                "nama_pasien"=>empty($penunjang) ? "" : $penunjang->nama_pasien,
                "tgllahir"=>empty($penunjang) ? "" : MyFormatter::formatDateTimeForDB($penunjang->tanggal_lahir),
                "jeniskelamin"=> empty($penunjang) ? "" : ($penunjang->jeniskelamin == "LAKI-LAKI" ? "M" : "F"),
                "no_pendaftaran"=> empty($penunjang) ? "" :$penunjang->no_pendaftaran,
                "dokterpemeriksa_nama"=>empty($peg) ? "" : $peg->namaLengkap,
                "pemeriksaanrad_nama"=>trim(substr(str_replace("-", " ", $rad->pemeriksaanrad_nama), 0, 16)),
                "pemeriksaanrad_id"=> empty($rad) ? "" : "$rad->pemeriksaanrad_id",
                "pemeriksaanalatrad_kode"=> empty($rad) ? "" :$rad->pemeriksaanrad_kode,
                "hasilpemeriksaanrad_id"=>"$item->hasilpemeriksaanrad_id",
                "pemeriksaanalatrad_aetitle"=>empty($jenis) ? "" : trim(substr(str_replace("-", " ", $jenis->jenispemeriksaanrad_kode), 0, 16)),
                "pemeriksaanalatrad_statname"=>empty($jenis) ? "" : trim(substr(str_replace("-", " ", $jenis->jenispemeriksaanrad_nama), 0, 16)),
                "pemeriksaanalatrad_nama"=> empty($rad) ? "" : $rad->kode_dicom_modality,
                "komentar_teks"=>$komentar,
                "no_kunjunganrad"=>empty($penunjang) ? "" : $penunjang->no_masukpenunjang,
            );


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->base_url."hl7-translator/tambah-pasien",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => CJSON::encode($data),
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => array(
    //                ": ",
                    "Content-Type: application/json",
                    "Cache-Control: no-cache"
                ),
            ));

            $res_raw = curl_exec($curl);


            $res = CJSON::decode($res_raw);

            $ok = $ok && $res !== null && json_last_error() === JSON_ERROR_NONE && $res['response']['status'] == "OK";

        }


        return $ok;


    }

    public function hapusPasien($pasienmasukpenunjang_id, $komentar = "") {
        if (!$this->is_hl7) {
            return true;
        }

        $penunjang = PasienmasukpenunjangT::model()->findByAttributes(array(
            "pasienmasukpenunjang_id"=>$pasienmasukpenunjang_id,
        ));

        $pendaftaran = PendaftaranT::model()->findByPk($penunjang->pendaftaran_id);
        $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);

        $pemeriksaan = HasilpemeriksaanradT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
        ));


        $peg = PegawaiM::model()->findByPk($penunjang->pegawai_id);

        $ok = true;

        foreach ($pemeriksaan as $item) {

            $rad = PemeriksaanradM::model()->findByPk($item->pemeriksaanrad_id);

            if (empty($rad)) {
                continue;
            }

            $jenis = JenispemeriksaanradM::model()->findByPk($rad->jenispemeriksaanrad_id);

            $data = array(
                "no_rekam_medik"=>$pasien->no_rekam_medik,
                "nama_pasien"=>$pasien->nama_pasien,
                "tgllahir"=>MyFormatter::formatDateTimeForDB($pasien->tanggal_lahir),
                "jeniskelamin"=>$pasien->jeniskelamin == "LAKI-LAKI" ? "M" : "F",
                "no_pendaftaran"=>$pendaftaran->no_pendaftaran,
                "dokterpemeriksa_nama"=>$peg->namaLengkap,
                "pemeriksaanrad_nama"=>trim(substr(str_replace("-", " ", $rad->pemeriksaanrad_nama), 0, 16)),
                "pemeriksaanrad_id"=>$rad->pemeriksaanrad_id,
                "pemeriksaanalatrad_kode"=>$rad->pemeriksaanrad_kode,
                "hasilpemeriksaanrad_id"=>$item->hasilpemeriksaanrad_id,
                "pemeriksaanalatrad_aetitle"=>empty($jenis) ? "" : trim(substr(str_replace("-", " ", $jenis->jenispemeriksaanrad_kode), 0, 16)),
                "pemeriksaanalatrad_statname"=>empty($jenis) ? "" : trim(substr(str_replace("-", " ", $jenis->jenispemeriksaanrad_nama), 0, 16)),
                "pemeriksaanalatrad_nama"=>$rad->kode_dicom_modality,
                "komentar_teks"=>$komentar,
                "no_kunjunganrad"=>$penunjang->no_masukpenunjang,
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->base_url."hl7-translator/hapus-pasien",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => CJSON::encode($data),
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => array(
    //                ": ",
                    "Content-Type: application/json",
                    "Cache-Control: no-cache"
                ),
            ));

            $res_raw = curl_exec($curl);

            $res = CJSON::decode($res_raw);

            $ok = $ok && $res !== null && json_last_error() === JSON_ERROR_NONE && $res['response']['status'] == "OK";
        }


        return $ok;

    }

    public function loadDataWeasis($penunjang, $periksa) {
        if (!$this->is_hl7) {
            return array();
        }


        $param = array(
            'accessionNumber'=>$periksa->hasilpemeriksaanrad_id,
            'patientID'=>$penunjang->no_rekam_medik,
        );

        $url = "http://192.168.1.6:8080/weasis-pacs-connector/weasis?".http_build_query($param, '', '&&');

        var_dump($url); die;


    }

}



?>
