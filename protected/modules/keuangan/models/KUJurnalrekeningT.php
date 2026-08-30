<?php

class KUJurnalrekeningT extends JurnalrekeningT
{
    public $rekening_nama;
    public $tgl_awal;
    public $tgl_akhir;
    public $rekDebit;
    public $rekening1_id;
    public $rekening2_id;
    public $rekening3_id;
    public $rekening4_id;
    public $rekening5_id;
    public $jurnaldetail_id;
    public $saldodebit;
    public $saldokredit;
    public $is_posting;
    public $jurnalPosting;
    public $jurnalRekening;
    public $id_temp_rek;
    public $success;
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function searchByFilter()
    {
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->with = 'jenisJurnal';
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchWithJoin()
    {
            $criteria=new CDbCriteria;
//            $criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
            $criteria->compare('LOWER(nobuktijurnal)', strtolower($this->nobuktijurnal), true);
            $criteria->compare('jenisjurnal_id',$this->jenisjurnal_id);
            $criteria->compare('noreferensi',$this->noreferensi);
            $criteria->compare('LOWER(kodejurnal)', strtolower($this->kodejurnal), true);
//            if(isset($this->is_posting))
//            {
//                if($this->is_posting == 0)
//                {
//                    $criteria->addCondition('t.jurnalposting_id IS NOT NULL');
//                }else if($this->is_posting == 1){
//                    $criteria->addCondition('t.jurnalposting_id IS NULL');
//                }
//                
//            }
            $criteria->addBetweenCondition('DATE(tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
            
          //  $criteria->with = array('jurnalPosting', 'jurnalRekening');
            //$criteria->order = 'jurnaldetail_id, nourut';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                'pagination'=>false,
            ));
    }
    
    public function searchWithJurDetail()
    {
        $criteria=new CDbCriteria;
        /*
        $criteria->compare('LOWER(jurnalrekening_t.nobuktijurnal)',strtolower($this->nobuktijurnal),true);
        $criteria->compare('LOWER(jurnalrekening_t.kodejurnal)',strtolower($this->kodejurnal),true);
         * 
         */
        $criteria->addCondition('jurnalposting_id IS NULL');
        $criteria->addBetweenCondition('DATE("jurnalRekening".tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->with = 'jurnalRekening';
        return new CActiveDataProvider("JurnaldetailT", array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));
    }
    
    public function getInfoRekening()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('rincianobyek_id',$this->rincianobyek_id);
        $criteria->compare('obyek_id',$this->obyek_id);
        $criteria->compare('jenis_id',$this->jenis_id);
        $criteria->order = 'struktur_id, kelompok_id, jenis_id, obyek_id, rincianobyek_id, nourutrek';
        $result = JurnalrekeningblmpostingV::model()->find($criteria);
        return $result;
    }
    
    public function cariRekening()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('LOWER(nmrincianobyek)',strtolower($this->nmrincianobyek),true);
        $criteria->compare('LOWER(nmrincianobyeklain)',strtolower($this->nmrincianobyeklain),true);
//        $criteria->addCondition('kdrincianobyek IS NOT NULL');
        $criteria->order = 'struktur_id, kelompok_id, jenis_id, obyek_id, rincianobyek_id, nourutrek';
        return new CActiveDataProvider($this,
            array(
                'criteria'=>$criteria,
            )
        );
    }
    
    public function getKodeRekening()
    {
        if(isset($this->rincianobyek_id))
        {
            $kode_rekening = $this->kdstruktur . "-" . $this->kdkelompok . "-" . $this->kdjenis . "-" . $this->kdobyek . "-" . $this->kdrincianobyek;
        }else{
            if(isset($this->obyek_id))
            {
                $kode_rekening = $this->kdstruktur . "-" . $this->kdkelompok . "-" . $this->kdjenis . "-" . $this->kdobyek;
            }else{
                $kode_rekening = $this->kdstruktur . "-" . $this->kdkelompok . "-" . $this->kdjenis;
            }
        }
        
        return $kode_rekening;
    }
    
    public function getNamaRekening()
    {
        if(isset($this->rincianobyek_id))
        {
            $kode_rekening = $this->nmrincianobyek;
        }else{
            if(isset($this->obyek_id))
            {
                $kode_rekening = $this->nmobyek;
            }else{
                $kode_rekening = $this->nmjenis;
            }
        }
        
        return $kode_rekening;
    }
    
    public function getIdRekening()
    {
        if(isset($this->rincianobyek_id))
        {
            $kode_rekening = $this->rincianobyek_id;
        }else{
            if(isset($this->obyek_id))
            {
                $kode_rekening = $this->obyek_id;
            }else{
                $kode_rekening = $this->jenis_id;
            }
        }
        return $kode_rekening;
    }
    
    protected function afterFind(){
        if(isset($this->rincianobyek_id))
        {
            $this->id_temp_rek = 'rincianobyek_id' . 'x' . $this->rincianobyek_id;
        }else{
            if(isset($this->obyek_id))
            {
                $this->id_temp_rek = 'obyek_id' . 'x' . $this->obyek_id;
            }else{
                $this->id_temp_rek = 'jenis_id' . 'x' . $this->jenis_id;
            }
        }
        return true;
    }
    
}


?>
