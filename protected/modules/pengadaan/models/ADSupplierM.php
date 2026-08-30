<?php

/**
 * Extend dari model SupplierM untuk modul pengadaan.
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package    application.modules.pengadaan
 * @subpackage models
 * @category   model
 */
class ADSupplierM extends SupplierM
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
    
    /**
     * Pencarian data supplier
     * 
     * @return /CActiveDataProvider
     */
    public function searchDialogPenyedia()
	{
		$prov = $this->search();
        
        return $prov;
	}
    
    

}
?>
