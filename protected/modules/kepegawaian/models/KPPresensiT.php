<?php
class KPPresensiT extends PresensiT {
    public $ruangan_id;
    public $instalasi_id;
    public $kategoripegawai;
    public $datepresensi;
    public $unit_perusahaan;
    public $statusscan_nama;
    public $statuskehadiran_nama;
    public $kelompokpegawai_id;
    public $jabatan_id;
    public $waktu;
	public $shift_jamawal;
	public $shift_jamakhir;
	public $jabatan_nama;
	public $kelompokpegawai_nama;
	public $gelardepan;
	public $gelarbelakang_nama;
	public $verifikasi;
	public $nomorindukpegawai;
	public $shift_nama;
	public $jamkerjamasuk;
	public $jamkerjapulang;
	public $presensimasuk_id;
	public $presensipulang_id;
	public $shift_bedatanggal;
	public $statusscan;



    public static function model($class = __CLASS__){
        return parent::model($class);

    }



    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->with = array('statusscan','pegawai', 'statuskehadiran');
            $criteria->compare('t.presensi_id',$this->presensi_id);
            $criteria->compare('t.statusscan_id',$this->statusscan_id);
            $criteria->compare('t.pegawai_id',$this->pegawai_id);
            $criteria->compare('t.statuskehadiran_id',$this->statuskehadiran_id);
            $criteria->addBetweenCondition('date(t.tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir);
//		$criteria->compare('tglpresensi',$this->tglpresensi,true);
            $criteria->compare('t.no_fingerprint',$this->no_fingerprint,true);
            $criteria->compare('t.verifikasi',$this->verifikasi);
            $criteria->compare('t.keterangan',$this->keterangan,true);
            $criteria->compare('t.create_time',$this->create_time,true);
            $criteria->compare('t.user_id',$this->user_id);
            $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(statusscan.statusscan_nama)',strtolower($this->statusscan_nama),true);
            $criteria->compare('LOWER(statuskehadiran.statuskehadiran_nama)',strtolower($this->statuskehadiran_nama),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function searchInformasiPresensi()
    {
        $provider = $this->search();
        $provider->criteria->with = array();
        $provider->criteria->join = "left join statusscan_m statusscan on statusscan.statusscan_id = t.statusscan_id "
                . "left join pegawai_m pegawai on pegawai.pegawai_id = t.pegawai_id ";
                //. "left join statuskehadiran_m statuskehadiran on statuskehadiran.statuskehadiran_id = t.statuskehadiran_id";
        $provider->criteria->group = "t.no_fingerprint, t.pegawai_id, t.tglpresensi::date, pegawai.nama_pegawai";
        $provider->criteria->select = "t.no_fingerprint, t.pegawai_id, t.tglpresensi::date, pegawai.nama_pegawai";

        $provider->criteria->compare('pegawai.kelompokpegawai_id', $this->kelompokpegawai_id);
        $provider->criteria->compare('pegawai.jabatan_id', $this->jabatan_id);

        $provider->criteria->order = 't.tglpresensi::date DESC, pegawai.nama_pegawai';

        return $provider;
    }

	public function criteriaInfoPresensi(){
		$criteria=new CDbCriteria;
		$criteria->join =	" JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id "
						.	" LEFT JOIN jabatan_m j ON j.jabatan_id = peg.jabatan_id "
						.	" LEFT JOIN kelompokpegawai_m kp ON kp.kelompokpegawai_id = peg.kelompokpegawai_id "
						.	" LEFT JOIN gelarbelakang_m gb ON gb.gelarbelakang_id = peg.gelarbelakang_id "
						.	" LEFT JOIN statuskehadiran_m sk ON sk.statuskehadiran_id = t.statuskehadiran_id "
						.	" LEFT JOIN shift_m s ON s.shift_id = t.shift_id ";
		$criteria->addBetweenCondition("date(tglpresensi)", date('Y-m-d',strtotime($this->tglpresensi.' -1 days')), date('Y-m-d',strtotime($this->tglpresensi_akhir.' +1 days')));
		if (!empty($this->kelompokpegawai_id)){
			if (is_array($this->kelompokpegawai_id)){
				$criteria->addInCondition(" peg.kelompokpegawai_id ",$this->kelompokpegawai_id);
				//$criteria->addCondition(" peg.kelompokpegawai_id != '".Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP."'  ");
			}else{
				$criteria->addCondition(" peg.kelompokpegawai_id = '".$this->kelompokpegawai_id."'   ");			//AND peg.kelompokpegawai_id != '".Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP."'
			}
		}else{
			//$criteria->addCondition(" peg.kelompokpegawai_id != '".Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP."'  ");
		}

		if (!empty($this->jabatan_id)){
			if (is_array($this->jabatan_id)){
				$criteria->addInCondition(" j.jabatan_id ",$this->jabatan_id);
			}else{
				$criteria->addCondition(" j.jabatan_id = '".$this->jabatan_id."' ");
			}
		}

		if (!empty($this->shift_id)){
			if (is_array($this->shift_id)){
				$criteria->addInCondition(" t.shift_id ",$this->shift_id);
			}else{
				$criteria->addCondition(" t.shift_id = '".$this->shift_id."' ");
			}
		}

		//if (!empty($this->statuskehadiran_id)){
		//	if (is_array($this->statuskehadiran_id)){
		//		$criteria->addInCondition(" t.statuskehadiran_id ",$this->statuskehadiran_id);
		//	}else{
		//		$criteria->addCondition(" t.statuskehadiran_id = '".$this->statuskehadiran_id."' ");
		//	}
		//}

		$criteria->compare("LOWER(t.no_fingerprint)", strtolower($this->no_fingerprint),true);
		$criteria->compare('t.pegawai_id', $this->pegawai_id);
		$criteria->compare("LOWER(peg.nomorindukpegawai)", strtolower($this->nomorindukpegawai),true);

		$criteria->compare("LOWER(peg.nama_pegawai)", strtolower($this->nama_pegawai),true);

		// pada laporan presensi
		if (!empty($this->kategoripegawai)){
			if (is_array($this->kategoripegawai)){
				$criteria->addInCondition(" peg.kategoripegawai ",$this->kategoripegawai);
			}else{
				$criteria->addCondition(" peg.kategoripegawai = '".$this->kategoripegawai."' ");
			}
		}

		if (!empty($this->instalasi_id)){

			$criIns = new CDbCriteria();
			$criIns->select = " t.pegawai_id ";
			$criIns->addInCondition(" instalasi_id ", $this->instalasi_id);
			if (!empty($this->ruangan_id)){
				$criIns->addInCondition(" ruangan_id ", $this->ruangan_id);
			}
			$peg = PegawairuanganV::model()->findAll($criIns);

			$r = array();
			foreach ($peg as $p){
				$r[]  = $p->pegawai_id;
			}

			if (count((array)$r)>0){
				$criteria->addInCondition(" peg.pegawai_id ",$r);
			}
		}

		if (!empty($this->pegawai_id)){
			$criteria->addCondition(" t.pegawai_id = '".$this->pegawai_id."' ");
		}



		return $criteria;
	}

	public function searchInformasiPresensiBaru(){

		$res = array();

        /*
		//awal absen masuk
		$criPre = $this->criteriaInfoPresensi();
		$criPre->select = " t.presensi_id, s.shift_bedatanggal, t.statuskehadiran_id, sk.statuskehadiran_nama,t.keterangan, t.jamkerjamasuk, s.shift_nama,peg.nomorindukpegawai, t.verifikasi, t.terlambat_mnt, s.shift_jamawal, s.shift_jamakhir, t.no_fingerprint, t.tglpresensi, t.shift_id, peg.pegawai_id, peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama, j.jabatan_nama, kp.kelompokpegawai_nama ";
		$criPre->group = $criPre->select;
		$criPre->order = " t.tglpresensi ASC, peg.nama_pegawai ASC,
			CASE WHEN sk.statuskehadiran_nama = '".Params::STATUSKEHADIRAN_NAMA_SAKIT."' THEN 1
              WHEN sk.statuskehadiran_nama = '".Params::STATUSKEHADIRAN_NAMA_IZIN."' THEN 2
              WHEN sk.statuskehadiran_nama = '".Params::STATUSKEHADIRAN_NAMA_DINAS."' THEN 3
              WHEN sk.statuskehadiran_nama = '".Params::STATUSKEHADIRAN_NAMA_ALPHA."' THEN 4
              WHEN sk.statuskehadiran_nama = '".Params::STATUSKEHADIRAN_NAMA_HADIR."' THEN 5
         END";
		$criPre->limit = -1;

		$pPre = new CActiveDataProvider($this, array(
				'criteria'=>$criPre,
				'pagination'=>false
		));

		foreach ($pPre->data as $item) {
			$ident = '1'.date('dmY', strtotime($item->tglpresensi)).''.$item->pegawai_id;
			if (!isset($res[$ident])){
				$res[$ident]['presensimasuk_id'] = $item->presensi_id;
				$res[$ident]['presensikeluar_id'] = '';
				$res[$ident]['presensidatang_id'] = '';
				$res[$ident]['presensipulang_id'] = '';
				$res[$ident]['tglpresensi'] = date('Y-m-d', strtotime($item->tglpresensi));
				$res[$ident]['keterangan'] = $item->keterangan;
				$res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
				$res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
				$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
				$res[$ident]['jamkerjamasuk'] = $item->jamkerjamasuk;
				$res[$ident]['jamkerjapulang'] = '';
				$res[$ident]['jamscan_masuk'] = date('H:i:s', strtotime($item->tglpresensi));
				$res[$ident]['jamscan_pulang'] = '';
				$res[$ident]['jamscan_keluar'] = '';
				$res[$ident]['jamscan_datang'] = '';
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['terlambat_mnt'] = $item->terlambat_mnt;
				$res[$ident]['pulangawal_mnt'] = '';
				$res[$ident]['shift_nama'] = $item->shift_nama;
				$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
				$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
				$res[$ident]['shift_id'] = $item->shift_id;
				$res[$ident]['no_fingerprint'] = $item->no_fingerprint;
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['jabatan_nama'] = $item->jabatan_nama;
				$res[$ident]['kelompokpegawai_nama'] = $item->kelompokpegawai_nama;
				$res[$ident]['nama_pegawai'] = $item->gelardepan.' '.$item->nama_pegawai.', '.$item->gelarbelakang_nama;
				$res[$ident]['urutannama'] = $item->nama_pegawai;
				$res[$ident]['verifikasi'] = $item->verifikasi;
				$res[$ident]['nomorindukpegawai'] = $item->nomorindukpegawai;
			}
		}
         *
         */

        /* Jadwal Pegawai */
        $criJadwal = new CDbCriteria();
        $criJadwal->join = "join pegawai_m p on p.pegawai_id = t.pegawai_id";
        $criJadwal->compare("t.pegawai_id", $this->pegawai_id);
        $criJadwal->compare("p.jabatan_id", $this->jabatan_id);
        $criJadwal->compare("p.kelompokpegawai_id", $this->kelompokpegawai_id);
        $criJadwal->compare("lower(p.nomorindukpegawai)", strtolower($this->nomorindukpegawai), true);
        $criJadwal->compare("lower(p.nama_pegawai)", strtolower($this->nama_pegawai), true);
        $criJadwal->addBetweenCondition("date(t.tgljadwalpegawai)", date('Y-m-d',strtotime($this->tglpresensi.' -1 days')), date('Y-m-d',strtotime($this->tglpresensi_akhir.' +1 days')));
        $criJadwal->order = "t.tgljadwalpegawai asc";
        $criJadwal->select = "t.pegawai_id, t.tgljadwalpegawai, t.jamkerjamasuk, t.jamkerjapulang, t.shift_id";
        $jadwal = PenjadwalandetailT::model()->findAll($criJadwal);


        $pegdat = array();
        $shiftdet = array();


        foreach ($jadwal as $item) {
            if (empty($shiftdet[$item->shift_id])) {
                $shiftdet[$item->shift_id] = ShiftM::model()->findByPk($item->shift_id);
            }

            if (empty($pegdat[$item->pegawai_id])) {
                $peg = PegawaiM::model()->findByPk($item->pegawai_id);
                $pegdat[$item->pegawai_id] = $peg->attributes;
                $pegdat[$item->pegawai_id]['nama_lengkap'] = $peg->namaLengkap;
                $pegdat[$item->pegawai_id]['jabatan_nama'] = null;
                $pegdat[$item->pegawai_id]['kelompokpegawai_nama'] = null;

                if (!empty($peg->jabatan_id)) {
                    $jabatan = JabatanM::model()->findByPk($peg->jabatan_id);
                    if (!empty($jabatan)) {
                        $pegdat[$item->pegawai_id]['jabatan_nama'] = $peg->jabatan_nama;
                    }
                }

                if (!empty($peg->kelompokpegawai_id)) {
                    $kel = KelompokpegawaiM::model()->findByPk($peg->kelompokpegawai_id);
                    if (!empty($kel)) {
                        $pegdat[$item->pegawai_id]['kelompokpegawai_nama'] = $kel->kelompokpegawai_nama;
                    }
                }
            }
            //*
            $ident = '1'.date('dmY', strtotime($item->tgljadwalpegawai)).''.$item->pegawai_id;
            if (!isset($res[$ident])){
                $res[$ident] = array();
				$res[$ident]['presensimasuk_id'] = '';
				$res[$ident]['presensikeluar_id'] = '';
				$res[$ident]['presensidatang_id'] = '';
				$res[$ident]['presensipulang_id'] = '';
				$res[$ident]['tglpresensi'] = date('Y-m-d', strtotime($item->tgljadwalpegawai));
				$res[$ident]['keterangan'] = '';
				$res[$ident]['statuskehadiran_id'] = '';
				$res[$ident]['statuskehadiran_nama'] = '';
				$res[$ident]['shift_bedatanggal'] = $shiftdet[$item->shift_id]->shift_bedatanggal;
				$res[$ident]['jamkerjamasuk'] = '';
				$res[$ident]['jamkerjapulang'] = '';
				$res[$ident]['jamscan_masuk'] = '';
				$res[$ident]['jamscan_pulang'] = '';
				$res[$ident]['jamscan_keluar'] = '';
				$res[$ident]['jamscan_datang'] = '';
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['terlambat_mnt'] = '';
				$res[$ident]['pulangawal_mnt'] = '';
				$res[$ident]['shift_nama'] = $shiftdet[$item->shift_id]->shift_nama;
				$res[$ident]['shift_jamawal'] = $shiftdet[$item->shift_id]->shift_jamawal;
				$res[$ident]['shift_jamakhir'] = $shiftdet[$item->shift_id]->shift_jamakhir;
				$res[$ident]['shift_id'] = $shiftdet[$item->shift_id]->shift_id;
				$res[$ident]['no_fingerprint'] = '';
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['jabatan_nama'] = $pegdat[$item->pegawai_id]['jabatan_nama'];
				$res[$ident]['kelompokpegawai_nama'] = $pegdat[$item->pegawai_id]['kelompokpegawai_nama'];
				$res[$ident]['nama_pegawai'] = $pegdat[$item->pegawai_id]['nama_lengkap'];
				$res[$ident]['urutannama'] = '';
				$res[$ident]['verifikasi'] = false;
				$res[$ident]['nomorindukpegawai'] = $pegdat[$item->pegawai_id]['nomorindukpegawai'];
                $res[$ident]['isfingerprintscan'] = false;
			}
            // *
            // */
        }


        // var_dump($res); die;

        //awal absen tidak hadir
		$criPmasuk = $this->criteriaInfoPresensi();
		$criPmasuk->select = " t.presensi_id, s.shift_bedatanggal, t.statuskehadiran_id, sk.statuskehadiran_nama,t.keterangan, t.jamkerjamasuk, s.shift_nama,peg.nomorindukpegawai, t.verifikasi, t.terlambat_mnt, s.shift_jamawal, s.shift_jamakhir, t.no_fingerprint, t.tglpresensi, t.shift_id, peg.pegawai_id, peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama, j.jabatan_nama, kp.kelompokpegawai_nama, t.isfingerprintscan ";

		$criPmasuk->addCondition(" t.statusscan_id is null ");
		$criPmasuk->group = $criPmasuk->select;
		$criPmasuk->order = " t.tglpresensi ASC, peg.nama_pegawai ASC ";
		$criPmasuk->limit = -1;

		$pMasuk = new CActiveDataProvider($this, array(
				'criteria'=>$criPmasuk,
				'pagination'=>false
		));



		foreach ($pMasuk->data as $item) {
			$ident = '1'.date('dmY', strtotime($item->tglpresensi)).''.$item->pegawai_id;
			if (!isset($res[$ident])){
				$res[$ident]['presensimasuk_id'] = $item->presensi_id;
				$res[$ident]['presensikeluar_id'] = '';
				$res[$ident]['presensidatang_id'] = '';
				$res[$ident]['presensipulang_id'] = '';
				$res[$ident]['tglpresensi'] = date('Y-m-d', strtotime($item->tglpresensi));
				$res[$ident]['keterangan'] = $item->keterangan;
				$res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
				$res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
				$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
				$res[$ident]['jamkerjamasuk'] = $item->jamkerjamasuk;
				$res[$ident]['jamkerjapulang'] = '';
				$res[$ident]['jamscan_masuk'] = '';
				$res[$ident]['jamscan_pulang'] = '';
				$res[$ident]['jamscan_keluar'] = '';
				$res[$ident]['jamscan_datang'] = '';
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['terlambat_mnt'] = $item->terlambat_mnt;
				$res[$ident]['pulangawal_mnt'] = '';
				$res[$ident]['shift_nama'] = $item->shift_nama;
				$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
				$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
				$res[$ident]['shift_id'] = $item->shift_id;
				$res[$ident]['no_fingerprint'] = $item->no_fingerprint;
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['jabatan_nama'] = $item->jabatan_nama;
				$res[$ident]['kelompokpegawai_nama'] = $item->kelompokpegawai_nama;
				$res[$ident]['nama_pegawai'] = $item->gelardepan.' '.$item->nama_pegawai.', '.$item->gelarbelakang_nama;
				$res[$ident]['urutannama'] = $item->nama_pegawai;
				$res[$ident]['verifikasi'] = $item->verifikasi;
				$res[$ident]['nomorindukpegawai'] = $item->nomorindukpegawai;
                if ($item->isfingerprintscan == true) {
                    $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                }
			}else{
                if (empty($res[$ident]['jamkerjamasuk'])) {
                    $res[$ident]['keterangan'] = $item->keterangan;
                    $res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
                    $res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
                    //$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
                    $res[$ident]['jamkerjamasuk'] = $item->jamkerjamasuk;
                    $res[$ident]['terlambat_mnt'] = $item->terlambat_mnt;
                    //$res[$ident]['shift_nama'] = $item->shift_nama;
                    //$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
                    //$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
                   // $res[$ident]['shift_id'] = $item->shift_id;
                    $res[$ident]['no_fingerprint'] = $item->no_fingerprint;
                    $res[$ident]['nama_pegawai'] = $item->gelardepan.' '.$item->nama_pegawai.', '.$item->gelarbelakang_nama;
                    $res[$ident]['urutannama'] = $item->nama_pegawai;
                    $res[$ident]['verifikasi'] = $item->verifikasi;
                    if ($item->isfingerprintscan == true) {
                        $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                    }
                }
            }
            $res[$ident]['jamscan_masuk'] = date('H:i:s', strtotime($item->tglpresensi));
            $res[$ident]['presensimasuk_id'] = $item->presensi_id;
		}




		//awal absen masuk
		$criPmasuk = $this->criteriaInfoPresensi();
		$criPmasuk->select = " t.presensi_id, s.shift_bedatanggal, t.statuskehadiran_id, sk.statuskehadiran_nama,t.keterangan, t.jamkerjamasuk, s.shift_nama,peg.nomorindukpegawai, t.verifikasi, t.terlambat_mnt, s.shift_jamawal, s.shift_jamakhir, t.no_fingerprint, t.tglpresensi, t.shift_id, peg.pegawai_id, peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama, j.jabatan_nama, kp.kelompokpegawai_nama, t.isfingerprintscan ";

		$criPmasuk->addCondition(" t.statusscan_id = '".Params::STATUSSCAN_MASUK."' ");
		$criPmasuk->group = $criPmasuk->select;
		$criPmasuk->order = " t.tglpresensi ASC, peg.nama_pegawai ASC ";
		$criPmasuk->limit = -1;

		$pMasuk = new CActiveDataProvider($this, array(
				'criteria'=>$criPmasuk,
				'pagination'=>false
		));



		foreach ($pMasuk->data as $item) {
			$ident = '1'.date('dmY', strtotime($item->tglpresensi)).''.$item->pegawai_id;
			if (!isset($res[$ident])){
				$res[$ident]['presensimasuk_id'] = $item->presensi_id;
				$res[$ident]['presensikeluar_id'] = '';
				$res[$ident]['presensidatang_id'] = '';
				$res[$ident]['presensipulang_id'] = '';
				$res[$ident]['tglpresensi'] = date('Y-m-d', strtotime($item->tglpresensi));
				$res[$ident]['keterangan'] = $item->keterangan;
				$res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
				$res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
				$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
				$res[$ident]['jamkerjamasuk'] = $item->jamkerjamasuk;
				$res[$ident]['jamkerjapulang'] = '';
				$res[$ident]['jamscan_masuk'] = date('H:i:s', strtotime($item->tglpresensi));
				$res[$ident]['jamscan_pulang'] = '';
				$res[$ident]['jamscan_keluar'] = '';
				$res[$ident]['jamscan_datang'] = '';
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['terlambat_mnt'] = $item->terlambat_mnt;
				$res[$ident]['pulangawal_mnt'] = '';
				$res[$ident]['shift_nama'] = $item->shift_nama;
				$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
				$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
				$res[$ident]['shift_id'] = $item->shift_id;
				$res[$ident]['no_fingerprint'] = $item->no_fingerprint;
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['jabatan_nama'] = $item->jabatan_nama;
				$res[$ident]['kelompokpegawai_nama'] = $item->kelompokpegawai_nama;
				$res[$ident]['nama_pegawai'] = $item->gelardepan.' '.$item->nama_pegawai.', '.$item->gelarbelakang_nama;
				$res[$ident]['urutannama'] = $item->nama_pegawai;
				$res[$ident]['verifikasi'] = $item->verifikasi;
				$res[$ident]['nomorindukpegawai'] = $item->nomorindukpegawai;
                if ($item->isfingerprintscan == true) {
                    $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                }
			}else{
                if (empty($res[$ident]['jamscan_masuk'])) {
                    $res[$ident]['keterangan'] = $item->keterangan;
                    $res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
                    $res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
                    //$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
                    $res[$ident]['jamkerjamasuk'] = $item->jamkerjamasuk;
                    $res[$ident]['terlambat_mnt'] = $item->terlambat_mnt;
                    //$res[$ident]['shift_nama'] = $item->shift_nama;
                    //$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
                    //$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
                    //$res[$ident]['shift_id'] = $item->shift_id;
                    $res[$ident]['no_fingerprint'] = $item->no_fingerprint;
                    $res[$ident]['nama_pegawai'] = $item->gelardepan.' '.$item->nama_pegawai.', '.$item->gelarbelakang_nama;
                    $res[$ident]['urutannama'] = $item->nama_pegawai;
                    $res[$ident]['verifikasi'] = $item->verifikasi;
                    if ($item->isfingerprintscan == true) {
                        $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                    }
                }
			}
            $res[$ident]['jamscan_masuk'] = date('H:i:s', strtotime($item->tglpresensi));
            $res[$ident]['presensimasuk_id'] = $item->presensi_id;
		}

		//akhir absesn masuk

		//awal absen keluar
		$criPmasuk = $this->criteriaInfoPresensi();
		$criPmasuk->select = " t.presensi_id, s.shift_bedatanggal, t.statuskehadiran_id,  sk.statuskehadiran_nama,t.keterangan, t.jamkerjamasuk, s.shift_nama,peg.nomorindukpegawai, t.verifikasi, t.terlambat_mnt, s.shift_jamawal, s.shift_jamakhir, t.no_fingerprint, t.tglpresensi, t.shift_id, peg.pegawai_id, peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama, j.jabatan_nama, kp.kelompokpegawai_nama, t.isfingerprintscan ";

		$criPmasuk->addCondition(" t.statusscan_id = '".Params::STATUSSCAN_KELUAR."' ");
		$criPmasuk->group = $criPmasuk->select;
		$criPmasuk->order = " t.tglpresensi ASC, peg.nama_pegawai ASC ";
		$criPmasuk->limit = -1;

		$pMasuk = new CActiveDataProvider($this, array(
				'criteria'=>$criPmasuk,
				'pagination'=>false
		));

		foreach ($pMasuk->data as $item) {
			$ident = '1'.date('dmY', strtotime($item->tglpresensi)).''.$item->pegawai_id;
			if (!isset($res[$ident])){
				$res[$ident]['presensimasuk_id'] = '';
				$res[$ident]['presensikeluar_id'] = $item->presensi_id;
				$res[$ident]['presensidatang_id'] = '';
				$res[$ident]['presensipulang_id'] = '';
				$res[$ident]['tglpresensi'] = date('Y-m-d', strtotime($item->tglpresensi));
				$res[$ident]['keterangan'] = $item->keterangan;
				$res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
				$res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
				$res[$ident]['jamkerjamasuk'] = '';
				$res[$ident]['jamkerjapulang'] = '';
				$res[$ident]['jamscan_masuk'] = '';
				$res[$ident]['jamscan_keluar'] = date('H:i:s', strtotime($item->tglpresensi));
				$res[$ident]['jamscan_datang'] = '';
				$res[$ident]['jamscan_pulang'] = '';
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['terlambat_mnt'] = $item->terlambat_mnt;
				$res[$ident]['pulangawal_mnt'] = '';
				$res[$ident]['shift_nama'] = $item->shift_nama;
				$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
				$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
				$res[$ident]['shift_id'] = $item->shift_id;
				$res[$ident]['no_fingerprint'] = $item->no_fingerprint;
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['jabatan_nama'] = $item->jabatan_nama;
				$res[$ident]['kelompokpegawai_nama'] = $item->kelompokpegawai_nama;
				$res[$ident]['nama_pegawai'] = $item->gelardepan.' '.$item->nama_pegawai.', '.$item->gelarbelakang_nama;
				$res[$ident]['urutannama'] = $item->nama_pegawai;
				$res[$ident]['verifikasi'] = $item->verifikasi;
				$res[$ident]['nomorindukpegawai'] = $item->nomorindukpegawai;
                if ($item->isfingerprintscan == true) {
                    $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                }
			}else{
                if (empty($res[$ident]['jamscan_keluar'])) {
                    $res[$ident]['keterangan'] = $item->keterangan;
                    $res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
                    $res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
                    //$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
                    //$res[$ident]['shift_nama'] = $item->shift_nama;
                    //$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
                    //$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
                    //$res[$ident]['shift_id'] = $item->shift_id;
                    $res[$ident]['no_fingerprint'] = $item->no_fingerprint;
                    $res[$ident]['urutannama'] = $item->nama_pegawai;
                    $res[$ident]['verifikasi'] = $item->verifikasi;
                    if ($item->isfingerprintscan == true) {
                        $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                    }
                }
				//$res[$ident]['pulangawal_mnt'] = $item->pulangawal_mnt;
				//$res[$ident]['jamkerjapulang'] = $item->jamkerjapulang;
			}
            $res[$ident]['jamscan_keluar'] = date('H:i:s', strtotime($item->tglpresensi));
            $res[$ident]['presensikeluar_id'] = $item->presensi_id;
		}

		//akhir absesn keluar

		//awal absen datang
		$criPmasuk = $this->criteriaInfoPresensi();
		$criPmasuk->select = "  t.presensi_id, s.shift_bedatanggal, t.statuskehadiran_id, sk.statuskehadiran_nama,t.keterangan, t.jamkerjamasuk, s.shift_nama,peg.nomorindukpegawai, t.verifikasi, t.terlambat_mnt, s.shift_jamawal, s.shift_jamakhir, t.no_fingerprint, t.tglpresensi, t.shift_id, peg.pegawai_id, peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama, j.jabatan_nama, kp.kelompokpegawai_nama, t.isfingerprintscan ";

		$criPmasuk->addCondition(" t.statusscan_id = '".Params::STATUSSCAN_DATANG."' ");
		$criPmasuk->group = $criPmasuk->select;
		$criPmasuk->order = " t.tglpresensi ASC, peg.nama_pegawai ASC ";
		$criPmasuk->limit = -1;

		$pMasuk = new CActiveDataProvider($this, array(
				'criteria'=>$criPmasuk,
				'pagination'=>false
		));

		foreach ($pMasuk->data as $item) {
			$ident = '1'.date('dmY', strtotime($item->tglpresensi)).''.$item->pegawai_id;
			if (!isset($res[$ident])){
				$res[$ident]['presensimasuk_id'] = '';
				$res[$ident]['presensikeluar_id'] = '';
				$res[$ident]['presensidatang_id'] = $item->presensi_id;
				$res[$ident]['presensipulang_id'] = '';
				$res[$ident]['tglpresensi'] = date('Y-m-d', strtotime($item->tglpresensi));
				$res[$ident]['keterangan'] = $item->keterangan;
				$res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
				$res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
				$res[$ident]['jamkerjamasuk'] = '';
				$res[$ident]['jamkerjapulang'] = '';
				$res[$ident]['jamscan_masuk'] = '';
				$res[$ident]['jamscan_keluar'] = '';
				$res[$ident]['jamscan_datang'] = date('H:i:s', strtotime($item->tglpresensi));
				$res[$ident]['jamscan_pulang'] = '';
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['terlambat_mnt'] = $item->terlambat_mnt;
				$res[$ident]['pulangawal_mnt'] = '';
				$res[$ident]['shift_nama'] = $item->shift_nama;
				$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
				$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
				$res[$ident]['shift_id'] = $item->shift_id;
				$res[$ident]['no_fingerprint'] = $item->no_fingerprint;
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['jabatan_nama'] = $item->jabatan_nama;
				$res[$ident]['kelompokpegawai_nama'] = $item->kelompokpegawai_nama;
				$res[$ident]['nama_pegawai'] = $item->gelardepan.' '.$item->nama_pegawai.', '.$item->gelarbelakang_nama;
				$res[$ident]['urutannama'] = $item->nama_pegawai;
				$res[$ident]['verifikasi'] = $item->verifikasi;
				$res[$ident]['nomorindukpegawai'] = $item->nomorindukpegawai;
                if ($item->isfingerprintscan == true) {
                    $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                }
			}else{
                if (empty($res[$ident]['jamscan_datang'])) {
                    $res[$ident]['keterangan'] = $item->keterangan;
                    $res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
                    $res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
                    //$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
                    //$res[$ident]['shift_nama'] = $item->shift_nama;
                    //$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
                    //$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
                    //$res[$ident]['shift_id'] = $item->shift_id;
                    $res[$ident]['no_fingerprint'] = $item->no_fingerprint;
                    $res[$ident]['urutannama'] = $item->nama_pegawai;
                    $res[$ident]['verifikasi'] = $item->verifikasi;
                    if ($item->isfingerprintscan == true) {
                        $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                    }
                }

			}
            $res[$ident]['presensidatang_id'] = $item->presensi_id;
            //$res[$ident]['pulangawal_mnt'] = $item->pulangawal_mnt;
            $res[$ident]['jamscan_datang'] = date('H:i:s', strtotime($item->tglpresensi));
            //$res[$ident]['jamkerjapulang'] = $item->jamkerjapulang;
		}

		//akhir absesn datang


		//awal absen pulang
		$criPpulang = $this->criteriaInfoPresensi();
		$criPpulang->select = "  t.presensi_id, s.shift_bedatanggal, t.statuskehadiran_id, sk.statuskehadiran_nama,t.keterangan, t.jamkerjapulang, s.shift_nama, peg.nomorindukpegawai, t.verifikasi, t.pulangawal_mnt, s.shift_jamawal, s.shift_jamakhir, t.no_fingerprint, t.tglpresensi, t.shift_id, peg.pegawai_id, peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama, j.jabatan_nama, kp.kelompokpegawai_nama, t.isfingerprintscan ";

		$criPpulang->addCondition(" t.statusscan_id = '".Params::STATUSSCAN_PULANG."' ");
		$criPpulang->group = $criPpulang->select;
		$criPpulang->order = " t.tglpresensi ASC, peg.nama_pegawai ASC ";
		$criPpulang->limit = -1;

		$pPpulang = new CActiveDataProvider($this, array(
				'criteria'=>$criPpulang,
				'pagination'=>false
		));

		foreach ($pPpulang->data as $item) {
			$ident = '1'.date('dmY', strtotime($item->tglpresensi)).''.$item->pegawai_id;
			$identK = '1'.date('dmY', strtotime($item->tglpresensi. '-1 days')).''.$item->pegawai_id;

			if (!isset($res[$ident])){
				$res[$ident]['presensimasuk_id'] = '';
				$res[$ident]['presensikeluar_id'] = '';
				$res[$ident]['presensidatang_id'] = '';
				$res[$ident]['presensipulang_id'] = $item->presensi_id;
				$res[$ident]['tglpresensi'] = date('Y-m-d', strtotime($item->tglpresensi));
				$res[$ident]['keterangan'] = $item->keterangan;
				$res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
				$res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
				$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
				$res[$ident]['jamkerjamasuk'] = '';
				$res[$ident]['jamkerjapulang'] = $item->jamkerjapulang;
				$res[$ident]['jamscan_masuk'] = '';
				$res[$ident]['jamscan_keluar'] = '';
				$res[$ident]['jamscan_datang'] = '';
				$res[$ident]['jamscan_pulang'] = date('H:i:s', strtotime($item->tglpresensi));
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['terlambat_mnt'] = $item->terlambat_mnt;
				$res[$ident]['pulangawal_mnt'] = $item->pulangawal_mnt;
				$res[$ident]['shift_nama'] = $item->shift_nama;
				$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
				$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
				$res[$ident]['shift_id'] = $item->shift_id;
				$res[$ident]['no_fingerprint'] = $item->no_fingerprint;
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['jabatan_nama'] = $item->jabatan_nama;
				$res[$ident]['kelompokpegawai_nama'] = $item->kelompokpegawai_nama;
				$res[$ident]['nama_pegawai'] = $item->gelardepan.' '.$item->nama_pegawai.', '.$item->gelarbelakang_nama;
				$res[$ident]['urutannama'] = $item->nama_pegawai;
				$res[$ident]['verifikasi'] = $item->verifikasi;
				$res[$ident]['nomorindukpegawai'] = $item->nomorindukpegawai;
                if ($item->isfingerprintscan == true) {
                    $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                }
			}else{
                if (empty($res[$ident]['jamscan_pulang'])) {
                    $res[$ident]['keterangan'] = $item->keterangan;
                    $res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
                    $res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
                    //$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
                    $res[$ident]['jamkerjapulang'] = $item->jamkerjapulang;
                    $res[$ident]['pulangawal_mnt'] = $item->pulangawal_mnt;
                    //$res[$ident]['shift_nama'] = $item->shift_nama;
                    //$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
                    //$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
                    //$res[$ident]['shift_id'] = $item->shift_id;
                    $res[$ident]['no_fingerprint'] = $item->no_fingerprint;
                    $res[$ident]['urutannama'] = $item->nama_pegawai;
                    $res[$ident]['verifikasi'] = $item->verifikasi;
                    if ($item->isfingerprintscan == true) {
                        $res[$ident]['isfingerprintscan'] = $item->isfingerprintscan;
                    }
                }
			}
            $res[$ident]['presensipulang_id'] = $item->presensi_id;
            $res[$ident]['pulangawal_mnt'] = $item->pulangawal_mnt;
            $res[$ident]['jamscan_pulang'] = date('H:i:s', strtotime($item->tglpresensi));
            $res[$ident]['jamkerjapulang'] = $item->jamkerjapulang;

			if (isset($res[$identK])){
				if (!empty($res[$identK]['jamscan_masuk'])){
					if ($res[$identK]['shift_bedatanggal'] == true){
						if (!empty($res[$identK]['jamscan_masuk'])){
							if ($res[$ident]['jamscan_masuk'] > $res[$ident]['jamscan_pulang']){
								$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
								$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
								$res[$ident]['jamscan_pulang'] = '';
							}else{
								if ($res[$identK]['jamscan_pulang'] < $res[$ident]['jamscan_pulang']){
									$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
									$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
									$res[$ident]['jamscan_pulang'] = '';
								}
							}
						}
						//	if ($res[$ident]['jamscan_masuk'] < $res[$ident]['jamscan_pulang']){
							///	$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
							//	$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
							//	$res[$ident]['jamscan_pulang'] = '';
							//}
						//}
					}else{
						if (!empty($res[$identK]['jamscan_masuk'])){
							if (!empty($res[$ident]['jamscan_masuk'])){
								if ($res[$ident]['jamscan_masuk'] > $res[$ident]['jamscan_pulang']){
									$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
									$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
									$res[$ident]['jamscan_pulang'] = '';
								}
							}else{
								if ($res[$identK]['jamscan_masuk'] > $res[$ident]['jamscan_pulang']){
									$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
									$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
									$res[$ident]['jamscan_pulang'] = '';
								}
							}
						}

					}
				}
			}

			if (empty($res[$ident]['jamscan_pulang']) && empty($res[$ident]['jamscan_keluar']) && empty($res[$ident]['jamscan_datang']) && empty($res[$ident]['jamscan_masuk'])){
				unset($res[$ident]);
			}
		}





		/*
		foreach ($pPpulang->data as $item) {
			$ident = '1'.date('dmY', strtotime($item->tglpresensi)).''.$item->pegawai_id;
			$identK = '1'.date('dmY', strtotime($item->tglpresensi. '-1 days')).''.$item->pegawai_id;

			if (!isset($res[$ident])){
				$res[$ident]['presensimasuk_id'] = '';
				$res[$ident]['presensikeluar_id'] = '';
				$res[$ident]['presensidatang_id'] = '';
				$res[$ident]['presensipulang_id'] = $item->presensi_id;
				$res[$ident]['tglpresensi'] = date('Y-m-d', strtotime($item->tglpresensi));
				$res[$ident]['keterangan'] = $item->keterangan;
				$res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
				$res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
				$res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
				$res[$ident]['jamkerjamasuk'] = '';
				$res[$ident]['jamkerjapulang'] = $item->jamkerjapulang;
				$res[$ident]['jamscan_masuk'] = '';
				$res[$ident]['jamscan_keluar'] = '';
				$res[$ident]['jamscan_datang'] = '';
				$res[$ident]['jamscan_pulang'] = date('H:i:s', strtotime($item->tglpresensi));
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['terlambat_mnt'] = '';
				$res[$ident]['pulangawal_mnt'] = $item->pulangawal_mnt;
				$res[$ident]['shift_nama'] = $item->shift_nama;
				$res[$ident]['shift_jamawal'] = $item->shift_jamawal;
				$res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
				$res[$ident]['shift_id'] = $item->shift_id;
				$res[$ident]['no_fingerprint'] = $item->no_fingerprint;
				$res[$ident]['pegawai_id'] = $item->pegawai_id;
				$res[$ident]['jabatan_nama'] = $item->jabatan_nama;
				$res[$ident]['kelompokpegawai_nama'] = $item->kelompokpegawai_nama;
				$res[$ident]['nama_pegawai'] = $item->gelardepan.' '.$item->nama_pegawai.', '.$item->gelarbelakang_nama;
				$res[$ident]['urutannama'] = $item->nama_pegawai;
				$res[$ident]['verifikasi'] = $item->verifikasi;
				$res[$ident]['nomorindukpegawai'] = $item->nomorindukpegawai;
			}else{
                $res[$ident]['keterangan'] = $item->keterangan;
                $res[$ident]['statuskehadiran_id'] = $item->statuskehadiran_id;
                $res[$ident]['statuskehadiran_nama'] = $item->statuskehadiran_nama;
                $res[$ident]['shift_bedatanggal'] = $item->shift_bedatanggal;
                $res[$ident]['jamkerjamasuk'] = $item->jamkerjamasuk;
                $res[$ident]['pulangawal_mnt'] = $item->pulangawal_mnt;
                $res[$ident]['shift_nama'] = $item->shift_nama;
                $res[$ident]['shift_jamawal'] = $item->shift_jamawal;
                $res[$ident]['shift_jamakhir'] = $item->shift_jamakhir;
                $res[$ident]['shift_id'] = $item->shift_id;
                $res[$ident]['no_fingerprint'] = $item->no_fingerprint;
                $res[$ident]['urutannama'] = $item->nama_pegawai;
                $res[$ident]['verifikasi'] = $item->verifikasi;
			}
            $res[$ident]['presensipulang_id'] = $item->presensi_id;
            $res[$ident]['jamscan_pulang'] = date('H:i:s', strtotime($item->tglpresensi));
            $res[$ident]['jamkerjapulang'] = $item->jamkerjapulang;


            // var_dump($res); die;

			if (isset($res[$identK])){
				if (!empty($res[$identK]['jamscan_masuk'])){
					if ($res[$identK]['shift_bedatanggal'] == true){
						if (!empty($res[$identK]['jamscan_masuk'])){
							if ($res[$ident]['jamscan_masuk'] > $res[$ident]['jamscan_pulang']){
								$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
								$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
								$res[$ident]['jamscan_pulang'] = '';
							}else{
								if ($res[$identK]['jamscan_pulang'] < $res[$ident]['jamscan_pulang']){
									$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
									$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
									$res[$ident]['jamscan_pulang'] = '';
								}
							}
						}
						//	if ($res[$ident]['jamscan_masuk'] < $res[$ident]['jamscan_pulang']){
							///	$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
							//	$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
							//	$res[$ident]['jamscan_pulang'] = '';
							//}
						//}
					}else{
						if (!empty($res[$identK]['jamscan_masuk'])){
							if (!empty($res[$ident]['jamscan_masuk'])){
								if ($res[$ident]['jamscan_masuk'] > $res[$ident]['jamscan_pulang']){
									$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
									$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
									$res[$ident]['jamscan_pulang'] = '';
								}
							}else{
								if ($res[$identK]['jamscan_masuk'] > $res[$ident]['jamscan_pulang']){
									$res[$identK]['jamscan_pulang'] = $res[$ident]['jamscan_pulang'];
									$res[$identK]['presensipulang_id'] = $res[$ident]['presensipulang_id'];
									$res[$ident]['jamscan_pulang'] = '';
								}
							}
						}

					}
				}
			}

			if (empty($res[$ident]['jamscan_pulang']) && empty($res[$ident]['jamscan_keluar']) && empty($res[$ident]['jamscan_datang']) && empty($res[$ident]['jamscan_masuk'])){
				unset($res[$ident]);
			}
		}
         *
         */

		foreach($res as $key => $row){
				// perhitungan terlambat
				if ($row['verifikasi'] != true){
					if (!empty($row['shift_id']) && !empty($row['jamscan_masuk'])){
						if ($row['shift_jamawal'] < $row['shift_jamakhir']){
							if ($row['verifikasi'] != true){
								$shiftawal = date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['shift_jamawal'];
//								$shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));
                                                                $shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal)));

								$scantawal = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['jamscan_masuk']);
							}else{
								//$shiftawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjamasuk']);
								$shiftawal = date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['jamkerjamasuk'];
//								$shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));
                                                                $shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal)));

								$scantawal = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['jamscan_masuk']);
							}

							$jam = round(round(($scantawal - $shiftawal ) / 60,2));

							if ($row['jamscan_masuk'] > $row['shift_jamawal']){
								if ($jam > 0){
									$res[$key]['terlambat_mnt'] = $jam;
								}
							}
						}
					}else{
						$res[$key]['terlambat_mnt'] = '';
					}
				}

				//perhitungan pulang awal
				if ($row['verifikasi'] != true){
					if (!empty($row['shift_id'] && !empty($row['jamscan_pulang']))){
						if ($row['shift_jamawal'] < $row['shift_jamakhir']){
							if ($row['verifikasi'] != true){
								$shiftakhir = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['shift_jamakhir']);
								$scantakhir = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['jamscan_pulang']);
							}else{
								$shiftakhir = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['jamkerjapulang']);
								$scantakhir = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['jamscan_pulang']);
							}

							$jam = round(round(($shiftakhir - $scantakhir) / 60,2));

							if ($row['jamscan_pulang'] < $row['shift_jamakhir']){
								if ($jam > 0){
									$res[$key]['pulangawal_mnt'] = $jam;
								}
							}
						} else {
                            if ($row['verifikasi'] != true){
								$shiftakhir = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['shift_jamakhir']);
								$scantakhir = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['jamscan_pulang']);
							}else{
								$shiftakhir = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['jamkerjapulang']);
								$scantakhir = strtotime(date('Y-m-d', strtotime($row['tglpresensi'])).' '.$row['jamscan_pulang']);
							}

							$jam = round(round(($shiftakhir - $scantakhir) / 60,2));

							if ($row['jamscan_pulang'] < $row['shift_jamakhir']){
								if ($jam > 0){
									$res[$key]['pulangawal_mnt'] = $jam;
								}
							}
                        }
					}else{
						$res[$key]['pulangawal_mnt'] = '';
					}

				}

				//perhitungan status kehadiran

				if ($row['verifikasi'] != true){
					if (empty($row['jamscan_masuk']) || empty($row['jamscan_pulang'])){
                        $res[$key]['statuskehadiran_id'] =  Params::STATUSKEHADIRAN_ALPHA;
					}
				}else{
					// tidak ada perubahan
				}


				if (!empty($this->statusscan)){
					/*if (is_array($this->statusscan)){
						foreach($this->statusscan as $st){
							if (count((array)$this->statusscan) < 2){
								if ($st == 'terlambat'){
									if (empty($res[$key]['terlambat_mnt'] || $res[$key]['terlambat_mnt'] > 0)){
										unset($res[$key]);
									}

								}elseif ($st == 'pulangawal'){

									if (empty($res[$key]['pulangawal_mnt'] || $res[$key]['pulangawal_mnt'] > 0)){
										unset($res[$key]);
									}
								}
							}else{
								if (isset($res[$key])){
									if (empty($res[$key]['terlambat_mnt'] || $res[$key]['terlambat_mnt'] > 0) )){
										unset($res[$key]);
									}
								}
							}
						}
					}else{*/

					//}

					/*if ($this->statusscan == 'terlambat'){
						if (empty($res[$key]['terlambat_mnt'] || $res[$key]['terlambat_mnt'] > 0)){
							unset($res[$key]);
						}
					}elseif ($this->statusscan == 'pulangawal'){
						if (empty($res[$key]['pulangawal_mnt'] || $res[$key]['pulangawal_mnt'] > 0)){
							unset($res[$key]);
						}
					}*/
				}


		}


		$sk = array();
		// melakukan pengecekkan pencarian berdasarkan status kehadiran
		foreach ($res as $idx => $val){
			if (!empty($this->statuskehadiran_id)){
				if (is_array($this->statuskehadiran_id)){
					foreach ($this->statuskehadiran_id as $s){
						if ($val['statuskehadiran_id'] == $s){
							if (!empty(Params::getCekStatusHadir($val['statuskehadiran_id']))){
								$sk[$idx] = $val;
							}
						}
					}
				}else{
					if ($val['statuskehadiran_id'] == $this->statuskehadiran_id){
						if (!empty(Params::getCekStatusHadir($val['statuskehadiran_id']))){
							$sk[$idx] = $val;
						}
					}
				}
			}else{
				$sk[$idx] = $val;
			}
		}


		$mnt = array();
		// melakukan pengecekkan pencarian berdasarkan status kehadiran
		foreach ($sk as $idx => $val){
			if (!empty($this->statusscan)){

				if (is_array($this->statusscan)){
					foreach($this->statusscan as $m){
						if (!empty(Params::getCekStatusScan($m))){
							if ($m == 'terlambat'){
								if ($sk[$idx]['terlambat_mnt'] > 0){
									$mnt[$idx] = $val;
								}
							}

							if ($m == 'pulangawal'){
								if ($sk[$idx]['pulangawal_mnt'] > 0){
									$mnt[$idx] = $val;
								}
							}
						}
					}
				}else{
					if ($this->statusscan == 'terlambat'){
						if (is_numeric($sk[$idx]['terlambat_mnt'])){
							if ($sk[$idx]['terlambat_mnt'] > 0){
								$mnt[$idx] = $val;
							}
						}
					}elseif ($this->statusscan == 'pulangawal'){
						if (is_numeric($sk[$idx]['pulangawal_mnt'])){
							if ($sk[$idx]['pulangawal_mnt'] > 0){
								$mnt[$idx] = $val;
							}
						}
					}
				}
			}else{
				$mnt[$idx] = $val;
			}
		}

        $tanggal = array();
        $namapegawai = array();

		foreach ($mnt as $key => $row) {
            if (!empty($this->shift_id) && $row['shift_id'] != $this->shift_id) {
                unset($mnt[$key]);
            }

            if (!empty($this->statuskehadiran_id) && $row['statuskehadiran_id'] != $this->statuskehadiran_id) {
                unset($mnt[$key]);
            }

			if($row['tglpresensi'] == date('Y-m-d', strtotime($this->tglpresensi_akhir. '+1 days'))){
				unset($mnt[$key]);
			}else{
				if($row['tglpresensi'] == date('Y-m-d', strtotime($this->tglpresensi. '-1 days'))){
					unset($mnt[$key]);
				}
			}
		}

        foreach ($mnt as $key => $row) {
            $tanggal[$key]  = $row['tglpresensi'];
            $namapegawai[$key] = $row['urutannama'];
        }

		if (count((array)$mnt)>0){

			array_multisort($tanggal, SORT_ASC, $namapegawai, SORT_ASC, $mnt);
		}


		return $mnt;
	}

	public function searchInfoTable(){

		$res = $this->searchInformasiPresensiBaru();

		return new CArrayDataProvider($res, array(
			'keyField'=>'pegawai_id',
            'id'=>'data_laporan',
			'totalItemCount'=>count((array)$res),
			'pagination' => array(
				'pageSize' => 10,
				'pageVar' => 'page'
			),
		));
	}

	public function searchInfoTablePrint(){

		$res = $this->searchInformasiPresensiBaru();

		return new CArrayDataProvider($res, array(
			'keyField'=>'pegawai_id',
            'id'=>'data_laporan',
			'totalItemCount'=>count((array)$res),
			'pagination' => array(
				'pageSize' => count((array)$res),
				'pageVar' => 'page'
			),

		));
	}

	public function generateTotalKehadiran(){
		$res = $this->searchInformasiPresensiBaru();

		$get = array();
		$mnt = array();

		foreach($res as $val){

			if (!isset($get[$val['pegawai_id']])){

				$get[$val['pegawai_id']] = array(
					Params::STATUSKEHADIRAN_HADIR => 0,
					Params::STATUSKEHADIRAN_ALPHA => 0,
					Params::STATUSKEHADIRAN_DINAS => 0,
					Params::STATUSKEHADIRAN_IZIN => 0,
					Params::STATUSKEHADIRAN_SAKIT => 0,
                                        Params::STATUSKEHADIRAN_CUTI => 0
				);

				$mnt[$val['pegawai_id']] = array(
					'totalterlambat' => 0,
					'totalpulangawal' => 0
				);

				//pehitungan total terlambat
				if (!empty($val['shift_id']) && !empty($val['jamscan_masuk'])){
					if ($val['shift_jamawal'] < $val['shift_jamakhir']){
						if ($val['verifikasi'] != true){
							$shiftawal = date('Y-m-d', strtotime($val['tglpresensi'])).' '.$val['shift_jamawal'];
//							$shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));
                                                        $shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal)));

							$scantawal = strtotime(date('Y-m-d', strtotime($val['tglpresensi'])).' '.$val['jamscan_masuk']);
						}else{
							//$shiftawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjamasuk']);
							$shiftawal = date('Y-m-d', strtotime($val['tglpresensi'])).' '.$val['jamkerjamasuk'];
							$shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal)));
