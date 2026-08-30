<?php

class SaldoAwalController extends MyAuthController
{
    public function actionIndex()
    {
        $this->pageTitle = Yii::app()->name . " - Saldo Awal";
        $model = new AKSaldoawalT;
        $AKSaldorekeningV = new AKRekening5M;		
		
		if (isset($_POST['AKSaldoawalT'])){			
			$ok = true;
			$trans = Yii::app()->db->beginTransaction();
			try{
				foreach ($_POST['AKSaldoawalT'] as $i => $val){				
					if (isset($val['cekList'])){

						if (empty($val['saldoawal_id'])){
							
							$model = new AKSaldoawalT;
							$model->attributes = $val;

                            $orijmlsaldoawald = 0;
                            $orijmlsaldoawalk = 0;

                            $modjmlsaldoawald = MyFormatter::formatRupiahForDB($val['jmlsaldoawald']);
                            $modjmlsaldoawalk = MyFormatter::formatRupiahForDB($val['jmlsaldoawalk']);

							$model->attributes = $val;
                            $nilaiDebit = ($modjmlsaldoawald - $orijmlsaldoawald);
                            $nilaiKredit = ($modjmlsaldoawalk - $orijmlsaldoawalk);
                            
                            $mutasid = 0;
                            $mutasik = 0;

                            if(!empty($model->rekening5)){
                                if($model->rekening5->rekening5_nb == 'D'){
                                    if($nilaiDebit > 0){
                                        $mutasid = $nilaiDebit;
                                    }else{
                                        $mutasik = abs($nilaiDebit);
                                    }
                                }else{
                                    if($nilaiKredit > 0){
                                        $mutasik = $nilaiKredit;
                                    }else{
                                        $mutasid = abs($nilaiKredit);
                                    }
                                }
                            }

                            $model->jmlmutasid = $mutasid;
							$model->jmlmutasik = $mutasik;

                            $model->jmlanggaran = 0;
							$model->jmlsaldoawald = $orijmlsaldoawald;
							$model->jmlsaldoawalk = $orijmlsaldoawalk;

                            $jmlsaldoakhird = 0;
                            $jmlsaldoakhirk = 0;

                            if(!empty($model->rekening5)){
                                if($model->rekening5->rekening5_nb == 'D'){
                                    $jmlAkhirSaldo = (($model->jmlsaldoawald - $model->jmlsaldoawalk) + ($model->jmlmutasid - $model->jmlmutasik));

                                    if($jmlAkhirSaldo > 0){
                                        $jmlsaldoakhird = $jmlAkhirSaldo;
                                    }else{
                                        $jmlsaldoakhirk = abs($jmlAkhirSaldo);
                                    }
                                }else{
                                    $jmlAkhirSaldo = (($model->jmlsaldoawald + $model->jmlsaldoawalk) + ($model->jmlmutasid + $model->jmlmutasik));

                                    if($jmlAkhirSaldo > 0){
                                        $jmlsaldoakhirk = $jmlAkhirSaldo;
                                    }else{
                                        $jmlsaldoakhird = abs($jmlAkhirSaldo);
                                    }
                                }
                            }

                            $model->jmlsaldoakhird = $jmlsaldoakhird;
							$model->jmlsaldoakhirk = $jmlsaldoakhirk;
							$model->create_time = date('Y-m-d H:i:s');
							$model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
							$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
						}else{
							$model = AKSaldoawalT::model()->findByPk($val['saldoawal_id']);
                            $orijmlsaldoawald = $model->jmlsaldoawald;
                            $orijmlsaldoawalk = $model->jmlsaldoawalk;

                            $modjmlsaldoawald = MyFormatter::formatRupiahForDB($val['jmlsaldoawald']);
                            $modjmlsaldoawalk = MyFormatter::formatRupiahForDB($val['jmlsaldoawalk']);

							$model->attributes = $val;
                            $nilaiDebit = ($modjmlsaldoawald - $orijmlsaldoawald);
                            $nilaiKredit = ($modjmlsaldoawalk - $orijmlsaldoawalk);
                            
                            $mutasid = 0;
                            $mutasik = 0;

                            if(!empty($model->rekening5)){
                                if($model->rekening5->rekening5_nb == 'D'){
                                    if($nilaiDebit > 0){
                                        $mutasid = $nilaiDebit;
                                    }else{
                                        $mutasik = abs($nilaiDebit);
                                    }
                                }else{
                                    if($nilaiKredit > 0){
                                        $mutasik = $nilaiKredit;
                                    }else{
                                        $mutasid = abs($nilaiKredit);
                                    }
                                }
                            }

                            $model->jmlmutasid = $mutasid;
							$model->jmlmutasik = $mutasik;

                            $model->jmlanggaran = 0;
							$model->jmlsaldoawald = $orijmlsaldoawald;
							$model->jmlsaldoawalk = $orijmlsaldoawalk;

                            $jmlsaldoakhird = 0;
                            $jmlsaldoakhirk = 0;

                            if(!empty($model->rekening5)){
                                if($model->rekening5->rekening5_nb == 'D'){
                                    $jmlAkhirSaldo = (($model->jmlsaldoawald - $model->jmlsaldoawalk) + ($model->jmlmutasid - $model->jmlmutasik));

                                    if($jmlAkhirSaldo > 0){
                                        $jmlsaldoakhird = $jmlAkhirSaldo;
                                    }else{
                                        $jmlsaldoakhirk = abs($jmlAkhirSaldo);
                                    }
                                }else{
                                    $jmlAkhirSaldo = (($model->jmlsaldoawald + $model->jmlsaldoawalk) + ($model->jmlmutasid + $model->jmlmutasik));

                                    if($jmlAkhirSaldo > 0){
                                        $jmlsaldoakhirk = $jmlAkhirSaldo;
                                    }else{
                                        $jmlsaldoakhird = abs($jmlAkhirSaldo);
                                    }
                                }
                            }

                            $model->jmlsaldoakhird = $jmlsaldoakhird;
							$model->jmlsaldoakhirk = $jmlsaldoakhirk;
							$model->update_time = date('Y-m-d H:i:s');
							$model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');						
						}

						if($model->save()){
                            $ok = true;
                        }else{
                            $ok = false; 
                        }
					}
				}

				if ($ok){
					$trans->commit();	
					Yii::app()->user->setFlash("success","Data berhasil Disimpan");
					
					$this->redirect(array('index', 'sukses' => 1));
					
				}else{
					$trans->rollback();
					Yii::app()->user->setFlash("error","Data Gagal Disimpan");
				}
			}catch(Exception $e){	
				$trans->rollback();
				Yii::app()->user->setFlash("error","Data Gagal Disimpan");
			}
		}
		
		if (isset($_GET['AKRekening5M'])) {
			$AKSaldorekeningV->attributes = $_GET['AKRekening5M'];
			$AKSaldorekeningV->tiperekening_id = $_GET['AKRekening5M']['tiperekening_id'];
			$AKSaldorekeningV->periodeposting_id = $_GET['AKRekening5M']['periodeposting_id'];
			
			$period = AKPeriodepostingM::model()->findByPk($AKSaldorekeningV->periodeposting_id);
			
			if (!empty($period)){
				$AKSaldorekeningV->rekperiod_id = $period->rekperiode_id;
			}
						
		}
		
        $this->render('indexBaru', array(
                'model' => $model,
                'AKSaldorekeningV'=>$AKSaldorekeningV
            )
        );
    }
    
