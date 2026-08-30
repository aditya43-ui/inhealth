<?php
/**
 * Behavior for adding gallery to any model.
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */
Yii::import('application.models.PhotopemeriksaanT');
class GalleryBehavior extends CActiveRecordBehavior
{
    /** @var string Model attribute name to store created gallery id */
    public $idAttribute;
    public $pendaftaran_id;
    /**
     * @var array Settings for image auto-generation
     * @example
     *  array(
     *       'small' => array(
     *              'resize' => array(200, null),
     *       ),
     *      'medium' => array(
     *              'resize' => array(800, null),
     *      )
     *  );
     */
    public $versions;
    /** @var boolean does images in gallery need names */
    public $name;
    /** @var boolean does images in gallery need descriptions */
    public $description;
    private $_gallery;

    /** Will create new gallery after save if no associated gallery exists */
//    public function beforeSave($event)
//    {
//        parent::beforeSave($event);
//        if ($event->isValid) {
//            if (empty($this->getOwner()->{$this->idAttribute})) {
//                $gallery = new PhotopemeriksaanT();
//                $gallery->pegawai_id = Yii::app()->user->getState('pegawai_id');
//                $gallery->pasien_id = 165424;
//                $gallery->pasienadmisi_id = null;
//                $gallery->pendaftaran_id = 31542;
//                $gallery->tglphotopemeriksaan = date('Y-m-d H:i:s');                
//                $gallery->nourut = '1';
//                $gallery->judulphotopemeriksaan = 'test';
//                $gallery->keteranganphoto = 'test';
//                $gallery->create_time = date('Y-m-d H:i:s');
//                $gallery->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
//                $gallery->create_ruangan = Yii::app()->user->getState('ruangan_id');
//                
//                $gallery->save();
//
//                $this->getOwner()->{$this->idAttribute} = $gallery->photopemeriksaan_id;
//            }
//        }
//    }

    /** Will remove associated Gallery before object removal */
    public function beforeDelete($event)
    {
        $gallery = $this->getGallery();
        if ($gallery !== null) {
            $gallery->delete();
        }
        parent::beforeDelete($event);
    }

    /** Method for changing gallery configuration and regeneration of images versions */
    public function changeConfig()
    {
        $gallery = $this->getGallery();
        if ($gallery == null) return;

        if ($gallery->versions_data != serialize($this->versions)) {
            foreach ($gallery->galleryPhotos as $photo) {
                $photo->removeImages();
            }

            $gallery->pegawai_id = Yii::app()->user->getState('pegawai_id');
            $gallery->pasien_id = 165424;
            $gallery->pasienadmisi_id = null;
            $gallery->pendaftaran_id = 31542;
            $gallery->tglphotopemeriksaan = date('Y-m-d H:i:s');                
            $gallery->nourut = '1';
            $gallery->judulphotopemeriksaan = 'test';
            $gallery->keteranganphoto = 'test';
            $gallery->create_time = date('Y-m-d H:i:s');
            $gallery->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            $gallery->create_ruangan = Yii::app()->user->getState('ruangan_id');
            
            $gallery->save();

            foreach ($gallery->galleryPhotos as $photo) {
                $photo->updateImages();
            }
        }
    }

    /** @return Gallery Returns gallery associated with model */
    public function getGallery()
    {
        if (empty($this->_gallery)) {
            $this->_gallery = PhotopemeriksaanT::model()->findByPk($this->getOwner()->{$this->idAttribute});
        }
        return $this->_gallery;
    }

    /** @return GalleryPhoto[] Photos from associated gallery */
    public function getGalleryPhotos()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'pendaftaran_id = :pendaftaran_id';
        $criteria->params[':pendaftaran_id'] = $this->getOwner()->{$this->pendaftaran_id};
        $criteria->order = 'nourut asc';
        $criteria->addCondition('tampildigalery is false');
        return PhotopemeriksaanT::model()->findAll($criteria);
    }
}
