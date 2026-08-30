<?php

class PCObatalkesPasienT extends ObatalkespasienT
{
        public $qty_selisih,$jmlstok,$stokobatalkes_id,$no_pendaftaran,$tgl_pendaftaran,$ruangan_nama,$kelaspelayanan_nama,$jeniskasuspenyakit_id,$jeniskasuspenyakit_nama;
        public $carabayar_nama,$penjamin_nama,$no_rekam_medik,$namadepan,$nama_pasien,$nama_bin,$tanggal_lahir,$umur,$jeniskelamin,$penanggungjawab_id,$nama_pj,$alamat_pasien;
        public $satuankecil_nama;
        public $permohonanoadetail_id;
        public $is_pilihoa = 1;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
         
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}