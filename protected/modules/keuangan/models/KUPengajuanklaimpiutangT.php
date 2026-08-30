<?php

/**
 * This is the model class for table "pengajuanklaimpiutang_t".
 *
 * The followings are the available columns in table 'pengajuanklaimpiutang_t':
 * @property integer $pengajuanklaimpiutang_id
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property string $tglpengajuanklaimanklaim
 * @property string $nopengajuanklaimanklaim
 * @property double $totalpiutang
 * @property double $totalsisapiutang
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengajuanklaimdetailT[] $pengajuanklaimdetailTs
 * @property PembayarklaimT[] $pembayarklaimTs
 * @property CarabayarM $carabayar
 * @property PenjaminpasienM $penjamin
 */
class KUPengajuanklaimpiutangT extends PengajuanklaimpiutangT
{
	public $tgl_awalPengajuan,$tgl_akhirPengajuan,$tgl_awalJatuhTempo,$tgl_akhirJatuhTempo;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanklaimpiutangT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	* Mengambil daftar semua carabayar
	* @return CActiveDataProvider 
	*/
	public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
		
	public function getPenjaminItems($carabayar_id=null)
	{
	   if(!empty($carabayar_id))
			   return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true,'carabayar_id'=>$carabayar_id),array('order'=>'penjamin_nama'));
	   else
			   return array();
	}
}
