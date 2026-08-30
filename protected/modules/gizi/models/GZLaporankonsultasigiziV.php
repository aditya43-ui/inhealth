<?php
class GZLaporankonsultasigiziV extends LaporankonsultasigiziV
{
        public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $tglmasukpenunjang;
        public $jumlahTampil;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->select ='no_rekam_medik,nama_pasien,no_pendaftaran,no_masukpenunjang,jenisdiet_nama,
                                    ruanganasal_nama,kelaspelayanan_nama,kelaspelayanan_id,date(tglmasukpenunjang) as tglmasukpenunjang,
                                    sum(qty_tindakan) as qty_tindakan, sum(tarif_tindakan) as tarif_tindakan';
                                    
                $criteria->group ='no_rekam_medik,nama_pasien,no_pendaftaran,no_masukpenunjang,jenisdiet_nama,
                                    ruanganasal_nama,kelaspelayanan_nama,kelaspelayanan_id,date(t.tglmasukpenunjang)';
                $criteria->addBetweenCondition('DATE(tglmasukpenunjang)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array('pageSize' => $this->jumlahTampil,),
                        'totalItemCount' => $this->jumlahTampil,
		));
	}
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria=new CDbCriteria;

                $criteria->select ='no_rekam_medik,nama_pasien,no_pendaftaran,no_masukpenunjang,jenisdiet_nama,
                                    ruanganasal_nama,kelaspelayanan_nama,kelaspelayanan_id,date(tglmasukpenunjang) as tglmasukpenunjang,
                                    sum(qty_tindakan) as qty_tindakan, sum(tarif_tindakan) as tarif_tindakan';
                                    
                $criteria->group ='no_rekam_medik,nama_pasien,no_pendaftaran,no_masukpenunjang,jenisdiet_nama,
                                    ruanganasal_nama,kelaspelayanan_nama,kelaspelayanan_id,date(t.tglmasukpenunjang)';
                $criteria->addBetweenCondition('DATE(tglmasukpenunjang)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
                     'pagination' => array('pageSize' => $this->jumlahTampil,),
                    'totalItemCount' => $this->jumlahTampil,
		));
	}
        
}
?>