<?php

class PSKegiatanOperasiM extends KegiatanOperasiM
{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanOperasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getAllItems()
        {
            return $this->model()->findAll('kegiatanoperasi_aktif = true order by kegiatanoperasi_nama');
        }

	/**
	 * @return string the associated database table name
	 */
}
?>
