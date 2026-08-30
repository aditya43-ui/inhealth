<?php
Yii::import('billingKasir.controllers.PembayaranTagihanPasienController');
class PembayaranObatPasienController extends PembayaranTagihanPasienController
{
  public $path_view = "billingKasir.views.pembayaranTagihanPasien.";

  /**
   * actionPrintRincianOABelumBayar 
   * @params $instalasi_id = RJ / RD / RI
   * @params $pendaftaran_id
   * @params $pasienadmisi_id (RI saja)
   */
  public function actionPrintRincianOABelumBayar($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $modRincians = null;
    if ($instalasi_id == Params::INSTALASI_ID_RJ) {
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteria->addCondition("LOWER(tm) <> 'tm'");
      $criteria->order = 'unitlayanan_nama, tgl_tindakan, tm';
      $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
    } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteria->addCondition("LOWER(tm) <> 'tm'");
      $criteria->order = 'ruangantindakan_id';
      $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
    } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteria->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
      $criteria->addCondition("LOWER(tm) <> 'tm'");
      $criteria->order = 'ruangantindakan_id, tm';
      $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
    }
    $this->render('printRincianOABelumBayar', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran));
  }
  
  /**
   * simpan BKOasudahbayarT
   * ubah BKObatalkesPasienT.oasudahbayar_id
   * @param type $model
   * @param $modOasudahbayar $modOasudahbayar
   * @param type $posts
   * @return type
   */
  protected function simpanBayarOas($model, $modOasudahbayar, $posts)
  {
      foreach ($posts as $idx=>$item) {
          $posts[$idx]['hargasatuan_oa'] = is_numeric($posts[$idx]['hargasatuan_oa']) ? $posts[$idx]['hargasatuan_oa'] : MyFormatter::formatRupiahForDB($posts[$idx]['hargasatuan_oa']);
          $posts[$idx]['tarifcyto'] = is_numeric($posts[$idx]['tarifcyto']) ? $posts[$idx]['tarifcyto'] : MyFormatter::formatRupiahForDB($posts[$idx]['tarifcyto']);
          $posts[$idx]['discount'] = is_numeric($posts[$idx]['discount']) ? $posts[$idx]['discount'] : MyFormatter::formatRupiahForDB($posts[$idx]['discount']);
          $posts[$idx]['biayalain'] = is_numeric($posts[$idx]['biayalain']) ? $posts[$idx]['biayalain'] : MyFormatter::formatRupiahForDB($posts[$idx]['biayalain']);
          $posts[$idx]['subsidiasuransi'] = is_numeric($posts[$idx]['subsidiasuransi']) ? $posts[$idx]['subsidiasuransi'] : MyFormatter::formatRupiahForDB($posts[$idx]['subsidiasuransi']);
          $posts[$idx]['subsidirs'] = is_numeric($posts[$idx]['subsidirs']) ? $posts[$idx]['subsidirs'] : MyFormatter::formatRupiahForDB($posts[$idx]['subsidirs']);
          $posts[$idx]['subsidipemerintah'] = is_numeric($posts[$idx]['subsidipemerintah']) ? $posts[$idx]['subsidipemerintah'] : MyFormatter::formatRupiahForDB($posts[$idx]['subsidipemerintah']);
          $posts[$idx]['iurbiaya'] = is_numeric($posts[$idx]['iurbiaya']) ? $posts[$idx]['iurbiaya'] : MyFormatter::formatRupiahForDB($posts[$idx]['iurbiaya']);
          $posts[$idx]['iurbiaya_temporary'] = is_numeric($posts[$idx]['iurbiaya_temporary']) ? $posts[$idx]['iurbiaya_temporary'] : MyFormatter::formatRupiahForDB($posts[$idx]['iurbiaya_temporary']);
          $posts[$idx]['jmlselisihbpjs'] = is_numeric($posts[$idx]['jmlselisihbpjs']) ? $posts[$idx]['jmlselisihbpjs'] : MyFormatter::formatRupiahForDB($posts[$idx]['jmlselisihbpjs']);
          $posts[$idx]['subtotaloa'] = is_numeric($posts[$idx]['subtotaloa']) ? $posts[$idx]['subtotaloa'] : MyFormatter::formatRupiahForDB($posts[$idx]['subtotaloa']);
          $posts[$idx]['jmlbayar_oa'] = is_numeric($posts[$idx]['jmlbayar_oa']) ? $posts[$idx]['jmlbayar_oa'] : MyFormatter::formatRupiahForDB($posts[$idx]['jmlbayar_oa']);
      }
      
//      var_dump($posts);
      
      return parent::simpanBayarOas($model, $modOasudahbayar, $posts);
  }
}
