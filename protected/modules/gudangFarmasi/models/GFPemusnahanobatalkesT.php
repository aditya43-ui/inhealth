<?php
class GFPemusnahanobatalkesT extends PemusnahanobatalkesT
{
        public $pegawaimengetahui_nama;
        public $pegawaimenyetujui_nama;
        public $instalasiasal_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemusnahanobatalkesT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}