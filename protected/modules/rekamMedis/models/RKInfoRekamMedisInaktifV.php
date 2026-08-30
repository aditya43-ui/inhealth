<?php
/**
    * @author          Yusuf Putra Anugrah<yusufputra@.com>
    * @version         2.0.0
    * @documentation   http://kbase..com
    * @issue           RSST-2164
    * - Menambahkan Menu Informasi Daftar Rekam Medis Inaktif

    * -  
    */
?>
<?php


class RKInfoRekamMedisInaktifV extends InfoinaktifrekammedisV
{	
        
	public $tgl_awal,$tgl_akhir,$no_rekam_medik,$tahun,$bulan,$hari;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalpakaiambulansT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
       public function searchInformasi()
	{
		
                $criteria=new CDbCriteria();
                $criteria->select="t.*,p.no_rekam_medik,EXTRACT(YEAR FROM age(cast(t.tglkunjunganterakhir as date))) as tahun,EXTRACT(MONTH FROM age(cast(t.tglkunjunganterakhir as date))) as bulan,EXTRACT(DAY FROM age(cast(t.tglkunjunganterakhir as date))) as hari";
                $criteria->join="join pasien_m p on t.pasien_id=p.pasien_id";
                
                $criteria->addBetweenCondition("DATE(t.tglinaktifrekammedis) ", $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
                $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
                $criteria->compare('t.noretensiinaktif',strtolower($this->noretensiinaktif),true);
                $criteria->compare('p.no_rekam_medik',$this->no_rekam_medik,true);
                
                
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
       
}