<?php

class KUInformasiinvoicetagihanV extends InformasiinvoicetagihanV
{
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function searchInvoice()
	{
		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(invoicetagihan_tgl)', $this->tgl_awal, $this->tgl_akhir);

		$criteria->compare('LOWER(invoicetagihan_tgl)',strtolower($this->invoicetagihan_tgl),true);
		$criteria->compare('LOWER(namapenagih)',strtolower($this->namapenagih),true);
		$criteria->compare('LOWER(invoicetagihan_no)',strtolower($this->invoicetagihan_no),true);
		$criteria->compare('LOWER(rekanan_tagihan)',strtolower($this->rekanan_tagihan),true);
		$criteria->compare('total_tagihan',$this->total_tagihan);
		$criteria->compare('LOWER(disetujui_nama)',strtolower($this->disetujui_nama),true);
		$criteria->compare('LOWER(disetujui_posisi)',strtolower($this->disetujui_posisi),true);
		$criteria->compare('LOWER(verifikator_nama)',strtolower($this->verifikator_nama),true);
		$criteria->select = "invoicetagihan_no,invoicetagihan_id,invoicetagihan_tgl,namapenagih,perihal_tagihan,rekanan_tagihan,total_tagihan,tgl_verfikasi_tagihan,verifikator_nama,status_verifikasi";
		$criteria->group = $criteria->select;
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public static function statusVerifikasi(){
		return array(
			'1' => 'Sudah Verifikasi',
			'0' => 'Belum Verifikasi'
		);
	}
 	
}