<?php

class GFObatalkesfarmasiV extends ObatalkesfarmasiV
{
    public $tglkadaluarsa_awal;
    public $tglkadaluarsa_akhir;
    public $rakobat_id, $penyimpananobat_id;
	public $init; 
    
    public static function model($className = __CLASS__) 
    {
        return parent::model($className);
    }
    
    public function criteriaDataObat()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('discount',$this->discount);
                                if ($this->tglkadaluarsa == 1){
                                    $criteria->addBetweenCondition('date(tglkadaluarsa)',$this->tglkadaluarsa_awal, $this->tglkadaluarsa_akhir);
                                }
		$criteria->compare('obatalkes_aktif',TRUE);
                
                                return $criteria;
		

    }
    
    public function searchDataObat()
    {
            return new CActiveDataProvider($this, array(
                    'criteria'=>$this->criteriaDataObat(),
                                            'pagination'=>false,
            ));
    }
    
    public function searchGudangFarmasiPrint()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->with = array('sumberdana','satuankecil', 'satuanbesar');
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
			}
			if(!empty($this->lokasigudang_id)){
				$criteria->addCondition('t.lokasigudang_id = '.$this->lokasigudang_id);
			}
            $criteria->compare('LOWER(lokasigudang.lokasigudang_nama)',  strtolower($this->lokasigudangNama));
			if(!empty($this->therapiobat_id)){
				$criteria->addCondition('t.therapiobat_id = '.$this->therapiobat_id);
			}
            $criteria->compare('LOWER(therapiobat.therapiobat_nama)',  strtolower($this->therapiobatNama));
			if(!empty($this->generik_id)){
				$criteria->addCondition('t.generik_id = '.$this->generik_id);
			}
			if(!empty($this->satuanbesar_id)){
				$criteria->addCondition('t.satuanbesar_id = '.$this->satuanbesar_id);
			}
            $criteria->compare('LOWER(satuanbesar.satuanbesar_nama)',  strtolower($this->satuanbesarNama));
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition('sumberdana.sumberdana_id = '.$this->sumberdana_id);
			}
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
			}
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
            $criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
            $criteria->compare('LOWER(noregister)',strtolower($this->noregister),true);
            $criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
            $criteria->compare('kemasanbesar',$this->kemasanbesar);
            $criteria->compare('kekuatan',$this->kekuatan);
            $criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);

            $criteria->compare('harganetto',$this->harganetto);
            $criteria->compare('hargajual',$this->hargajual);
            $criteria->compare('discount',$this->discount);
            $criteria->compare('marginresep',$this->marginresep);
            $criteria->compare('jasadokter',$this->jasadokter);
            $criteria->compare('hjaresep',$this->hjaresep);
            $criteria->compare('marginnonresep',$this->marginnonresep);
            $criteria->compare('hjanonresep',$this->hjanonresep);
            $criteria->compare('hpp',$this->hpp);

            $criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
            $criteria->compare('minimalstok',$this->minimalstok);
            $criteria->compare('LOWER(formularium)',strtolower($this->formularium),true);
            $criteria->compare('discountinue',$this->discountinue);
            $criteria->compare('obatalkes_aktif',isset($this->obatalkes_aktif)?$this->obatalkes_aktif:true);
            $criteria->compare('LOWER(satuankecil.satuankecil_nama)',strtolower($this->satuankecilNama),true);
            $criteria->compare('LOWER(sumberdana.sumberdana_nama)',strtolower($this->sumberdanaNama),true);
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
	/**
	 * untuk formulir stock opname
	 * @return \CActiveDataProvider
	 */
	public function searchObatFormulirStokOpname()
	{
		$criteria=new CDbCriteria;
		// $criteria->limit = 1000; //RTN-1095
		if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
			$criteria->limit = 0;
		}
		if(is_array($this->obatalkes_id)){ //jika menampilkan banyak obatalkes_id
			$pilihObat = array();
			$i = 0;
			foreach($this->obatalkes_id as $idObat){
				$pilihObat[$i] = "t.obatalkes_id = '".$idObat."' "; //multiple conditions
				$i++;
			}
			$criteria->condition = implode(' OR ',$pilihObat);
			$criteria->limit = -1;
		}else{
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
			}
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
			$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
			$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
			$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
			$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
			$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		}

		$criteria->select = "t.*, ro.rakobat_id, p.penyimpananobat_id";
		
		if ($this->init == false) {
			$criteria->addCondition("t.obatalkes_id is null");
		}
		
		$criteria->join = "left join penyimpananobat_m p on t.obatalkes_id = p.obatalkes_id and p.ruangan_id = ".Yii::app()->user->getState('ruangan_id')." 
						   left join rakobat_m ro on p.rakobat_id = ro.rakobat_id ";
		if(!empty($this->rakobat_id)){
			$criteria->addCondition('ro.rakobat_id = '.$this->rakobat_id);
		}

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>100,
				),
		));
	}
	/**
	 * menampilkan stok ruangan
	 * @return type
	 */
	public function getStokObatRuangan(){ // menampilkan stok obat per ruangan login
		return StokobatalkesT::getJumlahStok($this->obatalkes_id,Yii::app()->user->getState('ruangan_id'));
	}
	
	//==  untuk form stok obatalkes
	public function getHargajual_avg(){
		return $this->hargaaverage;
	}
	public function getHarganettoapotek_avg(){
		return $this->harganetto;
	}
	public function getQtystok(){
		return $this->getStokObatRuangan();
	}
	//==  end untuk form stok obatalkes
        
	public static function getTglKadaluarsa($obatalkes_id) {
		$criteria = new CDbCriteria();
		$criteria->addCondition('obatalkes_id = '.$obatalkes_id);
		$criteria->order = "tglkadaluarsa DESC";
		$modStok = StokobatalkesT::model()->find($criteria);

		return date("d-m-Y", strtotime($modStok->tglkadaluarsa)); 
	}

}

?>
