<?php

class PenutupanPeriodeAkuntansiTController extends MyAuthController {

	public $layout = "//layouts/column1";
	public $saldoAwal = true;
	public $updateRekPeriode = false;
        public $path_view = 'akuntansi.views.penutupanPeriodeAkuntansiT.';

	public function actionIndex() {
		$format = new MyFormatter;
		$model = new AKSaldoawalT;
		$modRekPeriod = new AKRekperiodM;
		$modRekPeriod->is_rekeningbaru = 1;
        $modTutup = new PenutupanperiodeakunT;

		// insert Rekening Periode Baru
		if (isset($_POST['AKRekperiodM'])) {      
                    
			$transaction = Yii::app()->db->beginTransaction();
            $period = null;
            $simple_err = false;
			try {
                
                $modTutup = $this->simpanPenutupanPeriodeAkun($modTutup, $_POST);
                $oldRekPeriod = AKRekperiodM::model()->findByPk($_POST['rekperiod_id']);
                
                
				if ($_POST['AKRekperiodM']['is_rekeningbaru']) {
                    $periodeOverlap = $this->periodeOverlap($_POST['AKRekperiodM']);
                    
                    if (count((array)$periodeOverlap) > 0) {
                        $simple_err = true;
                        throw new CDbException("Tanggal periode tidak boleh bersilangan dengan periode yang lain");
                    }
                    
                    
					$modRekPeriod = new AKRekperiodM;
					$modRekPeriod->attributes = $_POST['AKRekperiodM'];
					$modRekPeriod->perideawal = $format->formatDateTimeForDb($_POST['AKRekperiodM']['perideawal']);
					$modRekPeriod->sampaidgn = $format->formatDateTimeForDb($_POST['AKRekperiodM']['perideawal']);
					$modRekPeriod->save();
                    
                    $period = new PeriodepostingM;
                    $period->periodeposting_nama = $period->deskripsiperiodeposting = $modRekPeriod->deskripsi;
                    $period->rekperiode_id = $modRekPeriod->rekperiod_id;
                    $period->tglperiodeposting_awal = $modRekPeriod->perideawal;
                    $period->tglperiodeposting_akhir = $modRekPeriod->sampaidgn;
                    $period->create_time = date('Y-m-d H:i:s');
                    $period->create_loginpemakai_id = Yii::app()->user->id;
                    $period->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    
                    $period->save();
				} else {
                    $cr = new CDbCriteria();
                    $cr->addCondition("perideawal > '".$oldRekPeriod->sampaidgn."'");
                    $cr->addCondition("isclosing = false");
                    $cr->order = 'perideawal asc';
                    
                    
                    $modRekPeriod = AKRekperiodM::model()->find($cr);
                    
                    if (empty($modRekPeriod)) {
                        $simple_err = true;
                        throw new CDbException("Periode Akuntansi berikutnya tidak ditemukan.");
                    }
                    
                    $period = PeriodepostingM::model()->findByAttributes(array(
                        'rekperiode_id'=>$modRekPeriod->rekperiod_id,
                    ));
                    
                    if (empty($period)) {
                        $simple_err = true;
                        throw new CDbException("Periode Akuntansi berikutnya belum dibuat.");
                    }
                }
                // die;
				// insert saldoawal_t
				$totalDebit = $format->formatNumberForDb($_POST['totalDebit']);
				$totalKredit = $format->formatNumberForDb($_POST['totalKredit']);
                
                // cek 
                $laba_tahun_ini_debit = 0;
                $laba_tahun_ini_kredit = 0;
                foreach ($_POST['AKSaldoawalT'] as $i => $detail) {
                    if (date('m', strtotime($oldRekPeriod->sampaidgn)) == '12' && in_array($detail['rekening5_id'], array(Params::REKENING5_ID_LABARUGI_DITAHAN, Params::REKENING5_ID_LABARUGI_BERJALAN))) {
                        $laba_tahun_ini_debit += $detail['jmlsaldoawald'];
                        $laba_tahun_ini_kredit += $detail['jmlsaldoawalk'];
                    }
                }
                
				foreach ($_POST['AKSaldoawalT'] as $i => $detail) {
                    if($detail['jmlsaldoawald'] == 0 && $detail['jmlsaldoawalk'] == 0 && $detail['rekening5_id'] != Params::REKENING5_ID_LABARUGI_DITAHAN){
                        continue;
                    }
                    
                    $modDet = $this->simpanPenutupanPeriodeDetail($modTutup, $detail);
                    
                    $jmlsaldoawald = $detail['jmlsaldoawald'];
					$jmlsaldoawalk = $detail['jmlsaldoawalk'];
                    if (date('m', strtotime($oldRekPeriod->sampaidgn)) == '12' && $modDet->rekening5_id == Params::REKENING5_ID_LABARUGI_BERJALAN) {
                        $jmlsaldoawald = 0;
                        $jmlsaldoawalk = 0;
                    }
                    
                    if (date('m', strtotime($oldRekPeriod->sampaidgn)) == '12' && $modDet->rekening5_id == Params::REKENING5_ID_LABARUGI_DITAHAN) {
                        $jmlsaldoawald = $laba_tahun_ini_debit;
                        $jmlsaldoawalk = $laba_tahun_ini_kredit;
                    }
                    
                    $rek = Rekening5M::model()->findByAttributes(array(
                        'rekening5_id'=>$modDet->rekening5_id,
                    )); 
                    
                    
					$modDetail = new AKSaldoawalT;
					$modDetail->attributes = $detail;
					$modDetail->jmlsaldoawald = $jmlsaldoawald;
					$modDetail->jmlsaldoawalk = $jmlsaldoawalk;
                    $modDetail->jmlanggaran = 0;
                    $modDetail->jmlmutasid = 0;
					$modDetail->jmlmutasik = 0;

                    $jmlsaldoakhird = 0;
                    $jmlsaldoakhirk = 0;

                    if(!empty($modDetail->rekening5)){
                        if($modDetail->rekening5->rekening5_nb == 'D'){
                            $jmlAkhirSaldo = (($modDetail->jmlsaldoawald - $modDetail->jmlsaldoawalk) + ($modDetail->jmlmutasid - $modDetail->jmlmutasik));

                            if($jmlAkhirSaldo > 0){
                                $jmlsaldoakhird = $jmlAkhirSaldo;
                            }else{
                                $jmlsaldoakhirk = abs($jmlAkhirSaldo);
                            }
                        }else{
                            $jmlAkhirSaldo = (($modDetail->jmlsaldoawald + $modDetail->jmlsaldoawalk) + ($modDetail->jmlmutasid + $modDetail->jmlmutasik));

                            if($jmlAkhirSaldo > 0){
                                $jmlsaldoakhirk = $jmlAkhirSaldo;
                            }else{
                                $jmlsaldoakhird = abs($jmlAkhirSaldo);
                            }
                        }
                    }
					
					$modDetail->jmlsaldoakhird = $jmlsaldoakhird;
					$modDetail->jmlsaldoakhirk = $jmlsaldoakhirk;
					$modDetail->create_time = $modRekPeriod->perideawal;
					$modDetail->create_loginpemakai_id = Yii::app()->user->id;
					$modDetail->create_ruangan = Yii::app()->user->ruangan_id;
                    $modDetail->penutupanperiodedet_id = $modDet->penutupanperiodedet_id;
                    
                    $modDetail->rekening1_id = $rek->rekening1_id;
                    $modDetail->rekening2_id = $rek->rekening2_id;
                    $modDetail->rekening3_id = $rek->rekening3_id;
                    $modDetail->rekening4_id = $rek->rekening4_id;
                    $modDetail->rekening5_id = $rek->rekening5_id;
                    
                    $modDetail->rekperiod_id = $modRekPeriod->rekperiod_id;
                    $modDetail->periodeposting_id = $period->periodeposting_id;
                    
                    $modDetail->matauang_id = 1; // mata uang rupiah
                    $kurs = KursrpM::model()->findByAttributes(array(
                        'matauang_id'=>$modDetail->matauang_id,
                    ), array(
                        'order'=>'tglkursrp desc',
                    ));
                    
                    if (!empty($kurs)) {
                        $modDetail->kursrp_id = $kurs->kursrp_id;
                    }
                    
					if ($modDetail->validate()) {
						$this->saldoAwal = $this->saldoAwal && $modDetail->save();
					} else {
						$this->saldoAwal &= false;
					}
				}
				
                $disPeriod = PeriodepostingM::model()->findAllByAttributes(array(
                    'rekperiode_id'=>$oldRekPeriod->rekperiod_id,
                ));
                foreach ($disPeriod as $item) {
                    PeriodepostingM::model()->updateByPk($item->periodeposting_id, array(
                        'periodeposting_aktif'=>false,
                    ));
                }
                
				// update rekperiod_m isclosing = 'TRUE'  
				if ($this->saldoAwal) {
					$updateRekPeriode = RekperiodM::model()->updateByPk($_POST['AKSaldoawalT'][0]['rekperiod_id'], array('isclosing' => true));
					if ($updateRekPeriode) {
						$this->updateRekPeriode = true;
					}
				}
                
				if ($this->saldoAwal && $this->updateRekPeriode) {
                    // die;
					$transaction->commit();
					$this->redirect(array('index', 'sukses' => 1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data Penutupan Periode Rekening gagal disimpan !");
				}
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data Penutupan Periode Rekening gagal disimpan ! " . MyExceptionMessage::getMessage($e, true, $simple_err));
			
                $model = new AKSaldoawalT;
                $modRekPeriod = new AKRekperiodM;
                $modRekPeriod->is_rekeningbaru = 1;
                $modTutup = new PenutupanperiodeakunT;
            }
		}
//		
		$this->render('index', array(
			'format' => $format,
			'modRekPeriod' => $modRekPeriod
		));
	}
    
    
    public function simpanSaldoAwalLRBerjalan0($modDetail, $period, $modRekPeriod) {
        $saldoAwal = new AKSaldoawalT;
        $saldoAwal->attributes = $modDetail->attributes;
        
        // $rek = Rekening5M::model()->findByAttributes(array(
        //     'rekening5_id'=>$saldoAwal->rekening5_id,
        // ));

        // $saldoAwal->rekening1_id = $rek->rekening1_id;
        // $saldoAwal->rekening2_id = $rek->rekening2_id;
        // $saldoAwal->rekening3_id = $rek->rekening3_id;
        // $saldoAwal->rekening4_id = $rek->rekening4_id;

        $saldoAwal->rekperiod_id = $modRekPeriod->rekperiod_id;
        $saldoAwal->periodeposting_id = $period->periodeposting_id;
        
        $saldoAwal->jmlsaldoawalk = 0;
        $saldoAwal->jmlsaldoawald = 0;
        $saldoAwal->jmlanggaran = 0;

        $saldoAwal->matauang_id = 1; // mata uang rupiah
        $kurs = KursrpM::model()->findByAttributes(array(
            'matauang_id'=>$saldoAwal->matauang_id,
        ), array(
            'order'=>'tglkursrp desc',
        ));

        if (!empty($kurs)) {
            $modDetail->kursrp_id = $kurs->kursrp_id;
        }


        if ($saldoAwal->validate()) {
            $this->saldoAwal = $this->saldoAwal && $saldoAwal->save();
        } else {
            $this->saldoAwal &= false;
        }
    }
    
    public function periodeOverlap($post) {
        $cr = new CDbCriteria;
        $tgl_awal = MyFormatter::formatDateTimeForDB($post['perideawal']);
        $tgl_akhir = MyFormatter::formatDateTimeForDB($post['sampaidgn']);
        
        
        $cr->addCondition("'".$tgl_awal."'::date between perideawal and sampaidgn or "
            . "'".$tgl_akhir."'::date between perideawal and sampaidgn");
        
        return RekperiodM::model()->findAll($cr);
    }
    
    public function simpanPenutupanPeriodeDetail($modTutup, $detail)
    {
        $mod = new PenutupanperiodedetT;
        $mod->penutupanperiodeakun_id = $modTutup->penutupanperiodeakun_id;
        $mod->rekening5_id = $detail['rekening5_id'];
        $mod->saldodebit = $detail['jmlsaldoawald'];
        $mod->saldokredit = $detail['jmlsaldoawalk'];
        $mod->create_time = date('Y-m-d H:i:s');
        $mod->create_loginpemakai_id = Yii::app()->user->id;
        $mod->create_ruangan = Yii::app()->user->getState('ruangan_id');
        
        if ($mod->validate()) {
            $this->saldoAwal = $this->saldoAwal && $mod->save();
        }
        
        
        return $mod;
    }
    
    public function simpanPenutupanPeriodeAkun($modTutup, $post) {
        // simpan transaksi penutupan periode akuntansi
        $modTutup->rekperiod_id = $post['rekperiod_id'];
        $modTutup->tglpenutupan = date('Y-m-d H:i:s');
        $modTutup->nopenutupan = MyGenerator::noPenutupanPeriodeAkun();
        $modTutup->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $modTutup->saldodebit = MyFormatter::formatRupiahForDB($post['totalDebit']);
        $modTutup->saldokredit = MyFormatter::formatRupiahForDB($post['totalKredit']);
        $period = PeriodepostingM::model()->findByAttributes(array(
            'rekperiode_id'=>$modTutup->rekperiod_id,
        ));
        $modTutup->periodeposting_id = $period->periodeposting_id;

        $modTutup->create_time = date('Y-m-d H:i:s');
        $modTutup->create_loginpemakai_id = Yii::app()->user->id;
        $modTutup->create_ruangan = Yii::app()->user->getState('ruangan_id');
        
        if ($modTutup->validate()) {
            $this->saldoAwal = $this->saldoAwal && $modTutup->save();
        }
        
        return $modTutup;
    }
    

	/**
	 * menampilkan data pencarian rekening baru
	 * @return row table 
	 */
	public function actionCariRekeningBaru() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter;
			$pesan = '';
			$deskripsi = '';
			$rekperiod_id = '';
			$perideawal = $format->formatDateTimeForDb($_POST['perideawal']);
			$sampaidgn = $format->formatDateTimeForDb($_POST['sampaidgn']);

			$criteria = new CDbCriteria();
			$criteria->addCondition("DATE(perideawal) = '" . $perideawal . "'");
			$criteria->addCondition("DATE(sampaidgn) = '" . $sampaidgn . "'");
			$criteria->addCondition('isclosing IS FALSE');
			$modRekPeriod = AKRekperiodM::model()->find($criteria);

			if (!empty($modRekPeriod)) {
				$pesan = "Ada";
				$deskripsi = $modRekPeriod->deskripsi;
				$rekperiod_id = $modRekPeriod->rekperiod_id;
			}

			echo CJSON::encode(array(
				'rekperiod_id' => $rekperiod_id,
				'deskripsi' => $deskripsi,
				'pesan' => $pesan,
					)
			);
			exit;
		}
	}

