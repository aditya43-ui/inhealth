<?php

class KUUangMukaBeliT extends UangmukabeliT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UangmukabeliT the static model class
	 */
    
        public $tgl_awal, $tgl_akhir;
        public $nokaskeluar, $nopenerimaan, $nopermintaan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
         public function searchInformasi() {
				$criteria=new CDbCriteria;
               // var_dump($this->tgl_awal);
				$criteria->join =	"	LEFT JOIN tandabuktikeluar_t tbk ON tbk.uangmukabeli_id = t.uangmukabeli_id "
								.	"	LEFT JOIN penerimaanbarang_t pb ON pb.penerimaanbarang_id = t.penerimaanbarang_id"
								.	"	LEFT JOIN permintaanpembelian_t pp ON pb.permintaanpembelian_id = t.permintaanpembelian_id";
                //$criteria->with = array('penerimaanbarang','tandabuktikeluar','permintaanpembelian');
                $criteria->addBetweenCondition('date(tgluangmukabeli)', $this->tgl_awal, $this->tgl_akhir);
		//$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
                if (!empty($this->supplier_id)){
                    $criteria->addCondition("t.supplier_id = '".$this->supplier_id."' ");
                }
//		$criteria->compare('supplier_id',$this->supplier_id);
                $criteria->compare('LOWER(pb.noterima)',  strtolower($this->nopenerimaan), TRUE);
				$criteria->compare('LOWER(tbk.nokaskeluar)',  strtolower($this->nokaskeluar), TRUE);
                $criteria->compare('LOWER(pp.nopermintaan)',  strtolower($this->nopermintaan), TRUE);
		//$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		//$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		//$criteria->compare('LOWER(rekatasnama)',strtolower($this->rekatasnama),true);
		//$criteria->compare('jumlahuang',$this->jumlahuang);
                //$criteria->addCondition("penerimaanbarang_id IS NOT NULL");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
}