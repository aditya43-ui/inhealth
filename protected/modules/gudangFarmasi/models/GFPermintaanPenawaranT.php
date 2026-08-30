<?php

class GFPermintaanPenawaranT extends PermintaanpenawaranT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaanpenawaranT the static model class
	 */
        public $tgl_awal,$tgl_akhir;
        public $pegawaimengetahui_nama;
        public $pegawaimenyetujui_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPermintaanPembelian()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->compare('date(tglpenawaran)',$this->tglpenawaran);
		$criteria->compare('LOWER(nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                           
		$criteria->with = array('supplier','permintaanpembelian');
		$criteria->addBetweenCondition('date(tglpenawaran)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		$criteria->addCondition("permintaanpembelian.permintaanpembelian_id is null");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}