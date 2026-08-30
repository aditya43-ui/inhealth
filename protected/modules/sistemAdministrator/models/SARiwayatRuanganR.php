<?php

/**
 * This is the model class for table "riwayatruangan_r".
 *
 * The followings are the available columns in table 'riwayatruangan_r':
 * @property integer $riwayatruangan_id
 * @property string $tglpenetapanruangan
 * @property string $nopenetapanruangan
 * @property string $tentangpenetapan
 */
class SARiwayatRuanganR extends RiwayatruanganR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatruanganR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}