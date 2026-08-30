
<?php

/**
 * This is the model class for table "iurbea_t".
 *
 * The followings are the available columns in table 'iurbea_t':
 * @property integer $iurbea_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property double $inacbg_kelastanggungan
 * @property double $inacbg_kelasperawatan
 * @property double $totalinacbg_naikkelasperawatan
 * @property integer $create_loginpemakai_id
 * @property string $create_time
 * @property boolean $is_bataliurbea
 * @property string $alasanpembatalan
 * @property string $tgl_transaksiiurbiaya
 */
class IurbeaT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iurbea_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inacbg_kelastanggungan, inacbg_kelasperawatan, totalinacbg_naikkelasperawatan, create_loginpemakai_id, create_time', 'required'),
			array('pendaftaran_id, pasien_id, create_loginpemakai_id, pegawai_approvalbatal_id', 'numerical', 'integerOnly'=>true),
			array('inacbg_kelastanggungan, inacbg_kelasperawatan, totalinacbg_naikkelasperawatan, totalbiayarumahsakit, iurbeatujuhpuluhpersen, totalselisihkelastanggunganperawatan', 'numerical'),
			array('is_bataliurbea, alasanpembatalan, tgl_transaksiiurbiaya, is_approvalbatal, tgl_approvalbatal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('iurbea_id, pendaftaran_id, pasien_id, inacbg_kelastanggungan, inacbg_kelasperawatan, totalinacbg_naikkelasperawatan, create_loginpemakai_id, create_time, is_bataliurbea, alasanpembatalan, tgl_transaksiiurbiaya', 'safe', 'on'=>'search'),
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
			'iurbea_id' => 'Iurbea',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'inacbg_kelastanggungan' => 'Inacbg Kelastanggungan',
			'inacbg_kelasperawatan' => 'Inacbg Kelasperawatan',
			'totalinacbg_naikkelasperawatan' => 'Totalinacbg Naikkelasperawatan',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_time' => 'Create Time',
			'is_bataliurbea' => 'Is Bataliurbea',
			'alasanpembatalan' => 'Alasanpembatalan',
			'tgl_transaksiiurbiaya' => 'Tgl Transaksiiurbiaya',
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

		$criteria->compare('iurbea_id',$this->iurbea_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('inacbg_kelastanggungan',$this->inacbg_kelastanggungan);
		$criteria->compare('inacbg_kelasperawatan',$this->inacbg_kelasperawatan);
		$criteria->compare('totalinacbg_naikkelasperawatan',$this->totalinacbg_naikkelasperawatan);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('is_bataliurbea',$this->is_bataliurbea);
		$criteria->compare('alasanpembatalan',$this->alasanpembatalan,true);
		$criteria->compare('tgl_transaksiiurbiaya',$this->tgl_transaksiiurbiaya,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IurbeaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
