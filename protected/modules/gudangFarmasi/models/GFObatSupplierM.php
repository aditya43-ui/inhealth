<?php

/**
 * This is the model class for table "obatsupplier_m".
 *
 * The followings are the available columns in table 'obatsupplier_m':
 * @property integer $obatalkes_id
 * @property integer $supplier_id
 */
class GFObatSupplierM extends ObatsupplierM {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ObatsupplierM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('obatalkes', 'supplier');
        $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes.obatalkes_kode)', strtolower($this->obatalkes_kodeobat), true);
        $criteria->compare('LOWER(supplier.supplier_nama)', strtolower($this->supplier_nama), true);
        $criteria->compare('LOWER(supplier.supplier_kode)', strtolower($this->supplier_kode), true);
        $criteria->compare('LOWER(supplier.supplier_alamat)', strtolower($this->supplier_alamat), true);
        if (!empty($this->jenisobatalkes_id)) {
            $criteria->addCondition('t.jenisobatalkes_id = ' . $this->jenisobatalkes_id);
        }
        if (!empty($this->obatalkes_id)) {
            $criteria->addCondition('t.obatalkes_id = ' . $this->obatalkes_id);
        }
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('t.supplier_id = ' . $this->supplier_id);
        }
        if (!empty($this->obatsupplier_id)) {
            $criteria->addCondition('t.obatsupplier_id = ' . $this->obatsupplier_id);
        }
        if (!empty($this->satuankecil_id)) {
            $criteria->addCondition('t.satuankecil_id = ' . $this->satuankecil_id);
        }
        if (!empty($this->satuanbesar_id)) {
            $criteria->addCondition('t.satuanbesar_id = ' . $this->satuanbesar_id);
        }
        //$criteria->compare('t.hargabelibesar',$this->hargabelibesar);
        if (!empty($this->hargabelibesar)) {
            $criteria->addCondition('t.hargabelibesar= ' . $this->hargabelibesar);
        }
        //$criteria->compare('t.diskon_persen',$this->diskon_persen);
        if (!empty($this->diskon_persen)) {
            $criteria->addCondition('t.diskon_persen= ' . $this->diskon_persen);
        }
        //$criteria->compare('t.hargabelikecil',$this->hargabelikecil);
        if (!empty($this->hargabelikecil)) {
            $criteria->addCondition('t.hargabelikecil= ' . $this->hargabelikecil);
        }
        //$criteria->compare('t.ppn_persen',$this->ppn_persen);
        if (!empty($this->ppn_persen)) {
            $criteria->addCondition('t.ppn_persen= ' . $this->ppn_persen);
        }
        $criteria->order = 'supplier.supplier_kode ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchObatSupplierGF() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('obatalkes', 'supplier');
        $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes.obatalkes_kode)', strtolower($this->obatalkes_kodeobat), true);
        $criteria->compare('LOWER(supplier.supplier_nama)', strtolower($this->supplier_nama), true);
        $criteria->compare('LOWER(supplier.supplier_kode)', strtolower($this->supplier_kode), true);
        $criteria->compare('LOWER(supplier.supplier_alamat)', strtolower($this->supplier_alamat), true);
        if (!empty($this->jenisobatalkes_id)) {
            $criteria->addCondition('t.jenisobatalkes_id = ' . $this->jenisobatalkes_id);
        }
        if (!empty($this->obatalkes_id)) {
            $criteria->addCondition('t.obatalkes_id = ' . $this->obatalkes_id);
        }
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('t.supplier_id = ' . $this->supplier_id);
        }
        if (!empty($this->obatsupplier_id)) {
            $criteria->addCondition('t.obatsupplier_id = ' . $this->obatsupplier_id);
        }
        if (!empty($this->satuankecil_id)) {
            $criteria->addCondition('t.satuankecil_id = ' . $this->satuankecil_id);
        }
        if (!empty($this->satuanbesar_id)) {
            $criteria->addCondition('t.satuanbesar_id = ' . $this->satuanbesar_id);
        }
        //$criteria->compare('t.hargabelibesar',$this->hargabelibesar);
        if (!empty($this->hargabelibesar)) {
            $criteria->addCondition('t.hargabelibesar= ' . $this->hargabelibesar);
        }
        //$criteria->compare('t.diskon_persen',$this->diskon_persen);
        if (!empty($this->diskon_persen)) {
            $criteria->addCondition('t.diskon_persen= ' . $this->diskon_persen);
        }
        //$criteria->compare('t.hargabelikecil',$this->hargabelikecil);
        if (!empty($this->hargabelikecil)) {
            $criteria->addCondition('t.hargabelikecil= ' . $this->hargabelikecil);
        }
        //$criteria->compare('t.ppn_persen',$this->ppn_persen);
        if (!empty($this->ppn_persen)) {
            $criteria->addCondition('t.ppn_persen= ' . $this->ppn_persen);
        }
        $criteria->order = 'supplier.supplier_kode ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchObatED() {
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $this->tglkadaluarsa = isset($this->tglkadaluarsa) ? $format->formatDateTimeForDb($this->tglkadaluarsa) : null;
        $criteria->select = 't.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, obatalkes_m.tglkadaluarsa,
							supplier_m.supplier_id, supplier_m.supplier_nama, satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama';
        $criteria->join = 'JOIN obatalkes_m ON t.obatalkes_id=obatalkes_m.obatalkes_id
						JOIN supplier_m ON t.supplier_id=supplier_m.supplier_id
						JOIN satuankecil_m ON t.satuankecil_id=satuankecil_m.satuankecil_id';
        $criteria->limit = 5;
        if (!empty($this->obatalkes_id)) {
            $criteria->addCondition('t.obatalkes_id= ' . $this->obatalkes_id);
        }
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        //$criteria->addCondition('obatalkes_m.tglkadaluarsa= '.$this->tglkadaluarsa);
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('t.supplier_id= ' . $this->supplier_id);
        }
        $criteria->compare('LOWER(supplier_nama)', strtolower($this->supplier_nama), true);
        if (!empty($this->satuankecil_id)) {
            $criteria->addCondition('t.satuankecil_id= ' . $this->satuankecil_id);
        }
        $criteria->compare('LOWER(satuankecil_m.satuankecil_nama)', strtolower($this->satuankecil_nama), true);
        if (!empty($this->tglkadaluarsa)) {
            $criteria->addCondition("date(obatalkes_m.tglkadaluarsa) = '" . $this->tglkadaluarsa . "'");
        }
        $this->tglkadaluarsa = isset($this->tglkadaluarsa) ? $format->formatDateTimeForUser($this->tglkadaluarsa) : null;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function getStokObatRuangan($sumberdana_id = null) { // menampilkan stok obat per ruangan login
        if (!empty($sumberdana_id)) {
            return StokobatalkesT::getJumlahStok($this->obatalkes_id, Yii::app()->user->getState('ruangan_id'), $sumberdana_id);
        } else {
            return StokobatalkesT::getJumlahStok($this->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
        }
    }

    public function searchDialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        //$criteria->select = " t.*, oa.obatalkes_nama, joa.jenisobatalkes_nama";
        $criteria->join = "
							JOIN obatalkes_m oa ON oa.obatalkes_id = t.obatalkes_id 
                            JOIN satuankecil_m sk ON sk.satuankecil_id = t.satuankecil_id 
							JOIN satuanbesar_m sb ON sb.satuanbesar_id = t.satuanbesar_id 
                            LEFT JOIN jenisobatalkes_m joa ON joa.jenisobatalkes_id = oa.jenisobatalkes_id							
                            ";

        if (!empty($this->jenisobatalkes_id)) {
            $criteria->addCondition('oa.jenisobatalkes_id = ' . $this->jenisobatalkes_id);
        }

        if (!empty($this->satuankecil_id)) {
            $criteria->addCondition('t.satuankecil_id = ' . $this->satuankecil_id);
        }

        if (empty($this->supplier_id)) {
            $criteria->addCondition("t.supplier_id is NULL");
        } else {
            $criteria->addCondition("t.supplier_id=" . $this->supplier_id);
        }

        $criteria->compare('LOWER(oa.obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(oa.obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
        $criteria->compare('LOWER(oa.obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);

        if (!empty($this->tglkadaluarsa)) {
            $criteria->addCondition("date(oa.tglkadaluarsa) = '" . $this->tglkadaluarsa . "'");
        }

        $criteria->addCondition('oa.obatalkes_aktif = TRUE');
        $criteria->order = 'oa.obatalkes_nama ASC';

        //$criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                //'pagination'=>false,
        ));
    }
}    