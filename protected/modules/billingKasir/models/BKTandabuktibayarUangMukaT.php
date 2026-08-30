<?php

/**
 * This is the model class for table "tandabuktibayar_t".
 *
 * The followings are the available columns in table 'tandabuktibayar_t':
 * @property integer $tandabuktibayar_id
 * @property integer $closingkasir_id
 * @property integer $ruangan_id
 * @property integer $shift_id
 * @property integer $bayaruangmuka_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $nourutkasir
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property string $carapembayaran
 * @property string $dengankartu
 * @property string $bankkartu
 * @property string $nokartu
 * @property string $nostrukkartu
 * @property string $darinama_bkm
 * @property string $alamat_bkm
 * @property string $sebagaipembayaran_bkm
 * @property double $jmlpembulatan
 * @property double $jmlpembayaran
 * @property double $biayaadministrasi
 * @property double $biayamaterai
 * @property double $uangditerima
 * @property double $uangkembalian
 * @property double $keterangan_pembayaran
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BKTandabuktibayarUangMukaT extends TandabuktibayarT
{
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'closingkasir_id' => 'Closingkasir',
			'ruangan_id' => 'Ruangan',
			'shift_id' => 'Shift',
			'bayaruangmuka_id' => 'Bayaruangmuka',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'nourutkasir' => 'No. Urut Kasir',
			'nobuktibayar' => 'No. Bukti Bayar',
			'tglbuktibayar' => 'Tgl. Bukti Bayar',
			'carapembayaran' => 'Cara Pembayaran',
			'dengankartu' => 'Dengan Kartu',
			'bankkartu' => 'Bank Kartu',
			'nokartu' => 'No. Kartu',
			'nostrukkartu' => 'No. Struk Kartu',
			'darinama_bkm' => 'Dari Nama',
			'alamat_bkm' => 'Alamat',
			'sebagaipembayaran_bkm' => 'Sebagai Pembayaran',
			'jmlpembulatan' => 'Jml Pembulatan',
			'jmlpembayaran' => 'Pembayaran Uang Muka',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayamaterai' => 'Biaya Materai',
			'uangditerima' => 'Uang Diterima',
			'uangkembalian' => 'Uang Kembalian',
			'keterangan_pembayaran' => 'Keterangan Pembayaran',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}
}