<?php
class RJPhotopemeriksaanT extends PhotopemeriksaanT
{
        public $pilih_gambar = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PhotopemeriksaanT the static model class
	 */
	public static function model($className=__CLASS__) {
            return parent::model($className);
        }
        
        public function behaviors()
        {
            return array(
                'galleryBehavior' => array(
                    'class' => 'GalleryBehavior',
                    'idAttribute' => 'photopemeriksaan_id',
                    'pendaftaran_id' => 'pendaftaran_id',
                    'versions' => array(
                        'small' => array(
                            'centeredpreview' => array(98, 98),
                        ),
                        'medium' => array(
                            'resize' => array(800, null),
                        )
                    ),
                    'name' => true,
                    'description' => true,
                )
            );
        }

}