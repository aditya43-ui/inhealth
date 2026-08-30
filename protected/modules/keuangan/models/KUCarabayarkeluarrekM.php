<?php
class KUCarabayarkeluarrekM extends CarabayarkeluarrekM
{
    public $kdrekening5, $nmrekening5, $rekening4_id,$rekening3_id, $rekening2_id, $rekening1_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}

?>