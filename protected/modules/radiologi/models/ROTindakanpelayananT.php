<?php

class ROTindakanpelayananT extends TindakanpelayananT
{
        public $pemeriksaanrad_id; //untuk form daftar tindakan pemeriksaan
        public $jenispemeriksaanrad_nama; //untuk form daftar tindakan pemeriksaan
        public $jenistarif_id; //untuk form daftar tindakan pemeriksaan
        public $totaltariftindakan; //untuk total di lembar status
        public $is_elektif;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        /**
         * menampilkan pemeriksaan lab berdasarkan daftartindakan_id
         * @return type
         */
        public function getPemeriksaanRad(){
            return ROPemeriksaanRadM::model()->findByAttributes(array('daftartindakan_id'=>$this->daftartindakan_id));
        }
}