	/**
	 * menampilkan data rekening
	 * @return row table 
	 */
	public function actionLoadTabelRekening() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter;
			$modSaldoAwal = new AKSaldoawalT;
			$pesan = '';
			$rekperiod_id = $_POST['rekperiod_id'];

            $oldRekPeriod = RekperiodM::model()->findByPk($rekperiod_id);

            $tglawal_now = $oldRekPeriod->perideawal;
            $tglakhir_now = $oldRekPeriod->sampaidgn;
            
            $criteria_r5 = new CDbCriteria();
            $criteria_r5->select= "t.rekening5_id, t.rekening5_nb";
            $criteria_r5->join = "LEFT JOIN rekening5_m as t2 ON t.rekening5_id = t2.parent_id";
            $criteria_r5->addCondition('t.rekening5_aktif = true');
            $criteria_r5->addCondition('t2.rekening5_id IS NULL');
            $criteria_r5->order = "t.kdrekening5 ASC";
            $rek = Rekening5M::model()->findAll($criteria_r5);

            // $rek = Rekening5M::model()->findAllByAttributes(array(
            //     'rekening5_aktif'=>true,
            // ), array(
            //     'order'=>'kdrekening5',
            // ));
            
            $modRekenings = array();
			$criteria = new CDbCriteria;
			$criteria->join = "JOIN periodeposting_m ON periodeposting_m.periodeposting_id = t.periodeposting_id "
                . "join rekening5_m r5 on r5.rekening5_id = t.rekening5_id";
			$criteria->group = "t.periodeposting_id,t.rekening5_id, r5.kdrekening5";
			$criteria->select = $criteria->group . ", SUM(t.saldodebit) AS saldodebit, SUM(t.saldokredit) AS saldokredit";
            $criteria->order = 'r5.kdrekening5';
			if (!empty($this->periodeposting_id)) {
				$criteria->addCondition('t.periodeposting_id = ' . $this->periodeposting_id);
			}
			if (!empty($rekperiod_id)) {
				$criteria->addCondition('periodeposting_m.rekperiode_id = ' . $rekperiod_id);
			}
            
