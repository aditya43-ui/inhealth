<?php

/**
 * This is the model class for table "laporaninvoicetagihan_v".
 *
 * The followings are the available columns in table 'laporaninvoicetagihan_v':
 * @property integer $ruangan_id
 * @property integer $invoicetagihan_id
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $ruangan_nama
 * @property string $invoicetagihan_no
 * @property string $invoicetagihan_tgl
 * @property string $namapenagih
 * @property string $perihal_tagihan
 * @property string $ket_pembayaran
 * @property string $rekanan_tagihan
 * @property string $isisurat_tagihan
 * @property boolean $status_verifikasi
 * @property string $tgl_verfikasi_tagihan
 * @property double $total_tagihan
 * @property string $disetujui_nama
 * @property string $disetujui_posisi
 * @property string $verifikator_nama
 * @property string $verifikator_posisi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemekai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $invoicetagdetail_id
 * @property string $uraian_tagdetail
 * @property double $total_tagdetail
 * @property string $ket_tagdetail
 * @property integer $invoicedisposisi_id
 * @property string $uraian_disoposisi
 * @property double $total_disposisi
 * @property string $ket_disposisi
 */
class KULaporaninvoicetagihanV extends LaporaninvoicetagihanV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporaninvoicetagihanV the static model class
	 */
	public $jns_periode, $tgl_awal, $bln_awal, $thn_awal;
	public $tgl_akhir, $bln_akhir, $thn_akhir;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function dataSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->invoicetagihan_id)){
			$criteria->addCondition('invoicetagihan_id = '.$this->invoicetagihan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->addBetweenCondition('DATE(invoicetagihan_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(invoicetagihan_no)',strtolower($this->invoicetagihan_no),true);
		$criteria->compare('LOWER(namapenagih)',strtolower($this->namapenagih),true);
		$criteria->compare('LOWER(perihal_tagihan)',strtolower($this->perihal_tagihan),true);
		$criteria->compare('LOWER(ket_pembayaran)',strtolower($this->ket_pembayaran),true);
		$criteria->compare('LOWER(rekanan_tagihan)',strtolower($this->rekanan_tagihan),true);
		$criteria->compare('LOWER(isisurat_tagihan)',strtolower($this->isisurat_tagihan),true);
		$criteria->compare('status_verifikasi',$this->status_verifikasi);
		$criteria->compare('LOWER(tgl_verfikasi_tagihan)',strtolower($this->tgl_verfikasi_tagihan),true);
		$criteria->compare('total_tagihan',$this->total_tagihan);
		$criteria->compare('LOWER(disetujui_nama)',strtolower($this->disetujui_nama),true);
		$criteria->compare('LOWER(disetujui_posisi)',strtolower($this->disetujui_posisi),true);
		$criteria->compare('LOWER(verifikator_nama)',strtolower($this->verifikator_nama),true);
		$criteria->compare('LOWER(verifikator_posisi)',strtolower($this->verifikator_posisi),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemekai_id)){
			$criteria->addCondition('create_loginpemekai_id = '.$this->create_loginpemekai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->invoicetagdetail_id)){
			$criteria->addCondition('invoicetagdetail_id = '.$this->invoicetagdetail_id);
		}
		$criteria->compare('LOWER(uraian_tagdetail)',strtolower($this->uraian_tagdetail),true);
		$criteria->compare('total_tagdetail',$this->total_tagdetail);
		$criteria->compare('LOWER(ket_tagdetail)',strtolower($this->ket_tagdetail),true);
		if(!empty($this->invoicedisposisi_id)){
			$criteria->addCondition('invoicedisposisi_id = '.$this->invoicedisposisi_id);
		}
		$criteria->compare('LOWER(uraian_disoposisi)',strtolower($this->uraian_disoposisi),true);
		$criteria->compare('total_disposisi',$this->total_disposisi);
		$criteria->compare('LOWER(ket_disposisi)',strtolower($this->ket_disposisi),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchTabel()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->dataSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function cariPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->dataSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}