<?php

/**
 * This is the model class for table "tariftindakanruangandetail_v".
 *
 * The followings are the available columns in table 'tariftindakanruangandetail_v':
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_namalainnya
 * @property string $daftartindakan_katakunci
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property integer $tariftindakan_id
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $harga_tariftindakan
 * @property integer $persendiskon_tind
 * @property double $hargadiskon_tind
 * @property integer $persencyto_tind
 * @property integer $jeniskelas_id
 * @property string $jeniskelas_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $kelaspelayanan_namalainnya
 * @property integer $daftartindakan_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 */
class SATariftindakanruangandetailV extends TariftindakanruangandetailV {

    public $daftartindakan, $kelompoktindakan, $kategoritindakan, $ruangan, $ruangan_id;
    public $komponenunit_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TariftindakanruangandetailV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;

        if (!empty($this->kategoritindakan_id)) {
            $criteria->addCondition('t.kategoritindakan_id = ' . $this->kategoritindakan_id);
        }
        $criteria->compare('LOWER(t.kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
        if (!empty($this->kelompoktindakan_id)) {
            $criteria->addCondition('t.kelompoktindakan_id = ' . $this->kelompoktindakan_id);
        }
        $criteria->compare('LOWER(t.kelompoktindakan_nama)', strtolower($this->kelompoktindakan_nama), true);
        $criteria->compare('LOWER(t.daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
        $criteria->compare('LOWER(t.daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
        $criteria->compare('LOWER(t.daftartindakan_namalainnya)', strtolower($this->daftartindakan_namalainnya), true);
        $criteria->compare('LOWER(t.daftartindakan_katakunci)', strtolower($this->daftartindakan_katakunci), true);
        if (!empty($this->perdatarif_id)) {
            $criteria->addCondition('t.perdatarif_id = ' . $this->perdatarif_id);
        }
        $criteria->compare('LOWER(t.perdanama_sk)', strtolower($this->perdanama_sk), true);
        $criteria->compare('LOWER(t.noperda)', strtolower($this->noperda), true);
        $criteria->compare('LOWER(t.tglperda)', strtolower($this->tglperda), true);
        $criteria->compare('LOWER(t.perdatentang)', strtolower($this->perdatentang), true);
        $criteria->compare('LOWER(t.ditetapkanoleh)', strtolower($this->ditetapkanoleh), true);
        $criteria->compare('LOWER(t.tempatditetapkan)', strtolower($this->tempatditetapkan), true);
        if (!empty($this->jenistarif_id)) {
            $criteria->addCondition('t.jenistarif_id = ' . $this->jenistarif_id);
        }
        $criteria->compare('LOWER(t.jenistarif_nama)', strtolower($this->jenistarif_nama), true);
        if (!empty($this->tariftindakan_id)) {
            $criteria->addCondition('t.tariftindakan_id = ' . $this->tariftindakan_id);
        }
        if (!empty($this->komponentarif_id)) {
            $criteria->addCondition('t.komponentarif_id = ' . $this->komponentarif_id);
        }
        $criteria->compare('LOWER(t.komponentarif_nama)', strtolower($this->komponentarif_nama), true);
        $criteria->compare('t.harga_tariftindakan', $this->harga_tariftindakan);
        if (!empty($this->persendiskon_tind)) {
            $criteria->addCondition('t.persendiskon_tind = ' . $this->persendiskon_tind);
        }
        $criteria->compare('t.hargadiskon_tind', $this->hargadiskon_tind);
        if (!empty($this->persencyto_tind)) {
            $criteria->addCondition('t.persencyto_tind = ' . $this->persencyto_tind);
        }
        if (!empty($this->jeniskelas_id)) {
            $criteria->addCondition('t.jeniskelas_id = ' . $this->jeniskelas_id);
        }
        $criteria->compare('LOWER(t.jeniskelas_nama)', strtolower($this->jeniskelas_nama), true);
        if (!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('t.kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(t.kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('LOWER(t.kelaspelayanan_namalainnya)', strtolower($this->kelaspelayanan_namalainnya), true);
        if (!empty($this->daftartindakan_id)) {
            $criteria->addCondition('t.daftartindakan_id = ' . $this->daftartindakan_id);
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('t.ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('t.instalasi_id = ' . $this->instalasi_id);
        }
        $criteria->compare('LOWER(t.instalasi_nama)', strtolower($this->instalasi_nama), true);

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = $this->criteriaSearch();
        $criteria->group = "t.daftartindakan_id, t.daftartindakan_nama, t.ruangan_id, t.komponentarif_id, t.ruangan_nama, "
                . "t.komponentarif_nama, t.kelompoktindakan_nama, t.kelompoktindakan_id, t.kategoritindakan_nama, t.daftartindakan_kode, "
                . "t.daftartindakan_nama, d.komponenunit_id, k.komponenunit_nama";
        $criteria->select = $criteria->group;
        $criteria->join = 'join daftartindakan_m d on d.daftartindakan_id = t.daftartindakan_id'
                . ' left join komponenunit_m k on k.komponenunit_id = d.komponenunit_id';
        $criteria->compare('d.komponenunit_id', $this->komponenunit_id);
        $criteria->addCondition('d.daftartindakan_aktif = true');
        //$criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder'=>'t.kelompoktindakan_nama, k.komponenunit_nama, t.kategoritindakan_nama, t.ruangan_nama, t.daftartindakan_nama, t.komponentarif_nama'
            )
        ));
    }

}
