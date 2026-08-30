<?php

/**
 * Digunakan sebagai masater rekening jenis obat alkes
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.akuntansi
 * @subpackage controllers
 **/
class RekeningJenisAlkesController extends MyAuthController
{

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	/**
	 *  digunakan untuk menentukan apakah menu masuk dalam tab menu atau menu tersendiri
	 */

	public function init(){
		if (isset($_GET['tab'])){
			if ($_GET['tab'] == 'frame'){
				$this->layout='//layouts/iframe';
			}
		}
	}
 /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('_view',array(
            'model'=>$this->loadModel($id),
        ));
    }
  
  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */


  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new JnsobatalkesrekM;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

        if(isset($_POST['JnsobatalkesrekM']))
        {
            $model->attributes=$_POST['JnsobatalkesrekM'];
            $model->pilihan=$_POST['JnsobatalkesrekM']['pilihan'];

            if($model->pilihan == 'isreturoa'){
                $model->isreturoa = true;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ispenerimaanoa'){
                $model->ispenerimaanoa = true;
                $model->isreturoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isreturpembelian'){
                $model->isreturpembelian = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isstokopnameoa'){
                $model->isstokopnameoa = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isreturpembelian'){
                $model->isreturpembelian = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ispenjualanresep'){
                $model->ispenjualanresep = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ispemakaianruangan'){
                $model->ispemakaianruangan = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ispemusnahan'){
                $model->ispemusnahan = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isbahanproduksi'){
                $model->isbahanproduksi = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ishasilproduksi'){
                $model->ishasilproduksi = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isstokopnameoaberkurang'){
                $model->isstokopnameoaberkurang = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isstokberkurangoa'){
                $model->isstokberkurangoa = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ismutasioa'){
                $model->ismutasioa = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isstokopnameoabertambah'){
							$model->isstokopnameoabertambah = true;
                $model->ismutasioa = false;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
            }



            if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('view','id'=>$model->jnsobatalkesrek_id,"tab"=>(isset($_GET['tab'])?$_GET['tab']:'')));
            }

        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        if($model->isreturoa == true){
            $model->pilihan = 'isreturoa';
        }else if($model->isstokopnameoa == true){
            $model->pilihan = 'isstokopnameoa';
        }else if($model->ispenerimaanoa == true){
            $model->pilihan = 'ispenerimaanoa';
        }else if($model->isreturpembelian == true){
            $model->pilihan = 'isreturpembelian';
        }else if($model->ispenjualanresep == true){
            $model->pilihan = 'ispenjualanresep';
        }else if($model->ispemakaianruangan == true){
            $model->pilihan = 'ispemakaianruangan';
        }else if($model->ispemusnahan == true){
            $model->pilihan = 'ispemusnahan';
        }else if($model->isbahanproduksi == true){
            $model->pilihan = 'isbahanproduksi';
        }else if($model->ishasilproduksi == true){
            $model->pilihan = 'ishasilproduksi';
        }else if($model->isstokopnameoaberkurang == true){
            $model->pilihan = 'isstokopnameoaberkurang';
        }else if($model->isstokberkurangoa == true){
            $model->pilihan = 'isstokberkurangoa';
        }else if($model->ismutasioa == true){
            $model->pilihan = 'ismutasioa';
        }else if($model->isstokopnameoabertambah == true){
            $model->pilihan = 'isstokopnameoabertambah';
        }
				$model->nmrekening5 = (isset($model->rekening5)? $model->rekening5->nmrekening5: "");

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['JnsobatalkesrekM']))
        {
            $model->attributes=$_POST['JnsobatalkesrekM'];
            $model->pilihan=$_POST['JnsobatalkesrekM']['pilihan'];

						if($model->pilihan == 'isreturoa'){
                $model->isreturoa = true;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ispenerimaanoa'){
                $model->ispenerimaanoa = true;
                $model->isreturoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isreturpembelian'){
                $model->isreturpembelian = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isstokopnameoa'){
                $model->isstokopnameoa = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isreturpembelian'){
                $model->isreturpembelian = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ispenjualanresep'){
                $model->ispenjualanresep = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ispemakaianruangan'){
                $model->ispemakaianruangan = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ispemusnahan'){
                $model->ispemusnahan = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isbahanproduksi'){
                $model->isbahanproduksi = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ishasilproduksi'){
                $model->ishasilproduksi = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isstokopnameoaberkurang'){
                $model->isstokopnameoaberkurang = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokberkurangoa = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isstokberkurangoa'){
                $model->isstokberkurangoa = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->ismutasioa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'ismutasioa'){
                $model->ismutasioa = true;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
								$model->isstokopnameoabertambah = false;
            }else if($model->pilihan == 'isstokopnameoabertambah'){
							$model->isstokopnameoabertambah = true;
                $model->ismutasioa = false;
                $model->isreturoa = false;
                $model->ispenerimaanoa = false;
                $model->isstokopnameoa = false;
                $model->isreturpembelian = false;
                $model->ispenjualanresep = false;
                $model->ispemakaianruangan = false;
                $model->ispemusnahan = false;
                $model->isbahanproduksi = false;
                $model->ishasilproduksi = false;
                $model->isstokopnameoaberkurang = false;
                $model->isstokberkurangoa = false;
            }
            if($model->save())
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil diupdate.');
                $this->redirect(array('view','id'=>$model->jnsobatalkesrek_id,"tab"=>(isset($_GET['tab'])?$_GET['tab']:'')));
        }


      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->rekening5->nmrekening5 . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->jnsobatalkesrek_id, "tab" => (isset($_GET['tab']) ? $_GET['tab'] : '')));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
      }
    

    $this->render('create', array(
      'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  // public function actionUpdate($id)
  // {
  //   $model = $this->loadModel($id);
  //   if ($model->isreturoa == true) {
  //     $model->pilihan = 'isreturoa';
  //   } else if ($model->isstokopnameoa == true) {
  //     $model->pilihan = 'isstokopnameoa';
  //   } else if ($model->ispenerimaanoa == true) {
  //     $model->pilihan = 'ispenerimaanoa';
  //   } else if ($model->isreturpembelian == true) {
  //     $model->pilihan = 'isreturpembelian';
  //   } else if ($model->ispenjualanresep == true) {
  //     $model->pilihan = 'ispenjualanresep';
  //   } else if ($model->ispemakaianruangan == true) {
  //     $model->pilihan = 'ispemakaianruangan';
  //   } else if ($model->ispemusnahan == true) {
  //     $model->pilihan = 'ispemusnahan';
  //   } else if ($model->isbahanproduksi == true) {
  //     $model->pilihan = 'isbahanproduksi';
  //   } else if ($model->ishasilproduksi == true) {
  //     $model->pilihan = 'ishasilproduksi';
  //   } else if ($model->isstokopnameoaberkurang == true) {
  //     $model->pilihan = 'isstokopnameoaberkurang';
  //   } else if ($model->isstokberkurangoa == true) {
  //     $model->pilihan = 'isstokberkurangoa';
  //   } else if ($model->ismutasioa == true) {
  //     $model->pilihan = 'ismutasioa';
  //   }
  //   // Uncomment the following line if AJAX validation is needed
  //   // $this->performAjaxValidation($model);

  //   if (isset($_POST['JnsobatalkesrekM'])) {
  //     $model->attributes = $_POST['JnsobatalkesrekM'];
  //     $model->pilihan = $_POST['JnsobatalkesrekM']['pilihan'];

  //     if ($model->pilihan == 'isreturoa') {
  //       $model->isreturoa = true;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'ispenerimaanoa') {
  //       $model->ispenerimaanoa = true;
  //       $model->isreturoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'isreturpembelian') {
  //       $model->isreturpembelian = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'isstokopnameoa') {
  //       $model->isstokopnameoa = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'isreturpembelian') {
  //       $model->isreturpembelian = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'ispenjualanresep') {
  //       $model->ispenjualanresep = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'ispemakaianruangan') {
  //       $model->ispemakaianruangan = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'ispemusnahan') {
  //       $model->ispemusnahan = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'isbahanproduksi') {
  //       $model->isbahanproduksi = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'ishasilproduksi') {
  //       $model->ishasilproduksi = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'isstokopnameoaberkurang') {
  //       $model->isstokopnameoaberkurang = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokberkurangoa = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'isstokberkurangoa') {
  //       $model->isstokberkurangoa = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->ismutasioa = false;
  //     } else if ($model->pilihan == 'ismutasioa') {
  //       $model->ismutasioa = true;
  //       $model->isreturoa = false;
  //       $model->ispenerimaanoa = false;
  //       $model->isstokopnameoa = false;
  //       $model->isreturpembelian = false;
  //       $model->ispenjualanresep = false;
  //       $model->ispemakaianruangan = false;
  //       $model->ispemusnahan = false;
  //       $model->isbahanproduksi = false;
  //       $model->ishasilproduksi = false;
  //       $model->isstokopnameoaberkurang = false;
  //       $model->isstokberkurangoa = false;
  //     }
  //     if ($model->save())
  //       Yii::app()->user->setFlash('success', 'Data ' . $model->rekening5->nmrekening5 . ' berhasil disimpan.');
  //     $this->redirect(array('admin', 'id' => $model->jnsobatalkesrek_id, "tab" => (isset($_GET['tab']) ? $_GET['tab'] : '')));
  //   } else {
  //     Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
  //   }

  //   $this->render('update', array(
  //     'model' => $model,
  //   ));
  // }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax'])) {
        Yii::app()->user->setFlash('success', 'Data berhasil dihapus.');
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      }
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('JnsobatalkesrekM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  // /**
  //  * Manages all models.
  //  */
  public function actionAdmin()
  {
    $model = new JnsobatalkesrekM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['JnsobatalkesrekM']))
      $model->attributes = $_GET['JnsobatalkesrekM'];
    $model->jenistransaksi = isset($_GET['JnsobatalkesrekM']["jenistransaksi"]) ? $_GET['JnsobatalkesrekM']["jenistransaksi"] : null;

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = JnsobatalkesrekM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  // /**
  //  * Performs the AJAX validation.
  //  * @param CModel the model to be validated
  //  */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'jnsobatalkesrek-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Untuk mencetak data
   */
  // public function actionPrint()
  // {
  //   $model = new JnsobatalkesrekM;
  //   if (isset($_REQUEST['JnsobatalkesrekM'])) {
  //     $model->attributes = $_REQUEST['JnsobatalkesrekM'];
  //   }
  //   $judulLaporan = 'Data Jenis Obat Alkes ';
  //   $caraPrint = $_REQUEST['caraPrint'];
  //   if ($caraPrint == 'PRINT') {
  //     $this->layout = '//layouts/printWindows';
  //     $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  //   } else if ($caraPrint == 'EXCEL') {
  //     $this->layout = '//layouts/printExcel';
  //     $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  //   } else if ($_REQUEST['caraPrint'] == 'PDF') {
  //     $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');          //Ukuran Kertas Pdf
  //     $posisi = Yii::app()->user->getState('posisi_kertas');               //Posisi L->Landscape,P->Portait
  //     $mpdf = new MyPDF60('', $ukuranKertasPDF);
  //     //$mpdf->useOddEven = 2;
  //     $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
  //     $mpdf->WriteHTML($stylesheet, 1);
  //     $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
  //     $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
  //     $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
  //   }

    /**
     * Untuk mencetak data
     */
    public function actionPrint() {
		$model = new JnsobatalkesrekM;
		if (isset($_REQUEST['JnsobatalkesrekM'])) {
			$model->attributes = $_REQUEST['JnsobatalkesrekM'];
		}
		$judulLaporan = 'Data Rekening Jenis Obat Alkes';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');				  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');						   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('', $ukuranKertasPDF);
			////$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
		}
	}
}
