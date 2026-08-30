<?php

class PPAsuransipasienbadakM extends PPAsuransipasienM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsuransipasienM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	* mengambil data jenis status hubungan keluarga
	* @param type $penjamin_id
	*/
   public function getDropdownStatushubungankeluarga($penjamin_id = null)
   {
		$criteria = new CdbCriteria();
		$criteria->addCondition("lookup_type = 'statuskeluargaasuransi'");
		$criteria->addCondition('lookup_aktif = true');
		if($penjamin_id == Params::PENJAMIN_ID_PROKESPEN){
			$criteria->addCondition("lookup_name != 'Anak'"); // LNG-3
		}
		return LookupM::model()->findAll($criteria);
   }


}