<?php

/**
 * This is the model class for table "pegawaidiklat_t".
 *
 * The followings are the available columns in table 'pegawaidiklat_t':
 * @property integer $pegawaidiklat_id
 * @property integer $jenisdiklat_id
 * @property integer $pegawai_id
 * @property string $pegawaidiklat_nama
 * @property string $pegawaidiklat_namalainnya
 * @property string $pegawaidiklat_lamanya
 * @property string $pegawaidiklat_tahun
 * @property string $pegawaidiklat_tempat
 * @property string $nomorkeputusandiklat
 * @property string $tglditetapkandiklat
 * @property string $pejabatygmemdiklat
 * @property string $pegawaidiklat_keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PegawaidiklatT extends CActiveRecord
{
        public $no;
        public $pegawaidiklat_lamanyasatuan;
        public $nama_pegawai;
        public $jenisdiklat_nama;        
        public $nomorindukpegawai;
        public $ceklis;
        public $biaya_pelatihan;
        public $biaya_transportasi;        
        public $biaya_penginapan;
        public $biaya_perjalanandinas;
        public $biaya_lainlain;
        public $keterangan_lainlain;
        public $total;
        public $jabatan_id;
        public $jabatan_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaidiklatT the static model class
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
		return 'pegawaidiklat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiklat_id, pegawai_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jenisdiklat_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('pegawaidiklat_nama, pegawaidiklat_namalainnya, nomorkeputusandiklat, pejabatygmemdiklat, pegawaidiklat_keterangan', 'length', 'max'=>50),
			array('pegawaidiklat_lamanya', 'length', 'max'=>10),
                        array('pegawaidiklat_tempat', 'length', 'max'=>30),
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
			array('biaya_lainlain, total, keterangan_lainlain, biaya_perjalanandinas, biaya_penginapan, biaya_transportasi, biaya_pelatihan, realisasidiklat_id, jabatan_id, pegawaidiklat_tahun, tglditetapkandiklat, update_time, update_loginpemakai_id, sertifikat, masaberlakusertifikat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('biaya_lainlain, pegawaidiklat_id, jenisdiklat_id, pegawai_id, pegawaidiklat_nama, pegawaidiklat_namalainnya, pegawaidiklat_lamanya, pegawaidiklat_tahun, pegawaidiklat_tempat, nomorkeputusandiklat, tglditetapkandiklat, pejabatygmemdiklat, pegawaidiklat_keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, sertifikat, masaberlakusertifikat', 'safe', 'on'=>'search'),
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
			'jenisdiklat'=>array(self::BELONGS_TO,'JenisdiklatM','jenisdiklat_id'),
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
			'rencanadiklat'=>array(self::BELONGS_TO,'RencanadiklatT','rencanadiklat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegawaidiklat_id' => 'Pegawai Diklat',
			'jenisdiklat_id' => 'Jenis Diklat',
			'pegawai_id' => 'Pegawai',
			'pegawaidiklat_nama' => 'Nama Pegawai Diklat',
			'pegawaidiklat_namalainnya' => 'Nama Lainnya',
			'pegawaidiklat_lamanya' => 'Lama Pegawai Diklat',
			'pegawaidiklat_tahun' => 'Tahun Pegawai Diklat',
			'pegawaidiklat_tempat' => 'Tempat Pegawai Diklat',
			'nomorkeputusandiklat' => 'No. Keputusan Diklat',
			'tglditetapkandiklat' => 'Tgl. Ditetapkan Diklat',
			'pejabatygmemdiklat' => 'Pejabat Yang Mendiklat',
			'pegawaidiklat_keterangan' => 'Keterangan',
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

		$criteria->compare('pegawaidiklat_id',$this->pegawaidiklat_id);
		$criteria->compare('jenisdiklat_id',$this->jenisdiklat_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(pegawaidiklat_nama)',strtolower($this->pegawaidiklat_nama),true);
		$criteria->compare('LOWER(pegawaidiklat_namalainnya)',strtolower($this->pegawaidiklat_namalainnya),true);
		$criteria->compare('LOWER(pegawaidiklat_lamanya)',strtolower($this->pegawaidiklat_lamanya),true);
		$criteria->compare('LOWER(pegawaidiklat_tahun)',strtolower($this->pegawaidiklat_tahun),true);
		$criteria->compare('LOWER(pegawaidiklat_tempat)',strtolower($this->pegawaidiklat_tempat),true);
		$criteria->compare('LOWER(nomorkeputusandiklat)',strtolower($this->nomorkeputusandiklat),true);
		$criteria->compare('LOWER(tglditetapkandiklat)',strtolower($this->tglditetapkandiklat),true);
		$criteria->compare('LOWER(pejabatygmemdiklat)',strtolower($this->pejabatygmemdiklat),true);
		$criteria->compare('LOWER(pegawaidiklat_keterangan)',strtolower($this->pegawaidiklat_keterangan),true);
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
		$criteria->compare('pegawaidiklat_id',$this->pegawaidiklat_id);
		$criteria->compare('jenisdiklat_id',$this->jenisdiklat_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(pegawaidiklat_nama)',strtolower($this->pegawaidiklat_nama),true);
		$criteria->compare('LOWER(pegawaidiklat_namalainnya)',strtolower($this->pegawaidiklat_namalainnya),true);
		$criteria->compare('LOWER(pegawaidiklat_lamanya)',strtolower($this->pegawaidiklat_lamanya),true);
		$criteria->compare('LOWER(pegawaidiklat_tahun)',strtolower($this->pegawaidiklat_tahun),true);
		$criteria->compare('LOWER(pegawaidiklat_tempat)',strtolower($this->pegawaidiklat_tempat),true);
		$criteria->compare('LOWER(nomorkeputusandiklat)',strtolower($this->nomorkeputusandiklat),true);
		$criteria->compare('LOWER(tglditetapkandiklat)',strtolower($this->tglditetapkandiklat),true);
		$criteria->compare('LOWER(pejabatygmemdiklat)',strtolower($this->pejabatygmemdiklat),true);
		$criteria->compare('LOWER(pegawaidiklat_keterangan)',strtolower($this->pegawaidiklat_keterangan),true);
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
        
        public function getJenisdiklatItems() {
            return JenisdiklatM::model()->findAll('jenisdiklat_aktif=TRUE ORDER BY jenisdiklat_nama');
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