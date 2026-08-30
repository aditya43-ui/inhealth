<?php
class PJTarifTindakanPerdaRuanganV  extends TariftindakanperdaruanganV
{
        public $tipepaket_id = Params::TIPEPAKET_ID_NONPAKET; //untuk PaketpelayananV di search dialog
        public $penjamin_id;
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
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

               // if ((!empty($this->kelaspelayanan_id)) || (!empty($this->daftartindakan_id)) || (!empty($this->kategoritindakan_id))){
                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                    $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_nama),true);
                    $criteria->compare('kategoritindakan_id',  $this->kategoritindakan_id);
                    $criteria->compare('daftartindakan_id',  $this->daftartindakan_id);
                    $criteria->compare('jenistarif_id',  $this->jenistarif_id);
                    $criteria->compare('ruangan_id',$this->ruangan_id);
//                }
//                else{
//                    $criteria->compare('ruangan_id', 0);
//                }
		
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
//        public function searchDialog($ruangan_id = null,$kelaspelayanan_id = null, $jenistarif_id = null, $penjamin_id=null)
//	{
//		// Warning: Please modify the following code to remove attributes that
//		// should not be searched.
//
//		$criteria=new CDbCriteria;
//                
//                if(!empty($ruangan_id)){
//                    $criteria->compare('ruangan_id',$ruangan_id);
//                }
//                
//                if(!empty($kelaspelayanan_id)){
//                    $criteria->compare('kelaspelayanan_id',$kelaspelayanan_id);
//                }
//                
//                if(!empty($jenistarif_id)){
//                    $criteria->compare('jenistarif_id',$jenistarif_id);
//                }
//                
//                if(!empty($penjamin_id)){
//                    $criteria->compare('penjamin_id',$penjamin_id);
//                }
//                
//                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
//                $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_id),true);
//                $criteria->compare('kategoritindakan_id',  $this->kategoritindakan_id);
//                $criteria->compare('ruangan_id',$this->ruangan_id);
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//		));
//	}
        /**
	 * untuk dialog box pilih tindakan
	 */
	public function searchDialog()
	{
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
            $criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
            $criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
            $criteria->compare('daftartindakan_akomodasi', $this->daftartindakan_akomodasi);
            $criteria->compare('harga_tariftindakan', $this->harga_tariftindakan);
            $criteria->compare('persencyto_tind', $this->persencyto_tind);
			if($this->tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET){
				if(!empty($this->tipepaket_id)){
					$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);		
				}
                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
				}
                if(Yii::app()->user->getState('tindakankelas')){
					if(!empty($this->kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);		
					}
				}
                $models = new PaketpelayananV;
            }else if($this->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET){
				if(!empty($this->jenistarif_id)){
					$criteria->addCondition("jenistarif_id = ".$this->jenistarif_id);		
				}
                if(Yii::app()->user->getState('tindakankelas')){
					if(!empty($this->kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);		
					}
				}
				if(!empty($this->penjamin_id)){
					$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
				}
                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                    $models = new PJTarifTindakanPerdaRuanganV;
                } else {
                    if(Yii::app()->user->getState('tindakanruangan')){
						if(!empty($this->ruangan_id)){
							$criteria->addCondition("ruangan_id = ".$this->ruangan_id);		
						}
					}
                    if(Yii::app()->user->getState('tindakankelas')){
						if(!empty($this->kelaspelayanan_id)){
							$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);		
						}
                        /*
						if(!empty($this->tipepaket_id)){
							$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);		
						}
                         * 
                         */
					}
                    $models = new TariftindakanperdaV;
                }
            }else{
				if(!empty($this->tipepaket_id)){
					$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);		
				}
                $models = new PaketpelayananV;
            }
            // $criteria->limit = 5;
            return new CActiveDataProvider($models, array(
				'criteria'=>$criteria,
            ));
	}
}

