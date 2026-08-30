<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MABarangM extends BarangM
{
     public $golongan_id;
     public $bidang_nama;
     
     public $nopenerimaan;
     public $jmlterima;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getBidangNama(){
        return $this->bidang->bidang_nama;
    }
    
    public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 't.*, bidang.bidang_nama as bidang_nama, subkelompok.subkelompok_nama as subkelompok_nama, kelompok.kelompok_nama as kelompok_nama, golongan_kode, golongan.golongan_nama as golongan_nama, subsubkelompok.subsubkelompok_nama, subsubkelompok.subsubkelompok_kode';
		$criteria->join = 'LEFT JOIN subsubkelompok_m As subsubkelompok ON subsubkelompok.subsubkelompok_id = t.subsubkelompok_id'
				. ' LEFT JOIN subkelompok_m As subkelompok ON subkelompok.subkelompok_id = subsubkelompok.subkelompok_id'
				. ' LEFT JOIN kelompok_m As kelompok ON kelompok.kelompok_id = subkelompok.kelompok_id'
				. ' LEFT JOIN bidang_m As bidang ON bidang.bidang_id = kelompok.bidang_id'
				. ' LEFT JOIN golongan_m As golongan ON golongan.golongan_id = bidang.golongan_id';
		if(!empty($this->barang_id)){
			$criteria->addCondition("t.barang_id = ".$this->barang_id);			
		}
		if(!empty($this->bidang_id)){
			$criteria->addCondition("t.bidang_id = ".$this->bidang_id);			
		}
		$criteria->compare('LOWER(t.barang_type)',strtolower($this->barang_type));
		$criteria->compare('LOWER(t.barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(t.barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(t.barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(t.barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(t.barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(t.barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(t.barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(t.barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(t.barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('LOWER(bidang.bidang_nama)',strtolower($this->bidang_nama),true);
		$criteria->compare('LOWER(subkelompok.subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		$criteria->compare('LOWER(kelompok.kelompok_nama)',strtolower($this->kelompok_nama),true);
		$criteria->compare('LOWER(golongan.golongan_nama)',strtolower($this->golongan_nama),true);
		$criteria->compare('LOWER(golongan.golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('t.barang_statusregister',$this->barang_statusregister);
		$criteria->compare('t.barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('LOWER(t.barang_satuan)',strtolower($this->barang_satuan),true);
		$criteria->compare('t.barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('LOWER(t.barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('t.barang_aktif',isset($this->barang_aktif)?$this->barang_aktif:true);
//		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => [
                            'defaultOrder' => 'barang_nama ASC'
                        ]
//			'pagination'=>false,
		));
	}
        
    public function searchDialogAsetAlat()
{
        $criteria=new CDbCriteria;
        $criteria->select = 't.*, bidang.bidang_nama as bidang_nama, subkelompok.subkelompok_nama as subkelompok_nama, kelompok.kelompok_nama as kelompok_nama, golongan_kode, golongan.golongan_nama as golongan_nama
                            ,subsubkelompok.subsubkelompok_nama,subsubkelompok.subsubkelompok_kode,terimaDet.terimapersdetail_id,terima.terimapersediaan_id,terima.nopenerimaan,terimaDet.jmlterima';
        $criteria->join = 'LEFT JOIN subsubkelompok_m As subsubkelompok ON subsubkelompok.subsubkelompok_id = t.subsubkelompok_id'
                        . ' LEFT JOIN subkelompok_m As subkelompok ON subkelompok.subkelompok_id = subsubkelompok.subkelompok_id'
                        . ' LEFT JOIN kelompok_m As kelompok ON kelompok.kelompok_id = subkelompok.kelompok_id'
                        . ' LEFT JOIN bidang_m As bidang ON bidang.bidang_id = kelompok.bidang_id'
                        . ' LEFT JOIN golongan_m As golongan ON golongan.golongan_id = bidang.golongan_id'
                        . ' JOIN terimapersdetail_t As terimaDet ON terimaDet.barang_id = t.barang_id'
                        . ' JOIN terimapersediaan_t As terima ON terima.terimapersediaan_id = terimaDet.terimapersediaan_id';
        if(!empty($this->barang_id)){
                $criteria->addCondition("t.barang_id = ".$this->barang_id);			
        }
        if(!empty($this->bidang_id)){
                $criteria->addCondition("t.bidang_id = ".$this->bidang_id);			
        }
        $criteria->addCondition("terimaDet.terimapersdetail_id NOT IN (SELECT terimapersdetail_id FROM invperalatan_t WHERE terimapersdetail_id IS NOT NULL)"); //agar detail tidak muncul yg sudah di inventarisasi
        // $criteria->addCondition("t.barang_type = '".Params::TYPE_BARANG_ASET."'");
        $criteria->compare('LOWER(t.barang_type)',strtolower($this->barang_type),true);
        $criteria->compare('LOWER(t.barang_kode)',strtolower($this->barang_kode),true);
        $criteria->compare('LOWER(t.barang_nama)',strtolower($this->barang_nama),true);
        $criteria->compare('LOWER(t.barang_namalainnya)',strtolower($this->barang_namalainnya),true);
        $criteria->compare('LOWER(t.barang_merk)',strtolower($this->barang_merk),true);
        $criteria->compare('LOWER(t.barang_noseri)',strtolower($this->barang_noseri),true);
        $criteria->compare('LOWER(t.barang_ukuran)',strtolower($this->barang_ukuran),true);
        $criteria->compare('LOWER(t.barang_bahan)',strtolower($this->barang_bahan),true);
        $criteria->compare('LOWER(t.barang_thnbeli)',strtolower($this->barang_thnbeli),true);
        $criteria->compare('LOWER(t.barang_warna)',strtolower($this->barang_warna),true);
        $criteria->compare('LOWER(bidang.bidang_nama)',strtolower($this->bidang_nama),true);
        $criteria->compare('LOWER(subkelompok.subkelompok_nama)',strtolower($this->subkelompok_nama),true);
        $criteria->compare('LOWER(kelompok.kelompok_nama)',strtolower($this->kelompok_nama),true);
        $criteria->compare('LOWER(golongan.golongan_nama)',strtolower($this->golongan_nama),true);
        $criteria->compare('LOWER(golongan.golongan_kode)',strtolower($this->golongan_kode),true);
        $criteria->compare('t.barang_statusregister',$this->barang_statusregister);
        $criteria->compare('t.barang_ekonomis_thn',$this->barang_ekonomis_thn);
        $criteria->compare('LOWER(t.barang_satuan)',strtolower($this->barang_satuan),true);
        $criteria->compare('t.barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
        $criteria->compare('LOWER(t.barang_image)',strtolower($this->barang_image),true);
        $criteria->compare('t.barang_aktif',isset($this->barang_aktif)?$this->barang_aktif:true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    /**
     * Untuk load data aset/barang gedung
     * 
     * @author Tantowy <tantowijaya@.com>
     * 
     */
    public function searchDialogAsetGedung() {
        $criteria=new CDbCriteria;
        $criteria->select = 't.*, bidang.bidang_nama as bidang_nama, subkelompok.subkelompok_nama as subkelompok_nama, kelompok.kelompok_nama as kelompok_nama, golongan_kode, golongan.golongan_nama as golongan_nama
                            ,subsubkelompok.subsubkelompok_nama,subsubkelompok.subsubkelompok_kode,terimaDet.terimapersdetail_id,terima.terimapersediaan_id,terima.nopenerimaan,terimaDet.jmlterima';
        $criteria->join = 'LEFT JOIN subsubkelompok_m As subsubkelompok ON subsubkelompok.subsubkelompok_id = t.subsubkelompok_id'
                        . ' LEFT JOIN subkelompok_m As subkelompok ON subkelompok.subkelompok_id = subsubkelompok.subkelompok_id'
                        . ' LEFT JOIN kelompok_m As kelompok ON kelompok.kelompok_id = subkelompok.kelompok_id'
                        . ' LEFT JOIN bidang_m As bidang ON bidang.bidang_id = kelompok.bidang_id'
                        . ' LEFT JOIN golongan_m As golongan ON golongan.golongan_id = bidang.golongan_id'
                        . ' JOIN terimapersdetail_t As terimaDet ON terimaDet.barang_id = t.barang_id'
                        . ' JOIN terimapersediaan_t As terima ON terima.terimapersediaan_id = terimaDet.terimapersediaan_id';
        $criteria->select .= ", terimaDet.hargabeli, terimaDet.terimapersdetail_id";
        $criteria->addCondition("terimapersdetail_id NOT IN (SELECT terimapersdetail_id FROM invgedung_t WHERE terimapersdetail_id IS NOT NULL)"); //agar detail tidak muncul yg sudah di inventarisasi
        if(!empty($this->barang_id)){
                $criteria->addCondition("t.barang_id = ".$this->barang_id);			
        }
        if(!empty($this->bidang_id)){
                $criteria->addCondition("t.bidang_id = ".$this->bidang_id);			
        }
        $criteria->compare('LOWER(golongan.golongan_kode)',strtolower($this->golongan_kode),true);
        $criteria->compare('lower(terima.nopenerimaan)', strtolower($this->nopenerimaan), true);
        $criteria->compare('LOWER(t.barang_nama)',strtolower($this->barang_nama),true);
        $criteria->compare('LOWER(subkelompok.subkelompok_nama)',strtolower($this->subkelompok_nama),true);
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    /**
     * Diambil dari fungsi searchDialogAset dengan beberapa penambahan
     * - Kolom hargabeli dan terimapersdetail_id
     * - Kondisi khusus sesuai dengan kode golongan tertentu.
     * 
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     * 
     * @return CActiveDataProvider data untuk dipakai pada dialog Daftar Aset
     */
    public function searchDialogAset2() {
        $prov = $this->searchDialogAsetAlat();
        $prov->criteria->compare('lower(terima.nopenerimaan)', strtolower($this->nopenerimaan), true);
        $prov->criteria->select .= ", terimaDet.hargabeli, terimaDet.terimapersdetail_id";
        
        if ($this->golongan_kode == ParamsConst::GOLONGAN_KODE_TANAH) {
            $prov->criteria->join .= ' left join invtanah_t tanah on tanah.terimapersdetail_id = terimaDet.terimapersdetail_id';
            $prov->criteria->addCondition('tanah.terimapersdetail_id is null');
            $prov->criteria->addCondition('tanah.invtanah_id is null');
        } else if ($this->golongan_kode == ParamsConst::GOLONGAN_KODE_JALAN_IRIGASI_JARINGAN) {
            $prov->criteria->join .= ' left join invjalan_t jalan on jalan.terimapersdetail_id = terimaDet.terimapersdetail_id';
            $prov->criteria->addCondition('jalan.terimapersdetail_id is null');
            $prov->criteria->addCondition('jalan.invjalan_id is null');
        } else if ($this->golongan_kode == ParamsConst::GOLONGAN_KODE_ASET_TETAP_LAINNYA) {
            $prov->criteria->join .= ' left join invasetlain_t lain on lain.terimapersdetail_id = terimaDet.terimapersdetail_id';
            $prov->criteria->addCondition('lain.terimapersdetail_id is null');
            $prov->criteria->addCondition('lain.invasetlain_id is null');
        }
        return $prov;
    }
    
	public function getBidangItems()
    {
        return BidangM::model()->findAll('bidang_aktif = true ORDER BY bidang_nama');
    }
}
?>
