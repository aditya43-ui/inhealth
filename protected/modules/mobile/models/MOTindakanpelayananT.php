<?php

class MOTindakanpelayananT extends TindakanpelayananT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOTindakanpelayananT the static model class
	 */
	public $kategoritindakan_nama,$daftartindakan_kode,$daftartindakan_nama,$instalasi_nama,$ruangan_nama;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function detailRiwayatKonsul($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$criteria=new CDbCriteria;
		$criteria->group = 't.tindakanpelayanan_id,
							instalasi_m.instalasi_id,
							instalasi_m.instalasi_nama,
							ruangan_m.ruangan_id,
							ruangan_m.ruangan_nama,
							kategoritindakan_m.kategoritindakan_id,
							kategoritindakan_m.kategoritindakan_nama,
							daftartindakan_m.daftartindakan_id,
							daftartindakan_m.daftartindakan_kode,
							daftartindakan_m.daftartindakan_nama,
							t.tgl_tindakan,t.tarif_tindakan';
		$criteria->select = $criteria->group.' , SUM(t.qty_tindakan) as qty_tindakan';
		$criteria->join = 'JOIN daftartindakan_m ON t.daftartindakan_id = daftartindakan_m.daftartindakan_id
							JOIN ruangan_m ON t.ruangan_id = ruangan_m.ruangan_id
							JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
							LEFT JOIN kategoritindakan_m ON daftartindakan_m.kategoritindakan_id = kategoritindakan_m.kategoritindakan_id';
		$criteria->addCondition('komponenunit_id = '.Params::KOMPONENUNIT_ID_GIZI);
		$criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);

		$modTindakan = MOTindakanpelayananT::model()->findAll($criteria);
		
		return $modTindakan;
	}

}