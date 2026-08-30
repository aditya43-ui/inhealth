<?php
class KUTerimapersediaanT extends TerimapersediaanT 
{
	public $supplier_id,$tgljatuhtempo,$pegawaiPenerima,$pegawaiMengetahui;
	public $supplier_nama, $umurhutang, $syaratbayar_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimapersediaanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		
	public function searchGU()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->join = ''
			. 'left join pembelianbarang_t on pembelianbarang_t.pembelianbarang_id = t.pembelianbarang_id '
			. 'left join pegawai_m on pegawai_m.pegawai_id = t.peg_penerima_id';
		
		//$criteria->with=array('pembelianbarang');
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('returpenerimaan_id',$this->returpenerimaan_id);
		$criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		$criteria->compare('peg_penerima_id',$this->peg_penerima_id);
		$criteria->compare('peg_mengetahui_id',$this->peg_mengetahui_id);
		$criteria->compare('ruanganpenerima_id',$this->ruanganpenerima_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
//		$criteria->addCondition('nofaktur is NULL');
		$criteria->compare('pembelianbarang.supplier_id',$this->supplier_id);
		$criteria->compare('lower(pegawai_m.nama_pegawai)', strtolower($this->peg_penerima_nama), true);
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'tglterima desc',
			)
		));
	}
	
	public function searchGUBelumAdaFaktur()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->join = ''
			. 'left join pembelianbarang_t on pembelianbarang_t.pembelianbarang_id = t.pembelianbarang_id '
			. 'left join pegawai_m on pegawai_m.pegawai_id = t.peg_penerima_id';
		
		//$criteria->with=array('pembelianbarang');
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('returpenerimaan_id',$this->returpenerimaan_id);
		$criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		$criteria->compare('peg_penerima_id',$this->peg_penerima_id);
		$criteria->compare('peg_mengetahui_id',$this->peg_mengetahui_id);
		$criteria->compare('ruanganpenerima_id',$this->ruanganpenerima_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
//		$criteria->addCondition('nofaktur is NULL');
		$criteria->compare('pembelianbarang.supplier_id',$this->supplier_id);
		$criteria->compare('lower(pegawai_m.nama_pegawai)', strtolower($this->peg_penerima_nama), true);
		$criteria->addCondition("(nofaktur is null or trim(nofaktur) = '')");
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'tglterima desc',
			)
		));
	}

	public function getSupplierId(){
		return isset($this->pembelianbarang->supplier_id)?$this->pembelianbarang->supplier_id:"";
	}

}