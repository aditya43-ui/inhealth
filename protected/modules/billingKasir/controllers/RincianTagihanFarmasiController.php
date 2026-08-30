<?php
/**
 * digunakan untuk rincian tagihan farmasi
 * BMB-123
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.billingKasir
 * @subpackage      controllers
 *
 */
class RincianTagihanFarmasiController extends MyAuthController
{
/**
 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
 * using two-column layout. See 'protected/views/layouts/column2.php'.
 */
public $layout='//layouts/column1';
public $defaultAction = 'admin';

/**
* actionRincian untuk melihat / mencetak Rincian Tagihan Farmasi Pasien RS
* @param type $id
* @param type $caraPrint
*/
public function actionRincian($id, $caraPrint = ""){
$this->layout = '//layouts/iframe';
$format = new MyFormatter();
$data['judulHalaman'] = 'Rincian Biaya Farmasi';
$modPendaftaran = BKPendaftaranT::model()->findByPk($id);
//            $modRincian = BKRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
$criteria = new CDbCriteria();
if(!empty($id)){
$criteria->addCondition("pendaftaran_id = ".$id);
}
$criteria->addCondition('oasudahbayar_id is null');
$criteria->order = 'jenisobatalkes_nama, tglpenjualan';
$modRincian = BKInformasipenjualanaresepV::model()->findAll($criteria);
//            $modRincian = BKInformasipenjualanaresepV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'jenisobatalkes_nama, tglpenjualan'));
$data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;

if($caraPrint == 'PRINT')
{

$this->layout = '//layouts/printWindows';
$ukuranKertasPDF=Yii::app()->user->getState('ukuran_kertas');  
// $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
$mpdf=new MyPDF60('',$ukuranKertasPDF); 
$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
$mpdf->WriteHTML($stylesheet,1);
/*
* cara ambil margin
* tinggi_header * 72 / (72/25.4)
*  tinggi_header = inchi
*/
$header = 0.75 * 72 / (72/25.4);
$header_title = '
<div>&nbsp;</div>
<div style="font-family:tahoma;font-size: 8pt;">
<div style="margin-left:1px;width:100px;float:left">No. RM / Reg</div>
<div style="float:left">: '. $modPendaftaran->pasien->no_rekam_medik .' / '. $modPendaftaran->no_pendaftaran .'</div>
</div>
';
$mpdf->SetHTMLHeader($header_title);
//                $footer = '
//                <table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
//                <td width="50%"></td>
//                <td width="50%" align="right">{PAGENO} / {nb}</td>
//                </tr></table>
//                ';
//                $mpdf->SetHTMLFooter($footer);                
$mpdf->AddPage($posisi,'','','','',3,8,$header,5,0,0);
$mpdf->WriteHTML(
$this->renderPartial(
'billingKasir.views.rincianTagihanFarmasi.rincianPdf',
array(
'modPendaftaran'=>$modPendaftaran,
'modRincian'=>$modRincian,
'data'=>$data,
'format'=>$format,
'caraPrint'=>$caraPrint,
), true
)
);
$mpdf->Output();
}else{
$this->render(
'billingKasir.views.rincianTagihanFarmasi.rincian',
array(
'modPendaftaran'=>$modPendaftaran,
'modRincian'=>$modRincian,
'data'=>$data,
'format'=>$format,
'caraPrint'=>$caraPrint,
)
);
}
}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=  BKInformasipenjualanaresepV::model()->findByPk($id);
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
if(isset($_POST['ajax']) && $_POST['ajax']==='rjrinciantagihanpasien-v-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}

/**
*Mengubah status aktif
* @param type $id
*/
public function actionRemoveTemporary($id)
{
//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
}

//=====================================================================
//                Rincian Biaya Farmasi Rawat Jalan
//=====================================================================
/**
* digunakan untuk cetak rincian biaya farmasi
* @param integer $id menampung id pendaftaran
* @param string $caraPrint menampung kriteria print
*/
public function actionRincianBiayaFarmasi($id, $caraPrint = null){
$this->layout = '//layouts/iframe';
$format = new MyFormatter();
$data['judulHalaman'] = 'Rincian Biaya Farmasi';
$modPendaftaran = BKPendaftaranT::model()->findByPk($id);
$modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

$criteria = new CDbCriteria();
if(!empty($id)){
$criteria->addCondition("pendaftaran_id = ".$id);
}
// $criteria->addCondition('oasudahbayar_id is null');
$criteria->order = 'noresep, jenisobatalkes_nama, tglpenjualan';
$modRincian = RincianbiayafarmasirjV::model()->findAll($criteria);
$data['judulPrint'] = 'Rincian Biaya Farmasi';
$judulLaporan = "";
$lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
$data['nama_pegawai'] = empty($lp->pegawai_id)?"-":$lp->pegawai->nama_pegawai;


$modPenjualan = PenjualanresepT::model()->findAllByAttributes(array(
'pendaftaran_id' => $id,
), array(
'order'=>'tglpenjualan asc',
));

if(isset($caraPrint))
{
if($caraPrint=='PRINT')
{
$this->layout='//layouts/printWindows';
$this->render('billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiBelumBayar',
array(
'modPendaftaran'=>$modPendaftaran,
'modRincian'=>$modRincian,
'data'=>$data,
'caraPrint'=>$caraPrint,
'judulLaporan'=>$judulLaporan,
'modPenjualan'=>$modPenjualan,
'modPasienAdmisi'=>$modPasienAdmisi
)
);
}else
if ($caraPrint == 'EXCEL')
{
$this->layout='//layouts/printExcel';
$this->render('billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiBelumBayar',
array(
'modPendaftaran'=>$modPendaftaran,
'modRincian'=>$modRincian,
'data'=>$data,
'caraPrint'=>$caraPrint,
'judulLaporan'=>$judulLaporan,
'modPenjualan'=>$modPenjualan,
'modPasienAdmisi'=>$modPasienAdmisi
)
);
}else
if($caraPrint == 'PDF')
{
$ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
$mpdf = new MyPDF60('c',$ukuranKertasPDF);
//                    //$mpdf->useOddEven = 2;
$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
$mpdf->WriteHTML($stylesheet,1);

$footer = '
<table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
<td width="50%"></td>
<td width="50%" align="right">{PAGENO} / {nb}</td>
</tr></table>
';
$mpdf->SetHTMLFooter($footer);
$header = 0.75 * 72 / (72/25.4);
$mpdf->AddPage($posisi,'','','','',5,5,$header+4,8,0,0);
$mpdf->WriteHTML(
$this->renderPartial('billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiBelumBayar',
array(
'modPendaftaran'=>$modPendaftaran,
'modRincian'=>$modRincian,
'data'=>$data,
'format'=>$format, 'caraPrint'=>$caraPrint,
'modPenjualan'=>$modPenjualan,
'modPasienAdmisi'=>$modPasienAdmisi
), true
)
);

$mpdf->Output();
exit;
}


}else{
$this->render(
'billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiBelumBayar',
array(
'modPendaftaran'=>$modPendaftaran,
'modRincian'=>$modRincian,
'data'=>$data,
'format'=>$format,
'caraPrint'=>$caraPrint,
'modPenjualan'=>$modPenjualan,
'modPasienAdmisi'=>$modPasienAdmisi
)
);
}
}

//=====================================================================
//                Rincian Biaya Farmasi Rawat Darurat
//=====================================================================
/**
* digunakan untuk cetak rincian biaya farmasi RD
* @param integer $id menampung id pendaftaran
* @param string $caraPrint menampung kriteria print
*/
public function actionRincianBiayaFarmasiRD($id, $caraPrint = null){
$this->layout = '//layouts/iframe';
$format = new MyFormatter();
$data['judulHalaman'] = 'Rincian Biaya Farmasi';
// $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
$criteria = new CDbCriteria();
if(!empty($id)){
$criteria->addCondition("pendaftaran_id = ".$id);
}
$criteria->order = 'noresep, jenisobatalkes_nama, tglpenjualan';
$modRincian = RincianbiayafarmasirdV::model()->findAll($criteria);
$modPendaftaran = PendaftaranT::model()->findByPk($id);
$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
$data['judulPrint'] = 'Rincian Biaya Farmasi';
$judulPrint = '';
$judulLaporan = '';

$lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
$data['nama_pegawai'] = empty($lp->pegawai_id)?"-":$lp->pegawai->nama_pegawai;

if(isset($caraPrint))
{
if($caraPrint=='PRINT')
{
$this->layout='//layouts/printWindows';
$this->render('billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiRDPdf',
array(
'modRincian'=>$modRincian,
'data'=>$data,
'judulPrint'=>$judulPrint, 'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,
'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien
)
);
}else
if ($caraPrint == 'EXCEL')
{
$this->layout='//layouts/printExcel';
$this->render('billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiRDPdf',array('modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint,'judulPrint'=>$judulPrint,'judulLaporan'=>$judulLaporan,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
}else
if($caraPrint == 'PDF')
{
$ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
$mpdf = new MyPDF60('c',$ukuranKertasPDF);
//                    //$mpdf->useOddEven = 2;
$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
$mpdf->WriteHTML($stylesheet,1);

$footer = '
<table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
<td width="50%"></td>
<td width="50%" align="right">{PAGENO} / {nb}</td>
</tr></table>
';
$mpdf->SetHTMLFooter($footer);
$header = 0.75 * 72 / (72/25.4);
$mpdf->AddPage($posisi,'','','','',5,5,$header+4,8,0,0);
$mpdf->WriteHTML(
$this->renderPartial('rincianBiayaFarmasiRDPdf',
array(
'modRincian'=>$modRincian,
'data'=>$data,
'format'=>$format, 'caraPrint'=>$caraPrint,
'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien
), true
)
);

$mpdf->Output();
exit;
}


}else{
$this->render(
'billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiRD',
array(
'modRincian'=>$modRincian,
'data'=>$data,
'format'=>$format,
'caraPrint'=>$caraPrint,
'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien
)
);
}
}

//=====================================================================
//                Rincian Biaya Farmasi Rawat Inap
//=====================================================================
/**
* digunakan untuk cetak rincian biaya farmasi RI
* @param integer $id menampung id pendaftaran
* @param string $caraPrint menampung kriteria print
*/
public function actionRincianBiayaFarmasiRI($id, $caraPrint = null){
$this->layout = '//layouts/iframe';
$format = new MyFormatter();
$data['judulHalaman'] = 'Rincian Biaya Farmasi';
$criteria = new CDbCriteria();
if(!empty($id)){
$criteria->addCondition("pendaftaran_id = ".$id);
}
$criteria->order = 'noresep, jenisobatalkes_nama, tglpenjualan';
$modRincian = RincianbiayafarmasirawatinapV::model()->findAll($criteria);
$data['judulPrint'] = 'Rincian Biaya Farmasi';
$judulLaporan = '';
$judulPrint = '';

$lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
$data['nama_pegawai'] = empty($lp->pegawai_id)?"-":$lp->pegawai->nama_pegawai;

if(isset($caraPrint))
{
if($caraPrint=='PRINT')
{
$this->layout='//layouts/printWindows';
$this->render('billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiRIPdf',
array(
'modRincian'=>$modRincian,
'data'=>$data,
'caraPrint'=>$caraPrint,
'judulLaporan'=>$judulLaporan,
)
);
}else
if ($caraPrint == 'EXCEL')
{
$this->layout='//layouts/printExcel';
$this->render('billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiRIPdf',array('modRincian'=>$modRincian, 'data'=>$data, 'judulPrint'=>$judulPrint, 'caraPrint'=>$caraPrint,'judulLaporan'=>$judulLaporan,));
}else
if($caraPrint == 'PDF')
{
$ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
$mpdf = new MyPDF60('c',$ukuranKertasPDF);
//                    //$mpdf->useOddEven = 2;
$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
$mpdf->WriteHTML($stylesheet,1);

$footer = '
<table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
<td width="50%"></td>
<td width="50%" align="right">{PAGENO} / {nb}</td>
</tr></table>
';
$mpdf->SetHTMLFooter($footer);
$header = 0.75 * 72 / (72/25.4);
$mpdf->AddPage($posisi,'','','','',5,5,$header+4,8,0,0);
$mpdf->WriteHTML(
$this->renderPartial('rincianBiayaFarmasiRIPdf',
array(
'modRincian'=>$modRincian,
'data'=>$data,
'format'=>$format,
'caraPrint'=>$caraPrint,
'judulLaporan'=>$judulLaporan,
), true
)
);

$mpdf->Output();
exit;
}


}else{

$this->render(
'billingKasir.views.rincianTagihanFarmasi.rincianBiayaFarmasiRI',
array(
'modRincian'=>$modRincian,
'data'=>$data,
'format'=>$format,
'caraPrint'=>$caraPrint,
'judulLaporan'=>$judulLaporan,
)
);
}
}

}
