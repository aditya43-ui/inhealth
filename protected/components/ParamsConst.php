<?php

/**
 * untuk semua hardcode Url path
 */
Class ParamsConst {
    
    //tipe barang
    const TYPE_BARANG_ASET = 'Aset';
    const TYPE_BARANG_HABIS_PAKAI = 'Habis Pakai';
    const TYPE_BARANG_PAKAI_HABIS = 'Pakai Habis';
    const TYPE_BARANG_INVENTARIS = 'Inventaris';
    const DEFAULT_PERIKSAFISIK_GCS_EYE = 4;
    const DEFAULT_PERIKSAFISIK_GCS_VERBAL = 5;
    const DEFAULT_PERIKSAFISIK_GCS_MOTORIK = 6;
    // ipm ceklis
    const IPM_JENIS_NON_IPM = 'NON IPM CHECKLIST';
    
    // golongan barang
    const GOLONGAN_KODE_TANAH = '01';
    const GOLONGAN_KODE_PERALATAN_MESIN = '02';
    const GOLONGAN_KODE_GEDUNG_BANGUNAN = '03';
    const GOLONGAN_KODE_JALAN_IRIGASI_JARINGAN = '04';
    const GOLONGAN_KODE_ASET_TETAP_LAINNYA = '05';
    const GOLONGAN_KODE_KONSTRUKSI = '06';
    const GOLONGAN_KODE_BAHAN = '07';
    const GOLONGAN_KODE_LOGISTIK = '08';
    
    //kode golongan
    const KODE_GOLONGAN_MESIN_ALAT = '02';
    const KODE_GOLONGAN_GEDUNG_BANGUNAN = '03';   
    
    //STATUS DOKUMEN
    const STATUSDOKUMENOPEN = 'Open';
    const STATUSDOKUMENINPROGRESS = 'In Progress';
    const STATUSDOKUMENFINISH = 'Finish';
    const STATUSDOKUMENPENDING = 'Pending';
    const STATUSDOKUMENCLOSE = 'Close';
    
    //ruangan_id
    const RUANGAN_ID_SARANA_MEDIK_I = 1111;
    const RUANGAN_ID_SARANA_MEDIK_II = 1110;
    
    //modul
    const MODUL_ID_MANAJEMEN_ASET = 47;
    
    //jenis jurnal    
    const JENISJURNAL_ID_REEVALUASI = 13;
    const JENISJURNAL_ID_INVENTARISASI_ASET = 14;
    const JENISJURNAL_ID_PENJUALAN_ASET = 15;
    
    //untuk status pemeliharaan work order
    const STATUS_WO_BELUM = 'BELUM'; //diambil dari lookup (kondisi lookup_type = status_pemeliharaan)
    const STATUS_WO_SEDANG = 'SEDANG'; //diambil dari lookup (kondisi lookup_type = status_pemeliharaan)
    const STATUS_WO_SUDAH = 'SUDAH'; //diambil dari lookup (kondisi lookup_type = status_pemeliharaan)
    const STATUS_WO_OPEN = 'Open'; //diambil dari lookup (kondisi lookup_type = status_pemeliharaan)
    const STATUS_WO_PROGRESS = 'In Progress'; //diambil dari lookup (kondisi lookup_type = status_pemeliharaan)
    const STATUS_WO_FINISH = 'Finish'; //diambil dari lookup (kondisi lookup_type = status_pemeliharaan)
    const STATUS_WO_CLOSE = 'Close'; //diambil dari lookup (kondisi lookup_type = status_pemeliharaan)
    const STATUS_WO_PENDING = 'Pending'; //diambil dari lookup (kondisi lookup_type = status_pemeliharaan)
    
    //macam - macam jenis teknisi
    const JENIS_TEKNISI_INTERNAL = 'Internal'; //diambil dari lookup (kondisi lookup_type = jenisteknisi)
    const JENIS_TEKNISI_EKSTERNAL = 'Eksternal'; //diambil dari lookup (kondisi lookup_type = jenisteknisi)
    
    //untuk status mutasi aset
    const STATUS_MUTASI_ASET_BELUM = 'BELUM DITERIMA';
    const STATUS_MUTASI_ASET_SUDAH = 'SUDAH DITERIMA';
    const STATUS_MUTASI_ASET_BATAL = 'BATAL DITERIMA'; 
    
    //unitkerja
    const UNITKERJA_ID_SUB_BAGIAN_PERLENGKAPAN_ASET = 153;
    
    //barang kategori
    const BARANG_KATEGORI_MEDIS = 'MEDIS';
    const BARANG_KATEGORI_NON_MEDIS = 'NON MEDIS';
    
    const INSTALASI_ID_HEMODIALISA = 83;
    
    // jenis form survey
    const JENIS_FORM_SURVEY_ID_KARYAWAN = 2;
    const JENIS_FORM_SURVEY_ID_PTSA = 6;
    
    
    //ruangan id
    const RUANGAN_ID_KEUANGAN = 43;
    const RUANGAN_ID_TATA_USAHA = 812;
    const RUANGAN_ID_POLIK_MATA = 447;
    
    //unitkerja
    const UNITKERJA_ID_TATAUSAHA = 98;
    
    //surat keterangan
    const SURAT_KETERANGAN_PEMERIKSAAN_MATA_ID = 5;
    
    //hubungan keluarga
    const HUBUNGAN_DGN_PASIEN = 'DIRI SENDIRI';

    //kelompok tindakan
    const KELOMPOKTINDAKAN_ID_PEL_BANK_DARAH = 30;
    
    //status barcode
    const STATUSBARCODE_ANTRIAN_PENDING = 'Pending';
    const STATUSBARCODE_ANTRIAN_SELESAIPENDING = 'Selesai Pending';
    const STATUSBARCODE_ANTRIAN_TERLAMBAT = 'Terlambat';
    const STATUSBARCODE_ANTRIAN_BELUMBARCODE = 'Belum Barcode';
    const STATUSBARCODE_ANTRIAN_SUDAHBARCODE = 'Sudah Barcode';
    const STATUSBARCODE_ANTRIAN_PROSES = 'Proses';
    
    //status panggil
    const STATUSPANGGIL_ANTRIAN_TUNGGU = 'Tunggu';
    const STATUSPANGGIL_ANTRIAN_CALLOUTSIDE = 'Call Outside';  
    const STATUSPANGGIL_ANTRIAN_SELESAI = 'Selesai';
    
    //jenis kunjungan antrian
    CONST JENIS_KUNJUNGAN_ANTRIAN_RSERVASI = 'Reservasi';
    CONST JENIS_KUNJUNGAN_ANTRIAN_FASTTRACK = 'Fast Track';
    
    /**
     * - digunakan untuk memberikan warna pada status corrective maintance
     * @param  type $status
     * @return string     
     */
    public static function getWrStatusCorrective($status, $click = []) {
        $status = trim($status);
        $onclick = '';
        if (ucwords($status) == self::STATUSDOKUMENOPEN) {
            $warna = 'btn-danger';
        } else if ($status == self::STATUSDOKUMENINPROGRESS) {
            $warna = 'btn-blue';
        } else if ($status == self::STATUSDOKUMENPENDING) {
            $warna = 'btn-gold';
        } else if ($status == self::STATUSDOKUMENFINISH) {
            $onclick = !empty($click[$status]) ? $click[$status] : null;
            $warna = 'btn-info';
        } else if ($status == self::STATUSDOKUMENCLOSE) {
            $warna = 'btn-success';
        } else {
            $warna = 'btn-purple';
        }

        $button = '<button style="width:120px;" id="red" class="btn ' . $warna . '" name="yt1" onclick="' . $onclick . '">' . $status . '</button>';

        return $button;
    }
    
    /**
     * @author M Iqbal Laksana
     * @param  type $status
     * @return string
     * - digunakan untuk memberikan warna pada status mutasi aset
     */
    public static function getWrStatusMutasiAset($status, $data = null, $dis = '') {
        $status = trim($status);
        if ($status == self::STATUS_MUTASI_ASET_SUDAH) {
            $status = '<button class="btn btn-success nohover">' . $status . '</button>';
        } elseif ($status == self::STATUS_MUTASI_ASET_BATAL) {
            $status = '<button class="btn btn-danger nohover">' . $status . '</button>';
        } elseif ($status == self::STATUS_MUTASI_ASET_BELUM) {
            if ($data->penerima_id == Yii::app()->user->getState('pegawai_id')) {
                $status = '<button ' . $dis . ' rel="tooltip" title="Silahkan klik, untuk menerima, mutasi aset" class="btn btn-info btn-icon" onclick="ubahStatus(\'' . self::STATUS_MUTASI_ASET_SUDAH . '\',' . $data->mutasiaset_id . ')">' . $status . '<i class="' . MyIcon::getIcons('simpan') . '"></i></button>';
                $status .= '<button ' . $dis . ' rel="tooltip" title="Silahkan klik, untuk membatalkan mutasi aset" class="btn btn-danger " style="height:29px;position:relative;padding:0px"  onclick="ubahStatus(\'' . self::STATUS_MUTASI_ASET_BATAL . '\',' . $data->mutasiaset_id . ')"><i class="' . MyIcon::getIcons('batal') . '"></i></button>';
            } else {
                if (!empty($data->penerima_id)) {
                    $status = '<button ' . $dis . ' rel="tooltip" title="Silahkan klik, untuk menerima, mutasi aset" class="btn btn-info btn-icon" onclick="myAlert(\'Hanya <b>' . $data->namaLengkapPenerima . '</b> yang diizinkan untuk mengubah status ini\')">' . $status . '<i class="' . MyIcon::getIcons('simpan') . '"></i></button>';
                    $status .= '<button ' . $dis . ' rel="tooltip" title="Silahkan klik, untuk membatalkan mutasi aset" class="btn btn-danger " style="height:29px;position:relative;padding:0px"  onclick="myAlert(\'Hanya <b>' . $data->namaLengkapPenerima . '</b> yang diizinkan untuk mengubah status ini\')"><i class="' . MyIcon::getIcons('batal') . '"></i></button>';
                } else {
                    $status = '<button ' . $dis . ' rel="tooltip" title="Silahkan klik, untuk menerima, mutasi aset" class="btn btn-info btn-icon" onclick="ubahStatus(\'' . self::STATUS_MUTASI_ASET_SUDAH . '\',' . $data->mutasiaset_id . ')">' . $status . '<i class="' . MyIcon::getIcons('simpan') . '"></i></button>';
                    $status .= '<button ' . $dis . ' rel="tooltip" title="Silahkan klik, untuk membatalkan mutasi aset" class="btn btn-danger" style="height:29px;position:relative;padding:0px"  onclick="ubahStatus(\'' . self::STATUS_MUTASI_ASET_BATAL . '\',' . $data->mutasiaset_id . ')"><i class="' . MyIcon::getIcons('batal') . '"></i></button>';
                }
            }
        }
        return $status;
    }
    
    /**
     * - digunakan untuk memberikan warna pada status operasi
     * @param  type $status
     * @return string     
     */
    public static function getWrStatusWo($status, $click = []) {
        $status = trim($status);
        $onclick = '';
        if (ucwords($status) == self::STATUS_WO_OPEN) {
            $warna = 'btn-danger';
        } else if ($status == self::STATUS_WO_PROGRESS) {
            $warna = 'btn-blue';
        } else if ($status == self::STATUS_WO_FINISH) {
            $warna = 'btn-info';
        } else if ($status == self::STATUS_WO_CLOSE) {
            $warna = 'btn-success';
        } else {
            $warna = 'btn-purple';
        }

        $button = '<button style="width:120px;" id="red" class="btn ' . $warna . '" name="yt1" onclick="' . $onclick . '">' . $status . '</button>';

        return $button;
    }
    
   
}

?>
