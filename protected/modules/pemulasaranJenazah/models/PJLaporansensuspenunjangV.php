<?php

class PJLaporansensuspenunjangV extends LaporansensuspenunjangV {

    public $tgl_awal,$tgl_akhir;
    public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public $pilihanx;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        
        
        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->kunjungan)){
            if (!is_array($this->kunjungan)){
                $this->kunjungan = 0;
            }else{
                $data = array();
                foreach(  $this->kunjungan as $i => $values ){

                    if( $values == "KUNJUNGAN ULANG"){
                        $data[]="KUNJUNGAN LAMA";
                    } else{
                        $data[]=$values;
                    }
                }                                            
                $criteria->addInCondition('kunjungan', $data);
            }
        }
        $criteria->compare('instalasiasal_id', $this->instalasiasal_id);
        if (!empty($this->instalasiasal_id)){
            if (!is_array($this->ruanganasal_id)){
                $this->ruanganasal_id = 0;
            }
        }
        
        if (!empty($this->carabayar_id)){
            if (is_array($this->carabayar_id)){
                $criteria->addInCondition(" carabayar_id ", $this->carabayar_id);
            }else{
                $criteria->addCondition(" carabayar_id = '".$this->carabayar_id."' ");
            }
        }
        
        if (!empty($this->penjamin_id)){
            if (is_array($this->penjamin_id)){
                $criteria->addInCondition(" penjamin_id ", $this->penjamin_id);
            }else{
                $criteria->addCondition(" penjamin_id = '".$this->penjamin_id."' ");
            }
        }
        
        if (!empty($this->ruanganasal_id)){
            if (is_array($this->ruanganasal_id)){
                $criteria->addInCondition(" ruanganasal_id ", $this->ruanganasal_id);
            }else{
                $criteria->addCondition(" ruanganasal_id = '".$this->ruanganasal_id."' ");
            }
        }
        
        if (!empty($this->instalasiasal_id)){
            if (is_array($this->instalasiasal_id)){
                $criteria->addInCondition(" instalasiasal_id ", $this->instalasiasal_id);
            }else{
                $criteria->addCondition(" instalasiasal_id = '".$this->instalasiasal_id."' ");
            }
        }
        
        
        
        
        $criteria->compare('ruanganpenunj_id', Yii::app()->user->getState('ruangan_id'));

        return $criteria;
    }

    public function searchPrint() {
        $criteria = new CDbCriteria();
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'pagination'=>false, 
                    'criteria' => $criteria,
                ));
    }
    public function searchTable() {
        $criteria = new CDbCriteria();
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    public function searchGrafik() {
        $criteria = new CDbCriteria();
        
        $criteria = $this->functionCriteria();
        
          if ($_GET['tampilGrafik'] == 'kunjungan'){
            $criteria->select = 'count(pendaftaran_id) as jumlah, kunjungan as data';
            $criteria->group = 'kunjungan';
        }elseif ($_GET['tampilGrafik'] == 'carabayar'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';
            $criteria->group = 'carabayar_nama';
        }elseif ($_GET['tampilGrafik'] == 'jenispemeriksaan'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, jenispemeriksaanlab_nama as data';
            $criteria->group = 'jenispemeriksaanlab_nama';
        }elseif ($_GET['tampilGrafik'] == 'instalasiasal'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, instalasiasal_nama as data';
            $criteria->group = 'instalasiasal_nama';
        }elseif ($_GET['tampilGrafik'] == 'ruanganasal'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, ruanganasal_nama as data';
            $criteria->group = 'ruanganasal_nama';
        }
        
        $criteria->order = " jumlah DESC ";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getNamaModel() {
        return __CLASS__;
    }
    
    public static function statusKunjungan() {
        $status = array('baru' => 'KUNJUNGAN BARU',
            'lama' => 'KUNJUNGAN LAMA');
        return $status;
    }

    public static function berdasarkanStatus() {
        $status = array('pengunjung' => 'Berdasarkan Pengunjung',
            'kunjungan' => 'Berdasarkan Kunjungan');
        return $status;
    }

}

?>
