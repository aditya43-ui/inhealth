<?php

class HDJadwalhemodialisaT extends JadwalhemodialisaT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalhemodialisaT the static model class
	 */
    public $bulan_daftar,$tahun_daftar;
    public $bulan,$tahun;
            
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getTahun($pasien_id='')
    {
      $criteria = new CdbCriteria();
      $criteria->select = "extract (year from jadwalhemodialisa_tgl_ke) as tahun";
      if(!empty($pasien_id)){
        $criteria->addCondition("pasien_id = ".$pasien_id);   
      }
      $criteria->order = "jadwalhemodialisa_tgl_ke";
      $criteria->group = "jadwalhemodialisa_tgl_ke";
      $modJadwal = $this::model()->findAll($criteria);
      return $modJadwal;
    }
    
    public function getBulan($pasien_id='')
    {
      $criteria = new CdbCriteria();
      $criteria->select = "to_char(jadwalhemodialisa_tgl_ke, 'MONTH YYYY') as bulan";
      if(!empty($pasien_id)){
        $criteria->addCondition("pasien_id = ".$pasien_id);   
      }
      $criteria->order = "to_char(jadwalhemodialisa_tgl_ke, 'MONTH YYYY') ASC";
      $criteria->group = "to_char(jadwalhemodialisa_tgl_ke, 'MONTH YYYY')";
      $modJadwal = $this::model()->findAll($criteria);
      return $modJadwal;
    }

}