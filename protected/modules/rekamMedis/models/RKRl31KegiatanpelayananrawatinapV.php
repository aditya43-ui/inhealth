<?php
class RKRl31KegiatanpelayananrawatinapV extends Rl31KegiatanpelayananrawatinapV
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchRL()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('nokode_rumahsakit',$this->nokode_rumahsakit,true);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);			
		}
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('pasienawaltahun',$this->pasienawaltahun);
		$criteria->compare('pasienmasuk',$this->pasienmasuk);
		$criteria->compare('pasienkeluar',$this->pasienkeluar);
		$criteria->compare('pasienmatikurang48jam',$this->pasienmatikurang48jam);
		$criteria->compare('pasienmatilebih48jam',$this->pasienmatilebih48jam);
		$criteria->compare('lamadirawat',$this->lamadirawat);
		$criteria->compare('pasienakhirtahun',$this->pasienakhirtahun);
		$criteria->compare('hariperawatan',$this->hariperawatan);
		$criteria->compare('rincianhariperawatanvvip',$this->rincianhariperawatanvvip);
		$criteria->compare('rincianhariperawatanvip',$this->rincianhariperawatanvip);
		$criteria->compare('rincianhariperawatan1',$this->rincianhariperawatan1);
		$criteria->compare('rincianhariperawatan2',$this->rincianhariperawatan2);
		$criteria->compare('rincianhariperawatan3',$this->rincianhariperawatan3);
		$criteria->compare('rincianhariperawatankelaskhusus',$this->rincianhariperawatankelaskhusus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}