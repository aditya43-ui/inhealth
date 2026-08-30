<?php
class LAPenyimpananlinenV extends PenyimpananlinenV
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
		$criteria=new CDbCriteria;
        $criteria->join = 'left join penyimpananlinen_t p on p.penyimpananlinen_id = t.penyimpananlinen_id';
		$criteria->select = 't.penyimpananlinen_id, t.nopenyimpananlinen, t.tglpenyimpananlinen, t.ruangan_nama, t.keterangan_penyimpanan';
        $criteria->addCondition('p.pengirimanlinen_id is null');
		$criteria->group = $criteria->select;
		$criteria->compare('LOWER(t.nopenyimpananlinen)',strtolower($this->nopenyimpananlinen),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		/*RSPMC-921  $criteria->addCondition("penyimpananlinen_id NOT IN (SELECT penyimpananlinen_id FROM pengirimanlinendetail_t WHERE penyimpananlinen_id IS NOT NULL)");*/

		$criteria->limit=5;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
                                    'pageSize'=>5,
                                ),
		));
	}
}