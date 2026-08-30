<?php
class JurnalPengajuanBonusThrController extends MyAuthController {
    public $path_view = "kepegawaian.views.jurnalPengajuanBonusThr.";

    public function actionIndex() {


        if (isset($_POST['form_cari']) && isset($_POST['form_cari']['pengbonusthrdetail_id']) && isset($_POST['form_cari']['rekening'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
              $nopengajuan = "-";
              if (isset($_POST['form_cari']['pengbonusthrdetail_id'])) {
                  $pengbonusthrdetail_id = CJSON::decode($_POST['form_cari']['pengbonusthrdetail_id']);
                  foreach ($pengbonusthrdetail_id as $id) {
                    $findPengajuanDetail = PengbonusthrdetailT::model()->findByPk($id);
                    if(isset($findPengajuanDetail)){
                      $findPengajuan = PengbonusthrT::model()->findByPk($findPengajuanDetail->pengbonusthr_id);

                      if(isset($findPengajuan)){
                        $nopengajuan = $findPengajuan->nopengajuan;
                      }
                    }
                  }
              }
                $rekening = $this->simpanJurnal($_POST['form_cari'], $ok, $nopengajuan);
                $ok = $ok && $this->simpanJurnalDetail($rekening, $_POST['form_cari']);

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan ! ".MyExceptionMessage::getMessage($ex, true));

            }


        }

        $this->render($this->path_view."index", array());
    }


    protected function simpanJurnal($post, &$ok, $nopengajuan) {

        $period = Yii::app()->user->getState('periode_ids');
        if (is_array($period)) {
            $period = $period[0];
        }

        $model = new JurnalrekeningT();
        $periodePengajuan = MyFormatter::formatMonthForDb($post['periodegaji']);
        $periodePegawai = MyFormatter::getMonthUserGaji(date('m',strtotime($periodePengajuan))).' '.date('Y',strtotime($periodePengajuan));

        $model->urianjurnal = "Pengajuan ".$post['jenisgaji']." Pegawai Periode ".$periodePegawai;
        $model->jenisjurnal_id = 3;
        $model->tglbuktijurnal = $model->tglreferensi = $model->create_time = date('Y-m-d H:i:s');
        $model->noreferensi = $nopengajuan;

        $modJenisjurnal = JenisjurnalM::model()->findByPk($model->jenisjurnal_id);
        $model->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
        $model->kodejurnal = MyGenerator::kodeJurnalRek();

        $periodeID = $period;
        $model->rekperiod_id = $periodeID;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
            $ok = $ok && $model->save();
            if (isset($post['pengbonusthrdetail_id'])) {
                $pengbonusthrdetail_id = CJSON::decode($post['pengbonusthrdetail_id']);
                foreach ($pengbonusthrdetail_id as $id) {
                    PengbonusthrdetailT::model()->updateByPk($id, array(
                        'jurnalrekening_id'=>$model->jurnalrekening_id
                    ));
                }
            }
        } else {
            $ok = false;
        }

        return $model;
    }

    protected function simpanJurnalDetail($rekening, $post) {
        $ok = true;

        $idx = 1;
        foreach ($post['rekening'] as $rekening_id => $item) {

            $rek = RekeningakuntansiV::model()->findByAttributes(array(
                'rekeninglast_id'=>$rekening_id
            ));

            $detail = new JurnaldetailT();
            $detail->jurnalrekening_id = $rekening->jurnalrekening_id;
            $detail->rekperiod_id = $rekening->rekperiod_id;
            $detail->rekening5_id = $rekening_id;
            // $detail->rekening4_id = $rek->rekening4_id;
            // $detail->rekening3_id = $rek->rekening3_id;
            // $detail->rekening2_id = $rek->rekening2_id;
            // $detail->rekening1_id = $rek->rekening1_id;
            $detail->nourut = $idx++;
            $detail->uraiantransaksi = $rekening->urianjurnal;
            $detail->saldodebit = $item['debit'];
            $detail->saldokredit = $item['kredit'];

            if ($detail->validate()) {
                $ok = $ok && $detail->save();
            } else {
                $ok = false;
            }
        }

        return $ok;
    }

    public function actionLoadPengajuan() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $jumlah_pegawai = 0;
        $total_pengajuan = 0;
        $totalpph21 = 0;
        $totalthp = 0;
        $pengbonusthrdetail_id = array();

        $html = "";

