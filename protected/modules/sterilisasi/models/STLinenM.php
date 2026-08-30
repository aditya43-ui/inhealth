<?php
class STLinenM extends LinenM {
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.

	   $criteria=new CDbCriteria;

		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->jenislinen_id)){
			$criteria->addCondition('jenislinen_id = '.$this->jenislinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->rakpenyimpanan_id)){
			$criteria->addCondition('rakpenyimpanan_id = '.$this->rakpenyimpanan_id);
		}
		if(!empty($this->bahanlinen_id)){
			$criteria->addCondition('bahanlinen_id = '.$this->bahanlinen_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(kodelinen)',strtolower($this->kodelinen),true);
		$criteria->compare('LOWER(tglregisterlinen)',strtolower($this->tglregisterlinen),true);
		$criteria->compare('LOWER(noregisterlinen)',strtolower($this->noregisterlinen),true);
		$criteria->compare('LOWER(namalinen)',strtolower($this->namalinen),true);
		$criteria->compare('LOWER(namalainnya)',strtolower($this->namalainnya),true);
		$criteria->compare('LOWER(merklinen)',strtolower($this->merklinen),true);
		if(!empty($this->beratlinen)){
			$criteria->addCondition('beratlinen = '.$this->beratlinen);
		}
		$criteria->compare('LOWER(warna)',strtolower($this->warna),true);
		$criteria->compare('LOWER(tahunbeli)',strtolower($this->tahunbeli),true);
		$criteria->compare('LOWER(gambarlinen)',strtolower($this->gambarlinen),true);
		if(!empty($this->jmlcucilinen)){
			$criteria->addCondition('jmlcucilinen = '.$this->jmlcucilinen);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		$criteria->compare('linen_aktif',$this->linen_aktif);
		$criteria->compare('LOWER(satuanlinen)',strtolower($this->satuanlinen),true);

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;

	   return new CActiveDataProvider($this, array(
			   'criteria'=>$criteria,
	   ));
	} 
        
        public function getNamaBarang($id) {
            $hasil = '';
            $modBarang = BarangM::model()->findByAttributes(array('barang_id'=>$id)); 
            if(isset($modBarang)) {
            $hasil = $modBarang->barang_nama; 
            }
            return $hasil;
            
        }
}
