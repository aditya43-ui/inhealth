<?php

/**
 * This is the model class for table "asesmenpasienigd_t".
 *
 * The followings are the available columns in table 'asesmenpasienigd_t':
 * @property integer $asesmenpasienigd_id
 * @property string $asesmenpasienigd_no
 * @property string $asesmenpasienigd_tgl
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property string $tindakanlanjutan
 * @property integer $pasienpulang_id
 * @property integer $pasiendirujukkeluar_id
 * @property string $evaluasiaskep_subjektif
 * @property string $evaluasiaskep_objektif
 * @property string $evaluasiaskep_assessment
 * @property string $evaluasiaskep_planning
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class AsesmenpasienigdT extends CActiveRecord
{
    public $masalahkep;
    public $tindakankep;
    public $edukasipasien;
    public $masalah;
    public $tindakan;
    public $rujukan;
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmenpasienigdT the static model class
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
		return 'asesmenpasienigd_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenpasienigd_no, pasien_id, pendaftaran_id, pegawai_id, ruangan_id, create_time, create_loginpemakai_id', 'required'),
			array('pasien_id, pendaftaran_id, pegawai_id, ruangan_id, pasienpulang_id, pasiendirujukkeluar_id', 'numerical', 'integerOnly'=>true),
			array('asesmenpasienigd_no', 'length', 'max'=>100),
			array('dipulangkan, dipulangkan_tgl, pasienpulang_id, pasiendirujukkeluar_id, rujukankeluar_id, pasiendirujukkeluar_id, asesmenpasienigd_tgl, tindakanlanjutan, evaluasiaskep_subjektif, evaluasiaskep_objektif, evaluasiaskep_assessment, evaluasiaskep_planning, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dipulangkan, dipulangkan_tgl, pasienpulang_id, pasiendirujukkeluar_id, rujukankeluar_id, pasiendirujukkeluar_id, asesmenpasienigd_id, asesmenpasienigd_no, asesmenpasienigd_tgl, pasien_id, pendaftaran_id, pegawai_id, ruangan_id, tindakanlanjutan, pasienpulang_id, pasiendirujukkeluar_id, evaluasiaskep_subjektif, evaluasiaskep_objektif, evaluasiaskep_assessment, evaluasiaskep_planning, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		
            array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
            array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
            array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
            array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
            array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
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
			'asesmenpasienigd_id' => 'Asesmenpasienigd',
			'asesmenpasienigd_no' => 'Asesmenpasienigd No',
			'asesmenpasienigd_tgl' => 'Asesmenpasienigd Tgl',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'tindakanlanjutan' => 'Tindakanlanjutan',
			'pasienpulang_id' => 'Pasienpulang',
			'pasiendirujukkeluar_id' => 'Pasiendirujukkeluar',
			'evaluasiaskep_subjektif' => 'Evaluasiaskep Subjektif',
			'evaluasiaskep_objektif' => 'Evaluasiaskep Objektif',
			'evaluasiaskep_assessment' => 'Evaluasiaskep Assessment',
			'evaluasiaskep_planning' => 'Evaluasiaskep Planning',
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

		$criteria->compare('asesmenpasienigd_id',$this->asesmenpasienigd_id);
		$criteria->compare('asesmenpasienigd_no',$this->asesmenpasienigd_no,true);
		$criteria->compare('asesmenpasienigd_tgl',$this->asesmenpasienigd_tgl,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tindakanlanjutan',$this->tindakanlanjutan,true);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('pasiendirujukkeluar_id',$this->pasiendirujukkeluar_id);
		$criteria->compare('evaluasiaskep_subjektif',$this->evaluasiaskep_subjektif,true);
		$criteria->compare('evaluasiaskep_objektif',$this->evaluasiaskep_objektif,true);
		$criteria->compare('evaluasiaskep_assessment',$this->evaluasiaskep_assessment,true);
		$criteria->compare('evaluasiaskep_planning',$this->evaluasiaskep_planning,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function findData($daftar_id = null, $id = null) {
        $model = null;
        if (!empty($daftar_id)) {
            $model = self::model()->findByAttributes(array(
                'pendaftaran_id'=>$daftar_id,
            )); 
        }
        
        if (!empty($id) && empty($model)) {
            $model = self::model()->findByPk($id); 
        }
        
        if (empty($model)) return null;
        
        $model->masalah = array();
        $model->tindakan = array();
        
        $masalah = AsesmenmasalahkepT::model()->findAllByAttributes(array(
            'asesmenpasienigd_id'=>$model->asesmenpasienigd_id,
        ));
        
        $tindakan = AsesmentindakankepT::model()->findAllByAttributes(array(
            'asesmenpasienigd_id'=>$model->asesmenpasienigd_id,
        ));
        
        foreach ($masalah as $item) {
            $model->masalah[$item->masalahkeperawatan_id] = $item;
        }
        foreach ($tindakan as $item) {
            $model->tindakan[$item->tindakankeperawatan_id] = $item;
        }
        
        return $model;
    }
}