<?php

/**
 * This is the model class for table "pegmutasi_r".
 *
 * The followings are the available columns in table 'pegmutasi_r':
 * @property integer $pegmutasi_id
 * @property integer $pegawai_id
 * @property string $nomorsurat
 * @property string $jabatan_nama
 * @property string $pangkat_nama
 * @property string $unitkerja
 * @property string $nosk
 * @property string $tglsk
 * @property string $tmtsk
 * @property string $mengetahui_nama
 * @property string $pimpinan_nama
 * @property string $jabatan_baru
 * @property string $unitkerja_baru
 * @property string $pangkat_baru
 */
class PegmutasiR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegmutasiR the static model class
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
		return 'pegmutasi_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, nomorsurat, jabatan_nama, unitkerja', 'required'),
			array('pegawai_id', 'numerical', 'integerOnly'=>true),
			array('nomorsurat, mengetahui_nama, pimpinan_nama', 'length', 'max'=>100),
			array('jabatan_nama', 'length', 'max'=>50),
			array('pangkat_nama, unitkerja, jabatan_baru, unitkerja_baru, pangkat_baru', 'length', 'max'=>50),
			array('nosk, tglsk, tmtsk, dokumen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegmutasi_id, pegawai_id, nomorsurat, jabatan_nama, pangkat_nama, unitkerja, nosk, tglsk, tmtsk, mengetahui_nama, pimpinan_nama, jabatan_baru, unitkerja_baru, pangkat_baru, jenispromosi_mutasi, lokasikerja_baru, dokumen', 'safe', 'on'=>'search'),
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
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegmutasi_id' => 'ID',
			'pegawai_id' => 'Pegawai',
			'nomorsurat' => 'Nomor surat',
			'jabatan_nama' => 'Jabatan',
			'pangkat_nama' => 'Pangkat',
			'unitkerja' => 'Unit kerja',
			'nosk' => 'No. SK',
			'tglsk' => 'Tanggal SK',
			'tmtsk' => 'TMT SK',
			'mengetahui_nama' => 'Mengetahui',
			'pimpinan_nama' => 'Pimpinan',
			'jabatan_baru' => 'Jabatan Baru',
			'unitkerja_baru' => 'Unit kerja Baru',
			'pangkat_baru' => 'Pangkat Baru',
			'jenispromosi_mutasi'=>'Jenis Promosi',
			'lokasikerja_baru'=>'Lokasi Kerja Baru',
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

		$criteria->compare('pegmutasi_id',$this->pegmutasi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nomorsurat)',strtolower($this->nomorsurat),true);
		$criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);
		$criteria->compare('LOWER(pangkat_nama)',strtolower($this->pangkat_nama),true);
		$criteria->compare('LOWER(unitkerja)',strtolower($this->unitkerja),true);
		$criteria->compare('LOWER(nosk)',strtolower($this->nosk),true);
		$criteria->compare('LOWER(tglsk)',strtolower($this->tglsk),true);
		$criteria->compare('LOWER(tmtsk)',strtolower($this->tmtsk),true);
		$criteria->compare('LOWER(mengetahui_nama)',strtolower($this->mengetahui_nama),true);
		$criteria->compare('LOWER(pimpinan_nama)',strtolower($this->pimpinan_nama),true);
		$criteria->compare('LOWER(jabatan_baru)',strtolower($this->jabatan_baru),true);
		$criteria->compare('LOWER(unitkerja_baru)',strtolower($this->unitkerja_baru),true);
		$criteria->compare('LOWER(pangkat_baru)',strtolower($this->pangkat_baru),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pegmutasi_id',$this->pegmutasi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nomorsurat)',strtolower($this->nomorsurat),true);
		$criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);
		$criteria->compare('LOWER(pangkat_nama)',strtolower($this->pangkat_nama),true);
		$criteria->compare('LOWER(unitkerja)',strtolower($this->unitkerja),true);
		$criteria->compare('LOWER(nosk)',strtolower($this->nosk),true);
		$criteria->compare('LOWER(tglsk)',strtolower($this->tglsk),true);
		$criteria->compare('LOWER(tmtsk)',strtolower($this->tmtsk),true);
		$criteria->compare('LOWER(mengetahui_nama)',strtolower($this->mengetahui_nama),true);
		$criteria->compare('LOWER(pimpinan_nama)',strtolower($this->pimpinan_nama),true);
		$criteria->compare('LOWER(jabatan_baru)',strtolower($this->jabatan_baru),true);
		$criteria->compare('LOWER(unitkerja_baru)',strtolower($this->unitkerja_baru),true);
		$criteria->compare('LOWER(pangkat_baru)',strtolower($this->pangkat_baru),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJabatanItems() {
            return JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama');
        }
        
        public function getPangkatItems() {
            return PangkatM::model()->findAll('pangkat_aktif=TRUE ORDER BY pangkat_nama');
        }
        
        public function getMengetahuiItems() {
            return PegawaiM::model()->findAll('pegawai_aktif=TRUE ORDER BY nama_pegawai');
        }
        
        public function getRuanganItems() {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE ORDER BY ruangan_nama');
        }
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                if (!strlen($this->$columnName)) continue;
                if ($column->dbType == 'date'){
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                }elseif ($column->dbType == 'timestamp without time zone'){
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                            CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                }
            }
            return true;
        }
}