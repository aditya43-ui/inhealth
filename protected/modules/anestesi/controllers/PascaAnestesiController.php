<?php

class PascaAnestesiController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view='anestesi.views.pascaAnestesi.';
	public $path_tips='anestesi.views.tips.';
	
	public $pasienanestesitersimpan = false;
	public $pascaanestesitersimpan = false;
	public $kondisipasienanastesitersimpan = true;

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionIndex($pascaanestesi_id = null, $pasienanastesi_id = null)
	{
		$format = new MyFormatter();
		$model = new ATPasienanastesiT();
		$modPascaAnestesi = new ATPascaanestesiT();
		$modPraAnestesi = new ATPraanestesiT();
		$modKondisiPasienAnestesi = new ATKondisipasienanestesiT();
		$modDetails = array();
		
		$modPascaAnestesi->tglpascaanestesi = date('Y-m-d H:i:s');
		$modPascaAnestesi->nopascaanestesi = "-Otomatis-";
		
		$pasienanastesi_id = isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null;
		if(!empty($pasienanastesi_id)){
			$model = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);
			$pasienanastesi_id = $_GET['pasienanastesi_id'];
		}
		
		if(!empty($pascaanestesi_id)){
			$modPascaAnestesi = ATPascaanestesiT::model()->findByPk($pascaanestesi_id);
			if(!empty($modPascaAnestesi)){
			$pasienanas_id = $modPascaAnestesi->pasienanastesi_id;
			$criteria = new CDbCriteria();
			$criteria->addCondition('pasienanastesi_id = '.$pasienanas_id);
			$modKunjungan = ATInformasiintraanestesiV::model()->find($criteria);
			if(!isset($modKunjungan)){
				$modKunjungan = new ATInformasiintraanestesiV();
			}
				$modDetails = ATKondisipasienanestesiT::model()->findAllByAttributes(array('intraanestesi_id'=>$modPascaAnestesi->intraanestesi_id));					
			}
			
		}
		
		if(!empty($pasienanastesi_id)) {
			$criteria = new CDbCriteria();
			$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
			$modKunjungan = ATInformasiintraanestesiV::model()->find($criteria);
			if(isset($modKunjungan)){
				$modPascaAnestesi = ATPascaanestesiT::model()->findByAttributes(array('pasienanastesi_id'=>$modKunjungan->pasienanastesi_id,'pascaanestesi_id'=>$pascaanestesi_id));
				if(!isset($modPascaAnestesi)){
					$modPascaAnestesi = new ATPascaanestesiT();
				}
				$modDetails = ATKondisipasienanestesiT::model()->findAllByAttributes(array('intraanestesi_id'=>$modKunjungan->intraanestesi_id)); 
			}			
		}else{
			$modKunjungan = new ATInformasiintraanestesiV();
		}
		
		if(isset($_POST['ATPascaanestesiT']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$pasienanastesi_id = isset($_POST['ATPascaanestesiT']['pasienanastesi_id']) ? $_POST['ATPascaanestesiT']['pasienanastesi_id'] : null;
				$model = $this->simpanPasienAnestesi($_POST['ATPascaanestesiT']);
				
				$modPascaAnestesi = $this->simpanPascaAnestesi($model, $modPascaAnestesi, $_POST['ATPascaanestesiT']);
				if(isset($_POST['ATKondisipasienanestesiT'])){
					if(count($_POST['ATKondisipasienanestesiT']) > 0){
						foreach($_POST['ATKondisipasienanestesiT'] as $i=>$pemantauan){
							$modDetailsPemantauan[$i] = $this->SimpanKondisiPemantauan($modPascaAnestesi,$pemantauan);																					
						}
					}
				}
				if($this->pasienanestesitersimpan && $this->pascaanestesitersimpan && $this->kondisipasienanastesitersimpan){
					$transaction->commit();
					$modPascaAnestesi->isNewRecord = FALSE;
					$this->redirect(array('index','pascaanestesi_id'=>$modPascaAnestesi->pascaanestesi_id,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data Pasca Anestesi gagal disimpan !");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				$btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
						. "<i class='icon-refresh icon-white'></i> Simpan Ulang"
						. "</a>";
				Yii::app()->user->setFlash('error',"Data Pasca Anestesi gagal disimpan ! ".$btn_ulang." ".MyExceptionMessage::getMessage($exc,true));
			}
		}

		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'modKunjungan'=>$modKunjungan,
			'model'=>$model,
			'modPraAnestesi'=>$modPraAnestesi,
			'modPascaAnestesi'=>$modPascaAnestesi,
			'modKondisiPasienAnestesi'=>$modKondisiPasienAnestesi,
			'modDetails'=>$modDetails,
		));
	}
	
	
	/**
	* proses simpan / ubah data pasien anastesi
	* @param type $model
	* @param type $post
	* @return type
	*/
	public function simpanPasienAnestesi($post){
		$format = new MyFormatter();
		if( (!empty($post['pasienanastesi_id']))){
			$model = ATPasienanastesiT::model()->findByPk($post['pasienanastesi_id']);
			$modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
		}
		$model->tglanastesi = isset($model->tglanestesi) ? $model->tglanestesi : date('Y-m-d H:i:s');

		if(empty($post['pasienanastesi_id'])){
			$model->pasien_id = $modPendaftaran->pasien_id;
			$model->pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;
			$model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$model->create_loginpemakai_id = Yii::app()->user->id;
			$model->create_time = date('Y-m-d H:i:s');
			$model->noanestesi = MyGenerator::noAnestesi();
			$model->statusanestesi = 'Pasca Anestesia';
		}else{
			$model->statusanestesi = 'Pasca Anestesia';
			$model->update_loginpemakai_id = Yii::app()->user->id;
			$model->update_time = date('Y-m-d H:i:s');
			if(empty($model->noanestesi)){
				$model->noanestesi = MyGenerator::noAnestesi();
			}
		}

		if($model->save()){
			$this->pasienanestesitersimpan = true;
		}

		return $model;
	}
		
	/**
	* proses simpan / ubah data pasca anastesi
	* @param type $model
	* @param type $post
	* @return type
	*/
	public function simpanPascaAnestesi($model, $modPascaAnestesi, $post){
		$format = new MyFormatter();
		$modPendaftaran = array();
		if(isset($modPascaAnestesi->pascaanestesi_id) && (!empty($post['pascaanestesi_id']))){
			$load = new $modPascaAnestesi;
			$modPascaAnestesi = ATPascaanestesiT::model()->findByPk($modPascaAnestesi->pascaanestesi_id);
		}
		$modPascaAnestesi->attributes = $post;
		
		$modPascaAnestesi->tglpascaanestesi = $format->formatDateTimeForDb($modPascaAnestesi->tglpascaanestesi);
		
		if(empty($modPascaAnestesi->pascaanestesi_id)){
			$modPascaAnestesi->pasienanastesi_id = $post['pasienanastesi_id'];
			$modPascaAnestesi->intraanestesi_id = $modPascaAnestesi->intraanestesi_id;
			$modPascaAnestesi->nopascaanestesi = MyGenerator::noPascaAnestesi();
			$modPascaAnestesi->ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modPascaAnestesi->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modPascaAnestesi->create_loginpemakai_id = Yii::app()->user->id;
			$modPascaAnestesi->create_time = date('Y-m-d H:i:s');		   
		}else{
			$modPascaAnestesi->update_loginpemakai_id = Yii::app()->user->id;
			$modPascaAnestesi->update_time = date('Y-m-d H:i:s');
		}

		if($modPascaAnestesi->save()){
			$this->pascaanestesitersimpan = true;
		}

		return $modPascaAnestesi;
	}
	
	/**
	* proses simpan KondisipasienanestesiT
	*/
	public function simpanKondisiPemantauan($modPascaAnestesi, $post){
		$format = new MyFormatter();
		if(!empty($post['kondisipasienanestesi_id'])){
			$modKondisiPasienAnestesi = ATKondisipasienanestesiT::model()->findByPk($post['kondisipasienanestesi_id']);
		}else{
			$modKondisiPasienAnestesi = new ATKondisipasienanestesiT();
		}		
		$modKondisiPasienAnestesi->attributes = $post;
		$modKondisiPasienAnestesi->intraanestesi_id = $modPascaAnestesi->intraanestesi_id;
		$modKondisiPasienAnestesi->pascaanestesi_id = $modPascaAnestesi->pascaanestesi_id;
		$modKondisiPasienAnestesi->tglpemantauan = isset($post['tglpemantauan']) ? $format->formatDateTimeForDb($post['tglpemantauan']) : date('Y-m-d H:i:s');
		
		if($modKondisiPasienAnestesi->validate()){
			if($modKondisiPasienAnestesi->save()){
				$this->kondisipasienanastesitersimpan &= true;
			}
		}else{
			$this->kondisipasienanastesitersimpan &= false;
		}

		return $modKondisiPasienAnestesi;
   }
   
	/**
	*penggunaannya
	* 1. digunakan di rencana tindakan obat dan alkes - Pra Anestesia
	* @param type $encode
	* @param type $namaModel
	* @param type $attr 
	*/
   public function actionSetDropdownKamarKosong($encode=false,$namaModel='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $ruangan_id = (isset($_POST['ruanganpasca_id']) ? $_POST['ruanganpasca_id'] : null);
		   if (empty($ruangan_id) && isset($_POST[$namaModel]['ruanganpasca_id']))
			   $ruangan_id = $_POST[$namaModel]['ruanganpasca_id'];

		   $kamarKosong = array();
		   
		   if(!empty($ruangan_id)) {
				$kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
				$kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
		   }

		   if($encode){
			   echo CJSON::encode($kamarKosong);
		   } else {
			   if(empty($kamarKosong)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
				   foreach($kamarKosong as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
   }
   
   /**
	*penggunaannya
	* 1. digunakan di rencana tindakan obat dan alkes - Pra Anestesia
	* @param type $encode
	* @param type $namaModel
	* @param type $attr 
	*/
   public function actionSetDropDownRuangan($encode=false,$namaModel='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $instalasi_id = (isset($_POST['instalasipasca_id']) ? $_POST['instalasipasca_id'] : null);
		   if (empty($instalasi_id) && isset($_POST[$namaModel]['instalasipasca_id']))
			   $instalasi_id = $_POST[$namaModel]['instalasipasca_id'];

		   $ruangan = array();
		   
		   if(!empty($instalasi_id)) {
				$ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id,'ruangan_aktif'=>true),array('order'=>'ruangan_nama ASC'));
				$ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
		   }

		   if($encode){
			   echo CJSON::encode($ruangan);
		   } else {
			   if(empty($ruangan)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
				   foreach($ruangan as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
   }
   
	/**
	* get data pasien anastesi
	*/
	public function actionGetDataPasien(){
	   if (Yii::app()->request->isAjaxRequest){
		   $format = new MyFormatter();
		   $returnVal = array();
		   $pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;
		   if(!empty($pasienanastesi_id)){
				$criteria = new CdbCriteria();
				$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
				$model = ATInformasipasienanestesiV::model()->find($criteria);				
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal["$attribute"] = $model->$attribute;
				}
				$returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
				$returnVal["tglanastesi"] = $format->formatDateTimeForUser($model->tglanastesi);
		   }
		   echo CJSON::encode($returnVal);
		   Yii::app()->end();
	   }
	}
	
	/**
     * Mengurai data kunjungan berdasarkan:
     * - pasienmasukpenunjang_id
	 * - pasienanastesi_id
	 * - pendaftaran_id
	 * - intraanestesi_id
     * @throws CHttpException
     */
    public function actionGetDataKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();
			
			$intraanestesi_id = isset($_POST['intraanestesi_id']) ? $_POST['intraanestesi_id'] : null;
			$praanestesi_id = isset($_POST['praanestesi_id']) ? $_POST['praanestesi_id'] : null;
			$pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;
			
			if(!empty($intraanestesi_id)){
				$criteria->addCondition('intraanestesi_id ='.$intraanestesi_id);
			}
			if(!empty($praanestesi_id)){
				$criteria->addCondition('praanestesi_id ='.$praanestesi_id);
			}
			
            $model = ATInformasiintraanestesiV::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {				
                $returnVal["$attribute"] = $model->$attribute;
            }
			$modPraAnestesi = ATPraanestesiT::model()->findByPk($model->praanestesi_id);
			$modPendaftaran = ATPendaftaranT::model()->findByAttributes(array('pasien_id'=>$model->pasien_id),array('order'=>'pendaftaran_id DESC'));
            $returnVal["tglintraanestesi"] = $format->formatDateTimeForUser($model->tglintraanestesi);
			
            if(!empty($modPraAnestesi)){
				$returnVal["dokter_id"] = $modPraAnestesi->dokter_id;
				$returnVal["perawat1_id"] = $modPraAnestesi->perawat1_id;
				$returnVal["perawat2_id"] = $modPraAnestesi->perawat2_id;
				$returnVal["instalasipasca_id"] = $modPraAnestesi->instalasipasca_id;
				$returnVal["ruanganpasca_id"] = $modPraAnestesi->ruanganpasca_id;
				$returnVal["kamarruangan_id"] = $modPraAnestesi->kamarruangan_id;
			}
			if(!empty($modPendaftaran)){
				$returnVal["umur"] = $modPendaftaran->umur;
				$returnVal["jeniskelamin"] = $modPendaftaran->pasien->jeniskelamin;
				$returnVal["jeniskasuspenyakit_id"] = $modPendaftaran->jeniskasuspenyakit_id;
				$returnVal["jeniskasuspenyakit_nama"] = isset($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama) ? $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : "";
				$returnVal["pegawai_id"] = $modPendaftaran->pegawai_id;
				$returnVal["nama_pegawai"] = isset($modPendaftaran->pegawai->NamaLengkap) ? $modPendaftaran->pegawai->NamaLengkap : "";
				$returnVal["no_rekam_medik"] = isset($modPendaftaran->pasien->no_rekam_medik) ? $modPendaftaran->pasien->no_rekam_medik : "";
				$returnVal["nama_pasien"] = isset($modPendaftaran->pasien->nama_pasien) ? $modPendaftaran->pasien->nama_pasien : "";
				$returnVal["jeniskelamin"] = isset($modPendaftaran->pasien->jeniskelamin) ? $modPendaftaran->pasien->jeniskelamin : "";
				$returnVal["pekerjaan_id"] = isset($modPendaftaran->pasien->pekerjaan_id) ? $modPendaftaran->pasien->pekerjaan_id : "";;
				$returnVal["pekerjaan_nama"] = isset($modPendaftaran->pasien->pekerjaan->pekerjaan_nama) ? $modPendaftaran->pasien->pekerjaan->pekerjaan_nama : "";
				$returnVal["kelaspelayanan_id"] = $modPendaftaran->kelaspelayanan_id;
				$returnVal["kelaspelayanan_nama"] = isset($modPendaftaran->kelaspelayanan->kelaspelayanan_nama) ? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama : "";
				$returnVal["alamat_pasien"] = isset($modPendaftaran->pasien->alamat_pasien) ? $modPendaftaran->pasien->alamat_pasien : "";
			}
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	/**
    * untuk menampilkan data kunjungan dari autocomplete
    * - no_anestesi
    * - no_rekam_medik
    * - nama_pasien
    */
    public function actionAutocompleteKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nointraanestesi = isset($_GET['nointraanestesi']) ? $_GET['nointraanestesi'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
			
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nointraanestesi)', strtolower($nointraanestesi), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->addCondition("DATE(tglintraanestesi) = '".date("Y-m-d")."'");
            $criteria->limit = 5;
			
            $models = ATInformasiintraanestesiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nointraanestesi."-".$model->no_rekam_medik.'-'.$model->nama_pasien;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	/**
     * Mengurai data pra anestesi berdasarkan:
	 * - praanestesi_id
     * @throws CHttpException
     */
    public function actionGetDataPraAnestesi()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();
			
			$pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;
			
			if(!empty($pasienanastesi_id)){
				$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
			}
			$criteria->order = 'praanestesi_id DESC';
            $model = ATPraanestesiT::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tglpuasa"] = (!empty($model->tglpuasa) ? date("d/m/Y H:i:s",strtotime($model->tglpuasa)) : date("d/m/Y H:i:s"));;
            $returnVal["tglpraanestesi"] = (!empty($model->tglpraanestesi) ? date("d/m/Y H:i:s",strtotime($model->tglpraanestesi)) : date("d/m/Y H:i:s"));;;
            $returnVal["typeanastesi_id"] = $model->pasienanastesi->typeanastesi_id;
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	/**
     * Mengurai data kondisi anestesi berdasarkan:
	 * - intraanestesi_id
     * @throws CHttpException
     */
    public function actionSetDataKondisiPasienAnestesi()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			
			$intraanestesi_id = (isset($_POST['intraanestesi_id']) ? $_POST['intraanestesi_id'] : null);
			
			$modIntraAnestesi = ATIntraanestesiT::model()->findByPk($intraanestesi_id);
			$modKondisiPasien = ATKondisipasienanestesiT::model()->findAllByAttributes(array('intraanestesi_id'=>$intraanestesi_id));
						
			if(count($modKondisiPasien) > 0){
				foreach($modKondisiPasien AS $i => $kondisi){
					$form .= $this->renderPartial($this->path_view.'_rowPemantauanKondisi', array('modKondisiPasienAnestesi'=>$kondisi), true);
				}
			}else{
				$pesan = "Pemantauan kondisi pasien tidak ditemukan!";
			}

			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}
    }
	
	/**
	* set dropdown daerah pasien berdasarkan
	* propinsi_id
	* kabupaten_id
	* kecamatan_id
	* kelurahan_id
	* pasien_id
	*/
	public function actionSetDropDownKamarRuangan()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$modPraAnestesi = new ATPraanestesiT();
			$ruangan_id = $_POST['ruanganpasca_id'];
			$kamarruangan_id = $_POST['kamarruangan_id'];
			
			$ruangans = RuanganM::model()->findAll('instalasi_id = '.Params::INSTALASI_ID_RI.' AND ruangan_aktif = TRUE');
			$ruangans = CHtml::listData($ruangans,'ruangan_id','ruangan_nama');
			$ruanganOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
			foreach($ruangans as $value=>$name)
			{
				if($value==$ruangan_id)
					$ruanganOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
				else
					$ruanganOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
			}

			$kamarruangans = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
			$kamarruangans = CHtml::listData($kamarruangans,'kamarruangan_id','KamarDanTempatTidur');
			$kamarruanganOptions = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
			foreach($kamarruangans as $value=>$name)
			{
				if($value==$kamarruangan_id)
					$kamarruanganOptions .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
				else
					$kamarruanganOptions .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
			}

			$dataList['listRuangan'] = $ruanganOption;
			$dataList['listKamarruangan'] = $kamarruanganOptions;

			echo json_encode($dataList);
			Yii::app()->end();
		}
	}
   
	/**
     * untuk print data pasca anestesia
     */
    public function actionPrintHasil($pascaanestesi_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
		$modPascaAnestesi = ATPascaanestesiT::model()->findByPk($pascaanestesi_id);
        $modKondisiPasien = ATKondisipasienanestesiT::model()->findAllByAttributes(array('pascaanestesi_id'=>$modPascaAnestesi->pascaanestesi_id));
		if(!empty($modPascaAnestesi->intraanestesi_id)){
			$modPraAnestesi = ATPraanestesiT::model()->findByAttributes(array('praanestesi_id'=>$modPascaAnestesi->intraanestesi->praanestesi_id));
		}
        $judul_print = 'Pasca Anastesi';
        
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
				'modPascaAnestesi'=>$modPascaAnestesi,
                'modKondisiPasien'=>$modKondisiPasien,
				'modPraAnestesi'=>$modPraAnestesi,
                'caraprint'=>$caraprint
        ));
    }
}