            $criteria->addCondition('r5.rekening5_aktif = true');
            $criteria->addCondition('t.saldoawal_id is null');
            $criteria->addCondition('t.rekening5_id = :rekening5_id');

            if(!empty($tglawal_now) && !empty($tglakhir_now)){
                $criteria->addBetweenCondition('t.tglbukubesar::date', $tglawal_now, $tglakhir_now);
            }

            $per = PeriodepostingM::model()->findByAttributes(array(
                'rekperiode_id'=>$rekperiod_id
            ));

            $com = Yii::app()->db->createCommand(
                "select distinct on (t.rekening5_id) t.rekening5_id, r.rekening5_nb, perideawal, t.saldoawal_id, r.tiperekening_id, "
                . "sum(t.jmlsaldoawald) as jmlsaldoawald, sum(t.jmlsaldoawalk) as jmlsaldoawalk, sum(t.jmlsaldoakhird) as jmlsaldoakhird, sum(t.jmlsaldoakhirk) as jmlsaldoakhirk "
                . "from saldoawal_t t join rekening5_m r on r.rekening5_id = t.rekening5_id "
                . "join rekperiod_m rkp on rkp.rekperiod_id = t.rekperiod_id "
                . "where rkp.perideawal::date between '" . $tglawal_now . "'::date and '" . $tglawal_now . "'::date "
                . "or rkp.sampaidgn::date between '" . $tglawal_now . "'::date and '" . $tglawal_now . "'::date "
                . "group by t.rekening5_id, t.rekening5_id, r.rekening5_nb, perideawal, t.saldoawal_id, r.tiperekening_id "
                . "order by t.rekening5_id desc"
            )->queryAll();

