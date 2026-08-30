<?php
/**
 * 
 * - digunakan untuk mengenerate data pada tabel AsesmenedukasiDet_t, hanya untuk modul rawat inap saja
 * RSST-1459
 */
class RIAsesmenedukasiDetT extends AsesmenedukasiDetT
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}