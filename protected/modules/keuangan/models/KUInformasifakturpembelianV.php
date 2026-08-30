<?php
class KUInformasifakturpembelianV extends InformasifakturpembelianV
{
	public $tgl_awal,$tgl_akhir;
	public $tgl_awalJatuhTempo, $tgl_akhirJatuhTempo;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasifakturpembelianV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('DATE(tglfaktur)', $this->tgl_awal, $this->tgl_akhir,true);
		}
		
		//var_dump($this->tgl_akhirJatuhTempo);
		
		if (isset($_GET['berdasarkanJatuhTempo'])){
			if($_GET['berdasarkanJatuhTempo'] > 0){
				$criteria->addBetweenCondition('DATE(tgljatuhtempo)', $this->tgl_awalJatuhTempo, $this->tgl_akhirJatuhTempo);
			}
		}
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('noterima',$this->noterima,true);

		// $criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		//$criteria->compare('tglfaktur',$this->tglfaktur,true);
		//$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		// $criteria->compare('keteranganfaktur',$this->keteranganfaktur,true);
		
		// $criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		//$criteria->compare('tglterima',$this->tglterima,true);
		
		//$criteria->compare('tglsuratjalan',$this->tglsuratjalan,true);
		// $criteria->compare('nosuratjalan',$this->nosuratjalan,true);
		// $criteria->compare('statuspenerimaan',$this->statuspenerimaan,true);
		// $criteria->compare('returpembelian_id',$this->returpembelian_id);
		//$criteria->compare('tglretur',$this->tglretur,true);
		// $criteria->compare('noretur',$this->noretur,true);
		// $criteria->compare('alasanretur',$this->alasanretur,true);
		// $criteria->compare('keteranganretur',$this->keteranganretur,true);
		// $criteria->compare('totalretur',$this->totalretur);
		//$criteria->compare('tglterimafaktur',$this->tglterimafaktur,true);
		// $criteria->compare('supplier_id',$this->supplier_id);
		// $criteria->compare('supplier_kode',$this->supplier_kode,true);
		// $criteria->compare('supplier_nama',$this->supplier_nama,true);
		// $criteria->compare('supplier_namalain',$this->supplier_namalain,true);
		// $criteria->compare('supplier_alamat',$this->supplier_alamat,true);
		// $criteria->compare('supplier_propinsi',$this->supplier_propinsi,true);
		// $criteria->compare('supplier_kabupaten',$this->supplier_kabupaten,true);
		// $criteria->compare('supplier_telp',$this->supplier_telp,true);
		// $criteria->compare('supplier_fax',$this->supplier_fax,true);
		// $criteria->compare('supplier_kodepos',$this->supplier_kodepos,true);
		// $criteria->compare('supplier_npwp',$this->supplier_npwp,true);
		// $criteria->compare('supplier_norekening',$this->supplier_norekening,true);
		// $criteria->compare('supplier_namabank',$this->supplier_namabank,true);
		// $criteria->compare('supplier_rekatasnama',$this->supplier_rekatasnama,true);
		// $criteria->compare('supplier_matauang',$this->supplier_matauang,true);
		// $criteria->compare('supplier_website',$this->supplier_website,true);
		// $criteria->compare('supplier_email',$this->supplier_email,true);
		// $criteria->compare('supplier_logo',$this->supplier_logo,true);
		// $criteria->compare('supplier_cp',$this->supplier_cp,true);
		// $criteria->compare('supplier_cp_hp',$this->supplier_cp_hp,true);
		// $criteria->compare('supplier_cp_email',$this->supplier_cp_email,true);
		// $criteria->compare('supplier_cp2',$this->supplier_cp2,true);
		// $criteria->compare('supplier_cp2_hp',$this->supplier_cp2_hp,true);
		// $criteria->compare('supplier_cp2_email',$this->supplier_cp2_email,true);
		// $criteria->compare('supplier_jenis',$this->supplier_jenis,true);
		// $criteria->compare('supplier_termin',$this->supplier_termin);
		
		// $criteria->compare('syaratbayar_nama',$this->syaratbayar_nama,true);
		// $criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		// $criteria->compare('tandabuktiuangmuka_id',$this->tandabuktiuangmuka_id);
		//$criteria->compare('tglkaskeluar_uangmuka',$this->tglkaskeluar_uangmuka,true);
		// $criteria->compare('nokaskeluar_uangmuka',$this->nokaskeluar_uangmuka,true);
		// $criteria->compare('carabayarkeluar_uangmuka',$this->carabayarkeluar_uangmuka,true);
		// $criteria->compare('namabank',$this->namabank,true);
		// $criteria->compare('norekening',$this->norekening,true);
		// $criteria->compare('rekatasnama',$this->rekatasnama,true);
		// $criteria->compare('jumlahuang',$this->jumlahuang);
		// $criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		// $criteria->compare('tandabuktibayarkesupplier_id',$this->tandabuktibayarkesupplier_id);
		//$criteria->compare('tglkaskeluar_bayarkesupplier',$this->tglkaskeluar_bayarkesupplier,true);
		// $criteria->compare('nokaskeluar_bayarkesupplier',$this->nokaskeluar_bayarkesupplier,true);
		// $criteria->compare('carabayarkeluar_bayarkesupplier',$this->carabayarkeluar_bayarkesupplier,true);
		// $criteria->compare('tglbayarkesupplier',$this->tglbayarkesupplier,true);
		// $criteria->compare('totaltagihan',$this->totaltagihan);
		// $criteria->compare('jmldibayarkan',$this->jmldibayarkan);
		// $criteria->compare('batalbayarsupplier_id',$this->batalbayarsupplier_id);
		//$criteria->compare('tglbatalbayar',$this->tglbatalbayar,true);
		// $criteria->compare('alasanbatalbayar',$this->alasanbatalbayar,true);
		// $criteria->compare('user_name_otoritasi',$this->user_name_otoritasi,true);
		// $criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		// $criteria->compare('instalasi_id',$this->instalasi_id);
		// $criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		// $criteria->compare('ruangan_id',$this->ruangan_id);
		// $criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		
		if(!empty($this->supplier_id)){
			$criteria->addCondition("supplier_id = ".$this->supplier_id);
		}

		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition("syaratbayar_id = ".$this->syaratbayar_id);
		}
                
		if (!empty($this->statusBayar)){
			if ($this->statusBayar == 1){
				$criteria->addCondition(" bayarkesupplier_id IS NOT NULL ");
			}elseif ($this->statusBayar == 2){
				$criteria->addCondition(" bayarkesupplier_id IS NULL ");
			}
		}
		
		$criteria->order = " tglfaktur DESC ";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('DATE(tglfaktur)', $this->tgl_awal, $this->tgl_akhir,true);
		}
		
		//var_dump($this->tgl_akhirJatuhTempo);
		
		if (isset($_GET['berdasarkanJatuhTempo'])){
			if($_GET['berdasarkanJatuhTempo'] > 0){
				$criteria->addBetweenCondition('DATE(tgljatuhtempo)', $this->tgl_awalJatuhTempo, $this->tgl_akhirJatuhTempo);
			}
		}
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		//$criteria->compare('tglfaktur',$this->tglfaktur,true);
		//$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		//$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('noterima',$this->noterima,true);
		//$criteria->compare('tglsuratjalan',$this->tglsuratjalan,true);
		$criteria->compare('nosuratjalan',$this->nosuratjalan,true);
		$criteria->compare('statuspenerimaan',$this->statuspenerimaan,true);
		$criteria->compare('returpembelian_id',$this->returpembelian_id);
		//$criteria->compare('tglretur',$this->tglretur,true);
		$criteria->compare('noretur',$this->noretur,true);
		$criteria->compare('alasanretur',$this->alasanretur,true);
		$criteria->compare('keteranganretur',$this->keteranganretur,true);
		$criteria->compare('totalretur',$this->totalretur);
		//$criteria->compare('tglterimafaktur',$this->tglterimafaktur,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('supplier_namalain',$this->supplier_namalain,true);
		$criteria->compare('supplier_alamat',$this->supplier_alamat,true);
		$criteria->compare('supplier_propinsi',$this->supplier_propinsi,true);
		$criteria->compare('supplier_kabupaten',$this->supplier_kabupaten,true);
		$criteria->compare('supplier_telp',$this->supplier_telp,true);
		$criteria->compare('supplier_fax',$this->supplier_fax,true);
		$criteria->compare('supplier_kodepos',$this->supplier_kodepos,true);
		$criteria->compare('supplier_npwp',$this->supplier_npwp,true);
		$criteria->compare('supplier_norekening',$this->supplier_norekening,true);
		$criteria->compare('supplier_namabank',$this->supplier_namabank,true);
		$criteria->compare('supplier_rekatasnama',$this->supplier_rekatasnama,true);
		$criteria->compare('supplier_matauang',$this->supplier_matauang,true);
		$criteria->compare('supplier_website',$this->supplier_website,true);
		$criteria->compare('supplier_email',$this->supplier_email,true);
		$criteria->compare('supplier_logo',$this->supplier_logo,true);
		$criteria->compare('supplier_cp',$this->supplier_cp,true);
		$criteria->compare('supplier_cp_hp',$this->supplier_cp_hp,true);
		$criteria->compare('supplier_cp_email',$this->supplier_cp_email,true);
		$criteria->compare('supplier_cp2',$this->supplier_cp2,true);
		$criteria->compare('supplier_cp2_hp',$this->supplier_cp2_hp,true);
		$criteria->compare('supplier_cp2_email',$this->supplier_cp2_email,true);
		$criteria->compare('supplier_jenis',$this->supplier_jenis,true);
		$criteria->compare('supplier_termin',$this->supplier_termin);
                if(!empty($this->syaratbayar_id)){
                    $criteria->addCondition("syaratbayar_id = ".$this->syaratbayar_id);
                }
                