            $dat_saldo_awal = array();
            foreach ($com as $item) {
                $sadebit = 0;
                $sakredit = 0;

                if($item['tiperekening_id'] != 4){
                    continue;
                }
            
                if($item['rekening5_nb'] == 'D'){
                    $sadebit = $item['jmlsaldoawald'];
                    $sakredit = (0 - $item['jmlsaldoawalk']);
                }else{
                    $sadebit = (0 - $item['jmlsaldoawald']);
                    $sakredit = $item['jmlsaldoawalk'];
                }
            
                $dat_saldo_awal[$item['rekening5_id']] = array(
                    'saldoawal_id' => $item['saldoawal_id'],
                    'saldo_awal_debit' => $sadebit,
                    'saldo_awal_kredit' => $sakredit,
                );
            }
            $tglawal_periode = null;
            $tglakhir_periode = null;
            $tglawal_periode = null;
            $tglakhir_periode = null;
            
            $deskripsi = "";
            
            if(!empty($per->periodeposting_id)){
                foreach ($rek as $item) {
                    $mod = new AKBukubesarT;
                    $mod->attributes = $item->attributes;
                    $mod->saldodebit = $mod->saldokredit = 0;
                    $mod->periodeposting_id = $per->periodeposting_id;
                    
                    $criteria->params[':rekening5_id'] = $item->rekening5_id;
                   
                    $bb = BukubesarT::model()->find($criteria);
                    $saldoawal_d = 0;
                    $saldoawal_k = 0;
                    $saldoawal_total = 0;
    
                    if (!empty($dat_saldo_awal[$item->rekening5_id])) {
                        $saldoawal_d = $dat_saldo_awal[$item->rekening5_id]['saldo_awal_debit'];
                        $saldoawal_k = $dat_saldo_awal[$item->rekening5_id]['saldo_awal_kredit'];
                        $saldoawal_total = ($saldoawal_d + $saldoawal_k);
                    }
                    
                    $totalsaldoMutasi  = 0;
                    if (!empty($bb)) {
                        $sadebit = 0;
                        $sakredit = 0;
                        
                        if($item->rekening5_nb == 'K'){
                            $totalsaldoMutasi = ($bb->saldokredit - $bb->saldodebit);
                        }else{
                            $totalsaldoMutasi = ($bb->saldodebit - $bb->saldokredit);
                        }
    
    
                        // $mod->saldodebit = $sadebit;
                        // $mod->saldokredit = $sakredit;
                        $mod->periodeposting_id = $bb->periodeposting_id;
                    }
    
                    $saldoakhir = ($saldoawal_total + $totalsaldoMutasi);
                    
                    if($item->rekening5_nb == 'D'){
                        if($saldoakhir > 0){
                            $mod->saldodebit = $saldoakhir;
                            $mod->saldokredit = 0;
                        }else{
                            $mod->saldokredit = abs($saldoakhir);
                            $mod->saldodebit = 0;
                        }
                    }else{
                        if($saldoakhir > 0){
                            $mod->saldokredit = $saldoakhir;
                            $mod->saldodebit = 0;
                        }else{
                            $mod->saldodebit = abs($saldoakhir);
                            $mod->saldokredit = 0;
                        }
                    }
                    
                    // if ($mod->saldodebit > $mod->saldokredit) {
                    //     $mod->saldodebit = $mod->saldodebit - $mod->saldokredit;
                    //     $mod->saldokredit = 0;
                    // } else {
                    //     $mod->saldokredit = $mod->saldokredit - $mod->saldodebit;
                    //     $mod->saldodebit = 0;
                    // }
                    
                    
                    $modRekenings[] = $mod;
                }
                $pesan = "Ada";

                $cr = new CDbCriteria();
                $cr->addCondition('isclosing = false and rekperiod_id <> '.$rekperiod_id);
                $cr->addCondition("perideawal > '".$oldRekPeriod->sampaidgn."'");
                $periode_lanjut = RekperiodM::model()->find($cr);
                
                
                if (empty($periode_lanjut)) {
                    $tgl_awal = date('Y-m-1', strtotime('+1 month', strtotime($oldRekPeriod->sampaidgn)));
                    $tgl_akhir = date('Y-m-t', strtotime($tgl_awal));
                    
                    $tglawal_periode = date('d M Y', strtotime($tgl_awal));
                    $tglakhir_periode = date('d M Y', strtotime($tgl_akhir));
                    
                    $deskripsi = "Periode ".MyFormatter::getMonthId(date('m', strtotime($tgl_awal)))." ".date('Y', strtotime($tgl_awal));
                }
            }

            
            
//            
//            
            // Cek Periode Selanjutnya
            // $oldRekPeriod = RekperiodM::model()->findByPk($rekperiod_id);
            
            