//                                                        $shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));

							$scantawal = strtotime(date('Y-m-d', strtotime($val['tglpresensi'])).' '.$val['jamscan_masuk']);
						}

						$jam = round(round(abs($shiftawal - $scantawal ) / 60,2));

						if ($val['jamscan_masuk'] > $val['shift_jamawal']){
							if ($jam > 0){
								$mnt[$val['pegawai_id']]['totalterlambat']	+= $jam;
							}
						}
					}
				}


				//pulang awal
				if (!empty($val['shift_id'] && !empty($val['jamscan_pulang']))){
					if ($val['shift_jamawal'] < $val['shift_jamakhir']){
						if ($val['verifikasi'] != true){
							$shiftakhir = strtotime(date('Y-m-d').' '.$val['shift_jamakhir']);
							$scantakhir = strtotime(date('Y-m-d').' '.$val['jamscan_pulang']);
						}else{
							$shiftakhir = strtotime(date('Y-m-d').' '.$val['jamkerjapulang']);
							$scantakhir = strtotime(date('Y-m-d').' '.$val['jamscan_pulang']);
						}

						$jam = round(round(abs($scantakhir - $shiftakhir) / 60,2));

						if ($val['jamscan_pulang'] < $val['shift_jamakhir']){
							if ($jam > 0){
								$mnt[$val['pegawai_id']]['totalpulangawal']	+= $jam;
							}
						}
					}
				}


				// perhitungan total kehadiran
				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_HADIR){
					if ($val['verifikasi'] != true){
						if (empty($val['jamscan_masuk'])){
							$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_ALPHA] += 1;
						}else{
							$jamkerja = date("H:i:s",strtotime($val['shift_jamawal'].' +1 hours'));

							if (!empty($val['shift_id'])){
								if ($val['jamscan_masuk'] < $jamkerja){
									$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_HADIR] += 1;
								}

								if ($val['jamscan_masuk'] > $jamkerja){
									$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_ALPHA] += 1;
								}
							}else{
								$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_HADIR] += 1;
							}

						}
					}else{
						$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_HADIR] += 1;
					}
				}

				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_IZIN){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_IZIN] += 1;
				}

				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_SAKIT){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_SAKIT] += 1;
				}

				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_ALPHA){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_ALPHA] += 1;
				}

				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_DINAS){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_DINAS] += 1;
				}
                                if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_CUTI){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_CUTI] += 1;
				}
			}else{
				//perhitungan terlambat
				if (!empty($val['shift_id']) && !empty($val['jamscan_masuk'])){
					if ($val['shift_jamawal'] < $val['shift_jamakhir']){
						if ($val['verifikasi'] != true){
							$shiftawal = strtotime(date('Y-m-d').' '.$val['shift_jamawal']);
							$scantawal = strtotime(date('Y-m-d').' '.$val['jamscan_masuk']);
						}else{
							$shiftawal = strtotime(date('Y-m-d').' '.$val['jamkerjamasuk']);
							$scantawal = strtotime(date('Y-m-d').' '.$val['jamscan_masuk']);
						}

						$jam = round(round(abs($shiftawal - $scantawal ) / 60,2));

						if ($val['jamscan_masuk'] > $val['shift_jamawal']){
							if ($jam > 0){
								$mnt[$val['pegawai_id']]['totalterlambat']	+= $jam;
							}
						}
					}
				}

				//pulang awal
				if (!empty($val['shift_id'] && !empty($val['jamscan_pulang']))){
					if ($val['shift_jamawal'] < $val['shift_jamakhir']){
						if ($val['verifikasi'] != true){
							$shiftakhir = strtotime(date('Y-m-d').' '.$val['shift_jamakhir']);
							$scantakhir = strtotime(date('Y-m-d').' '.$val['jamscan_pulang']);
						}else{
							$shiftakhir = strtotime(date('Y-m-d').' '.$val['jamkerjapulang']);
							$scantakhir = strtotime(date('Y-m-d').' '.$val['jamscan_pulang']);
						}

						$jam = round(round(abs($scantakhir - $shiftakhir) / 60,2));

						if ($val['jamscan_pulang'] < $val['shift_jamakhir']){
							if ($jam > 0){
								$mnt[$val['pegawai_id']]['totalpulangawal']	+= $jam;
							}
						}
					}
				}

				//statuskehadiran
				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_HADIR){
					if ($val['verifikasi'] != true){
						if (empty($val['jamscan_masuk'])){
							$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_ALPHA] += 1;
						}else{
							$jamkerja = date("H:i:s",strtotime($val['shift_jamawal'].' +1 hours'));

							if (!empty($val['shift_id'])){
								if ($val['jamscan_masuk'] < $jamkerja){
									$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_HADIR] += 1;
								}

								if ($val['jamscan_masuk'] > $jamkerja){
									$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_ALPHA] += 1;
								}
							}else{
								$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_HADIR] += 1;
							}

						}
					}else{
						$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_HADIR] += 1;
					}
				}

				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_IZIN){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_IZIN] += 1;
				}

				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_SAKIT){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_SAKIT] += 1;
				}

				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_ALPHA){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_ALPHA] += 1;
				}

				if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_DINAS){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_DINAS] += 1;
				}

                                if ($val['statuskehadiran_id'] == Params::STATUSKEHADIRAN_CUTI){
					$get[$val['pegawai_id']][Params::STATUSKEHADIRAN_CUTI] += 1;
				}
			}

		}

		$data['totalkehadiran'] = $get;
		$data['menit'] = $mnt;

		return $data;


	}


    public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

            $criteria=new CDbCriteria;
            $criteria->with = array('statusscan','pegawai', 'statuskehadiran');
            $criteria->compare('t.presensi_id',$this->presensi_id);
            $criteria->compare('t.statusscan_id',$this->statusscan_id);
            $criteria->compare('t.pegawai_id',$this->pegawai_id);
            //$criteria->compare('t.statuskehadiran_id',$this->statuskehadiran_id);
            $criteria->addBetweenCondition('date(t.tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir);
            $criteria->compare('t.no_fingerprint',$this->no_fingerprint,true);
            $criteria->compare('t.verifikasi',$this->verifikasi);
            $criteria->compare('t.keterangan',$this->keterangan,true);
            $criteria->compare('t.create_time',$this->create_time,true);
            $criteria->compare('t.user_id',$this->user_id);
            $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(statusscan.statusscan_nama)',strtolower($this->statusscan_nama),true);
            //$criteria->compare('LOWER(statuskehadiran.statuskehadiran_nama)',strtolower($this->statuskehadiran_nama),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
		));

        }

    public function detailPresensi()
    {
        $criteria=new CDbCriteria;
        $criteria->select = 'date(t.tglpresensi) as datepresensi, t.pegawai_id, t.no_fingerprint';
        $criteria->order = 'date(t.tglpresensi)';
        $criteria->group = 'date(t.tglpresensi), t.pegawai_id, t.no_fingerprint';
        $criteria->addBetweenCondition('DATE(tglpresensi)', $this->tglpresensi, $this->tglpresensi_akhir);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        return new CActiveDataProvider($this,
            array(
                'criteria'=>$criteria
            )
        );
    }

    public function printDetailPresensi()
    {
        $criteria=new CDbCriteria;
        $criteria->select = 'date(t.tglpresensi) as datepresensi, t.pegawai_id, t.no_fingerprint';
        $criteria->order = 't.pegawai_id, date(t.tglpresensi)';
        $criteria->group = 'date(t.tglpresensi), t.pegawai_id, t.no_fingerprint';
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->addBetweenCondition('DATE(tglpresensi)', $this->tglpresensi, $this->tglpresensi_akhir);
        return new CActiveDataProvider($this,
            array(
                'criteria'=>$criteria,
                'pagination'=>false
            )
        );
    }

    public function criteriaPresensi()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->select = 'date(t.tglpresensi) as datepresensi, t.pegawai_id, t.no_fingerprint';
        $criteria->order = 'date(t.tglpresensi) ASC, pegawai_m.nama_pegawai ASC';
        $criteria->group = 'date(t.tglpresensi), t.pegawai_id, t.no_fingerprint, pegawai_m.nama_pegawai';
        $criteria->join = 'JOIN pegawai_m ON pegawai_m.pegawai_id=t.pegawai_id';
        $criteria->addBetweenCondition('DATE(tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir);
        $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
        $criteria->compare('kategoripegawai',$this->kategoripegawai);
        $criteria->compare('nofingerprint',$this->no_fingerprint);
        $criteria->compare('pegawai_m.unit_perusahaan',$this->unit_perusahaan);
		if (!empty($this->jenistenagamedis_id)){
			$criteria->addInCondition("jenistenagamedis_id",$this->jenistenagamedis_id);
		}
		if (!empty($this->kelompokjabatan)){
			$criteria->addInCondition("kelompokjabatan",$this->kelompokjabatan);
		}
		if (!empty($this->kategoripegawaiasal)){
			$criteria->addInCondition("kategoripegawaiasal",$this->kategoripegawaiasal);
		}

        if(!empty($this->ruangan_id))
        {
            $criteria_dua = new CDbCriteria;
            $criteria_dua->compare('ruangan_id', $this->ruangan_id);
            $record = RuanganpegawaiM::model()->findAll($criteria_dua);
            $pegawai = array();
            $is_exist = null;
            foreach($record as $val)
            {
                if($is_exist != $val->pegawai_id)
                {
                    $pegawai[] = $val->pegawai_id;
                }
                $is_exist = $val->pegawai_id;
            }
            $criteria->compare('pegawai_m.pegawai_id',$pegawai);
        }

        return $criteria;
    }

    public function searchPresensi()
    {
        return new CActiveDataProvider($this, array(
            'criteria'=>$this->criteriaPresensi(),
            'pagination'=>array(
                'pageSize'=>10,
            )
        ));
    }

    public function searchPrintpresensi()
    {
        return new CActiveDataProvider($this, array(
            'criteria'=>$this->criteriaPresensi(),
            'pagination'=>false,
        ));
    }

    public function getTerlambat($tglpresensi, $jamkerjamasuk)
    {
        $tepat = strtotime($tglpresensi);
        $masuk = strtotime(date('Y-m-d',  strtotime($tglpresensi)).' '.$jamkerjamasuk);

        return round(($tepat - $masuk) / 60);
        //$this->jamkerjamasuk
    }

    public function getPulangAwal($tglpresensi, $jamkerjamasuk)
    {
        $tepat = strtotime($tglpresensi);
        $pulang = strtotime(date('Y-m-d',  strtotime($tglpresensi)).' '.$jamkerjamasuk);

        return round(($pulang - $tepat) / 60);
    }

                public function getStatusItems()
                {
                    return StatuskehadiranM::model()->findAll();
                }
    public function getNamaModel(){
        return __CLASS__;
    }

    public function getShiftId($pegawai_id){
        $shift_id = KPPegawaiM::model()->findByPk($pegawai_id)->shift_id;

        if (!empty($shift_id)){
            return KPShiftM::model()->findByPk($shift_id);
        }else{
            return '';
        }
    }

	public function getJenisTenagaMedisItems(){
		return JenistenagamedisM::model()->findAllByAttributes(array('jenistenagamedis_aktif'=>TRUE), array('order'=>'tenagamedis_nama asc'));
	}
}
