<?php

class TutupJadwalDokterController extends MyAuthController
{
	public function actionAutocompleteDokter()
	{
		//$this->render('autocompleteDokter');
	}

	public function actionIndex()
	{
		$model = new TutupjadwaldokterT;
		$model->unsetAttributes();

		$model->periodeawal_tutupjadwal = date('Y-m-d');
		$model->periodeakhir_tutupjadwal = date('Y-m-d');
		$model->no_tutupjadwaldokter = MyGenerator::noTutupJadwalDokter();


		if (isset($_POST['TutupjadwaldokterT'])) {
			$trans = Yii::app()->db->beginTransaction();
			$ok = true;

			try {
				$model->attributes = $_POST['TutupjadwaldokterT'];
				$model->create_time = $model->update_time = date('Y-m-d H:i:s');
				$model->create_loginpemakai_id = $model->update_loginpemakai_id = Yii::app()->user->id;
	
				if ($model->validate()) {
					$ok = $ok && $model->save();
				} else {
					$ok = false;
				}
	
				if (isset($_POST['JadwaldokterM'])) {
					foreach ($_POST['JadwaldokterM'] as $jadwaldokter_id => $item) {
						//var_dump(!isset($item['ceklis']), $item['ceklis'] != 1);
						if (!isset($item['ceklis']) || (int)$item['ceklis'] != 1) {
							continue;
						}
	
						$jadwal_lama = JadwaldokterM::model()->findByPk($jadwaldokter_id);
						if (empty($jadwal_lama)) {
							continue;
						}
						
						$jadwal_baru = new JadwaldokterM;
						$jadwal_baru->attributes = $jadwal_lama->attributes;
						$jadwal_baru->attributes = $item;
						$jadwal_baru->jadwaldokter_id = null;
						$jadwal_baru->jadwaldokter_tgl = MyFormatter::formatDateTimeForDb($jadwal_baru->jadwaldokter_tgl);
						$jadwal_baru->create_time = $jadwal_baru->update_time = date('Y-m-d H:i:s');
	
						if ($jadwal_baru->validate()) {
							$ok = $ok && $jadwal_baru->save();
							$jadwal_lama->jadwaldokterpengganti_id = $jadwal_baru->jadwaldokter_id;
							$jadwal_lama->tutupjadwaldokter_id = $model->tutupjadwaldokter_id;
	
							$ok = $ok && $jadwal_lama->save();
						}
					}
				}
	
				if ($ok) {
					$trans->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('index'));
					//$this->refresh();
				} else {
					var_dump($model->getErrors());die;
					$trans->rollback();
					Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
				}

			} catch (Exception $exc) {
				$trans->rollback();
				Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.'.$exc->getMessage());
			}
		}

		$this->render('index', array(
			'model'=>$model,
		));
	}

	public function actionLoadJadwal()
	{
		if (!Yii::app()->request->isAjaxRequest) {
			Yii::app()->end();
		}

		$ok = 1;
		$msg = "";

		$tgl_awal = MyFormatter::formatDateTimeForDb($_POST['TutupjadwaldokterT']['periodeawal_tutupjadwal']);
		$tgl_akhir = MyFormatter::formatDateTimeForDb($_POST['TutupjadwaldokterT']['periodeakhir_tutupjadwal']);
		$pegawai_id = $_POST['TutupjadwaldokterT']['pegawai_id'];

		$cr = new CDbCriteria;
		$cr->addCondition('tutupjadwaldokter_id is null');
		$cr->compare('pegawai_id', $pegawai_id);
		$cr->addBetweenCondition('jadwaldokter_tgl::date', $tgl_awal, $tgl_akhir);
		$cr->order = 'jadwaldokter_tgl';

		$jadwal = JadwaldokterM::model()->findAll($cr);

		if (count($jadwal) == 0) {
			echo CJSON::encode(array(
				'ok'=>0,
				'msg'=>'Jadwal Tidak Ditemukan',
			));
			Yii::app()->end();
		}

		$html = "";

		foreach ($jadwal as $idx => $item) {
			$item->pegawai_id = null;
			$html .= $this->renderPartial('_rowJadwal', array(
				'idx'=>$idx,
				'model'=>$item,
				'pegawai_id'=>$pegawai_id,
			), true);
		}

		echo CJSON::encode(array(
			'ok'=>$ok,
			'msg'=>$msg,
			'html'=>$html,
		));
	}

}