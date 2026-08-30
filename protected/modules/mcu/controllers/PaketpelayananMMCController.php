<?php

Yii::import('sistemAdministrator.controllers.PaketpelayananMController');
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.views.paketpelayananM');

/**
 * Extend dari sistemAdministrator.controllers.PaketpelayananMController
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @version    2.0.0
 * @package    application.modules.mcu
 * @subpackage controllers
 */
class PaketpelayananMMCController extends PaketpelayananMController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.paketpelayananM.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    return PaketpelayananMController::actionView($id);
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    return PaketpelayananMController::actionCreate();
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    return PaketpelayananMController::actionUpdate($id);
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    return PaketpelayananMController::actionDelete($id);
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    return PaketpelayananMController::actionIndex();
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Paket Pelayanan";
    return PaketpelayananMController::actionAdmin();
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    return PaketpelayananMController::performAjaxValidation($model);
  }

  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    return PaketpelayananMController::actionRemoveTemporary($id);
  }

  /**
   * Printout admin Paket Pelayanan
   * 
   * @return PaketpelayananMController
   */
  public function actionPrint()
  {
    return PaketpelayananMController::actionPrint();
  }

  /**
   * Tambah detail tindakan untuk form paket pelayanan.
   * Untuk modul MCU, ruangan-nya adalah read-only.
   */
  // public function actionGetPaketPelayanan()
  // {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $tr = '';
  //     if (isset($_POST['tipePaket'])) {
  //       $modPaketPelayanan = PaketpelayananM::model()->findAllByAttributes(array('tipepaket_id' => $_POST['tipePaket']));
  //       if (count((array)$modPaketPelayanan) > 0) {
  //         $data['paket'] = 'Ada';
  //       } else {
  //         $data['paket'] = 'Tidak';
  //       }
  //     } else {
  //       $idTipePaket = $_POST['idTipePaket'];
  //       $idDaftarTindakan = $_POST['idDaftarTindakan'];
  //       $idTarifTindakan = $_POST['idTarifTindakan'];

  //       //$idRuangan = Yii::app()->user->getState('ruangan_id'); //isset($_POST['idRuangan']) ? $_POST['idRuangan'] : null;
  //       $idRuangan = isset($_POST['idRuangan']) ? $_POST['idRuangan'] : Yii::app()->user->getState('ruangan_id');

  //       $modTipePaket = TipepaketM::model()->findByPk($idTipePaket);
  //       $modDaftarTindakan = DaftartindakanM::model()->findByPk($idDaftarTindakan);
  //       // $namaRuangan = RuanganM::model()->findByPk($idRuangan)->ruangan_nama;
  //       $modPaketPelayanan = new PaketpelayananM;
  //       $modPaketPelayanan->ruangan_id = $idRuangan;
  //       $modTarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id' => $idDaftarTindakan, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL, 'kelaspelayanan_id' => $modTipePaket->kelaspelayanan_id));
  //       $TarifTindakan = TariftindakanM::model()->findByPk($idTarifTindakan);

  //       $totaltarif = 0;
  //       foreach ($modTarifTindakan as $row) {
  //         $totaltarif += $row->harga_tariftindakan;
  //       }
  //       $modPaketPelayanan->tipepaket_id  = $idTipePaket;
  //       $modPaketPelayanan->daftartindakan_id = $idDaftarTindakan;
  //       $modPaketPelayanan->carabayar_id = $modTipePaket->carabayar_id;
  //       $modPaketPelayanan->penjamin_id = $modTipePaket->penjamin_id;
  //       $modPaketPelayanan->jenistarif_id = $modTipePaket->jenistarif_id;
  //       //                                $modPaketPelayanan->daftartindakan_id = $idDaftarTindakan;

  //       $ruangan = RuanganM::model()->findByPk($modPaketPelayanan->ruangan_id);

  //       // $modPaketPelayanan->ruangan_id = $idRuangan;
  //       $tr .= "<tr>
	// 						<td>" . CHtml::TextField('noUrut', '', array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
  //         CHtml::activeHiddenField($modPaketPelayanan, '[' . $idDaftarTindakan . ']tipepaket_id') .
  //         CHtml::activeHiddenField($modPaketPelayanan, '[' . $idDaftarTindakan . ']daftartindakan_id') .
  //         CHtml::activeHiddenField($modPaketPelayanan, '[' . $idDaftarTindakan . ']carabayar_id') .
  //         CHtml::activeHiddenField($modPaketPelayanan, '[' . $idDaftarTindakan . ']penjamin_id') .
  //         CHtml::activeHiddenField($modPaketPelayanan, '[' . $idDaftarTindakan . ']jenistarif_id') .
  //         //CHtml::activeHiddenField($modPaketPelayanan, 'ruangan_id[]', array('value'=>$idRuangan)).
  //         "</td>
	// 						<td>" . $modTipePaket->tipepaket_nama . "</td>
	// 						<td>" . $modDaftarTindakan->daftartindakan_nama . "</td>
	// 						<td>" . CHtml::activeDropDownList($modPaketPelayanan, '[' . $idDaftarTindakan . ']ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 ruangan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
	// 						<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $idDaftarTindakan . ']namatindakan[]', array('readonly' => false, 'value' => $modDaftarTindakan->daftartindakan_nama, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
	// 						<td>" . CHtml::TextField('totaltarif[]', number_format($TarifTindakan->harga_tariftindakan, 0, ',', '.'), array('readonly' => true, 'class' => 'span2 integer2 totalTarif', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
	// 						<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $idDaftarTindakan . ']tarifpaketpel', array('parent' => 'SAPaketpelayananM_tarifpaketpel', 'class' => 'span2 tarifpaket integer2', 'onblur' => 'tarifPaket(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
	// 						<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $idDaftarTindakan . ']subsidiasuransi', array('parent' => 'SAPaketpelayananM_subsidiasuransi', 'class' => 'span2 subisidiAsuransi integer2', 'onblur' => 'tarifAsuransi(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
	// 						<td class='cols_hide'>" . CHtml::activeTextField($modPaketPelayanan, '[' . $idDaftarTindakan . ']subsidipemerintah', array('parent' => 'SAPaketpelayananM_subsidipemerintah', 'class' => 'span1 subisidiPemerintah integer2', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
	// 						<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $idDaftarTindakan . ']subsidirumahsakit', array('parent' => 'SAPaketpelayananM_subsidirumahsakit',  'class' => 'span2 subisidiRS integer2', 'onblur' => 'tarifRs(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
	// 						<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $idDaftarTindakan . ']iurbiaya', array('readonly' => true, 'parent' => 'SAPaketpelayananM_iurbiaya', 'class' => 'span2 iurBiaya integer2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
	// 						<td>" . CHtml::link("<i class='icon-remove'></i>", '', array('href' => '', 'onclick' => 'remove2(this);return false;')) . "</td>
	// 					</tr>
	// 					";

  //       $data['tr'] = $tr;
  //     }
  //     echo json_encode($data);
  //     Yii::app()->end();
  //   }
  // }

  /*
     * load data tipe paket pada database
     */
  public function actionGetTipePaket()
  {
    return PaketpelayananMController::actionGetTipePaket();
  }

  /**
   * menampilkan semua daftartindakan yang aktif
   */
  public function actionAutocompleteDaftarTindakan()
  {
    return PaketpelayananMController::actionAutocompleteDaftarTindakan();
  }
}
