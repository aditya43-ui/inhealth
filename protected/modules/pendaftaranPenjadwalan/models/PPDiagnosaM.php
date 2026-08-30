<?php
/**
 * model untuk mengakses tabel diagnosa_m, hanya untuk modul pendaftaran penjadwalan
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 */
class PPDiagnosaM extends DiagnosaM
{
    /**
     * digunakan untuk mengenerate fungsi cActiveRecord dari Yii
     * @param type $className
     * @return type
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * pencarian keluhan penyakit
     * @return \CActiveDataProvider
     */
    public function searchKeluhanPenyakit()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->diagnosa_id)){
				$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id); 			
			}
            $criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
            $criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
            $criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
            $criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
//            $criteria->with=array('dtdDiagnosa');
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
//                         'pagination'=>10,
            ));
    }
    
    /**
     * pencarian imunisasi
     * @return \CActiveDataProvider
     */
    public function searchImunisasi()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->diagnosa_id)){
				$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id); 			
			}
            $criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
            $criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
            $criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
            $criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
            $criteria->condition = "diagnosa_imunisasi = true";
//            $criteria->with=array('dtdDiagnosa');

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
//                         'pagination'=>10,
            ));
    }
    
    /**
     * pencarian diagnosa, ditampilkan dalam  dialog box
     * @return \CActiveDataProvider
     */
    public function searchDialog()
    {
        $criteria=new CDbCriteria;
        // var_dump($this->diagnosa_namalainnya);die();
        $criteria->compare('diagnosa_id', $this->diagnosa_id);
        $criteria->compare('klasifikasidiagnosa_id', $this->klasifikasidiagnosa_id);
        $criteria->compare('LOWER(diagnosa_kode)', strtolower($this->diagnosa_kode), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->compare('LOWER(diagnosa_namalainnya)', strtolower($this->diagnosa_namalainnya), true);
        $criteria->compare('LOWER(diagnosa_katakunci)', strtolower($this->diagnosa_katakunci), true);
        $criteria->compare('diagnosa_nourut', $this->diagnosa_nourut);
        $criteria->compare('diagnosa_imunisasi', isset($this->diagnosa_imunisasi)?$this->diagnosa_imunisasi:false);
        $criteria->compare('diagnosa_aktif', isset($this->diagnosa_aktif)?$this->diagnosa_aktif:true);
        if (!empty($this->dtd_id)) {
            $criteria->addCondition("dtd_id = ".$this->dtd_id);
        }
        
        return new CActiveDataProvider(
            $this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'diagnosa_kode',
                )
            )
        );
    }
}

?>