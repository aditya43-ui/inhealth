<?php

/**
 * controller utama untuk mengakses fungsi - fungsi pada transaksi pencucian linen
 * @package application.modules.laundry
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 */
class AmbilPencucianLinenUmumController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'laundry.views.ambilPencucianLinenUmum.';
    public $pencucianlinendetailtersimpan = true;
    public $pencucianlinentersimpan = true;
    public $pencucianbahantersimpan = true;

    /**
     * action ini digunakan untuk, mengakses menu pencucian linen
     * @param type $ambilpencucianlinenumum_id
     */
    public function actionIndex($ambilpencucianlinenumum_id = null) {
        $this->pageTitle = Yii::app()->name . " - Ambil Pencucian Linen Umum";
        $format = new MyFormatter();
        $model = new AmbilpencucianlinenumumT;
        $modDet = new AmbilpencucianlinenumumdetT;
        $modInfo = new InformasipencucianlinenumumV;

        if (!empty($ambilpencucianlinenumum_id)) {
            $modPencucianLinen = LAPencucianlinenT::model()->findByPk($ambilpencucianlinenumum_id);
            $modPencucianLinen->pegmengetahui_nama = !empty($modPencucianLinen->pegpenerima->NamaLengkap) ? $modPencucianLinen->pegpenerima->NamaLengkap : "";
            $modPencucianLinenDetail = LAPencuciandetailT::model()->findAllByAttributes(array('pencucianlinen_id' => $modPencucianLinen->pencucianlinen_id));
            $modPencucianBahan = LAPencucianbahanT::model()->findAllByAttributes(array('pencucianlinen_id' => $modPencucianLinen->pencucianlinen_id));

            $modDetailss = LAPencuciandetailT::model()->findByAttributes(array('pencucianlinen_id' => $modPencucianLinen->pencucianlinen_id));
            //			$modInfoPencucian = LAPenerimaanpencucianlinenV::model()->findByAttributes(array('penerimaanlinen_id'=>$modDetailss->penerimaanlinen_id));
            $modInfoPencucian->jenisperawatan = Params::JENISPERAWATAN_PENCUCIAN;
        }

        $instalasiTujuans = CHtml::listData(LAInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
        $ruanganTujuans = CHtml::listData(LARuanganM::getRuanganByInstalasi($modInfoPencucian->instalasi_id), 'ruangan_id', 'ruangan_nama');

        if (isset($_POST['LAPencucianlinenT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {

                $modPencucianLinen->attributes = $_POST['LAPencucianlinenT'];
                $modPencucianLinen->nopencucianlinen = MyGenerator::noPencucianLinen(Yii::app()->user->getState('instalasi_id'));
                $modPencucianLinen->tglpencucianlinen = $format->formatDateTimeForDb($_POST['LAPencucianlinenT']['tglpencucianlinen']);
                $modPencucianLinen->petugas_id = Yii::app()->user->id;
                $modPencucianLinen->create_time = date('Y-m-d H:i:s');
                $modPencucianLinen->update_time = date('Y-m-d H:i:s');
                $modPencucianLinen->create_loginpemakai_id = Yii::app()->user->id;
                $modPencucianLinen->update_loginpemakai_id = Yii::app()->user->id;
                $modPencucianLinen->create_ruangan = Yii::app()->user->ruangan_id;

                if ($modPencucianLinen->save()) {
                    $this->pencucianlinentersimpan = true;
                    if (isset($_POST['LAPencuciandetailT'])) {
                        if (count((array) $_POST['LAPencuciandetailT']) > 0) {
                            foreach ($_POST['LAPencuciandetailT'] as $i => $post) {
                                if (isset($post['checklist']) && $post['checklist'] == 1) {
                                    $modPencucianLinenDetail[$i] = $this->simpanPencucianLinenDetail($modPencucianLinen, $post);
                                }
                            }
                        }
                    } else {
                        
                    }

                    if (isset($_POST['LAPencucianbahanT'])) {
                        if (count((array) $_POST['LAPencucianbahanT']) > 0) {
                            foreach ($_POST['LAPencucianbahanT'] as $i => $bahan) {
                                $modPencucianBahan[$i] = $this->simpanPencucianBahan($modPencucianLinen, $bahan);
                            }
                        }
                    } else {
                        $this->pencucianbahantersimpan = false;
                    }
                }

                if ($this->pencucianlinentersimpan && $this->pencucianbahantersimpan) {
                    $transaction->commit();
                    $modPencucianLinen->isNewRecord = FALSE;
                    $this->redirect(array('index', 'pencucianlinen_id' => $modPencucianLinen->pencucianlinen_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Pencucian Linen gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Pencucian Linen gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'format' => $format,
            'model' => $model,
            'modDet' => $modDet,
            'modInfo' => $modInfo,
        ));
    }

    /**
     * simpan LAPencuciandetailT
     * @param type $modPencucianLinenDetail
     * @param type $detail
     * @return \LAPencuciandetailT
     */
    public function simpanPencucianLinenDetail($modPencucianLinen, $detail) {
        $format = new MyFormatter();
        $modPencucianLinenDetail = new LAPencuciandetailT;
        $modPencucianLinenDetail->attributes = $detail;
        $modPencucianLinenDetail->pencucianlinen_id = $modPencucianLinen->pencucianlinen_id;
        $modPencucianLinenDetail->statuspencucian = $detail['jenisperawatanlinen'];

        if ($modPencucianLinenDetail->validate()) {
            $modPencucianLinenDetail->save();
            $this->updatePencucianLinen($modPencucianLinen, $detail);
            $this->pencucianlinendetailtersimpan &= true;
        } else {
            $this->pencucianlinendetailtersimpan &= false;
            echo CHtml::errorSummary($modPencucianLinenDetail);
            exit();
        }
        return $modPencucianLinenDetail;
    }

    /**
     * fungsi ubah pencucian linen
     * @param type $modPencucianLinen
     * @param type $detail
     */
    public function updatePencucianLinen($modPencucianLinen, $detail) {
        $modPencucianLinen = LAPencucianlinenT::model()->findByPk($modPencucianLinen->pencucianlinen_id);
        //		$modPencucianLinen->penerimaanlinen_id = $detail['penerimaanlinen_id'];
        $modPencucianLinen->save();
    }

    /**
     * simpan LAPencucianbahanT
     * @param type $modPencucianBahan
     * @param type $bahan
     * @return \LAPencucianbahanT
     */
    public function simpanPencucianBahan($modPencucianLinen, $bahan) {
        $format = new MyFormatter();
        $modPencucianBahan = new LAPencucianbahanT;
        $modPencucianBahan->attributes = $bahan;
        $modPencucianBahan->pencucianlinen_id = $modPencucianLinen->pencucianlinen_id;

        if ($modPencucianBahan->validate()) {
            $modPencucianBahan->save();
            $this->pencucianbahantersimpan &= true;
        } else {
            $this->pencucianbahantersimpan &= false;
            echo CHtml::errorSummary($modPencucianBahan);
            exit();
        }
        return $modPencucianBahan;
    }

    /**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if ($model_nama !== '' && $attr == '') {
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            } else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            } else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(LARuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

            if ($encode) {
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                if (count((array) $models) > 0) {
                    foreach ($models as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * pencarian data pegawai sesuai yang diketikkan
     */
    public function actionAutocompletePegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = LAPegawaiV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * autocomplete bahan perawatan sesuai yang diketikkan
     */
    public function actionAutocompletePencucian() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nopencucian)', strtolower($_GET['term']), true);
            $criteria->order = 'nopencucian';
            $criteria->limit = 5;
            $models = InformasipencucianlinenumumV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nopencucian;
                $returnVal[$i]['value'] = $model->pencucianlinenumum_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * set umur dari tanggal lahir (date)
     */
    public function actionGetPencucian() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {

            $id = $_POST['id'];

            $data['tanggal'] = "";
            $data['namapengirim'] = "";
            $data['namamesin'] = "";
            $data['keterangan'] = "";

            if ($id != "") {
                $model = InformasipencucianlinenumumV::model()->findByAttributes(array('pencucianlinenumum_id' => $id));

                $data['tanggal'] = MyFormatter::formatDateTimeForUser($model->tglpencucian);
                $data['namapengirim'] = $model->namapengirim;
                $data['namamesin'] = $model->mesinpencucian_nama;
                $data['keterangan'] = $model_keterangan;
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * set umur dari tanggal lahir (date)
     */
    public function actionGetDetail() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {

            $id = $_POST['id'];

            $data['tanggal'] = "";

            if ($id != "") {
                $modDet = PencucianlinenumumdetT::model()->findAllByAttributes(array('pencucianlinenumum_id' => $id));

                if (!empty($modDet)) {
                    foreach ($modDet as $i => $det) {
                        $data['tr'] .= $this->renderPartial('_rowDetail', array('det' => $det, 'i' => $i), true);
                    }
                } else {
                    $data['tr'] = '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
                }
            } else {
                $data['tr'] = '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * laod fungsi cetak
     * @param type $ambilpencucianlinenumum_id
     * @param type $caraprint
     */
    public function actionPrint($ambilpencucianlinenumum_id, $caraprint = null) {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        } else if ($caraprint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
        }
        $format = new MyFormatter;

        $modPencucianLinen = LAPencucianlinenT::model()->findByPk($ambilpencucianlinenumum_id);
        $modDetailss = LAPencuciandetailT::model()->findByAttributes(array('pencucianlinen_id' => $modPencucianLinen->pencucianlinen_id));
        $modPencucianLinenDetail = LAPenerimaanpencucianlinenV::model()->findAllByAttributes(array('penerimaanlinen_id' => $modDetailss->penerimaanlinen_id, 'jenisperawatanlinen' => Params::JENISPERAWATAN_PENCUCIAN));

        $modPencucianBahan = LAPencucianbahanT::model()->findAllByAttributes(array('pencucianlinen_id' => $ambilpencucianlinenumum_id));
        $judul_print = 'Pencucian Linen';

        $this->render($this->path_view . 'Print', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modPencucianLinen' => $modPencucianLinen,
            'modPencucianLinenDetail' => $modPencucianLinenDetail,
            'modPencucianBahan' => $modPencucianBahan,
            'caraprint' => $caraprint
        ));
    }

}