        if (isset($_POST['form_cari'])) {

            $cr = new CDbCriteria();
            $cr->select = "t.pengbonusthrdetail_id, t.pegawai_id, p.jenisgaji, t.totalthr, t.nilaibonus, t.totalpajak, t.tunjangan_pph_21_thr, t.tunjangan_pph_21_bonus, t.pajakbonus, t.thp_thr, t.thp_bonus";
            $cr->join = "join pengbonusthr_t p on p.pengbonusthr_id = t.pengbonusthr_id "
                    . " LEFT JOIN jurnalrekening_t j ON j.jurnalrekening_id = t.jurnalrekening_id";
            $cr->compare('p.periodebonusthr', MyFormatter::formatMonthForDb($_POST['form_cari']['periodegaji'])."-01");
            $cr->compare("p.jenisgaji", $_POST['form_cari']['jenisgaji']);
            $cr->addCondition("p.tgl_menyetujui is not null");
            $cr->addCondition("t.isimport = true");
            $cr->addCondition('j.jurnalrekening_id is null');


            $jenisgaji = $_POST['form_cari']['jenisgaji'];

            $model = PengbonusthrdetailT::model()->findAll($cr);

            foreach ($model as $item) {
                $pengbonusthrdetail_id[] = $item->pengbonusthrdetail_id;
                $jumlah_pegawai++;

                if($item->jenisgaji =='THR'){
                    $total_pengajuan += $item->totalthr;
                    $totalpph21 += ($item->totalpajak + $item->tunjangan_pph_21_thr);
                    $totalthp += $item->thp_thr;
                }else{
                  $total_pengajuan += $item->nilaibonus;
                  $totalpph21 += ($item->pajakbonus + $item->tunjangan_pph_21_bonus);
                  $totalthp += $item->thp_thr;
                }
            }

            if($total_pengajuan > 0){
                $rekd_pengajuan = RekeningcolumnM::model()->findByAttributes(array(
                    'table_name'=> Params::REKENINGCOLUMN_TABLE_PENGBONUSTHRDETAILT,
                    'column_name'=> Params::REKENINGCOLUMN_COLUMN_TOTALTHR,
                    'debitkredit'=>'D'
                ));

                if(isset($rekd_pengajuan)){
                    $html .= $this->renderPartial($this->path_view.'_rowRekening', array('rekening'=>$rekd_pengajuan, 'debitkredit'=>'D', 'nilai'=>$total_pengajuan), true);
                }
            }

            if($totalpph21 > 0){
                $rekd_pph21 = RekeningcolumnM::model()->findByAttributes(array(
                    'table_name'=> Params::REKENINGCOLUMN_TABLE_PENGBONUSTHRDETAILT,
                    'column_name'=> Params::REKENINGCOLUMN_COLUMN_TUNJANGANPPH21THR,
                    'debitkredit'=>'K'
                ));

                if(isset($rekd_pph21)){
                    $html .= $this->renderPartial($this->path_view.'_rowRekening', array('rekening'=>$rekd_pph21, 'debitkredit'=>'K', 'nilai'=>$totalpph21), true);
                }
            }

            if($totalthp > 0){
              if($jenisgaji == 'THR'){
                $rek_thp = RekeningcolumnM::model()->findByAttributes(array(
                    'table_name'=> Params::REKENINGCOLUMN_TABLE_PENGBONUSTHRDETAILT,
                    'column_name'=> Params::REKENINGCOLUMN_COLUMN_THPTHR,
                    'debitkredit'=>'K'
                ));
              }else{
                $rek_thp = RekeningcolumnM::model()->findByAttributes(array(
                    'table_name'=> Params::REKENINGCOLUMN_TABLE_PENGBONUSTHRDETAILT,
                    'column_name'=> Params::REKENINGCOLUMN_COLUMN_THPBONUS,
                    'debitkredit'=>'K'
                ));
              }


                if(isset($rek_thp)){
                    $html .= $this->renderPartial($this->path_view.'_rowRekening', array('rekening'=>$rek_thp, 'debitkredit'=>'K', 'nilai'=>$totalthp), true);
                }
            }
        }


        echo CJSON::encode(array(
            'rekening'=>$html,
            'jumlah_pegawai'=>$jumlah_pegawai,
            'total_pengajuan'=> MyFormatter::formatNumberForPrint($total_pengajuan,2),
            'totalpph21'=>MyFormatter::formatNumberForPrint($totalpph21,2),
            'totalthp'=>MyFormatter::formatNumberForPrint($totalthp,2),
            'pengbonusthrdetail_id'=>$pengbonusthrdetail_id,
        ));

    }
}
