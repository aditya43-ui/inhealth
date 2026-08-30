<?php

class ADRenkebbarangT extends RenkebbarangT
{
	public $leadtime_lt,$pegmenyetujui_nama,$pegmengetahui_nama;
        public $jns_periode; 
        public $tgl_awal, $tgl_akhir;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $barang_nama, $jmlpermintaanbarangdet, $harga_barangdet;
        public $data, $jumlah;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function searchRencanaKebutuhan()
        {
                $criteria=new CDbCriteria;

                $criteria->select='t.renkebbarang_tgl, t.renkebbarang_no, t.ruangan_id, b.barang_nama, d.jmlpermintaanbarangdet,(d.harga_barangdet * d.jmlpermintaanbarangdet) as harga_barangdet';
                $criteria->group = 't.renkebbarang_tgl, t.renkebbarang_no, b.barang_nama, t.ruangan_id,d.jmlpermintaanbarangdet,d.harga_barangdet';
                $criteria->join = 'LEFT JOIN renkebbarangdet_t d ON d.renkebbarang_id = t.renkebbarang_id LEFT JOIN barang_m b ON b.barang_id=d.barang_id';
                $criteria->addBetweenCondition('date(t.renkebbarang_tgl)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->compare('LOWER(t.renkebbarang_no)',strtolower($this->renkebbarang_no),true);
                if(!empty($this->ruangan_id)){
                        $criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
                }
                $criteria->order = "t.renkebbarang_tgl ASC";
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        public function searchRencanaKebutuhanPrint()
        {
                $criteria=new CDbCriteria;

                $criteria->select='t.renkebbarang_tgl, t.renkebbarang_no, t.ruangan_id, b.barang_nama, d.jmlpermintaanbarangdet,(d.harga_barangdet * d.jmlpermintaanbarangdet) as harga_barangdet';
                $criteria->group = 't.renkebbarang_tgl, t.renkebbarang_no, b.barang_nama, t.ruangan_id,d.jmlpermintaanbarangdet,d.harga_barangdet';
                $criteria->join = 'LEFT JOIN renkebbarangdet_t d ON d.renkebbarang_id = t.renkebbarang_id LEFT JOIN barang_m b ON b.barang_id=d.barang_id';
                $criteria->addBetweenCondition('date(t.renkebbarang_tgl)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->compare('LOWER(t.renkebbarang_no)',strtolower($this->renkebbarang_no),true);
                if(!empty($this->ruangan_id)){
                        $criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
                }
                $criteria->order = "t.renkebbarang_tgl ASC";
                
                $criteria->limit = -1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination' => false
                ));
        }
        
        public function searchGrafik()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;

                $criteria->select = 'sum(d.jmlpermintaanbarangdet) as jumlah, b.barang_nama as data';
                $criteria->group = 'b.barang_nama';
                $criteria->join = 'LEFT JOIN renkebbarangdet_t d ON d.renkebbarang_id = t.renkebbarang_id LEFT JOIN barang_m b ON b.barang_id=d.barang_id';
                $criteria->addBetweenCondition('date(t.renkebbarang_tgl)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->ruangan_id);
                $criteria->compare('t.renkebbarang_no',$this->renkebbarang_no);
                $criteria->order = "jumlah DESC";

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
}