<?php
/**
* - digunakan sebagai format dasar untuk memilih jenis format isian expertise
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

$cri = new CDbCriteria();
$cri->select = "t.*, rhd.refhasildet_nama";
$cri->join =	" LEFT JOIN referensihasildet_m rhd ON rhd.refhasildet_id = t.refhasildet_id  "
			.	" LEFT JOIN referensihasilrad_m rhr ON rhd.refhasilrad_id = rhr.refhasilrad_id ";
$cri->addCondition(" rhr.refhasilrad_banyak = TRUE ");
$cri->addCondition(" t.hasilpemeriksaanrad_id = ".$model->hasilpemeriksaanrad_id." ");
$cri->order = " rhd.refhasildet_urut ";
$hasDet = ROHasilperiksaraddetT::model()->findAll($cri);
//var_dump($model->hasilpemeriksaanrad_id);
if (count((array)$hasDet) > 0){
	$this->render($this->path_view.'printTemplate.printHasilDet',array('model'=>$model, 'hasDet'=>$hasDet));
}else{
	if ($model->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_THORAX_PA){
		$this->render($this->path_view.'printTemplate.printThoraxPa',array('model'=>$model));
	}elseif ( $model->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_UPPER_LOWER_ABDOMEN || $model->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_UPPER_LOWER ){
		$this->render($this->path_view.'printTemplate.printUpperLowerAbd',array('model'=>$model));
	}elseif ($model->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_UROLOGI){
		$this->render($this->path_view.'printTemplate.printUrologi',array('model'=>$model));
	}else{
		$this->render($this->path_view.'printTemplate.print',array('model'=>$model));
	}
}