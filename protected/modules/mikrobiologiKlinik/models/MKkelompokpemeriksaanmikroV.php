<?php
/**
 * Model extend pasienkirimkeunitlain_t di modul mikrobiologi klinik
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage models
 * @category model
 */
class MKkelompokpemeriksaanmikroV extends KelompokpemeriksaanmikroV {

      /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokpemeriksaanmikroV the static model class
     */
	public $tgl_awal,$tgl_akhir,$status_kirim;

     public function searchMikro()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tgl_pemeriksaan)',$this->tgl_awal,$this->tgl_akhir);
    
		$criteria->compare('kelompokpemeriksaanmikro_id',$this->kelompokpemeriksaanmikro_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('no_lab',$this->no_lab,true);
		$criteria->compare('is_pemeriksaancci',$this->is_pemeriksaancci);
		$criteria->compare('is_pemeriksaanpcr',$this->is_pemeriksaanpcr);
		$criteria->compare('is_pemeriksaantbc',$this->is_pemeriksaantbc);
		$criteria->compare('is_pemeriksaankultur',$this->is_pemeriksaankultur);
		$criteria->compare('is_pemeriksaanpewarnaan',$this->is_pemeriksaanpewarnaan);
		$criteria->compare('is_pemeriksaanviralload',$this->is_pemeriksaanviralload);
		$criteria->compare('is_kirimhasil',$this->is_kirimhasil);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('samplelab_nama',$this->samplelab_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
