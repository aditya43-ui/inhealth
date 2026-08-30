<?php

/**
 * This is the model class for table "terdugatb_t".
 *
 * The followings are the available columns in table 'terdugatb_t':
 * @property integer $terdugatb_id
 * @property string $tglterdugatb
 * @property string $lokasianatomipenyakit
 * @property double $totalskorintbanak
 * @property string $hasilfototorax
 * @property string $statushiv
 * @property string $jenis_pemeriksaan
 * @property string $riwayatpenyaktterdahulu
 * @property string $tglhasil_xpertmtbrif
 * @property string $hasil_xpertmtbrif
 * @property string $tglhasil_biakan
 * @property string $hasil_biakan
 * @property string $kesimpulan
 * @property string $tglmulaipengobatan
 * @property string $tglselesaipengobatan
 * @property integer $rujukankeluar_id
 * @property string $keterangan
 */
class TerdugatbT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'terdugatb_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rujukankeluar_id', 'numerical', 'integerOnly'=>true),
			array('totalskorintbanak', 'numerical'),
			array('lokasianatomipenyakit', 'length', 'max'=>100),
			array('hasilfototorax, statushiv, hasil_xpertmtbrif, hasil_biakan', 'length', 'max'=>25),
			array('kesimpulan', 'length', 'max'=>50),
			array('tglterdugatb, riwayatpenyaktterdahulu, tglhasil_xpertmtbrif, tglhasil_biakan, tglmulaipengobatan, tglselesaipengobatan, keterangan, jenis_pemeriksaan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('terdugatb_id, tglterdugatb, lokasianatomipenyakit, totalskorintbanak, hasilfototorax, statushiv, jenis_pemeriksaan, riwayatpenyaktterdahulu, tglhasil_xpertmtbrif, hasil_xpertmtbrif, tglhasil_biakan, hasil_biakan, kesimpulan, tglmulaipengobatan, tglselesaipengobatan, rujukankeluar_id, keterangan', 'safe', 'on'=>'search'),
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
			'terdugatb_id' => 'Terduga TB',
			'tglterdugatb' => 'Tgl. Terduga TB',
			'lokasianatomipenyakit' => 'Lokasi Anatomi Penyakit',
			'totalskorintbanak' => 'Total Skoring TB Anak',
			'hasilfototorax' => 'Hasil Pemeriksaan Foto Torax',
			'statushiv' => 'Status HIV',
			'jenis_pemeriksaan' => 'Pemeriksaan',
			'riwayatpenyaktterdahulu' => 'Riwayat Penyakt Terdahulu',
			'tglhasil_xpertmtbrif' => 'Tgl. Hasil Diperoleh',
			'hasil_xpertmtbrif' => 'Hasil',
			'tglhasil_biakan' => 'Tgl. Hasil Diperoleh',
			'hasil_biakan' => 'Hasil',
			'kesimpulan' => 'Kesimpulan',
			'tglmulaipengobatan' => 'Tgl. Mulai Pengobatan TB',
			'tglselesaipengobatan' => 'Tgl. Selesai Pengobatan TB',
			'rujukankeluar_id' => 'Rujukan Keluar',
			'keterangan' => 'Keterangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('terdugatb_id',$this->terdugatb_id);
		$criteria->compare('tglterdugatb',$this->tglterdugatb,true);
		$criteria->compare('lokasianatomipenyakit',$this->lokasianatomipenyakit,true);
		$criteria->compare('totalskorintbanak',$this->totalskorintbanak);
		$criteria->compare('hasilfototorax',$this->hasilfototorax,true);
		$criteria->compare('statushiv',$this->statushiv,true);
		$criteria->compare('jenis_pemeriksaan',$this->jenis_pemeriksaan,true);
		$criteria->compare('riwayatpenyaktterdahulu',$this->riwayatpenyaktterdahulu,true);
		$criteria->compare('tglhasil_xpertmtbrif',$this->tglhasil_xpertmtbrif,true);
		$criteria->compare('hasil_xpertmtbrif',$this->hasil_xpertmtbrif,true);
		$criteria->compare('tglhasil_biakan',$this->tglhasil_biakan,true);
		$criteria->compare('hasil_biakan',$this->hasil_biakan,true);
		$criteria->compare('kesimpulan',$this->kesimpulan,true);
		$criteria->compare('tglmulaipengobatan',$this->tglmulaipengobatan,true);
		$criteria->compare('tglselesaipengobatan',$this->tglselesaipengobatan,true);
		$criteria->compare('rujukankeluar_id',$this->rujukankeluar_id);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TerdugatbT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
