<?php
class PCPasienM extends PasienM
{
        public $tgl_pendaftaran_cari, $instalasi_nama, $idInstalasi, $ruangan_nama, $carabayar_nama, $no_pendaftaran; //untuk pencarian & filtering
        public $propinsiNama,$kabupatenNama,$kecamatanNama,$kelurahanNama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * searchPasienRumahsakitV menampilkan pasien rumah sakit dari view database
         * @return \CActiveDataProvider
         */
        public function searchPasienRumahsakitV(){
            $format = new MyFormatter;
            $model = null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            if(!empty($this->tgl_pendaftaran_cari)){
                $this->tgl_pendaftaran_cari = $format->formatDateTimeForDb($this->tgl_pendaftaran_cari);
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_pendaftaran_cari." 00:00:00", $this->tgl_pendaftaran_cari." 23:59:59");
            }
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
			if(!empty($this->idInstalasi)){
				$criteria->addCondition("instalasi_id = ".$this->idInstalasi);						
			}
//            $criteria->compare('LOWER(instalasi_nama)', strtolower($this->namaInstalasi), true);
            $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->limit = 10;
            $criteria->order = 'tgl_pendaftaran DESC';
            //kembalikan format
            $this->tgl_pendaftaran_cari = empty($this->tgl_pendaftaran_cari) ? null : date('d M Y',strtotime($this->tgl_pendaftaran_cari));
            if($this->idInstalasi == Params::INSTALASI_ID_RD){
                $model = new PCInfoKunjunganRDV;
            }else if($this->idInstalasi == Params::INSTALASI_ID_RJ){
                $model = new PCInfoKunjunganRJV;
            }else if($this->idInstalasi == Params::INSTALASI_ID_RI){
                $model = new PCInfopasienmasukkamarV;
            }else{
                $model = new PCInfopasienmasukkamarV; //default
            }
            return new CActiveDataProvider($model, array(
                        'criteria'=>$criteria,
						'pagination'=>false,
                ));
        }
}