<?php

/**
 * This is the model class for table "obatalkespasien_t".
 *
 * The followings are the available columns in table 'obatalkespasien_t':
 * @property integer $obatalkespasien_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property integer $daftartindakan_id
 * @property integer $sumberdana_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property integer $satuankecil_id
 * @property integer $ruangan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $tipepaket_id
 * @property integer $obatalkes_id
 * @property integer $penjualanresep_id
 * @property integer $pegawai_id
 * @property integer $racikan_id
 * @property integer $pendaftaran_id
 * @property integer $kelaspelayanan_id
 * @property integer $shift_id
 * @property integer $pasienadmisi_id
 * @property string $tglpelayanan
 * @property string $r
 * @property integer $rke
 * @property integer $permintaan_oa
 * @property integer $jmlkemasan_oa
 * @property integer $kekuatan_oa
 * @property string $satuankekuatan_oa
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property string $signa_oa
 * @property double $harganetto_oa
 * @property double $hargajual_oa
 * @property string $etiket
 * @property double $jmlexposerad
 * @property string $kontrasrad
 * @property double $biayaservice
 * @property double $biayakonseling
 * @property double $jasadokterresep
 * @property double $biayakemasan
 * @property double $biayaadministrasi
 * @property double $tarifcyto
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property string $oa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruanganj
 * @property integer $permohonanoadetail_id
 */
class ATObatalkespasienT extends ObatalkespasienT {
	public $qty_stok,$stokobatalkes_id,$satuankecil_nama,$daftartindakan_nama,$obatalkes_nama,$qtypemakaian,$hargapemakaian,$hargajual,$anastesi_nama,$anastesi_id;
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
