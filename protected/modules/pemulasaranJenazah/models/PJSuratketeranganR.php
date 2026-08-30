<?php

class PJSuratketeranganR extends SuratketeranganR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AmbiljenazahT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
//      RSSP-669
        public function getNoSuratKematian($ruangan_id)
        {
            $bln = date('m');
            $tahun = date('Y');
            $default="001";
            $sql = "SELECT cast(max(substr(nomorsurat,5,3)) AS integer) nomer FROM suratketerangan_r WHERE ruangan_id=".$ruangan_id." AND date_part('year', tglsurat)='".$tahun."'"." AND date_part('month', tglsurat)='".$bln."'";
            $noJenislinen = Yii::app()->db->createCommand($sql)->queryRow();
            $noJenislinenBaru ="445/".(isset($noJenislinen['nomer']) ? (str_pad($noJenislinen['nomer']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

            return $noJenislinenBaru.'/KM'.date('m').'/42360003'.'/'.date('Y');  
        }
}