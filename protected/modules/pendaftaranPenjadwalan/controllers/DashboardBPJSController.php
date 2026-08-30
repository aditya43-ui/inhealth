<?php

class DashboardBPJSController extends Controller {
    
    public $layout = '//layouts/kiosAntrian';
    
    public function actionIndex() {
        $this->layout = '//layouts/kiosAntrian';
        $modKonfig = KonfigsystemK::model()->find();
        $this->render('index', array(
            'modKonfig' => $modKonfig,
        ));
    }
    
    
}
