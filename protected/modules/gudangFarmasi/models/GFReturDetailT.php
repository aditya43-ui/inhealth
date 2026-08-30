<?php

class GFReturDetailT extends ReturdetailT
{
        public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturdetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRetur()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->with=array('retur','obatalkes','fakturdetail');
                $criteria->condition = 'jmlretur > 0';
                $criteria->addBetweenCondition('date(retur.tglretur)', $this->tgl_awal, $this->tgl_akhir);
                $criteria->compare('obatalkes.obatalkes_nama', $this->namaObat);
                $criteria->compare('retur.noretur', $this->noRetur);
                $criteria->join = 'left join fakturdetail_t on fakturdetail_t.fakturdetail_id = t.fakturdetail_id
                                   left join fakturpembelian_t ON fakturpembelian_t.fakturpembelian_id = fakturdetail_t.fakturpembelian_id';
                $criteria->compare('lower(fakturpembelian_t.nofaktur)',strtolower($this->noFaktur),true);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
        		));
	}

}