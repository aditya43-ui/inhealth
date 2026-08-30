<?php

class RMLaporansensuspenunjangV extends LaporansensuspenunjangV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!is_array($this->kunjungan)){
            $this->kunjungan = 0;
        }
        
        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('kunjungan', $this->kunjungan);
		if (!empty($this->instalasiasal_id)){
			$criteria->addCondition('instalasiasal_id ='.$this->instalasiasal_id);
		}
        if (!empty($this->instalasiasal_id)){
            if (!is_array($this->ruanganasal_id)){
                $this->ruanganasal_id = 0;
            }
        }
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
		if (!empty($this->ruanganasal_id)){
			$criteria->addCondition('ruanganasal_id ='.$this->ruanganasal_id);
		}
		$ruangan_id = Yii::app()->user->getState('ruangan_id');
		if (!empty($ruangan_id)){
			$criteria->addCondition('ruanganpenunj_id ='.$ruangan_id);
		}

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
        
        $criteria->select = 'count(tglmasukpenunjang) as jumlah, kunjungan as data';
        $criteria->group = 'kunjungan';
        if ($this->pilihan == 'carabayar'){
            if (!empty($this->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as tick';
                $criteria->group .= ', penjamin_nama';
            } else if (!empty($this->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as tick';
                $criteria->group .= ', penjamin_nama';
            } else {
                $criteria->select .= ', carabayar_nama as tick';
                $criteria->group .= ', carabayar_nama';
            }
        }
        else{
            if (is_array($this->ruanganasal_id)){
                $criteria->select .= ', ruanganasal_nama as tick';
                $criteria->group .= ', ruanganasal_nama';
            }
            else if (!empty($this->instalasiasal_id)){
                $criteria->select .= ', ruanganasal_nama as tick';
                $criteria->group .= ', ruanganasal_nama';
            }
            else {
                $criteria->select .= ', instalasiasal_nama as tick';
                $criteria->group .= ', instalasiasal_nama';
            }
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getNamaModel() {
        return __CLASS__;
    }

}

?>
