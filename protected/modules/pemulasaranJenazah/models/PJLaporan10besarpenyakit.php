<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ROLaporan10besarpenyakit
 *
 * @author sujana
 */
class PJLaporan10besarpenyakit extends Laporan10besarpenyakitV {

    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->ruangan_id)) {
            $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama, diagnosa_kode';
            $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        } else if (!empty($this->instalasi_id)) {
            $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama, diagnosa_kode';
            $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        } else {
            $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama, diagnosa_kode';
            $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        }

        $criteria->order = 'jumlah DESC';
        $criteria->addBetweenCondition('DATE(tglmorbiditas)',$this->tgl_awal,$this->tgl_akhir,true);
        $criteria->compare('diagnosa_id', $this->diagnosa_id);
        $criteria->compare('LOWER(diagnosa_kode)', strtolower($this->diagnosa_kode), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->compare('date(tglmorbiditas)', $this->tglmorbiditas, true);
        $criteria->compare('pasienmorbiditas_id', $this->pasienmorbiditas_id);
		// RND-8606	"tambahkan filter ruangan_id pasien yang terdaftar di pemulasaran jenazah saja"
        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
//            $criteria->limit = $this->jumlahTampil;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array('pageSize' => $this->jumlahTampil,),
                    'totalItemCount' => $this->jumlahTampil,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->ruangan_id)) {
            $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama, diagnosa_kode';
            $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        } else if (!empty($this->instalasi_id)) {
            $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama, diagnosa_kode';
            $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        } else {
            $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama, diagnosa_kode';
            $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        }
        $criteria->order = 'jumlah DESC';
        $criteria->addBetweenCondition('DATE(tglmorbiditas)',$this->tgl_awal,$this->tgl_akhir,true);
		// RND-8606	"tambahkan filter ruangan_id pasien yang terdaftar di pemulasaran jenazah saja"
        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);

        return new CActiveDataProvider($this, array(
                    'pagination' => array('pageSize' => $this->jumlahTampil,),
                    'totalItemCount' => $this->jumlahTampil,
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->ruangan_id)) {
            $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode';
            $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        } else if (!empty($this->instalasi_id)) {
            $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode';
            $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        } else {
            $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode';
            $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        }
        $criteria->order = 'jumlah DESC';
        $criteria->addBetweenCondition('DATE(tglmorbiditas)',$this->tgl_awal,$this->tgl_akhir,true);
		// RND-8606	"tambahkan filter ruangan_id pasien yang terdaftar di pemulasaran jenazah saja"
        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array('pageSize' => $this->jumlahTampil,),
                    'totalItemCount' => $this->jumlahTampil,
                ));
    }

}

?>
