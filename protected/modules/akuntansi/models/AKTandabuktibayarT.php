<?php

class AKTandabuktibayarT extends TandabuktibayarT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandabuktibayarT the static model class
	 */
        public $tgl_awal;
        public $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function searchTable()
	{
		$criteria=new CDbCriteria;
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);			
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
		}
		$criteria->addBetweenCondition('DATE(tglbuktibayar)',$this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition('closingkasir_id IS NULL ');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}        
}