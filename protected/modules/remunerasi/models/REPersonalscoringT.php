<?php
class REPersonalscoringT extends PersonalscoringT
{
        public $tgl_awal, $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('DATE(t.tglscoring)',$this->tglscoring);
		// $criteria->addBetweenCondition('DATE(t.periodescoring)',$this->periodescoring,$this->sampaidengan);
		$criteria->compare('DATE(t.sampaidengan)',$this->sampaidengan);
		$criteria->compare('t.jabatan',$this->jabatan);
		$criteria->compare('t.pendidikan',$this->pendidikan);
		$criteria->compare('LOWER(pegawai_m.nama_pegawai)',$this->nama_pegawai,true);
                $criteria->join = 'JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}