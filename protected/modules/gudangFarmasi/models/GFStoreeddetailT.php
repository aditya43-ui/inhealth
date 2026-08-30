<?php

/**
 * This is the model class for table "storeeddetail_t".
 *
 * The followings are the available columns in table 'storeeddetail_t':
 * @property integer $storeeddetail_id
 * @property integer $satuankecil_id
 * @property integer $obatalkes_id
 * @property integer $storeed_id
 * @property string $tglkadaluarsa
 * @property integer $qtystoked
 * @property string $keterangan_obated
 * @property boolean $isdikembalikan
 */
class GFStoreeddetailT extends StoreeddetailT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreeddetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = "t.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, supplier_m.supplier_id,"
				. "supplier_m.supplier_nama, obatsupplier_m.obatsupplier_id, obatsupplier_m.obatalkes_id, obatsupplier_m.supplier_id,"
				. "satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama";

		$criteria->join = 'LEFT JOIN obatalkes_m ON t.obatalkes_id=obatalkes_m.obatalkes_id
							LEFT JOIN satuankecil_m ON t.satuankecil_id=satuankecil_m.satuankecil_id
							LEFT JOIN obatsupplier_m ON t.obatalkes_id=obatsupplier_m.obatalkes_id
							LEFT JOIN supplier_m ON obatsupplier_m.supplier_id=supplier_m.supplier_id';

		if(!empty($this->storeeddetail_id)){
			$criteria->addCondition('t.storeeddetail_id = '.$this->storeeddetail_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->obatalkes_nama)){
			$criteria->addCondition('obatalkes_m.obatalkes_nama = '.$this->obatalkes_nama);
		}
		if(!empty($this->storeed_id)){
			$criteria->addCondition('t.storeed_id = '.$this->storeed_id);
		}
		$criteria->compare('DATE(t.tglkadaluarsa)',MyFormatter::formatDateTimeForDb($this->tglkadaluarsa));
		if(!empty($this->qtystoked)){
			$criteria->addCondition('t.qtystoked = '.$this->qtystoked);
		}
		$criteria->compare('LOWER(t.keterangan_obated)',strtolower($this->keterangan_obated),true);
		$criteria->compare('t.isdikembalikan',$this->isdikembalikan);

		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_m.supplier_id = '.$this->supplier_id);
		}

		 $criteria->limit=10;

		 return new CActiveDataProvider($this, array(
				 'criteria'=>$criteria,
		 ));
	}

	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = "t.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama";

		$criteria->join = 'JOIN obatalkes_m ON t.obatalkes_id=obatalkes_m.obatalkes_id
						   JOIN satuankecil_m ON t.satuankecil_id=satuankecil_m.satuankecil_id';
		
		if(!empty($this->storeeddetail_id)){
			$criteria->addCondition('t.storeeddetail_id = '.$this->storeeddetail_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->storeed_id)){
			$criteria->addCondition('t.storeed_id = '.$this->storeed_id);
		}
		$criteria->compare('DATE(tglkadaluarsa)', strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(qtystoked)',strtolower($this->qtystoked),true);
		$criteria->compare('LOWER(keterangan_obated)',strtolower($this->keterangan_obated),true);
		$criteria->addCondition('isdikembalikan IS FALSE');
		 $criteria->limit=10;

		 return new CActiveDataProvider($this, array(
				 'criteria'=>$criteria,
		 ));
	}
}