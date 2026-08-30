<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SMSUserActiveCommand
 *
 * @author root
 */
class SMSUserActiveCommand extends CConsoleCommand {
	public function run($args) {
		
		$c = new CDbCriteria();
		$c->addCondition("now()::date - lastlogin::date > 30 and pegawai_id is not null and loginpemakai_aktif = true");
		$u = LoginpemakaiK::model()->findAll($c);
		
		$t = Yii::app()->db->beginTransaction();
		
		foreach ($u as $item) {
			$item->loginpemakai_aktif = false;
			$item->update();
			
			$p = PegawaiM::model()->findByPk($item->pegawai_id);
			
			$this->kirimSMS($p, $item);
		}
		
		$t->commit();
		
		echo count($u)."\n";
	}
	
	public function kirimSMS($pegawai, $pemakai)
	{
		$no_hp = $pegawai->nomobile_pegawai;
		if (empty($no_hp)) $no_hp = $pegawai->notelp_pegawai;
		if (empty($no_hp)) return false;
		
		$dat = "Pemakai atas nama '".$pemakai->nama_pemakai."' telah dinonaktifkan. "
				. "Untuk mengaktifkan kembali, hubungi admin SIMRS.";

		$model = new Outbox;
		$model->CreatorID = "simrs";

		$model->UDH = "";
		$model->DestinationNumber = $no_hp;
		$model->TextDecoded = $dat;

		$model->save();
	}
}
