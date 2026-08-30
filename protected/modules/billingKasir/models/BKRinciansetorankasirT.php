<?php

class BKRinciansetorankasirT extends RinciansetorankasirT {
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AntrianT the static model class
     */
	public $ruangan_nama;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
