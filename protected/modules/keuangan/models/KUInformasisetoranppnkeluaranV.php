<?php
class KUInformasisetoranppnkeluaranV extends InformasisetoranppnkeluaranV
{
    public $tgl_awal,$tgl_akhir,$tglnyetor_awal,$tglnyetor_akhir, $ceklis, $status_penyetoran, $status_pembatalan;

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }


    public function criteriaSearch()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
             $criteria->select = "tandabuktikeluar_id, pajak_nama,tglkaskeluar, nokaskeluar, tglsetoranpajak, no_setorpajakpembelian, sum(totalhutang) as totalhutang, sum(jmlpembayaran) as jmlpembayaran, sum(totalsisahutang) as totalsisahutang, biaya_materai, jmlkaskeluar, petugaspenyetor, batalpegawai_id";
             $criteria->group = "tandabuktikeluar_id,pajak_nama,tglkaskeluar, nokaskeluar, tglsetoranpajak, no_setorpajakpembelian, biaya_materai, jmlkaskeluar, petugaspenyetor, batalpegawai_id";

            $criteria->addBetweenCondition('DATE(tglkaskeluar)', $this->tgl_awal, $this->tgl_akhir);

            if($this->ceklis){
                $criteria->addBetweenCondition('DATE(tglsetoranpajak)', $this->tglbayar_awal, $this->tglbayar_akhir);
            }
           //
            $criteria->compare('LOWER(nokaskeluar)', strtolower($this->nokaskeluar),true);
            $criteria->compare('LOWER(no_setorpajakpembelian)', strtolower($this->no_setorpajakpembelian),true);
           //
           if(!empty($this->status_penyetoran)){
               if($this->status_penyetoran == '1'){
                   $criteria->addCondition('totalhutang > jmlpembayaran');
               }else if($this->status_penyetoran == '2'){
                   $criteria->addCondition('totalhutang = jmlpembayaran');
               }
            }

            if(!empty($this->status_pembatalan)){
               if($this->status_pembatalan == '1'){
                   $criteria->addCondition('pegawaibatal_id IS NULL');
               }else if($this->status_pembatalan == '2'){
                   $criteria->addCondition('pegawaibatal_id IS NOT NULL');
               }
            }

            if(!empty($this->pegawai_id)){
                $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
            }

            if(!empty($this->pajak_id)){
                $criteria->addCondition('pajak_id = '.$this->pajak_id);
            }
            return $criteria;
    }

    public function searchInformasi()
    {

        $criteria = $this->criteriaSearch();

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

}
