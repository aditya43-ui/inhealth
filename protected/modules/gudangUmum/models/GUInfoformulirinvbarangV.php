<?php
class GUInfoformulirinvbarangV extends InfoformulirinvbarangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoformulirinvbarangV the static model class
	 */
	public $tgl_awal,$tgl_akhir,$lookup_name,$lookup_type,$lookup_value;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	* Retrieves a list of models based on the current search/filter conditions.
	* @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	*/
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->group = 'formulirinvbarang_id, forminvbarang_no, forminvbarang_tgl, invbarang_id, forminvbarang_totalvolume, forminvbarang_totalharga, beluminv';
		$criteria->select = $criteria->group;
		
		$criteria->addBetweenCondition('DATE(forminvbarang_tgl)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->formulirinvbarang_id)){
			$criteria->addCondition('formulirinvbarang_id = '.$this->formulirinvbarang_id);
		}
		if(!empty($this->inventarisasi_id)){
			$criteria->addCondition('inventarisasi_id = '.$this->inventarisasi_id);
		}
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('LOWER(forminvbarang_no)',strtolower($this->forminvbarang_no),true);
		$criteria->compare('forminvbarang_totalvolume',$this->forminvbarang_totalvolume);
		$criteria->compare('forminvbarang_totalharga',$this->forminvbarang_totalharga);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->forminvbarangdet_id)){
			$criteria->addCondition('forminvbarangdet_id = '.$this->forminvbarangdet_id);
		}
		$criteria->compare('volume_inventaris',$this->volume_inventaris);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		if(!empty($this->lookup_id)){
			$criteria->addCondition('lookup_id = '.$this->lookup_id);
		}
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		if(!empty($this->lookup_urutan)){
			$criteria->addCondition('lookup_urutan = '.$this->lookup_urutan);
		}
		if(!empty($this->invbarangdet_id)){
			$criteria->addCondition('invbarangdet_id = '.$this->invbarangdet_id);
		}
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('harga_satuan',$this->harga_satuan);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('harga_netto',$this->harga_netto);
		$criteria->compare('jumlah_netto',$this->jumlah_netto);
		$criteria->compare('LOWER(kondisi_barang)',strtolower($this->kondisi_barang),true);
		if(!empty($this->invbarang_id)){
			$criteria->addCondition('invbarang_id = '.$this->invbarang_id);
		}
		$criteria->compare('LOWER(invbarang_no)',strtolower($this->invbarang_no),true);
		$criteria->compare('LOWER(invbarang_tgl)',strtolower($this->invbarang_tgl),true);
		$criteria->compare('LOWER(invbarang_ket)',strtolower($this->invbarang_ket),true);
		$criteria->compare('invbarang_totalharga',$this->invbarang_totalharga);
		$criteria->compare('invbarang_totalnetto',$this->invbarang_totalnetto);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		if(!empty($this->petugas1_id)){
			$criteria->addCondition('petugas1_id = '.$this->petugas1_id);
		}
		if(!empty($this->petugas2_id)){
			$criteria->addCondition('petugas2_id = '.$this->petugas2_id);
		}
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}
