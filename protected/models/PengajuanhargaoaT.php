<?php

/**
 * This is the model class for table "pengajuanhargaoa_t".
 *
 * The followings are the available columns in table 'pengajuanhargaoa_t':
 * @property integer $pengajuanhargaoa_id
 * @property string $tglpengajuanhargaoa
 * @property string $ketpengajuan
 * @property integer $pegawai_id
 * @property integer $pegawaimengetahui_id
 * @property integer $pegawaimenyetujui_id
 * @property string $tglmengetahui
 * @property string $tglmenyetujui
 * @property string $statuspengajuan
 * @property string $tglpembatalanpengajuanoa
 * @property integer $pegawaibatal_id
 * @property string $alasanpembatalan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PenghargaoadetailT[] $penghargaoadetailTs
 */
class PengajuanhargaoaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanhargaoaT the static model class
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
		return 'pengajuanhargaoa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpengajuanhargaoa, pegawai_id, create_time, create_loginpemakai, nopengajuanhargaoa', 'required'),
			array('pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id, pegawaibatal_id', 'numerical', 'integerOnly'=>true),
			array('statuspengajuan', 'length', 'max'=>20),
                        array('nopengajuanhargaoa', 'length', 'max'=>50),
			array('ketpengajuan, tglmengetahui, tglmenyetujui, update_time, update_loginpemakai, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanhargaoa_id, tglpengajuanhargaoa, ketpengajuan, pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id, tglmengetahui, tglmenyetujui, statuspengajuan, tglpembatalanpengajuanoa, pegawaibatal_id, alasanpembatalan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, nopengajuanhargaoa', 'safe', 'on'=>'search'),
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
			'penghargaoadetailTs' => array(self::HAS_MANY, 'PenghargaoadetailT', 'pengajuanhargaoa_id'),
                    'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
                    'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanhargaoa_id' => 'Pengajuanhargaoa',
			'tglpengajuanhargaoa' => 'Tgl. Pengajuan',
			'ketpengajuan' => 'Keterangan Pengajuan',
			'pegawai_id' => 'Pegawai yang Mengajukan',
			'pegawaimengetahui_id' => 'Manager Keuangan',
			'pegawaimenyetujui_id' => 'Direktur',
			'tglmengetahui' => 'Tglmengetahui',
			'tglmenyetujui' => 'Tglmenyetujui',
			'statuspengajuan' => 'Statuspengajuan',
			'tglpembatalanpengajuanoa' => 'Tglpembatalanpengajuanoa',
			'pegawaibatal_id' => 'Pegawai Batal',
			'alasanpembatalan' => 'Alasanpembatalan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                    'nopengajuanhargaoa' => 'No. Pengajuan',
                    
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

		$criteria->compare('pengajuanhargaoa_id',$this->pengajuanhargaoa_id);
		$criteria->compare('tglpengajuanhargaoa',$this->tglpengajuanhargaoa,true);
		$criteria->compare('ketpengajuan',$this->ketpengajuan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('tglmengetahui',$this->tglmengetahui,true);
		$criteria->compare('tglmenyetujui',$this->tglmenyetujui,true);
		$criteria->compare('statuspengajuan',$this->statuspengajuan,true);
		$criteria->compare('tglpembatalanpengajuanoa',$this->tglpembatalanpengajuanoa,true);
		$criteria->compare('pegawaibatal_id',$this->pegawaibatal_id);
		$criteria->compare('alasanpembatalan',$this->alasanpembatalan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}