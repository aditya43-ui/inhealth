<?php

class MasterSDKIController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'asuhanKeperawatan.views.masterSDKI.';

    public function actionIndex() {
        $this->render($this->path_view . 'index');
    }

}
