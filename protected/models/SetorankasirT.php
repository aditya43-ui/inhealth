<?php

/**
 * This is the model class for table "setorankasir_t".
 *
 * The followings are the available columns in table 'setorankasir_t':
 * @property integer $setorankasir_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $profilrs_id
 * @property integer $closingkasir_id
 * @property string $nosetorankasir
 * @property string $tglsetorankasir
 * @property double $jmluangsetorankasir
 * @property integer $bendaharapenerima_id
 * @property string $tglditerimabendahara
 * @property string $tglprintsetoran
 * @property integer $jmlprintsetoran
 * @property string $setorankasirdari
 * @property string $sampaidengan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class SetorankasirT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SetorankasirT the static model class
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
		return 'setorankasir_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, ruangan_id, profilrs_id, nosetorankasir, tglsetorankasir, jmluangsetorankasir', 'required'),
			array('pegawai_id, ruangan_id, profilrs_id, closingkasir_id, bendaharapenerima_id, jmlprintsetoran, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmluangsetorankasir', 'numerical'),
			array('nosetorankasir', 'length', 'max'=>50),
			array('tglditerimabendahara, tglprintsetoran, setorankasirdari, sampaidengan, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setorankasir_id, pegawai_id, ruangan_id, profilrs_id, closingkasir_id, nosetorankasir, tglsetorankasir, jmluangsetorankasir, bendaharapenerima_id, tglditerimabendahara, tglprintsetoran, jmlprintsetoran, setorankasirdari, sampaidengan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		
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
			'setorankasir_id' => 'Setorankasir',
			'pegawai_id' => 'Pegawai Setoran',
			'ruangan_id' => 'Ruangan',
			'profilrs_id' => 'Profil RS',
			'closingkasir_id' => 'Closing Kasir',
			'nosetorankasir' => 'No. Setoran',
			'tglsetorankasir' => 'Tgl. Setoran',
			'jmluangsetorankasir' => 'Jumlah Setoran',
			'bendaharapenerima_id' => 'Bendahara Penerima',
			'tglditerimabendahara' => 'Tgl. Menerima',
			'tglprintsetoran' => 'Tgl. Print',
			'jmlprintsetoran' => 'Jml. Print',
			'setorankasirdari' => 'Setoran Dari Tgl.',
			'sampaidengan' => 'Sampai Tgl.',
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

		$criteria->compare('setorankasir_id',$this->setorankasir_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('nosetorankasir',$this->nosetorankasir,true);
		$criteria->compare('tglsetorankasir',$this->tglsetorankasir,true);
		$criteria->compare('jmluangsetorankasir',$this->jmluangsetorankasir);
		$criteria->compare('bendaharapenerima_id',$this->bendaharapenerima_id);
		$criteria->compare('tglditerimabendahara',$this->tglditerimabendahara,true);
		$criteria->compare('tglprintsetoran',$this->tglprintsetoran,true);
		$criteria->compare('jmlprintsetoran',$this->jmlprintsetoran);
		$criteria->compare('setorankasirdari',$this->setorankasirdari,true);
		$criteria->compare('sampaidengan',$this->sampaidengan,true);
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