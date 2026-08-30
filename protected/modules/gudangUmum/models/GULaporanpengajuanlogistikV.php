<?php
/**
* - digunakan untuk memanggil view laporanpengajuanlogistik_v, hanya untuk modul gudang umum
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class GULaporanpengajuanlogistikV extends LaporanpengajuanlogistikV
{
	public $tgl_awal, $tgl_akhir;
	public $bln_awal, $bln_akhir;
	public $thn_awal, $thn_akhir;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  target bep
	 * @return \CActiveDataProvider
	 */
	public function searchTable(){
		
		$ruangan_id = array();
		
		
		
		$criteria = $this->searchCriteria();
		$criteria->select =	" b.barang_harganetto,b.barang_satuan, b.barang_nama, b.barang_id, (CASE WHEN t.jenisbarang_nama = '' THEN 'Belum Di Set' ELSE t.jenisbarang_nama END) as jenisbarang_nama";						
		if (!empty($this->ruangan_id)){
			
			foreach($this->ruangan_id as $r){
				$ruangan_id[] = $r->ruangan_id;
			}						
			$criteria->select .=	" ,(SELECT sum(terimabarang) FROM laporanpengajuanlogistik_v WHERE tgltransaksi BETWEEN '".$this->tgl_awal."' AND '".$this->tgl_akhir."' AND ruangan_id = '".$ruangan_id."' )";
		}else{			
			$criteria->select .=	" , (SELECT sum(terimabarang) FROM laporanpengajuanlogistik_v WHERE tgltransaksi BETWEEN '".$this->tgl_awal."' AND '".$this->tgl_akhir."')";
		}
		
		$criteria->group = "b.barang_harganetto, b.barang_satuan, b.barang_nama, b.barang_id, t.jenisbarang_nama ";
		$criteria->order = " t.jenisbarang_nama, b.barang_nama ASC ";
		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  target bep  pada prinout
	 * @return \CActiveDataProvider
	 */
	public function searchPrint(){
		$ruangan_id = array();
		
		
		
		$criteria = $this->searchCriteria();
		$criteria->select =	" b.barang_harganetto,b.barang_satuan, b.barang_nama, b.barang_id, (CASE WHEN t.jenisbarang_nama = '' THEN 'Belum Di Set' ELSE t.jenisbarang_nama END) as jenisbarang_nama";						
		if (!empty($this->ruangan_id)){
			
			foreach($this->ruangan_id as $r){
				$ruangan_id[] = $r->ruangan_id;
			}						
			$criteria->select .=	" ,(SELECT sum(terimabarang) FROM laporanpengajuanlogistik_v WHERE tgltransaksi BETWEEN '".$this->tgl_awal."' AND '".$this->tgl_akhir."' AND ruangan_id = '".$ruangan_id."' )";
		}else{			
			$criteria->select .=	" , (SELECT sum(terimabarang) FROM laporanpengajuanlogistik_v WHERE tgltransaksi BETWEEN '".$this->tgl_awal."' AND '".$this->tgl_akhir."')";
		}
		
		$criteria->group = "b.barang_harganetto, b.barang_satuan, b.barang_nama, b.barang_id, t.jenisbarang_nama ";
		$criteria->order = " t.jenisbarang_nama, b.barang_nama ASC ";
		$criteria->limit = -1;

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false
		));
	}

	/**
	 * - digunakan untuk mengenerate data target bep dalam bentuk grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		//$criteria->select = " count(alatmedis_id) as jumlah, alatmedis_nama as data ";
		//$criteria->group = " data ";
		//$criteria->order = " jumlah DESC ";
		//if ($_GET['tampilGrafik'] == 'wilayah'){

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,                    
		));
	}

	/**
	 * - digunakan untuk memfilter datanya berdasarkan pencarian yang ada
	 * @return \CActiveDataProvider
	 */
	public function searchCriteria(){
		$criteria = new CDbCriteria();
		$criteria->join = " RIGHT JOIN barang_m b ON b.barang_id = t.barang_id ";
		//$criteria->addBetweenCondition('DATE(tgltransaksi)', $this->tgl_awal, $this->tgl_akhir);
		//$criteria->compare('LOWER(alatmedis_nama)', strtolower($this->nama_pasien),true);
		

		return $criteria;
	}
	
	public function getStokAwalByBulan($awal, $barang_id,$ruangan_id='')
	{				
		$tgl_awal = date('Y-m-01', strtotime($awal));
		$tgl_akhir = date('Y-m-t', strtotime($awal));
						
		$criteria = new CDbCriteria;
		$criteria->select = " sum(terimabarang) as terimabarang, sum(pemakaianbarang) as pemakaianbarang ";
		//$criteria->addBetweenCondition('date(tgltransaksi)',$tgl_awal,$tgl_akhir);		
		$criteria->addCondition("date(tgltransaksi) <= '".$tgl_akhir."' ");		
		if (!empty($ruangan_id)){
			$criteria->addInCondition(" ruangan_id ",$ruangan_id);
		}		
		$criteria->addCondition(" barang_id = ".$barang_id." ");
						
		
		$get = LaporanpengajuanlogistikV::model()->find($criteria);
		//var_dump($awal);
		if (!empty($get)){
			if ($get->terimabarang == null || $get->terimabarang == '' || $get->terimabarang == 0){
				return '';
			}else{
				//var_dump($get->pemakaianbarang);
				if ($get->pemakaianbarang == null || $get->pemakaianbarang == ''){
					$get->pemakaianbarang = 0;
				}
				
				return $get->terimabarang - $get->pemakaianbarang;
			}
			
		}else{
			return '';
		}
		
	}
	
	public function getTerimaBarangByBulan($awal, $barang_id, $ruangan_id='')
	{				
		$tgl_awal = date('Y-m-01', strtotime($awal));
		$tgl_akhir = date('Y-m-t', strtotime($awal));
						
		$criteria = new CDbCriteria;
		$criteria->select = " sum(terimabarang) as terimabarang ";
		$criteria->addBetweenCondition('date(tgltransaksi)',$tgl_awal,$tgl_akhir);		
		if (!empty($ruangan_id)){
			$criteria->addInCondition(" ruangan_id ",$ruangan_id);
		}
		$criteria->addCondition(" barang_id = ".$barang_id." ");
						
		
		$get = LaporanpengajuanlogistikV::model()->find($criteria);
		//var_dump($awal);
		if (!empty($get)){
			if ($get->terimabarang == null || $get->terimabarang == '' || $get->terimabarang == 0){
				return '';
			}else{
				return $get->terimabarang;
			}
			
		}else{
			return '';
		}
		
	}
	
	public function getPemakaianByBulan($awal, $barang_id, $ruangan_id='')
	{				
		$tgl_awal = date('Y-m-01', strtotime($awal));
		$tgl_akhir = date('Y-m-t', strtotime($awal));
						
		$criteria = new CDbCriteria;
		$criteria->select = " sum(pemakaianbarang) as pemakaianbarang ";
		$criteria->addBetweenCondition('date(tgltransaksi)',$tgl_awal,$tgl_akhir);		
		if (!empty($ruangan_id)){
			$criteria->addInCondition(" ruangan_id ",$ruangan_id);
		}
		$criteria->addCondition(" barang_id = ".$barang_id." ");
						
		
		$get = LaporanpengajuanlogistikV::model()->find($criteria);
		//var_dump($awal);
		if (!empty($get)){
			if ($get->pemakaianbarang == null || $get->pemakaianbarang == '' || $get->pemakaianbarang == 0){
				return '';
			}else{
				return $get->pemakaianbarang;
			}
			
		}else{
			return '';
		}
		
	}
	
	public function getTotalStokByBulan($awal, $barang_id, $ruangan_id='')
	{				
		$stokawal = $this->getStokAwalByBulan($awal, $barang_id, $ruangan_id);				
		$terima = $this->getTerimaBarangByBulan(date('Y-m-d', strtotime($awal.' +1 month')), $barang_id, $ruangan_id);
		
		if(!empty($stokawal)){
			$stokawal = $stokawal;
		}else{
			$stokawal = 0;
		}
		
		if(!empty($terima)){
			$terima = $terima;
		}else{
			$terima = 0;
		}
		
		$total = $stokawal + $terima;
		
		if ($total == 0){
			return '';
		}else{
			return $total;
		}		
	}
	
	public function getRencanaByBulan($awal, $barang_id, $ruangan_id='')
	{				
		$tgl_awal = date('Y-m-01', strtotime($awal));
		$tgl_akhir = date('Y-m-t', strtotime($awal));
						
		$criteria = new CDbCriteria;
		$criteria->select = " sum(rencanapemesanan) as rencanapemesanan ";
		$criteria->addBetweenCondition('date(tgltransaksi)',$tgl_awal,$tgl_akhir);		
		if (!empty($ruangan_id)){
			$criteria->addInCondition(" ruangan_id ",$ruangan_id);
		}
		$criteria->addCondition(" barang_id = ".$barang_id." ");
						
		
		$get = LaporanpengajuanlogistikV::model()->find($criteria);
		
		if (!empty($get)){
			
			if ($get->rencanapemesanan == null || $get->rencanapemesanan == '' || $get->rencanapemesanan == 0){
				return '';
			}else{
				return $get->rencanapemesanan;
			}
			
		}else{
			return '';
		}
		
	}
	
	public function getHargaBeliByBulan($awal, $barang_id, $ruangan_id='')
	{				
		$tgl_awal = date('Y-m-01', strtotime($awal));
		$tgl_akhir = date('Y-m-t', strtotime($awal));
						
		$criteria = new CDbCriteria;
		$criteria->select = " hargabeli ";
		$criteria->addCondition("date(tgltransaksi) <= '".$tgl_akhir."' ");		
		if (!empty($ruangan_id)){
			$criteria->addInCondition(" ruangan_id ",$ruangan_id);
		}
		$criteria->addCondition(" barang_id = ".$barang_id." ");
		$criteria->addCondition(" terimabarang > 0 ");
		$criteria->order = " tgltransaksi DESC ";
		$criteria->limit = 1;
		
		
		$get = LaporanpengajuanlogistikV::model()->find($criteria);
		
		if (!empty($get)){
			
			if ($get->hargabeli == null || $get->hargabeli == '' || $get->hargabeli == 0){
				return '';
			}else{
				return $get->hargabeli;
			}
			
		}else{
			return '';
		}
		
	}
	
	public function getTotalHargaBeli($awal, $barang_id, $ruangan_id='')
	{		
		$total = 0;
		$hargabeli = $this->getHargaBeliByBulan($awal, $barang_id, $ruangan_id);				
		$rencana = $this->getRencanaByBulan($awal, $barang_id, $ruangan_id);				
		//var_dump($hargabeli);
		if(!empty($hargabeli)){
			$hargabeli = ($hargabeli);
		}else{
			$hargabeli = 0;
		}
		
		if(!empty($rencana)){
			$rencana = ($rencana);
		}else{
			$rencana = 0;
		}
		
		if (!empty($rencana) && !empty($hargabeli)){
			$total = $hargabeli * $rencana;
		}
		
		if ($total == 0){
			return '';
		}else{
			return $total;
		}		
	}
	
}

?>