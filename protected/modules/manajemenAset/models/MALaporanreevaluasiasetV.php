<?php

class MALaporanreevaluasiasetV extends LaporanreevaluasiasetV
{
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(reevaluasiaset_tgl)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->reevaluasiaset_id)){
			$criteria->addCondition('reevaluasiaset_id = '.$this->reevaluasiaset_id);
		}
		$criteria->compare('LOWER(reevaluasiaset_tgl)',strtolower($this->reevaluasiaset_tgl),true);
		$criteria->compare('LOWER(reevaluasiaset_no)',strtolower($this->reevaluasiaset_no),true);
		if(!empty($this->reevaluasiasetdetail_id)){
			$criteria->addCondition('reevaluasiasetdetail_id = '.$this->reevaluasiasetdetail_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->bidang_id)){
			$criteria->addCondition('bidang_id = '.$this->bidang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		$criteria->compare('LOWER(invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		$criteria->compare('reevaluasiaset_umurekonomis',$this->reevaluasiaset_umurekonomis);
		$criteria->compare('reevaluasiaset_nilaibuku',$this->reevaluasiaset_nilaibuku);
		$criteria->compare('reevaluasiaset_hargaperolehan',$this->reevaluasiaset_hargaperolehan);
		$criteria->compare('reevaluasiaset_selisihreevaluasi',$this->reevaluasiaset_selisihreevaluasi);
		$criteria->compare('reevaluasiaset_totalselisih',$this->reevaluasiaset_totalselisih);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
        
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
		
	public function searchTable() {
        $criteria = new CDbCriteria();
        //$criteria = $this->criteriaSearch();
        $criteria->order = 'reevaluasiaset_tgl DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
	
    public function searchPrint()
    {
        $criteria = new CDbCriteria();
        //$criteria = $this->criteriaSearch();
        $criteria->order = 'reevaluasiaset_tgl DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
	
}