<?php
class KUInformasipembayaranuangmukapembelianV extends InformasipembayaranuangmukapembelianV
{
    public $tgl_awal, $tgl_akhir;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria= new CDbCriteria();
		$criteria->addBetweenCondition('date(tglkaskeluar)',$this->tgl_awal, $this->tgl_akhir,true);
		$criteria->compare('lower(nokaskeluar)', strtolower($this->nokaskeluar),true);
                $criteria->compare('lower(nopermintaanpembelian)', strtolower($this->nopermintaanpembelian),true);
                $criteria->compare('lower(supplier_jenis)', strtolower($this->supplier_jenis),false);
                
                if(!empty($this->supplier_id)){
                    $criteria->addCondition('supplier_id = '.$this->supplier_id);
                }
                $criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}

?>