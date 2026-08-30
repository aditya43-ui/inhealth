<?php

/**
 * This is the model class for table "notadinasppk_t".
 *
 * The followings are the available columns in table 'notadinasppk_t':
 * @property integer $notadinasppk_id
 * @property integer $suratperjanjiankerja_id
 * @property string $notadinasppk_tanggal
 * @property string $notadinasppk_nomor
 * @property string $nomor_notadinas
 * @property string $kepada
 * @property integer $pegppk_id
 * @property string $pekerjaan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegppk
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 */
class NotadinasppkT extends CActiveRecord
{
        public $pegppk_nama, $tr;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NotadinasppkT the static model class
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
		return 'notadinasppk_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notadinasppk_tanggal, notadinasppk_nomor, kepada, pegppk_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('suratperjanjiankerja_id, pegppk_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('notadinasppk_nomor, nomor_notadinas', 'length', 'max'=>50),
			array('kepada', 'length', 'max'=>300),
			array('pekerjaan', 'length', 'max'=>200),
			array('terminke, termin_persen, total_pembayaran, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('notadinasppk_id, suratperjanjiankerja_id, notadinasppk_tanggal, notadinasppk_nomor, nomor_notadinas, kepada, pegppk_id, pekerjaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegppk' => array(self::BELONGS_TO, 'PegawaiM', 'pegppk_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'notadinasppk_id' => 'Notadinasppk',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'notadinasppk_tanggal' => 'Tanggal Nota Dinas',
			'notadinasppk_nomor' => 'Nomor Transaksi',
			'nomor_notadinas' => 'Nomor Nota Dinas',
			'kepada' => 'Kepada',
			'pegppk_id' => 'Pejabat Pembuat Komitmen',
                        'pegppk_nama' => 'Pejabat Pembuat Komitmen',
			'Pekerjaan' => 'Pekerjaan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('notadinasppk_id',$this->notadinasppk_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('notadinasppk_tanggal',$this->notadinasppk_tanggal,true);
		$criteria->compare('notadinasppk_nomor',$this->notadinasppk_nomor,true);
		$criteria->compare('nomor_notadinas',$this->nomor_notadinas,true);
		$criteria->compare('kepada',$this->kepada,true);
		$criteria->compare('pegppk_id',$this->pegppk_id);
		$criteria->compare('pekerjaan',$this->pekerjaan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}