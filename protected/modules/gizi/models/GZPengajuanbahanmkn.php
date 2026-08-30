<?php
class GZPengajuanbahanmkn extends PengajuanbahanmknT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->addBetweenCondition('DATE(tglpengajuanbahan)', $this->tgl_awal, $this->tgl_akhir);
                $criteria->addCondition('terimabahanmakan_id is null');
		$criteria->compare('pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(nopengajuan)',strtolower($this->nopengajuan),true);
//		$criteria->compare('LOWER(tglpengajuanbahan)',strtolower($this->tglpengajuanbahan),true);
		$criteria->compare('LOWER(sumberdanabhn)',strtolower($this->sumberdanabhn),true);
		$criteria->compare('LOWER(alamatpengiriman)',strtolower($this->alamatpengiriman),true);
		$criteria->compare('idpegawai_mengetahui',$this->idpegawai_mengetahui);
		$criteria->compare('idpegawai_mengajukan',$this->idpegawai_mengajukan);
		$criteria->compare('LOWER(keterangan_bahan)',strtolower($this->keterangan_bahan),true);
		$criteria->compare('totalharganetto',$this->totalharganetto);
                if (!empty($this->tglmintadikirim)){
                    $criteria->addCondition("tglmintadikirim = '".$this->tglmintadikirim."' ");
                }
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                
                if (!empty($this->sumberdana_id)){
                    $criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);
                }
                
                if (!empty($this->pajak_id)){
                    $criteria->addCondition("pajak_id = ".$this->pajak_id);
                }
                
                if (!empty($this->status_persetujuan)){
                  
                    if ($this->status_persetujuan == '1'){
                        $status = TRUE;
                    }else{
                        $status = FALSE;
                    }
                    $criteria->compare('status_persetujuan',$this->status_persetujuan);
                    
                }
                 $criteria->addCondition("batalpermintaanpembelian_id is null");
                 
                 if(!empty($this->statuspermintaanuangmuka)){
                     if($this->statuspermintaanuangmuka == 1){
                        $criteria->addCondition("jmlpermintaanuangmuka IS NOT NULL"); 
                     }else{
                        $criteria->addCondition("jmlpermintaanuangmuka IS NULL");
                     }
                 }
                 
		$criteria->order='tglpengajuanbahan DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
         * menampilkan nama supplier 
         * @param type $ruangan_id = gizi
         * RSN-316
         */
        public function getSupplier()
        {
            $criteria = new CdbCriteria();
            $criteria->addCondition("supplier_jenis= '".Params::SUPPLIER_JENIS_GIZI."'");
            $criteria->addCondition('supplier_aktif = true');
            $modSupplier = SupplierM::model()->findAll($criteria);
            return $modSupplier;
        }
        
}