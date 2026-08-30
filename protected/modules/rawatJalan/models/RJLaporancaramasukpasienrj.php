<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class RJLaporancaramasukpasienrj extends LaporancaramasukpasienrjV {
    public $data;
    public $jumlah;
    public $tick;
    public $is_rujukan;
    public $tgl_awal;
    public $tgl_akhir;
    public $bln_awal;
    public $bln_akhir;
    public $thn_awal;
    public $thn_akhir;
    public $jns_periode;
    

    public static function model($className = __CLASS__) {
        parent::model($className);
    }
    
    public function searchTableCaraMasuk()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        if($this->is_rujukan == 'rujukan')
        {
            if(!empty($this->asalrujukan_id)){
                    if(is_array($this->asalrujukan_id)){
                            $criteria->addInCondition('asalrujukan_id', $this->asalrujukan_id);
                    }else{
                            $criteria->addCondition("asalrujukan_id = ".$this->asalrujukan_id);		
                    }
            }
        }
        if (!empty($this->ruangan_id)){
            $criteria->addCondition('ruangan_id ='.$this->ruangan_id);
        }
        return new CActiveDataProvider($this,
            array(
                'criteria'=>$criteria,
            )
        );
    }
    
    public function searchGrafik()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah, ruangan_nama as data';
        $criteria->group = 'ruangan_nama';
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
         if (!empty($this->ruangan_id)){
            $criteria->addCondition('ruangan_id ='.$this->ruangan_id);
        }

        return new CActiveDataProvider($this,
            array(
                'criteria'=>$criteria,
            )
        );
    }  
    
    public function searchPrint()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

         
            
             $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
            if($this->is_rujukan == 'rujukan')
            {
                if(!empty($this->asalrujukan_id)){
                        if(is_array($this->asalrujukan_id)){
                                $criteria->addInCondition('asalrujukan_id', $this->asalrujukan_id);
                        }else{
                                $criteria->addCondition("asalrujukan_id = ".$this->asalrujukan_id);		
                        }
                }
            }
            if (!empty($this->ruangan_id)){
                $criteria->addCondition('ruangan_id ='.$this->ruangan_id);
            }

            return new CActiveDataProvider($this, array(                   
                    'criteria'=>$criteria,
					'pagination' => false
            ));
    }
}
?>
