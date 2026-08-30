<?php
class KUDaftarrencanapembayaranT extends DaftarrencanapembayaranT
{
    public $tgl_awal, $tgl_akhir, $jenispengeluaran_id, $jenisverifikasi_id, $no_bku, $tgl_bku, $bank_id, $jenispengeluaran_nama, $no_rekening, $diskon, $ver_pengembalianuangmuka_id, $verpengembalianuangmukadet_id, $supplier_nama;
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remo ve attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
//		$criteria->with = array('verpengeluaran');
		$criteria->addBetweenCondition('tgl_bku', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(no_bku)',strtolower($this->no_bku),true);
		if(!empty($this->jenispengeluaran_id)){
			$criteria->addCondition('jenispengeluaran_id='.$this->jenispengeluaran_id);
		}
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchDetail($id=null){
		$criteria=new CDbCriteria;
		
		
//		$criteria->addBetweenCondition('tgl_voucher', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(no_bku)',strtolower($this->no_bku),true);
		if(!empty($this->jenispengeluaran_id)){
			$criteria->addCondition('jenispengeluaran_id='.$this->jenispengeluaran_id);
		}
		
		if(!empty($id)){
			$criteria->addCondition('bkupengembalianuangmuka_id = '.$id);
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function jenisPengeluaran($jenispengeluaran_id){
		$modjenis=  JenispengeluaranM::model()->findByPk($jenispengeluaran_id);
		if(!empty($modjenis)){
			return $modjenis->jenispengeluaran_nama;
		}
	}
	
	public function jenisBank($bank_id){
		$modjenis=BankM::model()->findByPk($bank_id);
		if(!empty($modjenis)){
			return $modjenis->namabank;
		}
	}
	
        /**
	* kriteria pencarian untuk dashboard
	* @return \CActiveDataProvider
	*/
	public function searchDashboard()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.

	   $criteria=new CDbCriteria;
//	   $criteria->addCondition("date(tglpiutangmacet) >= '".date("Y-m-d")."'");
	   $criteria->order = 'tgl_voucher DESC';
	   $criteria->limit = 10;
	   return new CActiveDataProvider($this, array(
		   'criteria'=>$criteria,
		   'pagination'=>false
	   ));
	}   
	
        
        public function searchLaporan()
	{
		$criteria=new CDbCriteria;
		
		$criteria->addBetweenCondition('date(tgl_voucher)', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchLaporanPrint()
	{
		$criteria=new CDbCriteria;
		
		$criteria->addBetweenCondition('date(tgl_voucher)', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}
}