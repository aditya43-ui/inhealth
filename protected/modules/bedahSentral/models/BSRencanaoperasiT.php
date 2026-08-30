<?php

class BSRencanaoperasiT extends RencanaoperasiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanaoperasiT the static model class
	 */
         
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function attributeLabels()
	{
		return array(
                    'no_rekam_medik' => 'No. Rekam Medik',
                    'no_pendaftaran' => 'No. Pendaftaran',
                    'nama_bin' => 'Nama Panggilan'
                );
        }
        
    public function getKamarKosongItems($kelaspelayanan_id)
    {
        if(!empty($kelaspelayanan_id))
            return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id'=>$kelaspelayanan_id,'kamarruangan_status'=>true));
        else
            return array();
    }
}