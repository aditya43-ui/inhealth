<?php

class BKClosingkasirTRemote extends BKClosingkasirT {

//    public $no_pendaftaran,$nama_pasien,$jumlahuang,$total;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * switch database and connection
     * @return type
     * @throws CDbException
     */
    public static $conection; // Model attribute

    public function getDbConnection(){

        if(self::$conection!==null)
            return self::$conection;
        else{
            self::$conection = Yii::app()->db_remoteserver; // main.php - DB config name

            if(self::$conection instanceof CDbConnection){
                self::$conection->setActive(true);
                return self::$conection;
            }
            else
                throw new CDbException(Yii::t('yii',"Active Record requires a '$conection' CDbConnection application component."));
        }
    }
}

?>
