<?php

/**
 * This is the model class for table "komponenjasa_m".
 *
 * The followings are the available columns in table 'komponenjasa_m':
 * @property integer $komponenjasa_id
 * @property integer $komponentarif_id
 * @property integer $carabayar_id
 * @property integer $kelompoktindakan_id
 * @property integer $ruangan_id
 * @property integer $jenistarif_id
 * @property string $komponenjasa_kode
 * @property string $komponenjasa_nama
 * @property string $komponenjasa_singkatan
 * @property integer $besaranjasa
 * @property double $potongan
 * @property string $jasadireksi
 * @property string $kuebesar
 * @property string $jasadokter
 * @property string $jasaparamedis
 * @property string $jasaunit
 * @property string $jasabalanceins
 * @property string $jasaemergency
 * @property string $biayaumum
 * @property boolean $komponenjasa_aktif
 */
class KomponenjasaM extends CActiveRecord
{
        public $no;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomponenjasaM the static model class
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
		return 'komponenjasa_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponentarif_id, carabayar_id, kelompoktindakan_id, jenistarif_id, komponenjasa_kode, komponenjasa_nama, komponenjasa_singkatan, potongan, jasadokter, jasabalanceins, jasaemergency', 'required'),
			array('komponentarif_id, carabayar_id, kelompoktindakan_id, ruangan_id, jenistarif_id, besaranjasa', 'numerical', 'integerOnly'=>true),
			array('potongan', 'numerical'),
			array('komponenjasa_kode', 'length', 'max'=>5),
			array('komponenjasa_nama', 'length', 'max'=>100),
			array('komponenjasa_singkatan', 'length', 'max'=>10),
			array('jasadireksi, kuebesar, jasadokter, jasaparamedis, jasaunit, jasabalanceins, jasaemergency, biayaumum', 'length', 'max'=>50),
			array('komponenjasa_aktif,no', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponenjasa_id, komponentarif_id, no, carabayar_id, kelompoktindakan_id, ruangan_id, jenistarif_id, komponenjasa_kode, komponenjasa_nama, komponenjasa_singkatan, besaranjasa, potongan, jasadireksi, kuebesar, jasadokter, jasaparamedis, jasaunit, jasabalanceins, jasaemergency, biayaumum, komponenjasa_aktif', 'safe', 'on'=>'search'),
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
                    'komponentarif' => array(self::BELONGS_TO, 'KomponentarifM', 'komponentarif_id'),
                    'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
                    'jenistarif' => array(self::BELONGS_TO, 'JenistarifM', 'jenistarif_id'),
                    'kelompoktindakan' => array(self::BELONGS_TO, 'KelompoktindakanM', 'kelompoktindakan_id'),
                    'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'komponenjasa_id' => 'ID',
			'komponentarif_id' => 'Komponen Tarif',
			'carabayar_id' => 'Jenis Penjamin',
			'kelompoktindakan_id' => 'Kelompok Tindakan',
			'ruangan_id' => 'Ruangan',
			'jenistarif_id' => 'Jenis Tarif',
			'komponenjasa_kode' => 'Kode Komponen Jasa',
			'komponenjasa_nama' => 'Nama Komponen Jasa',
			'komponenjasa_singkatan' => 'Singkatan Komponen Jasa',
			'besaranjasa' => 'Besaran Jasa',
			'potongan' => 'Potongan',
			'jasadireksi' => 'Jasa Direksi',
			'kuebesar' => 'Kue Besar',
			'jasadokter' => 'Jasa Dokter',
			'jasaparamedis' => 'Jasa Paramedis',
			'jasaunit' => 'Jasa Unit',
			'jasabalanceins' => 'Jasa Balanceins',
			'jasaemergency' => 'Jasa Emergency',
			'biayaumum' => 'Biaya Umum',
			'komponenjasa_aktif' => 'Komponen Jasa Aktif',
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

		$criteria->compare('komponenjasa_id',$this->komponenjasa_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(komponenjasa_kode)',strtolower($this->komponenjasa_kode),true);
		$criteria->compare('LOWER(komponenjasa_nama)',strtolower($this->komponenjasa_nama),true);
		$criteria->compare('LOWER(komponenjasa_singkatan)',strtolower($this->komponenjasa_singkatan),true);
		$criteria->compare('besaranjasa',$this->besaranjasa);
		$criteria->compare('potongan',$this->potongan);
		$criteria->compare('LOWER(jasadireksi)',strtolower($this->jasadireksi),true);
		$criteria->compare('LOWER(kuebesar)',strtolower($this->kuebesar),true);
		$criteria->compare('LOWER(jasadokter)',strtolower($this->jasadokter),true);
		$criteria->compare('LOWER(jasaparamedis)',strtolower($this->jasaparamedis),true);
		$criteria->compare('LOWER(jasaunit)',strtolower($this->jasaunit),true);
		$criteria->compare('LOWER(jasabalanceins)',strtolower($this->jasabalanceins),true);
		$criteria->compare('LOWER(jasaemergency)',strtolower($this->jasaemergency),true);
		$criteria->compare('LOWER(biayaumum)',strtolower($this->biayaumum),true);
		$criteria->compare('komponenjasa_aktif',isset($this->komponenjasa_aktif)?$this->komponenjasa_aktif:true);
               // $criteria->addCondition('komponenjasa_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('komponenjasa_id',$this->komponenjasa_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(komponenjasa_kode)',strtolower($this->komponenjasa_kode),true);
		$criteria->compare('LOWER(komponenjasa_nama)',strtolower($this->komponenjasa_nama),true);
		$criteria->compare('LOWER(komponenjasa_singkatan)',strtolower($this->komponenjasa_singkatan),true);
		$criteria->compare('besaranjasa',$this->besaranjasa);
		$criteria->compare('potongan',$this->potongan);
		$criteria->compare('LOWER(jasadireksi)',strtolower($this->jasadireksi),true);
		$criteria->compare('LOWER(kuebesar)',strtolower($this->kuebesar),true);
		$criteria->compare('LOWER(jasadokter)',strtolower($this->jasadokter),true);
		$criteria->compare('LOWER(jasaparamedis)',strtolower($this->jasaparamedis),true);
		$criteria->compare('LOWER(jasaunit)',strtolower($this->jasaunit),true);
		$criteria->compare('LOWER(jasabalanceins)',strtolower($this->jasabalanceins),true);
		$criteria->compare('LOWER(jasaemergency)',strtolower($this->jasaemergency),true);
		$criteria->compare('LOWER(biayaumum)',strtolower($this->biayaumum),true);
		$criteria->compare('komponenjasa_aktif',$this->komponenjasa_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getKelompoktindakanItems() {
            return KelompoktindakanM::model()->findAll('kelompoktindakan_aktif=TRUE ORDER BY kelompoktindakan_nama');
        }
        
        public function getRuanganItems() {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE ORDER BY ruangan_nama');
        }
        
        public function getJenistarifItems() {
            return JenistarifM::model()->findAll('jenistarif_aktif=TRUE ORDER BY jenistarif_nama');
        }
        
        public function getCarabayarItems() {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama');
        }
        
        public function getKomponentarifItems() {
            return KomponentarifM::model()->findAll('komponentarif_aktif=TRUE ORDER BY komponentarif_nama');
        }
}