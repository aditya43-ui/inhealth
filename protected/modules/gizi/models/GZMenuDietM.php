<?php

class GZMenuDietM extends MenuDietM {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public $idKelasPelayanan, $kelaspelayanan_id, $idJenisDiet, $jenisdiet_id, $jenistarif_id, $penjamin_id;
    public $isPasien = true;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchMenuDiet() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;


        $criteria->select = 't.*,jenisdiet_m.*,tariftindakan_m.*,kelaspelayanan_m.*';
        $criteria->select = 't.*, sum(tariftindakan_m.harga_tariftindakan) as harga_tariftindakan, tariftindakan_m.daftartindakan_id, t.jenisdiet_id';
        $criteria->group = 'tariftindakan_m.daftartindakan_id, t.menudiet_id, t.jenisdiet_id,t.menudiet_nama,t.menudiet_namalain,t.jml_porsi,t.ukuranrumahtangga,t.daftartindakan_id';
        $criteria->compare('t.menudiet_id', $this->menudiet_id);
        $criteria->compare('t.jenisdiet_id', $this->jenisdiet_id);
        $criteria->compare('t.daftartindakan_id', $this->daftartindakan_id);
        $criteria->compare('LOWER(t.menudiet_nama)', strtolower($this->menudiet_nama), true);
        $criteria->compare('LOWER(t.menudiet_namalain)', strtolower($this->menudiet_namalain), true);
        $criteria->compare('LOWER(jenisdiet_m.jenisdiet_nama)', strtolower($this->jenisdiet_nama), true);
        $criteria->compare('t.jml_porsi', $this->jml_porsi);
        $criteria->compare('tariftindakan_m.kelaspelayanan_id', $this->idKelasPelayanan);
        $criteria->compare('LOWER(t.ukuranrumahtangga)', strtolower($this->ukuranrumahtangga), true);
        
        
        if ($this->isPasien == true) {
            $criteria->addCondition('t.daftartindakan_id is not null');
            $criteria->join = 'JOIN tariftindakan_m on tariftindakan_m.daftartindakan_id = t.daftartindakan_id
                                       JOIN kelaspelayanan_m on kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id
                                       JOIN jenisdiet_m on jenisdiet_m.jenisdiet_id = t.jenisdiet_id';

        } else {
            $criteria->join = 'left JOIN tariftindakan_m on tariftindakan_m.daftartindakan_id = t.daftartindakan_id
                                       left JOIN kelaspelayanan_m on kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id
                                       JOIN jenisdiet_m on jenisdiet_m.jenisdiet_id = t.jenisdiet_id';
            
        }
        
        $criteria->order = 't.menudiet_nama';
        
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*
     * fungsi dialog diet untuk master menu makan tabulasi Jadwal Makan (tambah baru)
     */

    public function searchDialogDiet() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = "left join jenisdiet_m jenisdiet on jenisdiet.jenisdiet_id = t.jenisdiet_id "
                . "left join tipediet_m tipediet on tipediet.tipediet_id = t.tipediet_id"
                . ' JOIN kelaspelayanan_m k on k.kelaspelayanan_id = t.kelaspelayanan_id';
        if (!empty($this->menudiet_id)) {
            $criteria->addCondition('t.menudiet_id = ' . $this->menudiet_id);
        }
        if (!empty($this->jenisdiet_id)) {
            $criteria->addCondition('t.jenisdiet_id = ' . $this->jenisdiet_id);
        }
        if(!empty($this->jeniswaktu_id)) {
            $criteria->addCondition('t.jeniswaktu_id = ' . $this->jeniswaktu_id);
        }
        if(!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('t.kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(t.menudiet_nama)', strtolower($this->menudiet_nama), true);
        $criteria->compare('LOWER(t.menudiet_namalain)', strtolower($this->menudiet_namalain), true);
        $criteria->compare('t.jml_porsi', $this->jml_porsi);
        $criteria->compare('LOWER(t.ukuranrumahtangga)', strtolower($this->ukuranrumahtangga), true);
        $criteria->addCondition('t.kelaspelayanan_id is not null');
        $criteria->order = ('t.jenisdiet_id');
        
        $criteria->select = "t.*, jenisdiet.jenisdiet_nama, tipediet.tipediet_nama";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

?>