<?php
class RujukanBpjsController extends MyAuthController
{
    protected $path_view = 'pendaftaranPenjadwalan.views.rujukanBpjs_new.';
    protected $path_view_peserta = 'pendaftaranPenjadwalan.views.pesertaBpjs.';

    public function actionIndex()
    {
        $this->pageTitle = Yii::app()->name . " - Pencarian Rujukan BPJS";
        $this->render($this->path_view . 'indexRujukan', array());
    }

    /**
     * set bpjs Interface
     */
    public function actionBpjsInterface()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $format = new MyFormatter();
            $start = 1;
            $limit = 1;
            if (empty($_GET['param']) or $_GET['param'] === '') {
                die('param can\'not empty value');
            } else {
                $param = $_GET['param'];
            }

            $bpjs = new BpjsVklaim();

            switch ($param) {
                case '1':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_no_rujukan($query));
                    break;
                case '2':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_no_bpjs($query));
                    break;
                case '3':
                    $query = $_GET['query'];
                    $query = $format->formatDateTimeForDb($query);
                    print_r($bpjs->list_rujukan_tanggal($query, $start, $limit));
                    break;
                case '4':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_rs_no_rujukan($query));
                    break;
                case '5':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_rs_no_bpjs($query));
                    break;
                case '6':
                    $query = $_GET['query'];
                    $query = $format->formatDateTimeForDb($query);
                    print_r($bpjs->list_rujukan_rs_tanggal($query, $start, $limit));
                    break;
                case '99':
                    $bpjs->identity_magic();
                    break;
                case '100':
                    print_r($bpjs->help());
                    break;
                default:
                    die('error number, please check your parameter option');
                    break;
            }
            Yii::app()->end();
        }
    }

    /**
     * set bpjs Interface
     */
    public function actionBpjsInterface_new()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $format = new MyFormatter();
            $start = 1;
            $limit = 1;
            if (empty($_GET['param']) or $_GET['param'] === '') {
                die('param can\'not empty value');
            } else {
                $param = $_GET['param'];
            }

            $bpjs = new BpjsVklaim();

            switch ($param) {
                case '1':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_no_rujukan($query));
                    break;
                case '2':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_no_bpjs($query));
                    break;
                case '4':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_rs_no_rujukan($query));
                    break;
                case '5':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_rs_no_bpjs($query));
                    break;
                case '6':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_pcare_multi($query));
                    break;
                case '7':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_rs_multi($query));
                    break;
                case '99':
                    $bpjs->identity_magic();
                    break;
                case '100':
                    print_r($bpjs->help());
                    break;
                default:
                    die('error number, please check your parameter option');
                    break;
            }
            Yii::app()->end();
        }
    }

    /**
     * @param type $sep_id
     */
    public function actionPrintRujukanBpjs($norujukan = null, $nokartu = null, $tglrujukan = null)
    {
        $this->pageTitle = Yii::app()->name . " - Cetak Rujukan BPJS";
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;

        $judul_print = 'DATA PESERTA BPJS';
        $this->render($this->path_view . 'printRujukanBpjs', array(
            'format' => $format,
            'judul_print' => $judul_print,
        ));
    }

    /**
     * @param type $sep_id
     */
    public function actionPrintRujukanBpjsFktl($norujukan = null, $nokartu = null, $tglrujukan = null)
    {
        $this->pageTitle = Yii::app()->name . " - Cetak Rujukan BPJS";
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;

        $judul_print = 'DATA RUJUKAN PESERTA BPJS FKTL';
        $this->render($this->path_view . 'printFKTL', array(
            'format' => $format,
            'judul_print' => $judul_print,
        ));
    }

    /**
     * @param type $sep_id
     */
    public function actionPrintRujukanBpjsFktp($norujukan = null, $nokartu = null, $tglrujukan = null)
    {
        $this->pageTitle = Yii::app()->name . " - Cetak Rujukan BPJS";
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;

        $judul_print = 'DATA RUJUKAN PESERTA BPJS FKTP';
        $this->render($this->path_view . 'printFKTP', array(
            'format' => $format,
            'judul_print' => $judul_print,
        ));
    }

    public function actionSetForm()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $rujukanList = $_POST['rujukanList'];
            $form = '';
            $pasien = '';
            $pesan = '';
            if (count((array)$rujukanList) > 0) {
                $count = 0;

                foreach ($rujukanList as $i => $rujukan) {
                    $form .= $this->renderPartial($this->path_view . '_formRujukanTP_1', array(
                        'rujukan' => $rujukan,
                    ), true);
                    if ($count <= 0) {
                        $pasien .= $this->renderPartial($this->path_view . '_formDataPeserta', array(
                            'rujukan' => $rujukan,
                        ), true);
                    }
                    $count++;
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pasien' => $pasien, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
}
