<?php
/**
* - digunakan untuk memanggil view lappengajuanklaimpiutang_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/


class KULappengajuanklaimpiutangV extends LappengajuanklaimpiutangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalbayarsupplierT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearchLaporan()
	{		
		$criteria = new CDbCriteria;

		$criteria->addBetweenCondition('date(tglpengajuanklaimanklaim)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('penjamin_id', $this->penjamin_id);

		return $criteria;
	}
	
	public function searchTableLaporan(){
		$criteria = $this->criteriaSearchLaporan();		
		$criteria->order = " tglpengajuanklaimanklaim DESC ";
		$criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchTableLaporanPrint(){
		$criteria = $this->criteriaSearchLaporan();		
		$criteria->order = " tglpengajuanklaimanklaim DESC ";
		$criteria->limit = -1;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
}