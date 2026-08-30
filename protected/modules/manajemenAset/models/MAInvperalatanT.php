
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvperalatanT extends InvperalatanT
{
    public $barang_nama;
    public $peralatankecuali_id;
    public $tgl_awal, $tgl_akhir, $lokaiaset_namalokasi;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchDialog() {
        $criteria=new CDbCriteria;
        $criteria->select = "t.*, la.lokasiaset_namalokasi";
        $criteria->join = " LEFT JOIN lokasiaset_m la ON la.lokasi_id = t.lokasi_id ";
	$criteria->compare('t.invperalatan_id',$this->invperalatan_id);
	$criteria->compare('t.lokasi_id',$this->lokasi_id);
	$criteria->compare('t.barang_id',$this->barang_id);
	$criteria->compare('t.asalaset_id',$this->asalaset_id);
	$criteria->compare('t.pemilikbarang_id',$this->pemilikbarang_id);
	$criteria->compare('LOWER(t.invperalatan_kode)',strtolower($this->invperalatan_kode),true);
	$criteria->compare('LOWER(t.invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
	$criteria->compare('LOWER(t.invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
	$criteria->compare('LOWER(t.invperalatan_merk)',strtolower($this->invperalatan_merk),true);
	$criteria->compare('LOWER(t.invperalatan_ukuran)',strtolower($this->invperalatan_ukuran),true);
	$criteria->compare('LOWER(t.invperalatan_bahan)',strtolower($this->invperalatan_bahan),true);
	$criteria->compare('LOWER(t.invperalatan_thnpembelian)',strtolower($this->invperalatan_thnpembelian),true);
	$criteria->compare('LOWER(t.invperalatan_tglguna)',strtolower($this->invperalatan_tglguna),true);
	$criteria->compare('LOWER(t.invperalatan_nopabrik)',strtolower($this->invperalatan_nopabrik),true);
	$criteria->compare('LOWER(t.invperalatan_norangka)',strtolower($this->invperalatan_norangka),true);
	$criteria->compare('LOWER(t.invperalatan_nomesin)',strtolower($this->invperalatan_nomesin),true);
	$criteria->compare('LOWER(t.invperalatan_nopolisi)',strtolower($this->invperalatan_nopolisi),true);
	$criteria->compare('LOWER(t.invperalatan_nobpkb)',strtolower($this->invperalatan_nobpkb),true);
	$criteria->compare('t.invperalatan_harga',$this->invperalatan_harga);
	$criteria->compare('t.invperalatan_akumsusut',$this->invperalatan_akumsusut);
	$criteria->compare('LOWER(t.invperalatan_ket)',strtolower($this->invperalatan_ket),true);
	$criteria->compare('LOWER(t.invperalatan_kapasitasrata)',strtolower($this->invperalatan_kapasitasrata),true);
	$criteria->compare('t.invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
	$criteria->compare('LOWER(t.invperalatan_serftkkalibrasi)',strtolower($this->invperalatan_serftkkalibrasi),true);
	$criteria->compare('t.invperalatan_umurekonomis',$this->invperalatan_umurekonomis);
	$criteria->compare('LOWER(t.invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
	$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
	$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
	$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
	$criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
	$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
        if (!empty($this->ruangan_id)){
            $criteria->addCondition(" t.ruangan_id = ".$this->ruangan_id."  ");
        }
        
        if (!empty($this->default)){
            $criteria->addCondition(" invperalatan_id IS NULL ");
        }
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }  


    public function searchInformasi(){     
        $criteria=new CDbCriteria;
        $criteria->with = array('pemilik','ruangan');
        

        if (!empty($this->pemilikbarang_id)){
            $criteria->addCondition("pemilik.pemilikbarang_id = '".$this->pemilikbarang_id."' ");
        } 

        if (!empty($this->create_ruangan)){
            $criteria->compare("t.ruangan_id", $this->create_ruangan);
        } 
        
        if (!empty($this->lokasi_id)){
            $criteria->compare("t.lokasi_id", $this->lokasi_id);
        } 
        
        $criteria->addCondition("tglpenghapusan is null and tipepenghapusan is null");
        
        $criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
        $criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));

    }
    
    public function searchDialogPeralatan() {
        $criteria=new CDbCriteria;
        $criteria->with = array('pemilik','ruangan');
        

        if (!empty($this->pemilikbarang_id)){
            $criteria->addCondition("pemilik.pemilikbarang_id = '".$this->pemilikbarang_id."' ");
        } 

        if (!empty($this->ruangan_id)){
            $criteria->compare("t.ruangan_id", $this->ruangan_id);
        } 
        
        if (!empty($this->peralatankecuali_id)) {
            $kecuali = explode(".", $this->peralatankecuali_id);
            $criteria->addNotInCondition('invperalatan_id', $kecuali);
        }
        
        if (!empty($this->default)){
            $criteria->addCondition(" invperalatan_id IS NULL ");
        }
        
        if (!empty($this->lokasi_id)){
            $criteria->addCondition(" lokasi_id = ".$this->lokasi_id);
        }
        
        $criteria->addCondition("tglpenghapusan is null and tipepenghapusan is null");

        $criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
        $criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    public function searchPeralatanNilaiPerolehan() {
        $criteria=new CDbCriteria;
        $criteria->join = " JOIN barang_m b ON b.barang_id = t.barang_id ";
        $criteria->select = [
            'DISTINCT(t.barang_id)',
            'b.barang_nama',
            't.invperalatan_kode',
            't.invperalatan_harga'
        ];
        $criteria->group = "   
            t.barang_id,
            b.barang_nama,
            t.invperalatan_kode,
            t.invperalatan_harga
        ";
        $criteria->order = " t.invperalatan_harga DESC  ";
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }
    
    /**
     * 
     * @return \CActiveDataProvider
     */
    public function searchDashboardInvenBaru(){
        $criteria=new CDbCriteria;
        $criteria->join = " JOIN lokasiaset_m lok ON lok.lokasi_id = t.lokasi_id ";
        $criteria->select = [
            'invperalatan_namabrg',
            'lok.lokasiaset_namalokasi'
        ];
        $criteria->group = "invperalatan_namabrg, lok.lokasiaset_namalokasi,DATE(t.create_time)";
        $criteria->addBetweenCondition("t.create_time", $this->tgl_awal, $this->tgl_akhir);
        $criteria->order = " DATE(t.create_time) DESC  ";
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }
}
?>
