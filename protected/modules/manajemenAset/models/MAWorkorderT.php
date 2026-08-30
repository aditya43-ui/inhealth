<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan untuk menampilkan data pada tabel workorder_t
* RSST-1584
*/

class MAWorkorderT extends WorkorderT
{     
    public $invperalatan_namabrg, $invperalatan_kode, $lokasiaset_namalokasi;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * 
     * @return \CActiveDataProvider
     */
    public function searchDashboardWo(){
        $criteria=new CDbCriteria;
        $criteria->join = " JOIN invperalatan_t inv ON inv.invperalatan_id = t.invperalatan_id "
                        . " JOIN lokasiaset_m lok ON lok.lokasi_id = t.lokasi_id";
        $criteria->select = [
            'inv.invperalatan_namabrg',
            'inv.invperalatan_kode',
            'lok.lokasiaset_namalokasi',
            't.status_pemeliharaan'
        ];
        $criteria->order = "t.create_time DESC";
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,      
            'pagination'=>false
        ));
    }
}
?>
