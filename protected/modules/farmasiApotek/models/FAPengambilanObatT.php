<?php

class FAPengambilanObatT extends PengambilanobatTriageT
{
	public $no_triage, $harga_satuanpakai, $biayaadministrasi, $hargasatuan_oa, $total_embalase, $totalbiayaadministrasi;
	public $nama_pasien;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengambilanobatTriageT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */

	public static function getDropTrigaePasien($pendaftaran_id) {
		$cri = new CDbCriteria();
	if ((!empty($pendaftaran_id))) {
			$cri->addCondition(" (pasien_id is NULL AND pendaftaran_id is NULL) OR pendaftaran_id =" . $pendaftaran_id);
		}else{
			$cri->addCondition("pasien_id is NULL AND pendaftaran_id is NULL");
		}
                $cri->order = "no_bed_triage ASC";
		$data = [];
		$query = NotriagePasienT::model()->findAll($cri);
		foreach ($query as $key => $value) {
			$data[$value->notriage_pasien_id] = $value->no_triage_pasien . ' - ' .$value->no_bed_triage ;
		}

		return $data;
    }

	public function getDokterItems($ruangan_id=null){
		if (Yii::app()->user->getState('dokterruangan')==false){
			if(empty($ruangan_id))
				$ruangan_id = Yii::app()->user->getState('ruangan_id');
			if(!empty($ruangan_id))
				return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
			else
				return array();
		}else{
			//criteria disamakan dengan dokter_v
			$criteria = new CDbCriteria();
			$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
			$criteria->addCondition("pegawai_aktif = TRUE");
			$criteria->order = 'nama_pegawai';
			return PegawaiM::model()->findAll($criteria);
		}
	}

	public function searchRiwayat()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pengambilanobat_triage_id',$this->pengambilanobat_triage_id);
		$criteria->compare('notriage_pasien_id',$this->notriage_pasien_id);
		$criteria->compare('noresep_triage',$this->noresep_triage,true);
		$criteria->compare('petugasfarmasi_id',$this->petugasfarmasi_id);
		$criteria->compare('petugasigd_id',$this->petugasigd_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('validasi',$this->validasi);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->addCondition('is_jual is false');
		// $criteria->order = '(CASE WHEN validasi = false THEN 0 ELSE 1 END), update_time desc';
		$criteria->order = '(CASE WHEN validasi = false THEN 0 ELSE 1 END),
		(CASE WHEN validasi = true THEN t.update_time ELSE NULL END) DESC';
		// echo '<pre>';var_dump($criteria);die;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>