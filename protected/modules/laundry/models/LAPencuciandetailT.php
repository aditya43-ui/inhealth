<?php
class LAPencuciandetailT extends PencuciandetailT
{
	public $tgl_awal, $tgl_akhir, $instalasi_id, $ruangan_id;
	public $nopencucianlinen, $penerimaanlinen_id, $keteranganpenerimaanlinen_item;
	public $perawtanlinen_id, $kodelinen, $namalinen, $ruangan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PencuciandetailT the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function searchPencucianLinen()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$format = new MyFormatter();

		$this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);

		$criteria->limit = 1000;
		if (!Yii::app()->request->isAjaxRequest) { //data hanya muncul setelah melakukan pencarian
			$criteria->limit = 0;
		}

		$criteria->select = 'linen_m.*, t.*, pencucianlinen_t.*';

		$criteria->addBetweenCondition('DATE(pencucianlinen_t.tglpencucianlinen)', $this->tgl_awal, $this->tgl_akhir, true);
		if (!empty($this->nopencucianlinen)) {
			$criteria->compare('LOWER(pencucianlinen_t.nopencucianlinen)', strtolower($this->nopencucianlinen), true);
		}
		if (!empty($this->pencuciandetail_id)) {
			$criteria->addCondition('pencuciandetail_id = ' . $this->pencuciandetail_id);
		}
		if (!empty($this->linen_id)) {
			$criteria->addCondition('linen_id = ' . $this->linen_id);
		}
		if (!empty($this->pencucianlinen_id)) {
			$criteria->addCondition('pencucianlinen_id = ' . $this->pencucianlinen_id);
		}
		$criteria->compare('LOWER(statuspencucian)', strtolower($this->statuspencucian), true);

		$criteria->join = 'LEFT JOIN linen_m ON linen_m.linen_id = t.linen_id'
			. ' LEFT JOIN pencucianlinen_t ON pencucianlinen_t.pencucianlinen_id = t.pencucianlinen_id'
			. ' LEFT JOIN perawatanlinen_t ON perawatanlinen_t.perawatanlinen_id = t.perawatanlinen_id'
			. ' LEFT JOIN perawatanlinendetail_t ON perawatanlinendetail_t.perawatanlinen_id = perawatanlinen_t.perawatanlinen_id'
			. ' LEFT JOIN ruangan_m ON ruangan_m.ruangan_id = pencucianlinen_t.create_ruangan';

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function getRuanganAsal($penerimaanlinen_id)
	{
		$ruangan = '';
		if (!empty($penerimaanlinen_id)) {
			$modPenerimaan = PenerimaanpencucianlinenV::model()->findByAttributes(array('penerimaanlinen_id' => $penerimaanlinen_id));
			$ruangan = $modPenerimaan->ruangan_nama;
		}
		return $ruangan;
	}

	public function getDetailDataLinen($pencucianlinen_id)
	{
		$cekPencucianDetail = PencuciandetailT::model()->findByAttributes(array('pencucianlinen_id' => $pencucianlinen_id));
		$penerimaanlinen_id = 0;
		if (!empty($cekPencucianDetail)) {
			$penerimaanlinen_id = $cekPencucianDetail->penerimaanlinen_id;
		}
		$criteria = new CDbCriteria;
		$criteria->addCondition('penerimaanlinen_id = ' . $penerimaanlinen_id);
		return new CActiveDataProvider(PenerimaanpencucianlinenV::model(), array(
			'criteria' => $criteria,
		));
	}
}
