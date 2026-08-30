<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan untuk menampilkan data pada tabel Infomutasiaset_v
* RSST-1584
*/

class MAInfomutasiasetV extends InfomutasiasetV
{     
    public $is_pj_aset;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function searchInformasi(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition("DATE(tglmutasiaset)",$this->tgl_awal,$this->tgl_akhir);
               
      
        if (!empty($this->ruanganasal_id)){
            $criteria->addCondition("ruanganasal_id =".$this->ruanganasal_id);
        }
        
        if (!empty($this->ruangantujuan_id)){
            $criteria->addCondition("ruangantujuan_id =".$this->ruangantujuan_id);
        }
        
        if (!empty($this->lokasiasal_id)){
            $criteria->addCondition("lokasiasal_id =".$this->lokasiasal_id);
        }
        
        if (!empty($this->lokasitujuan_id)){
            $criteria->addCondition("lokasitujuan_id =".$this->lokasitujuan_id);
        }
       
        
        if ($this->is_pj_aset){
            $criteria->addCondition(" (t.lokasiasal_id IN (SELECT lokasi_id FROM penanggungjawabaset_m WHERE penanggungjawabaset_aktif = TRUE AND pegawai_id = '".Yii::app()->user->getState('pegawai_id')."' GROUP BY lokasi_id )) OR t.penerima_id = ".Yii::app()->user->getState('pegawai_id'));                        
        }
        
        $criteria->compare("LOWER(nomutasiaset)",strtolower($this->nomutasiaset),true);
        
        $sort = new CSort;
        
        $sort->defaultOrder = "tglmutasiaset DESC";
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>$sort
        ));
			
    }
}
?>