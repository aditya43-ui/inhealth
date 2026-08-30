<?php


if (version_compare(phpversion(), '7.0.0', '<')) {

    // Yii::import('application.extensions.MPDF60.*');
    // require ('mpdf.php');
    // class MyPDF60 extends mPDF {

    // }

} else {

    require_once __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../vendor/setasign/fpdi/src/PdfParser/PdfParser.php';
    ini_set('pcre.backtrack_limit', 5000000);

    class MyPDF60 extends \Mpdf\Mpdf {
        
        public function __construct($mode = '', $format = 'A4', $default_font_size = 0, $default_font = '', $mgl = 15, $mgr = 15, $mgt = 16, $mgb = 16, $mgh = 9, $mgf = 9, $orientation = 'P') {

            $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            // var_dump($fontData); die;

            parent::__construct(array(
                'model' => $mode,
                'format' => $format,
                'default_font_size' => $default_font_size,
                'default_font' => $default_font,
                'mgl' => $mgl,
                'mgr' => $mgr,
                'mgt' => $mgt,
                'mgb' => $mgb,
                'mgh' => $mgh,
                'mgf' => $mgf,
                'orientation' => $orientation,
                'tempDir' => Yii::app()->basePath  . "/../assets",
                'defaultCssFile' => Yii::app()->basePath . "/extensions/MPDF60/mpdf.css",
                /*
                'fontDir' => array_merge($fontDirs, array(
                    Yii::app()->basePath . '/../css/font',
                )),
                 * 
                 */
                'fontdata' => array_merge($fontData, array(
                    'mistral' => array(
                        'R' => 'MISTRAL.TTF',
                    ),
                    'calbiri' => array(
                        'R' => 'Calibri Regular.ttf',
                    ),
                    'glyphicon' => [
                        'R' => 'glyphicons-halflings-regular.ttf'
                    ],              
                    'fontawesome' => [
                        'R' => 'fontawesome-webfont.ttf'
                    ],
                ))
            ));

            parent::AddFontDirectory(Yii::app()->basePath . '/../css/font');
        }

        function SetHTMLFooter($footer = '', $OE = '') {

            $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
            $alamat = !empty($profil->alamatlokasi_rumahsakit) ? $profil->alamatlokasi_rumahsakit : "";
            $motto = !empty($profil->motto) ? $profil->motto : "";
            $telp = !empty($profil->no_telp_profilrs) ? $profil->no_telp_profilrs : "";
            $email = !empty($profil->email) ? $profil->email : "";
            $website = !empty($profil->website) ? $profil->website : "";
            $layoutkiri = $alamat . "<br>" . "Telp:" . $telp . " Email:" . $email . " Website:" . $website;


            $height = 0;
            if (is_array($footer) && isset($footer['html']) && $footer['html']) {
                $Fhtml = $footer['html'];
                if ($this->setAutoBottomMargin) {
                    if (isset($footer['h'])) {
                        $height = $footer['h'];
                    } else {
                        $height = $this->_getHtmlHeight($Fhtml);
                    }
                }
            } elseif (!is_array($footer) && $footer) {
                $Fhtml = $footer;
                if ($this->setAutoBottomMargin) {
                    $height = $this->_getHtmlHeight($Fhtml);
                }
            } else {
                $Fhtml = '<div  class="footer"><table ><tr><td  class="alamatfooter" >'.$layoutkiri.'</td><td class="mottofooter" >'.$motto.'</td></tr></table></div>';
            }

            if ($OE !== 'E') {
                $OE = 'O';
            }

            if ($OE === 'E') {
                if ($Fhtml) {
                    $this->HTMLFooterE = [];
                    $this->HTMLFooterE['html'] = $Fhtml;
                    $this->HTMLFooterE['h'] = $height;
                } else {
                    $this->HTMLFooterE = '';
                }
            } else {
                if ($Fhtml) {
                    $this->HTMLFooter = [];
                    $this->HTMLFooter['html'] = $Fhtml;
                    $this->HTMLFooter['h'] = $height;
                } else {
                    $this->HTMLFooter = '';
                }
            }

            if (!$this->mirrorMargins && $OE == 'E') {
                return;
            }

            if ($Fhtml == '') {
                return false;
            }

            if ($this->setAutoBottomMargin == 'pad') {
                $this->bMargin = $this->margin_footer + $height + $this->orig_bMargin;
                $this->PageBreakTrigger = $this->h - $this->bMargin;
                if (isset($this->saveHTMLHeader[$this->page][$OE]['mb'])) {
                    $this->saveHTMLHeader[$this->page][$OE]['mb'] = $this->bMargin;
                }
            } elseif ($this->setAutoBottomMargin == 'stretch') {
                $this->bMargin = max($this->orig_bMargin, $this->margin_footer + $height + $this->autoMarginPadding);
                $this->PageBreakTrigger = $this->h - $this->bMargin;
                if (isset($this->saveHTMLHeader[$this->page][$OE]['mb'])) {
                    $this->saveHTMLHeader[$this->page][$OE]['mb'] = $this->bMargin;
                }
            }
        }

    }
}
