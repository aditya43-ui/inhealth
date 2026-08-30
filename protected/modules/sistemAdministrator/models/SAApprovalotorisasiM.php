<?php

/**
 */
class SAApprovalotorisasiM extends ApprovalotorisasiM
{
    public $nama_pemakai;
    public $jeniskelamin;
    public $nama_pegawai;
    public $namaLengkap;
    public $pegawai_id;
    public $nomorindukpegawai;
    public $jabatan_id;
    public $bagiankepegawaian_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SAAlatfingerM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchKonfigSystemApproval()
	{
		// echo "wewewe";
		$criteria=new CDbCriteria;
                // $criteria->select = "approvalotorisasi_id, kepalagizi_id, kepalafarmasi_id, kepalaumum_id, kasipersonalia_id, managerumum_id, managerkeuangan_id, direkturrs_id, direkturpt_id'";
                // $criteria->group = $criteria->select;
                // $criteria->join = " JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = t.pegawai_id"
                //         . " JOIN ruangan_m ON ruangan_m.ruangan_id = ruanganpegawai_m.ruangan_id";
                // $criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
                // $criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
                // $criteria->compare('t.pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
                // $criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
                // if(!empty($this->jabatan_id)){
                //     $criteria->compare('t.jabatan_id',$this->jabatan_id);
                // }
                // $criteria->addInCondition("ruangan_m.ruangan_id", array(Params::RUANGAN_ID_GUDANG_FARMASI, Params::RUANGAN_ID_APOTEK_1));
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
}