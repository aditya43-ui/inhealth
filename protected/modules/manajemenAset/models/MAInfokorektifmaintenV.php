<?php

class MAInfokorektifmaintenV extends InfokorektifmaintenV
{
    public $tgl_awal,$tgl_akhir;
    public $is_pj_asset, $teknisipemeliharaanaset_id, $teknisipemeliharaanaset_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokorektifmaintenV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi() {
            $criteria=$this->criteriaSearch();
            $criteria->addBetweenCondition('DATE(korektifmainten_tgl)', $this->tgl_awal, $this->tgl_akhir);        
            if ($this->is_pj_asset){                
                $criteria->addCondition(" pegpemohon_id = ".$this->pegpemohon_id." OR lokasi_id IN (SELECT lokasi_id FROM penanggungjawabaset_m WHERE pegawai_id = ".Yii::app()->user->getState('pegawai_id')." AND penanggungjawabaset_aktif = TRUE GROUP BY lokasi_id) ");
            }
            
            if ($this->teknisipemeliharaanaset_id){
                $criteria->addCondition(" korektifmainten_id IN (select tek.korektifmainten_id from teknisipemeliharaanaset_t tek JOIN korektifmainten_t kor ON kor.korektifmainten_id = tek.korektifmainten_id WHERE tek.pegawai_id = ".$this->teknisipemeliharaanaset_id." GROUP BY tek.korektifmainten_id) ");
            }
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
            
        }

}