<?php

/**
 * Form Distribusi Darah
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Aida Rahmawati <aidarahmawati@.co.id>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 * 
 */
class DistribusiDarahController extends MyAuthController
{
    public $path_view = "application.modules.bankDarah.views.distribusiDarah.";

    /**
     * Load kantong darah dari data yang diceklis dari dialog/autocomplete kantong darah.
     */
    public function actionAjaxKantongDarah()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        if (!isset($_POST['checked'])) {
            Yii::app()->end();
        }

        $str = "";
        $msg = "";

        
        foreach ($_POST['checked'] as $id => $item) {
            if ($item == "true") {
                $kantong = KantongdarahT::model()->findByPk($id);
                if (empty($kantong)) {
                    $terima = TerimakantongdetT::model()->findByAttributes(array('nobarcodekantong' => $id));
                    if (!empty($terima)) {
                        $kantong = KantongdarahT::model()->findByPk($terima->kantongdarah_id);
                        $pendonor = PendonorM::model()->findByPk($kantong->pendonor_id);
                        $komponen = KomponendarahM::model()->findByPk($kantong->komponendarah_id);
                        $jenis = JeniskantongdarahM::model()->findByPk($kantong->jeniskantongdarah_id);
                        $str .= $this->renderPartial($this->path_view."ajaxKantongDarah", array(
                            'kantong'=>$kantong,
                            'pendonor'=>$pendonor,
                            'komponen'=>$komponen,
                            'jenis'=>$jenis,
                        ), true);
                    } else {
                        $msg .= "Nomor Kantong Darah Tidak Ditemukan";
                    }
                } else if (!empty($kantong)) {
                    $pendonor = PendonorM::model()->findByPk($kantong->pendonor_id);
                    $komponen = KomponendarahM::model()->findByPk($kantong->komponendarah_id);
                    $jenis = JeniskantongdarahM::model()->findByPk($kantong->jeniskantongdarah_id);
                    $str .= $this->renderPartial($this->path_view."ajaxKantongDarah", array(
                        'kantong'=>$kantong,
                        'pendonor'=>$pendonor,
                        'komponen'=>$komponen,
                        'jenis'=>$jenis,
                    ), true);
                } else {
                    $msg .= "Nomor Kantong Darah Tidak Ditemukan";
                }
            }
        }

