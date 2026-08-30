<?php
class GFPegawaiV extends PegawaiV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiV the static model class
	 */
        public $ruangan_id;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchDialog()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->pegawai_id)){
				$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
			}
            $criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
            $criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
            $criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(t.nama_keluarga)',strtolower($this->nama_keluarga),true);
            $criteria->compare('LOWER(t.tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
            $criteria->compare('LOWER(t.tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
            $criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
            $criteria->compare('t.pegawai_aktif',$this->pegawai_aktif);
            $criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
            $criteria->compare('LOWER(t.golongandarah)',strtolower($this->golongandarah),true);
            $criteria->compare('LOWER(t.alamatemail)',strtolower($this->alamatemail),true);
            $criteria->compare('LOWER(t.notelp_pegawai)',strtolower($this->notelp_pegawai),true);
            $criteria->compare('LOWER(t.nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
            $criteria->compare('LOWER(t.photopegawai)',strtolower($this->photopegawai),true);
			if(!empty($this->pendidikan_id)){
				$criteria->addCondition('t.pendidikan_id = '.$this->pendidikan_id);
			}
            $criteria->compare('LOWER(t.pendidikan_nama)',strtolower($this->pendidikan_nama),true);
			if(!empty($this->pendkualifikasi_id)){
				$criteria->addCondition('t.pendkualifikasi_id = '.$this->pendkualifikasi_id);
			}
            $criteria->compare('LOWER(t.pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
            $criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
			if(!empty($this->pangkat_id)){
				$criteria->addCondition('t.pangkat_id = '.$this->pangkat_id);
			}
			if(!empty($this->kelompokpegawai_id)){
				$criteria->addCondition('t.kelompokpegawai_id = '.$this->kelompokpegawai_id);
			}
			if(!empty($this->jabatan_id)){
				$criteria->addCondition('t.jabatan_id = '.$this->jabatan_id);
			}
			//$criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    //'pagination'=>false,                    
            ));
	}
        
        public function searchDialogMengetahui() {
            $provider = $this->searchDialog();
            $provider->criteria->join = "join ruanganpegawai_m p on p.pegawai_id = t.pegawai_id";
            $provider->criteria->compare("p.ruangan_id", $this->ruangan_id);
            
            return $provider;
        }

}