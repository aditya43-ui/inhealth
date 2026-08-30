<?php
class KUInformasipembayaransupplierkolektifV extends InformasipembayaransupplierkolektifV
{
    public $tgl_awal,$tgl_akhir,$tglnyetor_awal,$tglnyetor_akhir, $ceklis, $status_penyetoran, $status_pembatalan;

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchInformasi()
    {

        $criteria=new CDbCriteria;
        $criteria->select = "tandabuktikeluar_id,tglkaskeluar, nokaskeluar, tglbayarkesupplier, no_setorpajakpembelian, sum(jmldibayarkan) as jmldibayarkan, sum(totaltagihan) as totaltagihan, sum(totalsisatagihan) as totalsisatagihan, biayaadministrasi, biayaongkos_kirim, jmlkaskeluar, petugaspenyetor, supplier_nama, supplier_jenis";
        $criteria->group = "tandabuktikeluar_id,tglkaskeluar, nokaskeluar, tglbayarkesupplier, no_setorpajakpembelian, biayaadministrasi, biayaongkos_kirim, jmlkaskeluar, petugaspenyetor, supplier_nama, supplier_jenis";

        $criteria->addBetweenCondition('DATE(tglkaskeluar)', $this->tgl_awal, $this->tgl_akhir);

        if($this->ceklis){
            $criteria->addBetweenCondition('DATE(tglbayarkesupplier)', $this->tglnyetor_awal, $this->tglnyetor_akhir);
        }

        $criteria->compare('LOWER(nokaskeluar)', strtolower($this->nokaskeluar),true);
        $criteria->compare('LOWER(supplier_nama)', strtolower($this->supplier_nama),false);
        $criteria->compare('LOWER(supplier_jenis)', strtolower($this->supplier_jenis),false);
        $criteria->compare('LOWER(no_setorpajakpembelian)', strtolower($this->no_setorpajakpembelian),true);
       //
       //  if(!empty($this->pajak_id)){
       //      $criteria->addCondition('pajak_id = '.$this->pajak_id);
       //  }
       //
       if(!empty($this->status_penyetoran)){
           if($this->status_penyetoran == '1'){
               $criteria->addCondition('totalsisatagihan > 0');
           }else if($this->status_penyetoran == '2'){
               $criteria->addCondition('totalsisatagihan = 0');
           }
        }
       //
       //  if(!empty($this->status_pembatalan)){
       //     if($this->status_pembatalan == '1'){
       //         $criteria->addCondition('batalpegawai_id IS NULL');
       //     }else if($this->status_pembatalan == '2'){
       //         $criteria->addCondition('batalpegawai_id IS NOT NULL');
       //     }
       //  }
       //
        if(!empty($this->petugaspenyetor_id)){
            $criteria->addCondition('petugaspenyetor_id = '.$this->petugaspenyetor_id);
        }

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}
