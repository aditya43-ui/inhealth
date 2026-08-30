<?php

class GFPegawaiM extends PegawaiM
{
    
    public $nama_pemakai;
    public $new_password;
    public $new_password_repeat;  
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

        public function searchKonfigSystemFarmasi()
	{
		$criteria=new CDbCriteria;
                $criteria->select = "t.pegawai_id, t.nama_pegawai, t.nomorindukpegawai, t.jeniskelamin, t.jabatan_id";
                $criteria->group = $criteria->select;
                $criteria->join = " JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = t.pegawai_id"
                        . " JOIN ruangan_m ON ruangan_m.ruangan_id = ruanganpegawai_m.ruangan_id";
                $criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
                $criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('t.pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
                $criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
                if(!empty($this->jabatan_id)){
                    $criteria->compare('t.jabatan_id',$this->jabatan_id);
                }
                $criteria->addInCondition("ruangan_m.ruangan_id", array(Params::RUANGAN_ID_GUDANG_FARMASI, Params::RUANGAN_ID_APOTEK_1));
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
}