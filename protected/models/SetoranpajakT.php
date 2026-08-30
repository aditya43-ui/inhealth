<?php

/**
 * This is the model class for table "setoranpajak_t".
 *
 * The followings are the available columns in table 'setoranpajak_t':
 * @property integer $setoranpajak_id
 * @property integer $fakturpembelian_id
 * @property integer $terimapersediaan_id
 * @property integer $tandabuktikeluar_id
 * @property integer $jurnalrekening_id
 * @property string $tglsetoranpajak
 * @property double $totalhutang
 * @property double $jmlpembayaran
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property string $create_ruangan
 */
class SetoranpajakT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SetoranpajakT the static model class
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
		return 'setoranpajak_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tandabuktikeluar_id, tglsetoranpajak, totalhutang, jmlpembayaran, create_time, create_loginpemakai', 'required'),
			array('fakturpembelian_id, terimapersediaan_id, tandabuktikeluar_id, jurnalrekening_id, batalpegawai_id, terimabahanmakan_id, pengeluaranumum_id, pajak_id, bayarke, obatalkespasien_id', 'numerical', 'integerOnly'=>true),
			array('totalhutang, jmlpembayaran, totalsisahutang', 'numerical'),
                        array('jenissetoran', 'length', 'max'=>40),
			array('update_time, update_loginpemakai, create_ruangan, tglbatalsetor, alasanbatal, keterangansetoran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setoranpajak_id, fakturpembelian_id, terimapersediaan_id, tandabuktikeluar_id, jurnalrekening_id, tglsetoranpajak, totalhutang, jmlpembayaran, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, tglbatalsetor, batalpegawai_id, alasanbatal, totalsisahutang, jenissetoran, keterangansetoran, terimabahanmakan_id, pengeluaranumum_id, pajak_id, bayarke, obatalkespasien_id', 'safe', 'on'=>'search'),
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
                    'fakturpembelian' => array(self::BELONGS_TO, 'FakturpembelianT', 'fakturpembelian_id'),
                    'terimapersediaan' => array(self::BELONGS_TO, 'TerimapersediaanT', 'terimapersediaan_id'),
                    'terimabahanmakan' => array(self::BELONGS_TO, 'TerimabahanmakanT', 'terimabahanmakan_id'),
                    'pajak' => array(self::BELONGS_TO, 'PajakM', 'pajak_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'setoranpajak_id' => 'Setoranpajak',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'terimapersediaan_id' => 'Terima Persediaan',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'jurnalrekening_id' => 'Jurnalrekening',
			'tglsetoranpajak' => 'Tgl. Penyetoran',
			'totalhutang' => 'Total Hutang',
			'jmlpembayaran' => 'Jumlah Setoran',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                    'totalsisahutang'=>'Total Sisa Hutang'
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

		$criteria->compare('setoranpajak_id',$this->setoranpajak_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		$criteria->compare('tglsetoranpajak',$this->tglsetoranpajak,true);
		$criteria->compare('totalhutang',$this->totalhutang);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
