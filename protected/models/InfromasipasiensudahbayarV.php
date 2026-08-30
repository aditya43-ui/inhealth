<?php

/**
 * This is the model class for table "infromasipasiensudahbayar_v".
 *
 * The followings are the available columns in table 'infromasipasiensudahbayar_v':
 * @property string $tglbuktibayar
 * @property string $nobuktibayar
 * @property string $instalasi
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property double $totalbiayapelayanan
 * @property double $totalsubsidiasuransi
 * @property double $totalsubsidipemerintah
 * @property double $totalsubsidirs
 * @property double $totaliurbiaya
 * @property double $totaldiscount
 * @property double $totalpembebasan
 * @property integer $pembayaranpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 */
class InfromasipasiensudahbayarV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfromasipasiensudahbayarV the static model class
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
		return 'infromasipasiensudahbayar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayaranpelayanan_id, pendaftaran_id, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totaldiscount, totalpembebasan', 'numerical'),
			array('nobuktibayar, instalasi, nama_pasien, carabayar_nama, penjamin_nama', 'length', 'max'=>50),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_bin', 'length', 'max'=>30),
			array('tglbuktibayar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglbuktibayar, nobuktibayar, instalasi, no_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, carabayar_nama, penjamin_nama, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totaldiscount, totalpembebasan, pembayaranpelayanan_id, pendaftaran_id, pasienadmisi_id', 'safe', 'on'=>'search'),
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
			'tglbuktibayar' => 'Tglbuktibayar',
			'nobuktibayar' => 'Nobuktibayar',
			'instalasi' => 'Instalasi',
			'no_pendaftaran' => 'No. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'totalbiayapelayanan' => 'Totalbiayapelayanan',
			'totalsubsidiasuransi' => 'Totalsubsidiasuransi',
			'totalsubsidipemerintah' => 'Totalsubsidipemerintah',
			'totalsubsidirs' => 'Totalsubsidirs',
			'totaliurbiaya' => 'Totaliurbiaya',
			'totaldiscount' => 'Total Keringanan',
			'totalpembebasan' => 'Totalpembebasan',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
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

		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(instalasi)',strtolower($this->instalasi),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah',$this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('totalpembebasan',$this->totalpembebasan);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(instalasi)',strtolower($this->instalasi),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah',$this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('totalpembebasan',$this->totalpembebasan);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}