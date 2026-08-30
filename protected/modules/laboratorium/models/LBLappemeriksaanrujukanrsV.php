<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil view laporanpemeriksaanrujukanrs_v, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/


class LBLappemeriksaanrujukanrsV extends LaporanpemeriksaanrujukanrsV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function searchTable(){
		$criteria = $this->searchCriteria();
		$criteria->select = " t.*, (qty_tindakan * tarif_tindakankomp) as subtotal ";
		$criteria->order = " tgl_tindakan ASC ";

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public function searchPrint(){
		$criteria = $this->searchCriteria();
		$criteria->select = " t.*, (qty_tindakan * tarif_tindakankomp) as subtotal ";
		$criteria->limit = -1;
		$criteria->order = " tgl_tindakan ASC ";
		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false
		));
	}

	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		$criteria->select = " sum(qty_tindakan * tarif_tindakankomp) as jumlah, (CASE WHEN tindakansudahbayar_id IS NULL THEN 'TAGIHAN' ELSE 'LUNAS' END) as data ";
		$criteria->group = " data ";
		$criteria->order = " jumlah DESC ";
		//if ($_GET['tampilGrafik'] == 'wilayah'){

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,                    
		));
	}

	public function searchCriteria(){
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition('DATE(tgl_tindakan)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition(" ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
		if (!empty($this->pegawai_id)){
			if (is_array($this->pegawai_id)){
				$criteria->addInCondition("pegawai_id",$this->pegawai_id);
			}else{
				$criteria->addCondition(" pegawai_id = ".$this->pegawai_id." ");
			}
		}
		

		return $criteria;
	}
        
}