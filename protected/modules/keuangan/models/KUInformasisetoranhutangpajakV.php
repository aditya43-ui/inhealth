<?php
class KUInformasisetoranhutangpajakV extends InformasisetoranhutangpajakV
{
    public $tgl_awal,$tgl_akhir,$tglnyetor_awal,$tglnyetor_akhir, $ceklis, $status_penyetoran, $status_pembatalan;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasifakturpembelianV the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    
    public function criteriaSearch()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->select = "tandabuktikeluar_id,tglkaskeluar, nokaskeluar, tglsetoranpajak, no_setorpajakpembelian, sum(totalhutang) as totalhutang, sum(jmlpembayaran) as jmlpembayaran, sum(totalsisahutang) as totalsisahutang, biaya_materai, jmlkaskeluar, petugaspenyetor, batalpegawai_id";
            $criteria->group = "tandabuktikeluar_id,tglkaskeluar, nokaskeluar, tglsetoranpajak, no_setorpajakpembelian, biaya_materai, jmlkaskeluar, petugaspenyetor, batalpegawai_id";

            $criteria->addBetweenCondition('DATE(tglkaskeluar)', $this->tgl_awal, $this->tgl_akhir);

            if($this->ceklis){
                $criteria->addBetweenCondition('DATE(tglsetoranpajak)', $this->tglnyetor_awal, $this->tglnyetor_akhir);
            }

            $criteria->compare('LOWER(nokaskeluar)', strtolower($this->nokaskeluar),true);
            $criteria->compare('LOWER(no_setorpajakpembelian)', strtolower($this->no_setorpajakpembelian),true);

           if(!empty($this->status_penyetoran)){
               if($this->status_penyetoran == '1'){
                   $criteria->addCondition('totalhutang > jmlpembayaran');
               }else if($this->status_penyetoran == '2'){
                   $criteria->addCondition('totalhutang = jmlpembayaran');
               }
            }

            if(!empty($this->status_pembatalan)){
               if($this->status_pembatalan == '1'){
                   $criteria->addCondition('batalpegawai_id IS NULL');
               }else if($this->status_pembatalan == '2'){
                   $criteria->addCondition('batalpegawai_id IS NOT NULL');
               }
            }

            if(!empty($this->petugaspenyetor_id)){
                $criteria->addCondition('petugaspenyetor_id = '.$this->petugaspenyetor_id);
            }
            $criteria->compare('LOWER(jenissetoran)', strtolower($this->jenissetoran),false);

            return $criteria;
    }
    
    public function searchInformasi()
    {

        $criteria=new CDbCriteria;
        $criteria->select = "tandabuktikeluar_id,tglkaskeluar, nokaskeluar, tglsetoranpajak, no_setorpajakpembelian, sum(totalhutang) as totalhutang, sum(jmlpembayaran) as jmlpembayaran, sum(totalsisahutang) as totalsisahutang, biaya_materai, jmlkaskeluar, petugaspenyetor, batalpegawai_id";
        $criteria->group = "tandabuktikeluar_id,tglkaskeluar, nokaskeluar, tglsetoranpajak, no_setorpajakpembelian, biaya_materai, jmlkaskeluar, petugaspenyetor, batalpegawai_id";

        $criteria->addBetweenCondition('DATE(tglkaskeluar)', $this->tgl_awal, $this->tgl_akhir);
        
        if($this->ceklis){
            $criteria->addBetweenCondition('DATE(tglsetoranpajak)', $this->tglnyetor_awal, $this->tglnyetor_akhir);
        }
        
        $criteria->compare('LOWER(nokaskeluar)', strtolower($this->nokaskeluar),true);
        $criteria->compare('LOWER(no_setorpajakpembelian)', strtolower($this->no_setorpajakpembelian),true);
        
       if(!empty($this->status_penyetoran)){
           if($this->status_penyetoran == '1'){
               $criteria->addCondition('totalhutang > jmlpembayaran');
           }else if($this->status_penyetoran == '2'){
               $criteria->addCondition('totalhutang = jmlpembayaran');
           }
        }
        
        if(!empty($this->status_pembatalan)){
           if($this->status_pembatalan == '1'){
               $criteria->addCondition('batalpegawai_id IS NULL');
           }else if($this->status_pembatalan == '2'){
               $criteria->addCondition('batalpegawai_id IS NOT NULL');
           }
        }

        if(!empty($this->petugaspenyetor_id)){
            $criteria->addCondition('petugaspenyetor_id = '.$this->petugaspenyetor_id);
        }
        $criteria->compare('LOWER(jenissetoran)', strtolower($this->jenissetoran),false);
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchInformasiPengeluaranKas()
    {

        $criteria=$this->criteriaSearch();
        $criteria->select = "tandabuktikeluar_id,tglkaskeluar, nokaskeluar, tglsetoranpajak, no_setorpajakpembelian, sum(totalhutang) as totalhutang, sum(jmlpembayaran) as jmlpembayaran, sum(totalsisahutang) as totalsisahutang, biaya_materai, jmlkaskeluar, petugaspenyetor, batalpegawai_id, pajak_nama";
        $criteria->group = "tandabuktikeluar_id,tglkaskeluar, nokaskeluar, tglsetoranpajak, no_setorpajakpembelian, biaya_materai, jmlkaskeluar, petugaspenyetor, batalpegawai_id, pajak_nama";
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}