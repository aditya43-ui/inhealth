<?php
/**
 * Widget to manage gallery.
 * Requires Twitter Bootstrap styles to work.
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */
class GalleryManager extends CWidget
{
    /** @var Gallery Model of gallery to manage */
    public $gallery;
    /** @var string Route to gallery controller */
    public $controllerRoute = false;
    public $assets;

    public function init()
    {
        $this->assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
    }


    public $htmlOptions = array();


    /** Render widget */
    public function run()
    {
        /** @var $cs CClientScript */
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($this->assets . '/galleryManager.css');

        $cs->registerCoreScript('jquery');
//        $cs->registerCoreScript('jquery.ui');

        if (YII_DEBUG) {
            $cs->registerScriptFile($this->assets . '/jquery.iframe-transport.js');
            $cs->registerScriptFile($this->assets . '/jquery.galleryManager.js');
        } else {
            $cs->registerScriptFile($this->assets . '/jquery.iframe-transport.min.js');
            $cs->registerScriptFile($this->assets . '/jquery.galleryManager.min.js');
        }

        if ($this->controllerRoute === null)
            throw new CException('$controllerRoute must be set.', 500);

        $photos = array();
        foreach ($this->gallery->galleryPhotos as $photo) {
            $photos[] = array(
                'photopemeriksaan_id' => $photo->photopemeriksaan_id,
                'nourut' => $photo->nourut,
                'judulphotopemeriksaan' => (string)$photo->judulphotopemeriksaan,
                'keteranganphoto' => (string)$photo->keteranganphoto,
                'preview' => PhotopemeriksaanT::model()->getPreview($photo->pathphoto),
            );
        }

        $opts = array(
//            'hasName' => $this->gallery->judulphotopemeriksaan ? true : false,
//            'hasDesc' => $this->gallery->keteranganphoto ? true : false,
//            'uploadUrl' => Yii::app()->createUrl($this->controllerRoute . '/ajaxUpload'),
            'updateGallery' => Yii::app()->createUrl($this->controllerRoute . '/updateGallery'),
            'uploadUrl' => Yii::app()->createUrl($this->controllerRoute . '/ajaxUpload', array('pendaftaran_id' => isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null)),
            'deleteUrl' => Yii::app()->createUrl($this->controllerRoute . '/delete'),
            'updateUrl' => Yii::app()->createUrl($this->controllerRoute . '/changeData'),
            'arrangeUrl' => Yii::app()->createUrl($this->controllerRoute . '/order'),
            'nameLabel' => Yii::t('galleryManager.main', 'Name'),
            'descriptionLabel' => Yii::t('galleryManager.main', 'Description'),
            'photos' => $photos,
        );

        if (Yii::app()->request->enableCsrfValidation) {
            $opts['csrfTokenName'] = Yii::app()->request->csrfTokenName;
            $opts['csrfToken'] = Yii::app()->request->csrfToken;
        }
        $opts = CJavaScript::encode($opts);
        $cs->registerScript('galleryManager#' . $this->id, "$('#{$this->id}').galleryManager({$opts});");

        $this->htmlOptions['id'] = $this->id;
        $this->htmlOptions['class'] = 'GalleryEditor';

        $this->render('galleryManager');
    }

}
