<?php
class BKPengajuanklaimpiutangT extends PengajuanklaimpiutangT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanklaimpiutangT the static model class
	 */
	public $penjamin_nama, $penjamin_id;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function searchBelumBayarKlaim()
	{
		$prov = $this->search();
		$criteria = $prov->criteria;
		
		$criteria->group = $criteria->select = 't.penjamin_id, t.tgljatuhtempo, t.tglpengajuanklaimanklaim, '
				. 't.nopengajuanklaimanklaim, t.pengajuanklaimpiutang_id, t.penjamin_id, p.penjamin_nama';
		$criteria->join = 'left join penjaminpasien_m p on p.penjamin_id = t.penjamin_id '
				. 'left join ('
				. 'select 
					t.pengajuanklaimpiutang_id, t.jumlahbayar, sum(b.jumlahbayar) as dibayar
					from pengajuanklaimdetail_t t
					left join pembklaimdetal_t b on b.pengajuanklaimdetail_id = t.pengajuanklaimdetail_id
					group by t.pengajuanklaimpiutang_id, t.jumlahbayar'
				. ') pkm on pkm.pengajuanklaimpiutang_id = t.pengajuanklaimpiutang_id';
		
		$criteria->addCondition('pkm.dibayar is null or pkm.jumlahbayar > pkm.dibayar');
        $criteria->addCondition('pkm.jumlahbayar <> 0');
		
		$prov->criteria = $criteria;
        $prov->sort->defaultOrder = 't.tgljatuhtempo';
        
		return $prov;
	}
        
        public function searchDialogKlaim() {
            $cr = new CDbCriteria;
            $cr->addCondition('pembayarklaim_id is null');
            $cr->compare('lower(nopengajuanklaimanklaim)', strtolower($this->nopengajuanklaimanklaim), true);
            $cr->compare('carabayar_id', $this->carabayar_id);
            $cr->compare('penjamin_id', $this->penjamin_id);
            $cr->order = 'tglpengajuanklaimanklaim desc';
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$cr,
            ));
        }
}