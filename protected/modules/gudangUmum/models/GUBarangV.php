<?php
class GUBarangV extends BarangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BarangV the static model class
	 */
	public $invbarang_jenis,$qtystok,$invbarangdet_id,$inventarisasi, $subtotal;
        public $inventarisasi_qty_in, $inventarisasi_qty_out,$inventarisasi_qty_skrg;
        public $volume_fisik, $ruangan_id;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchBarang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->limit = 1000;
		if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
			$criteria->limit = 0;
		}

		if(!empty($this->golongan_id)){
			$criteria->addCondition('t.golongan_id = '.$this->golongan_id);
		}
		$criteria->compare('LOWER(t.golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(t.golongan_nama)',strtolower($this->golongan_nama),true);
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('t.kelompok_id = '.$this->kelompok_id);
		}
		$criteria->compare('LOWER(t.kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(t.kelompok_nama)',strtolower($this->kelompok_nama),true);
		if(!empty($this->subkelompok_id)){
			$criteria->addCondition('t.subkelompok_id = '.$this->subkelompok_id);
		}
		$criteria->compare('LOWER(t.subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(t.subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		if(!empty($this->bidang_id)){
			$criteria->addCondition('t.bidang_id = '.$this->bidang_id);
		}
		$criteria->compare('LOWER(t.bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(t.bidang_nama)',strtolower($this->bidang_nama),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('t.barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(t.barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(t.barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(t.barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(t.barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(t.barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(t.barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(t.barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(t.barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(t.barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(t.barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('t.barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('t.barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(t.barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('t.barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('LOWER(t.barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('t.barang_aktif',$this->barang_aktif);
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('t.invasetlain_id = '.$this->invasetlain_id);
		}
		if(!empty($this->asalaset_inventarisasiasetlain_id)){
			$criteria->addCondition('t.asalaset_inventarisasiasetlain_id = '.$this->asalaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(t.asalaset_inventarisasiasetlain_nama)',strtolower($this->asalaset_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(t.asalaset_inventarisasiasetlain_singkatan)',strtolower($this->asalaset_inventarisasiasetlain_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiasetlain_id)){
			$criteria->addCondition('t.lokasiaset_inventarisasiasetlain_id = '.$this->lokasiaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(t.lokasiaset_inventarisasiasetlain_kode)',strtolower($this->lokasiaset_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasiasetlain_namainstalasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namainstalasi),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasiasetlain_namabagian)',strtolower($this->lokasiaset_inventarisasiasetlain_namabagian),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasiasetlain_namalokasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiasetlain_id)){
			$criteria->addCondition('t.pemilikbarang_inventarisasiasetlain_id = '.$this->pemilikbarang_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasiasetlain_kode)',strtolower($this->pemilikbarang_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasiasetlain_nama)',strtolower($this->pemilikbarang_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(t.invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(t.invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		$criteria->compare('LOWER(t.invasetlain_namabrg)',strtolower($this->invasetlain_namabrg),true);
		$criteria->compare('LOWER(t.invasetlain_judulbuku)',strtolower($this->invasetlain_judulbuku),true);
		$criteria->compare('LOWER(t.invasetlain_spesifikasibuku)',strtolower($this->invasetlain_spesifikasibuku),true);
		$criteria->compare('LOWER(t.invasetlain_asalkesenian)',strtolower($this->invasetlain_asalkesenian),true);
		$criteria->compare('t.invasetlain_jumlah',$this->invasetlain_jumlah);
		$criteria->compare('LOWER(t.invasetlain_thncetak)',strtolower($this->invasetlain_thncetak),true);
		$criteria->compare('t.invasetlain_harga',$this->invasetlain_harga);
		$criteria->compare('LOWER(t.invasetlain_tglguna)',strtolower($this->invasetlain_tglguna),true);
		$criteria->compare('t.invasetlain_akumsusut',$this->invasetlain_akumsusut);
		$criteria->compare('LOWER(t.invasetlain_ket)',strtolower($this->invasetlain_ket),true);
		$criteria->compare('LOWER(t.invasetlain_penciptakesenian)',strtolower($this->invasetlain_penciptakesenian),true);
		$criteria->compare('LOWER(t.invasetlain_bahankesenian)',strtolower($this->invasetlain_bahankesenian),true);
		$criteria->compare('LOWER(t.invasetlain_jenishewan_tum)',strtolower($this->invasetlain_jenishewan_tum),true);
		$criteria->compare('LOWER(t.invasetlain_ukuranhewan_tum)',strtolower($this->invasetlain_ukuranhewan_tum),true);
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('t.invtanah_id = '.$this->invtanah_id);
		}
		if(!empty($this->asalaset_inventarisasitanah_id)){
			$criteria->addCondition('t.asalaset_inventarisasitanah_id = '.$this->asalaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(t.asalaset_inventarisasitanah_nama)',strtolower($this->asalaset_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(t.asalaset_inventarisasitanah_singkatan)',strtolower($this->asalaset_inventarisasitanah_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasitanah_id)){
			$criteria->addCondition('t.lokasiaset_inventarisasitanah_id = '.$this->lokasiaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(t.lokasiaset_inventarisasitanah_kode)',strtolower($this->lokasiaset_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasitanah_namainstalasi)',strtolower($this->lokasiaset_inventarisasitanah_namainstalasi),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasitanah_namabagian)',strtolower($this->lokasiaset_inventarisasitanah_namabagian),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasitanah_namalokasi)',strtolower($this->lokasiaset_inventarisasitanah_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasitanah_id)){
			$criteria->addCondition('t.pemilikbarang_inventarisasitanah_id = '.$this->pemilikbarang_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasitanah_kode)',strtolower($this->pemilikbarang_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasitanah_nama)',strtolower($this->pemilikbarang_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(t.invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(t.invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		$criteria->compare('LOWER(t.invtanah_namabrg)',strtolower($this->invtanah_namabrg),true);
		$criteria->compare('LOWER(t.invtanah_luas)',strtolower($this->invtanah_luas),true);
		$criteria->compare('LOWER(t.invtanah_thnpengadaan)',strtolower($this->invtanah_thnpengadaan),true);
		$criteria->compare('LOWER(t.invtanah_tglguna)',strtolower($this->invtanah_tglguna),true);
		$criteria->compare('LOWER(t.invtanah_alamat)',strtolower($this->invtanah_alamat),true);
		$criteria->compare('LOWER(t.invtanah_status)',strtolower($this->invtanah_status),true);
		$criteria->compare('LOWER(t.invtanah_tglsertifikat)',strtolower($this->invtanah_tglsertifikat),true);
		$criteria->compare('LOWER(t.invtanah_nosertifikat)',strtolower($this->invtanah_nosertifikat),true);
		$criteria->compare('LOWER(t.invtanah_penggunaan)',strtolower($this->invtanah_penggunaan),true);
		$criteria->compare('t.invtanah_harga',$this->invtanah_harga);
		$criteria->compare('LOWER(t.invtanah_ket)',strtolower($this->invtanah_ket),true);
		$criteria->compare('t.invtanah_umurekonomis',$this->invtanah_umurekonomis);
		$criteria->compare('t.invtanah_nilairesidu',$this->invtanah_nilairesidu);
		$criteria->compare('LOWER(t.tglpenghapusan)',strtolower($this->tglpenghapusan),true);
		$criteria->compare('LOWER(t.tipepenghapusan)',strtolower($this->tipepenghapusan),true);
		$criteria->compare('t.hargajualaktiva',$this->hargajualaktiva);
		$criteria->compare('t.kerugian',$this->kerugian);
		$criteria->compare('t.keuntungan',$this->keuntungan);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('t.invperalatan_id = '.$this->invperalatan_id);
		}
		if(!empty($this->asalaset_inventarisasiperalatan_id)){
			$criteria->addCondition('t.asalaset_inventarisasiperalatan_id = '.$this->asalaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(t.asalaset_inventarisasiperalatan_nama)',strtolower($this->asalaset_inventarisasiperalatan_nama),true);
		$criteria->compare('LOWER(t.asalaset_inventarisasiperalatan_singkatan)',strtolower($this->asalaset_inventarisasiperalatan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiperalatan_id)){
			$criteria->addCondition('t.lokasiaset_inventarisasiperalatan_id = '.$this->lokasiaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(t.lokasiaset_inventarisasiperalatan_kode)',strtolower($this->lokasiaset_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasiperalatan_namainstalasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namainstalasi),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasiperalatan_namabagian)',strtolower($this->lokasiaset_inventarisasiperalatan_namabagian),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasiperalatan_namalokasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiperalatan_id)){
			$criteria->addCondition('t.pemilikbarang_inventarisasiperalatan_id = '.$this->pemilikbarang_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasiperalatan_kode)',strtolower($this->pemilikbarang_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasiperalatan_nama)',strtolower($this->pemilikbarang_inventarisasiperalatan_nama),true);
		$criteria->compare('LOWER(t.invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(t.invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		$criteria->compare('LOWER(t.invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
		$criteria->compare('LOWER(t.invperalatan_merk)',strtolower($this->invperalatan_merk),true);
		$criteria->compare('LOWER(t.invperalatan_ukuran)',strtolower($this->invperalatan_ukuran),true);
		$criteria->compare('LOWER(t.invperalatan_bahan)',strtolower($this->invperalatan_bahan),true);
		$criteria->compare('LOWER(t.invperalatan_thnpembelian)',strtolower($this->invperalatan_thnpembelian),true);
		$criteria->compare('LOWER(t.invperalatan_tglguna)',strtolower($this->invperalatan_tglguna),true);
		$criteria->compare('LOWER(t.invperalatan_nopabrik)',strtolower($this->invperalatan_nopabrik),true);
		$criteria->compare('LOWER(t.invperalatan_norangka)',strtolower($this->invperalatan_norangka),true);
		$criteria->compare('LOWER(t.invperalatan_nomesin)',strtolower($this->invperalatan_nomesin),true);
		$criteria->compare('LOWER(t.invperalatan_nopolisi)',strtolower($this->invperalatan_nopolisi),true);
		$criteria->compare('LOWER(t.invperalatan_nobpkb)',strtolower($this->invperalatan_nobpkb),true);
		$criteria->compare('t.invperalatan_harga',$this->invperalatan_harga);
		$criteria->compare('t.invperalatan_akumsusut',$this->invperalatan_akumsusut);
		$criteria->compare('LOWER(t.invperalatan_ket)',strtolower($this->invperalatan_ket),true);
		$criteria->compare('LOWER(t.invperalatan_kapasitasrata)',strtolower($this->invperalatan_kapasitasrata),true);
		$criteria->compare('t.invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
		$criteria->compare('LOWER(t.invperalatan_serftkkalibrasi)',strtolower($this->invperalatan_serftkkalibrasi),true);
		if(!empty($this->invperalatan_umurekonomis)){
			$criteria->addCondition('t.invperalatan_umurekonomis = '.$this->invperalatan_umurekonomis);
		}
		$criteria->compare('LOWER(t.invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('t.invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->asalaset_inventarisasigedung_id)){
			$criteria->addCondition('t.asalaset_inventarisasigedung_id = '.$this->asalaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(t.asalaset_inventarisasigedung_nama)',strtolower($this->asalaset_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(t.asalaset_inventarisasigedung_singkatan)',strtolower($this->asalaset_inventarisasigedung_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasigedung_id)){
			$criteria->addCondition('t.lokasiaset_inventarisasigedung_id = '.$this->lokasiaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(t.lokasiaset_inventarisasigedung_kode)',strtolower($this->lokasiaset_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasigedung_namainstalasi)',strtolower($this->lokasiaset_inventarisasigedung_namainstalasi),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasigedung_namabagian)',strtolower($this->lokasiaset_inventarisasigedung_namabagian),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasigedung_namalokasi)',strtolower($this->lokasiaset_inventarisasigedung_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasigedung_id)){
			$criteria->addCondition('t.pemilikbarang_inventarisasigedung_id = '.$this->pemilikbarang_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasigedung_kode)',strtolower($this->pemilikbarang_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasigedung_nama)',strtolower($this->pemilikbarang_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(t.invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(t.invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		$criteria->compare('LOWER(t.invgedung_namabrg)',strtolower($this->invgedung_namabrg),true);
		$criteria->compare('LOWER(t.invgedung_kontruksi)',strtolower($this->invgedung_kontruksi),true);
		$criteria->compare('t.invgedung_luaslantai',$this->invgedung_luaslantai);
		$criteria->compare('LOWER(t.invgedung_alamat)',strtolower($this->invgedung_alamat),true);
		$criteria->compare('LOWER(t.invgedung_tgldokumen)',strtolower($this->invgedung_tgldokumen),true);
		$criteria->compare('LOWER(t.invgedung_tglguna)',strtolower($this->invgedung_tglguna),true);
		$criteria->compare('LOWER(t.invgedung_nodokumen)',strtolower($this->invgedung_nodokumen),true);
		$criteria->compare('t.invgedung_harga',$this->invgedung_harga);
		$criteria->compare('t.invgedung_akumsusut',$this->invgedung_akumsusut);
		$criteria->compare('LOWER(t.invgedung_ket)',strtolower($this->invgedung_ket),true);
		if(!empty($this->invgedung_umurekonomis)){
			$criteria->addCondition('t.invgedung_umurekonomis = '.$this->invgedung_umurekonomis);
		}
		$criteria->compare('t.invgedung_nilairesidu',$this->invgedung_nilairesidu);
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('t.invjalan_id = '.$this->invjalan_id);
		}
		if(!empty($this->asalaset_inventarisasijalan_id)){
			$criteria->addCondition('t.asalaset_inventarisasijalan_id = '.$this->asalaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(t.asalaset_inventarisasijalan_nama)',strtolower($this->asalaset_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(t.asalaset_inventarisasijalan_singkatan)',strtolower($this->asalaset_inventarisasijalan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasijalan_id)){
			$criteria->addCondition('t.lokasiaset_inventarisasijalan_id = '.$this->lokasiaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(t.lokasiaset_inventarisasijalan_kode)',strtolower($this->lokasiaset_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasijalan_namainstalasi)',strtolower($this->lokasiaset_inventarisasijalan_namainstalasi),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasijalan_namabagian)',strtolower($this->lokasiaset_inventarisasijalan_namabagian),true);
		$criteria->compare('LOWER(t.lokasiaset_inventarisasijalan_namalokasi)',strtolower($this->lokasiaset_inventarisasijalan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasijalan_id)){
			$criteria->addCondition('t.pemilikbarang_inventarisasijalan_id = '.$this->pemilikbarang_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasijalan_kode)',strtolower($this->pemilikbarang_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(t.pemilikbarang_inventarisasijalan_nama)',strtolower($this->pemilikbarang_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(t.invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(t.invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		$criteria->compare('LOWER(t.invjalan_namabrg)',strtolower($this->invjalan_namabrg),true);
		$criteria->compare('LOWER(t.invjalan_kontruksi)',strtolower($this->invjalan_kontruksi),true);
		$criteria->compare('LOWER(t.invjalan_panjang)',strtolower($this->invjalan_panjang),true);
		$criteria->compare('LOWER(t.invjalan_lebar)',strtolower($this->invjalan_lebar),true);
		$criteria->compare('LOWER(t.invjalan_luas)',strtolower($this->invjalan_luas),true);
		$criteria->compare('LOWER(t.invjalan_letak)',strtolower($this->invjalan_letak),true);
		$criteria->compare('LOWER(t.invjalan_tgldokumen)',strtolower($this->invjalan_tgldokumen),true);
		$criteria->compare('LOWER(t.invjalan_tglguna)',strtolower($this->invjalan_tglguna),true);
		$criteria->compare('LOWER(t.invjalan_nodokumen)',strtolower($this->invjalan_nodokumen),true);
		$criteria->compare('LOWER(t.invjalan_statustanah)',strtolower($this->invjalan_statustanah),true);
		$criteria->compare('LOWER(t.invjalan_keadaaan)',strtolower($this->invjalan_keadaaan),true);
		$criteria->compare('t.invjalan_harga',$this->invjalan_harga);
		$criteria->compare('t.invjalan_akumsusut',$this->invjalan_akumsusut);
		$criteria->compare('LOWER(t.invjalan_ket)',strtolower($this->invjalan_ket),true);
		$criteria->compare('t.barang_harganetto',$this->barang_harganetto);
		$criteria->compare('t.barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('t.barang_ppn',$this->barang_ppn);
		$criteria->compare('t.barang_hpp',$this->barang_hpp);
		$criteria->compare('t.barang_hargajual',$this->barang_hargajual);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}

	public function searchBarangFormulirInventarisasi()
	{
		$prov = $this->searchBarang();
		$cr = $prov->criteria;

		$cr->group = "t.barang_id, t.barang_kode, t.barang_nama, t.barang_merk, t.barang_noseri, t.barang_satuan, t.barang_hpp, t.barang_harganetto";
		$cr->select = $cr->group;

		$cr->join = 'join inventarisasiruangan_t i on i.barang_id = t.barang_id';
		$cr->addCondition('i.barang_id is not null');

		$prov->criteria = $cr;

		return $prov;
	}
}
