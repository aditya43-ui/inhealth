<?php
/**
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 */
class ADPerintahmulaikerjaT extends PerintahmulaikerjaT {
    
    public $supplier_nama;
    public $supplier_alamat,$supplier_direktur,$isi_surat;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * digunakan untuk filter informasi
     * @return \CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	

}

?>
