<?php
/**
 * Model untuk penyerahan darah di modul Bank Darah
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @version 2.0.0
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDPenyerahandarahT extends PenyerahandarahT
{
        public $nama_pasien,$no_rekam_medik,$golongandarah,
                $no_kantongdarah,$gol_darah,$rhesus,
                $singkatan_komp,$ruangan_nama,$ujikompatibilitas_id, $rhesus_darah;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyerahandarahT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Pencarian kantong darah
         * @return \CActiveDataProvider
         */
        public function searchKantongDarah(){
            $criteria=new CDbCriteria;
            $criteria->select = 't.*,'
                    . 't.penyerahandarah_id,'
                    . 'pasien.nama_pasien,'
                    . 'pasien.no_rekam_medik,'
                    . 'pasien.golongandarah,'
                    . 'kantong.no_kantongdarah,'
                    . 'komponen.singkatan_komp,'
                    . 'uji.ujikompatibilitas_id,uji.rilis,'
                    . 'ruangan.ruangan_nama,'
                    . 'CASE WHEN kantong.penerimaandarahpmidet_id IS NULL THEN pendonor.gol_darah ELSE stok.golongan_darah END AS gol_darah ,
                       CASE WHEN kantong.penerimaandarahpmidet_id IS NULL THEN pendonor.rhesus ELSE stok.rhesus END AS rhesus_darah ';
            $criteria->join = ' LEFT JOIN penyiapandarah_t as penyiapan ON t.penyiapandarah_id=penyiapan.penyiapandarah_id '
                            . ' LEFT JOIN ujikompatibilitas_t as uji ON penyiapan.ujikompatibilitas_id=uji.ujikompatibilitas_id '
                            . ' LEFT JOIN permintaandarahdet_t as permintaandet ON uji.permintaandarahdet_id=permintaandet.permintaandarahdet_id '
                            . ' LEFT JOIN permintaandarah_t as permintaan ON permintaandet.permintaandarah_id=permintaan.permintaandarah_id '
                            . ' LEFT JOIN stokkantongdarah_t as stok ON uji.stokkantongdarah_id=stok.stokkantongdarah_id '
                            . ' LEFT JOIN kantongdarah_t as kantong ON stok.kantongdarah_id=kantong.kantongdarah_id '
                            . ' LEFT JOIN komponendarah_m as komponen ON kantong.komponendarah_id=komponen.komponendarah_id '
                            . ' LEFT JOIN pendonor_m as pendonor ON kantong.pendonor_id=pendonor.pendonor_id '
                            . ' LEFT JOIN pasien_m as pasien ON uji.pasien_id = pasien.pasien_id '
                            . ' LEFT JOIN pendaftaran_t as pendaftaran ON uji.pendaftaran_id = pendaftaran.pendaftaran_id '
                            . ' LEFT JOIN ruangan_m as ruangan ON permintaan.ruanganpemesan_id = ruangan.ruangan_id '
                            . ' LEFT JOIN returdarah_t as retur on uji.ujikompatibilitas_id = retur.ujikompatibilitas_id ';
            $criteria->group = 't.*,'
                    . 't.penyerahandarah_id,'
                    . 'pasien.nama_pasien,'
                    . 'pasien.no_rekam_medik,'
                    . 'pasien.golongandarah,'
                    . 'kantong.no_kantongdarah,'
                    . 'komponen.singkatan_komp,'
                    . 'uji.ujikompatibilitas_id,uji.rilis,'
                    . 'ruangan.ruangan_nama,'
                    . 'pendonor.gol_darah, '
                    . 'rhesus_darah,'
                    . 'penerimaandarahpmidet_id, stok.golongan_darah';
            //$criteria->addCondition("uji.rilis = 'rilis'");
            $criteria->addCondition("uji.rilis = 'Release'");
            $criteria->addCondition("retur.returdarah_id IS NULL");
            if(!empty($this->no_kantongdarah)){
                $criteria->compare("LOWER(kantong.no_kantongdarah)", strtolower($this->no_kantongdarah),true);
            }
            if(!empty($this->gol_darah)){
                $criteria->compare("LOWER(pendonor.gol_darah)", strtolower($this->gol_darah),true);
            }
            if(!empty($this->singkatan_komp)){
                $criteria->compare("LOWER(komponen.singkatan_komp)", strtolower($this->singkatan_komp),true);
            }
            if(!empty($this->rhesus)){
                $criteria->compare("LOWER(pendonor.rhesus)", strtolower($this->rhesus),true);
            }
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}