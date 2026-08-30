<?php

class BKInfopasienmasukkamarV extends InfopasienmasukkamarV
{
        /**
        * Returns the static model of the specified AR class.
        * @param string $className active record class name.
        * @return InfopasienmasukkamarV the static model class
        */
		public $tglselesaiperiksa;
                public $tglpembayaran;
                public $nopembayaran;
                public $pembayaran_id, $nobuktibayar;
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        
        
	
}