			echo CJSON::encode(array(
                'periode_kosong'=>empty($periode_lanjut) ? 1 : 0,
                'tglawal_periode'=>$tglawal_periode,
                'tglakhir_periode'=>$tglakhir_periode,
                'deskripsi_periode'=>$deskripsi,
				'pesan' => $pesan,
				'form' => $this->renderPartial('_rowRekening', array(
					'format' => $format,
					'modRekenings' => $modRekenings,
					'modSaldoAwal' => $modSaldoAwal
						), true))
			);
			exit;
		}
	}

	public function actionAutocompleteRekeningPeriode() {
		if (Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(deskripsi)', strtolower($_GET['deskripsi']), true);
			$criteria->order = 'rekperiod_id';
			$criteria->limit = 5;
			$models = AKRekperiodM::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->deskripsi;
				$returnVal[$i]['value'] = $model->rekperiod_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
    
    
    public function actionInformasi() {
        $model = new PenutupanperiodeakunT;  
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');
                
        if (isset($_GET['PenutupanperiodeakunT'])) {
            $model->attributes = $_GET['PenutupanperiodeakunT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PenutupanperiodeakunT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PenutupanperiodeakunT']['tgl_akhir']);
        }
        
        
        $this->render('informasi', array(
            'model'=>$model,
        ));
    }
    
     public function actionPrintInformasi()
    {
        $model = new PenutupanperiodeakunT;  
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');
                
        if (isset($_GET['PenutupanperiodeakunT'])) {
            $model->attributes = $_GET['PenutupanperiodeakunT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PenutupanperiodeakunT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PenutupanperiodeakunT']['tgl_akhir']);
        }
		
        $judulLaporan='Penutupan Periode Akuntansi';
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'PrintInformasi',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'PrintInformasi',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            //$mpdf->useOddEven = 2;  
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);  
            $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'PrintInformasi',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
            $mpdf->Output($judulLaporan."_".date('Y-m-d').'.pdf','I');
        }                       
    }
    
    public function actionDetail($id) {
        $this->layout = '//layouts/iframe';
        
        $model = PenutupanperiodeakunT::model()->findByPk($id);
        $det = PenutupanperiodedetT::model()->findAllByAttributes(array(
            'penutupanperiodeakun_id'=>$id,
        ));
            
        $this->render('detail', array(
            'model'=>$model,
            'det'=>$det,
        ));
    }

}
