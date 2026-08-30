<?php

/**
 * This is the model class for table "tindakanpelayanan_t".
 *
 * The followings are the available columns in table 'tindakanpelayanan_t':
 * @property integer $tindakanpelayanan_id
 * @property integer $penjamin_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $kelaspelayanan_id
 * @property integer $tipepaket_id
 * @property integer $instalasi_id
 * @property integer $pendaftaran_id
 * @property integer $shift_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $daftartindakan_id
 * @property integer $carabayar_id
 * @property integer $jeniskasuspenyakit_id
 * @property string $tgl_tindakan
 * @property double $tarif_tindakan
 * @property string $satuantindakan
 * @property string $qty_tindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property string $dokterpemeriksa1_id
 * @property string $dokterpemeriksa2_id
 * @property string $dokterpendamping_id
 * @property string $dokteranastesi_id
 * @property string $dokterdelegasi_id
 * @property string $bidan_id
 * @property string $suster_id
 * @property string $perawat_id
 * @property integer $kelastanggungan_id
 * @property double $discount_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $subsidipemerintah_tindakan
 * @property double $subsisidirumahsakit_tindakan
 * @property double $iurbiaya_tindakan
 * @property string $tm 
 * 
 * @property string $kategoriTindakanNama
 * @property string $daftartindakanNama
 * @property double $jumlahTarif
 * @property double $persenCyto
 * 
 * @property double $tarif_satuan
 * @property integer $rencanaoperasi_id
 * @property integer $hasilpemeriksaanpa_id
 * @property integer $hasilpemeriksaanrm_id
 * @property integer $konsulpoli_id
 * @property integer $hasilpemeriksaanrad_id
 * @property integer $detailhasilpemeriksaanlab_id
 * 
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $rencanatindakan_id
 */
class ATTindakanpelayananT extends TindakanpelayananT
{

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}