    public function actionSimpanSaldoRekening()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = array();
            $transaction = Yii::app()->db->beginTransaction();
            parse_str($_REQUEST['data'], $data_parsing);
            
            $is_simpan = true;
            $action = 'insert';
            $is_exist = false;
			
            try{
                $model = new AKSaldoawalT;
                $data_parsing['AKSaldoawalT']['create_ruangan'] = Yii::app()->user->getState('ruangan_id');
                $data_parsing['AKSaldoawalT']['update_loginpemakai_id'] = Yii::app()->user->id;
                $data_parsing['AKSaldoawalT']['update_time'] = date('Y-m-d');
				$data_parsing['AKSaldoawalT']['jmlanggaran'] = MyFormatter::formatRupiahForDB($data_parsing['AKSaldoawalT']['jmlanggaran']);
				$data_parsing['AKSaldoawalT']['jmlsaldoawald'] = MyFormatter::formatRupiahForDB($data_parsing['AKSaldoawalT']['jmlsaldoawald']);
				$data_parsing['AKSaldoawalT']['jmlsaldoawalk'] = MyFormatter::formatRupiahForDB($data_parsing['AKSaldoawalT']['jmlsaldoawalk']);

                if(strlen($data_parsing['AKSaldoawalT']['saldoawal_id']) > 0)
                {
					$period = PeriodepostingM::model()->findByPk($data_parsing['AKSaldoawalT']['periodeposting_id']);
					
                    $model->rekperiod_id = $period->rekperiode_id;
                    //$model->periodeposting_id = $data_parsing['AKSaldoawalT']['periodeposting_id'];
                    $is_exist = $model->isExis($data_parsing['AKSaldoawalT']['saldoawal_id']);
					
                    if(!$is_exist){
						//Var_dump($is_exist);die;
                        $attributes = array(
                            'rekperiod_id'=>$model->rekperiod_id,
                            //'periodeposting_id'=>$data_parsing['AKSaldoawalT']['periodeposting_id'],
                            'matauang_id'=>$data_parsing['AKSaldoawalT']['matauang_id'],
                            'kursrp_id'=>$data_parsing['AKSaldoawalT']['kursrp_id'],
                            'jmlanggaran'=>$data_parsing['AKSaldoawalT']['jmlanggaran'],
                            'jmlsaldoawald'=>$data_parsing['AKSaldoawalT']['jmlsaldoawald'],
                            'jmlsaldoawalk'=>$data_parsing['AKSaldoawalT']['jmlsaldoawalk'],
                            /*
                            'jmlmutasid'=>$data_parsing['AKSaldoawalT']['jmlmutasid'],
                            'jmlmutasik'=>$data_parsing['AKSaldoawalT']['jmlmutasik'],
                            'jmlsaldoakhird'=>$data_parsing['AKSaldoawalT']['jmlsaldoakhird'],
                            'jmlsaldoakhirk'=>$data_parsing['AKSaldoawalT']['jmlsaldoakhirk'],
                             * 
                             */
                            'update_time'=>date('Y-m-d H:i:s'),
                            'update_loginpemakai_id'=>Yii::app()->user->id
                        );
						
                        $is_simpan = AKSaldoawalT::model()->findByPk($data_parsing['AKSaldoawalT']['saldoawal_id']);                        
						$is_simpan->attributes = $attributes;			
						$is_simpan->save();
									
						//echo "kick"; die;
						
                    }else{
                        $is_simpan = false;
                    }
                    $action = 'update';
                    $id_rekening = $data_parsing['AKSaldoawalT'];
					
                }else{
					
                    $attributes = array(
                        'rekperiod_id' => !isset($data_parsing['AKSaldoawalT']['rekperiod_id'])?null:$data_parsing['AKSaldoawalT']['rekperiod_id'],
                        'rekening1_id' => $data_parsing['AKSaldoawalT']['rekening1_id'],
                        'rekening2_id' => $data_parsing['AKSaldoawalT']['rekening2_id']
                    );
                    
                    if($data_parsing['AKSaldoawalT']['rekening3_id'] != null)
                    {
                        $attributes['rekening3_id'] = $data_parsing['AKSaldoawalT']['rekening3_id'];
                    }
                    
                    if($data_parsing['AKSaldoawalT']['rekening4_id'] != null)
                    {
                        $attributes['rekening4_id'] = $data_parsing['AKSaldoawalT']['rekening4_id'];
                    }
                    
                    if($data_parsing['AKSaldoawalT']['rekening5_id'] != null)
                    {
                        $attributes['rekening5_id'] = $data_parsing['AKSaldoawalT']['rekening5_id'];
                    }                    
                    $id_rekening = $attributes;
					
//					if($data_parsing['AKSaldoawalT']['rekening3_id'] != null)
//                    {
//                        $attributes['rekening3_id'] = $data_parsing['AKSaldoawalT']['rekening3_id'];
//                    }
//                    if($data_parsing['AKSaldoawalT']['rekening4_id'] != null)
//                    {
//                        $attributes['rekening4_id'] = $data_parsing['AKSaldoawalT']['rekening4_id'];
//                    }

					$is_exist = $model->findByAttributes($attributes);
                    if(!$is_exist)
                    {
                        $data_parsing['AKSaldoawalT']['create_loginpemakai_id'] = Yii::app()->user->id;
                        $data_parsing['AKSaldoawalT']['create_time'] = date('Y-m-d');
                        $is_simpan = $this->simpanRekening($model, $data_parsing['AKSaldoawalT']);
//			                  $this->simpanParentRekening($model, $data_parsing['AKSaldoawalT'], $attributes);
                    }else{
                        $is_simpan = false;
                    }
                    
                }
                
                if($is_simpan)
                {
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                }
            } catch (Exception $exc){
							
						//echo $exc->getMessage();die;
                $is_simpan = true;
                $action = $exc;
                $transaction->rollback();
            }
            
