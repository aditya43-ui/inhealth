<?php

/**
 * This is the model class for table "obatsupplier_m".
 *
 * The followings are the available columns in table 'obatsupplier_m':
 * @property integer $obatalkes_id
 * @property integer $supplier_id
 */
class SAObatsupplierM extends ObatsupplierM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatsupplierM the static model class
	 */    
	public $obatalkes_nama, $supplier_nama, $tglkadaluarsa, $satuankecil_nama, $stok;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

				$criteria->with = array('obatalkes','supplier');
		$criteria->compare('LOWER(obatalkes.obatalkes_nama)',  strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes.obatalkes_kode)',  strtolower($this->obatalkes_kodeobat),true);
				$criteria->compare('LOWER(supplier.supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier.supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier.supplier_alamat)',strtolower($this->supplier_alamat),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		if(!empty($this->obatsupplier_id)){
			$criteria->addCondition('t.obatsupplier_id = '.$this->obatsupplier_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->satuanbesar_id)){
			$criteria->addCondition('t.satuanbesar_id = '.$this->satuanbesar_id);
		}
		//$criteria->compare('t.hargabelibesar',$this->hargabelibesar);
		if(!empty($this->hargabelibesar)){
			$criteria->addCondition('t.hargabelibesar= '.$this->hargabelibesar);
		}
		//$criteria->compare('t.diskon_persen',$this->diskon_persen);
		if(!empty($this->diskon_persen)){
			$criteria->addCondition('t.diskon_persen= '.$this->diskon_persen);
		}
		//$criteria->compare('t.hargabelikecil',$this->hargabelikecil);
		if(!empty($this->hargabelikecil)){
			$criteria->addCondition('t.hargabelikecil= '.$this->hargabelikecil);
		}
		//$criteria->compare('t.ppn_persen',$this->ppn_persen);
		if(!empty($this->ppn_persen)){
			$criteria->addCondition('t.ppn_persen= '.$this->ppn_persen);
		}
				$criteria->order='supplier.supplier_kode ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}

	public function searchObatSupplierGF()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

				$criteria->with = array('obatalkes','supplier');
		$criteria->compare('LOWER(obatalkes.obatalkes_nama)',  strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes.obatalkes_kode)',  strtolower($this->obatalkes_kodeobat),true);
				$criteria->compare('LOWER(supplier.supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier.supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier.supplier_alamat)',strtolower($this->supplier_alamat),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		if(!empty($this->obatsupplier_id)){
			$criteria->addCondition('t.obatsupplier_id = '.$this->obatsupplier_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->satuanbesar_id)){
			$criteria->addCondition('t.satuanbesar_id = '.$this->satuanbesar_id);
		}
		//$criteria->compare('t.hargabelibesar',$this->hargabelibesar);
		if(!empty($this->hargabelibesar)){
			$criteria->addCondition('t.hargabelibesar= '.$this->hargabelibesar);
		}
		//$criteria->compare('t.diskon_persen',$this->diskon_persen);
		if(!empty($this->diskon_persen)){
			$criteria->addCondition('t.diskon_persen= '.$this->diskon_persen);
		}
		//$criteria->compare('t.hargabelikecil',$this->hargabelikecil);
		if(!empty($this->hargabelikecil)){
			$criteria->addCondition('t.hargabelikecil= '.$this->hargabelikecil);
		}
		//$criteria->compare('t.ppn_persen',$this->ppn_persen);
		if(!empty($this->ppn_persen)){
			$criteria->addCondition('t.ppn_persen= '.$this->ppn_persen);
		}
		$criteria->order='supplier.supplier_kode ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'attributes' => array(
                                'supplier_kode' => array(
                                    'asc' => 'supplier.supplier_kode ASC',
                                    'desc' => 'supplier.supplier_kode DESC',
                                ),
                                'supplier_nama' => array(
                                    'asc' => 'supplier.supplier_nama ASC',
                                    'desc' => 'supplier.supplier_nama DESC',
                                ),
                                'supplier_alamat' => array(
                                    'asc' => 'supplier.supplier_alamat ASC',
                                    'desc' => 'supplier.supplier_alamat DESC',
                                ),
                                'obatalkes_nama' => array(
                                    'asc' => 'obatalkes.obatalkes_nama ASC',
                                    'desc' => 'obatalkes.obatalkes_nama DESC',
                                ),
                                '*',
                            )
                        )
		));
	}
	public function searchObatED()
	{
		$criteria = new CDbCriteria();
		$criteria->select = 't.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, obatalkes_m.tglkadaluarsa,
							supplier_m.supplier_id, supplier_m.supplier_nama, satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama';
		$criteria->join ='JOIN obatalkes_m ON t.obatalkes_id=obatalkes_m.obatalkes_id
						JOIN supplier_m ON t.supplier_id=supplier_m.supplier_id
						JOIN satuankecil_m ON t.satuankecil_id=satuankecil_m.satuankecil_id';
		$criteria->order = 't.obatalkes_id';
		$criteria->limit = 10;
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('t.obatalkes_id= '.$this->obatalkes_id);
		}
		//$criteria->addCondition('obatalkes_m.obatalkes_nama= '.$this->obatalkes_nama);
		//$criteria->addCondition('obatalkes_m.tglkadaluarsa= '.$this->tglkadaluarsa);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id= '.$this->supplier_id);
		}
		//$criteria->addCondition('supplier_m.supplier_nama= '.$this->supplier_nama);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id= '.$this->satuankecil_id);
		}
		//$criteria->addCondition('satuankecil_m.satuankecil_nama= '.$this->satuankecil_nama);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getStokObatRuangan() // menampilkan stok obat per ruangan login
	{ 
			return StokobatalkesT::getJumlahStok($this->obatalkes_id,Yii::app()->user->getState('ruangan_id'));
	}
}