<?php
/**
 * Class model untuk tabel "obatalkes_m" pada module pengadaan.
 * 
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 */
class ADObatalkesV extends ObatalkesV {
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ObatalkesM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * kriteria data obat
     * @return \CDbCriteria
     */
    public function criteriaDataObat() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        if (is_array($this->obatalkes_id)) { //jika menampilkan banyak obatalkes_id
            $pilihObat = array();
            $i = 0;
            foreach ($this->obatalkes_id as $idObat) {
                $pilihObat[$i] = "obatalkes_id = '" . $idObat . "' "; //multiple conditions
                $i++;
            }
            $criteria->condition = implode(' OR ', $pilihObat);
        } else {
            if (!empty($this->obatalkes_id)) {
                $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
            }
            if (!empty($this->obatalkes_id)) {
                $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
            }
            if (!empty($this->sumberdana_id)) {
                $criteria->addCondition('sumberdana_id = ' . $this->sumberdana_id);
            }
            if (!empty($this->satuankecil_id)) {
                $criteria->addCondition('satuankecil_id = ' . $this->satuankecil_id);
            }
            if (!empty($this->jenisobatalkes_id)) {
                $criteria->addCondition('jenisobatalkes_id = ' . $this->jenisobatalkes_id);
            }
            $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
            $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
            $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
            $criteria->compare('LOWER(obatalkes_kadarobat)', strtolower($this->obatalkes_kadarobat), true);
            $criteria->compare('kemasanbesar', $this->kemasanbesar);
            $criteria->compare('kekuatan', $this->kekuatan);
            $criteria->compare('LOWER(satuankekuatan)', strtolower($this->satuankekuatan), true);
            $criteria->compare('harganetto', $this->harganetto);
            $criteria->compare('hargajual', $this->hargajual);
            $criteria->compare('discount', $this->discount);
        }
        if ($this->tglkadaluarsa == 1) {
            $criteria->addBetweenCondition('date(tglkadaluarsa)', $this->tglkadaluarsa_awal, $this->tglkadaluarsa_akhir);
        }
        $criteria->compare('obatalkes_aktif', TRUE);
        if (!isset($_GET['ADObatalkesM'])) {
            $criteria->limit = 0;
        }
        return $criteria;
    }
    
    /**
     * Mencari data obat berdasarkan kriteria
     * @return \CActiveDataProvider
     */
    public function searchDataObat() {
        return new CActiveDataProvider($this, array(
            'criteria' => $this->criteriaDataObat(),
            'pagination' => false,
        ));
    }

    /**
     * Untuk mencari data obat
     * @return \CActiveDataProvider
     */
    public function searchDataObatAfter() {
        $criteria = new CDbCriteria;
        if (is_array($this->obatalkes_id)) { //jika menampilkan banyak obatalkes_id
            $pilihObat = array();
            $i = 0;
            foreach ($this->obatalkes_id as $idObat) {
                $pilihObat[$i] = "obatalkes_id = '" . $idObat . "' "; //multiple conditions
                $i++;
            }
            $criteria->condition = implode(' OR ', $pilihObat);
        } else {
            if (!empty($this->obatalkes_id)) {
                $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
            }
            if (!empty($this->sumberdana_id)) {
                $criteria->addCondition('sumberdana_id = ' . $this->sumberdana_id);
            }
            if (!empty($this->satuankecil_id)) {
                $criteria->addCondition('satuankecil_id = ' . $this->satuankecil_id);
            }
            if (!empty($this->jenisobatalkes_id)) {
                $criteria->addCondition('jenisobatalkes_id = ' . $this->jenisobatalkes_id);
            }
            $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
            $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
            $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
            $criteria->compare('LOWER(obatalkes_kadarobat)', strtolower($this->obatalkes_kadarobat), true);
            $criteria->compare('kemasanbesar', $this->kemasanbesar);
            $criteria->compare('kekuatan', $this->kekuatan);
            $criteria->compare('LOWER(satuankekuatan)', strtolower($this->satuankekuatan), true);
            $criteria->compare('harganetto', $this->harganetto);
            $criteria->compare('hargajual', $this->hargajual);
            $criteria->compare('discount', $this->discount);
        }
        if ($this->tglkadaluarsa == 1) {
            $criteria->addBetweenCondition('date(tglkadaluarsa)', $this->tglkadaluarsa_awal, $this->tglkadaluarsa_akhir);
        }
        $criteria->compare('obatalkes_aktif', TRUE);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
    /**
     * Mencari data obat alkes untuk open dialog
     * @return \CActiveDataProvider
     */
    public function searchDialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        if (!empty($this->obatalkes_id)) {
            $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
        }
        $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
        $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
        $criteria->compare('LOWER(supplier_nama)', strtolower($this->supplier_nama), true);
        $criteria->order = 'obatalkes_nama ASC';
        //$criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                //'pagination'=>false,
        ));
    }
    
    /**
     * Mencari data obat alkes
     */
    public function searchDialogStokObatAlkesRuanganLogin() {
        $prov = $this->searchDialog();

        $prov->criteria->group = 't.satuankecil_id, t.obatalkes_id, t.obatalkes_nama, t.jenisobatalkes_id, t.obatalkes_kategori, t.obatalkes_golongan, t.tglkadaluarsa, t.harganetto, t.ppn_persen,t.hargajual';
        $prov->criteria->select = $prov->criteria->group . ", sum((case when stok.qtystok_in is null then 0 else stok.qtystok_in end) - (case when stok.qtystok_out is null then 0 else stok.qtystok_out end)) as qtystok";
        $prov->criteria->join .= ' left join stokobatalkes_t stok on stok.obatalkes_id = t.obatalkes_id and stok.ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' ';
        // $prov->criteria->having = '(sum((case when stok.qtystok_in is null then 0 else stok.qtystok_in end) - (case when stok.qtystok_out is null then 0 else stok.qtystok_out end)) = 0)';
        $prov->criteria->order = null;
        $prov->sort->attributes = array(
            'qtystok' => array(
                'asc' => 'sum((case when stok.qtystok_in is null then 0 else stok.qtystok_in end) - (case when stok.qtystok_out is null then 0 else stok.qtystok_out end)) asc',
                'desc' => 'sum((case when stok.qtystok_in is null then 0 else stok.qtystok_in end) - (case when stok.qtystok_out is null then 0 else stok.qtystok_out end)) desc',
            ),
            "*"
        );
        $prov->sort->defaultOrder = 't.obatalkes_nama';

        return $prov;
    }
    
    /**
     * Mencari data obat alkes ruangan login 
     * @return type
     */
    public function searchDialogStokRencanaRuanganLogin() {
        $prov = $this->searchDialog();

        $prov->criteria->group = 't.satuankecil_id, t.obatalkes_id, t.obatalkes_nama, t.jenisobatalkes_id, t.obatalkes_kategori, t.obatalkes_golongan, t.tglkadaluarsa, t.harganetto, t.ppn_persen';
        $prov->criteria->select = $prov->criteria->group . ", sum((case when stok.qtystok_in is null then 0 else stok.qtystok_in end) - (case when stok.qtystok_out is null then 0 else stok.qtystok_out end)) as qtystok";
        $prov->criteria->join .= ' left join stokobatalkes_t stok on stok.obatalkes_id = t.obatalkes_id and stok.ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' ';
        // $prov->criteria->having = '(sum((case when stok.qtystok_in is null then 0 else stok.qtystok_in end) - (case when stok.qtystok_out is null then 0 else stok.qtystok_out end)) = 0)';
        $prov->criteria->order = null;
        $prov->sort->attributes = array(
            'qtystok' => array(
                'asc' => 'sum((case when stok.qtystok_in is null then 0 else stok.qtystok_in end) - (case when stok.qtystok_out is null then 0 else stok.qtystok_out end)) asc',
                'desc' => 'sum((case when stok.qtystok_in is null then 0 else stok.qtystok_in end) - (case when stok.qtystok_out is null then 0 else stok.qtystok_out end)) desc',
            ),
            "*"
        );
        $prov->sort->defaultOrder = 't.obatalkes_nama';

        return $prov;
    }

    /**
     * untuk dialog pilih obat alkes
     * @return type
     */
    public function getSatuanKecilNama() {
        return $this->satuankecil->satuankecil_nama;
    }
    
    /**
     * Mendapatkan stok obat ruangan pemesan
     */
    public function getStokObatRuanganPemesan() { // menampilkan stok obat berdasarkan ruangan pemesan
        if (isset($_GET['pesanobatalkes_id'])) {
            $modInfoOa = ADInformasipesanobatalkesV::model()->findByAttributes(array('pesanobatalkes_id' => $_GET['pesanobatalkes_id']));
            if (!empty($modInfoOa)) {
                return StokobatalkesT::getJumlahStok($this->obatalkes_id, $modInfoOa->ruanganpemesan_id);
            } else {
                return 0;
            }
        } else {
            return StokobatalkesT::getJumlahStok($this->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
        }
    }
    
    /**
     * Menampilkan data obat alkes
     * @return \CActiveDataProvider
     */
    public function searchPilih() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('jenisobatalkes');

        if (!empty($this->obatalkes_id)) {
            $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
        }
        if (!empty($this->jenisobatalkes_id)) {
            $criteria->addCondition('jenisobatalkes_id = ' . $this->jenisobatalkes_id);
        }

        $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(jenisobatalkes.jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
        $criteria->addCondition("obatalkes_aktif = TRUE");
        $criteria->order = 'obatalkes_nama ASC';
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Menampilkan dialog mutasi obat alkes
     * @return \CActiveDataProvider
     */
    public function searchDialogMutasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        if ($this->is_nobatch_tglkadaluarsa == true) {
            $criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
            if (!empty($this->obatalkes_id)) {
                $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
            }
            $criteria->compare('LOWER(obatalkes_barcode)', strtolower($this->obatalkes_barcode), true);
            $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
            $criteria->compare('LOWER(obatalkes_namalain)', strtolower($this->obatalkes_namalain), true);
            $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
            $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
            $criteria->compare('LOWER(obatalkes_kadarobat)', strtolower($this->obatalkes_kadarobat), true);

            if (!empty($this->satuankecil_id)) {
                $criteria->addCondition('satuankecil_id = ' . $this->satuankecil_id);
            }
            $criteria->compare('LOWER(satuankecil_nama)', strtolower($this->satuankecil_nama), true);
            $criteria->compare('LOWER(nobatch)', strtolower($this->nobatch), true);

            if (!empty($this->tglkadaluarsa)) {
                $criteria->addBetweenCondition('DATE(tglkadaluarsa)', $this->tglkadaluarsa, $this->tglkadaluarsa);
            }

            $criteria->order = 'obatalkes_nama ASC';
            $criteria->limit = 10;

            $model = new ADInformasistokobatalkesV;
        } else {
            $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
						JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
						LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
						";
            if (!empty($this->obatalkes_id)) {
                $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
            }
            if (!empty($this->sumberdana_id)) {
                $criteria->addCondition('t.sumberdana_id = ' . $this->sumberdana_id);
            }
            if (!empty($this->satuankecil_id)) {
                $criteria->addCondition('t.satuankecil_id = ' . $this->satuankecil_id);
            }
            if (!empty($this->jenisobatalkes_id)) {
                $criteria->addCondition('t.jenisobatalkes_id = ' . $this->jenisobatalkes_id);
            }
            $criteria->compare('LOWER(t.obatalkes_kode)', strtolower($this->obatalkes_kode), true);
            $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($this->obatalkes_nama), true);
            $criteria->compare('LOWER(t.obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
            $criteria->compare('LOWER(t.obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
//			$criteria->compare('LOWER(t.tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
            if (!empty($this->tglkadaluarsa)) {
                $criteria->addBetweenCondition('DATE(t.tglkadaluarsa)', $this->tglkadaluarsa, $this->tglkadaluarsa);
            }
            $criteria->compare('LOWER(satuankecil_m.satuankecil_nama)', strtolower($this->satuankecil_nama), true);
            $criteria->compare('LOWER(sumberdana_m.sumberdana_nama)', strtolower($this->sumberdana_nama), true);
            $criteria->compare('LOWER(jenisobatalkes_m.jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
            $criteria->addCondition('obatalkes_aktif = TRUE');
            $criteria->order = 'obatalkes_nama ASC';
            $criteria->limit = 10;

            $model = new ADObatalkesM;
        }

        return new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Mendapatkan data pabrik
     */
    public function getPabrikItems() {
        return PabrikM::model()->findAll('pabrik_aktif=true ORDER BY pabrik_nama');
    }
    
    /**
     * Mendapatkan data atc
     */
    public function getAtcItems() {
        return ADAtcM::model()->findAll('atc_aktif=true ORDER BY atc_nama');
    }

}

?>
