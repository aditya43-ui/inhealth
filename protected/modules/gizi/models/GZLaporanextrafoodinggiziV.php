<?php
class GZLaporanextrafoodinggiziV extends LaporanextrafoodinggiziV
{
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
         
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->addBetweenCondition('DATE(tglkirimmenu)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('LOWER(keterangan_kirim)',strtolower($this->keterangan_kirim),true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jml_kirim',$this->jml_kirim);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('LOWER(jeniswaktu_nama)',strtolower($this->jeniswaktu_nama),true);
		$criteria->compare('LOWER(menudiet_nama)',strtolower($this->menudiet_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(jeniswaktu_jam)',strtolower($this->jeniswaktu_jam),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->addBetweenCondition('DATE(tglkirimmenu)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('LOWER(keterangan_kirim)',strtolower($this->keterangan_kirim),true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jml_kirim',$this->jml_kirim);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('LOWER(jeniswaktu_nama)',strtolower($this->jeniswaktu_nama),true);
		$criteria->compare('LOWER(menudiet_nama)',strtolower($this->menudiet_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(jeniswaktu_jam)',strtolower($this->jeniswaktu_jam),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
                
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//			jika komen dibawah diaktifkan, akan muncul error ketika print Extra Fooding 
//                        'pagination'=>false,
		));
	}
}
?>