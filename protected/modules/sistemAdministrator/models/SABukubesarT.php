<?php

/**
 * This is the model class for table "bukubesar_t".
 *
 * The followings are the available columns in table 'bukubesar_t':
 * @property integer $bukubesar_id
 * @property integer $rekening3_id
 * @property integer $rekening4_id
 * @property integer $rekening2_id
 * @property integer $rekening5_id
 * @property integer $rekening1_id
 * @property string $tglbukubesar
 * @property string $uraiantransaksi
 * @property double $saldodebit
 * @property double $saldokredit
 * @property double $saldoakhirberjalan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $no_referensi
 * @property integer $periodeposting_id
 *
 * The followings are the available model relations:
 * @property LaporanlabarugidetailR[] $laporanlabarugidetailRs
 * @property JurnalrekeningT[] $jurnalrekeningTs
 * @property JurnalpostingT[] $jurnalpostingTs
 * @property LaporanperubahanmodaldetailR[] $laporanperubahanmodaldetailRs
 * @property PeriodepostingM $periodeposting
 * @property Rekening1M $rekening1
 * @property Rekening2M $rekening2
 * @property Rekening3M $rekening3
 * @property Rekening4M $rekening4
 * @property Rekening5M $rekening5
 */
class SABukubesarT extends BukubesarT
{
	public $rekperiode_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BukubesarT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}