<?php
class TindakanGiziController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.tindakanGizi.';

  public function actionIndex()
  {

    // if(!empty($pasienadmisi_id)) {

    //   $modPendaftaran = RIInfokunjunganriV::model()->findByAttributes(array(
    //     'pendaftaran_id' => $pendaftaran_id,
    //   ));

    // } else {

    //   $modPendaftaran = PendaftaranT::model()->findByAttributes(array(
    //     'pendaftaran_id' => $pendaftaran_id,
    //   ));

    // }

    $modPendaftaran = new GZPendaftaranT;
    $modPasien = new GZPasienM;

    $modAdmisi = new GZPasienAdmisiT;

    
    // if(empty($pasienadmisi_id)) {
    // } else {
    //   $modAdmisi = RIPasienAdmisiT::model()->findByPk($pasienadmisi_id);
    // }
    $format = new MyFormatter();

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAdmisi' => $modAdmisi,
    ));
  }

  public function actionGetPasienByPendaftaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      
      $pendaftaran = GZPendaftaranT::model()->find('pendaftaran_id = ' . $_POST['pendaftaran_id']);
      $pasien = GZPasienM::model()->findByPk($pendaftaran->pasien_id);
      $admisi = GZPasienAdmisiT::model()->findByPk($pendaftaran->pasienadmisi_id) ?? new GZPasienAdmisiT;

      $pendaftaran = empty($pendaftaran) ? new GZPendaftaranT : $pendaftaran;

      $res['datapasien'] = $this->renderPartial('_dataPasien', array('modPendaftaran' => $pendaftaran, 'modPasien' => $pasien, 'modAdmisi' => $admisi), true);
      $res['pasien_id'] = $pasien->pasien_id;
      $res['pendaftaran_id'] = !empty($pendaftaran) ? $pendaftaran->pendaftaran_id : '';
      $res['pasienadmisi_id'] = !empty($admisi) ? $admisi->pasienadmisi_id : '';
       
      echo json_encode($res);
    }
    Yii::app()->end();
  }

  public function actionGetRuanganInstalasi() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $instalasi_id = $_POST['instalasi_id'];

    $ruangan = RuanganM::model()->findAllByAttributes(array(
      'instalasi_id'=>$instalasi_id,
      'ruangan_aktif'=>true,
    ), array(
      'order'=>'ruangan_nama asc',
    ));

    $html = '<option value="">-- Pilih --</option>';
    foreach ($ruangan as $item) {
      $html .= '<option value="'.$item->ruangan_id.'">'.$item->ruangan_nama.'</option>';
    }

    echo $html;
  }
}
