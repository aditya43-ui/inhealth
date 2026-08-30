<?php

class KUPenggajiankompT extends PenggajiankompT{
	public $jml_kenaikan,$total;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}