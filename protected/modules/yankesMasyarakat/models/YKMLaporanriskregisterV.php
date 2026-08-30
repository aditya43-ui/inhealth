<?php

/**
 * Digunakan untuk memanggil view laporanriskregister_v, hanya untuk modul yankesMasyarakat
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models  
 */
class YKMLaporanriskregisterV extends LaporanriskregisterV {

    public $instalasi_id, $ruangan_id, $ruangan_nama, $instalasi_nama, $konsekuensi_warna;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporanriskregisterV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Filter tabel laporan risk register
     * @return \CActiveDataProvider
     */
    public function searchTable() {

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Filtering cetak data laporan risk register
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Criteria pencarian untuk filter data tabel dan print laporan risk register
     * @return \CDbCriteria
     */
    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        $format = new MyFormatter();
        $criteria->select = "t.*,"
                            . "CASE
                                WHEN t.konsekuensi_bobot between 1 and 3 then 'Hijau'::text
                                WHEN t.konsekuensi_bobot between 4 and 6 then  'Kuning'::text
                                WHEN t.konsekuensi_bobot between 8 and 12 then  'Oranye'::text
                                ELSE 'Merah'::text END AS konsekuensi_warna";
        if (!empty($this->ruangan_id)) {
            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        }
        if (!empty($this->perioderiskregister_id)) {
            $criteria->compare('sumber_resiko', $this->sumber_resiko, true);
        }
        if (!empty($this->sumber_resiko)) {
            $criteria->compare('sumber_resiko', $this->sumber_resiko, true);
        }
        if (!empty($this->status_riskregister)) {
            $criteria->compare('status_riskregister', $this->status_riskregister, true);
        }
        if (!empty($this->tingkatrisiko_id)) {
            $criteria->addCondition('tingkatrisiko_id ='. $this->tingkatrisiko_id);
        }
        $criteria->order = "rpn_score desc";
        return $criteria;
    }
    
