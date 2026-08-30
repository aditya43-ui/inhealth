<?php

class HDLaporanaustralasiantriageV extends LaporanaustralasiantriageV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanaustralasiantriageV the static model class
	 */
	public $tgl_awal,$tgl_akhir;
	public $jumlah,$data;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchGrafik() {
        
		$sql = "select count(pendaftaran_t.pendaftaran_id) as jumlah, kelompokumur_m.kelompokumur_nama as data
				from pendaftaran_t
				join pasien_m on pasien_m.pasien_id = pendaftaran_t.pasien_id
				join kelompokumur_m on pendaftaran_t.kelompokumur_id = kelompokumur_m.kelompokumur_id
				join (select distinct triase_id, pendaftaran_id,tglanamnesis from anamnesa_t order by tglanamnesis desc) as austriase
				join triase_m on triase_m.triase_id = austriase.triase_id
				on austriase.pendaftaran_id = pendaftaran_t.pendaftaran_id
				where pendaftaran_t.instalasi_id = 3
				and pendaftaran_t.tgl_pendaftaran BETWEEN '".$this->tgl_awal." 00:00:00' AND '".$this->tgl_akhir." 23:59:59'
				group by kelompokumur_m.kelompokumur_nama,pendaftaran_t.tgl_pendaftaran
				order by kelompokumur_m.kelompokumur_nama
				";

		$result = Yii::app()->db->createCommand($sql)->queryAll();

		return new CSqlDataProvider($sql, array('keyField' => 'jumlah','pagination'=>false));

    }

}