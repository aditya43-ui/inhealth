<?php
class KUPermintaanpembeliantouangmukaV extends PermintaanpembeliantouangmukaV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchDialog(){
            $criteria=new CDbCriteria;
            
            if(!empty($this->tglpermintaan)){
                $tglpermintaan = $this->getKonverviDateRange($this->tglpermintaan);
                $criteria->addBetweenCondition('DATE(tglpermintaan)', $tglpermintaan[0], $tglpermintaan[1]);
            }
            $criteria->compare('LOWER(nopermintaan)', strtolower($this->nopermintaan),true);
            $criteria->compare('LOWER(supplier_nama)', strtolower($this->supplier_nama),true);
            $criteria->compare('LOWER(noreferensi)', strtolower($this->noreferensi),true);
            $criteria->addCondition('jmlpermintaanuangmuka IS NOT NULL AND jmlpermintaanuangmuka > 0');
            $criteria->addCondition('jumlahuangmuka <> jmlpermintaanuangmuka');
            $criteria->order = "tglpermintaan DESC";
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
        
    public function getKonverviDateRange($tgl){
        $Tgl = (explode(" - ",$tgl));

        //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
        $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
        $Tgl[0] = $Tgl[0]->format('Y-m-d');
        $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
        $Tgl[1] = $Tgl[1]->format('Y-m-d');
        return array($Tgl[0],$Tgl[1]);
    } 
	
}

?>