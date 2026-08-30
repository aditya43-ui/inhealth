<?php

class BKLaporansetorankasirbendaharaV extends LaporansetorankasirbendaharaV
{
	public $jns_periode;
	public $tgl_awal, $tgl_akhir;
	public $bln_awal, $bln_akhir;
	public $thn_awal, $thn_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiclosingkasirV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchLaporan()
	{
		$criteria = new CDbCriteria;
		$criteria->addBetweenCondition('date(tglsetorankasir)', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrintLaporan()
	{
		$criteria = new CDbCriteria;
		$criteria->addBetweenCondition('date(tglsetorankasir)', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	

	
}