<?php

/**
 * This is the model class for table "pengangkatantphl_t".
 *
 * The followings are the available columns in table 'pengangkatantphl_t':
 * @property integer $pengangkatantphl_id
 * @property integer $pegawai_id
 * @property string $pengangkatantphl_noperjanjian
 * @property string $pengangkatantphl_tmt
 * @property string $pengangkatantphl_tugaspekerjaan
 * @property string $pengangkatantphl_nosk
 * @property string $pengangkatantphl_tglsk
 * @property string $pengangkatantphl_tmtsk
 * @property string $pengangkatantphl_noskterakhir
 * @property string $pengangkatantphl_keterangan
 * @property string $pimpinannama
 */
class PengangkatantphlT extends CActiveRecord
{
	public $nomorindukpegawai , $gelardepan, $nama_pegawai, $nama_keluarga, $tempatlahir_pegawai;
        public $jeniskelamin, $statusperkawinan, $alamat_pegawai, $agama;
        public $tgl_awal;
        public $tgl_akhir;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengangkatantphlT the static model class
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
		return 'pengangkatantphl_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengangkatantphl_noperjanjian, pengangkatantphl_tmt, pengangkatantphl_tugaspekerjaan, pengangkatantphl_nosk, pengangkatantphl_tglsk, pengangkatantphl_tmtsk', 'required'),
			array('pegawai_id', 'numerical', 'integerOnly'=>true),
			array('pengangkatantphl_noperjanjian, pengangkatantphl_nosk, pengangkatantphl_noskterakhir, pengangkatantphl_keterangan', 'length', 'max'=>50),
			array('pimpinannama, nomorindukpegawai, tgl_awal, tgl_akhir, gelardepan, nama_pegawai, nama_keluarga, tempatlahir_pegawai, jeniskelamin, statusperkawinan, alamat_pegawai, agama', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengangkatantphl_id, tgl_awal,tgl_akhir,nomorindukpegawai, gelardepan, nama_pegawai, nama_keluarga, tempatlahir_pegawai, jeniskelamin, statusperkawinan, alamat_pegawai, agama, pegawai_id, pengangkatantphl_noperjanjian, pengangkatantphl_tmt, pengangkatantphl_tugaspekerjaan, pengangkatantphl_nosk, pengangkatantphl_tglsk, pengangkatantphl_tmtsk, pengangkatantphl_noskterakhir, pengangkatantphl_keterangan, pimpinannama', 'safe', 'on'=>'search'),
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
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengangkatantphl_id' => 'Pengangkatan TPHL',
			'pegawai_id' => 'Pegawai',
			'pengangkatantphl_noperjanjian' => 'No. Perjanjian',
			'pengangkatantphl_tmt' => 'TMT',
			'pengangkatantphl_tugaspekerjaan' => 'Tugas Pekerjaan',
			'pengangkatantphl_nosk' => 'No. SK',
			'pengangkatantphl_tglsk' => 'Tanggal SK',
			'pengangkatantphl_tmtsk' => 'TMT SK',
			'pengangkatantphl_noskterakhir' => 'No. SK Terakhir',
			'pengangkatantphl_keterangan' => 'Keterangan',
			'pimpinannama' => 'Pimpinan Nama',
                        'pengangkatantphl_tmtAkhir'=>'Sampai Dengan',
                        'nomorindukpegawai'=>'NIP',
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
                
              
		$criteria->compare('pengangkatantphl_id',$this->pengangkatantphl_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(pengangkatantphl_noperjanjian)',strtolower($this->pengangkatantphl_noperjanjian),true);
		$criteria->addBetweenCondition('DATE(pengangkatantphl_tmt)',$this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(pengangkatantphl_tugaspekerjaan)',strtolower($this->pengangkatantphl_tugaspekerjaan),true);
		$criteria->compare('LOWER(pengangkatantphl_nosk)',strtolower($this->pengangkatantphl_nosk),true);
		$criteria->compare('DATE(pengangkatantphl_tglsk)',$this->pengangkatantphl_tglsk,true);
		$criteria->compare('DATE(pengangkatantphl_tmtsk)',$this->pengangkatantphl_tmtsk,true);
		$criteria->compare('LOWER(pengangkatantphl_noskterakhir)',strtolower($this->pengangkatantphl_noskterakhir),true);
		$criteria->compare('LOWER(pengangkatantphl_keterangan)',strtolower($this->pengangkatantphl_keterangan),true);
		$criteria->compare('LOWER(pimpinannama)',strtolower($this->pimpinannama),true);
		$criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(pegawai.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(pegawai.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(pegawai.nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(pegawai.jeniskelamin)', strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(pegawai.agama)', strtolower($this->agama),true);
		$criteria->compare('LOWER(pegawai.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(pegawai.statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->with = array('pegawai');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
              
		$criteria->compare('pengangkatantphl_id',$this->pengangkatantphl_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(pengangkatantphl_noperjanjian)',strtolower($this->pengangkatantphl_noperjanjian),true);
		$criteria->addBetweenCondition('DATE(pengangkatantphl_tmt)',$this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(pengangkatantphl_tugaspekerjaan)',strtolower($this->pengangkatantphl_tugaspekerjaan),true);
		$criteria->compare('LOWER(pengangkatantphl_nosk)',strtolower($this->pengangkatantphl_nosk),true);
		$criteria->compare('DATE(pengangkatantphl_tglsk)',$this->pengangkatantphl_tglsk,true);
		$criteria->compare('DATE(pengangkatantphl_tmtsk)',$this->pengangkatantphl_tmtsk,true);
		$criteria->compare('LOWER(pengangkatantphl_noskterakhir)',strtolower($this->pengangkatantphl_noskterakhir),true);
		$criteria->compare('LOWER(pengangkatantphl_keterangan)',strtolower($this->pengangkatantphl_keterangan),true);
		$criteria->compare('LOWER(pimpinannama)',strtolower($this->pimpinannama),true);
		$criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(pegawai.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(pegawai.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(pegawai.nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(pegawai.jeniskelamin)', strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(pegawai.agama)', strtolower($this->agama),true);
		$criteria->compare('LOWER(pegawai.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(pegawai.statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->with = array('pegawai');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        
	public function searchPrint()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('pengangkatantphl_id',$this->pengangkatantphl_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(pengangkatantphl_noperjanjian)',strtolower($this->pengangkatantphl_noperjanjian),true);
		$criteria->compare('LOWER(pengangkatantphl_tmt)',strtolower($this->pengangkatantphl_tmt),true);
		$criteria->compare('LOWER(pengangkatantphl_tugaspekerjaan)',strtolower($this->pengangkatantphl_tugaspekerjaan),true);
		$criteria->compare('LOWER(pengangkatantphl_nosk)',strtolower($this->pengangkatantphl_nosk),true);
		$criteria->compare('LOWER(pengangkatantphl_tglsk)',strtolower($this->pengangkatantphl_tglsk),true);
		$criteria->compare('LOWER(pengangkatantphl_tmtsk)',strtolower($this->pengangkatantphl_tmtsk),true);
		$criteria->compare('LOWER(pengangkatantphl_noskterakhir)',strtolower($this->pengangkatantphl_noskterakhir),true);
		$criteria->compare('LOWER(pengangkatantphl_keterangan)',strtolower($this->pengangkatantphl_keterangan),true);
		$criteria->compare('LOWER(pimpinannama)',strtolower($this->pimpinannama),true);
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
				else if ( $column->dbType == 'timestamp without time zone')
					{
						$this->$columnName = $format->formatDateTimeForDb($this->$columnName);
					}
		}

		return parent::beforeValidate ();
	}

	public function beforeSave() {         
		if($this->pengangkatantphl_tglsk===null || trim($this->pengangkatantphl_tglsk)==''){
		$this->setAttribute('pengangkatantphl_tglsk', null);
		}
		if($this->pengangkatantphl_tmt===null || trim($this->pengangkatantphl_tmt)==''){
		$this->setAttribute('pengangkatantphl_tmt', null);
		}
		if($this->pengangkatantphl_tmtsk===null || trim($this->pengangkatantphl_tmtsk)==''){
		$this->setAttribute('pengangkatantphl_tmtsk', null);
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
}