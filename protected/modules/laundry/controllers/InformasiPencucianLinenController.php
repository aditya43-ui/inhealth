<?php

class InformasiPencucianLinenController extends MyAuthController {

    public $path_view = 'laundry.views.informasiPencucianLinen.';

    public function actionIndex() {
        $this->pageTitle = Yii::app()->name . " - Pencucian Linen";
        $format = new MyFormatter();
        $modPencucianLinen = new LAPencucianlinenT('searchInformasi');
        $modPencucianLinen->tgl_awal = date("Y-m-d");
        $modPencucianLinen->tgl_akhir = date("Y-m-d");

        if (isset($_GET['LAPencucianlinenT'])) {
            $modPencucianLinen->attributes = $_GET['LAPencucianlinenT'];
            $modPencucianLinen->tgl_awal = $format->formatDateTimeForDb($_GET['LAPencucianlinenT']['tgl_awal']);
            $modPencucianLinen->tgl_akhir = $format->formatDateTimeForDb($_GET['LAPencucianlinenT']['tgl_akhir']);
        }

        $this->render($this->path_view . 'index', array(
            'format' => $format,
            'model' => $modPencucianLinen
        ));
    }

    public function actionDetail($id = null) {
        $this->layout = 'iframe';

        $model = LAPencucianlinenT::model()->findByPk($id);
        $modDetail = LAPencuciandetailT::model()->findAllByAttributes(array('pencucianlinen_id' => $id));


        $this->render($this->path_view . '_detailPencucian', array(
            'model' => $model,
            'modDetail' => $modDetail,
        ));
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

    public function actionUbahStatusDetailLinen() {
        if (Yii::app()->request->isAjaxRequest) {
            $pencuciandetail_id = $_POST['pencuciandetail_id'];
            $status = false;

            $modDetail = PencuciandetailT::model()->findByPk($pencuciandetail_id);
            $modDetail->statuspencucian = Params::STATUSPERAWATAN_SELESAI;
            if ($modDetail->update()) {
                $status = true;
            }

            echo CJSON::encode($status);
        }
        Yii::app()->end();
    }

}
