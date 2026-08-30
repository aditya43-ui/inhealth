<?php
Yii::import('keuangan.controllers.MasterBankController');
Yii::import('keuangan.models.*');
class MasterBankAKController extends MasterBankController
{
	public function init(){
		if (isset($_GET['tab'])){
			if ($_GET['tab'] == 'frame'){
				$this->layout='//layouts/iframe';
			}
		}
	}

	public function getUrlBank(){
		return $this->module->id.'/BankMAK/Admin';
	}

	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlBankLookup(){
		return $this->module->id.'/BankLookupAK/Admin';
	}
}
