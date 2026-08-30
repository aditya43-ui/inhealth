<?php

/**
 * This is the model class for table "periksakehamilan_t".
 *
 * The followings are the available columns in table 'periksakehamilan_t':
 * @property integer $periksakehamilan_id
 * @property integer $ruangan_id
 * @property integer $pasienimunisasi_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property string $tglpemeriksaaan
 * @property string $tglkehamilan
 * @property string $masagestasike
 * @property string $tglakhirmenstruasi
 * @property string $tglperkiraankelahiran
 * @property string $gravida
 * @property integer $jmlpartusimaturus
 * @property integer $jmlpartusmaturus
 * @property integer $jmlpartuspostmaturus
 * @property integer $jmlabortus
 * @property string $keadaanibuhamil
 * @property string $keadaanjanin
 * @property string $posisijanin
 * @property double $bb_gram
 * @property double $tb_cm
 * @property string $catatankehamilan
 * @property string $bidan_id
 * @property string $filefotousg
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PeriksakehamilanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriksakehamilanT the static model class
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
		return 'periksakehamilan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, tglpemeriksaaan, tglkehamilan, masagestasike, tglakhirmenstruasi', 'required'),
			array('ruangan_id, pasienimunisasi_id, pasien_id, pegawai_id, pendaftaran_id, jmlpartusimaturus, jmlpartusmaturus, jmlpartuspostmaturus, jmlabortus', 'numerical', 'integerOnly'=>true),
			array('bb_gram, tb_cm_', 'numerical'),
			array('masagestasike', 'length', 'max'=>20),
			array('gravida', 'length', 'max'=>100),
			array('posisijanin', 'length', 'max'=>50),
			array('filefotousg', 'length', 'max'=>200),
			array('tglperkiraankelahiran, keadaanibuhamil, keadaanjanin, catatankehamilan, bidan_id, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('periksakehamilan_id, ruangan_id, pasienimunisasi_id, pasien_id, pegawai_id, pendaftaran_id, tglpemeriksaaan, tglkehamilan, masagestasike, tglakhirmenstruasi, tglperkiraankelahiran, gravida, jmlpartusimaturus, jmlpartusmaturus, jmlpartuspostmaturus, jmlabortus, keadaanibuhamil, keadaanjanin, posisijanin, bb_gram, tb_cm_, catatankehamilan, bidan_id, filefotousg, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                   'bidan'=>array(self::BELONGS_TO,'PegawaiM','bidan_id'),
                   'dokter'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
                   'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'periksakehamilan_id' => 'Id',
			'ruangan_id' => 'Ruangan',
			'pasienimunisasi_id' => 'Pasien Imunisasi',
			'pasien_id' => 'Pasien',
			'pegawai_id' => 'Dokter',
			'pendaftaran_id' => 'No. Pendaftaran',
			'tglpemeriksaaan' => 'Tanggal Pemeriksaaan',
			'tglkehamilan' => 'Tanggal Kehamilan',
			'masagestasike' => 'Masa Gestasi Ke',
			'tglakhirmenstruasi' => 'Tanggal Akhir Menstruasi',
			'tglperkiraankelahiran' => 'Tanggal Perkiraan Kelahiran',
			'gravida' => 'Gravida',
			'jmlpartusimaturus' => 'Jumlah Partusimaturus',
			'jmlpartusmaturus' => 'Jumlah Partusmaturus',
			'jmlpartuspostmaturus' => 'Jumlah Partuspostmaturus',
			'jmlabortus' => 'Jumlah Abortus',
			'keadaanibuhamil' => 'Keadaan Ibu Hamil',
			'keadaanjanin' => 'Keadaan Janin',
			'posisijanin' => 'Posisi Janin',
			'bb_gram' => 'Berat Badan',
			'tb_cm_' => 'Tinggi Badan',
			'catatankehamilan' => 'Catatan Kehamilan',
			'bidan_id' => 'Bidan',
			'filefotousg' => 'File Foto USG',
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

		$criteria->compare('periksakehamilan_id',$this->periksakehamilan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienimunisasi_id',$this->pasienimunisasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpemeriksaaan)',strtolower($this->tglpemeriksaaan),true);
		$criteria->compare('LOWER(tglkehamilan)',strtolower($this->tglkehamilan),true);
		$criteria->compare('LOWER(masagestasike)',strtolower($this->masagestasike),true);
		$criteria->compare('LOWER(tglakhirmenstruasi)',strtolower($this->tglakhirmenstruasi),true);
		$criteria->compare('LOWER(tglperkiraankelahiran)',strtolower($this->tglperkiraankelahiran),true);
		$criteria->compare('LOWER(gravida)',strtolower($this->gravida),true);
		$criteria->compare('jmlpartusimaturus',$this->jmlpartusimaturus);
		$criteria->compare('jmlpartusmaturus',$this->jmlpartusmaturus);
		$criteria->compare('jmlpartuspostmaturus',$this->jmlpartuspostmaturus);
		$criteria->compare('jmlabortus',$this->jmlabortus);
		$criteria->compare('LOWER(keadaanibuhamil)',strtolower($this->keadaanibuhamil),true);
		$criteria->compare('LOWER(keadaanjanin)',strtolower($this->keadaanjanin),true);
		$criteria->compare('LOWER(posisijanin)',strtolower($this->posisijanin),true);
		$criteria->compare('bb_gram',$this->bb_gram);
		$criteria->compare('tb_cm_',$this->tb_cm);
		$criteria->compare('LOWER(catatankehamilan)',strtolower($this->catatankehamilan),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(filefotousg)',strtolower($this->filefotousg),true);
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
		$criteria->compare('periksakehamilan_id',$this->periksakehamilan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienimunisasi_id',$this->pasienimunisasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpemeriksaaan)',strtolower($this->tglpemeriksaaan),true);
		$criteria->compare('LOWER(tglkehamilan)',strtolower($this->tglkehamilan),true);
		$criteria->compare('LOWER(masagestasike)',strtolower($this->masagestasike),true);
		$criteria->compare('LOWER(tglakhirmenstruasi)',strtolower($this->tglakhirmenstruasi),true);
		$criteria->compare('LOWER(tglperkiraankelahiran)',strtolower($this->tglperkiraankelahiran),true);
		$criteria->compare('LOWER(gravida)',strtolower($this->gravida),true);
		$criteria->compare('jmlpartusimaturus',$this->jmlpartusimaturus);
		$criteria->compare('jmlpartusmaturus',$this->jmlpartusmaturus);
		$criteria->compare('jmlpartuspostmaturus',$this->jmlpartuspostmaturus);
		$criteria->compare('jmlabortus',$this->jmlabortus);
		$criteria->compare('LOWER(keadaanibuhamil)',strtolower($this->keadaanibuhamil),true);
		$criteria->compare('LOWER(keadaanjanin)',strtolower($this->keadaanjanin),true);
		$criteria->compare('LOWER(posisijanin)',strtolower($this->posisijanin),true);
		$criteria->compare('bb_gram',$this->bb_gram);
		$criteria->compare('tb_cm_',$this->tb_cm);
		$criteria->compare('LOWER(catatankehamilan)',strtolower($this->catatankehamilan),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(filefotousg)',strtolower($this->filefotousg),true);
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
        
        public function beforeSave() {         
            if($this->tglperkiraankelahiran===null || trim($this->tglperkiraankelahiran)==''){
	        $this->setAttribute('tglperkiraankelahiran', null);
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
        
        public function getBidanItems()
        {
            return ParamedisV::model()->findAll('ruangan_id='.Yii::app()->user->getState('ruangan_id').' ORDER BY nama_pegawai');
        }
        
        public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==true){
				if(empty($ruangan_id))
					$ruangan_id = Yii::app()->user->getState('ruangan_id');
                if(!empty($ruangan_id))
                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
                else
                    return array();
            }else{
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("pegawai_aktif = TRUE");
				$criteria->order = 'nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
            }
        }
        
        public function getTglPeriksaNoPendaftaran() {                         
            return $this->tglpemeriksaaan.PHP_EOL.'<br/>'.$this->pendaftaran->no_pendaftaran;
        }
}