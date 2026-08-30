<?php

class PetaKesehatanController extends MyAuthController
{
	public function actionIndex()
	{
        $this->render('index');
	}

	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
    public function actionSetIFrameContent(){

        $this->layout= '//layouts/iframePolos';

		    $this->render('iframeContent',array());

    }
}