            $result = array(
                'id_rekening' => $id_rekening,
                'pesan' => ($is_exist == true ? 'exist' : $action),
                'status' => ($is_simpan == true ? 'ok' : 'not'),
            );
            
            echo json_encode($result);
            Yii::app()->end();            
        }        
    }
    
    protected function simpanRekening($model, $params)
    {

        $model->attributes = $params;
		$model->periodeposting_id = $params['periodeposting_id'];
		
		if (empty($model->unitkerja_id)) $model->unitkerja_id = Yii::app()->user->getState('unitkerja_id');
		
		$pos = PeriodepostingM::model()->findByPk($model->periodeposting_id);
		
		$model->rekperiod_id = $pos->rekperiode_id;
		
		// var_dump($model->attributes); die;
        if($model->validate()){
            if($model->save()){
                return true;
            }else{
                return false;
            }
        }else{
            print_r($model->getErrors());
            return false;
        }        
    }
    
    public function actionEditSaldoRekening()
    {
        $this->layout = '//layouts/iframe';
        $id = $_GET['id'];
        $model = AKSaldoawalT::model()->findByPk($id);
        
        if(isset($_POST['AKSaldoawalT']))
        {
           $pos = PeriodepostingM::model()->findByPk($_POST['AKSaldoawalT']['periodeposting_id']);
			
            $attributes = array(
                'rekperiod_id'=>$pos->rekperiode_id,
				'periodeposting_id'=>$_POST['AKSaldoawalT']['periodeposting_id'],
                'matauang_id'=>$_POST['AKSaldoawalT']['matauang_id'],
                'kursrp_id'=>$_POST['AKSaldoawalT']['kursrp_id'],
                'jmlanggaran'=>$_POST['AKSaldoawalT']['jmlanggaran'],
                'jmlsaldoawald'=>$_POST['AKSaldoawalT']['jmlsaldoawald'],
                'jmlsaldoawalk'=>$_POST['AKSaldoawalT']['jmlsaldoawalk'],
                'jmlmutasid'=>$_POST['AKSaldoawalT']['jmlmutasid'],
                'jmlmutasik'=>$_POST['AKSaldoawalT']['jmlmutasik'],
                'jmlsaldoakhird'=>$_POST['AKSaldoawalT']['jmlsaldoakhird'],
                'jmlsaldoakhirk'=>$_POST['AKSaldoawalT']['jmlsaldoakhirk'],
                'update_time'=>date('Y-m-d'),
                'update_loginpemakai_id'=>Yii::app()->user->id
            );
            $update = AKSaldoawalT::model()->updateByPk($id, $attributes);
            
            if($update){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            }
        }
        
        $this->render('__formInputSaldoRekening', array(
                'model' => $model
            )
        );
    }

    public function actionGetInformasiSaldo()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $id = $_POST['id'];
            $model = AKSaldoawalT::model()->findByPk($id);
			$model->jmlanggaran = MyFormatter::formatNumberForPrint($model->jmlanggaran, 2);
			$model->jmlsaldoawald = MyFormatter::formatNumberForPrint($model->jmlsaldoawald, 2);
			$model->jmlsaldoawalk = MyFormatter::formatNumberForPrint($model->jmlsaldoawalk, 2);
            echo json_encode($model->attributes);
            Yii::app()->end();
        }        
    }

    private function simpanParentRekening($model, $params, $attrb)
    {
        foreach ($attrb as $key => $value) {
            if($key != 'rekperiod_id')
            {
                
            }
        }
    }
    
    public function actionPrint()
    {
        $model= new AKRekeningakuntansiV;
		
		
		if (isset($_GET['AKRekeningakuntansiV'])) {
			$model->attributes = $_GET['AKRekeningakuntansiV'];
		//	$AKSaldorekeningV->periodeposting_id = $_GET['AKRekeningakuntansiV']['periodeposting_id'];
			$model->tiperekening_id = $_GET['AKRekeningakuntansiV']['tiperekening_id'];
			$model->periodeposting_id = $_GET['AKRekeningakuntansiV']['periodeposting_id'];
			
			$period = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);
			
			if (!empty($period)){
				$model->rekperiod_id = $period->rekperiode_id;
			}
						
		}
		
        $judulLaporan='MASTER SALDO AWAL';
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render('PrintBaru',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render('PrintBaru',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
             $footer = '
            <table width="100%">
            <tr>'
            . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
            . '</tr>
             <tr>'
            . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : '.MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')).'</b></i></td>'
            . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : '.$this->pageTitle=Yii::app()->user->nama_pemakai.' </b></i></td>'
            . '</tr>
            </table>';
            $mpdf->SetHtmlFooter($footer,'E');
            $mpdf->SetHtmlFooter($footer,'O');  
            ////$mpdf->useOddEven = 1;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);			
			$period = '';
			if (!empty($model->periodeposting_id)){
				$period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
			}

			$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10),true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('PrintBaru',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
            $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
        }                       
    }
	
	/**
     * Mengatur dropdown priode posting
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownPeriodePosting($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $rekperiod_id = null;
            if($model_nama !=='' && $attr == ''){
                $rekperiod_id = $_POST["$model_nama"]['rekperiod_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $rekperiod_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $rekperiod_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(AKPeriodepostingM::model()->getTglPeriode($rekperiod_id),'periodeposting_id','periodeposting_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(count((array)$models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    public function actionInformasi()
    {
        $model = new AKInformasisaldoawalV;
		//$model->unsetAttributes();
		$periodPost = AKPeriodepostingM::model()->find("  periodeposting_aktif = TRUE AND (date(tglperiodeposting_awal) < '".date('Y-m-d')."' AND date(tglperiodeposting_akhir) > '".date('Y-m-d')."' ) ");
		
		if (!empty($periodPost)){
			$model->periodeposting_id = $periodPost->periodeposting_id;
		}
		
         

        if(isset($_GET['AKInformasisaldoawalV'])){
            $model->attributes=$_GET['AKInformasisaldoawalV'];
			$model->periodeposting_id=isset($_GET['AKInformasisaldoawalV']['periodeposting_id'])?$_GET['AKInformasisaldoawalV']['periodeposting_id']:null;
			//$model->periodeposting_id=isset($_GET['AKInformasisaldoawalV']['periodeposting_id'])?$_GET['AKInformasisaldoawalV']['periodeposting_id']:null;
			//var_dump($model->attributes);die;
        }

		/*
        // ===== Rekening 1 =====
        // $criteria->addBetweenCondition('tglbuktijurnal', $modelLaporan->tglAwal, $modelLaporan->tglAkhir);
        $criteria = new CDbCriteria;
        $criteria->select = 'kdrekening1, rekening1_id, nmrekening1, count(nmrekening1) as jmlrekening, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
        $criteria->compare('LOWER(nmrekening5)',strtolower($model->nmrekening5),true);
        $criteria->compare('LOWER(kdrekening5)',strtolower($model->kdrekening5),true);
        $criteria->group = 'kdrekening1, nmrekening1, rekening1_id';
        $criteria->order = 'rekening1_id';
        $rekening1 = AKInformasisaldoawalV::model()->findAll($criteria);

        // ===== Rekening 2 =====
        $criteria = new CDbCriteria;
        $criteria->select = 'kdrekening2, rekening1_id, rekening2_id, nmrekening2, count(nmrekening2) as jmlrekening, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
        $criteria->compare('LOWER(nmrekening5)',strtolower($model->nmrekening5),true);
        $criteria->compare('LOWER(kdrekening5)',strtolower($model->kdrekening5),true);
        $criteria->group = 'kdrekening2, nmrekening2, rekening2_id, rekening1_id';
        $criteria->order = 'rekening1_id, rekening2_id';
        $rekening2 = AKInformasisaldoawalV::model()->findAll($criteria);

        // ===== Rekening 3 =====
        $criteria = new CDbCriteria;
        $criteria->select = 'kdrekening3, rekening1_id, rekening2_id, rekening3_id, nmrekening3, count(nmrekening3) as jmlrekening, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
        $criteria->compare('LOWER(nmrekening5)',strtolower($model->nmrekening5),true);
        $criteria->compare('LOWER(kdrekening5)',strtolower($model->kdrekening5),true);
        $criteria->group = 'kdrekening3, nmrekening3, rekening3_id, rekening2_id, rekening1_id';
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id';
        $rekening3 = AKInformasisaldoawalV::model()->findAll($criteria);

        // ===== Rekening 4 =====
        $criteria = new CDbCriteria;
        $criteria->select = 'kdrekening4, rekening1_id, rekening2_id, rekening3_id, rekening4_id, nmrekening4, count(nmrekening4) as jmlrekening, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
        $criteria->compare('LOWER(nmrekening5)',strtolower($model->nmrekening5),true);
        $criteria->compare('LOWER(kdrekening5)',strtolower($model->kdrekening5),true);
        $criteria->group = 'kdrekening4, nmrekening4,  rekening4_id, rekening3_id, rekening2_id, rekening1_id';
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id';
        $rekening4 = AKInformasisaldoawalV::model()->findAll($criteria);

        // ===== Rekening 5 =====
        $criteria = new CDbCriteria;
        $criteria->select = 'kdrekening5, rekening1_id, nmrekening1, rekening2_id, nmrekening2, rekening3_id, nmrekening3, rekening4_id, nmrekening4, rekening5_id, nmrekening5, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
        $criteria->compare('LOWER(nmrekening5)',strtolower($model->nmrekening5),true);
        $criteria->compare('LOWER(kdrekening5)',strtolower($model->kdrekening5),true);
        $criteria->group = 'kdrekening5, nmrekening5, rekening5_id, nmrekening4, rekening4_id, nmrekening3, rekening3_id, nmrekening2, rekening2_id, nmrekening1, rekening1_id';
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id';
        $rekening5 = AKInformasisaldoawalV::model()->findAll($criteria);
		*/
		
		
		
		
		
		
		$criteria = new CDbCriteria;
        //$criteria->select = 'kdrekening1, rekening1_id, nmrekening1, count(nmrekening1) as jmlrekening, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
        $criteria->compare('LOWER(nmrekening5)',strtolower($model->nmrekening5),true);
        $criteria->compare('LOWER(kdrekening5)',strtolower($model->kdrekening5),true);
		$criteria->compare('unitkerja_id', $model->unitkerja_id);
		if (!empty($model->periodeposting_id)){			
			$criteria->addCondition('periodeposting_id ='.$model->periodeposting_id);
		}
        //$criteria->group = 'kdrekening5, nmrekening5, rekening5_id';
        //$criteria->order = 'kdrekening5 ASC';
		$criteria->addCondition('jmlsaldoawald <> 0 or jmlsaldoawalk <> 0');
        // $criteria->having = 'sum(jmlsaldoawald) <> 0 or sum(jmlsaldoawalk) <> 0';
		$saldoawal = AKInformasisaldoawalV::model()->findAll($criteria);
		
        $this->render('informasi',array(
            //'model'=>$model, 'rekening1'=>$rekening1, 'rekening2'=>$rekening2, 'rekening3'=>$rekening3, 'rekening4'=>$rekening4, 'rekening5'=>$rekening5,
			'model'=>$model, 'saldoawal'=>$saldoawal,
        ));
    }
	
	public function actionPrintInfoSaldoAwal() {
		$this->layout = '//layouts/printWindows';
		$model = new AKInformasisaldoawalV;
        $model->unsetAttributes(); 

        if(isset($_GET['AKInformasisaldoawalV'])){
            $model->attributes=$_GET['AKInformasisaldoawalV'];
			$model->periodeposting_id=isset($_GET['AKInformasisaldoawalV']['periodeposting_id'])?$_GET['AKInformasisaldoawalV']['periodeposting_id']:null;			
        }

		$criteria = new CDbCriteria;        
        $criteria->compare('LOWER(nmrekening5)',strtolower($model->nmrekening5),true);
        $criteria->compare('LOWER(kdrekening5)',strtolower($model->kdrekening5),true);
		$criteria->compare('unitkerja_id', $model->unitkerja_id);
		if (!empty($model->periodeposting_id)){
			$criteria->addCondition('periodeposting_id ='.$model->periodeposting_id);
		}       
		$criteria->addCondition('jmlsaldoawald <> 0 or jmlsaldoawalk <> 0');        
		$saldoawal = AKInformasisaldoawalV::model()->findAll($criteria);
		
        $this->render('informasiPrint',array(            
			'model'=>$model, 'saldoawal'=>$saldoawal,'caraPrint'=>$_GET['caraPrint'],'judulLaporan'=>'Informasi Saldo Awal'
        ));
	}
}
