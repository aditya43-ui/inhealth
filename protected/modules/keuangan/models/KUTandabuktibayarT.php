<?php

class KUTandabuktibayarT extends TandabuktibayarT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandabuktibayarT the static model class
	 */
	public $tgl_awal;
	public $tgl_akhir;
	public $is_menggunakankartu;
	public $carabayar_id,$penjamin_id;
	
	
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
		$criteria->addCondition('closingkasir_id IS NULL AND pembatalanuangmuka_id IS NULL');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	public function getRuanganKasir(){
		return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>Params::INSTALASI_ID_KASIR));
	}
	
	public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
	
	public function getPenjaminItems($carabayar_id=null)
	{
	   if(!empty($carabayar_id))
			   return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true,'carabayar_id'=>$carabayar_id),array('order'=>'penjamin_nama'));
	   else
			   return array();
	}
}