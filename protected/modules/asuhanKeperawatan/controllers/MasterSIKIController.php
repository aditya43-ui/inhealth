<?php

/**
 * Master SIKI
 * 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controller
 */
class MasterSIKIController extends MyAuthController {

    /**
     * Default menu SIKI
     */
    public function actionIndex() {
        $model = new JenisintervensiM;

        $this->render('index', array('model' => $model));
    }

}
