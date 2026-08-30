<?php

/**
 * untuk semua hardcode Url path
 */
Class ParamsUrl {

    public static function urlSertifikatTeknisiDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/lainlain/sertifikatteknisi/';
    } 
    
    public static function pathSertifikatTeknisiDirectory(){
        return Yii::getPathOfAlias('webroot').'/data/lainlain/sertifikatteknisi/';
        
    }
    
    public static function pathKalibrasiPdfDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/pdf/kalibrasi/';
    }

    public static function urlKalibrasiPdfDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/pdf/kalibrasi/';
    }
    
    public static function pathInvgambarDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/inventarisasi/';
    }

    public static function pathInvgambarTumbsDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/inventarisasi/tumbs/';
    }

    public static function urlInvgambarDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/inventarisasi/';          //Untuk Menampilkan Gambar Asli
    }

    public static function urlInvgambarTumbsDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/inventarisasi/tumbs/';    //Untuk Menampilkan Gambar Tumbs
    }
    
    public static function pathInvpersparepartDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/sparepart/';
    }

    public static function pathInvpersparepartTumbsDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/sparepart/tumbs/';
    }

    public static function urlInvpersparepartDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/sparepart/';          //Untuk Menampilkan Gambar Asli
    }

    public static function urlInvpersparepartTumbsDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/sparepart/tumbs/';    //Untuk Menampilkan Gambar Tumbs
    }
    
    public static function pathInvperizinanDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/pdf/dokumenperizinan/';
    }

    public static function urlInvperizinanDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/pdf/dokumenperizinan/';
    }
    
    public static function pathKontrakPemeliharaanFileDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/pdf/kontrakpemeliharaan/';
    }
    
    public static function pathPelayananDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/images/pelayanan/';
    }
    
    public static function urlPelayananDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/images/pelayanan/';
    }
}

?>
