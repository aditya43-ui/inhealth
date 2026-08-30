<?php

/**
 * This is the model class for table "personalscoring_t".
 *
 * The followings are the available columns in table 'personalscoring_t':
 * @property integer $personalscoring_id
 * @property integer $pegawai_id
 * @property integer $penilaianpegawai_id
 * @property string $tglscoring
 * @property string $periodescoring
 * @property string $sampaidengan
 * @property double $gajipokok
 * @property string $jabatan
 * @property string $pendidikan
 * @property integer $totalscore
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PersonalscoringT extends CActiveRecord
{
                public $nama_pegawai;
                public $periodescoringawal;
                public $periodescoringakhir;
                public $sampaidenganawal;
                public $sampaidenganakhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersonalscoringT the static model class
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
		return 'personalscoring_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, tglscoring, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, penilaianpegawai_id', 'numerical', 'integerOnly'=>true),
			array('gajipokok, totalscore', 'numerical'),
			array('jabatan, pendidikan', 'length', 'max'=>100),
			array('periodescoring, sampaidengan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('personalscoring_id, nama_pegawai,pegawai_id, penilaianpegawai_id, tglscoring, periodescoring, sampaidengan, gajipokok, jabatan, pendidikan, totalscore, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                                    'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
                                    'jbtn'=>array(self::BELONGS_TO,'JabatanM','jabatan'),
                                    'pnddkn'=>array(self::BELONGS_TO,'PendidikanM','pendidikan'),
                                    'loginpemakai'=>array(self::BELONGS_TO,'LoginpemakaiK','create_loginpemakai_id'),
                                    'ruangan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'personalscoring_id' => 'Personal scoring',
			'pegawai_id' => 'Pegawai',
			'penilaianpegawai_id' => 'Penilaian pegawai',
			'tglscoring' => 'Tanggal scoring',
			'periodescoring' => 'Periode scoring',
			'sampaidengan' => 'Sampai dengan',
			'gajipokok' => 'Gajipokok',
			'jabatan' => 'Jabatan',
			'pendidikan' => 'Pendidikan',
			'totalscore' => 'Totalscore',
			'create_time' => 'Tanggal pembuatan',
			'update_time' => 'Tanggal perubahan',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Ruangan',
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

		$criteria->compare('personalscoring_id',$this->personalscoring_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('penilaianpegawai_id',$this->penilaianpegawai_id);
		$criteria->compare('LOWER(tglscoring)',strtolower($this->tglscoring),true);
		$criteria->compare('LOWER(periodescoring)',strtolower($this->periodescoring),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('gajipokok',$this->gajipokok);
		$criteria->compare('LOWER(jabatan)',strtolower($this->jabatan),true);
		$criteria->compare('LOWER(pendidikan)',strtolower($this->pendidikan),true);
		$criteria->compare('totalscore',$this->totalscore);
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
		$criteria->compare('personalscoring_id',$this->personalscoring_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('penilaianpegawai_id',$this->penilaianpegawai_id);
		$criteria->compare('LOWER(tglscoring)',strtolower($this->tglscoring),true);
		$criteria->compare('LOWER(periodescoring)',strtolower($this->periodescoring),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('gajipokok',$this->gajipokok);
		$criteria->compare('LOWER(jabatan)',strtolower($this->jabatan),true);
		$criteria->compare('LOWER(pendidikan)',strtolower($this->pendidikan),true);
		$criteria->compare('totalscore',$this->totalscore);
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
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tglscoring',$this->tglscoring);
		$criteria->addBetweenCondition('periodescoring',$this->periodescoring,$this->sampaidengan);
		$criteria->addBetweenCondition('sampaidengan',$this->periodescoring,$this->sampaidengan);
		$criteria->compare('jabatan',$this->jabatan);
		$criteria->compare('pendidikan',$this->pendidikan);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getJabatanItems() {
            return JabatanM::model()->findAll('jabatan_aktif=TRUE ORDER BY Jabatan_nama asc');
        }
        
        public function getPendidikanItems() {
            return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY pendidikan_nama asc');
        }
}