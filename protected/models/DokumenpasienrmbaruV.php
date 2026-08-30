<?php

/**
 * This is the model class for table "dokumenpasienrmbaru_v".
 *
 * The followings are the available columns in table 'dokumenpasienrmbaru_v':
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $tempat_lahir
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $no_pendaftaran
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $statuspasien
 */
class DokumenpasienrmbaruV extends CActiveRecord
{
        public $warnadokrm_id;
        public $subrak_id;
        public $lokasirak_id;
        public $tgl_rekam_medik_akhir;
        public $no_rekam_medik_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DokumenpasienrmbaruV the static model class
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
		return 'dokumenpasienrmbaru_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, ruangan_id, pendaftaran_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, ruangan_nama, instalasi_nama, statuspasien', 'length', 'max'=>50),
			array('nama_bin', 'length', 'max'=>30),
			array('jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('tempat_lahir', 'length', 'max'=>25),
			array('no_urutantri', 'length', 'max'=>6),
			array('tgl_rekam_medik, tanggal_lahir, alamat_pasien, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, no_rekam_medik, tgl_rekam_medik, nama_pasien, nama_bin, jeniskelamin, tanggal_lahir, alamat_pasien, tempat_lahir, ruangan_id, ruangan_nama, no_pendaftaran, pendaftaran_id, tgl_pendaftaran, no_urutantri, instalasi_id, instalasi_nama, statuspasien', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medis',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'tempat_lahir' => 'Tempat Lahir',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_urutantri' => 'No. Urutantri',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'statuspasien' => 'Status Pasien',
			'subrak_id'=>'Sub Rak',
			'lokasirak_id'=>'Lokasi Rak',
			'warnadokrm_id'=>'Warna Dokumen',
			'tglrekammedis'=>'Tanggal Rekam Medis',
			'statusrekammedis'=>'Status Rekam Medis',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                     else if ($column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }    
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tgl_pendaftaran===null || trim($this->tgl_pendaftaran)==''){
	        $this->setAttribute('tgl_pendaftaran', null);
            }
            if($this->tgl_rekam_medik===null || trim($this->tgl_rekam_medik)==''){
	        $this->setAttribute('tgl_rekam_medik', null);
            }
            if($this->tanggal_lahir===null || trim($this->tanggal_lahir)==''){
	        $this->setAttribute('tanggal_lahir', null);
            }
            return parent::beforeSave();
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
        
        public function primaryKey()
        {
          return 'pendaftaran_id';
        }
}