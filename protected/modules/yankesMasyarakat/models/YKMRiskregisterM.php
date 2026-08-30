<?php
/**
 * Model untuk tabel riskregister_m hanya untuk model pelayanan kesehatan masyarakat
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 */
class YKMRiskregisterM extends RiskregisterM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RiskregisterM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
     * Pencarian untuk Informasi Risk Register Pelayanan Kesehatan Masyarakat
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchInformasi(){
        $criteria=new CDbCriteria;
        if (!empty($this->tgl_awal) || !empty($this->tgl_akhir)) {
            $criteria->addBetweenCondition("t.riskregister_tanggalmulai", $this->tgl_awal, $this->tgl_akhir);
        }
        if (!empty($this->tgl_awal2) || !empty($this->tgl_akhir2)) {
            $criteria->addBetweenCondition("t.riskregister_tanggaltinjauan", $this->tgl_awal2, $this->tgl_akhir2);
        }
        if(!empty($this->tiperesiko_id)){
            $criteria->addCondition('tiperesiko_id ='.$this->tiperesiko_id);
        }
        $criteria->compare('lower(sumber_riskregister)',strtolower($this->sumber_riskregister),true);
        $criteria->compare('lower(status_riskregister)',strtolower($this->status_riskregister),true);
        $criteria->compare('lower(penanggungjawab)',strtolower($this->penanggungjawab),true);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    /**
     * Pencarian Print Informasi Risk Register Pelayanan Kesehatan Masyarakat
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria();
        if (!empty($this->tgl_awal) || !empty($this->tgl_akhir)) {
            $criteria->addBetweenCondition("t.riskregister_tanggalmulai", $this->tgl_awal, $this->tgl_akhir);
        }
        if (!empty($this->tgl_awal2) || !empty($this->tgl_akhir2)) {
            $criteria->addBetweenCondition("t.riskregister_tanggaltinjauan", $this->tgl_awal2, $this->tgl_akhir2);
        }
        if(!empty($this->tiperesiko_id)){
            $criteria->addCondition('tiperesiko_id ='.$this->tiperesiko_id);
        }
        $criteria->compare('lower(sumber_riskregister)',strtolower($this->sumber_riskregister),true);
        $criteria->compare('lower(status_riskregister)',strtolower($this->status_riskregister),true);
        $criteria->compare('lower(penanggungjawab)',strtolower($this->penanggungjawab),true);

        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit=-1;
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));
    }  
}