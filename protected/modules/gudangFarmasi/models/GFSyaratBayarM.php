<?php


class GFSyaratBayarM extends SyaratbayarM
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
         public static function getSyaratbayarItems()
        {
            return SyaratbayarM::model()->findAll("syaratbayar_aktif=TRUE ORDER BY syaratbayar_nama");
        }

}