<?php

class LihatHasilController extends MyAuthController
{
	public function actionHasilPeriksa($pendaftaran_id,$pasien_id,$pasienmasukpenunjang_id)
	{
            $this->layout = '//layouts/printWindows';
            
            $masukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);  
            $pemeriksa = DokterV::model()->findByAttributes(array('pegawai_id'=>$masukpenunjang->pegawai_id));
            
            $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
            $detailHasil = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id'=>$modHasilPeriksa->hasilpemeriksaanlab_id),array('order'=>'detailhasilpemeriksaanlab_id'));
            $hasil = array();
            foreach ($detailHasil as $i => $detail) {
                $jenisPeriksa = $detail->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
                $kelompokDet = $detail->pemeriksaandetail->nilairujukan->kelompokdet;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['namapemeriksaan'] = $detail->pemeriksaandetail->nilairujukan->namapemeriksaandet;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['hasil'] = $detail->hasilpemeriksaan;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['nilairujukan'] = $detail->nilairujukan;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['satuan'] = $detail->hasilpemeriksaan_satuan;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['keterangan'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan;
            }
            
            $this->render('hasilPeriksa',array('modHasilPeriksa'=>$modHasilPeriksa,
                                               'detailHasil'=>$detailHasil,
                                               'hasil'=>$hasil, 
                                               'masukpenunjang'=>$masukpenunjang,
                                               'pemeriksa'=>$pemeriksa));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}