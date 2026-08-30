<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan untuk menampilkan data pada tabel Infopengeluaranaset_V pada modul manajemen aset
* RSST-1640
*/

class MAInfopengeluaranasetV extends InfopengeluaranasetV
{     
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function searchPengeluaranAset(){
        $criteria=new CDbCriteria;
        $criteria->select = " t.*, tp.tglterima ";
        $criteria->join = "  JOIN invperalatan_t ip ON ip.invperalatan_id = t.invperalatan_id "
                        . "  LEFT JOIN terimapersdetail_t tpdet ON tpdet.terimapersdetail_id = ip.terimapersdetail_id "
                        . "  LEFT JOIN terimapersediaan_t tp ON tpdet.terimapersediaan_id = tp.terimapersediaan_id ";
        $criteria->addCondition(" ip.tglpenghapusan is NULL ");
        $criteria->addBetweenCondition("DATE(t.tglpengeluaranaset)", MyFormatter::formatDateTimeForDb($this->tgl_awal), MyFormatter::formatDateTimeForDb($this->tgl_akhir));
        
        if (!empty($this->jenisperuntukan)){
            $criteria->addCondition(" t.jenisperuntukan = '".$this->jenisperuntukan."' ");
        }        
        $criteria->compare(" LOWER(t.nopengeluaranaset)",strtolower($this->nopengeluaranaset),true);
        
        
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }
    public function searchInformasi(){
        $criteria=new CDbCriteria;
       
         $criteria->select = "t.nopengeluaranaset,t.tglpengeluaranaset,t.jenisperuntukan,t.no_suratperintah,t.tglsuratperintah,t.tglpenyerahan,t.alasan_pengeluaran,t.pengeluaran_nama,t.pengeluaranaset_id";
         $criteria->group = 't.nopengeluaranaset,t.tglpengeluaranaset,t.jenisperuntukan,t.no_suratperintah,t.tglsuratperintah,t.tglpenyerahan,t.alasan_pengeluaran,t.pengeluaran_nama,t.pengeluaranaset_id';
        $criteria->addBetweenCondition("DATE(t.tglpengeluaranaset)", MyFormatter::formatDateTimeForDb($this->tgl_awal), MyFormatter::formatDateTimeForDb($this->tgl_akhir));
        
        if (!empty($this->jenisperuntukan)){
            $criteria->addCondition(" t.jenisperuntukan = '".$this->jenisperuntukan."' ");
        }
$criteria->compare(" LOWER(t.no_suratperintah)",strtolower($this->no_suratperintah),true);        
        $criteria->compare(" LOWER(t.nopengeluaranaset)",strtolower($this->nopengeluaranaset),true);
        $criteria->compare(" LOWER(t.pengeluaran_nama)",strtolower($this->pengeluaran_nama),true);
        
        
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }
}
?>
