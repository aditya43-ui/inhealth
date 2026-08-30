<?php
class BKMenuDietM extends MenuDietM
{
    public $jenisdiet_nama;
    public $menudiet_nama;
    public $daftartindakan_nama;
    public $harga_tariftindakan;
    public $kelaspelayanan_nama,$kelaspelayanan_id;
    public $idKelasPelayanan,$idJenisDiet;
    public $ruangan_id,$penjamin_id,$jenistarif_id,$tipepaket_id,$kategoritindakan_nama;
    public $daftartindakan_kode,$persencyto_tind;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MenuDietM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

        
    public function searchDialogDiet()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->select = 't.*, tariftindakan_m.*, kelaspelayanan_m.*, jenisdiet_m.*,daftartindakan_m.*,kategoritindakan_m.*';
			if(!empty($this->menudiet_id)){
				$criteria->addCondition("menudiet_id = ".$this->menudiet_id);					
			}
			if(!empty($this->jenisdiet_id)){
				$criteria->addCondition("t.jenisdiet_id = ".$this->jenisdiet_id);					
			}
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("tariftindakan_m.kelaspelayanan_id = ".$this->kelaspelayanan_id);					
			}
			if(!empty($this->jenistarif_id)){
				$criteria->addCondition("tariftindakan_m.jenistarif_id = ".$this->jenistarif_id);					
			}
			if(!empty($this->daftartindakan_id)){
				$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id);					
			}
            $criteria->compare('LOWER(daftartindakan_m.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
            $criteria->compare('LOWER(daftartindakan_m.daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
            $criteria->compare('LOWER(jenisdiet_m.jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
            $criteria->compare('LOWER(menudiet_nama)',strtolower($this->menudiet_nama),true);
            $criteria->compare('LOWER(menudiet_namalain)',strtolower($this->menudiet_namalain),true);
            $criteria->compare('jml_porsi',$this->jml_porsi);
            $criteria->compare('LOWER(ukuranrumahtangga)',strtolower($this->ukuranrumahtangga),true);
            $criteria->addCondition('komponentarif_id = '.PARAMS::KOMPONENTARIF_ID_TOTAL);
            $criteria->join = 'JOIN daftartindakan_m ON t.daftartindakan_id = daftartindakan_m.daftartindakan_id
                               LEFT JOIN kategoritindakan_m ON daftartindakan_m.kategoritindakan_id = kategoritindakan_m.kategoritindakan_id
                               JOIN tariftindakan_m on tariftindakan_m.daftartindakan_id = t.daftartindakan_id 
                               JOIN jenisdiet_m on jenisdiet_m.jenisdiet_id = t.jenisdiet_id
                               JOIN kelaspelayanan_m on kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}