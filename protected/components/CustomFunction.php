<?php
/**
 * Class CustomFunction untuk menyimpan function PHP yg digunakan umum (semua module)
 * - mencari nilai tertentu
 * - menentukan nilai dari parameter
 */
class CustomFunction
{
	/**
	 * Konversi waktu (H:i:s) menjadi Nilai Integer
	 * @param string $time Waktu yang akan dikonversikan
	 * @return integer Hasil konversi waktu menjadi Nilai Integer.
	 */
	public static function time2int($time) {
		$time = explode(":", $time);
		return ($time[0] * 3600) + ($time[1] * 60) + $time[2];
	}

    public static function alertRekamMedis() {
        $alert = "<script>
                    $(function(){
                        window.parent.myAlert('Pasien sudah ditindak lanjut, dokumen rekam medis tidak bisa ditambahkan!');
                        $('#btn_simpan').attr('disabled', true);
                        $('#simpan_gambar').attr('disabled', true);
                    });
                </script>";

        if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RI || Yii::app()->user->getState('modul_id') == Params::MODUL_ID_ICU) {
            $alert = '';
        }

        return $alert;
    }

	public static function hakAksesHapus($pegawai_login, $ruangan_create, $pegawai_create) {
		$modul_pel = [Params::MODUL_ID_RJ, Params::MODUL_ID_RD, Params::MODUL_ID_RI, Params::MODUL_ID_ICU];
        $ruangan_login = Yii::app()->user->getState('ruangan_id');
        $pegawai_login = $pegawai_login;
        $modul_login = Yii::app()->user->getState('modul_id');

        $bisa_hapus = ((($ruangan_login == $ruangan_create) && ($pegawai_login == $pegawai_create) && in_array($modul_login, $modul_pel)) || ($ruangan_login == $ruangan_create && !in_array($modul_login, $modul_pel))) ? 1 : 0;

		return $bisa_hapus;
	}
	
    /**
     * Menyebarkan notifikasi secara bersamaan.
     * 
     * @author Deni Hamdani <pii.deni.prg@gmail.com>        
     * @param string $judul Judul dari notifikasi
     * @param string $isi Isi/Konten dari notifikasi
     * @param mixed $tujuan Data tujuan yang tiap subarray-nya terdiri dari:
     * - instalasi_id
     * - ruangan_id (bisa dalam bentuk array maupun integer)
     * - modul_id
     * @return boolean Jika sukses menambahkan notifikasi ke tempat tujuan. False 
     * jika sebaliknya.
     * 
     */
    public static function broadcastNotif($judul, $isi, $tujuan) {
        $param = array();
        $param['tglnotifikasi'] = date('Y-m-d H:i:s');
        $param['create_time'] = date('Y-m-d H:i:s');
        $param['create_loginpemakai_id'] = Yii::app()->user->id;
        $param['judulnotifikasi'] = $judul;
        $param['isinotifikasi'] = $isi;
        
        $ok = true;
        foreach ($tujuan as $item) {
            $param['instalasi_id'] = $item['instalasi_id'];
            $param['modul_id'] = $item['modul_id'];
            if (isset($item['pegawai_id'])){
                $param['pegawai_id'] = $item['pegawai_id'];
            }
            
            if (isset($item['keterangan'])){
                $param['keterangan'] = $item['keterangan'];
            }
			
			if (isset($item['link_proses'])){
                $param['link_proses'] = $item['link_proses'];
            }
            
            if (is_array($item['ruangan_id'])) {
                foreach ($item['ruangan_id'] as $ruangan) {
                    $param['create_ruangan'] = $ruangan;
                    $ok = $ok && self::insertNotifikasi($param);
                }
            } else {
                $param['create_ruangan'] = $item['ruangan_id'];
                $ok = $ok && self::insertNotifikasi($param);
            }
        }
        
        return $ok;
    }
	
	/**
     * Menyebarkan notifikasi secara bersamaan.
     * 
     * @author Deni Hamdani <iqbal.laksana@piindonesia.co.id>        
     * @param string $judul Judul dari notifikasi
     * @param string $isi Isi/Konten dari notifikasi
     * @param mixed $tujuan Data tujuan yang tiap subarray-nya terdiri dari:
     * - instalasi_id
     * - ruangan_id (bisa dalam bentuk array maupun integer)
     * - modul_id
     * @return boolean Jika sukses menambahkan notifikasi ke tempat tujuan. False 
     * jika sebaliknya.
     * 
     */
    public static function broadcastNotifCron($judul, $isi, $tujuan) {
        $param = array();
        $param['tglnotifikasi'] = date('Y-m-d H:i:s');
        $param['create_time'] = date('Y-m-d H:i:s');
        $param['create_loginpemakai_id'] = Params::LOGINPEMAKAI_ID_ADMIN;
        $param['judulnotifikasi'] = $judul;
        $param['isinotifikasi'] = $isi;
        if (isset($item['pegawai_id'])){
            $param['pegawai_id'] = $item['pegawai_id'];
        }
        
        $ok = true;
        foreach ($tujuan as $item) {
            $param['instalasi_id'] = $item['instalasi_id'];
            $param['modul_id'] = $item['modul_id'];
            
            if (is_array($item['ruangan_id'])) {
                foreach ($item['ruangan_id'] as $ruangan) {
                    $param['create_ruangan'] = $ruangan;					
                    $ok = $ok && self::insertNotifikasiCron($param);
                }
            } else {				
                $param['create_ruangan'] = $item['ruangan_id'];				
                $ok = $ok && self::insertNotifikasiCron($param);				
            }
        }
        
        return $ok;
    }
    
    
    /**
     * Untuk menambahkan notifikasi  pada cronjon command
     * digunakan juga di semua module
     * @param type $params
     * @return boolean
     */
    public static function insertNotifikasi($params){
        $is_simpan = true;
        $model = new NofitikasiR;
        $model->attributes = $params;

        $criteria = new CDbCriteria;
        $criteria->compare('instalasi_id',$params['instalasi_id']);
        $criteria->compare('modul_id',$params['modul_id']);
        if (isset($params['pegawai_id'])){
            $criteria->compare('pegawai_id',$params['pegawai_id']);
        }
        if (isset($params['keterangan'])){
            $criteria->compare('keterangan',$params['keterangan']);
        }
        $criteria->compare('LOWER(isinotifikasi)',strtolower($params['isinotifikasi']),true);
        $criteria->compare('LOWER(judulnotifikasi)',strtolower($params['judulnotifikasi']),true);
        $criteria->compare('create_ruangan',$params['create_ruangan']);
        $criteria->addCondition("DATE(tglnotifikasi) = DATE(NOW()) AND isread = false");
        $is_exist = NofitikasiR::model()->find($criteria);
        
        $modKonfig = KonfigsystemK::model()->find();
        if ($modKonfig->notifikasi) {
        if(!$is_exist)
        {
            if($model->save()){
                $is_simpan = true;
            }
        }else{
            $attributes = array(
                'update_time' => date('Y-m-d H:i:s'),
                'update_loginpemakai_id' => Yii::app()->user->id,
            );
            $update = $model::model()->updateByPk($is_exist['nofitikasi_id'], $attributes);
            if($update){
                $is_simpan = true;
            }
        }
        }
        return $is_simpan;
    }
	
	 /**
     * Untuk menambahkan notifikasi digunakan pada cronjon command
     * digunakan juga di semua module
     * @param type $params
     * @return boolean
     */
    public static function insertNotifikasiCron($params){
	
        $is_simpan = false;		
        $model = new NotifikasiCron;		
        $model->attributes = $params;		

        $criteria = new CDbCriteria;
        $criteria->compare('instalasi_id',$params['instalasi_id']);
        $criteria->compare('modul_id',$params['modul_id']);
        if (isset($params['pegawai_id'])){
            $criteria->compare('pegawai_id',$params['pegawai_id']);
        }
        $criteria->compare('LOWER(isinotifikasi)',strtolower($params['isinotifikasi']),true);
        $criteria->compare('LOWER(judulnotifikasi)',strtolower($params['judulnotifikasi']),true);
        $criteria->compare('create_ruangan',$params['create_ruangan']);
        $criteria->addCondition("DATE(tglnotifikasi) = DATE(NOW()) AND isread = false");
        $is_exist = NofitikasiR::model()->find($criteria);
        
        $modKonfig = KonfigsystemK::model()->find();
        if ($modKonfig->notifikasi) {
        if(!$is_exist)
        {
            if($model->save()){
                $is_simpan = true;
            }
        }else{
            $attributes = array(
                'update_time' => date('Y-m-d H:i:s'),
                'update_loginpemakai_id' => Params::LOGINPEMAKAI_ID_ADMIN,
            );
            $update = $model::model()->updateByPk($is_exist['nofitikasi_id'], $attributes);
            if($update){
                $is_simpan = true;
            }
        }
        }
        return $is_simpan;
    }
    
    
    /**
     * Menghitung hari antara 2 tanggal
     * @param type $dateFrom
     * @param type $dateTo
     * @return type
     */
    public static function hitungHari($dateFrom,$dateTo=''){
        
        $dateTo = (!empty($dateTo)) ? date('Y-m-d', strtotime($dateTo)) : date('Y-m-d'); // or your date as well
        $dateFrom = date('Y-m-d', strtotime($dateFrom));
        
        // var_dump($dateFrom." - ".$dateTo);
        
        $d1 = new DateTime($dateFrom);
        $d2 = new DateTime($dateTo);
        
        $interval = $d1->diff($d2);
        
        return $interval->format('%a');
        
        //echo floor($dateFrom/(60*60*24))." - ".; die;
        //$datediff = $dateTo - $dateFrom;
        //var_dump($dateTo/(60*60*24)." - ".$dateFrom/(60*60*24));
        //$hari = ceil($dateTo/(60*60*24)) - floor($dateFrom/(60*60*24));
        // return 0; //$hari;
    }
	/**
	 * menghitung lama hari perawatan medis
	 * @param type $dateFrom
	 * @param type $dateTo
	 * @return type
	 */
	public static function hitungHariRawat($dateFrom,$dateTo=''){
        $dateTo = (!empty($dateTo)) ? strtotime($dateTo) : time(); // or your date as well
        $dateFrom = strtotime($dateFrom);
        $datediff = $dateTo - $dateFrom;
        $hari = floor(((float)$datediff)/(60*60*24)) + 1;
        return $hari;
    }
    /**
     * Digunakan di konfigfarmasi_k.formulajasadokter
     * @param type $mathString
     * @return type
     */
    public static function calculate_string( $mathString ){
        $mathString = trim($mathString);     // trim white spaces
        $mathString = preg_replace('/[^0-9\-\+\/\*]/i', '', $mathString);    // remove any non-numbers chars; exception for math operators
        $mathString = (!empty($mathString)) ? $mathString : true;
        $compute = create_function("", "return (" . $mathString . ");" );
        return 0 + $compute();
    }
    
    /**
     *
     * @param  type $data
     * @return type
     */
    public static function getHariByNomorMobile($no) {
        $dt = array(
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            0 => 'Minggu',
        );

        return isset($dt[$no]) ? $dt[$no] : null;
    }
    
    /**
     * Golongan Umur
     * @param float $umur 
     * @return array hasil query tabel golongan umur ($result['golonganumur_id'],$result['golonganumur_nama'])
     */
    public static function getGolonganUmur($tgl_lahir){
        $umur = self::hitungUmur($tgl_lahir);
        $sql = "select golonganumur_id, golonganumur_nama from golonganumur_m where '".ceil((float)$umur)."' between golonganumur_minimal AND golonganumur_maksimal";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result['golonganumur_id'];
    }
    /**
     * Kelompok Umur
     * @param type $umur
     * @return type
     */
    public static function getKelompokUmur($tgl_lahir){
        $umur = self::hitungUmur($tgl_lahir);
        $sql = "select kelompokumur_id, kelompokumur_nama from kelompokumur_m where '".ceil((float)$umur)."' between kelompokumur_minimal AND kelompokumur_maksimal";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result['kelompokumur_id'];
    }
    /**
     * menghtung umur dari tanggal lahir
     * @param type $tgl_lahir
     * @return type
     */
    public static function hitungUmur($tgl_lahir){
        $format = new MyFormatter();
        $tgl_lahir = $format->formatDateTimeForDb($tgl_lahir);
        $today=date("Y-m-d");
		$date1 = new DateTime($tgl_lahir);
		$date2 = new DateTime($today);
		$interval = $date1->diff($date2);
		$umur = str_pad($interval->y, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($interval->m, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($interval->d, 2, '0', STR_PAD_LEFT).' Hr';
        
        return $umur;
    }
    
    public static function hitungTahunBulanHari($dateFrom,$dateTo=''){
        $format = new MyFormatter();
        $tgl_awal = $format->formatDateTimeForDb($dateFrom);
        $today= (!empty($dateTo)?$format->formatDateTimeForDb($dateTo) : date("Y-m-d"));
        
        $date1 = new DateTime($tgl_awal);
        $date2 = new DateTime($today);
        $interval = $date1->diff($date2);
        $umur = str_pad($interval->y, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($interval->m, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($interval->d, 2, '0', STR_PAD_LEFT).' Hr';
        
        return $umur;
    }
    /**
     * menentukan tanggal dari umur (format: 00 Thn 00 Bln 00 Hr)
     * @param type $umur
     * @return type Y-m-d
     */
    public static function getTanggalUmur($umur){
        $umur = explode(' ', $umur);
		$today = date('Y-m-d');
		if(isset($umur[0])&&isset($umur[2])&&isset($umur[4])){
			$thn = $umur[0];
			$bln = $umur[2];
			$hr = $umur[4];

			if($thn=='')$thn=0;if($bln=='')$bln=0;
			$date_calc = strtotime(date("Y-m-d", strtotime($today)) . "-$hr day");
			$date = date("Y-m-d",  $date_calc);
			$date_calc = strtotime(date("Y-m-d", strtotime($date)) . "-$bln month");
			$date = date('Y-m-d', $date_calc);
			$date_calc = strtotime(date("Y-m-d", strtotime($date)) . "-$thn year");
			$date = date('Y-m-d', $date_calc);
		} else {
			$date = date("Y-m-d",  strtotime($today));
		}
        
        return $date;
    }
    /**
     * statuspasien : pasien lama / baru 
     * @param type $modelPasien
     * @return type
     */
    public static function getStatusPasien($modelPasien)
    {
        $sql = "SELECT pendaftaran_id FROM pendaftaran_t WHERE pasien_id = ".$modelPasien->pasien_id;
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $status = (!empty($result)) ? Params::STATUSPASIEN_LAMA : Params::STATUSPASIEN_BARU;
        return $status;
    }
    /**
     * statuskunjungan : kunjungan Lama / Baru
     * @param type $modelPasien
     * @param type $ruangan_id
     * @return type
     */
    public static function getKunjungan($modelPasien, $ruangan_id)
    {
        if(!empty($ruangan_id)){
            $sql = "SELECT pendaftaran_id FROM pendaftaran_t WHERE pasien_id = ".$modelPasien->pasien_id.' AND ruangan_id = '.$ruangan_id;
            $result = Yii::app()->db->createCommand($sql)->queryRow();
            $status = (!empty($result)) ? Params::STATUSKUNJUNGAN_LAMA : Params::STATUSKUNJUNGAN_BARU;
            return $status;
        } else {
            return Params::STATUSKUNJUNGAN_BARU;
        }
    }
    /**
     * Menampilkan Umur 
     * @param type $tglLahir
     * @return string [23 Thn 02 Bln 15 Hr]
     */
    public static function getUmur($tglLahir)
    {
        $format = new MyFormatter;
        $tglLahir = $format->formatDateTimeForDb($tglLahir);
        $dob=$tglLahir; $today=date("Y-m-d");
        list($y,$m,$d)=explode('-',$dob);
        list($ty,$tm,$td)=explode('-',$today);
        if($td-$d<0){
            $day=($td+30)-$d;
            $tm--;
        }
        else{
            $day=$td-$d;
        }
        if($tm-$m<0){
            $month=($tm+12)-$m;
            $ty--;
        }
        else{
            $month=$tm-$m;
        }
        $year=$ty-$y;

        $umur = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
        
        return $umur;
    }

    /**
     * menampilkan module-module yang ada
     * @return type
     */
    public static function getModules()
    {
        $moduls = Yii::app()->metadata->getModules();
        foreach($moduls as $i=>$modul){
            $result[$modul] = $modul;
        }
        
        return $result;
    }
    
    /**
     * menampilkan controller dari module
     * @param type $namaModul 
     */
    public static function getControllers($namaModul)
    {        
        $controllers = Yii::app()->metadata->getControllers($namaModul);
        foreach($controllers as $i=>$controller){
            $controller = str_replace('Controller', '', $controller);
            $result[$controller] = $controller;
        }
        
        return $result;
    }
    
    /**
     * manempilkan action dari controller dan module
     * @param type $contorllerId
     * @param type $namaModul 
     */
    public static function getActions($contorllerId, $namaModul)
    {
        $result = array();
        $actions = Yii::app()->metadata->getActions(ucfirst($contorllerId).'Controller', $namaModul);
        foreach($actions as $i=>$action){
            $result[$action] = $action;
        }
        
        return $result;
    }
    
    /**
     * menampilkan list ukuran kertas
     * @return array
     */
    public static function getUkuranKertas()
    {
        $daftar = array(
            'A3'=>'A3',
            'A4'=>'A4',
            'A5'=>'A5',
        );
        asort($daftar);
        return $daftar;
    }
    /**
     * menampilkan list posisi kertas
     * @return string
     */
    public static function getPosisiKertas()
    {
        $daftar = array(
            'L'=>'Landscape',
            'P'=>'Portrait',
        );
        asort($daftar);
        return $daftar;
    }
    
    
    /**
     * menampilkan list status konfirmasi booking
     * @return array
     */
    public static function getStatusKonfirmasiBooking()
    {
        $statuskonfirmbooking = array(
            Params::STATUSKONFIRMASI_BOOKING_SUDAH=>'SUDAH KONFIRMASI',
            Params::STATUSKONFIRMASI_BOOKING_BELUM=>'BELUM KONFIRMASI',
            Params::STATUSKONFIRMASI_BOOKING_BATAL=>'BATAL BOOKING',
        );
        asort($statuskonfirmbooking);
        return $statuskonfirmbooking;
    }
    
    /**
     * menampilkan list status konfirmasi berdasarkan pendaftaran_t
     * @return array
     */
    public static function getStatusKonfirmasi()
    {
        $statusKonfirmasi = array(
            Params::STATUSKONFIRMASI_SUDAH=>'SUDAH DIKONFIRMASI',
            Params::STATUSKONFIRMASI_BELUM=>'BELUM DIKONFIRMASI',
        );
        asort($statusKonfirmasi);
        return $statusKonfirmasi;
    }
    
    /**
     * Menampilkan list nama hari
     * @return string
     */
    public static function getNamaHari()
    {
        $namaHari = array(
			'MINGGU'=>'Minggu',
            'SENIN'=>'Senin',
            'SELASA'=>'Selasa',
            'RABU'=>'Rabu',
            'KAMIS'=>'Kamis',
            'JUMAT'=>'Jumat',
            'SABTU'=>'Sabtu',            
        );
        return $namaHari;
    }
    
    /**
     * menampilkan semua tahun dari $sebelumthn tahun sampai $setelahthn tahun dari tahun sekarang
     * @param type $sebelumthn
     * @param type $setelahthn
     */
    public static function getTahun($sebelumthn = null, $setelahthn = null){
        $rangeArr = range(2000,date("Y"));
        if(isset($sebelumthn) && empty($setelahthn))
            $rangeArr = range(date("Y", strtotime("-".$sebelumthn." years")),date("Y"));
        else if(empty($sebelumthn) && isset($setelahthn))
            $rangeArr = range(date("Y"),date("Y", strtotime("+".$setelahthn." years")));
        else if(isset($setelahthn) && isset($setelahthn))
            $rangeArr = range(date("Y", strtotime("-".$sebelumthn." years")),date("Y", strtotime("+".$setelahthn." years")));
        
        $tahunArr = array();
        foreach($rangeArr as $value){
            $tahunArr[$value] = $value;
        }
        return $tahunArr;
    }

     /**
     * menampilkan semua bulan
     */
    public static function getBulan(){
        $bulan = array(
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember'
            );
        return $bulan;
    }
    
     /**
     * menampilkan semua bulan
     */
    public static function getBulan3Digit(){
        $bulan = array(
                        '01' => 'Jan',
                        '02' => 'Feb',
                        '03' => 'Mar',
                        '04' => 'Apr',
                        '05' => 'Mei',
                        '06' => 'Jun',
                        '07' => 'Jul',
                        '08' => 'Agu',
                        '09' => 'Sep',
                        '10' => 'Okt',
                        '11' => 'Nov',
                        '12' => 'Des'
            );
        return $bulan;
    }

    /**
     * menampilkan list angka dari $dari sampai $sampai
     * @param type $dari
     * @param type $sampai
     * @return array
     */
    public static function getDaftarAngka($dari = 1, $sampai = 20)
    {
        for ($i = $dari; $i <= $sampai; $i++) {
            $angka[$i] = $i;
        } 
        return $angka;
    }
    /**
     * menampilkan urutan dari angka kedalam text
     * @param type $dari
     * @param type $sampai
     * @return array | ex: [3]=>"ketiga"
     */
    public static function getNomorUrutText($dari = 1, $sampai = 20){
        $format = new MyFormatter();
        for ($i = $dari; $i <= $sampai; $i++) {
            $angka[$i] = "Ke".$format->kataTerbilang($i);
        } 
        return $angka;       
    }
    /**
     * menampilkan list status bayar
     * @return array | sudah = true, belum = false
     */
    public static function getStatusBayar(){
        return array(
            false=>'Belum Bayar',
            true=>'Sudah Bayar',
        );
    }
    
    /*
     * Params ubah angka ke Romawi 
     */
    public static function Romawi($n){
		$n=(int)$n;
        $hasil = "";
        $iromawi =
        array("","I","II","III","IV","V","VI","VII","VIII","IX","X",
        20=>"XX",30=>"XXX",40=>"XL",50=>"L",60=>"LX",70=>"LXX",80=>"LXXX",
        90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",
        600=>"DC",700=>"DCC",800=>"DCCC",900=>"CM",1000=>"M",
        2000=>"MM",3000=>"MMM");

            if(array_key_exists($n,$iromawi)){
            $hasil = $iromawi[$n];
            }elseif($n >= 11 && $n <= 99){
            $i = $n % 10;
            $hasil = $iromawi[$n-$i] . self::Romawi($n % 10);
            }elseif($n >= 101 && $n <= 999){
            $i = $n % 100;
            $hasil = $iromawi[$n-$i] . self::Romawi($n % 100);
            }else{
            $i = $n % 1000;
            $hasil = $iromawi[$n-$i] . self::Romawi($n % 1000);
        }
        return $hasil;
    }
    
	/**
	 * Menggabungkan 2 array
	 * @param type $array_a : format([i]=>array([key]=>value))
	 * @param type $array_b : format([i]=>array([key]=>value))
	 * @param type $fkey = foreign key (acuan dalam penggabungan array)
	 * @return type
	 */
	public static function joinTwo2DArrays($array_a, $array_b, $fkey){
		//switch ke array yg lebih lengkap nilainya untuk dijadikan acuan
		if(count($array_b) > count($array_a)){
			$array_temp = $array_a;
			$array_a = $array_b;
			$array_b = $array_temp;
		}
		if(count($array_a) > 0 && count($array_b) > 0){
			foreach($array_a AS $i => $data_a){
				foreach($array_b AS $ii => $data_b){
					if($array_a[$i][$fkey] == $array_b[$ii][$fkey]){
						if(count($array_b[$ii]) > 1){
							foreach($array_b[$ii] AS $iii => $attr){
								$array_a[$i][$iii] = $array_b[$ii][$iii];
							}
						}
					}
				}
			}
		}
		
		return $array_a;
	}
	/**
	 * konversi character tertentu ke simbol yang diinginkan
	 * @param type $string
	 * @return type
	 */
	public static function symbolsConverter($string){
		//== 1. replace ^($string) to <sup>($string)</sup> ==
		$value = preg_replace("/\^(\w*)/", "<sup>$1</sup>", $string);
		
		return $value;
	}
	
	/**
	 * kirim data php socket ke telnet (untuk dimasukkan ke led matrix)
	 * MIC-91
	 */
	public static function postTelnet($data){
		if(Yii::app()->user->getState('is_telnetaktif')){
			$address = Yii::app()->user->getState('telnet_host');
			$port = Yii::app()->user->getState('telnet_port');
			$socket = socket_create(AF_INET, SOCK_STREAM, 0) OR FALSE;
			if($socket){
				if(socket_connect($socket, $address, $port)){
					socket_write($socket, $data);
					socket_close($socket);
				}
			}
		}
	}
    
    /**
     * kirim data php socket ke komputer menerima, yang kemudian diolah untuk ditampilkan
     * ke papan antrian tertentu.
     *  
     * @param type $ruangan_id
     */
    public static function postSerialPanggilanRuangan($no_antrian, $ruangan_id) {
        $serialruangan = PapanantrianserialruanganM::model()->findByAttributes(array(
            'ruangan_id'=>$ruangan_id,
        ));
        
        $data = $serialruangan->serial_id." ".$no_antrian; 
        $address = $serialruangan->ip_address;
        $port = $serialruangan->ip_port;
        
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) OR FALSE;
        
        if($socket) {
            if(socket_connect($socket, $address, $port)){
                socket_write($socket, $data);
                socket_close($socket);
            }
        }
    }
		
	/**
	 * kirim php socket untuk HL-7 Broker
	 * RND-8272
	 * $data = string
	 * $prefix = 'ADD' (untuk menambahkan) / 'DEL' (untuk menghapus)
	 */
	public static function postHL7Broker($prefix="ADD", $data=''){
		$data = $prefix."+".$data."\n";
		if(Yii::app()->user->getState('hl7broker_aktif')){
			$address = Yii::app()->user->getState('hl7broker_host');
			$port = Yii::app()->user->getState('hl7broker_port');
			$socket = socket_create(AF_INET, SOCK_STREAM, 0) OR FALSE;
			if($socket){
				if(socket_connect($socket, $address, $port)){
					socket_write($socket, $data);
					socket_close($socket);
				}
			}
		}
	}
        
        public static function incPortFinger($ip){
            $split = explode('.', $ip); // pecah ip contoh 192.168.0.52,  192 = [0], 168 = [1], 0 = [2],  52 = [3]            
            $length = strlen($split[3]);
            $port = Yii::app()->user->getState('telnet_port'); // contoh port 6000
            $satuan = substr($port, 0, 1); // dari port yang diambil menjadi 6
            $puluhan = substr($port, 0, 2); // dari port yang diambil menjadi 60
            $ratusan = substr($port, 0, 3); // dari port yang diambil menjadi 600
            
            $portBaru = '';            
            if ($length == 1){
                $portBaru = $ratusan.$split[3];
            }elseif ($length == 2){
                if ($split[3] > 63){
                    $k = $split[3]-63;
                    $br = strlen($k)==1?'0'.$k:$k;
                    $portBaru = $puluhan.$br;
                }else{
                    $portBaru = $puluhan.$split[3];
                }
            }elseif ($length == 3){                
                if ( ($split[3] > 99) && ($split[3] <= 126) ){
                    $k = $split[3]-63;
                    $br = strlen($k)==1?'0'.$k:$k;
                    $portBaru = $puluhan.$br;
                }elseif ( ($split[3] >= 127) && ($split[3] <= 190) ){
                    $k = $split[3]-127;
                    $br = strlen($k)==1?'0'.$k:$k;
                    $portBaru = $puluhan.$br;
                }elseif ( ($split[3] >= 191 ) && ($split[3] <= 253) ) {
                    $k = $split[3]-190;
                    $br = strlen($k)==1?'0'.$k:$k;
                    $portBaru = $puluhan.$br;
                }else{
                    $k = $split[3]-253;
                    $br = strlen($k)==1?'0'.$k:$k;
                    $portBaru = $puluhan.$br;
                }
            }
            
            return $portBaru;
                
        }
        
        public static function runAjaxF($controller, $post) {
		if (isset($post['ajax'])) {
			if (isset($post['param'])) call_user_func(array($controller, $post['f']), $post['param']);
			else call_user_func(array($controller, $post['f']));
			Yii::app()->end();
		}
	}
	
	public static function time_since($since) {
            if($since < 0){
                $since = abs((float)$since);
            }
            
			$chunks = array(
				array(60 * 60 * 24 * 365 , 'year'),
				array(60 * 60 * 24 * 30 , 'month'),
				array(60 * 60 * 24 * 7, 'week'),
				array(60 * 60 * 24 , 'day'),
				array(60 * 60 , 'hour'),
				array(60 , 'minute'),
				array(1 , 'second')
			);

			for ($i = 0, $j = count($chunks); $i < $j; $i++) {
				$seconds = $chunks[$i][0];
				$name = $chunks[$i][1];
				if (($count = floor($since / $seconds)) != 0) {
					break;
				}
			}
//$print = $since;
		$print = ($count == 1) ? '1 '.  CustomFunction::ubah_bahasa_waktu($name).' yang lalu' : $count.' '. CustomFunction::ubah_bahasa_waktu($name)." yang lalu";
		return $print;
		
	}
	
	public static function ubah_bahasa_waktu($waktu){
		$dt = array(
			'second' => 'detik',
			'minute' =>  'menit',
			'hour' => 'jam',
			'day' => 'hari',
			'month' => 'bulan',
			'year' => 'tahun',
                        'week' => 'minggu'
		);
		
		return $dt[$waktu];
	}
	
	public static function getWeek(){
		return array(
			date('Y-m-d', strtotime(" +1 weeks ")), // 1 minggu kedepan dihitung dari hari sekarang
			date('Y-m-d', strtotime(" +2 weeks ")),
			date('Y-m-d', strtotime(" +3 weeks ")),
			date('Y-m-d', strtotime(" +4 weeks ")),
			);
	}
	
	public static function getAttributeTooltip($model, $attribute){
		$labels = $model->attributeTooltips();
        if (isset($labels[$attribute])){
            return $labels[$attribute];
		}else if (strpos($attribute, '.') !== false) {
            $segs = explode('.', $attribute);
            $name = array_pop($segs);
            
            foreach ($segs as $seg) {
                $relations = $model->getMetaData()->relations;
                if (isset($relations[$seg]))
                    $model = CActiveRecord::model($relations[$seg]->className);
                else
                    break;
            }
            return $model->getAttributeLabel($name);
        } else{
            return $model->generateAttributeLabel($attribute);
		}
	}
        
        /**
         * - digunakan untuk mengenerate dari 2 variable tanggal untuk mendapatkan total bulan
         * @param type $start
         * @param type $end
         * @return type
         */
        public static function getTotalBulan($start, $end){
            $date1 = $end;
            $date2 = $start;
                        
            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);

            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);

            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);

            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
            
            return $diff;
        }
        
        public static function getSelisihJam($start, $end){
            $jamMulai = explode(":", $start);
            $jamAkhir = explode(":", $end);

            if ($jamMulai[0] > $jamAkhir[0]){
                $awal  = strtotime(date('Y-m-d').' '.$start);
                $akhir = strtotime(date('Y-m-d', strtotime("+1 days")).' '.$end);
            }else{
                $awal  = strtotime(date('Y-m-d').' '.$start);
                $akhir = strtotime(date('Y-m-d').' '.$end);
            }
            
            $diff  = $akhir - $awal;

            $jam   = floor($diff / (60 * 60));
            $menit = floor($diff - $jam * (60 * 60))/60;
            
            return array(
                'jam' => $jam,
                'menit' => $menit
            );
        }
                
	public static function getDecimal($number,$decimal){
		$int = 10 * $decimal;
		
		return floor((float)$number*$int)/$int;
	}
	
	/**
	* Menampilkan Umur dalam tahun
	* @param type $tglLahir
	* @return string [23]
	*/
    public static function getUmurTahun($tglLahir,$tglDaftar)
    {
        $format = new MyFormatter;
        $tglLahir = date('Y-m-d',strtotime($format->formatDateTimeForDb($tglLahir)));
        $tglDaftar = date('Y-m-d',strtotime($format->formatDateTimeForDb($tglDaftar)));
        $dob=$tglLahir; $today=$tglDaftar;
        list($y,$m,$d)=explode('-',$dob);
        list($ty,$tm,$td)=explode('-',$today);
        if($td-$d<0){
            $day=($td+30)-$d;
            $tm--;
        }
        else{
            $day=$td-$d;
        }
        if($tm-$m<0){
            $month=($tm+12)-$m;
            $ty--;
        }
        else{
            $month=$tm-$m;
        }
        $year=$ty-$y;

        $umur = str_pad($year, 2, '0', STR_PAD_LEFT);
        
        return $umur;
    }
	
	/**
	 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @param type $val
	 * @return type
	 */
	public static function isDecimal( $val )
	{
		return is_numeric( $val ) && floor( (float)$val ) != $val;
	}
        
    /**
    * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
    * @param type $val
    * @return type
    */
   public static function saveError($error)
   {            
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip_client = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip_client = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                    $ip_client = $_SERVER['REMOTE_ADDR'];                                                    
            }                        
       
            //$cekReport = ReportbugsR::model()->findByAttributes(array('link_bugs'=>$actual_link,'kodebugs'=>$error->getCode(),'type_bugs'=>get_class($error)));
            $ok = true;
            //if(!$cekReport){
                    $model = new ReportbugsR;
                    $model->kodebugs = $error->getCode();
                    $model->judul_bugs = substr($error->getMessage(),0,190);
                    $model->pesan_bugs = $error->getMessage()."<br>".$error->getTraceAsString();
                    $model->link_bugs = $actual_link;
                    $model->type_bugs = get_class($error);
                    $model->file_bugs = $error->getFile();
                    $model->line_bugs = $error->getLine();
                    $model->prioritas_bugs = (($model->kodebugs == '404') ? 1 : 2);
                    $model->isajax_bugs = Yii::app()->request->isAjaxRequest;
                    if(isset(Yii::app()->user->id)){
                            $model->create_login_id = Yii::app()->user->id;
                            $model->create_login_nama = Yii::app()->user->getState('nama_pemakai');
                            $model->create_pegawai_id = Yii::app()->user->getState('pegawai_id');
                            $model->create_instalasi_id = Yii::app()->user->getState('instalasi_id');
                            $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                            $model->create_modul_id = (isset(Yii::app()->session['modul_id']) ? Yii::app()->session['modul_id'] : null);
                    }else{
                            $model->create_login_nama = "mobile";
                    }
                    $model->create_hostname_pc = $ip_client;
                    $model->create_browser_pc = $_SERVER['HTTP_USER_AGENT'];
                    $model->create_datetime = date("Y-m-d H:i:s");
                    $ok = $ok && $model->save();
                   
            //}
            
            return $ok; 
   }
   
    /**
     * rumus hasil kesimpulan uji golongan darah
     * @param type $arr
     * @return string
     */
    public static function ujiGolDarah($arr){
        
        $dt = '';
        
        $anti_a = $arr['anti_a'];
        $anti_b = $arr['anti_b'];
        $anti_d = $arr['anti_d'];
        
        $plus = Params::PENGUJIAN_GOLDARAH_POSITIF;
        $minus = Params::PENGUJIAN_GOLDARAH_NEGATIF;
                        
        if ($anti_a == $plus && $anti_b == $minus && $anti_d == $plus){
            $dt = 'A Positif';//baris 1
        }elseif ($anti_a == $plus && $anti_b == $minus && $anti_d == $minus){
            $dt = 'A Negatif';//baris 2
        }elseif ($anti_a == $minus && $anti_b == $plus && $anti_d == $plus){
            $dt = 'B Positif';//baris 3
        }elseif ($anti_a == $minus && $anti_b == $plus && $anti_d == $minus){
            $dt = 'B Negatif';//baris 4
        }elseif ($anti_a == $plus && $anti_b == $plus && $anti_d == $plus){
            $dt = 'AB Positif';//baris 5
        }elseif ($anti_a == $plus && $anti_b == $plus && $anti_d == $minus){
            $dt = 'AB negatif';//baris 6
        }elseif ($anti_a == $minus && $anti_b == $minus && $anti_d == $plus){
            $dt = 'O Positif';//baris 7
        }elseif ($anti_a == $minus && $anti_b == $minus && $anti_d == $minus){
            $dt = 'O Negatif';//baris 7
        }
        
        return $dt;
    }
    
    /**
     * rumus hasil kesimpulan uji konfirmasi golongan darah
     * @param type $arr
     * @return string
     */
    public static function ujiKonfirmasiGolDarah($arr){
        
        $gol_darah = '';
        $rhesus = '';
        $status = '';
        $nama_rhesus = '';
        
        $group_gol_darah = '';
        $group_rhesus = '';
        $group_nama_rhesus = '';
        
        $typing_gol_darah = '';
        $typing_rhesus = '';
        $typing_nama_rhesus = '';
        
        $anti_a = $arr['anti_a'];
        $anti_b = $arr['anti_b'];
        $anti_d = $arr['anti_d'];
        $anti_ab = $arr['anti_ab'];
        
        $group_gol_darah = '';
        $group_rhesus = '';
        $group_nama_rhesus = '';
        
        $sel_a = $arr['sel_a'];
        $sel_b = $arr['sel_b'];
        $sel_o = $arr['sel_o'];
        
        $metode = isset($arr['metode'])?$arr['metode']:null;
        
        $metode_untuk = isset($arr['metode_untuk'])?$arr['metode_untuk']:null;
        
        $plus = Params::PENGUJIAN_GOLDARAH_POSITIF;
        $minus = Params::PENGUJIAN_GOLDARAH_NEGATIF;                
                       
        if ($anti_a == $plus && $anti_b == $minus && $anti_ab == $plus && $anti_d == $plus){            
            $group_gol_darah = 'A';//baris 1
            $rhesus = Params::RHESUS_POSITIF;//baris 1
            $nama_rhesus = $plus;//baris 1
        }elseif ($anti_a == $plus && $anti_b == $minus && $anti_ab == $plus && $anti_d == $minus){            
            $group_gol_darah = 'A';//baris 2
            $rhesus = Params::RHESUS_NEGATIF;//baris 2
            $nama_rhesus = $minus;//baris 2
        }elseif ($anti_a == $minus && $anti_b == $plus && $anti_ab == $plus && $anti_d == $plus){            
            $group_gol_darah = 'B';//baris 3
            $rhesus = Params::RHESUS_POSITIF;//baris 3
            $nama_rhesus = $plus;//baris 3
        }elseif ($anti_a == $minus && $anti_b == $plus && $anti_ab == $plus && $anti_d == $minus){            
            $group_gol_darah = 'B';//baris 4
            $rhesus = Params::RHESUS_NEGATIF;//baris 4
            $nama_rhesus = $minus;//baris 4
        }elseif ($anti_a == $plus && $anti_b == $plus && $anti_ab == $plus && $anti_d == $plus){            
            $group_gol_darah = 'AB';//baris 5
            $rhesus = Params::RHESUS_POSITIF;//baris 5
            $nama_rhesus = $plus;//baris 5
        }elseif ($anti_a == $plus && $anti_b == $plus && $anti_ab == $plus && $anti_d == $minus){            
            $group_gol_darah = 'AB';//baris 6
            $rhesus = Params::RHESUS_NEGATIF;//baris 6
            $nama_rhesus = $minus;//baris 6
        }elseif ($anti_a == $minus && $anti_b == $minus && $anti_ab == $minus && $anti_d == $plus){            
            $group_gol_darah = 'O';//baris 7
            $rhesus = Params::RHESUS_POSITIF;//baris 7
            $nama_rhesus = $plus;//baris 7
        }elseif ($anti_a == $minus && $anti_b == $minus && $anti_ab == $minus && $anti_d == $minus){            
            $group_gol_darah = 'O';//baris 8
            $rhesus = Params::RHESUS_NEGATIF;//baris 8
            $nama_rhesus = $minus;//baris 8
        }else{
            if ($metode == Params::METODE_DARAH_ID_TUBE_TEST){                   
                $status = Params::KESIMPULAN_GOLDARAH_TIDAK;
            }            
        }
                
        
        if ($sel_a == $minus && $sel_b == $plus && $sel_o == $minus){
            $typing_gol_darah = 'A';//baris 1            
        }elseif ($sel_a == $plus && $sel_b == $minus && $sel_o == $minus){            
            $typing_gol_darah = 'B';//baris 4            
        }elseif ($sel_a == $minus && $sel_b == $minus && $sel_o == $minus){            
            $typing_gol_darah = 'AB';//baris 6            
        }elseif ($sel_a == $plus && $sel_b == $plus && $sel_o == $minus){            
            $typing_gol_darah = 'O';//baris 8            
        }else{
            if ($metode == Params::METODE_DARAH_ID_TUBE_TEST){                   
                $status = Params::KESIMPULAN_GOLDARAH_TIDAK;
            }            
        }
        
        if ($metode_untuk == 'komponen'){
            if (!empty($group_gol_darah)){
                $gol_darah = $group_gol_darah;                                        
            }else{
                $gol_darah = $typing_gol_darah;                                        
            }
        }else{        
            
            if (!empty($typing_gol_darah) && !empty($group_gol_darah)){
                if ($typing_gol_darah == $group_gol_darah){                    
                    $gol_darah = $group_gol_darah;                                        
                }
              
            }
        }
        
        return array(
            'gol_darah' => $gol_darah,
            'rhesus' => $rhesus,
            'nama_rhesus' => $nama_rhesus,
            'status' => $status
        );
    }
    
    /**
     * rumus hasil kesimpulan pengujian kompatibilitas
     * @param type $arr
     * @return string
     */
    public static function ujiSilangSerasi($arr){
        
        $kesimpulan = '';
        $pilihan = LookupM::getItemsUrutan('rilis');
        
        $mayor = Params::cekUjiKompatibilitas($arr['mayor']);
        $minor = Params::cekUjiKompatibilitas($arr['minor']);
        $autocontrol = Params::cekUjiKompatibilitas($arr['autocontrol']);
        $dct = Params::cekUjiKompatibilitas($arr['dct']);                
               
        $plus = Params::PENGUJIAN_GOLDARAH_POSITIF;
        $minus = Params::PENGUJIAN_GOLDARAH_NEGATIF;                
                       
        if ($mayor == $minus && $minor == $minus && $autocontrol == $minus){// && $dct == $minus
            $kesimpulan = Params::KESIMPULAN_UJI_KOMPATIBILITAS_KOMPATIBEL;
            $pilihan = array(
                Params::STATUS_UJI_KOMPATIBILITAS_RELEASE => Params::STATUS_UJI_KOMPATIBILITAS_RELEASE,
            );
        }elseif ($mayor == $minus && $minor == $plus && $autocontrol == $plus){// && $dct == $plus
            $kesimpulan = Params::KESIMPULAN_UJI_KOMPATIBILITAS_INKOMPATIBEL;
            $pilihan = array(
                Params::STATUS_UJI_KOMPATIBILITAS_STOP => Params::STATUS_UJI_KOMPATIBILITAS_STOP,
                Params::STATUS_UJI_KOMPATIBILITAS_RELEASE => Params::STATUS_UJI_KOMPATIBILITAS_RELEASE,
            );
        }elseif ($mayor == $plus && $minor == $minus && $autocontrol == $minus){// && $dct == $minus
            $kesimpulan = Params::KESIMPULAN_UJI_KOMPATIBILITAS_INKOMPATIBEL;
            $pilihan = array(
                Params::STATUS_UJI_KOMPATIBILITAS_STOP => Params::STATUS_UJI_KOMPATIBILITAS_STOP,                
            );
        }elseif ($mayor == $plus && $minor == $plus && $autocontrol == $plus){// && $dct == $plus
            $kesimpulan = Params::KESIMPULAN_UJI_KOMPATIBILITAS_INKOMPATIBEL;
            $pilihan = array(
                Params::STATUS_UJI_KOMPATIBILITAS_STOP => Params::STATUS_UJI_KOMPATIBILITAS_STOP,
                Params::STATUS_UJI_KOMPATIBILITAS_RELEASE => Params::STATUS_UJI_KOMPATIBILITAS_RELEASE,
            );
        }
        
        return array(            
            'pilihan' => $pilihan,
            'kesimpulan' => $kesimpulan
        );
    }
    
     /**
     * mengelompokkan kategori suara
     * @param type $huruf
     * @return string
     */
    public static function pengelompokkanFile($huruf){
        $alphabetRange = range('a', 'z');
        $arrAlpha = array();
        foreach ($alphabetRange as $letter)
        {
          $arrAlpha[] = $letter;
        }
        
        $arrAngka = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas","ribu","seribu","seratus","");
        
        
        
        if (in_array($huruf, $arrAlpha)){
            $kel = 'Huruf Alphabet';
        }elseif (in_array($huruf, $arrAngka) || is_numeric($huruf)){
            $kel = 'Bilangan Angka';
        }else{
            $kel = 'Kalimat';
        }
        
        return $kel;
    }
    
    /**
     * 
     * - digunakan untuk mengubah menjadi ceklis
     * @param type $nilai
     * @param type $excel
     * @return string
     */
    public static function set_pilihan_ceklis($nilai, $excel=false, $noncheckbox = false){
            
        if ($excel){
            if ($nilai){
                $value = 'V';
            }else{
                $value = 'X';
            }
            
            $data = $value;
        }else{            
            if (!$noncheckbox){
                $icon = '<span  style="font-size:15px;font-family:FontAwesome;color:red;">&#xf00d;</span>';
            }else{
                $icon = '<span  style="font-size:15px;font-family:FontAwesome;color:red;">&#xf00d;</span>';
            }
            
            if ($nilai){
                if (!$noncheckbox){
                    $icon = '<span  style="font-size:15px;font-family:FontAwesome;color:green;">&#xf00c;</span>';
                }else{
                    $icon = '<span  style="font-size:15px;font-family:FontAwesome;color:green;">&#xf00c;</span>';
                }
            }
            
            $data = $icon;
        }
        
        
        
        return $data;
    } 
    
    /**
     * 
     * @param type $jumlah
     * @param type $kalimat
     * @return type
     */
    public function defaulttitik($jumlah, $kalimat, $jarak=''){
        
        $count_kal = strlen($kalimat); 
        
        $bagi = $jumlah - ($count_kal*2);
        
        $titik = '';        
        if (empty($kalimat)){
            for($i=1;$i<=$bagi;$i++){
                $titik .= ' . ';
            }        
        }else{
            for($i=1;$i<=$bagi;$i++){
                $titik .= $jarak;
            } 
        }
        
        return ''.$kalimat.''.$titik;
    }
    
    /**
     * 
     * @param type $kalimat
     * @param type $pilih
     * @param type $pisah
     * @return type
     */
    public function set_strike_word($kalimat,$pilih, $pisah){
        $pecah = explode($pisah,$kalimat);        
        $str = [];
        if (!empty($pecah)){
            foreach($pecah as $det){
                if (!empty($pilih)){
                    if ($pilih != trim($det)){
                        $str[] = '<strike>'.trim($det).'</strike>';
                    }else{
                        $str[] = trim($det);
                    }
                }else{
                    $str[] = trim($det);
                }
            }
            
            $str = implode(' '.$pisah.' ',$str);
        }else{
            $str = $kalimat;
        }
        
        return $str;
    }
    
    /**
     * 
     * @param type $tgl_akhir
     * @param type $tgl_awal
     * @return type
     */
    public static function hitungBulan($tgl_akhir, $tgl_awal){        
        $ts1 = strtotime($tgl_awal);
        $ts2 = strtotime($tgl_akhir);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        
        return $diff;
    }
    
    /**
     * menampilkan semua bulan
     */
    public static function getBulanNamaPendek(){
        $bulan = array(
                        '01' => 'Jan',
                        '02' => 'Feb',
                        '03' => 'Mar',
                        '04' => 'Apr',
                        '05' => 'Mei',
                        '06' => 'Jun',
                        '07' => 'Jul',
                        '08' => 'Agu',
                        '09' => 'Sep',
                        '10' => 'Okt',
                        '11' => 'Nov',
                        '12' => 'Des'
            );
        return $bulan;
    }
    
    /**
     * 
     * @return type
     */
    public static function kodeWarna(){
        return array(
            'merah' => '#e01111',
            'kuning' => '#fff716',
            'hijau' => '#11d624',
            'biru' => '#1319d6'
        );
    }

    public static function getUrlByMenuID($id) {
        $menu = MenumodulK::model()->findByPk($id);
        
        if (empty($menu)) {
            return '#';
        }

        if (empty($menu->menu_url)) {
            return "#";
        }

        return Yii::app()->createUrl('/'.$menu->menu_url);
    }

    /**
     * digunakan untuk mengubah nilai RH+ menjadi Positif dan RH- menjadi Negatif
     * @param type $r
     * @return type
     */
    public static function cekNamaRhesus($r){
        
        $r = trim($r);
        
        $arr = array(
            Params::RHESUS_POSITIF => 'Positif',
            Params::RHESUS_NEGATIF => 'Negatif',
        );
                        
        return isset($arr[$r])?$arr[$r]:$r;
    }
    
    public static function absoluteUrl($url, $route){        
        return $url.str_replace(Yii::app()->getBaseUrl(false).'/','/',Yii::app()->createUrl($route));
    }

    public static function isGridViewUpdate($gridview_id) {
        return !isset($_GET['ajax']) || $_GET['ajax'] == $gridview_id;
    }

    public static function isBayarLunas($pendaftaran_id) {
        $sql = "
        select t.pendaftaran_id, count(*) as count_tindakan, 
        sum((((case when t.cyto_tindakan = true and t.tarifcyto_tindakan <> 0 then t.tarifcyto_tindakan else t.tarif_satuan end) + (case when is_alkes = true then t.biayaadministrasi else 0 end)) * t.qty_tindakan) - t.discount_tindakan) as tarif,
        sum(case when tsb.jmliurbiaya is null then 0 else tsb.jmliurbiaya end) as total_bayar_tindakan, 
        sum(case when osb.jmliurbiaya is null then 0 else osb.jmliurbiaya end) as total_bayar_oa 
        from rinciantagihapasien_v t 
        left join (
            select tsba.tindakanpelayanan_id, sum(tsba.jmliurbiaya + tsba.jmlsubsidi_asuransi) as jmliurbiaya
            from tindakansudahbayar_t tsba where tsba.orderbatalpembayaranpelayanan_id is null
            group by tsba.tindakanpelayanan_id
        ) tsb on tsb.tindakanpelayanan_id = t.tindakanpelayanan_id and t.is_alkes = false
        left join (
            select osba.obatalkespasien_id, sum(osba.jmliurbiaya + osba.jmlsubsidi_asuransi) as jmliurbiaya
            from oasudahbayar_t osba where osba.orderbatalpembayaranpelayanan_id is null
            group by osba.obatalkespasien_id
        ) osb on osb.obatalkespasien_id = t.tindakanpelayanan_id and t.is_alkes = true
        where t.pendaftaran_id = ".$pendaftaran_id."

        group by t.pendaftaran_id;
        ";

        $res = Yii::app()->db->createCommand($sql)->queryRow();

        if (empty($res)) {
            return false;
        }

        if ($res['count_tindakan'] == 0) {
            return false;
        }

        return $res['tarif'] - ($res['total_bayar_tindakan'] + $res['total_bayar_oa']) == 0;
    }
}
?>