    /**
     * Generate Laporan
     * @return type
     */
    public function generateLaporan(){
        $criteria = new CDbCriteria();
        $criteria->order = "rpn_score desc";
        
        if (!empty($this->ruangan_id)) {
            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        }
        if (!empty($this->sumber_resiko)) {
            $criteria->compare('sumber_resiko', $this->sumber_resiko, true);
        }
        if (!empty($this->status_riskregister)) {
            $criteria->compare('status_riskregister', $this->status_riskregister, true);
        }
        if (!empty($this->perioderiskregister_id)) {
            $criteria->addCondition('perioderiskregister_id ='. $this->perioderiskregister_id);
        }
        
        if (!empty($this->tingkatrisiko_id)) {
            $criteria->addCondition('tingkatrisiko_id ='. $this->tingkatrisiko_id);
        }
        if (empty($_GET['caraPrint'])) {
            $criteria->limit = 10;
            $criteria->offset = !empty($_GET['page']) ? $_GET['page'] + 8 : 0;
        }
        $model = YKMLaporanriskregisterV::model()->findAll($criteria);
        $count = YKMLaporanriskregisterV::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $arr = array();
        
        foreach($model as $det){
            $iden = $det->identifikasiresiko_id; 

            $cekLookup = LookupM::model()->findByAttributes(array('lookup_type' => 'sumber_riskregister', 'lookup_value' => $det->sumber_resiko));
            $modUnit = UnitkerjaM::model()->findByPk($det->unitkerja_id);

            $arr[$iden]['sumber_resiko'] = !empty($cekLookup->lookup_name) ? $cekLookup->lookup_name : "-";
            $arr[$iden]['deskripsiresiko'] = !empty($det->deskripsiresiko) ? $det->deskripsiresiko : "-"; 
            $arr[$iden]['dampakrisiko'] = !empty($det->dampakrisiko) ? $det->dampakrisiko : "-";
            $arr[$iden]['namaunitkerja'] = !empty($modUnit->namaunitkerja) ? $modUnit->namaunitkerja : "-"; 
            $arr[$iden]['penyebabresiko'] = !empty($det->penyebabresiko) ? $det->penyebabresiko : "-"; 
            
            $modTipe = TiperesikoM::model()->findByPk($det->tiperesiko_id);
            $arr[$iden]['tiperesiko_nama'] = !empty($modTipe->tiperesiko_nama) ? $modTipe->tiperesiko_nama : "-"; 
            $arr[$iden]['konsekuensi_bobot'] = !empty($det->konsekuensi_bobot) ? $det->konsekuensi_bobot : "-";
            
            if ($det->konsekuensi_bobot == 1) {
                $arr[$iden]['style_warna_konsekuensi'] = "background: #ffffff!important; color: black; text-align: center;"; 
                $arr[$iden]['style_warna_konsekuensi_excel'] = "bgcolor='#ffffff' color='black' align='center'"; 
            } else if ($det->konsekuensi_bobot == 2) {
                $arr[$iden]['style_warna_konsekuensi'] = "background: #92d050!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_konsekuensi_excel'] = "bgcolor='#92d050' color='black' align='center'"; 
            } else if ($det->konsekuensi_bobot == 3) {
                $arr[$iden]['style_warna_konsekuensi'] = "background: #ffff00!important; color: black; text-align: center;"; 
                $arr[$iden]['style_warna_konsekuensi_excel'] = "bgcolor='#ffff00' color='black' align='center'"; 
            } else if ($det->konsekuensi_bobot == 4) {
                $arr[$iden]['style_warna_konsekuensi'] = "background: #ffc000!important; color: black; text-align: center;"; 
                $arr[$iden]['style_warna_konsekuensi_excel'] = "bgcolor='#ffc000' color='black' align='center'"; 
            } else if ($det->konsekuensi_bobot == 5) {
                $arr[$iden]['style_warna_konsekuensi'] = "background: #ed1c24!important; color: black; text-align: center;"; 
                $arr[$iden]['style_warna_konsekuensi_excel'] = "bgcolor='#ed1c24' color='black' align='center'"; 
            }
            
            $arr[$iden]['peluang_bobotdescriptor'] = !empty($det->peluang_bobotdescriptor) ? $det->peluang_bobotdescriptor : "-";
            $arr[$iden]['skor_cl'] = !empty($det->skor_cl) ? $det->skor_cl : "-";
            
            if ($det->skor_cl  >= 1 && $det->skor_cl <= 3) {
                $arr[$iden]['style_warna_cl'] = "background: #92d050!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_cl_excel'] = "bgcolor='#92d050' color='black' align='center'"; 
            } else if ($det->skor_cl  >= 4 && $det->skor_cl <= 6) {
                $arr[$iden]['style_warna_cl'] = "background: #ffff00!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_cl_excel'] = "bgcolor='#ffff00' color='black' align='center'"; 
            } else if ($det->skor_cl  >= 8 && $det->skor_cl <= 12) {
                $arr[$iden]['style_warna_cl'] = "background: #ffc000!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_cl_excel'] = "bgcolor='#ffc000' color='black' align='center'"; 
            } else if ($det->skor_cl  >= 15 && $det->skor_cl <= 25) {
                $arr[$iden]['style_warna_cl'] = "background: #ed1c24!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_cl_excel'] = "bgcolor='#ed1c24' color='black' align='center'"; 
            } else {
                $arr[$iden]['style_warna_cl'] = "background: #ffffff!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_cl_excel'] = "bgcolor='#ffffff' color='black' align='center'"; 
            }
            
            $arr[$iden]['detectability_bobot'] = !empty($det->detectability_bobot) ? $det->detectability_bobot : "-";
            $arr[$iden]['rpn_score'] = !empty($det->rpn_score) ? $det->rpn_score : "-";
            
            if ($det->rpn_score  >= 1 && $det->rpn_score <= 8) {
                $arr[$iden]['style_warna_rpn'] = "background: #92d050!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_rpn_excel'] = "bgcolor='#92d050' color='black' align='center'";
            } else if ($det->rpn_score  >= 9 && $det->rpn_score <= 36) {
                $arr[$iden]['style_warna_rpn'] = "background: #ffff00!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_rpn_excel'] = "bgcolor='#ffff00' color='black' align='center'";
            } else if ($det->rpn_score  >= 36 && $det->rpn_score <= 59) {
                $arr[$iden]['style_warna_rpn'] = "background: #ffc000!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_rpn_excel'] = "bgcolor='#ffc000' color='black' align='center'";
            } else if ($det->rpn_score  >= 60 && $det->rpn_score <= 100) {
                $arr[$iden]['style_warna_rpn'] = "background: #ed1c24!important; color: black; text-align: center;";
                $arr[$iden]['style_warna_rpn_excel'] = "bgcolor='#ed1c24' color='black' align='center'";
            } 
            
            $arr[$iden]['tingkatrisiko_nama'] = !empty($det->tingkatrisiko_nama) ? $det->tingkatrisiko_nama : "-";
            
            $cekLookup2 = LookupM::model()->findByAttributes(array('lookup_type' => 'evaluasi_risiko', 'lookup_value' => $det->evaluasi_risiko));
            $arr[$iden]['evaluasi_risiko'] = !empty($cekLookup2->lookup_name) ? $cekLookup2->lookup_name : "-";

            $arr[$iden]['riskrespon'] = !empty($det->riskrespon) ? $det->riskrespon : "-";
            $arr[$iden]['tgl_tinjauan'] = !empty($det->tgl_tinjauan) ? MyFormatter::formatDateTimeForUser($det->tgl_tinjauan) : "-";
            
            $modPegawai = PegawaiM::model()->findByPk($det->pegawai_id);
            $arr[$iden]['nama_pegawai'] = !empty($modPegawai->namaLengkap) ? $modPegawai->namaLengkap : "-";
            
            $arr[$iden]['rpn_sisa'] = !empty($det->rpn_sisa) ? $det->rpn_sisa : "-";
            $arr[$iden]['laporansingkat'] = !empty($det->laporansingkat) ? $det->laporansingkat : "-";
            
            $cekLookup3 = LookupM::model()->findByAttributes(array('lookup_type' => 'status_riskregister', 'lookup_value' => $det->status_riskregister));
            $arr[$iden]['status_riskregister'] = !empty($cekLookup3->lookup_name) ? $cekLookup3->lookup_name : "-";
        }
        
        ksort($arr);
        
        return $data = array(
            'tabel'=>$arr,
            'pages' => $pages);
    }

}

?>
