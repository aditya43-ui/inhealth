<?php

class MCPemeriksaanlabM extends PemeriksaanlabM
{
        public $is_pilih;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getJenispemeriksaanLABItems() {
            return LBJenisPemeriksaanLabM::model()->findAll('jenispemeriksaanlab_aktif=TRUE ORDER BY jenispemeriksaanlab_nama');
        }

}