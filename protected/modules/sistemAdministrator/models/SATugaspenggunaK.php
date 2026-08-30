<?php
class SATugaspenggunaK extends TugaspenggunaK
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getModul($modul_id = null)
    {
            if (empty($modul_id))
                return ModulK::model()->findAll('modul_aktif = true order by modul_nama');
            return ModulK::model()->findAll('modul_aktif = true and modul_id = '.$modul_id.' order by modul_nama');
    }

    public function getPeranPengguna()
    {
		$cri = new CDbCriteria();
		$cri->addCondition(" peranpengguna_aktif = TRUE ");
		$cri->order = " peranpenggunanama ";
		if (!Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))){				
			$cri->addNotInCondition("peranpengguna_id", Params::getAllVendor());
		}
        return PeranpenggunaK::model()->findAll($cri);
    }
    
    public function searchTugasPengguna() {
        $provider = $this->search();
        $provider->criteria->group = 'peranpengguna_id, tugas_nama, tugas_namalainnya';
        $provider->criteria->select = $provider->criteria->group;
		$provider->criteria->addCondition("tugas_nama not ilike '%otomatis%'");
		$provider->criteria->addCOndition('peranpengguna_id <> 1');
        
        return $provider;
    }
}