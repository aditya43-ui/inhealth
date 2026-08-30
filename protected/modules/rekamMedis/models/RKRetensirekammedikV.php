<?php
/**
 * model ini digunakan untuk mengakses view Retensirekammedik_v
 * 
 * @package application.modules.rekamMedis
 * @subpackage models  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 */
class RKRetensirekammedikV extends RetensirekammedikV
{     
    /**
     * action ini untuk mengenerate fungsi AActiveProvider Yii, 
     * @param type $className
     * @return type
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }    
    
    /**
     * load data berkas dokumen rekam medis, sesuai filternya
     * @return \CActiveDataProvider
     */
    public function searchBerkasRekamMedis()
    {		
            $criteria=new CDbCriteria;
            $criteria->join = "  LEFT JOIN inaktifrekammedisdet_t inaktif ON inaktif.dokrekammedis_id = t.dokrekammedis_id AND t.pasien_id = inaktif.pasien_id  ";

            $criteria->addBetweenCondition(" DATE(t.tgl_pendaftaran) ", $this->tgl_awal, $this->tgl_akhir);
            
            $criteria->compare("LOWER(t.nama_pasien)", strtolower($this->nama_pasien),true);
            
            if (empty($this->no_rekam_medik) && !empty($this->no_rekam_medik_akhir)){
                $criteria->addCondition(" CAST(t.no_rekam_medik as integer) = ".$this->no_rekam_medik_akhir."  ");
            }elseif (!empty($this->no_rekam_medik) && empty($this->no_rekam_medik_akhir)){
                $criteria->addCondition(" CAST(t.no_rekam_medik as integer) = ".$this->no_rekam_medik."  ");
            }elseif (!empty($this->no_rekam_medik) && !empty($this->no_rekam_medik_akhir)){
                $criteria->addCondition(" CAST(t.no_rekam_medik as integer) BETWEEN ".$this->no_rekam_medik." AND ".$this->no_rekam_medik_akhir."  ");
            }
            
            if (!empty($this->daftarinstalasiakhir_id)){
                if (is_array($this->daftarinstalasiakhir_id)){
                    $criteria->addInCondition("t.daftarinstalasiakhir_id", $this->daftarinstalasiakhir_id);
                }else{
                    $criteria->addCondition("t.daftarinstalasiakhir_id = ".$this->daftarinstalasiakhir_id );
                }
            }
            
            if (!empty($this->daftarruanganakhir_id)){
                if (is_array($this->daftarruanganakhir_id)){
                    $criteria->addInCondition("t.daftarruanganakhir_id", $this->daftarruanganakhir_id);
                }else{
                    $criteria->addCondition("t.daftarruanganakhir_id = ".$this->daftarruanganakhir_id );
                }
            }
            
            if (!empty($this->statusrekammedis)){
                if (is_array($this->statusrekammedis)){
                    $criteria->addInCondition("t.statusrekammedis", $this->statusrekammedis);
                }else{
                    $criteria->addCondition("t.statusrekammedis = ".$this->statusrekammedis );
                }
            }
            $criteria->addCondition(" inaktif.dokrekammedis_id IS NULL  ");
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination' => false
            ));
    }
}

