<?php
class GFInformasifakturpembelianV extends InformasifakturpembelianV
{
        public $tgl_awal,$tgl_akhir;
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

		$criteria->addBetweenCondition('DATE(tglfaktur)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->fakturpembelian_id)){
			$criteria->addCondition('fakturpembelian_id = '.$this->fakturpembelian_id);
		}
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		if(!empty($this->penerimaanbarang_id)){
			$criteria->addCondition('penerimaanbarang_id = '.$this->penerimaanbarang_id);
		}
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('noterima',$this->noterima,true);
		$criteria->compare('tglsuratjalan',$this->tglsuratjalan,true);
		$criteria->compare('nosuratjalan',$this->nosuratjalan,true);
		$criteria->compare('statuspenerimaan',$this->statuspenerimaan,true);
		if(!empty($this->returpembelian_id)){
			$criteria->addCondition('returpembelian_id = '.$this->returpembelian_id);
		}
		$criteria->compare('tglretur',$this->tglretur,true);
		$criteria->compare('noretur',$this->noretur,true);
		$criteria->compare('alasanretur',$this->alasanretur,true);
		$criteria->compare('keteranganretur',$this->keteranganretur,true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('tglterimafaktur',$this->tglterimafaktur,true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('supplier_namalain',$this->supplier_namalain,true);
		$criteria->compare('supplier_alamat',$this->supplier_alamat,true);
		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition('syaratbayar_id = '.$this->syaratbayar_id);
		}
		$criteria->compare('syaratbayar_nama',$this->syaratbayar_nama,true);
		if(!empty($this->uangmukabeli_id)){
			$criteria->addCondition('uangmukabeli_id = '.$this->uangmukabeli_id);
		}
		if(!empty($this->tandabuktiuangmuka_id)){
			$criteria->addCondition('tandabuktiuangmuka_id = '.$this->tandabuktiuangmuka_id);
		}
		$criteria->compare('tglkaskeluar_uangmuka',$this->tglkaskeluar_uangmuka,true);
		$criteria->compare('nokaskeluar_uangmuka',$this->nokaskeluar_uangmuka,true);
		$criteria->compare('carabayarkeluar_uangmuka',$this->carabayarkeluar_uangmuka,true);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('norekening',$this->norekening,true);
		$criteria->compare('rekatasnama',$this->rekatasnama,true);
		$criteria->compare('jumlahuang',$this->jumlahuang);
		if(!empty($this->bayarkesupplier_id)){
			$criteria->addCondition('bayarkesupplier_id = '.$this->bayarkesupplier_id);
		}
		if(!empty($this->tandabuktibayarkesupplier_id)){
			$criteria->addCondition('tandabuktibayarkesupplier_id = '.$this->tandabuktibayarkesupplier_id);
		}
		$criteria->compare('tglkaskeluar_bayarkesupplier',$this->tglkaskeluar_bayarkesupplier,true);
		$criteria->compare('nokaskeluar_bayarkesupplier',$this->nokaskeluar_bayarkesupplier,true);
		$criteria->compare('carabayarkeluar_bayarkesupplier',$this->carabayarkeluar_bayarkesupplier,true);
		$criteria->compare('tglbayarkesupplier',$this->tglbayarkesupplier,true);
		$criteria->compare('totaltagihan',$this->totaltagihan);
		$criteria->compare('jmldibayarkan',$this->jmldibayarkan);
		if(!empty($this->batalbayarsupplier_id)){
			$criteria->addCondition('batalbayarsupplier_id = '.$this->batalbayarsupplier_id);
		}
		$criteria->compare('tglbatalbayar',$this->tglbatalbayar,true);
		$criteria->compare('alasanbatalbayar',$this->alasanbatalbayar,true);
		$criteria->compare('user_name_otoritasi',$this->user_name_otoritasi,true);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}