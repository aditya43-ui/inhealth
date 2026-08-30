<?php
class KPInfobonusthrpegawaiV extends InfobonusthrpegawaiV
{
    public $tgl_mengetahui, $tgl_mengetahuipt, $tgl_menyetujui, $ruangan_id, $nip;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchInformasi()
    {
        $criteria=new CDbCriteria;
        if(!empty($this->periodebonusthr)){
            $this->periodebonusthr = MyFormatter::formatMonthForDB($this->periodebonusthr);
        }


        $criteria->addCondition("(case when periodebonusthr is null then tglpengajuan else periodebonusthr end)::date between '".
            $this->periodebonusthr."-01' and '".date('Y-m-t', strtotime($this->periodebonusthr.'-01'))."'");
            $criteria->compare('lower(nopengajuan)', strtolower($this->nopengajuan),true);
            $criteria->compare('lower(nama_pegawai)', strtolower($this->nama_pegawai),true);
            $criteria->compare('lower(jenisgaji)', strtolower($this->jenisgaji),false);
            $criteria->compare('lower(statuspegawai)', strtolower($this->statuspegawai),false);

//            if(!empty($this->ruangan_id)){
//               $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
//            }

            if(!empty($this->unitkerja_id)){
               $criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
            }

            if(!empty($this->kelompokpegawai_id)){
               $criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
            }

            if(!empty($this->jabatan_id)){
               $criteria->addCondition('jabatan_id = '.$this->jabatan_id);
            }

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

    public function searchInformasiPrint()
    {
        $criteria=new CDbCriteria;

        $criteria->addCondition("(case when periodebonusthr is null then tglpengajuan else periodebonusthr end)::date between '".
            $this->periodebonusthr."-01' and '".date('Y-m-t', strtotime($this->periodebonusthr.'-01'))."'");
            $criteria->compare('lower(nopengajuan)', strtolower($this->nopengajuan),true);
            $criteria->compare('lower(nama_pegawai)', strtolower($this->nama_pegawai),true);
            $criteria->compare('lower(jenisgaji)', strtolower($this->jenisgaji),false);
            $criteria->compare('lower(statuspegawai)', strtolower($this->statuspegawai),false);

//            if(!empty($this->ruangan_id)){
//               $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
//            }

            if(!empty($this->unitkerja_id)){
               $criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
            }

            if(!empty($this->kelompokpegawai_id)){
               $criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
            }

            if(!empty($this->jabatan_id)){
               $criteria->addCondition('jabatan_id = '.$this->jabatan_id);
            }

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            'pagination'=>false
        ));
    }

    public function getTotal()
		{
            $criteria=new CDbCriteria;
            if ($this->jenis == "THR"){
                $criteria->select = 'sum(t.totalthr) as total';
            }else{
                $criteria->select = 'sum(t.nilaibonus) as total';
            }
            
            $criteria->addCondition("(case when periodebonusthr is null then tglpengajuan else periodebonusthr end)::date between '".
                $this->periodebonusthr."-01' and '".date('Y-m-t', strtotime($this->periodebonusthr.'-01'))."'");
                $criteria->compare('lower(nopengajuan)', strtolower($this->nopengajuan),true);
                $criteria->compare('lower(nama_pegawai)', strtolower($this->nama_pegawai),true);
                $criteria->compare('lower(jenisgaji)', strtolower($this->jenisgaji),false);
                $criteria->compare('lower(statuspegawai)', strtolower($this->statuspegawai),false);
    
    //            if(!empty($this->ruangan_id)){
    //               $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
    //            }
    
                if(!empty($this->unitkerja_id)){
                   $criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
                }
    
                if(!empty($this->kelompokpegawai_id)){
                   $criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
                }
    
                if(!empty($this->jabatan_id)){
                   $criteria->addCondition('jabatan_id = '.$this->jabatan_id);
                }
                $jumlah = InfobonusthrpegawaiV::model()->find($criteria)->total;
			if (empty($jumlah)){
                $jumlah = 0;
            }
            return $jumlah;
    }
}

?>
