
<?php

class TarifTindakanController extends MyAuthController
{
	public $layout='//layouts/iframe';
	public $defaultAction = 'admin';
	public $_lastDaftarTindakanId = null;
	public $_lastDaftarTindakanId2 = null;
	public $_lastTindakanTarifId = null;
	public $_lastKelasPelayanan_id = null;

	public $daftartindakan_nama;

	public $path_view = 'sistemAdministrator.views.tarifTindakan.';
	public $init = '';

	public function actionView($id)
	{
		$model = $this->loadTarifPerdaV($id);
		$modKomponenTarif = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$model->daftartindakan_id,'jenistarif_id'=>$model->jenistarif_id,'kelaspelayanan_id'=>$model->kelaspelayanan_id),array('order'=>'komponentarif_id'));
		$this->render($this->path_view.'view',array(
				'model'=>$model,
				'modKomponenTarif'=>$modKomponenTarif
		));
	}

	public function actionIndex()
	{
            $detailtersimpan = true;
            $model=new SATarifTindakanM;
            $modDetails=new TariftindakanM;
            $lists = array();
            $isCreate = true;
            // $model->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;

            if(isset($_GET['jenistarif_id'])&&isset($_GET['perdatarif_id'])&&isset($_GET['perdatarif_id'])&&isset($_GET['daftartindakan_id'])&&isset($_GET['jeniswaktukerja'])){
                $isCreate = false;
                $jenistarif_id = $_GET['jenistarif_id'];
                $perdatarif_id = $_GET['perdatarif_id'];
                $kelaspelayanan_id = $_GET['kelaspelayanan_id'];
                $daftartindakan_id = $_GET['daftartindakan_id'];
                $jeniswaktukerja = $_GET['jeniswaktukerja'];
                $criteria = new CDbCriteria;
                $criteria->addCondition('jenistarif_id ='.$jenistarif_id);
                $criteria->addCondition('perdatarif_id ='.$perdatarif_id);
                $criteria->addCondition('kelaspelayanan_id ='.$kelaspelayanan_id);
                $criteria->addCondition('daftartindakan_id ='.$daftartindakan_id);
                $criteria->addCondition("jeniswaktukerja = '".$jeniswaktukerja."'");
                $lists = TariftindakanM::model()->findAll($criteria);
                $model->jenistarif_id = $jenistarif_id;
				$model->jenistarif_nama = JenistarifM::model()->findByPk($jenistarif_id)->jenistarif_nama;
                $model->perdatarif_id = $perdatarif_id;
				$model->perdanama_sk = PerdatarifM::model()->findByPk($perdatarif_id)->perdanama_sk;
                $model->kelaspelayanan_id = $kelaspelayanan_id;
				$model->kelaspelayanan_nama = KelaspelayananM::model()->findByPk($kelaspelayanan_id)->kelaspelayanan_nama;
                $model->daftartindakan_id = $daftartindakan_id;
				$model->daftartindakan_nama = DaftartindakanM::model()->findByPk($daftartindakan_id)->daftartindakan_nama;
                $model->jeniswaktukerja = $jeniswaktukerja;

						if(count($lists) > 0){
							$persenDiskon = 0;
                            $persenCyto = 0;
							foreach ($lists as $tarifOri) {
								$persenDiskon = $tarifOri->persendiskon_tind;
                                $persenCyto = $tarifOri->persencyto_tind;
							}
							$model->persendiskon_tind = $persenDiskon;
                            $model->persencyto_tind = $persenCyto;
						}
				}

            if(isset($_POST['SATarifTindakanM']) || isset($_POST['TariftindakanM'])){

                $transaction = Yii::app()->db->beginTransaction();

                $persendiskon_tind = $_POST['SATarifTindakanM']['persendiskon_tind'];
                $hargadiskon_tind = $_POST['SATarifTindakanM']['hargadiskon_tind'];
                $total_tarifakhir = $_POST['SATarifTindakanM']['total_tarifakhir'];
                $persencyto_tind = $_POST['SATarifTindakanM']['persencyto_tind'];
                $hargacyto_tind = $_POST['SATarifTindakanM']['hargacyto_tind'];
                $jenistarif_mod = $_POST['SATarifTindakanM']['jenistarif_id'];
                $perdatarif_mod = $_POST['SATarifTindakanM']['perdatarif_id'];
                $kelaspelayanan_mod = $_POST['SATarifTindakanM']['kelaspelayanan_id'];
                $daftartindakan_mod = $_POST['SATarifTindakanM']['daftartindakan_id'];
                $jeniswaktukerja_mod = $_POST['SATarifTindakanM']['jeniswaktukerja'];
                $totaltarifakhir_cyto = $_POST['SATarifTindakanM']['totaltarifakhir_cyto'];
                $findTarifTindakan_mod = TariftindakanM::model()->findByAttributes(array(
                    'jenistarif_id'=>$jenistarif_mod,
                    'perdatarif_id'=>$perdatarif_mod,
                    'kelaspelayanan_id'=>$kelaspelayanan_mod,
                    'daftartindakan_id'=>$daftartindakan_mod,
                    'jeniswaktukerja'=>$jeniswaktukerja_mod,
                    'komponentarif_id'=>6
                ));


                foreach ($lists as $item) {
										if ($item->komponentarif_id == Params::KOMPONENTARIF_ID_TOTAL){
											$totalTarifLama = $item->harga_tariftindakan;
										}
                    // $item->delete();
                }

                try {
									// echo '<pre>';
									// print_r($_POST);
									// exit();
                    // var_dump($_POST);
                    $detailtersimpan = true;
                    $total = 0;

                    if(isset($_POST['TariftindakanM'])){

                       foreach ($_POST['TariftindakanM'] as $i => $post) {
												 	if(empty($post['tariftindakan_id'])){
														$modDetail = new TariftindakanM;
														$modDetail->create_time = date('Y-m-d H:i:s');
														$modDetail->create_loginpemakai_id = Yii::app()->user->id;
														$modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
													}else{
														$modDetail = TariftindakanM::model()->findByPk($post['tariftindakan_id']);
														$modDetail->update_time = date('Y-m-d H:i:s');
														$modDetail->update_loginpemakai_id = Yii::app()->user->id;
													}
                            //var_dump($post);
                            //if(empty($post['tariftindakan_id'])){

                                $modDetail->attributes = $post;
                                $modDetail->persendiskon_tind = $persendiskon_tind;
                                $modDetail->persencyto_tind = $persencyto_tind;


                                if($modDetail->validate()){
                                    $detailtersimpan &= $modDetail->save();
                                    $total += $modDetail->harga_tariftindakan;
                                }else{
                                    // var_dump($modDetail->errors); die;
                                    $detailtersimpan &= false;
                                }
                            //}
                        }

                    }
										$cekOriTindakan = 0;
										foreach ($lists as $item) {
												$cekOriTindakan = 0;
												if($item->komponentarif_id != 6){
													if(!empty($_POST['TariftindakanM'])){
														foreach ($_POST['TariftindakanM'] as $i => $post) {
															if($item->tariftindakan_id == $post['tariftindakan_id']){
																$cekOriTindakan = 1;
																break;
															}
														}
													}
												}else{
													if($total > 0){
														$cekOriTindakan = 1;
													}
												}

												if($cekOriTindakan==0){
													$item->delete();
												}
										}

                    if($total > 0){
                        if(!empty($findTarifTindakan_mod)){
                            $modTotal = $findTarifTindakan_mod;
                            $modTotal->update_time = date('Y-m-d H:i:s');
                            $modTotal->update_loginpemakai_id = Yii::app()->user->id;
                        }else{
                            $modTotal = new TariftindakanM;
                            $modTotal->create_time = date('Y-m-d H:i:s');
                            $modTotal->create_loginpemakai_id = Yii::app()->user->id;
                            $modTotal->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        }
                        $modTotal->kelaspelayanan_id = $kelaspelayanan_mod;
                        $modTotal->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
                        $modTotal->daftartindakan_id = $daftartindakan_mod;
                        $modTotal->jenistarif_id = $jenistarif_mod;
                        $modTotal->perdatarif_id = $perdatarif_mod;
                        $modTotal->jeniswaktukerja = $jeniswaktukerja_mod;
                        $modTotal->persendiskon_tind = $persendiskon_tind;
                        $modTotal->hargadiskon_tind = $hargadiskon_tind;
                        $modTotal->persencyto_tind = $persencyto_tind;
                        $modTotal->hargacyto_tind = $hargacyto_tind;
                        $modTotal->harga_tariftindakan = $total;
                        $modTotal->total_tarifakhir = $total_tarifakhir;
                        $modTotal->totaltarifakhir_cyto = $totaltarifakhir_cyto;

                        // $modTotal->create_time = date('Y-m-d H:i:s');
                        // $modTotal->create_loginpemakai_id = Yii::app()->user->id;
                        // $modTotal->create_ruangan = Yii::app()->user->getState('ruangan_id');

                        if ($modTotal->validate()) {
                            $detailtersimpan &= $modTotal->save();
                        } else {
                            var_dump($modTotal->errors);
                            $detailtersimpan &= false;
                        }
                    }



                    //var_dump($detailtersimpan); die;

                    if($detailtersimpan){
                        if (isset($totalTarifLama)){
                            if ($total != $totalTarifLama){
                                    // $this->notifTarifBerubah($modTotal);
                            }
                        }else{
                            // $this->notifTarifBaru($modTotal);
                        }

                        $typenotif = "ubah";
                        if($isCreate){
                            $typenotif = "tambah";
                        }

                        if(!empty($modTotal)){
                                $this->notifPerubahanTarifTindakan($modTotal, $typenotif);
                        }else{
                            $this->notifPenghapusanTarifTindakan($daftartindakan_mod, $jenistarif_mod, $kelaspelayanan_mod);
                        }

                        $transaction->commit();
                        $this->redirect(array('admin','sukses'=>1));
                    }
                } catch (Exception $e) {
                    $transaction->rollback(); // var_dump($e->getMessage()); die;
                     Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !".MyExceptionMessage::getMessage($e,true));
                }
            }else{
//                if(!$isCreate){
//                    $total = 0;
//                    if(count((array)$lists)>0){
//                        foreach ($lists as $i => $post) {
//                            if ($item->komponentarif_id != Params::KOMPONENTARIF_ID_TOTAL){
//                               $total +=  $modDetail->harga_tariftindakan;
//                            }
//                        }

//                        foreach ($lists as $i => $post) {
//                            if ($item->komponentarif_id == Params::KOMPONENTARIF_ID_TOTAL){
//                                TariftindakanM::model()->updateByPk($post->tariftindakan_id, array('harga_tariftindakan'=>$total));
//                            }
//                        }
//                    }
//                }
            }
            $this->render($this->path_view.'create',array(
		'model'=>$model,
                'modDetails'=>$modDetails,
                'lists'=>$lists,
                'isCreate'=>$isCreate,
            ));
	}

	public function actionDelete($id)
	{
            if (Yii::app()->request->isAjaxRequest) {
                $model = TariftindakanM::model()->findByPk($id);
                $deleteData = TariftindakanM::model()->deleteAllByAttributes(array(
                    'kelaspelayanan_id'=>$model->kelaspelayanan_id,
                    'daftartindakan_id'=>$model->daftartindakan_id,
                    'jenistarif_id'=>$model->jenistarif_id,
                    'perdatarif_id'=>$model->perdatarif_id,
                ));

                if($deleteData){
                    $this->notifPerubahanTarifTindakan($model, 'hapus');
                }

                Yii::app()->end();
            }
	}


	public function actionAdmin()
	{
		$model=new TariftindakanperdaV('search');
		$model->unsetAttributes();
		if(isset($_GET['TariftindakanperdaV'])) {
			$model->attributes=$_GET['TariftindakanperdaV'];
                }

		$this->render($this->path_view.'admin',array(
			'model'=>$model,
		));
	}

	public function loadTarifPerdaV($id)
	{
		$model=TariftindakanperdaV::model()->findByAttributes(array('tariftindakan_id'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='satarif-tindakan-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionPrint()
    {
       // if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $model= new TariftindakanperdaV;
        $model->unsetAttributes();
            if (isset($_GET['TariftindakanperdaV'])) {
                      $model->attributes=$_GET['TariftindakanperdaV'];
            }

        $judulLaporan='Data Nominal Tarif';
        $caraPrint=$_REQUEST['caraPrint'];
        $perdaTarif = Params::DEFAULT_PERDA_TARIF;
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF);
			// //$mpdf->useOddEven = 2;

			$mpdf->AddPage($posisi,'','','','',15,15,15,30,15,15);
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);

            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'perdaTarif'=>$per
                ),true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

    public function actionAjaxGetDaftarTindakan()
    {
        if(Yii::app()->request->isAjaxRequest){

            $criteria = new CDbCriteria;
            $criteria->select = array('daftartindakan_nama, daftartindakan_id, kelaspelayanan_id, kategoritindakan_id');
            if (isset($_POST['kategoritindakan_id'])){
				if (!empty($_POST['kategoritindakan_id'])){
					$criteria->addCondition('kategoritindakan_id ='.$_POST['kategoritindakan_id']);
				}
			}
			if (isset($_POST['daftartindakan_id'])){
				if (!empty($_POST['daftartindakan_id'])){
					$criteria->addCondition('daftartindakan_id ='.$_POST['daftartindakan_id']);
				}
			}
            $criteria->order = 'daftartindakan_nama';

            $datas = DaftartindakannontarifV::model()->findAll($criteria);
            $kelas = KelaspelayananM::model()->findByPk($_POST['kelaspelayanan_id']);
            $daftartindakan = DaftartindakanM::model()->findByPk($_POST['daftartindakan_id']);

            $tarifTindakan = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$_POST['daftartindakan_id'], 'kelaspelayanan_id'=>$_POST['kelaspelayanan_id']));
            if (empty($tarifTindakan)){
                $inputHiddenKomponen = '<input type="hidden" size="4" name="komponen[1]" id="komponen_1" readonly="true" value="'.Params::KOMPONENTARIF_ID_TOTAL.'"  class="komponen"/>';
                $tr = '<table id="tblInputTarifTindakan"><th> Pilih Semua <br/>'.CHtml::checkBox('checkUncheck', true, array('onclick'=>'checkUncheckAll(this);')).'</th>
                                   <th>Tindakan</th><th>'.$inputHiddenKomponen.'Tarif Total</th>';
                foreach($datas as $data)
                {
                        $td = "<tr><td>";
                        $td .= CHtml::checkBox('daftartindakan_id[1]', true, array('value'=>$data->getAttribute('daftartindakan_id')));
                        $td .= '</td><td>'.$data->getAttribute('daftartindakan_nama');
                        $td .= '</td><td>'.CHtml::textField('totalHarga[1]', '0', array('size'=>6,'class'=>'default'));
                        $td .= "</td></tr>";
                }
                $tr .= ((!empty($td)) ? $td : '');
                $returnVal['table'] = $tr;
                $returnVal['status'] = 'Not Empty';
            }
            else{
                $returnVal['status'] = 'Empty';
                $returnVal['messege'] = 'Tindakan sudah memiliki tarif';

            }
            if(!empty($datas)){
                echo CJSON::encode($returnVal);
            }else{
                $returnVal['status'] = 'Empty';
                $returnVal['messege'] = 'Daftar Tidak Ditemukan';
                echo CJSON::encode($returnVal);
            }

         }
         Yii::app()->end();
    }

    public function actionTindakan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->select = array('daftartindakan_nama, daftartindakan_id,kategoritindakan_id');
            $criteria->group = 'daftartindakan_nama, daftartindakan_id, kategoritindakan_id';
            if(!empty($_GET['idKategori'])){
                $idKategori = $_GET['idKategori'];
				if (!empty($idKategori)){
					$criteria->addCondition('kategoritindakan_id ='.$idKategori);
				}
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
            }else{
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
            }
            $criteria->order = 'daftartindakan_nama';

            $models = DaftartindakannontarifV::model()->findAll($criteria);
			$returnVal = array();
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->daftartindakan_nama;
                $returnVal[$i]['value'] = $model->daftartindakan_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	/**
	 * untuk mencari data komponen tarif total yang tidak sesuai
	 * @throws CHttpException
	 */
	public function actionCariPerbaikanTarif(){
		if(Yii::app()->request->isAjaxRequest) {
			$data['sukses'] = 0;
			$data['pesan'] = "Pencarian gagal";
			$sql_tarif = "SELECT *
				FROM tariftindakanperda_v
				OFFSET ".($_POST['pageaktif']*10)."
				LIMIT 100
				";
			$tarifKomponens = Yii::app()->db->createCommand($sql_tarif)->queryAll();

			if(count((array)$tarifKomponens) > 0){
				foreach($tarifKomponens AS $i => $tarif){
					$model = new TariftindakanperdaV;
					$model->attributes = $tarif;
					if(!$model->IsKomponenValid){
						$data = $model->attributes;
						$data['sukses'] = 1;
						$data['pesan'] = "Data ditemukan!";
						break; //stop looping
					}else{
						$data['pesan'] = "Data tidak ditemukan!";
					}
				}
			}
			echo CJSON::encode($data);
		}else{
			throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
		}
	}

    public function actionHapusDetailTarif()
    {   $data['status'] = 0;
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['tariftindakan_id'])){
                // $delete = TariftindakanM::model()->deleteByPk($_POST['tariftindakan_id']);
                // if($delete){
                    $data['status'] = 1;
                // }
                echo CJSON::encode($data);
            }
        }else{
           throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
        }
    }

    public function actionSetTarifDet()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {

            $jenistarif_id = $_POST['jenistarif_id'];
            $perdatarif_id = $_POST['perdatarif_id'];
            $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
            $daftartindakan_id = $_POST['daftartindakan_id'];
            $isCreate = $_POST['isCreate'];
            $jeniswaktukerja = $_POST['jeniswaktukerja'];

            $data['form'] = "";
            $data['error'] = 0;
            $criteria = new CDbCriteria;
            $criteria->addCondition('jenistarif_id ='.$jenistarif_id);
            $criteria->addCondition('perdatarif_id ='.$perdatarif_id);
            $criteria->addCondition('kelaspelayanan_id ='.$kelaspelayanan_id);
            $criteria->addCondition('daftartindakan_id ='.$daftartindakan_id);
            $criteria->addCondition("jeniswaktukerja = '".$jeniswaktukerja."'");
            $models = TariftindakanM::model()->findAll($criteria);


            if(count((array)$models) > 0){
                if ($isCreate) $data['error'] = 1;
                else {
                    foreach ($models AS $i=>$model){
                        $data['form'] .= $this->renderPartial($this->path_view.'_rowDetail',array('model'=>$model),true);
                    }
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

	/**
	* @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	*
	* - digunakan untuk membuat notifikasi, jika ada Nominal Tarif baru
	* @param type $modObat
	* @return type
	*/
   public function notifTarifBaru($model) {

	   $judul = 'Nominal Tarif Baru';

	   $isi = $model->kelaspelayanan->kelaspelayanan_nama.' '.$model->jenistarif->jenistarif_nama.' '.$model->daftartindakan->daftartindakan_nama;

	   return CustomFunction::broadcastNotif($judul, $isi, array(
		   array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),
		   array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_BENDAHARA, 'modul_id'=>Params::MODUL_ID_KEUANGAN ),
		   array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_FINANCE, 'modul_id'=>Params::MODUL_ID_KEUANGAN ),
	   ));
   }

		/**
		 * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
		 *
		 * - digunakan untuk membuat notifikasi, jika ada perubahan harga Nominal Tarif
		 * @param type $modObat
		 * @return type
		 */
		public function notifTarifBerubah($model) {

			$judul = 'Perubahan Harga Nominal Tarif';

			$isi = $model->kelaspelayanan->kelaspelayanan_nama.' '.$model->jenistarif->jenistarif_nama.' '.$model->daftartindakan->daftartindakan_nama;

			return CustomFunction::broadcastNotif($judul, $isi, array(
				array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),
				array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_BENDAHARA, 'modul_id'=>Params::MODUL_ID_KEUANGAN ),
				array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_FINANCE, 'modul_id'=>Params::MODUL_ID_KEUANGAN ),
			));
		}

    public function notifPerubahanTarifTindakan($model, $type = 'tambah') {


           $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

           $pegawai = (isset($peg) ? $peg->namaLengkap : "");
           $tindakan = $model->daftartindakan->daftartindakan_nama;
           $jenistarif = $model->jenistarif->jenistarif_nama;
           $kelaspelayanan = $model->kelaspelayanan->kelaspelayanan_nama;
           $tgl = date('d')." ".MyFormatter::getMonthId(date('m'))." ".date('Y H:i:s');
           $text = "Penambahan";

           if($type == 'ubah'){
               $text = "Perubahan";
           }else if($type == 'hapus'){
               $text = "Hapus";
           }

        $judul = $text." Master Nominal Tarif";
	    $isi = "Telah dilakukan ".$text." master data Nominal Tarif oleh ".$pegawai." untuk tindakan ".$tindakan." dengan jenis tarif = ".$jenistarif." dan kelas pelayanan = ".$kelaspelayanan." pada ".$tgl;

	   return CustomFunction::broadcastNotif($judul, $isi, array(
		   array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_AKUNTANSI, 'modul_id'=>Params::MODUL_ID_AKUNTANSI),
		   array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_FINANCE, 'modul_id'=>Params::MODUL_ID_KEUANGAN),
	   ));
   }

	 public function notifPenghapusanTarifTindakan($tindakan, $jenistarif, $kelaspelayanan) {


					$peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
					$daftartindakan = DaftartindakanM::model()->findByPk($tindakan);
					$jenistarif = JenistarifM::model()->findByPk($jenistarif);
					$kelaspel = KelaspelayananM::model()->findByPk($kelaspelayanan);

					$pegawai = (isset($peg) ? $peg->namaLengkap : "");
					$tindakan = (isset($daftartindakan) ? $daftartindakan->daftartindakan_nama : "");
					$jenistarif = (isset($jenistarif) ? $jenistarif->jenistarif_nama : "");
					$kelaspelayanan = (isset($kelaspel) ? $kelaspel->kelaspelayanan_nama : "");
					$tgl = date('d')." ".MyFormatter::getMonthId(date('m'))." ".date('Y H:i:s');
					$text = "Penghapusan";


			 $judul = $text." Master Nominal Tarif";
		 		$isi = "Telah dilakukan ".$text." master data Nominal Tarif oleh ".$pegawai." untuk tindakan ".$tindakan." dengan jenis tarif = ".$jenistarif." dan kelas pelayanan = ".$kelaspelayanan." pada ".$tgl;

		return CustomFunction::broadcastNotif($judul, $isi, array(
			array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_AKUNTANSI, 'modul_id'=>Params::MODUL_ID_AKUNTANSI),
			array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_FINANCE, 'modul_id'=>Params::MODUL_ID_KEUANGAN),
		));
	}


}
