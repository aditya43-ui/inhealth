<?php

    class AKJenispengeluaranM extends JenispengeluaranM
    {
		public $rekening_debit;
		public $rekening_kredit;
            public static function model($className=__CLASS__)
            {
                    return parent::model($className);
            }


    }

?>