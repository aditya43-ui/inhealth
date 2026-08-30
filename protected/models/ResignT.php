<?php

/**
 * This is the model class for table "resign_t".
 *
 * The followings are the available columns in table 'resign_t':
 * @property string $resign_id
 * @property string $tglresign
 * @property string $noresign
 * @property string $alasanresign
 * @property string $pegawai_id
 * @property string $jabatan_id
 * @property string $untikerja_id
 * @property string $tglditerima
 * @property string $lamakerja
 * @property string $lampiran_surat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemekai
 * @property string $create_ruangan
 */
class ResignT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResignT the static model class
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
		return 'resign_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglresign, noresign, pegawai_id, tglditerima, lamakerja, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('noresign, lamakerja', 'length', 'max'=>50),
			array('alasanresign, lampiran_surat', 'length', 'max'=>255),
			array('update_time, update_loginpemekai', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resign_id, tglresign, noresign, alasanresign, pegawai_id, jabatan_id, untikerja_id, tglditerima, lamakerja, lampiran_surat, create_time, update_time, create_loginpemakai, update_loginpemekai, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pegawaiRl' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resign_id' => 'Resign',
			'tglresign' => 'Tanggal Resign',
			'noresign' => 'No Surat',
			'alasanresign' => 'Alasan Resign',
			'pegawai_id' => 'Pegawai',
			'jabatan_id' => 'Jabatan',
			'untikerja_id' => 'Unit Kerja',
			'tglditerima' => 'Tanggal Diterima',
			'lamakerja' => 'Lama Kerja',
			'lampiran_surat' => 'Lampiran Surat',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemekai' => 'Update Loginpemekai',
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

		$criteria->compare('resign_id',$this->resign_id,true);
		$criteria->compare('tglresign',$this->tglresign,true);
		$criteria->compare('noresign',$this->noresign,true);
		$criteria->compare('alasanresign',$this->alasanresign,true);
		$criteria->compare('pegawai_id',$this->pegawai_id,true);
		$criteria->compare('jabatan_id',$this->jabatan_id,true);
		$criteria->compare('untikerja_id',$this->untikerja_id,true);
		$criteria->compare('tglditerima',$this->tglditerima,true);
		$criteria->compare('lamakerja',$this->lamakerja,true);
		$criteria->compare('lampiran_surat',$this->lampiran_surat,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemekai',$this->update_loginpemekai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
		
		public function getUnitKerjaItems() {
            return UnitkerjaM::model()->findAll('unitkerja_aktif=TRUE ORDER BY namaunitkerja');
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