//		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
		$criteria->compare('syaratbayar_nama',$this->syaratbayar_nama,true);
		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('tandabuktiuangmuka_id',$this->tandabuktiuangmuka_id);
		//$criteria->compare('tglkaskeluar_uangmuka',$this->tglkaskeluar_uangmuka,true);
		$criteria->compare('nokaskeluar_uangmuka',$this->nokaskeluar_uangmuka,true);
		$criteria->compare('carabayarkeluar_uangmuka',$this->carabayarkeluar_uangmuka,true);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('norekening',$this->norekening,true);
		$criteria->compare('rekatasnama',$this->rekatasnama,true);
		$criteria->compare('jumlahuang',$this->jumlahuang);
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('tandabuktibayarkesupplier_id',$this->tandabuktibayarkesupplier_id);
		//$criteria->compare('tglkaskeluar_bayarkesupplier',$this->tglkaskeluar_bayarkesupplier,true);
		$criteria->compare('nokaskeluar_bayarkesupplier',$this->nokaskeluar_bayarkesupplier,true);
		$criteria->compare('carabayarkeluar_bayarkesupplier',$this->carabayarkeluar_bayarkesupplier,true);
		$criteria->compare('tglbayarkesupplier',$this->tglbayarkesupplier,true);
		$criteria->compare('totaltagihan',$this->totaltagihan);
		$criteria->compare('jmldibayarkan',$this->jmldibayarkan);
		$criteria->compare('batalbayarsupplier_id',$this->batalbayarsupplier_id);
		//$criteria->compare('tglbatalbayar',$this->tglbatalbayar,true);
		$criteria->compare('alasanbatalbayar',$this->alasanbatalbayar,true);
		$criteria->compare('user_name_otoritasi',$this->user_name_otoritasi,true);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		
		if (!empty($this->statusBayar)){
			if ($this->statusBayar == 1){
				$criteria->addCondition(" bayarkesupplier_id IS NOT NULL ");
			}elseif ($this->statusBayar == 2){
				$criteria->addCondition(" bayarkesupplier_id IS NULL ");
			}
		}
		
		$criteria->order = " tglfaktur DESC ";
		$criteria->limit = -1 ;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function getSupplierItems()
	{
		return SupplierM::model()->findAll('supplier_aktif=TRUE ORDER BY supplier_nama');
	}
		
	public function getUmurHutang(){
		$tglfaktur = $this->tglfaktur;	
                $tglfaktur = date('Y-m-d', strtotime($tglfaktur));
                $tgljatuhtempo = (!empty($this->tgljatuhtempo)?date('Y-m-d', strtotime($this->tgljatuhtempo)):date('Y-m-d H:i:s'));
		$dob=$tglfaktur; 
		$jatuhtempo=$tgljatuhtempo;
		list($y,$m,$d)=explode('-',$dob);
		list($ty,$tm,$td)=explode('-',$jatuhtempo);
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

		$umurHutang = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';

		return $umurHutang;
	}
        
        public function getSyaratBayarItems()
	{
		return SyaratbayarM::model()->findAll('syaratbayar_aktif=TRUE ORDER BY syaratbayar_nama ASC');
	}

}