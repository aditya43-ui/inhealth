<?php

class RencanaOperasiController extends Controller {
    
    public $layout = '//layouts/kiosAntrian';
    public $path_view = 'application.modules.sistemInformasiEksekutif.views.rencanaOperasi.';
    
    public function actionIndex() {
        $this->layout = '//layouts/kiosAntrian';
        // $this->render('index');
        $this->render($this->path_view . 'index', array());
    }
    
    
}
