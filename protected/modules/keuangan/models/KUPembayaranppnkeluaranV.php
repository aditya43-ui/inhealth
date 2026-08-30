<?php
class KUPembayaranppnkeluaranV extends PembayaranppnkeluaranV
{
	public $tgl_awal, $tgl_akhir, $jmldibayarkan, $sisahutang, $keterangan, $bayarke, $checklist;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPenjaminItems($carabayar_id=null)
	{
			if(!empty($carabayar_id))
					return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
			else
				return array();
	}


}

?>
