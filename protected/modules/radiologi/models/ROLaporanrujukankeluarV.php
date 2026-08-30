<?php
/**
 * - digunakan untuk meload data pada view laporanrujukankeluar_v, hanya untuk di modul radiologi
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website <piindonesia.co.id>
 */
class ROLaporanrujukankeluarV extends LaporanrujukankeluarV
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
		//$criteria->select = " t.*, (qty_tindakan * tarif_tindakankomp) as subtotal ";
		$criteria->order = " pemeriksaankeluar_tgl ASC ";

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public function searchPrint(){
		$criteria = $this->searchCriteria();
		//$criteria->select = " t.*, (qty_tindakan * tarif_tindakankomp) as subtotal ";
		$criteria->limit = -1;
		$criteria->order = " pemeriksaankeluar_tgl ASC ";
		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false
		));
	}

	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		$criteria->select = " sum(qty_tindakan) as jumlah, labklinikrujukan_nama as data ";
		$criteria->group = " data ";
		$criteria->order = " jumlah DESC ";
		//if ($_GET['tampilGrafik'] == 'wilayah'){

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,                    
		));
	}

	public function searchCriteria(){
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition('DATE(pemeriksaankeluar_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition(" ruanganpengirim_id = '".Yii::app()->user->getState('ruangan_id')."' ");
		
		if (!empty($this->dokterpengirim_id)){
			if (is_array($this->dokterpengirim_id)){
				$criteria->addInCondition("dokterpengirim_id",$this->dokterpengirim_id);
			}else{
				$criteria->addCondition(" dokterpengirim_id = ".$this->dokterpengirim_id." ");
			}
		}
		
		if (!empty($this->labklinikrujukan_id)){
			if (is_array($this->labklinikrujukan_id)){
				$criteria->addInCondition("labklinikrujukan_id",$this->labklinikrujukan_id);
			}else{
				$criteria->addCondition(" labklinikrujukan_id = ".$this->labklinikrujukan_id." ");
			}
		}
		
		if (!empty($this->carabayar_id)){
			if (is_array($this->carabayar_id)){
				$criteria->addInCondition("carabayar_id",$this->carabayar_id);
			}else{
				$criteria->addCondition(" carabayar_id = ".$this->carabayar_id." ");
			}
		}
		
		if (!empty($this->penjamin_id)){
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition("penjamin_id",$this->penjamin_id);
			}else{
				$criteria->addCondition(" penjamin_id = ".$this->penjamin_id." ");
			}
		}
		
		

		return $criteria;
	}
}