<?php
class MABarangV extends BarangV {
	public $noreg,$umur_ekonomis,$penyusutan,$hrg_peroleh;
	public $waktu_pengecekan,$kondisi_aset,$ket,$checklist;
	public static function model($className=__CLASS__)
    {
		return parent::model($className);
    }
	
	public function searchDialog(){
		
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->golongan_id)){
			$criteria->addCondition('golongan_id = '.$this->golongan_id);
		}		
		$criteria->compare('LOWER(golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(golongan_nama)',strtolower($this->golongan_nama),true);
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('kelompok_id = '.$this->kelompok_id);
		}
		$criteria->compare('LOWER(kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(kelompok_nama)',strtolower($this->kelompok_nama),true);
		if(!empty($this->subkelompok_id)){
			$criteria->addCondition('subkelompok_id = '.$this->subkelompok_id);
		}
		$criteria->compare('LOWER(subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		if(!empty($this->bidang_id)){
			$criteria->addCondition('bidang_id = '.$this->bidang_id);
		}
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		if(!empty($this->asalaset_inventarisasiasetlain_id)){
			$criteria->addCondition('asalaset_inventarisasiasetlain_id = '.$this->asalaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasiasetlain_nama)',strtolower($this->asalaset_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasiasetlain_singkatan)',strtolower($this->asalaset_inventarisasiasetlain_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiasetlain_id)){
			$criteria->addCondition('lokasiaset_inventarisasiasetlain_id = '.$this->lokasiaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_kode)',strtolower($this->lokasiaset_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namainstalasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namabagian)',strtolower($this->lokasiaset_inventarisasiasetlain_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namalokasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiasetlain_id)){
			$criteria->addCondition('pemilikbarang_inventarisasiasetlain_id = '.$this->pemilikbarang_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasiasetlain_kode)',strtolower($this->pemilikbarang_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasiasetlain_nama)',strtolower($this->pemilikbarang_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		$criteria->compare('LOWER(invasetlain_namabrg)',strtolower($this->invasetlain_namabrg),true);
		$criteria->compare('LOWER(invasetlain_judulbuku)',strtolower($this->invasetlain_judulbuku),true);
		$criteria->compare('LOWER(invasetlain_spesifikasibuku)',strtolower($this->invasetlain_spesifikasibuku),true);
		$criteria->compare('LOWER(invasetlain_asalkesenian)',strtolower($this->invasetlain_asalkesenian),true);
		$criteria->compare('invasetlain_jumlah',$this->invasetlain_jumlah);
		$criteria->compare('LOWER(invasetlain_thncetak)',strtolower($this->invasetlain_thncetak),true);
		$criteria->compare('invasetlain_harga',$this->invasetlain_harga);
		$criteria->compare('LOWER(invasetlain_tglguna)',strtolower($this->invasetlain_tglguna),true);
		$criteria->compare('invasetlain_akumsusut',$this->invasetlain_akumsusut);
		$criteria->compare('LOWER(invasetlain_ket)',strtolower($this->invasetlain_ket),true);
		$criteria->compare('LOWER(invasetlain_penciptakesenian)',strtolower($this->invasetlain_penciptakesenian),true);
		$criteria->compare('LOWER(invasetlain_bahankesenian)',strtolower($this->invasetlain_bahankesenian),true);
		$criteria->compare('LOWER(invasetlain_jenishewan_tum)',strtolower($this->invasetlain_jenishewan_tum),true);
		$criteria->compare('LOWER(invasetlain_ukuranhewan_tum)',strtolower($this->invasetlain_ukuranhewan_tum),true);
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		if(!empty($this->asalaset_inventarisasitanah_id)){
			$criteria->addCondition('asalaset_inventarisasitanah_id = '.$this->asalaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasitanah_nama)',strtolower($this->asalaset_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasitanah_singkatan)',strtolower($this->asalaset_inventarisasitanah_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasitanah_id)){
			$criteria->addCondition('lokasiaset_inventarisasitanah_id = '.$this->lokasiaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_kode)',strtolower($this->lokasiaset_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namainstalasi)',strtolower($this->lokasiaset_inventarisasitanah_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namabagian)',strtolower($this->lokasiaset_inventarisasitanah_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namalokasi)',strtolower($this->lokasiaset_inventarisasitanah_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasitanah_id)){
			$criteria->addCondition('pemilikbarang_inventarisasitanah_id = '.$this->pemilikbarang_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasitanah_kode)',strtolower($this->pemilikbarang_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasitanah_nama)',strtolower($this->pemilikbarang_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		$criteria->compare('LOWER(invtanah_namabrg)',strtolower($this->invtanah_namabrg),true);
		$criteria->compare('LOWER(invtanah_luas)',strtolower($this->invtanah_luas),true);
		$criteria->compare('LOWER(invtanah_thnpengadaan)',strtolower($this->invtanah_thnpengadaan),true);
		$criteria->compare('LOWER(invtanah_tglguna)',strtolower($this->invtanah_tglguna),true);
		$criteria->compare('LOWER(invtanah_alamat)',strtolower($this->invtanah_alamat),true);
		$criteria->compare('LOWER(invtanah_status)',strtolower($this->invtanah_status),true);
		$criteria->compare('LOWER(invtanah_tglsertifikat)',strtolower($this->invtanah_tglsertifikat),true);
		$criteria->compare('LOWER(invtanah_nosertifikat)',strtolower($this->invtanah_nosertifikat),true);
		$criteria->compare('LOWER(invtanah_penggunaan)',strtolower($this->invtanah_penggunaan),true);
		$criteria->compare('invtanah_harga',$this->invtanah_harga);
		$criteria->compare('LOWER(invtanah_ket)',strtolower($this->invtanah_ket),true);
		$criteria->compare('invtanah_umurekonomis',$this->invtanah_umurekonomis);
		$criteria->compare('invtanah_nilairesidu',$this->invtanah_nilairesidu);
		$criteria->compare('LOWER(tglpenghapusan)',strtolower($this->tglpenghapusan),true);
		$criteria->compare('LOWER(tipepenghapusan)',strtolower($this->tipepenghapusan),true);
		$criteria->compare('hargajualaktiva',$this->hargajualaktiva);
		$criteria->compare('kerugian',$this->kerugian);
		$criteria->compare('keuntungan',$this->keuntungan);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		if(!empty($this->asalaset_inventarisasiperalatan_id)){
			$criteria->addCondition('asalaset_inventarisasiperalatan_id = '.$this->asalaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasiperalatan_nama)',strtolower($this->asalaset_inventarisasiperalatan_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasiperalatan_singkatan)',strtolower($this->asalaset_inventarisasiperalatan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiperalatan_id)){
			$criteria->addCondition('lokasiaset_inventarisasiperalatan_id = '.$this->lokasiaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_kode)',strtolower($this->lokasiaset_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namainstalasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namabagian)',strtolower($this->lokasiaset_inventarisasiperalatan_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namalokasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiperalatan_id)){
			$criteria->addCondition('pemilikbarang_inventarisasiperalatan_id = '.$this->pemilikbarang_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasiperalatan_kode)',strtolower($this->pemilikbarang_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasiperalatan_nama)',strtolower($this->pemilikbarang_inventarisasiperalatan_nama),true);
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		$criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
		$criteria->compare('LOWER(invperalatan_merk)',strtolower($this->invperalatan_merk),true);
		$criteria->compare('LOWER(invperalatan_ukuran)',strtolower($this->invperalatan_ukuran),true);
		$criteria->compare('LOWER(invperalatan_bahan)',strtolower($this->invperalatan_bahan),true);
		$criteria->compare('LOWER(invperalatan_thnpembelian)',strtolower($this->invperalatan_thnpembelian),true);
		$criteria->compare('LOWER(invperalatan_tglguna)',strtolower($this->invperalatan_tglguna),true);
		$criteria->compare('LOWER(invperalatan_nopabrik)',strtolower($this->invperalatan_nopabrik),true);
		$criteria->compare('LOWER(invperalatan_norangka)',strtolower($this->invperalatan_norangka),true);
		$criteria->compare('LOWER(invperalatan_nomesin)',strtolower($this->invperalatan_nomesin),true);
		$criteria->compare('LOWER(invperalatan_nopolisi)',strtolower($this->invperalatan_nopolisi),true);
		$criteria->compare('LOWER(invperalatan_nobpkb)',strtolower($this->invperalatan_nobpkb),true);
		$criteria->compare('invperalatan_harga',$this->invperalatan_harga);
		$criteria->compare('invperalatan_akumsusut',$this->invperalatan_akumsusut);
		$criteria->compare('LOWER(invperalatan_ket)',strtolower($this->invperalatan_ket),true);
		$criteria->compare('LOWER(invperalatan_kapasitasrata)',strtolower($this->invperalatan_kapasitasrata),true);
		$criteria->compare('invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
		$criteria->compare('LOWER(invperalatan_serftkkalibrasi)',strtolower($this->invperalatan_serftkkalibrasi),true);
		if(!empty($this->invperalatan_umurekonomis)){
			$criteria->addCondition('invperalatan_umurekonomis = '.$this->invperalatan_umurekonomis);
		}
		$criteria->compare('LOWER(invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->asalaset_inventarisasigedung_id)){
			$criteria->addCondition('asalaset_inventarisasigedung_id = '.$this->asalaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasigedung_nama)',strtolower($this->asalaset_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasigedung_singkatan)',strtolower($this->asalaset_inventarisasigedung_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasigedung_id)){
			$criteria->addCondition('lokasiaset_inventarisasigedung_id = '.$this->lokasiaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_kode)',strtolower($this->lokasiaset_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namainstalasi)',strtolower($this->lokasiaset_inventarisasigedung_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namabagian)',strtolower($this->lokasiaset_inventarisasigedung_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namalokasi)',strtolower($this->lokasiaset_inventarisasigedung_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasigedung_id)){
			$criteria->addCondition('pemilikbarang_inventarisasigedung_id = '.$this->pemilikbarang_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasigedung_kode)',strtolower($this->pemilikbarang_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasigedung_nama)',strtolower($this->pemilikbarang_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		$criteria->compare('LOWER(invgedung_namabrg)',strtolower($this->invgedung_namabrg),true);
		$criteria->compare('LOWER(invgedung_kontruksi)',strtolower($this->invgedung_kontruksi),true);
		$criteria->compare('invgedung_luaslantai',$this->invgedung_luaslantai);
		$criteria->compare('LOWER(invgedung_alamat)',strtolower($this->invgedung_alamat),true);
		$criteria->compare('LOWER(invgedung_tgldokumen)',strtolower($this->invgedung_tgldokumen),true);
		$criteria->compare('LOWER(invgedung_tglguna)',strtolower($this->invgedung_tglguna),true);
		$criteria->compare('LOWER(invgedung_nodokumen)',strtolower($this->invgedung_nodokumen),true);
		$criteria->compare('invgedung_harga',$this->invgedung_harga);
		$criteria->compare('invgedung_akumsusut',$this->invgedung_akumsusut);
		$criteria->compare('LOWER(invgedung_ket)',strtolower($this->invgedung_ket),true);
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		if(!empty($this->asalaset_inventarisasijalan_id)){
			$criteria->addCondition('asalaset_inventarisasijalan_id = '.$this->asalaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasijalan_nama)',strtolower($this->asalaset_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasijalan_singkatan)',strtolower($this->asalaset_inventarisasijalan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasijalan_id)){
			$criteria->addCondition('lokasiaset_inventarisasijalan_id = '.$this->lokasiaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_kode)',strtolower($this->lokasiaset_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namainstalasi)',strtolower($this->lokasiaset_inventarisasijalan_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namabagian)',strtolower($this->lokasiaset_inventarisasijalan_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namalokasi)',strtolower($this->lokasiaset_inventarisasijalan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasijalan_id)){
			$criteria->addCondition('pemilikbarang_inventarisasijalan_id = '.$this->pemilikbarang_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasijalan_kode)',strtolower($this->pemilikbarang_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasijalan_nama)',strtolower($this->pemilikbarang_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		$criteria->compare('LOWER(invjalan_namabrg)',strtolower($this->invjalan_namabrg),true);
		$criteria->compare('LOWER(invjalan_kontruksi)',strtolower($this->invjalan_kontruksi),true);
		$criteria->compare('LOWER(invjalan_panjang)',strtolower($this->invjalan_panjang),true);
		$criteria->compare('LOWER(invjalan_lebar)',strtolower($this->invjalan_lebar),true);
		$criteria->compare('LOWER(invjalan_luas)',strtolower($this->invjalan_luas),true);
		$criteria->compare('LOWER(invjalan_letak)',strtolower($this->invjalan_letak),true);
		$criteria->compare('LOWER(invjalan_tgldokumen)',strtolower($this->invjalan_tgldokumen),true);
		$criteria->compare('LOWER(invjalan_tglguna)',strtolower($this->invjalan_tglguna),true);
		$criteria->compare('LOWER(invjalan_nodokumen)',strtolower($this->invjalan_nodokumen),true);
		$criteria->compare('LOWER(invjalan_statustanah)',strtolower($this->invjalan_statustanah),true);
		$criteria->compare('LOWER(invjalan_keadaaan)',strtolower($this->invjalan_keadaaan),true);
		$criteria->compare('invjalan_harga',$this->invjalan_harga);
		$criteria->compare('invjalan_akumsusut',$this->invjalan_akumsusut);
		$criteria->compare('LOWER(invjalan_ket)',strtolower($this->invjalan_ket),true);
		$criteria->addCondition('barang_statusregister IS true');
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
//		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => [
                            'defaultOrder' => 'barang_nama ASC'
                        ]
//			'pagination'=>false,
		));
	}
	public function searchDialogAsset(){
		
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->golongan_id)){
			$criteria->addCondition('golongan_id = '.$this->golongan_id);
		}		
		$criteria->compare('LOWER(golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(golongan_nama)',strtolower($this->golongan_nama),true);
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('kelompok_id = '.$this->kelompok_id);
		}
		$criteria->compare('LOWER(kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(kelompok_nama)',strtolower($this->kelompok_nama),true);
		if(!empty($this->subkelompok_id)){
			$criteria->addCondition('subkelompok_id = '.$this->subkelompok_id);
		}
		$criteria->compare('LOWER(subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		if(!empty($this->bidang_id)){
			$criteria->addCondition('bidang_id = '.$this->bidang_id);
		}
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		if(!empty($this->asalaset_inventarisasiasetlain_id)){
			$criteria->addCondition('asalaset_inventarisasiasetlain_id = '.$this->asalaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasiasetlain_nama)',strtolower($this->asalaset_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasiasetlain_singkatan)',strtolower($this->asalaset_inventarisasiasetlain_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiasetlain_id)){
			$criteria->addCondition('lokasiaset_inventarisasiasetlain_id = '.$this->lokasiaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_kode)',strtolower($this->lokasiaset_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namainstalasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namabagian)',strtolower($this->lokasiaset_inventarisasiasetlain_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namalokasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiasetlain_id)){
			$criteria->addCondition('pemilikbarang_inventarisasiasetlain_id = '.$this->pemilikbarang_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasiasetlain_kode)',strtolower($this->pemilikbarang_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasiasetlain_nama)',strtolower($this->pemilikbarang_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		$criteria->compare('LOWER(invasetlain_namabrg)',strtolower($this->invasetlain_namabrg),true);
		$criteria->compare('LOWER(invasetlain_judulbuku)',strtolower($this->invasetlain_judulbuku),true);
		$criteria->compare('LOWER(invasetlain_spesifikasibuku)',strtolower($this->invasetlain_spesifikasibuku),true);
		$criteria->compare('LOWER(invasetlain_asalkesenian)',strtolower($this->invasetlain_asalkesenian),true);
		$criteria->compare('invasetlain_jumlah',$this->invasetlain_jumlah);
		$criteria->compare('LOWER(invasetlain_thncetak)',strtolower($this->invasetlain_thncetak),true);
		$criteria->compare('invasetlain_harga',$this->invasetlain_harga);
		$criteria->compare('LOWER(invasetlain_tglguna)',strtolower($this->invasetlain_tglguna),true);
		$criteria->compare('invasetlain_akumsusut',$this->invasetlain_akumsusut);
		$criteria->compare('LOWER(invasetlain_ket)',strtolower($this->invasetlain_ket),true);
		$criteria->compare('LOWER(invasetlain_penciptakesenian)',strtolower($this->invasetlain_penciptakesenian),true);
		$criteria->compare('LOWER(invasetlain_bahankesenian)',strtolower($this->invasetlain_bahankesenian),true);
		$criteria->compare('LOWER(invasetlain_jenishewan_tum)',strtolower($this->invasetlain_jenishewan_tum),true);
		$criteria->compare('LOWER(invasetlain_ukuranhewan_tum)',strtolower($this->invasetlain_ukuranhewan_tum),true);
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		if(!empty($this->asalaset_inventarisasitanah_id)){
			$criteria->addCondition('asalaset_inventarisasitanah_id = '.$this->asalaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasitanah_nama)',strtolower($this->asalaset_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasitanah_singkatan)',strtolower($this->asalaset_inventarisasitanah_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasitanah_id)){
			$criteria->addCondition('lokasiaset_inventarisasitanah_id = '.$this->lokasiaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_kode)',strtolower($this->lokasiaset_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namainstalasi)',strtolower($this->lokasiaset_inventarisasitanah_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namabagian)',strtolower($this->lokasiaset_inventarisasitanah_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namalokasi)',strtolower($this->lokasiaset_inventarisasitanah_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasitanah_id)){
			$criteria->addCondition('pemilikbarang_inventarisasitanah_id = '.$this->pemilikbarang_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasitanah_kode)',strtolower($this->pemilikbarang_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasitanah_nama)',strtolower($this->pemilikbarang_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		$criteria->compare('LOWER(invtanah_namabrg)',strtolower($this->invtanah_namabrg),true);
		$criteria->compare('LOWER(invtanah_luas)',strtolower($this->invtanah_luas),true);
		$criteria->compare('LOWER(invtanah_thnpengadaan)',strtolower($this->invtanah_thnpengadaan),true);
		$criteria->compare('LOWER(invtanah_tglguna)',strtolower($this->invtanah_tglguna),true);
		$criteria->compare('LOWER(invtanah_alamat)',strtolower($this->invtanah_alamat),true);
		$criteria->compare('LOWER(invtanah_status)',strtolower($this->invtanah_status),true);
		$criteria->compare('LOWER(invtanah_tglsertifikat)',strtolower($this->invtanah_tglsertifikat),true);
		$criteria->compare('LOWER(invtanah_nosertifikat)',strtolower($this->invtanah_nosertifikat),true);
		$criteria->compare('LOWER(invtanah_penggunaan)',strtolower($this->invtanah_penggunaan),true);
		$criteria->compare('invtanah_harga',$this->invtanah_harga);
		$criteria->compare('LOWER(invtanah_ket)',strtolower($this->invtanah_ket),true);
		$criteria->compare('invtanah_umurekonomis',$this->invtanah_umurekonomis);
		$criteria->compare('invtanah_nilairesidu',$this->invtanah_nilairesidu);
		$criteria->compare('LOWER(tglpenghapusan)',strtolower($this->tglpenghapusan),true);
		$criteria->compare('LOWER(tipepenghapusan)',strtolower($this->tipepenghapusan),true);
		$criteria->compare('hargajualaktiva',$this->hargajualaktiva);
		$criteria->compare('kerugian',$this->kerugian);
		$criteria->compare('keuntungan',$this->keuntungan);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		if(!empty($this->asalaset_inventarisasiperalatan_id)){
			$criteria->addCondition('asalaset_inventarisasiperalatan_id = '.$this->asalaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasiperalatan_nama)',strtolower($this->asalaset_inventarisasiperalatan_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasiperalatan_singkatan)',strtolower($this->asalaset_inventarisasiperalatan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiperalatan_id)){
			$criteria->addCondition('lokasiaset_inventarisasiperalatan_id = '.$this->lokasiaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_kode)',strtolower($this->lokasiaset_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namainstalasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namabagian)',strtolower($this->lokasiaset_inventarisasiperalatan_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namalokasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiperalatan_id)){
			$criteria->addCondition('pemilikbarang_inventarisasiperalatan_id = '.$this->pemilikbarang_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasiperalatan_kode)',strtolower($this->pemilikbarang_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasiperalatan_nama)',strtolower($this->pemilikbarang_inventarisasiperalatan_nama),true);
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		$criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
		$criteria->compare('LOWER(invperalatan_merk)',strtolower($this->invperalatan_merk),true);
		$criteria->compare('LOWER(invperalatan_ukuran)',strtolower($this->invperalatan_ukuran),true);
		$criteria->compare('LOWER(invperalatan_bahan)',strtolower($this->invperalatan_bahan),true);
		$criteria->compare('LOWER(invperalatan_thnpembelian)',strtolower($this->invperalatan_thnpembelian),true);
		$criteria->compare('LOWER(invperalatan_tglguna)',strtolower($this->invperalatan_tglguna),true);
		$criteria->compare('LOWER(invperalatan_nopabrik)',strtolower($this->invperalatan_nopabrik),true);
		$criteria->compare('LOWER(invperalatan_norangka)',strtolower($this->invperalatan_norangka),true);
		$criteria->compare('LOWER(invperalatan_nomesin)',strtolower($this->invperalatan_nomesin),true);
		$criteria->compare('LOWER(invperalatan_nopolisi)',strtolower($this->invperalatan_nopolisi),true);
		$criteria->compare('LOWER(invperalatan_nobpkb)',strtolower($this->invperalatan_nobpkb),true);
		$criteria->compare('invperalatan_harga',$this->invperalatan_harga);
		$criteria->compare('invperalatan_akumsusut',$this->invperalatan_akumsusut);
		$criteria->compare('LOWER(invperalatan_ket)',strtolower($this->invperalatan_ket),true);
		$criteria->compare('LOWER(invperalatan_kapasitasrata)',strtolower($this->invperalatan_kapasitasrata),true);
		$criteria->compare('invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
		$criteria->compare('LOWER(invperalatan_serftkkalibrasi)',strtolower($this->invperalatan_serftkkalibrasi),true);
		if(!empty($this->invperalatan_umurekonomis)){
			$criteria->addCondition('invperalatan_umurekonomis = '.$this->invperalatan_umurekonomis);
		}
		$criteria->compare('LOWER(invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->asalaset_inventarisasigedung_id)){
			$criteria->addCondition('asalaset_inventarisasigedung_id = '.$this->asalaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasigedung_nama)',strtolower($this->asalaset_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasigedung_singkatan)',strtolower($this->asalaset_inventarisasigedung_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasigedung_id)){
			$criteria->addCondition('lokasiaset_inventarisasigedung_id = '.$this->lokasiaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_kode)',strtolower($this->lokasiaset_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namainstalasi)',strtolower($this->lokasiaset_inventarisasigedung_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namabagian)',strtolower($this->lokasiaset_inventarisasigedung_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namalokasi)',strtolower($this->lokasiaset_inventarisasigedung_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasigedung_id)){
			$criteria->addCondition('pemilikbarang_inventarisasigedung_id = '.$this->pemilikbarang_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasigedung_kode)',strtolower($this->pemilikbarang_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasigedung_nama)',strtolower($this->pemilikbarang_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		$criteria->compare('LOWER(invgedung_namabrg)',strtolower($this->invgedung_namabrg),true);
		$criteria->compare('LOWER(invgedung_kontruksi)',strtolower($this->invgedung_kontruksi),true);
		$criteria->compare('invgedung_luaslantai',$this->invgedung_luaslantai);
		$criteria->compare('LOWER(invgedung_alamat)',strtolower($this->invgedung_alamat),true);
		$criteria->compare('LOWER(invgedung_tgldokumen)',strtolower($this->invgedung_tgldokumen),true);
		$criteria->compare('LOWER(invgedung_tglguna)',strtolower($this->invgedung_tglguna),true);
		$criteria->compare('LOWER(invgedung_nodokumen)',strtolower($this->invgedung_nodokumen),true);
		$criteria->compare('invgedung_harga',$this->invgedung_harga);
		$criteria->compare('invgedung_akumsusut',$this->invgedung_akumsusut);
		$criteria->compare('LOWER(invgedung_ket)',strtolower($this->invgedung_ket),true);
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		if(!empty($this->asalaset_inventarisasijalan_id)){
			$criteria->addCondition('asalaset_inventarisasijalan_id = '.$this->asalaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasijalan_nama)',strtolower($this->asalaset_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasijalan_singkatan)',strtolower($this->asalaset_inventarisasijalan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasijalan_id)){
			$criteria->addCondition('lokasiaset_inventarisasijalan_id = '.$this->lokasiaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_kode)',strtolower($this->lokasiaset_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namainstalasi)',strtolower($this->lokasiaset_inventarisasijalan_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namabagian)',strtolower($this->lokasiaset_inventarisasijalan_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namalokasi)',strtolower($this->lokasiaset_inventarisasijalan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasijalan_id)){
			$criteria->addCondition('pemilikbarang_inventarisasijalan_id = '.$this->pemilikbarang_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasijalan_kode)',strtolower($this->pemilikbarang_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasijalan_nama)',strtolower($this->pemilikbarang_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		$criteria->compare('LOWER(invjalan_namabrg)',strtolower($this->invjalan_namabrg),true);
		$criteria->compare('LOWER(invjalan_kontruksi)',strtolower($this->invjalan_kontruksi),true);
		$criteria->compare('LOWER(invjalan_panjang)',strtolower($this->invjalan_panjang),true);
		$criteria->compare('LOWER(invjalan_lebar)',strtolower($this->invjalan_lebar),true);
		$criteria->compare('LOWER(invjalan_luas)',strtolower($this->invjalan_luas),true);
		$criteria->compare('LOWER(invjalan_letak)',strtolower($this->invjalan_letak),true);
		$criteria->compare('LOWER(invjalan_tgldokumen)',strtolower($this->invjalan_tgldokumen),true);
		$criteria->compare('LOWER(invjalan_tglguna)',strtolower($this->invjalan_tglguna),true);
		$criteria->compare('LOWER(invjalan_nodokumen)',strtolower($this->invjalan_nodokumen),true);
		$criteria->compare('LOWER(invjalan_statustanah)',strtolower($this->invjalan_statustanah),true);
		$criteria->compare('LOWER(invjalan_keadaaan)',strtolower($this->invjalan_keadaaan),true);
		$criteria->compare('invjalan_harga',$this->invjalan_harga);
		$criteria->compare('invjalan_akumsusut',$this->invjalan_akumsusut);
		$criteria->compare('LOWER(invjalan_ket)',strtolower($this->invjalan_ket),true);
		$criteria->addCondition('barang_statusregister IS true');
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->addCondition("invasetlain_id is not null or invtanah_id is not null or invperalatan_id is not null or 
						invgedung_id is not null or invjalan_id is not null");
		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	public function searchNoReg(){
		
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->golongan_id)){
			$criteria->addCondition('golongan_id = '.$this->golongan_id);
		}		
		$criteria->compare('LOWER(golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(golongan_nama)',strtolower($this->golongan_nama),true);
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('kelompok_id = '.$this->kelompok_id);
		}
		$criteria->compare('LOWER(kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(kelompok_nama)',strtolower($this->kelompok_nama),true);
		if(!empty($this->subkelompok_id)){
			$criteria->addCondition('subkelompok_id = '.$this->subkelompok_id);
		}
		$criteria->compare('LOWER(subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		if(!empty($this->bidang_id)){
			$criteria->addCondition('bidang_id = '.$this->bidang_id);
		}
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		if(!empty($this->asalaset_inventarisasiasetlain_id)){
			$criteria->addCondition('asalaset_inventarisasiasetlain_id = '.$this->asalaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasiasetlain_nama)',strtolower($this->asalaset_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasiasetlain_singkatan)',strtolower($this->asalaset_inventarisasiasetlain_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiasetlain_id)){
			$criteria->addCondition('lokasiaset_inventarisasiasetlain_id = '.$this->lokasiaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_kode)',strtolower($this->lokasiaset_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namainstalasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namabagian)',strtolower($this->lokasiaset_inventarisasiasetlain_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namalokasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiasetlain_id)){
			$criteria->addCondition('pemilikbarang_inventarisasiasetlain_id = '.$this->pemilikbarang_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasiasetlain_kode)',strtolower($this->pemilikbarang_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasiasetlain_nama)',strtolower($this->pemilikbarang_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		$criteria->compare('LOWER(invasetlain_namabrg)',strtolower($this->invasetlain_namabrg),true);
		$criteria->compare('LOWER(invasetlain_judulbuku)',strtolower($this->invasetlain_judulbuku),true);
		$criteria->compare('LOWER(invasetlain_spesifikasibuku)',strtolower($this->invasetlain_spesifikasibuku),true);
		$criteria->compare('LOWER(invasetlain_asalkesenian)',strtolower($this->invasetlain_asalkesenian),true);
		$criteria->compare('invasetlain_jumlah',$this->invasetlain_jumlah);
		$criteria->compare('LOWER(invasetlain_thncetak)',strtolower($this->invasetlain_thncetak),true);
		$criteria->compare('invasetlain_harga',$this->invasetlain_harga);
		$criteria->compare('LOWER(invasetlain_tglguna)',strtolower($this->invasetlain_tglguna),true);
		$criteria->compare('invasetlain_akumsusut',$this->invasetlain_akumsusut);
		$criteria->compare('LOWER(invasetlain_ket)',strtolower($this->invasetlain_ket),true);
		$criteria->compare('LOWER(invasetlain_penciptakesenian)',strtolower($this->invasetlain_penciptakesenian),true);
		$criteria->compare('LOWER(invasetlain_bahankesenian)',strtolower($this->invasetlain_bahankesenian),true);
		$criteria->compare('LOWER(invasetlain_jenishewan_tum)',strtolower($this->invasetlain_jenishewan_tum),true);
		$criteria->compare('LOWER(invasetlain_ukuranhewan_tum)',strtolower($this->invasetlain_ukuranhewan_tum),true);
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		if(!empty($this->asalaset_inventarisasitanah_id)){
			$criteria->addCondition('asalaset_inventarisasitanah_id = '.$this->asalaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasitanah_nama)',strtolower($this->asalaset_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasitanah_singkatan)',strtolower($this->asalaset_inventarisasitanah_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasitanah_id)){
			$criteria->addCondition('lokasiaset_inventarisasitanah_id = '.$this->lokasiaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_kode)',strtolower($this->lokasiaset_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namainstalasi)',strtolower($this->lokasiaset_inventarisasitanah_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namabagian)',strtolower($this->lokasiaset_inventarisasitanah_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namalokasi)',strtolower($this->lokasiaset_inventarisasitanah_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasitanah_id)){
			$criteria->addCondition('pemilikbarang_inventarisasitanah_id = '.$this->pemilikbarang_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasitanah_kode)',strtolower($this->pemilikbarang_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasitanah_nama)',strtolower($this->pemilikbarang_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		$criteria->compare('LOWER(invtanah_namabrg)',strtolower($this->invtanah_namabrg),true);
		$criteria->compare('LOWER(invtanah_luas)',strtolower($this->invtanah_luas),true);
		$criteria->compare('LOWER(invtanah_thnpengadaan)',strtolower($this->invtanah_thnpengadaan),true);
		$criteria->compare('LOWER(invtanah_tglguna)',strtolower($this->invtanah_tglguna),true);
		$criteria->compare('LOWER(invtanah_alamat)',strtolower($this->invtanah_alamat),true);
		$criteria->compare('LOWER(invtanah_status)',strtolower($this->invtanah_status),true);
		$criteria->compare('LOWER(invtanah_tglsertifikat)',strtolower($this->invtanah_tglsertifikat),true);
		$criteria->compare('LOWER(invtanah_nosertifikat)',strtolower($this->invtanah_nosertifikat),true);
		$criteria->compare('LOWER(invtanah_penggunaan)',strtolower($this->invtanah_penggunaan),true);
		$criteria->compare('invtanah_harga',$this->invtanah_harga);
		$criteria->compare('LOWER(invtanah_ket)',strtolower($this->invtanah_ket),true);
		$criteria->compare('invtanah_umurekonomis',$this->invtanah_umurekonomis);
		$criteria->compare('invtanah_nilairesidu',$this->invtanah_nilairesidu);
		$criteria->compare('LOWER(tglpenghapusan)',strtolower($this->tglpenghapusan),true);
		$criteria->compare('LOWER(tipepenghapusan)',strtolower($this->tipepenghapusan),true);
		$criteria->compare('hargajualaktiva',$this->hargajualaktiva);
		$criteria->compare('kerugian',$this->kerugian);
		$criteria->compare('keuntungan',$this->keuntungan);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		if(!empty($this->asalaset_inventarisasiperalatan_id)){
			$criteria->addCondition('asalaset_inventarisasiperalatan_id = '.$this->asalaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasiperalatan_nama)',strtolower($this->asalaset_inventarisasiperalatan_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasiperalatan_singkatan)',strtolower($this->asalaset_inventarisasiperalatan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiperalatan_id)){
			$criteria->addCondition('lokasiaset_inventarisasiperalatan_id = '.$this->lokasiaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_kode)',strtolower($this->lokasiaset_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namainstalasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namabagian)',strtolower($this->lokasiaset_inventarisasiperalatan_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namalokasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiperalatan_id)){
			$criteria->addCondition('pemilikbarang_inventarisasiperalatan_id = '.$this->pemilikbarang_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasiperalatan_kode)',strtolower($this->pemilikbarang_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasiperalatan_nama)',strtolower($this->pemilikbarang_inventarisasiperalatan_nama),true);
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		$criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
		$criteria->compare('LOWER(invperalatan_merk)',strtolower($this->invperalatan_merk),true);
		$criteria->compare('LOWER(invperalatan_ukuran)',strtolower($this->invperalatan_ukuran),true);
		$criteria->compare('LOWER(invperalatan_bahan)',strtolower($this->invperalatan_bahan),true);
		$criteria->compare('LOWER(invperalatan_thnpembelian)',strtolower($this->invperalatan_thnpembelian),true);
		$criteria->compare('LOWER(invperalatan_tglguna)',strtolower($this->invperalatan_tglguna),true);
		$criteria->compare('LOWER(invperalatan_nopabrik)',strtolower($this->invperalatan_nopabrik),true);
		$criteria->compare('LOWER(invperalatan_norangka)',strtolower($this->invperalatan_norangka),true);
		$criteria->compare('LOWER(invperalatan_nomesin)',strtolower($this->invperalatan_nomesin),true);
		$criteria->compare('LOWER(invperalatan_nopolisi)',strtolower($this->invperalatan_nopolisi),true);
		$criteria->compare('LOWER(invperalatan_nobpkb)',strtolower($this->invperalatan_nobpkb),true);
		$criteria->compare('invperalatan_harga',$this->invperalatan_harga);
		$criteria->compare('invperalatan_akumsusut',$this->invperalatan_akumsusut);
		$criteria->compare('LOWER(invperalatan_ket)',strtolower($this->invperalatan_ket),true);
		$criteria->compare('LOWER(invperalatan_kapasitasrata)',strtolower($this->invperalatan_kapasitasrata),true);
		$criteria->compare('invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
		$criteria->compare('LOWER(invperalatan_serftkkalibrasi)',strtolower($this->invperalatan_serftkkalibrasi),true);
		if(!empty($this->invperalatan_umurekonomis)){
			$criteria->addCondition('invperalatan_umurekonomis = '.$this->invperalatan_umurekonomis);
		}
		$criteria->compare('LOWER(invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->asalaset_inventarisasigedung_id)){
			$criteria->addCondition('asalaset_inventarisasigedung_id = '.$this->asalaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasigedung_nama)',strtolower($this->asalaset_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasigedung_singkatan)',strtolower($this->asalaset_inventarisasigedung_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasigedung_id)){
			$criteria->addCondition('lokasiaset_inventarisasigedung_id = '.$this->lokasiaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_kode)',strtolower($this->lokasiaset_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namainstalasi)',strtolower($this->lokasiaset_inventarisasigedung_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namabagian)',strtolower($this->lokasiaset_inventarisasigedung_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namalokasi)',strtolower($this->lokasiaset_inventarisasigedung_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasigedung_id)){
			$criteria->addCondition('pemilikbarang_inventarisasigedung_id = '.$this->pemilikbarang_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasigedung_kode)',strtolower($this->pemilikbarang_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasigedung_nama)',strtolower($this->pemilikbarang_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		$criteria->compare('LOWER(invgedung_namabrg)',strtolower($this->invgedung_namabrg),true);
		$criteria->compare('LOWER(invgedung_kontruksi)',strtolower($this->invgedung_kontruksi),true);
		$criteria->compare('invgedung_luaslantai',$this->invgedung_luaslantai);
		$criteria->compare('LOWER(invgedung_alamat)',strtolower($this->invgedung_alamat),true);
		$criteria->compare('LOWER(invgedung_tgldokumen)',strtolower($this->invgedung_tgldokumen),true);
		$criteria->compare('LOWER(invgedung_tglguna)',strtolower($this->invgedung_tglguna),true);
		$criteria->compare('LOWER(invgedung_nodokumen)',strtolower($this->invgedung_nodokumen),true);
		$criteria->compare('invgedung_harga',$this->invgedung_harga);
		$criteria->compare('invgedung_akumsusut',$this->invgedung_akumsusut);
		$criteria->compare('LOWER(invgedung_ket)',strtolower($this->invgedung_ket),true);
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		if(!empty($this->asalaset_inventarisasijalan_id)){
			$criteria->addCondition('asalaset_inventarisasijalan_id = '.$this->asalaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasijalan_nama)',strtolower($this->asalaset_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasijalan_singkatan)',strtolower($this->asalaset_inventarisasijalan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasijalan_id)){
			$criteria->addCondition('lokasiaset_inventarisasijalan_id = '.$this->lokasiaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_kode)',strtolower($this->lokasiaset_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namainstalasi)',strtolower($this->lokasiaset_inventarisasijalan_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namabagian)',strtolower($this->lokasiaset_inventarisasijalan_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namalokasi)',strtolower($this->lokasiaset_inventarisasijalan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasijalan_id)){
			$criteria->addCondition('pemilikbarang_inventarisasijalan_id = '.$this->pemilikbarang_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasijalan_kode)',strtolower($this->pemilikbarang_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasijalan_nama)',strtolower($this->pemilikbarang_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		$criteria->compare('LOWER(invjalan_namabrg)',strtolower($this->invjalan_namabrg),true);
		$criteria->compare('LOWER(invjalan_kontruksi)',strtolower($this->invjalan_kontruksi),true);
		$criteria->compare('LOWER(invjalan_panjang)',strtolower($this->invjalan_panjang),true);
		$criteria->compare('LOWER(invjalan_lebar)',strtolower($this->invjalan_lebar),true);
		$criteria->compare('LOWER(invjalan_luas)',strtolower($this->invjalan_luas),true);
		$criteria->compare('LOWER(invjalan_letak)',strtolower($this->invjalan_letak),true);
		$criteria->compare('LOWER(invjalan_tgldokumen)',strtolower($this->invjalan_tgldokumen),true);
		$criteria->compare('LOWER(invjalan_tglguna)',strtolower($this->invjalan_tglguna),true);
		$criteria->compare('LOWER(invjalan_nodokumen)',strtolower($this->invjalan_nodokumen),true);
		$criteria->compare('LOWER(invjalan_statustanah)',strtolower($this->invjalan_statustanah),true);
		$criteria->compare('LOWER(invjalan_keadaaan)',strtolower($this->invjalan_keadaaan),true);
		$criteria->compare('invjalan_harga',$this->invjalan_harga);
		$criteria->compare('invjalan_akumsusut',$this->invjalan_akumsusut);
		$criteria->compare('LOWER(invjalan_ket)',strtolower($this->invjalan_ket),true);
		$criteria->addCondition('barang_statusregister IS true');
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->addCondition('invasetlain_noregister is not null or invtanah_noregister is not null or invperalatan_noregister is not null or invgedung_noregister is not null or
				invjalan_noregister is not null');
		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}