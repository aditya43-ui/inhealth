<?php
class ModuleDashboardSEController extends MyAuthController
{
	public $layout='//layouts/column1';
	public function actionIndex()
	{
        $this->render('index');
	}
	
	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
    public function actionSetIFrameDashboard(){

        $this->layout= '//layouts/iframeNeon';
        $format = new MyFormatter();
		//=== start 4 kolom ===
		$dataKolom = array();
		
		$this->render('dashboard',array(
                    'dataKolom'=>$dataKolom,
		));

    }
}
?>