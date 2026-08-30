<?php


class RKLaporanJumlahPemeriksaanDokterV extends LaporanjumlahpemeriksaandokterV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporantindaklanjutV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        /*
        if (is_array($this->carakeluar)) {
            foreach ($this->carakeluar as $v) {
                if ($v == 'DIPULANGKAN') {
                    $criteria->addCondition('carakeluar is null', 'OR');
                } else {
                    $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                }
            }
        } else {
            $criteria->addCondition('pasienpulang_id is not null');
            $criteria->addCondition('carakeluar is null');
        }
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);

        */
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
	
	public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        /*
        if (is_array($this->carakeluar)) {
            foreach ($this->carakeluar as $v) {
                if ($v == 'DIPULANGKAN') {
                    $criteria->addCondition('carakeluar is null', 'OR');
                } else {
                    $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                }
            }
        } else {
            $criteria->addCondition('pasienpulang_id is not null');
            $criteria->addCondition('carakeluar is null');
        }

        $criteria->select = "count(pendaftaran_id) as jumlah, coalesce(carakeluar,'PULANG') as data";
        $criteria->group = 'carakeluar';

        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);

        */
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        /*
        if (is_array($this->carakeluar)) {
            foreach ($this->carakeluar as $v) {
                if ($v == 'DIPULANGKAN') {
                    $criteria->addCondition('carakeluar is null', 'OR');
                } else {
                    $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                }
            }
        } else {
            $criteria->addCondition('pasienpulang_id is not null');
            $criteria->addCondition('carakeluar is null');
        }
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->limit = -1;

        */
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                    'sort' => false,
                ));
    }
	
}