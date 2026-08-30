<?php

class RIObatalkesM extends ObatalkesM {

    public $generik_id, $therapiobat_id, $ruangan_id, $jnskelompok, $jenisobatalkes_nama, $lookup_name, $satuankecil_nama;
    public $komposisi, $pendaftaran_id, $jenisresep, $racikan_id;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ObatalkesM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchObatFarmasiRuangan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $format = new MyFormatter();
        $criteria = new CDbCriteria;

        $criteria->join = 'left join sumberdana_m on sumberdana_m.sumberdana_id = t.sumberdana_id '
                . 'left join satuankecil_m on satuankecil_m.satuankecil_id = t.satuankecil_id '
                . 'left join satuanbesar_m on satuanbesar_m.satuanbesar_id = t.satuanbesar_id '
                . 'left join generik_m on generik_m.generik_id = t.generik_id '
                . 'left join lookup_m ON t.jnskelompok = lookup_m.lookup_value';

        $criteria->select = '*, lookup_m.lookup_name, satuankecil_m.satuankecil_nama';

        // $criteria->with = array('sumberdana','satuankecil', 'satuanbesar','generik');
        $criteria->compare('LOWER(generik.generik_nama)', strtolower($this->generik_nama), true);
        $criteria->compare('LOWER(t.jnskelompok)', strtolower($this->jnskelompok), true);
        if (!empty($this->sumberdana_id)) {
            $criteria->addCondition("sumberdana_id = " . $this->sumberdana_id);
        }
        if (!empty($this->satuankecil_id)) {
            $criteria->addCondition("t.satuankecil_id = " . $this->satuankecil_id);
        }
        if (!empty($this->jenisobatalkes_id)) {
            $criteria->addCondition("jenisobatalkes_id = " . $this->jenisobatalkes_id);
        }
        $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
        $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
        $criteria->compare('LOWER(obatalkes_kadarobat)', strtolower($this->obatalkes_kadarobat), true);

        $criteria->compare('hargajual', $this->hargajual);
        $criteria->compare('obatalkes_aktif', isset($this->obatalkes_aktif) ? $this->obatalkes_aktif : true);
        $criteria->compare('LOWER(satuanbesar.satuanbesar_nama)', strtolower($this->satuanbesarNama), true);
        $criteria->compare('LOWER(satuankecil.satuankecil_nama)', strtolower($this->satuankecilNama), true);
        $criteria->compare('LOWER(sumberdana.sumberdana_nama)', strtolower($this->sumberdanaNama), true);

        if (!empty($this->therapiobat_id)) {
            $criteria->join .= (' JOIN therapimapobat_m ON therapimapobat_m.obatalkes_id = t.obatalkes_id');
            $criteria->addCondition('therapimapobat_m.therapiobat_id = ' . $this->therapiobat_id);
        }

        $criteria2 = new CDbCriteria;
        $criteria2->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $modObat = $this->model()->find($criteria2);
        if (isset($modObat)) {
            $generik_id = $modObat->generik_id;
            if (empty($this->generik_nama) && !empty($generik_id)) {
                $criteria->addCondition("LOWER(t.obatalkes_nama) ILIKE '%" . $this->obatalkes_nama . "%' OR t.generik_id = " . $generik_id);
            }
        } else {
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        }
        $criteria->addCondition('obatalkes_farmasi is true');
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'obatalkes_nama'),
        ));
    }

    public function searchObatAlkesPasienDijual() {
        $criteria = new CDbCriteria;
        $criteria->join = 'join (select a.pendaftaran_id, a.obatalkes_id, a.racikan_id from obatalkespasien_t a group by a.pendaftaran_id, a.obatalkes_id, a.racikan_id) o on o.obatalkes_id = t.obatalkes_id';
        $criteria->compare('o.pendaftaran_id', $this->pendaftaran_id);

        if (!empty($this->obatalkes_id)) {
            $criteria->addCondition("t.obatalkes_id = " . $this->obatalkes_id);
        }
        $criteria->compare('LOWER(t.obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($this->obatalkes_nama), true);

				if (!empty($this->jenisresep)) {
					if($this->jenisresep == 'Obat Racikan'){
						$criteria->addCondition("o.racikan_id IS NOT NULL");
					}else if($this->jenisresep == 'Obat Non Racikan'){
						$criteria->addCondition("o.racikan_id IS NULL");
					}
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder'=>'obatalkes_nama',
            ),
        ));
    }
}
