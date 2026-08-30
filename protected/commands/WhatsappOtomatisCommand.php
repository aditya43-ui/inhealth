<?php

class WhatsappOtomatisCommand extends CConsoleCommand {

    function actionReminderJanjiPoli() {

        $cr = new CDbCriteria();
        $cr->addCondition("'".date('Y-m-d')."'::date <= tgljadwal::date");
        $cr->addCondition('pendaftaran_id is null');
        $cr->addCondition('whatsapp = true');
        $cr->order = 'tgljadwal asc';

        $data = BuatjanjipoliT::model()->findAll($cr);

        $profil = ProfilrumahsakitM::model()->find();
        $konfig = KonfigsystemK::model()->find();

        
        // var_dump($profil->attributes);
        
        $now = new DateTime(date('Y-m-d H:i:s'));

        foreach ($data as $item) {

            $pasien = PasienM::model()->findByPk($item->pasien_id);
            
            $jadwal = new DateTime($item->tgljadwal);
            $diff = $now->diff($jadwal);
            // var_dump($diff, $diff->days, $diff->h);

            $is_panggil = false;

            if ($diff->days !== false) {

                if ($diff->days == 1 && $diff->h == 0) {
                    $is_panggil = true;
                }

                if ($diff->days == 0 && $diff->h == 6) {
                    $is_panggil = true;
                }
            }

            // $is_panggil = true;

            if ($is_panggil) {
                echo "Panggil...\n";
                $msg = "
Assalamualaikum.Wr.Wb
Terimakasih telah melakukan Perjanjian di ((nama_rs))


Kami mengingatkan bahwa ((nama_pasien)) memiliki perjanjian dengan No Perjanjian ((no_buatjanji)) untuk tanggal kunjungan ((jgljadwal)) Ke ((ruangan_nama)) - ((nama_pegawai)) dengan Nomor Antrian ((no_antrian))


Jangan lupa untuk datang 30 menit sebelum estimasi jadwal yang sudah di tentukan. 

Selalu jaga protokol kesehatan.

*Membawa Surat Rujukan Online dari PPK 1 yang masih berlaku/ RS Tipe C (BPJS)
*Sebelum memasuki rumah sakit Semua pengunjung harus mengisi screening online di link berikut: http://sariasihciputat.com/screening 
*Untuk melihat Live Antrian dapat mengunjungi : https://sariasihgroup.com/salive/antrian 


Terimakasih
Syafakumullah

Wassalamualaikum.Wr.Wb";

                $msg = str_replace("((nama_rs))", $profil->nama_rumahsakit, $msg);
                $msg = str_replace("((nama_pasien))", $pasien->namadepan.$pasien->nama_pasien, $msg);
                $msg = str_replace("((no_rekam_medik))", $pasien->no_rekam_medik, $msg);
                $msg = str_replace("((no_buatjanji))", $item->no_buatjanji, $msg);
                $msg = str_replace("((jgljadwal))", MyFormatter::formatDateTimeForUser($item->tgljadwal), $msg);
                $msg = str_replace("((ruangan_nama))", $item->ruangan->ruangan_nama, $msg);
                $msg = str_replace("((nama_pegawai))", $item->pegawai->namaLengkap, $msg);
                $msg = str_replace("((no_antrian))", $item->ruangan->ruangan_singkatan."-".$item->no_antrianjanji, $msg);

                // echo $msg."\n";

                // $pasien->no_mobile_pasien = "085606615990";
                if (!empty($pasien->no_mobile_pasien)) {
                    echo "Kirim: ".$item->no_buatjanji." - ".$pasien->no_mobile_pasien."\n";
                    $wa = new WhatsApp();
                    $res = $wa->kirimIndividu($pasien->no_mobile_pasien, $msg);

                    // var_dump($res);
                }

                // die;

            }

        }

        

    }

}