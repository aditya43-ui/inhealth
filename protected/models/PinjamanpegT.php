<?php

/**
 * This is the model class for table "pinjamanpeg_t".
 *
 * The followings are the available columns in table 'pinjamanpeg_t':
 * @property integer $pinjamanpeg_id
 * @property integer $tandabuktikeluar_id
 * @property integer $komponengaji_id
 * @property integer $pegawai_id
 * @property string $tglpinjampeg
 * @property string $tgljatuhtempo
 * @property string $nopinjam
 * @property string $untukkeperluan
 * @property string $keterangan
 * @property double $jumlahpinjaman
 * @property integer $lamapinjambln
 * @property double $persenpinjaman
 * @property double $sisapinjaman
 */
class PinjamanpegT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PinjamanpegT the static model class
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
		return 'pinjamanpeg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponengaji_id, pegawai_id, tglpinjampeg,tgljatuhtempo, nopinjam, jumlahpinjaman, persenpinjaman, sisapinjaman', 'required'),
			array('tandabuktikeluar_id, komponengaji_id, pegawai_id, lamapinjambln', 'numerical', 'integerOnly'=>true),
			array('jumlahpinjaman, persenpinjaman, sisapinjaman', 'numerical'),
			array('nopinjam', 'length', 'max'=>50),
			array('untukkeperluan, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pinjamanpeg_id, tandabuktikeluar_id, komponengaji_id, pegawai_id, tgljatuhtempo, tglpinjampeg, nopinjam, untukkeperluan, keterangan, jumlahpinjaman, lamapinjambln, persenpinjaman, sisapinjaman', 'safe', 'on'=>'search'),
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
			'tandabuktikeluar'=>array(self::BELONGS_TO, 'TandabuktikeluarT', 'tandabuktikeluar_id'),
			'komponengaji'=>array(self::BELONGS_TO, 'KomponengajiM', 'komponengaji_id'),
			'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pinjamanpeg_id' => 'Pinjaman Pegawai',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'komponengaji_id' => 'Komponen Gaji',
			'pegawai_id' => 'Pegawai',
			'tglpinjampeg' => 'Tanggal Peminjaman',
			'tgljatuhtempo' => 'Tanggal Jatuh Tempo',
			'nopinjam' => 'No. Pinjaman',
			'untukkeperluan' => 'Untuk Keperluan',
			'keterangan' => 'Keterangan',
			'jumlahpinjaman' => 'Jumlah Pinjaman',
			'lamapinjambln' => 'Lama Pinjam',
			'persenpinjaman' => 'Bunga Pinjam',
			'sisapinjaman' => 'Sisa Pinjaman',
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

		$criteria->compare('pinjamanpeg_id',$this->pinjamanpeg_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('komponengaji_id',$this->komponengaji_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglpinjampeg',$this->tglpinjampeg);
		$criteria->compare('LOWER(nopinjam)',strtolower($this->nopinjam),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('jumlahpinjaman',$this->jumlahpinjaman);
		$criteria->compare('lamapinjambln',$this->lamapinjambln);
		$criteria->compare('persenpinjaman',$this->persenpinjaman);
		$criteria->compare('sisapinjaman',$this->sisapinjaman);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pinjamanpeg_id',$this->pinjamanpeg_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('komponengaji_id',$this->komponengaji_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglpinjampeg',$this->tglpinjampeg);
		$criteria->compare('LOWER(nopinjam)',strtolower($this->nopinjam),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('jumlahpinjaman',$this->jumlahpinjaman);
		$criteria->compare('lamapinjambln',$this->lamapinjambln);
		$criteria->compare('persenpinjaman',$this->persenpinjaman);
		$criteria->compare('sisapinjaman',$this->sisapinjaman);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}