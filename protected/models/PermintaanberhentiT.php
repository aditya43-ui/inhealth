<?php

/**
 * This is the model class for table "permintaanberhenti_t".
 *
 * The followings are the available columns in table 'permintaanberhenti_t':
 * @property integer $permintaanberhenti_id
 * @property integer $keanggotaan_id
 * @property integer $pegawai_id
 * @property string $tglpermintaanberhenti
 * @property string $tglberhenti_dipecat
 * @property string $sebabberhenti
 * @property string $alasanberhenti
 * @property double $jmlsimpanan_berhenti
 * @property double $jmltunggakan_berhenti
 * @property string $lamamenjadi_anggota
 * @property string $tgldibuatpermintaan
 * @property integer $dibuatolehperm_id
 * @property string $tgldiperiksaperm
 * @property integer $diperiksaprmint_id
 * @property string $tgldisetujuiperm
 * @property integer $disetuuiolehperm_id
 * @property double $jmlkasmasuk_keluar
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property JmlangsuranT[] $jmlangsuranTs
 * @property KeanggotaanT $keanggotaan
 * @property PegawaiM $pegawai
 * @property SimpananT[] $simpananTs
 */
class PermintaanberhentiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaanberhentiT the static model class
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
		return 'permintaanberhenti_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keanggotaan_id, pegawai_id, tglpermintaanberhenti, sebabberhenti, tgldibuatpermintaan, dibuatolehperm_id, create_time, create_loginpemakai_id', 'required'),
			array('keanggotaan_id, pegawai_id, dibuatolehperm_id, diperiksaprmint_id, disetuuiolehperm_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmlsimpanan_berhenti, jmltunggakan_berhenti, jmlkasmasuk_keluar', 'numerical'),
			array('sebabberhenti', 'length', 'max'=>200),
			array('lamamenjadi_anggota', 'length', 'max'=>20),
			array('tglberhenti_dipecat, alasanberhenti, tgldiperiksaperm, tgldisetujuiperm, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permintaanberhenti_id, keanggotaan_id, pegawai_id, tglpermintaanberhenti, tglberhenti_dipecat, sebabberhenti, alasanberhenti, jmlsimpanan_berhenti, jmltunggakan_berhenti, lamamenjadi_anggota, tgldibuatpermintaan, dibuatolehperm_id, tgldiperiksaperm, diperiksaprmint_id, tgldisetujuiperm, disetuuiolehperm_id, jmlkasmasuk_keluar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jmlangsuranTs' => array(self::HAS_MANY, 'JmlangsuranT', 'permintaanberhenti_id'),
			'keanggotaan' => array(self::BELONGS_TO, 'KeanggotaanT', 'keanggotaan_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'simpananTs' => array(self::HAS_MANY, 'SimpananT', 'permintaanberhenti_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permintaanberhenti_id' => 'Permintaanberhenti',
			'keanggotaan_id' => 'Keanggotaan',
			'pegawai_id' => 'Pegawai',
			'tglpermintaanberhenti' => 'Tglpermintaanberhenti',
			'tglberhenti_dipecat' => 'Tglberhenti Dipecat',
			'sebabberhenti' => 'Sebabberhenti',
			'alasanberhenti' => 'Alasanberhenti',
			'jmlsimpanan_berhenti' => 'Jmlsimpanan Berhenti',
			'jmltunggakan_berhenti' => 'Jmltunggakan Berhenti',
			'lamamenjadi_anggota' => 'Lamamenjadi Anggota',
			'tgldibuatpermintaan' => 'Tgldibuatpermintaan',
			'dibuatolehperm_id' => 'Dibuatolehperm',
			'tgldiperiksaperm' => 'Tgldiperiksaperm',
			'diperiksaprmint_id' => 'Diperiksaprmint',
			'tgldisetujuiperm' => 'Tgldisetujuiperm',
			'disetuuiolehperm_id' => 'Disetuuiolehperm',
			'jmlkasmasuk_keluar' => 'Jmlkasmasuk Keluar',
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

		$criteria->compare('permintaanberhenti_id',$this->permintaanberhenti_id);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglpermintaanberhenti',$this->tglpermintaanberhenti,true);
		$criteria->compare('tglberhenti_dipecat',$this->tglberhenti_dipecat,true);
		$criteria->compare('sebabberhenti',$this->sebabberhenti,true);
		$criteria->compare('alasanberhenti',$this->alasanberhenti,true);
		$criteria->compare('jmlsimpanan_berhenti',$this->jmlsimpanan_berhenti);
		$criteria->compare('jmltunggakan_berhenti',$this->jmltunggakan_berhenti);
		$criteria->compare('lamamenjadi_anggota',$this->lamamenjadi_anggota,true);
		$criteria->compare('tgldibuatpermintaan',$this->tgldibuatpermintaan,true);
		$criteria->compare('dibuatolehperm_id',$this->dibuatolehperm_id);
		$criteria->compare('tgldiperiksaperm',$this->tgldiperiksaperm,true);
		$criteria->compare('diperiksaprmint_id',$this->diperiksaprmint_id);
		$criteria->compare('tgldisetujuiperm',$this->tgldisetujuiperm,true);
		$criteria->compare('disetuuiolehperm_id',$this->disetuuiolehperm_id);
		$criteria->compare('jmlkasmasuk_keluar',$this->jmlkasmasuk_keluar);
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