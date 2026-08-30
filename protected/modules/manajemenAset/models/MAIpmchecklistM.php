<?php
/**
* - digunakan sebagai Model Extend
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>

<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAIpmchecklistM extends IpmchecklistM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
