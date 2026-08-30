<?php

/**
 * Digunakan untuk mengakses transaksi OPPE Keperawatan
 * @author Andyka Putra <andykaputra@.com>
 * @packag application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controller
 */
class OppeKeperawatanController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'asuhanKeperawatan.views.oppeKeperawatan.';

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->render($this->path_view . 'index');
    }

}
