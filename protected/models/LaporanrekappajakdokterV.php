<?php

/**
 * This is the model class for table "laporanrekappajakdokter_v".
 *
 * The followings are the available columns in table 'laporanrekappajakdokter_v':
 * @property integer $pegawai_id
 * @property string $tglbayarjasa
 * @property string $nobayarjasa
 * @property string $periodejasa
 * @property string $sampaidgn
 * @property double $totaltarif
 * @property double $totaljasa
 * @property double $totalbayarjasa
 * @property double $totalsisajasa
 * @property double $total_pajak
 * @property double $total_terima
 * @property integer $mengetahui_id
 * @property string $mengetahui
 * @property integer $mengetahui_pt_id
 * @property string $mengetahui_pt
 * @property integer $menyetujui_id
 * @property string $menyetujui
 * @property string $tgl_perhitungan
 * @property string $no_perhitungan
 * @property string $periodebulanpajak
 * @property double $penghasilanbruto
 * @property double $pkp
 * @property double $pkpkumulatif
 * @property double $pelapisanpph
 * @property double $pajakprogressif
 * @property integer $petugashitung_id
 * @property string $mengetahui_pajak
 * @property string $menyetujui_pajak
 * @property integer $mengetahui_id_pajak
 * @property integer $menyetujui_id_pajak
 * @property string $mengetahui_pt_pajak
 * @property integer $mengetahui_pt_id_pajak
 */
class LaporanrekappajakdokterV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrekappajakdokterV the static model class
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
		return 'laporanrekappajakdokter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, mengetahui_id, mengetahui_pt_id, menyetujui_id, petugashitung_id, mengetahui_id_pajak, menyetujui_id_pajak, mengetahui_pt_id_pajak', 'numerical', 'integerOnly'=>true),
			array('totaltarif, totaljasa, totalbayarjasa, totalsisajasa, total_pajak, total_terima, penghasilanbruto, pkp, pkpkumulatif, pelapisanpph, pajakprogressif', 'numerical'),
			array('nobayarjasa', 'length', 'max'=>15),
			array('no_perhitungan', 'length', 'max'=>50),
			array('mengetahui_pajak, menyetujui_pajak', 'length', 'max'=>100),
			array('tglbayarjasa, periodejasa, sampaidgn, mengetahui, mengetahui_pt, menyetujui, tgl_perhitungan, periodebulanpajak, mengetahui_pt_pajak', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, tglbayarjasa, nobayarjasa, periodejasa, sampaidgn, totaltarif, totaljasa, totalbayarjasa, totalsisajasa, total_pajak, total_terima, mengetahui_id, mengetahui, mengetahui_pt_id, mengetahui_pt, menyetujui_id, menyetujui, tgl_perhitungan, no_perhitungan, periodebulanpajak, penghasilanbruto, pkp, pkpkumulatif, pelapisanpph, pajakprogressif, petugashitung_id, mengetahui_pajak, menyetujui_pajak, mengetahui_id_pajak, menyetujui_id_pajak, mengetahui_pt_pajak, mengetahui_pt_id_pajak', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'tglbayarjasa' => 'Tglbayarjasa',
			'nobayarjasa' => 'Nobayarjasa',
			'periodejasa' => 'Periodejasa',
			'sampaidgn' => 'Sampaidgn',
			'totaltarif' => 'Totaltarif',
			'totaljasa' => 'Totaljasa',
			'totalbayarjasa' => 'Totalbayarjasa',
			'totalsisajasa' => 'Totalsisajasa',
			'total_pajak' => 'Total Pajak',
			'total_terima' => 'Total Terima',
			'mengetahui_id' => 'Mengetahui',
			'mengetahui' => 'Mengetahui',
			'mengetahui_pt_id' => 'Mengetahui Pt',
			'mengetahui_pt' => 'Mengetahui Pt',
			'menyetujui_id' => 'Menyetujui',
			'menyetujui' => 'Menyetujui',
			'tgl_perhitungan' => 'Tgl. Perhitungan',
			'no_perhitungan' => 'No Perhitungan',
			'periodebulanpajak' => 'Periodebulanpajak',
			'penghasilanbruto' => 'Penghasilanbruto',
			'pkp' => 'Pkp',
			'pkpkumulatif' => 'Pkpkumulatif',
			'pelapisanpph' => 'Pelapisanpph',
			'pajakprogressif' => 'Pajakprogressif',
			'petugashitung_id' => 'Petugashitung',
			'mengetahui_pajak' => 'Mengetahui Pajak',
			'menyetujui_pajak' => 'Menyetujui Pajak',
			'mengetahui_id_pajak' => 'Mengetahui Id Pajak',
			'menyetujui_id_pajak' => 'Menyetujui Id Pajak',
			'mengetahui_pt_pajak' => 'Mengetahui Pt Pajak',
			'mengetahui_pt_id_pajak' => 'Mengetahui Pt Id Pajak',
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

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglbayarjasa',$this->tglbayarjasa,true);
		$criteria->compare('nobayarjasa',$this->nobayarjasa,true);
		$criteria->compare('periodejasa',$this->periodejasa,true);
		$criteria->compare('sampaidgn',$this->sampaidgn,true);
		$criteria->compare('totaltarif',$this->totaltarif);
		$criteria->compare('totaljasa',$this->totaljasa);
		$criteria->compare('totalbayarjasa',$this->totalbayarjasa);
		$criteria->compare('totalsisajasa',$this->totalsisajasa);
		$criteria->compare('total_pajak',$this->total_pajak);
		$criteria->compare('total_terima',$this->total_terima);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('mengetahui',$this->mengetahui,true);
		$criteria->compare('mengetahui_pt_id',$this->mengetahui_pt_id);
		$criteria->compare('mengetahui_pt',$this->mengetahui_pt,true);
		$criteria->compare('menyetujui_id',$this->menyetujui_id);
		$criteria->compare('menyetujui',$this->menyetujui,true);
		$criteria->compare('tgl_perhitungan',$this->tgl_perhitungan,true);
		$criteria->compare('no_perhitungan',$this->no_perhitungan,true);
		$criteria->compare('periodebulanpajak',$this->periodebulanpajak,true);
		$criteria->compare('penghasilanbruto',$this->penghasilanbruto);
		$criteria->compare('pkp',$this->pkp);
		$criteria->compare('pkpkumulatif',$this->pkpkumulatif);
		$criteria->compare('pelapisanpph',$this->pelapisanpph);
		$criteria->compare('pajakprogressif',$this->pajakprogressif);
		$criteria->compare('petugashitung_id',$this->petugashitung_id);
		$criteria->compare('mengetahui_pajak',$this->mengetahui_pajak,true);
		$criteria->compare('menyetujui_pajak',$this->menyetujui_pajak,true);
		$criteria->compare('mengetahui_id_pajak',$this->mengetahui_id_pajak);
		$criteria->compare('menyetujui_id_pajak',$this->menyetujui_id_pajak);
		$criteria->compare('mengetahui_pt_pajak',$this->mengetahui_pt_pajak,true);
		$criteria->compare('mengetahui_pt_id_pajak',$this->mengetahui_pt_id_pajak);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}