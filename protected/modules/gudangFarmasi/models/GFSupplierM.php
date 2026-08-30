<?php

class GFSupplierM extends SupplierM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupplierM the static model class
	 */
        public $harganetto, $hargajual,$harganettoppn,$obatalkes_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
                $criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
                $criteria->compare('LOWER(supplier_jenis)','farmasi',true);
		$criteria->compare('supplier_aktif',isset($this->supplier_aktif)?$this->supplier_aktif:true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));                
        }
        
	public function searchPrintSuplier()
	{
		$criteria=new CDbCriteria;
		
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
                $criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
                $criteria->compare('LOWER(supplier_jenis)','farmasi',true);
		$criteria->compare('supplier_aktif',$this->supplier_aktif);
                $criteria->order='t.supplier_id asc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));            
        }
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->select='t.supplier_id, t.supplier_kode, t.supplier_aktif, t.supplier_alamat,  t.supplier_nama, obatalkes_m.obatalkes_nama, obatalkes_m.obatalkes_id, obatsupplier_m.hargajual, obatsupplier_m.harganetto, obatsupplier_m.harganettoppn';
		$criteria->join = 'JOIN obatsupplier_m ON obatsupplier_m.supplier_id = t.supplier_id  JOIN obatalkes_m ON obatsupplier_m.obatalkes_id = obatalkes_m.obatalkes_id';
				
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
                $criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
                $criteria->compare('LOWER(supplier_jenis)','farmasi',true);
		$criteria->compare('supplier_aktif',$this->supplier_aktif);
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
                $criteria->order='t.supplier_id asc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
        }
        
        public function searchObatSupplier()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select='t.supplier_id, t.supplier_kode, t.supplier_aktif, t.supplier_alamat,  t.supplier_nama, obatalkes_m.obatalkes_nama, obatalkes_m.obatalkes_id, obatsupplier_m.hargajual, obatsupplier_m.harganetto, obatsupplier_m.harganettoppn';
                $criteria->join = 'JOIN obatsupplier_m ON obatsupplier_m.supplier_id = t.supplier_id  JOIN obatalkes_m ON obatsupplier_m.obatalkes_id = obatalkes_m.obatalkes_id';
//              $criteria->group = 't.supplier_id, t.supplier_kode,obatsupplier_m.supplier_id, obatsupplier_m.obatalkes_id,t.supplier_aktif, t.supplier_alamat, t.supplier_nama, obatalkes_m.obatalkes_nama, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_id, obatsupplier_m.harganetto, obatsupplier_m.hargajual, obatsupplier_m.harganettoppn';
		//$criteria->compare('obatalkes_m.obatalkes_nama', $this->obatalkes_nama);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
                $criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
                $criteria->compare('LOWER(supplier_jenis)','farmasi',true);
		$criteria->compare('supplier_aktif',$this->supplier_aktif);
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
                /*
                if(strlen($this->obatalkes_nama) > 0)
                {
                    $criteria->addCondition("LOWER(obatalkes_m.obatalkes_nama) LIKE '%". strtolower($this->obatalkes_nama) ."%'");
                }
                 * 
                 */
                $criteria->order='t.supplier_id asc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getSupplierItems()
        {
            $criteria = new CDbCriteria();
            $criteria->addCondition("supplier_aktif=TRUE AND supplier_jenis='Farmasi'");
            $criteria->order = "supplier_nama";
            $items= GFSupplierM::model()->findAll($criteria);
            return $items;
        }
        
}
?>