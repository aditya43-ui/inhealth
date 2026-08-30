<?php
class GFLaporanfarmasikopnameV extends LaporanfarmasikopnameV
{   
    public $tgl_awal, $tgl_akhir;
    public $tick;
    public $data;
    public $jumlah;
    public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchTable()
    {
            $criteria=new CDbCriteria;

            //$criteria->addBetweenCondition('tglstokopname',$this->tgl_awal,$this->tgl_akhir);
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
            $criteria->addCondition('ruangan_id = 20');
          
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    public function searchTableGF()
    {
            $criteria=new CDbCriteria;

            $criteria->select = 'obatalkes_nama, jenisobatalkes_nama, obatalkes_golongan, obatalkes_kode, jenisobatalkes_nama, sumberdana_nama, harganetto, kemasanbesar, SUM(volume_fisik) as volume_fisik, tglkadaluarsa, kondisibarang';
            $criteria->group = 'obatalkes_nama,jenisobatalkes_nama, obatalkes_golongan, obatalkes_kode, jenisobatalkes_nama, sumberdana_nama, harganetto, kemasanbesar, tglkadaluarsa, kondisibarang';
            $criteria->addBetweenCondition('tglstokopname',$this->tgl_awal,$this->tgl_akhir);
//			if(!empty($this->jenisobatalkes_id)){
//				$criteria->addInCondition('jenisobatalkes_id', $this->jenisobatalkes_id);
//			}
                        if(!empty($this->jenisobatalkes_id)){
			if (is_array($this->jenisobatalkes_id)){
				$criteria->addInCondition('jenisobatalkes_id',$this->jenisobatalkes_id);
			}else{
				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
		        }
            $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'obatalkes_kode';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
        
        
    public function searchPrint()
    {
        $criteria=new CDbCriteria;
        
        //$criteria->addBetweenCondition('tglstokopname',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
        $criteria->addCondition('ruangan_id = 20');

        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
    
    public function searchPrintGF()
    {
        $criteria=new CDbCriteria;

        $criteria->select = 'obatalkes_nama, jenisobatalkes_nama, obatalkes_golongan, obatalkes_kode, jenisobatalkes_nama, sumberdana_nama, harganetto, kemasanbesar, SUM(volume_fisik) as volume_fisik, tglkadaluarsa, kondisibarang';
            $criteria->group = 'obatalkes_nama,jenisobatalkes_nama, obatalkes_golongan, obatalkes_kode, jenisobatalkes_nama, sumberdana_nama, harganetto, kemasanbesar, tglkadaluarsa, kondisibarang';
            $criteria->addBetweenCondition('tglstokopname',$this->tgl_awal,$this->tgl_akhir);
		    if(!empty($this->jenisobatalkes_id)){
			if (is_array($this->jenisobatalkes_id)){
				$criteria->addInCondition('jenisobatalkes_id',$this->jenisobatalkes_id);
			}else{
				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
		    }
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
         $criteria->order = 'obatalkes_kode';
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
//        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }

    public function searchGrafik()
    {
		$criteria=new CDbCriteria;
			$criteria->select = 'sum(volume_fisik) as jumlah, obatalkes_nama as data';
			$criteria->group = 'obatalkes_nama';
			//$criteria->addBetweenCondition('tglstokopname', $this->tgl_awal, $this->tgl_akhir);

		$criteria->addBetweenCondition('tglstokopname',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addInCondition('jenisobatalkes_id', $this->jenisobatalkes_id);
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }

}