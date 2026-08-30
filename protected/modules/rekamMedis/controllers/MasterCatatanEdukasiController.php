<?php

class MasterCatatanEdukasiController extends MyAuthController {
  public $path_view = 'rekamMedis.views.masterCatatanEdukasi.';

    public function actionIndex() {
        $this->render('index');
    }
}
