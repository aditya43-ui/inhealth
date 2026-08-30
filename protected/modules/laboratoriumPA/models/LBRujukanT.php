<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class LBRujukanT extends RujukanT
{
    public $rujukandari_id;
    public $asalrujukan_nama;
    public $nama_perujuk;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_rujukan', 'length', 'max'=>20),
			array('nama_perujuk', 'length', 'max'=>50),
			array('tanggal_rujukan, diagnosa_rujukan, aktif_rujukan, rujukandari_id', 'safe'),
			array('rujukan_id, asalrujukan_id, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, aktif_rujukan', 'safe', 'on'=>'search'),
			array('no_rujukan,asalrujukan_id', 'required'),
		);
	}
        
    public function attributeLabels()
    {
            return array(
                'rujukandari_id' => 'Rujukan Dari',
                'rujukan_id' => 'Rujukan',
                'asalrujukan_id' => 'Asal Rujukan',
                'no_rujukan' => 'No. Rujukan',
                'nama_perujuk' => 'Nama Perujuk',
                'tanggal_rujukan' => 'Tanggal Rujukan',
                'diagnosa_rujukan' => 'Diagnosa Rujukan',
                'aktif_rujukan' => 'Aktif Rujukan',
            );
    }
    public function getRujukanDariNama(){
        return RujukandariM::model()->findByPk($this->rujukandari_id);
    }
    public function beforeSave() {         
            return parent::beforeSave();
        }
        
    protected function beforeValidate ()
    {
        return parent::beforeValidate ();
    }
    public function getDokterItems()
    {
        return DokterV::model()->findAll(array('order'=>'nama_pegawai'));
    }    
    
    public function getDokterLuarItems()
    {   
        return RujukandariM::model()->findAll(
            array(
                'order'=>'namaperujuk'
            ), 'asalrujukan_id = 1'
        );
    } 
    
    public function getAsalRujukanItems()
    {
       return AsalrujukanM::model()->findAll('asalrujukan_aktif=true ORDER BY asalrujukan_nama');
    }
    
    /**
     * Mengambil daftar semua kabupaten berdasarkan propinsi
     * @return CActiveDataProvider 
     */
    public function getRujukanDariItems($asalrujukan_id=null)
    {
        if(!empty($asalrujukan_id))
            return RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$asalrujukan_id,),array('order'=>'namaperujuk'));
        else {
            return array();
        }
    }
}
?>