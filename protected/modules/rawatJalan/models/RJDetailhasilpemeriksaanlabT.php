<?php
class RJDetailhasilpemeriksaanlabT extends DetailhasilpemeriksaanlabT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchDetailHasilLab($data,$pagination=array())
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->detailhasilpemeriksaanlab_id)){
			$criteria->addCondition("detailhasilpemeriksaanlab_id = ".$this->detailhasilpemeriksaanlab_id);		
		}
		if(!empty($data)){
			$criteria->addCondition("hasilpemeriksaanlab_id = ".$data);		
		}
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition("pemeriksaanlab_id = ".$this->pemeriksaanlab_id);		
		}
//		$criteria->compare('LOWER(hasilpemeriksaan)',strtolower($this->hasilpemeriksaan),true);
//		$criteria->compare('LOWER(nilairujukan)',strtolower($this->nilairujukan),true);
//		$criteria->compare('LOWER(hasilpemeriksaan_satuan)',strtolower($this->hasilpemeriksaan_satuan),true);
//		$criteria->compare('LOWER(hasilpemeriksaan_metode)',strtolower($this->hasilpemeriksaan_metode),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>$pagination,
		));
	}
	
	public function getNilaiRujukan(){
		return CustomFunction::symbolsConverter($this->nilairujukan);
	}
	/**
	 * nilai yang sudah ada converting symbol
	 */
	public function getHasilPemeriksaanSatuan(){
		return CustomFunction::symbolsConverter($this->hasilpemeriksaan_satuan);
	}
	/**
	 * nilai yang sudah ada converting symbol
	 */
	public function getHasilPemeriksaanMetode(){
		return CustomFunction::symbolsConverter($this->hasilpemeriksaan_metode);
	}
}