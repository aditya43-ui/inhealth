<?php

class PJTindakanPelayananT extends TindakanpelayananT
{
    public $kategoritindakan_nama;
    public $daftartindakan_nama;
    public $jenistarif_id;
    public $persencyto_tindakan;
    public $subtotal;
    public $dokterpemeriksa1_nama;
    public $ppds1_nama,$ppds2_nama,$ppds3_nama,$ppds4_nama,$ppds5_nama;
    public $ppds1_id,$ppds2_id,$ppds3_id,$ppds4_id,$ppds5_id;

    public $dokterpendamping_nama;
    public $dokteranastesi_nama;
    public $dokterdelegasi_nama;
    public $dokterpemeriksa2_nama;
    public $bidan_nama;
    public $suster_nama;
    public $perawat_nama;
    public $instalasi_id;
	public $jeniskasuspenyakit_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function getTipePakets()
    {
        return TipepaketM::model()->findAllByAttributes(array('tipepaket_aktif'=>true));
    }
    
    public function getRuangans($instalasi_id=null)
    {
        $criteria = new CdbCriteria();
        if (!empty($instalasi_id)){
            $criteria->compare('instalasi_id',$instalasi_id);
        }
        $criteria->addCondition('ruangan_aktif = true');
        return RuanganM::model()->findAll($criteria);
    }

    public function search10Besar()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->compare('daftartindakan_id',124);
        $criteria->order = 'tgl_tindakan desc';
        $criteria->limit = 10;


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }
	
	public function searchDashboardPJ()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
		$criteria->select = 'pendaftaran_t.no_pendaftaran, pasien_m.nama_pasien,daftartindakan_m.daftartindakan_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,tgl_tindakan';
		$criteria->join = 'JOIN pasien_m ON pasien_m.pasien_id= t.pasien_id
							JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=t.pendaftaran_id
							JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id=daftartindakan_m.daftartindakan_id
							JOIN jeniskasuspenyakit_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id=t.jeniskasuspenyakit_id';
        $criteria->addCondition("daftartindakan_m.daftartindakan_id ='124'");
        $criteria->order = 't.tgl_tindakan desc';
        $criteria->limit = 10;


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }

}