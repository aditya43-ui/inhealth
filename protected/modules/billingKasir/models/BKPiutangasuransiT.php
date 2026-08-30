<?php

/**
 * This is the model class for table "piutangasuransi_t".
 *
 * The followings are the available columns in table 'piutangasuransi_t':
 * @property integer $piutangasuransi_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property double $jmlpiutangasuransi
 *
 * The followings are the available model relations:
 * @property CarabayarM $carabayar
 * @property PembayaranpelayananT $pembayaranpelayanan
 * @property PenjaminpasienM $penjamin
 */
class BKPiutangasuransiT extends PiutangasuransiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PiutangasuransiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
	
	public function getPenjaminItems($carabayar_id=null)
	{
		if(!empty($carabayar_id))
				return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
		else
				return array();
	}

}