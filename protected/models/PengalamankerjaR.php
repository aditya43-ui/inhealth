<?php

/**
 * This is the model class for table "pengalamankerja_r".
 *
 * The followings are the available columns in table 'pengalamankerja_r':
 * @property integer $pengalamankerja_id
 * @property integer $pegawai_id
 * @property integer $pengalamankerja_nourut
 * @property string $namaperusahaan
 * @property string $bidangperusahaan
 * @property string $jabatanterahkir
 * @property string $tglmasuk
 * @property string $tglkeluar
 * @property integer $lama_tahun
 * @property integer $lama_bulan
 * @property string $alasanberhenti
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PengalamankerjaR extends CActiveRecord
{
                public $no;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengalamankerjaR the static model class
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
		return 'pengalamankerja_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengalamankerja_nourut, namaperusahaan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, pengalamankerja_nourut, lama_tahun, lama_bulan, pelamar_id', 'numerical', 'integerOnly'=>true),
			array('namaperusahaan, jabatanterahkir', 'length', 'max'=>50),
			array('bidangperusahaan', 'length', 'max'=>100),
			array('tglmasuk, tglkeluar, alasanberhenti, keterangan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengalamankerja_id, pegawai_id, pengalamankerja_nourut, namaperusahaan, bidangperusahaan, jabatanterahkir, tglmasuk, tglkeluar, lama_tahun, lama_bulan, alasanberhenti, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pengalamankerja_id' => 'Pengalaman Kerja',
			'pegawai_id' => 'Pegawai',
			'pengalamankerja_nourut' => 'No. Urut Pengalaman Kerja',
			'namaperusahaan' => 'Nama Perusahaan',
			'bidangperusahaan' => 'Bidang Perusahaan',
			'jabatanterahkir' => 'Jabatan Terakhir',
			'tglmasuk' => 'Tgl. Masuk',
			'tglkeluar' => 'Tgl. Keluar',
			'lama_tahun' => 'Lama Tahun',
			'lama_bulan' => 'Lama Bulan',
			'alasanberhenti' => 'Alasan Berhenti',
			'keterangan' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('pengalamankerja_id',$this->pengalamankerja_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pengalamankerja_nourut',$this->pengalamankerja_nourut);
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(bidangperusahaan)',strtolower($this->bidangperusahaan),true);
		$criteria->compare('LOWER(jabatanterahkir)',strtolower($this->jabatanterahkir),true);
		$criteria->compare('LOWER(tglmasuk)',strtolower($this->tglmasuk),true);
		$criteria->compare('LOWER(tglkeluar)',strtolower($this->tglkeluar),true);
		$criteria->compare('lama_tahun',$this->lama_tahun);
		$criteria->compare('lama_bulan',$this->lama_bulan);
		$criteria->compare('LOWER(alasanberhenti)',strtolower($this->alasanberhenti),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pengalamankerja_id',$this->pengalamankerja_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pengalamankerja_nourut',$this->pengalamankerja_nourut);
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(bidangperusahaan)',strtolower($this->bidangperusahaan),true);
		$criteria->compare('LOWER(jabatanterahkir)',strtolower($this->jabatanterahkir),true);
		$criteria->compare('LOWER(tglmasuk)',strtolower($this->tglmasuk),true);
		$criteria->compare('LOWER(tglkeluar)',strtolower($this->tglkeluar),true);
		$criteria->compare('lama_tahun',$this->lama_tahun);
		$criteria->compare('lama_bulan',$this->lama_bulan);
		$criteria->compare('LOWER(alasanberhenti)',strtolower($this->alasanberhenti),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
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