<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan untuk menampilkan data pada tabel Prevmainten_t
* RSST-1584
*/

class MAPrevmaintenT extends PrevmaintenT
{     
    public $invperalatan_namabrg, $invperalatan_kode;
    public $lokasiaset_namalokasi;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * 
     * @return \CActiveDataProvider
     */
    public function searchDashboardPrevenBulanIni(){
        $criteria=new CDbCriteria;
        $criteria->join = " JOIN invperalatan_t inv ON inv.invperalatan_id = t.invperalatan_id "
                        . " JOIN lokasiaset_m lok ON lok.lokasi_id = inv.lokasi_id";
        $criteria->select = [
            'inv.invperalatan_namabrg',
            'inv.invperalatan_kode',
            'lok.lokasiaset_namalokasi',
            'DATE(t.tglprevmainten) as tglprevmainten'
        ];
        $criteria->addCondition(" DATE(tglprevmainten)::text ilike '".date('Y-m')."%' ");
        $criteria->order = " DATE(t.tglprevmainten) ASC  ";
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,            
        ));
    }
}
?>
