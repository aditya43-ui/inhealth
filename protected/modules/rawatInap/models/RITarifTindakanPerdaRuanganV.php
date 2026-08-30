<?php
class RITarifTindakanPerdaRuanganV  extends TariftindakanperdaruanganV
{
    public $jenisdiet_nama, $jml_porsi, $jenisdiet_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchInformasi()
	{
		$criteria=new CDbCriteria;
		
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		
		if(!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id = '.$this->kategoritindakan_id);
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
                
                 if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition('kelompoktindakan_id = '.$this->kelompoktindakan_id);
		}
                if(!empty($this->komponenunit_id)){
			$criteria->addCondition('komponenunit_id = '.$this->komponenunit_id);
		}
                
                $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_nama),true);
		$criteria->limit = 10;
		$criteria->order = "jenistarif_nama ASC, kelompoktindakan_nama ASC, komponenunit_nama ASC, kategoritindakan_nama ASC, kelaspelayanan_nama ASC, daftartindakan_nama ASC";
		return new CActiveDataProvider($this, array(
		'criteria'=>$criteria,
		));
	}
        
         public function searchTarifPrint() {
            $provider = $this->searchInformasi();
            $provider->criteria->limit = -1;
            //$provider->criteria->order = "jenistarif_nama ASC, kategoritindakan_nama ASC, kelaspelayanan_nama ASC, daftartindakan_nama ASC";
            $provider->pagination = false;
            
            return $provider;
        }
        
        public function searchDialogDiet()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'jenisdiet_m.jenisdiet_id, jenisdiet_m.jenisdiet_nama, '
				. 'menudiet_m.menudiet_id, menudiet_m.menudiet_nama, menudiet_m.menudiet_namalain, '
				. 'menudiet_m.jml_porsi, menudiet_m.ukuranrumahtangga';	
                $criteria->group = $criteria->select;
		$criteria->compare('LOWER(jenisdiet_m.jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('LOWER(menudiet_m.menudiet_nama)',strtolower($this->menudiet_nama),true);
		$criteria->compare('LOWER(menudiet_m.menudiet_namalain)',strtolower($this->menudiet_namalain),true);
		$criteria->compare('LOWER(menudiet_m.ukuranrumahtangga)',strtolower($this->ukuranrumahtangga),true);
		$criteria->compare('menudiet_m.jml_porsi',$this->jml_porsi);
		$criteria->addCondition("komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL);
                if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
		}
                $criteria->compare("t.jenistarif_id", $this->jenistarif_id);
		if(Yii::app()->user->getState('tindakankelas')){
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);					
			}
		}
		if(Yii::app()->user->getState('tindakanruangan')){
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
			}
			$model = new RITarifTindakanPerdaRuanganV;
		} else {
		$model = new TariftindakanperdaV;
		}
		if(!empty($this->jenisdiet_id)){
			$criteria->addCondition("jenisdiet_m.jenisdiet_id = ".$this->jenisdiet_id);					
		}
		// $criteria->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));					
		$criteria->join = ' JOIN menudiet_m ON t.daftartindakan_id = menudiet_m.daftartindakan_id
							JOIN jenisdiet_m ON menudiet_m.jenisdiet_id = jenisdiet_m.jenisdiet_id';
		
                // $criteria->limit = 10;
                // var_dump($criteria); die;
		return new CActiveDataProvider($model, array(
			'criteria'=>$criteria,
			// 'pagination'=>false,
		));
	}
}

