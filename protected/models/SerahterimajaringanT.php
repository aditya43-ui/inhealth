<?php

/**
 * This is the model class for table "serahterimajaringan_t".
 *
 * The followings are the available columns in table 'serahterimajaringan_t':
 * @property integer $serahterimajaringan_id
 * @property integer $petugas_id
 * @property integer $jabatan
 * @property string $nama_kepenanggungjawab
 * @property string $alamat
 * @property string $namapasien
 * @property string $nomor_rm
 * @property string $diagnosa
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property string $pihakpenerima
 * @property string $pihakmenyerahkan
 */
class SerahterimajaringanT extends CActiveRecord
{
        public $petugas_nama, $jabatan_nama;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'serahterimajaringan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_kepenanggungjawab, namapasien, create_time, create_loginpemakai_id, pihakpenerima, pihakmenyerahkan', 'required'),
			array('petugas_id, jabatan, create_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('nama_kepenanggungjawab, pihakpenerima, pihakmenyerahkan', 'length', 'max'=>50),
			array('namapasien, diagnosa', 'length', 'max'=>100),
			array('nomor_rm', 'length', 'max'=>12),
			array('pendaftaran_id, pasienmasukpenunjang_id, alamat, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('serahterimajaringan_id, petugas_id, jabatan, nama_kepenanggungjawab, alamat, namapasien, nomor_rm, diagnosa, create_time, update_time, create_loginpemakai_id, pihakpenerima, pihakmenyerahkan', 'safe', 'on'=>'search'),
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
			'serahterimajaringan_id' => 'Serahterimajaringan',
			'petugas_id' => 'Petugas',
			'jabatan' => 'Jabatan',
			'nama_kepenanggungjawab' => 'Nama Kepenanggungjawab',
			'alamat' => 'Alamat',
			'namapasien' => 'Namapasien',
			'nomor_rm' => 'Nomor Rm',
			'diagnosa' => 'Diagnosa',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'pihakpenerima' => 'Pihakpenerima',
			'pihakmenyerahkan' => 'Pihakmenyerahkan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('serahterimajaringan_id',$this->serahterimajaringan_id);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('jabatan',$this->jabatan);
		$criteria->compare('nama_kepenanggungjawab',$this->nama_kepenanggungjawab,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('namapasien',$this->namapasien,true);
		$criteria->compare('nomor_rm',$this->nomor_rm,true);
		$criteria->compare('diagnosa',$this->diagnosa,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('pihakpenerima',$this->pihakpenerima,true);
		$criteria->compare('pihakmenyerahkan',$this->pihakmenyerahkan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SerahterimajaringanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function simpanData($model, $post){
            
            $pesan = '';
            $ok = true;
            
            $model->attributes = $post;
            
            if (empty($model->serahterimajaringan_id)){
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            }else{
                $model->update_time = date('Y-m-d H:i:s');
            }
            
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= 'Data surat akad ijarah gagal disimpan '.MyExceptionMessage::getErrorMessage($model);
            }
                     
            return [
                'model'=>$model,
                'pesan'=>$pesan,
                'sukses'=>$ok
            ];   
        }
        
        public function loadInput(){
            
        }
}
