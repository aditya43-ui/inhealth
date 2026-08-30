<?php

/**
 * This is the model class for table "laporanpotongan_v".
 *
 * The followings are the available columns in table 'laporanpotongan_v':
 * @property integer $potongansumber_id
 * @property string $namapotongan
 * @property string $tglpengajuanpemb
 * @property string $nopengajuan
 * @property string $tglpembjthtempo
 * @property string $sampaidgntgljthtempo
 * @property string $tglbuktibayar
 * @property string $nobuktimasuk
 * @property string $carapembayaran
 * @property string $sebagaipembayaran_bkm
 * @property string $keterangan_pembayaran
 * @property double $potongan_simpananwajib
 * @property double $potongan_simpanansukarela
 * @property double $potongan_pokokangsuran
 * @property double $potongan_jasaangsuran
 * @property double $potongan_dendaangsuran
 * @property double $potongan_totalpengajuan
 * @property double $potongan_sisapengajuan
 * @property double $potongan_bayarangsuran
 * @property double $potongan_sisaangsuran
 * @property double $jmlpembayaran
 * @property string $tgldibuat_pengpemb
 * @property integer $dibuatoleh_id_pengpemb
 * @property string $tgldiperiksa_pengpemb
 * @property integer $diperiksaoleh_id_pengpemb
 * @property string $tgldisetujui_pengpemb
 * @property integer $disetujuioleh_id_pengpemb
 */
