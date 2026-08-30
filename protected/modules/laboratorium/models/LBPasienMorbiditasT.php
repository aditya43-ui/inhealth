<?php

class LBPasienMorbiditasT extends PasienmorbiditasT
{
	public $diagnosa_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function diagnosa($pendaftaran_id){
		$criteria = new CDbCriteria();
		$criteria->select = 'd.diagnosa_nama';
		$criteria->join = 'JOIN diagnosa_m d ON t.diagnosa_id = d.diagnosa_id';
		$criteria->addCondition('kelompokdiagnosa_id = ' . Params::KELOMPOKDIAGNOSA_UTAMA . ' and pendaftaran_id = ' . $pendaftaran_id);
		$query = LBPasienMorbiditasT::model()->findAll($criteria);

		$ket = [];
		$diagnosa_nama = '-';
		if (count((array)$query) > 0) {
			foreach ($query as $key => $value) {
				if ($key === 0) {
					$diagnosa_nama = $value->diagnosa_nama;
				}
				
				$title = '- ' . $value->diagnosa_nama .'<br>';
				array_push($ket, $title);
			}
			// echo '<pre>';
			// var_dump($ket);
		}else{
			$ket = '';
		}
		$arr = ['- a', '- b', '- c'];
		return implode("<br>",$ket);
	}

}