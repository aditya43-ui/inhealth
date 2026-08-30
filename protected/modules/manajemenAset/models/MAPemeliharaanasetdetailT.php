<?php

class MAPemeliharaanasetdetailT extends PemeliharaanasetdetailT
{
	public $kategori_aset,$asal_aset,$kode_inventaris,$kode_aset,$nama_aset;
	public $checklist;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		if(!empty($this->pemeliharaanasetdet_id)){
			$criteria->addCondition('pemeliharaanasetdet_id = '.$this->pemeliharaanasetdet_id);
		}
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		if(!empty($this->inventarisasi_id)){
			$criteria->addCondition('inventarisasi_id = '.$this->inventarisasi_id);
		}
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->asalaset_id)){
			$criteria->addCondition('asalaset_id = '.$this->asalaset_id);
		}
		if(!empty($this->pemeliharaanaset_id)){
			$criteria->addCondition('pemeliharaanaset_id = '.$this->pemeliharaanaset_id);
		}
		$criteria->compare('LOWER(pemeliharaanasetdet_tgl)',strtolower($this->pemeliharaanasetdet_tgl),true);
		$criteria->compare('LOWER(kondisiaset)',strtolower($this->kondisiaset),true);
		$criteria->compare('LOWER(keteranganaset)',strtolower($this->keteranganaset),true);

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
}