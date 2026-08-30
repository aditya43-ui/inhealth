<?php

class FAObatalkesPasienT extends ObatalkespasienT
{
        public $qty_selisih,$jmlstok,$stokobatalkes_id,$no_pendaftaran,$tgl_pendaftaran,$ruangan_nama,$kelaspelayanan_nama,$jeniskasuspenyakit_id,$jeniskasuspenyakit_nama;
        public $carabayar_nama,$penjamin_nama,$no_rekam_medik,$namadepan,$nama_pasien,$nama_bin,$tanggal_lahir,$umur,$jeniskelamin,$penanggungjawab_id,$nama_pj,$alamat_pasien;
        public $satuankecil_nama;
        public $permohonanoadetail_id;
        public $is_pilihoa = 1;
		public $therapiobat_id,$iter;
		public $qty_reseptur,$qty_dilayani,$hargajual_reseptur,$signa_reseptur,$hargasatuan_reseptur,$harganetto_reseptur, $temp_permintaan_dosis, $ppnperobat, $admracikan, $administrasi, $sumberdana_nama;

		public $statusobat, $racikan_nama, $qty_oa, $signa_oa, $jumlahpermintaan_obatracikan, $satuansediaan, $st_fornas;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
         
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getObatAlkesNama(){
		$obatalkes_id = $this->obatalkes_id;
		$modOa = FAObatalkesM::model()->findByPk($obatalkes_id);
		return $modOa->obatalkes_nama;
	}

}