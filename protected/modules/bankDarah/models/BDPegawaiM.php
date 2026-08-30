<?php

/**
 * Model data pegawai pada modul Bank Darah
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package    application.modules.bankDarah
 * @subpackage models
 */
class BDPegawaiM extends PegawaiM
{
    
    public $nama_pemakai;
    public $new_password;
    public $new_password_repeat;  
    public $ruangan_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
	 */
    public $tempPhoto;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * menampilkan tenaga laboratorium
	 * @param type $ruangan_id
	 */
	public function getTenagaLaboratoriums($ruangan_id = null){
		$criteria = new CDbCriteria();
		$criteria->addCondition("kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_LAB);
		if(!empty($ruangan_id)){
			$criteria->join = "JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = t.pegawai_id";
			$criteria->addCondition("ruanganpegawai_m.ruangan_id = ".$ruangan_id);
		}
		$models = self::model()->findAll($criteria);
		if(count((array)$models) > 0){
			return $models;
		}else{
			return array();
		}
	}
	
    /**
     * Pencarian untuk dialog Pegawai.
     * 
     * @return \CActiveDataProvider
     */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('gelarbelakang');
                $criteria->join = "JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = t.pegawai_id";
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai), true);
		$criteria->compare('LOWER(gelarbelakang.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
        $criteria->addCondition("ruanganpegawai_m.ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
		
		// $criteria->limit = 5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			// 'pagination'=>false,
		));
	}
    
    /**
     * Pencarian Petugas Verifikator, Menyerahkan, dan Trasporter untuk 
     * transaksi Penyerahan Darah
     * 
     * @return \CActiveDataProvider
     */
    public function searchDialogPenyerahanDarah() {
        $prov = $this->search();
        $prov->criteria->join = 'left join ruanganpegawai_m pr on pr.pegawai_id = t.pegawai_id';
        $prov->criteria->compare('pr.ruangan_id', $this->ruangan_id);
        
        return $prov;
    }

}