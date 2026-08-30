<?php

class PPSepT extends SepT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SepT the static model class
	 */
		public $nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $lakalantas, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans, $lokasilakalantas, $jenisfaskes, $skenario;
	public $klsRawatNaik;
	public $no_rekam_medik, $nopeserta, $pasien_id, $penjamin_id, $carabayar_id;
	public $asuransipasien_id, $namapemilikasuransi, $jenispeserta_id, $pendaftaran_id, $kelastanggungan_id;
	public $barcode_sep, $cari_sep, $surat_rujukan, $nama_peserta, $jeniskelamin;
	public $nama_pasien, $klsrawat_nama, $kelaspelayanan_nama, $no_pendaftaran, $tgl_pendaftaran, $no_identitas_pasien;
	public $jenis_rujukan, $ppkpelayanan_nama, $jenispelayanan, $kelastanggungan, $ppkrujukan_nama;
	public $is_polieksekutif, $is_cob, $is_lakalantas, $pembuat_sep;
	public $tgl_awal, $tgl_akhir, $politujuan_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}