class LaporanpotonganV extends CActiveRecord
{
        public $tgl_awal, $bln_awal, $thn_awal;
        public $tgl_akhir, $bln_akhir, $thn_akhir;
        public $jns_periode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpotonganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanpotongan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('potongansumber_id, dibuatoleh_id_pengpemb, diperiksaoleh_id_pengpemb, disetujuioleh_id_pengpemb', 'numerical', 'integerOnly'=>true),
			array('potongan_simpananwajib, potongan_simpanansukarela, potongan_pokokangsuran, potongan_jasaangsuran, potongan_dendaangsuran, potongan_totalpengajuan, potongan_sisapengajuan, potongan_bayarangsuran, potongan_sisaangsuran, jmlpembayaran', 'numerical'),
			array('namapotongan, sebagaipembayaran_bkm', 'length', 'max'=>100),
			array('nopengajuan, nobuktimasuk, carapembayaran', 'length', 'max'=>50),
			array('tglpengajuanpemb, tglpembjthtempo, sampaidgntgljthtempo, tglbuktibayar, keterangan_pembayaran, tgldibuat_pengpemb, tgldiperiksa_pengpemb, tgldisetujui_pengpemb', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('potongansumber_id, namapotongan, tglpengajuanpemb, nopengajuan, tglpembjthtempo, sampaidgntgljthtempo, tglbuktibayar, nobuktimasuk, carapembayaran, sebagaipembayaran_bkm, keterangan_pembayaran, potongan_simpananwajib, potongan_simpanansukarela, potongan_pokokangsuran, potongan_jasaangsuran, potongan_dendaangsuran, potongan_totalpengajuan, potongan_sisapengajuan, potongan_bayarangsuran, potongan_sisaangsuran, jmlpembayaran, tgldibuat_pengpemb, dibuatoleh_id_pengpemb, tgldiperiksa_pengpemb, diperiksaoleh_id_pengpemb, tgldisetujui_pengpemb, disetujuioleh_id_pengpemb', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'potongansumber_id' => 'Potongansumber',
			'namapotongan' => 'Namapotongan',
			'tglpengajuanpemb' => 'Tglpengajuanpemb',
			'nopengajuan' => 'Nopengajuan',
			'tglpembjthtempo' => 'Tglpembjthtempo',
			'sampaidgntgljthtempo' => 'Sampaidgntgljthtempo',
			'tglbuktibayar' => 'Tglbuktibayar',
			'nobuktimasuk' => 'Nobuktimasuk',
			'carapembayaran' => 'Carapembayaran',
			'sebagaipembayaran_bkm' => 'Sebagaipembayaran Bkm',
			'keterangan_pembayaran' => 'Keterangan Pembayaran',
			'potongan_simpananwajib' => 'Potongan Simpananwajib',
			'potongan_simpanansukarela' => 'Potongan Simpanansukarela',
			'potongan_pokokangsuran' => 'Potongan Pokokangsuran',
			'potongan_jasaangsuran' => 'Potongan Jasaangsuran',
			'potongan_dendaangsuran' => 'Potongan Dendaangsuran',
			'potongan_totalpengajuan' => 'Potongan Totalpengajuan',
			'potongan_sisapengajuan' => 'Potongan Sisapengajuan',
			'potongan_bayarangsuran' => 'Potongan Bayarangsuran',
			'potongan_sisaangsuran' => 'Potongan Sisaangsuran',
			'jmlpembayaran' => 'Jmlpembayaran',
			'tgldibuat_pengpemb' => 'Tgldibuat Pengpemb',
			'dibuatoleh_id_pengpemb' => 'Dibuatoleh Id Pengpemb',
			'tgldiperiksa_pengpemb' => 'Tgldiperiksa Pengpemb',
			'diperiksaoleh_id_pengpemb' => 'Diperiksaoleh Id Pengpemb',
			'tgldisetujui_pengpemb' => 'Tgldisetujui Pengpemb',
			'disetujuioleh_id_pengpemb' => 'Disetujuioleh Id Pengpemb',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('namapotongan',$this->namapotongan,true);
		$criteria->compare('tglpengajuanpemb',$this->tglpengajuanpemb,true);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);
		$criteria->compare('tglpembjthtempo',$this->tglpembjthtempo,true);
		$criteria->compare('sampaidgntgljthtempo',$this->sampaidgntgljthtempo,true);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('nobuktimasuk',$this->nobuktimasuk,true);
		$criteria->compare('carapembayaran',$this->carapembayaran,true);
		$criteria->compare('sebagaipembayaran_bkm',$this->sebagaipembayaran_bkm,true);
		$criteria->compare('keterangan_pembayaran',$this->keterangan_pembayaran,true);
		$criteria->compare('potongan_simpananwajib',$this->potongan_simpananwajib);
		$criteria->compare('potongan_simpanansukarela',$this->potongan_simpanansukarela);
		$criteria->compare('potongan_pokokangsuran',$this->potongan_pokokangsuran);
		$criteria->compare('potongan_jasaangsuran',$this->potongan_jasaangsuran);
		$criteria->compare('potongan_dendaangsuran',$this->potongan_dendaangsuran);
		$criteria->compare('potongan_totalpengajuan',$this->potongan_totalpengajuan);
		$criteria->compare('potongan_sisapengajuan',$this->potongan_sisapengajuan);
		$criteria->compare('potongan_bayarangsuran',$this->potongan_bayarangsuran);
		$criteria->compare('potongan_sisaangsuran',$this->potongan_sisaangsuran);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('tgldibuat_pengpemb',$this->tgldibuat_pengpemb,true);
		$criteria->compare('dibuatoleh_id_pengpemb',$this->dibuatoleh_id_pengpemb);
		$criteria->compare('tgldiperiksa_pengpemb',$this->tgldiperiksa_pengpemb,true);
		$criteria->compare('diperiksaoleh_id_pengpemb',$this->diperiksaoleh_id_pengpemb);
		$criteria->compare('tgldisetujui_pengpemb',$this->tgldisetujui_pengpemb,true);
		$criteria->compare('disetujuioleh_id_pengpemb',$this->disetujuioleh_id_pengpemb);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTotSW($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->potongan_simpananwajib;
		}
		return $total;
	}

	public function getTotSS($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->potongan_simpanansukarela;
		}
		return $total;
	}

	public function getTotPK($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->potongan_pokokangsuran;
		}
		return $total;
	}

	public function getTotJA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->potongan_jasaangsuran;
		}
		return $total;
	}

	public function getTotDA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->potongan_dendaangsuran;
		}
		return $total;
	}

	public function getTotPengajuan($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->potongan_totalpengajuan;
		}
		return $total;
	}

	public function getTotPenerimaan($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmlpembayaran;
		}
		return $total;
	}

	public function getTotSisa($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->potongan_sisaangsuran;
		}
		return $total;
	}
}