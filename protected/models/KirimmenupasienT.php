<?php

/**
 * This is the model class for table "kirimmenupasien_t".
 *
 * The followings are the available columns in table 'kirimmenupasien_t':
 * @property integer $kirimmenupasien_id
 * @property integer $ruangan_id
 * @property integer $kirimmenudiet_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property integer $menudiet_id
 * @property integer $pendaftaran_id
 * @property integer $pesanmenudetail_id
 * @property integer $jeniswaktu_id
 * @property double $jml_kirim
 * @property string $satuanjml_urt
 * @property integer $kelaspelayanan_id
 * @property double $hargasatuan
 */
class KirimmenupasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimmenupasienT the static model class
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
		return 'kirimmenupasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, kirimmenudiet_id, pasien_id, menudiet_id, pendaftaran_id, jeniswaktu_id, jml_kirim', 'required'),
			array('ruangan_id, kirimmenudiet_id, pasien_id, pasienadmisi_id, menudiet_id, pendaftaran_id, pesanmenudetail_id, jeniswaktu_id,kelaspelayanan_id', 'numerical', 'integerOnly'=>true),
			array('jml_kirim,hargasatuan', 'numerical'),
			array('satuanjml_urt', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kirimmenupasien_id, ruangan_id, kirimmenudiet_id, pasien_id, pasienadmisi_id, menudiet_id, pendaftaran_id, pesanmenudetail_id, jeniswaktu_id, jml_kirim, satuanjml_urt,kelaspelayanan_id,hargasatuan', 'safe', 'on'=>'search'),
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
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'pasien'=>array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                    'menudiet'=>array(self::BELONGS_TO, 'MenuDietM', 'menudiet_id'),
                    'kirimmenudiet'=>array(self::BELONGS_TO, 'KirimmenudietT', 'kirimmenudiet_id'),
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
                    'jeniswaktu'=>array(self::BELONGS_TO, 'JeniswaktuM', 'jeniswaktu_id'),
                    'pasienadmisi'=>array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kirimmenupasien_id' => 'Kirim Menu Pasien',
			'ruangan_id' => 'Ruangan',
			'kirimmenudiet_id' => 'Kirim Menu Diet',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasien Admisi',
			'menudiet_id' => 'Menu Diet',
			'pendaftaran_id' => 'Pendaftaran',
			'pesanmenudetail_id' => 'Pesan Menu Detail',
			'jeniswaktu_id' => 'Jenis Waktu',
			'jml_kirim' => 'Jml Kirim',
			'satuanjml_urt' => 'Satuan Jumlah Urt',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'hargasatuan' => 'Harga Satuan',
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

		$criteria->compare('kirimmenupasien_id',$this->kirimmenupasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pesanmenudetail_id',$this->pesanmenudetail_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jml_kirim',$this->jml_kirim);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);
                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                $criteria->compare('hargasatuan',$this->hargasatuan);
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kirimmenupasien_id',$this->kirimmenupasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pesanmenudetail_id',$this->pesanmenudetail_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jml_kirim',$this->jml_kirim);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);
                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                $criteria->compare('hargasatuan',$this->hargasatuan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}