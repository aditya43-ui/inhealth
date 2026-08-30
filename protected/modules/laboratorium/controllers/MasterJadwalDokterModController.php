<?php
class MasterJadwalDokterModController extends MyAuthController
{
    function actionIndex() {
        

        // load awal
        $tgl = explode('-', date('Y-m-d'));
        
        $bulan = $tgl[0] . '-' . $tgl[1];
        $bulan = MyFormatter::formatMonthForUser($bulan);
        if(isset($_GET['tanggaljaga'])) {
           $bulan = $_GET['tanggaljaga'];
           $tgl = MyFormatter::formatMonthForDb($bulan);
           $tgl = explode('-', (string)$tgl);
        }


        $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);

        $kalenderJadwal = $this->createGrid($day, $tgl[1], $tgl[0]);

        $ok = true;
        if(isset($_POST['DokterMod']) && isset($_POST['DokterSPV'])) {
            try {
                $transaction = Yii::app()->db->beginTransaction();
                // echo '<pre>';var_dump($_POST);die;
                $doktermod = $_POST['DokterMod'];
                $dokterspv = $_POST['DokterSPV'];
    
                if(!empty($doktermod)) {
                    // simpan dokter mod
                    foreach ($doktermod as $i => $data) {
                        
                        if($data['pegawai_id'] != '') {
                            $model = JadwaldoktermodM::model()->findByAttributes(['tanggaljaga' => $i, 'is_mod' => true]);
                            if(empty($model)) {
                                $model = new JadwaldoktermodM();
                                $model->tanggaljaga = $i; 
                                $model->pegawai_id = $data['pegawai_id']; 
                                $model->create_time = date('Y-m-d'); 
                                $model->is_mod = true; 
                            } else {
                                $model->pegawai_id = $data['pegawai_id']; 
                                $model->update_time = date('Y-m-d'); 
                            }
                            $ok &= $model->save();
                        }
                    }
                }
                if(!empty($dokterspv)) {
                    // simpan dokter mod
                    foreach ($dokterspv as $i => $data) {
                        
                        if($data['pegawai_id'] != '') {
                            $model = JadwaldoktermodM::model()->findByAttributes(['tanggaljaga' => $i, 'is_spvcadangan' => true]);
                            if(empty($model)) {
                                $model = new JadwaldoktermodM();
                                $model->tanggaljaga = $i; 
                                $model->pegawai_id = $data['pegawai_id']; 
                                $model->create_time = date('Y-m-d'); 
                                $model->is_spvcadangan = true; 
                            } else {
                                $model->pegawai_id = $data['pegawai_id']; 
                                $model->update_time = date('Y-m-d'); 
                            }
                            $ok &= $model->save();
                        }
                    }
                }

                // die;
                if($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index'));
                } else {
                    $transaction->rollback();
                }

            } catch (Exception $exc) {
                echo '<pre>';var_dump($exc);die;
                $transaction->rollback();
            }
        }
        
        $this->render('index', [
            'kalenderJadwal' => $kalenderJadwal,
            'bulanPilih' => $bulan
        ]);
    }

    protected function createGrid($jumlahhari, $bulan, $tahun, $variable = null)
    {
        $tglMulai = strtotime($tahun . '-' . $bulan . '-' . '01');
        return $this->renderPartial("_createGrid", array('tglMulai' => $tglMulai, 'bulan' => $bulan, 'tahun' => $tahun, 'jumlahHari' => $jumlahhari, 'variable' => $variable), true);
    }
}