<?php
class HDCarakeluarM extends CarakeluarM
{
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function getCarakeluarItems()
        {
            return $this->findAll('carakeluar_aktif=TRUE ORDER BY carakeluar_nama');
        }
}