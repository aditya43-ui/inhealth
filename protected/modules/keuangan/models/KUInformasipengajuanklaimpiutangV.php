<?php

/**
 * This is the model class for table "informasipengajuanklaimpiutang_v".
 *
 * The followings are the available columns in table 'informasipengajuanklaimpiutang_v':
 * @property integer $pengajuanklaimpiutang_id
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $tglpengajuanklaimanklaim
 * @property string $nopengajuanklaimanklaim
 * @property double $totalpiutang
 * @property double $totalsisapiutang
 * @property string $tgljatuhtempo
 */
class KUInformasipengajuanklaimpiutangV extends InformasipengajuanklaimpiutangV
{
	public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipengajuanklaimpiutangV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasiPengajuan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->addBetweenCondition('date(tglpengajuanklaimanklaim)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->limit=10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pengajuanklaimpiutang_id',$this->pengajuanklaimpiutang_id);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('tglpengajuanklaimanklaim',$this->tglpengajuanklaimanklaim,true);
		$criteria->compare('nopengajuanklaimanklaim',$this->nopengajuanklaimanklaim,true);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('totalsisapiutang',$this->totalsisapiutang);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);

		return $criteria;
	}
	
	public function getPenjaminItems($carabayar_id=null)
	{
		if(!empty($carabayar_id))
				return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
		else
				return array();
				//return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
	}
	
	public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
}