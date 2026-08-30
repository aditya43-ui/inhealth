<?php

class GZPenjadwalandetailT extends PenjadwalandetailT
{
    public $nama_pegawai, $jeniskelamin, $ruangan_nama, $alamat_pegawai, $instalasi_id; 
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

           $criteria=new CDbCriteria;
           $criteria->select = "t.shift_id,pegawai_m.pegawai_id, pegawai_m.nama_pegawai, pegawai_m.jeniskelamin, pegawai_m.alamat_pegawai, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.instalasi_id";
           $criteria->group = $criteria->select;
           $criteria->join = " JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id "
                   . "JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_id";
          
           if(!empty($this->shift_id)){
                $criteria->addCondition('t.shift_id = '.$this->shift_id);
            }
            if(!empty($this->ruangan_id)){
                $criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
            }
           
            $criteria->limit=10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}
?>
