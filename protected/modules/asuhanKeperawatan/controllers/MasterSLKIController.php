<?php

/**
 * Master SLKI
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 */
class MasterSLKIController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'asuhanKeperawatan.views.masterSLKI.';

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->render($this->path_view . 'index');
    }

}
