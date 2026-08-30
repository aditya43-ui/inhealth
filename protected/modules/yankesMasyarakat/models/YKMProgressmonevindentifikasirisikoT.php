<?php
/**
 * Model untuk tabel ProgressmonevindentifikasirisikoT hanya untuk model pelayanan kesehatan masyarakat
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 */
class YKMProgressmonevindentifikasirisikoT extends ProgressmonevindentifikasirisikoT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporaninsidenV the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
}