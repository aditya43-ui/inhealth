<?php

class KetersediaanKamarController extends Controller {
    
    public $layout = '//layouts/kiosAntrian';
    
    public function actionIndex() {
        $this->layout = '//layouts/kiosAntrian';
        $this->render('index');
    }
    
    
}
