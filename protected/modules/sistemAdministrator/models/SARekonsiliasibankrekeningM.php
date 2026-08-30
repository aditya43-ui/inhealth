<?php
class SARekonsiliasibankrekeningM extends RekonsiliasibankrekeningM
{
	public $jenisrekonsiliasibank_nama,$jenisrekonsiliasibank_namalain, $rekening_debit, $rekeningKredit, $jnsNama,
			$rekDebit,$rekKredit;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchRekonsiliasi()
	{

		$criteria=new CDbCriteria;

		if(!empty($this->rekonsiliasibankrekening_id)){
			$criteria->addCondition('rekonsiliasibankrekening_id = '.$this->rekonsiliasibankrekening_id);
		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		if(!empty($this->jenisrekonsiliasibank_id)){
			$criteria->addCondition('jenisrekonsiliasibank_id = '.$this->jenisrekonsiliasibank_id);
		}
		$criteria->select = 't.jenisrekonsiliasibank_id';
		$criteria->group='t.jenisrekonsiliasibank_id';

		$criteria->join ="
					JOIN jenisrekonsiliasibank_m ON t.jenisrekonsiliasibank_id = jenisrekonsiliasibank_m.jenisrekonsiliasibank_id
					JOIN rekening5_m ON t.rekening5_id = rekening5_m.rekening5_id";		

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}	
}