        echo CJSON::encode(array(
            'html'=>$str,
            'data'=>$msg
        ));
    }

    /**
     * Load data kantong darah berdasarkan nomor kantong darah-nya.
     * Data yang sudah ditambahkan tidak akan ditampilkan.
     * 
     * @param string  $term No Kantong Darah yang dicari
     * @param integer $id   ID Pengecualian pada Data Kantong Darah
     */
    public function actionAutocompleteKantongDarah($term = "", $id = null)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modKantong = new BDKantongdarahT('search');
        $modKantong->unsetAttributes();
        $modKantong->no_kantongdarah = $term;


        $prov = $modKantong->searchKantongUntukDistribusi();
        if (!empty($id)) {
            $id = explode(".", $id);
            if (is_array($id)) {
                $prov->criteria->addNotInCondition('t.kantongdarah_id', $id);
            }
        }

        $res = array();
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $pendonor = PendonorM::model()->findByPk($item->pendonor_id);
            $komponen = KomponendarahM::model()->findByPk($item->komponendarah_id);
            $jenis = JeniskantongdarahM::model()->findByPk($item->jeniskantongdarah_id);

            $sub['label'] = $item->no_kantongdarah." - ".$jenis->nama_jenis." - ".$komponen->singkatan_komp;
            $sub['value'] = $item->kantongdarah_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    /**
     * Menampilkan data pegawai koordinator berdasarkan ruangan login dan nama yang dicari-nya.
     * @param string $term Nama Pegawai yang dicari
     */
    public function actionAutocompleteKoordinator($term = "")
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $koordinator = new PegawairuanganV('search');
        $koordinator->unsetAttributes();
        $koordinator->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $koordinator->nama_pegawai = $term;

        $res = array();

        foreach ($koordinator->search()->data as $item) {
            $res[] = array(
                'label'=>$item->nama_pegawai." - ".$item->nomorindukpegawai,
                'nama_pegawai'=>$item->nama_pegawai,
                'value'=>$item->pegawai_id,
            );
        }

        echo CJSON::encode($res);

    }

    /**
     * Menampilkan data pegawai distribusi berdasarkan ruangan login dan nama yang dicari-nya.
     * @param string $term Nama Pegawai yang dicari
     */
    public function actionAutocompletePetugasDistribusi($term = '')
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $distribusi = new PegawairuanganV('search');
        $distribusi->unsetAttributes();
        $distribusi->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $distribusi->nama_pegawai = $term;

        $res = array();

        foreach ($distribusi->search()->data as $item) {
            $res[] = array(
                'label'=>$item->nama_pegawai." - ".$item->nomorindukpegawai,
                'nama_pegawai'=>$item->nama_pegawai,
                'value'=>$item->pegawai_id,
            );
        }

        echo CJSON::encode($res);

    }

    /**
     * Form Distribusi Darah.
     * Jika form di-submit maka diredirect ke halaman yang sama dengan data yang sudah sitransaksikan.
     * 
     * @param integer $distribusidarah_id ID Distribusi Darah
     */
    public function actionIndex($distribusidarah_id = null)
    {
        $model = new DistribusidarahT;
        $model->nomor_pengiriman = "-- Otomatis --";
        $model->tgl_distribusi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->instalasi_id = Yii::app()->user->getState("instalasi_id");
        $model->ruangan_id = Yii::app()->user->getState("ruangan_id");

        $cri = new CDbCriteria();
        $cri->addCondition("current_time >= shift_distribusi_darah_jamawal");
        $cri->addCondition("current_time <= shift_distribusi_darah_jamakhir");
        $cri->order = "shift_distribusi_darah_jamakhir ASC";
        
        $modShift = ShiftDistribusiDarahM::model()->find($cri);
        if (!empty($modShift)) {
            $model->shift_distribusi = $modShift->shift_distribusi_darah_nama;
        }

        if (!empty($distribusidarah_id)) {
            $model = DistribusidarahT::model()->findByPk($distribusidarah_id);
            $model->tgl_distribusi = MyFormatter::formatDateTimeForUser($model->tgl_distribusi);
        }

        if (isset($_POST['DistribusidarahT'])) {
            $trans = Yii::app()->db->beginTransaction();

            try {
                if ($model->saveDistribusiDarah($_POST)) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','distribusidarah_id'=>$model->distribusidarah_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
                }
            } catch (CException $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data Gagal Disimpan ".MyExceptionMessage::getMessage($e,true));
            }
        }

        $this->render($this->path_view.'index', array(
            'model'=>$model,
        ));
    }

    /**
     * Menambahkan fungsi cek shift  
     */
    public function actionCekShift()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['shift'] = null;
            $tanggal = MyFormatter::formatDateTimeForDb($_POST['tgl_distribusi']);
            $tgl = date("H:i:s", strtotime($tanggal));
            if ($tgl >= "04:00:00" && $tgl <= "12:00:00"){
                $data['shift'] = Params::SHIFT_DISTRIBUSI_DARAH_PAGI;
            } else if ($tgl >= "12:00:00" && $tgl <= "15:00:00") {
                $data['shift'] = Params::SHIFT_DISTRIBUSI_DARAH_SIANG;
            } else if ($tgl >= "15:00:00" && $tgl <= "18:00:00") {
                $data['shift'] = Params::SHIFT_DISTRIBUSI_DARAH_SORE;
            } else {
                $data['shift'] = Params::SHIFT_DISTRIBUSI_DARAH_MALAM;
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
}