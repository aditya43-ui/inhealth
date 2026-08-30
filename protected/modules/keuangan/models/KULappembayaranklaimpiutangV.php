<?php
/**
* - digunakan untuk memanggil view lappembayaranklaimpiutang_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/


class KULappembayaranklaimpiutangV extends LappembayaranklaimpiutangV
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

		$criteria->addBetweenCondition('date(tglpembayaranklaim)',date("Y-m-01",strtotime($this->tgl_awal.' -3 month')),$this->tgl_akhir);
		if (!empty($this->penjamin_id)){
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition("penjamin_id", $this->penjamin_id);
			}else{
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);
			}
		}

		return $criteria;
	}
	
	public function searchTableLaporan(){
		$criteria = $this->criteriaSearchLaporan();		
		$criteria->select = "  penjamin_id, penjamin_nama ";
		$criteria->order = " penjamin_nama ASC ";
		$criteria->group = " penjamin_id, penjamin_nama ";
		$criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchTableLaporanPrint(){
		$criteria = $this->criteriaSearchLaporan();		
		$criteria->select = "  penjamin_id, penjamin_nama ";
		$criteria->order = " penjamin_nama ASC ";
		$criteria->group = " penjamin_id, penjamin_nama ";
		$criteria->limit = -1;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function getJumlahBayarTotal($bln, $thn, $penjamin_id = null)
	{		
		$awal = $thn.date('-m-01', strtotime('first day of january'));
		$tgl_awal = date('Y-m-01', strtotime($awal.' +'.($bln-1).' month'));
		$tgl_akhir = date('Y-m-t', strtotime($awal.' +'.($bln-1).' month'));
				
		$criteria = new CDbCriteria;
		$criteria->select = " sum(jumlahbayar) as jumlahbayar ";
		$criteria->addBetweenCondition('date(tglpembayaranklaim)',$tgl_awal,$tgl_akhir);	
        $criteria->compare("penjamin_id", $penjamin_id);
						
		
		$get = LappembayaranklaimpiutangV::model()->find($criteria);
		
		if (!empty($get)){
			return number_format($get->jumlahbayar,0,"",".");
		}else{
			return '';
		}
		
	}
	public function getJumlahBayar($bln, $penjamin_id, $thn)
	{		
		$awal = $thn.date('-m-01', strtotime('first day of january'));
		$tgl_awal = date('Y-m-01', strtotime($awal.' +'.($bln-1).' month'));
		$tgl_akhir = date('Y-m-t', strtotime($awal.' +'.($bln-1).' month'));
				
		$criteria = new CDbCriteria;
		$criteria->select = " sum(jumlahbayar) as jumlahbayar ";
		$criteria->addBetweenCondition('date(tglpembayaranklaim)',$tgl_awal,$tgl_akhir);		
		$criteria->addCondition(" penjamin_id = ".$penjamin_id." ");
						
		
		$get = LappembayaranklaimpiutangV::model()->find($criteria);
		
		if (!empty($get)){
			return number_format($get->jumlahbayar,0,"",".");
		}else{
			return '';
		}
		
	}
    
    public function getJumlahPiutang4BulanTotal($bln, $thn, $penjamin_id = null)
    {
        $awal = $thn.date('-m-01', strtotime('first day of january'));
		$tgl_akhir = date('Y-m-t', strtotime($awal.' +'.($bln).' month'));
		$tgl_awal = date('Y-m-01', strtotime($awal.' +'.($bln-3).' month'));
		
		//var_dump($tgl_akhir);						
		//var_dump($tgl_awal);						
		$criteria = new CDbCriteria;
		$criteria->select = " sum(jmlpiutang) as jmlpiutang ";
		$criteria->addBetweenCondition('date(tglpembayaranklaim)',$tgl_awal,$tgl_akhir);	
        $criteria->compare("penjamin_id", $penjamin_id);	
						
		
		$get = LappembayaranklaimpiutangV::model()->find($criteria);
		
		if (!empty($get)){
			return number_format($get->jmlpiutang,0,"",".");
		}else{
			return '';
		}
    }
	
	public function getJumlahPiutang4Bulan($bln, $penjamin_id, $thn)
	{		
		$awal = $thn.date('-m-01', strtotime('first day of january'));
		$tgl_akhir = date('Y-m-t', strtotime($awal.' +'.($bln).' month'));
		$tgl_awal = date('Y-m-01', strtotime($awal.' +'.($bln-3).' month'));
		
		//var_dump($tgl_akhir);						
		//var_dump($tgl_awal);						
		$criteria = new CDbCriteria;
		$criteria->select = " sum(jmlpiutang) as jmlpiutang ";
		$criteria->addBetweenCondition('date(tglpembayaranklaim)',$tgl_awal,$tgl_akhir);		
		$criteria->addCondition(" penjamin_id = ".$penjamin_id." ");
						
		
		$get = LappembayaranklaimpiutangV::model()->find($criteria);
		
		if (!empty($get)){
			return number_format($get->jmlpiutang,0,"",".");
		}else{
			return '';
		}
		
	}
	
	public function getJumlahBayar4BulanTotal($bln, $thn, $penjamin_id = null)
	{		
		$awal = $thn.date('-m-01', strtotime('first day of january'));
		$tgl_akhir = date('Y-m-t', strtotime($awal.' +'.($bln).' month'));
		$tgl_awal = date('Y-m-01', strtotime($awal.' +'.($bln-3).' month'));
		
		//var_dump($tgl_akhir);						
		//var_dump($tgl_awal);						
		$criteria = new CDbCriteria;
		$criteria->select = " sum(jumlahbayar) as jumlahbayar ";
		$criteria->addBetweenCondition('date(tglpembayaranklaim)',$tgl_awal,$tgl_akhir);
        $criteria->compare("penjamin_id", $penjamin_id);	
						
		
		$get = LappembayaranklaimpiutangV::model()->find($criteria);
		
		if (!empty($get)){
			return number_format($get->jumlahbayar,0,"",".");
		}else{
			return '';
		}
		
	}
    
	public function getJumlahBayar4Bulan($bln, $penjamin_id, $thn)
	{		
		$awal = $thn.date('-m-01', strtotime('first day of january'));
		$tgl_akhir = date('Y-m-t', strtotime($awal.' +'.($bln).' month'));
		$tgl_awal = date('Y-m-01', strtotime($awal.' +'.($bln-3).' month'));
		
		//var_dump($tgl_akhir);						
		//var_dump($tgl_awal);						
		$criteria = new CDbCriteria;
		$criteria->select = " sum(jumlahbayar) as jumlahbayar ";
		$criteria->addBetweenCondition('date(tglpembayaranklaim)',$tgl_awal,$tgl_akhir);		
		$criteria->addCondition(" penjamin_id = ".$penjamin_id." ");
						
		
		$get = LappembayaranklaimpiutangV::model()->find($criteria);
		
		if (!empty($get)){
			return number_format($get->jumlahbayar,0,"",".");
		}else{
			return '';
		}
		
	}
}