<?php
class LAPencucianlinenT extends PencucianlinenT
{
	public $pegpenerima_nama, $pegmengetahui_nama;
	public $tgl_awal, $tgl_akhir, $instalasi_id, $ruangan_id;
	public $penyimpananlinendet_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PencucianlinenT the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->select = "t.pencucianlinen_id, t.nopencucianlinen, t.tglpencucianlinen, 
		t.keterangan_pencucianlinen, penyimpananlinendet_t.penyimpananlinendet_id,
		t.is_cuciulang";

		$criteria->join = " LEFT JOIN penyimpananlinendet_t ON penyimpananlinendet_t.pencucianlinen_id = t.pencucianlinen_id";
		$criteria->addBetweenCondition('DATE(tglpencucianlinen)', $this->tgl_awal, $this->tgl_akhir, true);
		if (!empty($this->pencucianlinen_id)) {
			$criteria->addCondition('pencucianlinen_id = ' . $this->pencucianlinen_id);
		}
		if (!empty($this->perawatanlinen_id)) {
			$criteria->addCondition('perawatanlinen_id = ' . $this->perawatanlinen_id);
		}
		//		$criteria->compare('LOWER(tglpencucianlinen)',strtolower($this->tglpencucianlinen),true);
		$criteria->compare('LOWER(nopencucianlinen)', strtolower($this->nopencucianlinen), true);
		$criteria->compare('LOWER(keterangan_pencucianlinen)', strtolower($this->keterangan_pencucianlinen), true);
		if (!empty($this->petugas_id)) {
			$criteria->addCondition('petugas_id = ' . $this->petugas_id);
		}
		if (!empty($this->pegpenerima_id)) {
			$criteria->addCondition('pegpenerima_id = ' . $this->pegpenerima_id);
		}
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		if (!empty($this->create_loginpemakai_id)) {
			$criteria->addCondition('create_loginpemakai_id = ' . $this->create_loginpemakai_id);
		}
		if (!empty($this->update_loginpemakai_id)) {
			$criteria->addCondition('update_loginpemakai_id = ' . $this->update_loginpemakai_id);
		}
		if (!empty($this->create_ruangan)) {
			$criteria->addCondition('create_ruangan = ' . $this->create_ruangan);
		}

		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function getRuanganIns($pencucianlinen_id, $ins)
	{
		$ruanganIns = '';
		$modCuciDet = PencuciandetailT::model()->findByAttributes(array('pencucianlinen_id' => $pencucianlinen_id));
		if (!empty($modCuciDet)) {
			$modPerDetail = PenerimaanpencucianlinenV::model()->findByAttributes(array('penerimaanlinen_id' => $modCuciDet->penerimaanlinen_id));
			if (!empty($modPerDetail)) {
				if ($ins == 'ruangan') {
					$ruanganIns = $modPerDetail->ruangan_nama;
				} else {
					$ruanganIns = $modPerDetail->instalasi_nama;
				}
			}
		}
		return $ruanganIns;
	}

	public function getCuciUlang($pencucianlinen_id, $is_cuciulang)
	{
		// if ($is_cuciulang === false) {
		// 	echo 'false';
		// } else if ($is_cuciulang === true) {
		// 	echo "true";
		// } else if (is_null($is_cuciulang)) {
		// 	echo "null";
		// }
		$tblPenyimpananlinendetT = PenyimpananlinendetT::model()->findByAttributes(array('pencucianlinen_id' => $pencucianlinen_id));
		if(($is_cuciulang === false || is_null($is_cuciulang)) && $tblPenyimpananlinendetT){
			echo CHtml::link("<i class='icon-cucilinen'></i>",
			Yii::app()->controller->createUrl("/laundry/informasiPencucianLinen/formCuciUlang",array("id"=>$pencucianlinen_id)), 
			array('rel'=>'tooltip','title'=>'Form Cuci Ulang')); 
		}else{
			echo "Sudah Dicuci";
		}
	}
}
