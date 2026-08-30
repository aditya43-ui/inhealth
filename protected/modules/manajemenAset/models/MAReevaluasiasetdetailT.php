<?php

class MAReevaluasiasetdetailT extends ReevaluasiasetdetailT
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reevaluasiasetdetail_id' => 'Reevaluasi Aset Detail',
			'barang_id' => 'Barang',
			'invtanah_id' => 'Inv Tanah',
			'invgedung_id' => 'Inv Gedung',
			'invperalatan_id' => 'Inv Peralatan',
			'invjalan_id' => 'Inv Jalan',
			'invasetlain_id' => 'Inv Aset Lain',
			'reevaluasiaset_umurekonomis' => 'Umur Ekonomis',
			'reevaluasiaset_nilaibuku' => 'Nilai Buku',
			'reevaluasiaset_hargaperolehan' => 'Harga Perolehan',
			'reevaluasiaset_selisihreevaluasi' => 'Selisih Reevaluasi',
			'reevaluasiaset_id' => 'Reevaluasi Aset',
		);
	}

}