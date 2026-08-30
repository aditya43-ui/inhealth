<?php

/**
 * This is the model class for table "pasienapachescore_t".
 *
 * The followings are the available columns in table 'pasienapachescore_t':
 * @property integer $pasienapachescore_id
 * @property integer $pasien_id
 * @property integer $apachescore_id
 * @property integer $pasienadmisi_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property string $tglscoring
 * @property boolean $gagalginjalakut
 * @property string $point_nama
 * @property double $point_nilai
 * @property double $point_score
 * @property string $paramedis_id
 * @property string $catatanapachescore
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PasienapachescoreT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienapachescoreT the static model class
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
		return 'pasienapachescore_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, apachescore_id, ruangan_id, pendaftaran_id, tglscoring, point_nama, point_score', 'required'),
			array('pasien_id, apachescore_id, pasienadmisi_id, ruangan_id, pegawai_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('point_nilai, point_score', 'numerical'),
			array('point_nama', 'length', 'max'=>100),
			array('gagalginjalakut, paramedis_id, catatanapachescore, update_time, update_loginpemakai_id', 'safe'),
                        
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'update,insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienapachescore_id, pasien_id, apachescore_id, pasienadmisi_id, ruangan_id, pegawai_id, pendaftaran_id, tglscoring, gagalginjalakut, point_nama, point_nilai, point_score, paramedis_id, catatanapachescore, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'apachescore'=>array(self::BELONGS_TO,'ApachescoreM','apachescore_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienapachescore_id' => 'Pasien Apache Score',
			'pasien_id' => 'Pasien',
			'apachescore_id' => 'Apache Score',
			'pasienadmisi_id' => 'Pasien Admisi',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'pendaftaran_id' => 'Pendaftaran',
			'tglscoring' => 'Tanggal Scoring',
			'gagalginjalakut' => 'Gagal Ginjal Akut',
			'point_nama' => 'Point Nama',
			'point_nilai' => 'Point Nilai',
			'point_score' => 'Point Score',
			'paramedis_id' => 'Paramedis',
			'catatanapachescore' => 'Catatan Apache Score',
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

		$criteria->compare('pasienapachescore_id',$this->pasienapachescore_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('apachescore_id',$this->apachescore_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglscoring)',strtolower($this->tglscoring),true);
		$criteria->compare('gagalginjalakut',$this->gagalginjalakut);
		$criteria->compare('LOWER(point_nama)',strtolower($this->point_nama),true);
		$criteria->compare('point_nilai',$this->point_nilai);
		$criteria->compare('point_score',$this->point_score);
		$criteria->compare('LOWER(paramedis_id)',strtolower($this->paramedis_id),true);
		$criteria->compare('LOWER(catatanapachescore)',strtolower($this->catatanapachescore),true);
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
		$criteria->compare('pasienapachescore_id',$this->pasienapachescore_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('apachescore_id',$this->apachescore_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglscoring)',strtolower($this->tglscoring),true);
		$criteria->compare('gagalginjalakut',$this->gagalginjalakut);
		$criteria->compare('LOWER(point_nama)',strtolower($this->point_nama),true);
		$criteria->compare('point_nilai',$this->point_nilai);
		$criteria->compare('point_score',$this->point_score);
		$criteria->compare('LOWER(paramedis_id)',strtolower($this->paramedis_id),true);
		$criteria->compare('LOWER(catatanapachescore)',strtolower($this->catatanapachescore),true);
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
            if($this->tglscoring===null || trim($this->tglscoring)==''){
	        $this->setAttribute('tglscoring', null);
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