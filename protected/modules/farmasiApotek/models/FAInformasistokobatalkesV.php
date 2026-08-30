<?php
class FAInformasistokobatalkesV extends InformasistokobatalkesV
{
    public $lookup_name, $minimalstok, $data, $jumlah, $tgl_awal, $tgl_akhir;
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function searchMinimal() {
        return new CActiveDataProvider($this, array(
            'criteria' => $this->criteriaMinimal(),
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => 'obatalkes_nama asc',
            )
        ));
    }

    public function searchMinimalPrint() {
        $criteria = $this->criteriaMinimal();
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array(
                'defaultOrder' => 'obatalkes_nama asc',
            )
        ));
    }    
        
    public function CriteriaMinimal() {
        $criteria = new CDbCriteria;
        $criteria->select = 't.obatalkes_id, t.obatalkes_golongan, t.obatalkes_kategori, t.jenisobatalkes_id, t.jenisobatalkes_nama, t.obatalkes_kode,  
                l.lookup_name, t.obatalkes_nama, t.qtystok, oa.minimalstok';
        $criteria->group = 't.obatalkes_id, t.obatalkes_golongan, t.obatalkes_kategori, t.jenisobatalkes_id, t.jenisobatalkes_nama, t.obatalkes_kode,  
                l.lookup_name, t.obatalkes_nama, t.qtystok, oa.minimalstok';

        $criteria->join = " JOIN obatalkes_m oa ON t.obatalkes_id = oa.obatalkes_id "
                . " LEFT JOIN lookup_m l ON oa.jnskelompok = l.lookup_value";

        if (!empty($this->jenisobatalkes_id)) {
            $criteria->addInCondition("t.jenisobatalkes_id", $this->jenisobatalkes_id);
        }

        if (!empty($this->obatalkes_kategori)) {
            if (is_array($this->obatalkes_kategori)) {
                $criteria->addInCondition("t.obatalkes_kategori", $this->obatalkes_kategori);
            } else {
                $criteria->addCondition("t.obatalkes_kategori = " . $this->obatalkes_kategori);
            }
        }

        if (!empty($this->obatalkes_golongan)) {
            if (is_array($this->obatalkes_golongan)) {
                $criteria->addInCondition("t.obatalkes_golongan", $this->obatalkes_golongan);
            } else {
                $criteria->addCondition("t.obatalkes_golongan = " . $this->obatalkes_golongan);
            }
        }

        $criteria->addCondition('t.ruangan_id = ' . Yii::app()->user->ruangan_id);
        $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(t.obatalkes_kode)', strtolower($this->obatalkes_kode), true);

        if (!empty($this->lookup_name)) {
            $criteria->AddInCondition('l.lookup_value', $this->lookup_name);
        }
        $criteria->addCondition('t.qtystok <= oa.minimalstok');
        return $criteria;
    }
    
    public function searchGrafik()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.
            
		$criteria=new CDbCriteria;
		$criteria->select = 'count(obatalkes_kode) as jumlah, obatalkes_nama as data';
		$criteria->group = 'obatalkes_nama,obatalkes_kode';
		$criteria->addBetweenCondition('date(tglstok_in)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addInCondition("jenisobatalkes_id", $this->jenisobatalkes_id);						
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);						
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
		$criteria->compare('qtystok_current',$this->qtystok_current);
		$criteria->compare('LOWER(ruangan_id)',strtolower($this->ruangan_id),true);
		$criteria->addBetweenCondition('DATE(tglstok_in)',$this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 
                return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
        ));
        }
        
        public function searchGrafikMinimalStock(){
        
            $criteria = $this->CriteriaMinimal();

            $criteria2 = $criteria;
            $criteria2->select = 'count(t.obatalkes_id) as jumlah, t.obatalkes_nama as data'; 
            $criteria2->group = 't.obatalkes_nama';


            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria2,
            ));

        }
        
        public function searchGrafikStock(){
        
            $criteria = $this->CriteriaMinimal();

            $criteria2 = $criteria;
            $criteria2->select = 'count(t.obatalkes_id) as jumlah, t.obatalkes_nama as data'; 
            $criteria2->group = 't.obatalkes_nama';


            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria2,
            ));

        }
}