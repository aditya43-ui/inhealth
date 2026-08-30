<?php
class AGAlokasianggaranT extends AlokasianggaranT
{
	public $deskripsiperiode,$sumberanggarannama,$subkegiatanprogram_nama;
	public $pegawaimengetahui_nama,$pegawaimenyetujui_nama;
	public $total_nilairencana,$total_nilaialokasi,$nilaipengeluaran;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTglPeriode()
	{
		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1));
		$criteria = new CDbCriteria();
		// $criteria->addCondition('DATE(tglanggaran) <=\''.$next_year.'\'');
		// $criteria->addCondition('DATE(sd_tglanggaran) >= \''.$next_year.'\'');
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)',strtolower($this->deskripsiperiode),true);
		$criteria->order = "sd_tglanggaran";
		$criteria->addCondition("isclosing_anggaran IS FALSE");
        $periodes = KonfiganggaranK::model()->findAll($criteria);
		foreach($periodes as $i => $periode){
			$periodes[$i]->deskripsiperiode = $periode->deskripsiperiode;
		}
		return $periodes;
	}
	
	/**
		 * kriteria pencarian untuk dashboard
		 * @return \CActiveDataProvider
		 */
		public function searchDashboard()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->compare('DATE(tglalokasianggaran)', date("Y-m-d"));
			$criteria->order = 'tglalokasianggaran ASC';
			$criteria->limit = 10;
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false
			));
		}

}