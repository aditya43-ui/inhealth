<?php
class LAPenerimaanlinendetailT extends PenerimaanlinendetailT {
	public $tgl_awal,$tgl_akhir,$instalasi_id,$ruangan_id;
	public $kodelinen,$namalinen,$nopenerimaanlinen, $barang_nama, $noregisterlinen;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchPenerimaanLinenDetail()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$format = new MyFormatter();
		$criteria=new CDbCriteria;
		$this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
		
		$criteria->limit=1000;
		if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
			$criteria->limit = 0;
		}
		$criteria->select = 'penerimaanlinen_t.*,t.*,ruangan_m.*,linen_m.linen_id, linen_m.kodelinen, linen_m.namalinen';
		$criteria->addBetweenCondition('DATE(penerimaanlinen_t.tglpenerimaanlinen)', $this->tgl_awal, $this->tgl_akhir,true);
		
		if(!empty($this->nopenerimaanlinen)){
			$criteria->compare('LOWER(penerimaanlinen_t.nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		}
		if(!empty($this->penerimaanlinendetail_id)){
			$criteria->addCondition('t.penerimaanlinendetail_id = '.$this->penerimaanlinendetail_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('t.linen_id = '.$this->linen_id);
		}
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('t.penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('penerimaanlinen_t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->jenisperawatanlinen)){
			$criteria->compare('LOWER(jenisperawatanlinen)',strtolower($this->jenisperawatanlinen));
		}else{
			$criteria->addCondition("t.jenisperawatanlinen != '".Params::JENISPERAWATAN_PENCUCIAN."'");
		}
		$criteria->compare('LOWER(penerimaanlinen_t.nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		$criteria->compare('LOWER(t.keterangan_penerimaanlinen)',strtolower($this->keterangan_penerimaanlinen),true);
		$criteria->join = 'LEFT JOIN penerimaanlinen_t ON penerimaanlinen_t.penerimaanlinen_id = t.penerimaanlinen_id'
				. ' LEFT JOIN ruangan_m ON ruangan_m.ruangan_id = penerimaanlinen_t.ruangan_id'
				. ' LEFT JOIN linen_m ON linen_m.linen_id = t.linen_id';
                $criteria->addCondition("t.penerimaanlinen_id NOT IN (SELECT penerimaanlinen_id FROM perawatanlinendetail_t)");
//		echo '<pre>';
//                print_r($criteria);
//                exit();
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}
