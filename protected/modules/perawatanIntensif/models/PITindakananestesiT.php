<?php

/**
 * This is the model class for table "tindakananestesi_t".
 *
 * The followings are the available columns in table 'tindakananestesi_t':
 * @property integer $tindakananestesi_id
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property integer $anastesi_id
 * @property integer $praanestesi_id
 * @property integer $intraanestesi_id
 * @property integer $ruangan_id
 * @property integer $alatmedis_id
 * @property string $tgl_tindakananestesi
 * @property integer $qty_tindakan
 * @property double $tarif_tindakan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property AlatmedisM $alatmedis
 * @property AnastesiM $anastesi
 * @property DaftartindakanM $daftartindakan
 * @property IntraanestesiT $intraanestesi
 * @property PraanestesiT $praanestesi
 * @property RuanganM $ruangan
 * @property TindakanpelayananT $tindakanpelayanan
 */
class PITindakananestesiT extends TindakananestesiT
{
	public $tindakansudahbayar_id,$satuantindakan,$tarif_satuan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakananestesiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}