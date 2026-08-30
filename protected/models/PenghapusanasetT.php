<?php

/**
 * This is the model class for table "penghapusanaset_t".
 *
 * The followings are the available columns in table 'penghapusanaset_t':
 * @property integer $penghapusanaset_id
 * @property string $tglpenghapusan
 * @property string $nopenghapusan
 * @property string $no_sk_penghapusan
 * @property string $tgl_sk_penghapusan
 * @property string $carapenghapusan
 * @property integer $pegpenghapusan_id
 * @property integer $pegmengetahui_id
 * @property integer $pegmenyetujui_id
 * @property string $ket_penghapusan
 * @property integer $ruanganpenghapusan_id
 * @property string $create_time
 * @property string $udpate_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenghapusanasetT extends CActiveRecord
{
        public $pegmengetahui_nama;
        public $pegmenyetujui_nama;
        public $issambada;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenghapusanasetT the static model class
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
		return 'penghapusanaset_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpenghapusan, nopenghapusan, no_sk_penghapusan, tgl_sk_penghapusan, carapenghapusan, pegpenghapusan_id, pegmengetahui_id, ruanganpenghapusan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegpenghapusan_id, pegmengetahui_id, pegmenyetujui_id, ruanganpenghapusan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopenghapusan', 'length', 'max'=>100),
			array('no_sk_penghapusan, carapenghapusan', 'length', 'max'=>50),
			array('issambada, ket_penghapusan, udpate_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penghapusanaset_id, tglpenghapusan, nopenghapusan, no_sk_penghapusan, tgl_sk_penghapusan, carapenghapusan, pegpenghapusan_id, pegmengetahui_id, pegmenyetujui_id, ket_penghapusan, ruanganpenghapusan_id, create_time, udpate_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pegPenghapus' => array(self::BELONGS_TO,'PegawaiM','pegpenghapusan_id'),
                    'pegMengetahui' => array(self::BELONGS_TO,'PegawaiM','pegmengetahui_id'),
                    'pegMenyetujui' => array(self::BELONGS_TO,'PegawaiM','pegmenyetujui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penghapusanaset_id' => 'Penghapusanaset',
			'tglpenghapusan' => 'Tglpenghapusan',
			'nopenghapusan' => 'Nopenghapusan',
			'no_sk_penghapusan' => 'No Sk Penghapusan',
			'tgl_sk_penghapusan' => 'Tgl Sk Penghapusan',
			'carapenghapusan' => 'Carapenghapusan',
			'pegpenghapusan_id' => 'Pegpenghapusan',
			'pegmengetahui_id' => 'Pegmengetahui',
			'pegmenyetujui_id' => 'Pegmenyetujui',
			'ket_penghapusan' => 'Ket Penghapusan',
			'ruanganpenghapusan_id' => 'Ruanganpenghapusan',
			'create_time' => 'Create Time',
			'udpate_time' => 'Udpate Time',
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

		$criteria->compare('penghapusanaset_id',$this->penghapusanaset_id);
		$criteria->compare('tglpenghapusan',$this->tglpenghapusan,true);
		$criteria->compare('nopenghapusan',$this->nopenghapusan,true);
		$criteria->compare('no_sk_penghapusan',$this->no_sk_penghapusan,true);
		$criteria->compare('tgl_sk_penghapusan',$this->tgl_sk_penghapusan,true);
		$criteria->compare('carapenghapusan',$this->carapenghapusan,true);
		$criteria->compare('pegpenghapusan_id',$this->pegpenghapusan_id);
		$criteria->compare('pegmengetahui_id',$this->pegmengetahui_id);
		$criteria->compare('pegmenyetujui_id',$this->pegmenyetujui_id);
		$criteria->compare('ket_penghapusan',$this->ket_penghapusan,true);
		$criteria->compare('ruanganpenghapusan_id',$this->ruanganpenghapusan_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('udpate_time',$this->udpate_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}