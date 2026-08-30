<?php

class ROKarcisV extends KarcisV
{
        public $is_pilihkarcis; //untuk chekbox di form
        public $satuantindakan; //untuk form diinsert ke tindakanpelayanan_t
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KarcisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}