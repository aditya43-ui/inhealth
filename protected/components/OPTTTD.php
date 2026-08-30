<?php

class OPTTTD {
    public static function generateOTP() {

        $res = array(
            'kode'=>null,
            'limit'=>null,
        );

        if (empty(Yii::app()->user)) {
            return false;
        }

        $limit = strtotime('+2 minutes');

        $pegawai_id = Yii::app()->user->getState('pegawai_id');
        $val = str_pad(rand(100000, 999999), 6, "0", STR_PAD_LEFT);

        $pass = hash_hmac("sha256", $val."&".$pegawai_id, Yii::app()->params->seckey."_opt123" ,true);
		$pass1 = base64_encode(password_hash($pass, PASSWORD_DEFAULT, array('cost'=>12)));

        Yii::app()->user->setState('otp_kode', $pass1);
        Yii::app()->user->setState('otp_limit', $limit);

        $res['kode'] = $val;
        $res['limit'] = $limit;

        return $res;
    }

    public static function veifikasiOTP($verifikasi) {

        $pass = Yii::app()->user->getState('otp_kode');
        $limit = Yii::app()->user->getState('otp_limit');
        $pegawai_id = Yii::app()->user->getState('pegawai_id');

        $verifikasi = hash_hmac("sha256", $verifikasi."&".$pegawai_id, Yii::app()->params->seckey."_opt123" ,true);
        $pass = base64_decode($pass);

        // return 0;

        if (time() >= $limit) {
            return 2;
        }

        return password_verify($verifikasi, $pass) ? 0 : 1;

        // var_dump($verifikasi, $pass, $limit, password_verify($verifikasi, $pass)); die;

    }
}