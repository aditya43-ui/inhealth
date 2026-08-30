<?php

/**
 * This is the model class for table "penjaminpasien_m".
 *
 * The followings are the available columns in table 'penjaminpasien_m':
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property string $penjamin_nama
 * @property string $penjamin_namalainnya
 * @property boolean $penjamin_aktif
 */
class EKFasilitasgaleryS extends FasilitasgaleryS
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return FasilitasgaleryS the static model class
     */

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
   
    public function getFasilitasItems()
    {            
        
        $sql = "SELECT fasilitas_s.namafasilitas, fasilitas_s.descfasilitas, fasilitasgalery_s.galeryimage, fasilitasgalery_s.galery_thumbs
                FROM fasilitas_s
                JOIN fasilitasgalery_s ON fasilitasgalery_s.fasilitas_id = fasilitas_s.fasilitas_id
                WHERE fasilitas_s.fasilitasaktif = TRUE
                ORDER BY fasilitas_s.fasilitas_id, fasilitasgalery_s.fasilitasgalery_id";
        $modFasilitasGalery = EKFasilitasgaleryS::model()->findAllBySql($sql);
        
        return $modFasilitasGalery;
    }
}