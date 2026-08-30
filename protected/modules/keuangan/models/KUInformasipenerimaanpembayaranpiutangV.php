<?php
class KUInformasipenerimaanpembayaranpiutangV extends InformasipenerimaanpembayaranpiutangV
{
    public $tgl_awal,$tgl_akhir,$tglbayar_awal,$tglbayar_akhir, $ceklis, $status_pembayaran, $status_pembatalan;

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }


    public function criteriaSearch()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
             $criteria->select = "tglpembayaran,nopembayaran, tglbuktibayar, nobuktibayar, jnspembayar_nama, namabank, sum(jmlpiutang) as jmlpiutang, sum(jmlbayar) as jmlbayar, sum(biayaadministrasi) as biayaadministrasi, sum(biaya_materai) as biaya_materai, sum(jmlpenerimaan) as jmlpenerimaan, sum(jmlsisapiutang) as jmlsisapiutang, petugaspenyetor, pegawaibatal_id, tandabuktibayar_id, pembpiutangbank_id";
            $criteria->group = "tglpembayaran,nopembayaran, tglbuktibayar, nobuktibayar, jnspembayar_nama, namabank,petugaspenyetor, pegawaibatal_id, tandabuktibayar_id, pembpiutangbank_id";

            $criteria->addBetweenCondition('DATE(tglbuktibayar)', $this->tgl_awal, $this->tgl_akhir);

            if($this->ceklis){
                $criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tglbayar_awal, $this->tglbayar_akhir);
            }

            $criteria->compare('LOWER(nobuktibayar)', strtolower($this->nobuktibayar),true);
            $criteria->compare('LOWER(nopembayaran)', strtolower($this->nopembayaran),true);

           if(!empty($this->status_pembayaran)){
               if($this->status_pembayaran == '1'){
                   $criteria->addCondition('jmlpiutang > jmlbayar');
               }else if($this->status_pembayaran == '2'){
                   $criteria->addCondition('jmlpiutang = jmlbayar');
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

            if(!empty($this->jnspembayar_id)){
                $criteria->addCondition('jnspembayar_id = '.$this->jnspembayar_id);
            }

            if(!empty($this->bank_id)){
                $criteria->addCondition('bank_id = '.$this->bank_id);
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
