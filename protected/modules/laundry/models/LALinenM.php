<?php
class LALinenM extends LinenM {
	public $barang_nama,$bahanlinen_nama,$jenislinen_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.
		$format = new MyFormatter();
		$criteria=new CDbCriteria;
//              RSSP-689
//		$this->tglregisterlinen = empty($this->tglregisterlinen) ? date("Y-m-d") : $format->formatDateTimeForDb($this->tglregisterlinen); //filter grid
		
		$criteria->join = 'LEFT JOIN barang_m As barang ON barang.barang_id = t.barang_id'
				. ' LEFT JOIN bahanlinen_m As bahanlinen ON bahanlinen.bahanlinen_id = t.bahanlinen_id'
				. ' LEFT JOIN jenislinen_m As jenislinen ON jenislinen.jenislinen_id = t.jenislinen_id';
//		if(!empty($this->tglregisterlinen)){
//			$criteria->addCondition("DATE(t.tglregisterlinen) = '".$this->tglregisterlinen."'");
//		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('t.linen_id = '.$this->linen_id);
		}
		if(!empty($this->jenislinen_id)){
			$criteria->addCondition('t.jenislinen_id = '.$this->jenislinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->rakpenyimpanan_id)){
			$criteria->addCondition('t.rakpenyimpanan_id = '.$this->rakpenyimpanan_id);
		}
		if(!empty($this->bahanlinen_id)){
			$criteria->addCondition('t.bahanlinen_id = '.$this->bahanlinen_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('t.barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang.barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(bahanlinen.bahalinen_nama)',strtolower($this->bahanlinen_nama),true);
		$criteria->compare('LOWER(jenislinen.jenislinen_nama)',strtolower($this->jenislinen_nama),true);
		$criteria->compare('LOWER(t.kodelinen)',strtolower($this->kodelinen),true);
		$criteria->compare('LOWER(t.noregisterlinen)',strtolower($this->noregisterlinen),true);
		$criteria->compare('LOWER(t.namalinen)',strtolower($this->namalinen),true);
		$criteria->compare('LOWER(t.namalainnya)',strtolower($this->namalainnya),true);
		$criteria->compare('LOWER(t.merklinen)',strtolower($this->merklinen),true);
		if(!empty($this->beratlinen)){
			$criteria->addCondition('t.beratlinen = '.$this->beratlinen);
		}
		$criteria->compare('LOWER(t.warna)',strtolower($this->warna),true);
		$criteria->compare('LOWER(t.tahunbeli)',strtolower($this->tahunbeli),true);
		$criteria->compare('LOWER(t.gambarlinen)',strtolower($this->gambarlinen),true);
		if(!empty($this->jmlcucilinen)){
			$criteria->addCondition('t.jmlcucilinen = '.$this->jmlcucilinen);
		}
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('t.create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('t.update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('t.create_ruangan = '.$this->create_ruangan);
		}
		$criteria->compare('t.linen_aktif',$this->linen_aktif);
		$criteria->compare('LOWER(t.satuanlinen)',strtolower($this->satuanlinen),true);
//                RSSP-689
//		$criteria->addCondition("t.linen_id in(select linen_id from penyimpananlinen_t)");
//		$this->tglregisterlinen = $format->formatDateTimeForUser($this->tglregisterlinen);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=>5,
            )
		));
	}
}
