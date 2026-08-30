<?php

/**
 * This is the model class for table "askepgeriatri_t".
 *
 * The followings are the available columns in table 'askepgeriatri_t':
 * @property integer $askepgeriatri_id
 * @property integer $asesmenawalkeperawatan_id
 * @property string $orangterdekat_nama
 * @property string $orangygtinggal_serumah
 * @property integer $jmlanak_seluruh
 * @property integer $jmlanak_lakilaki
 * @property integer $jmlanak_perempuan
 * @property integer $jmlcucu_seluruh
 * @property integer $jmlcucu_lakilaki
 * @property integer $jmlcucu_perempuan
 * @property integer $jmlcicit_seluruh
 * @property integer $jmlcicit_lakilaki
 * @property integer $jmlcicit_perempuan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property AsesmenawalkeperawatanT $asesmenawalkeperawatan
 */
class AskepgeriatriT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AskepgeriatriT the static model class
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
		return 'askepgeriatri_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenawalkeperawatan_id, create_time, create_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'required'),
			array('asesmenawalkeperawatan_id, jmlanak_seluruh, jmlanak_lakilaki, jmlanak_perempuan, jmlcucu_seluruh, jmlcucu_lakilaki, jmlcucu_perempuan, jmlcicit_seluruh, jmlcicit_lakilaki, jmlcicit_perempuan, create_petugaspengisi_id, create_ruangan_id, minimentalexam_skor', 'numerical', 'integerOnly'=>true),
			array('orangterdekat_nama, create_loginpemakai, update_loginpemakai, pengetahuanttg_perawatan, minimentalexam_keterangan', 'length', 'max'=>100),
			array('orangygtinggal_serumah, pengetahuanttg_penyakitsaatini', 'length', 'max'=>200),
			array('update_time, kegiatan_sekarang, rencana_tindaklanjut, perasaanyg_dirasakan, periksafisik_abdomen_auskultasi, periksafisik_abdomen_perkusi, periksafisik_abdomen_palpasi, periksafisik_abdomen_inspeksi, periksafisik_paru_auskultasi, periksafisik_paru_perkusi, periksafisik_paru_palpasi, periksafisik_paru_inspeksi, periksafisik_jantung_auskultasi, periksafisik_jantung_perkusi, periksafisik_jantung_palpasi, periksafisik_jantung_inspeksi, periksafisik_muskuloskeletal, periksafisik_leher, periksafisik_mulutrahang_gigi, periksafisik_kulit, periksafisik_penglihatan, periksafisik_pendengaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('askepgeriatri_id, asesmenawalkeperawatan_id, orangterdekat_nama, orangygtinggal_serumah, jmlanak_seluruh, jmlanak_lakilaki, jmlanak_perempuan, jmlcucu_seluruh, jmlcucu_lakilaki, jmlcucu_perempuan, jmlcicit_seluruh, jmlcicit_lakilaki, jmlcicit_perempuan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id, kegiatan_sekarang, rencana_tindaklanjut, perasaanyg_dirasakan, periksafisik_abdomen_auskultasi, periksafisik_abdomen_perkusi, periksafisik_abdomen_palpasi, periksafisik_abdomen_inspeksi, periksafisik_paru_auskultasi, periksafisik_paru_perkusi, periksafisik_paru_palpasi, periksafisik_paru_inspeksi, periksafisik_jantung_auskultasi, periksafisik_jantung_perkusi, periksafisik_jantung_palpasi, periksafisik_jantung_inspeksi, periksafisik_muskuloskeletal, periksafisik_leher, periksafisik_mulutrahang_gigi, periksafisik_kulit, periksafisik_penglihatan, periksafisik_pendengaran, pengetahuanttg_penyakitsaatini, pengetahuanttg_perawatan, minimentalexam_keterangan, minimentalexam_skor', 'safe', 'on'=>'search'),
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
			'asesmenawalkeperawatan' => array(self::BELONGS_TO, 'AsesmenawalkeperawatanT', 'asesmenawalkeperawatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'askepgeriatri_id' => 'Askepgeriatri',
			'asesmenawalkeperawatan_id' => 'Asesmenawalkeperawatan',
			'orangterdekat_nama' => 'Orangterdekat Nama',
			'orangygtinggal_serumah' => 'Orangygtinggal Serumah',
			'jmlanak_seluruh' => 'Jmlanak Seluruh',
			'jmlanak_lakilaki' => 'Jmlanak Lakilaki',
			'jmlanak_perempuan' => 'Jmlanak Perempuan',
			'jmlcucu_seluruh' => 'Jmlcucu Seluruh',
			'jmlcucu_lakilaki' => 'Jmlcucu Lakilaki',
			'jmlcucu_perempuan' => 'Jmlcucu Perempuan',
			'jmlcicit_seluruh' => 'Jmlcicit Seluruh',
			'jmlcicit_lakilaki' => 'Jmlcicit Lakilaki',
			'jmlcicit_perempuan' => 'Jmlcicit Perempuan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
			'kegiatan_sekarang'=>'Kegiatan Sekarang'
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

		$criteria->compare('askepgeriatri_id',$this->askepgeriatri_id);
		$criteria->compare('asesmenawalkeperawatan_id',$this->asesmenawalkeperawatan_id);
		$criteria->compare('orangterdekat_nama',$this->orangterdekat_nama,true);
		$criteria->compare('orangygtinggal_serumah',$this->orangygtinggal_serumah,true);
		$criteria->compare('jmlanak_seluruh',$this->jmlanak_seluruh);
		$criteria->compare('jmlanak_lakilaki',$this->jmlanak_lakilaki);
		$criteria->compare('jmlanak_perempuan',$this->jmlanak_perempuan);
		$criteria->compare('jmlcucu_seluruh',$this->jmlcucu_seluruh);
		$criteria->compare('jmlcucu_lakilaki',$this->jmlcucu_lakilaki);
		$criteria->compare('jmlcucu_perempuan',$this->jmlcucu_perempuan);
		$criteria->compare('jmlcicit_seluruh',$this->jmlcicit_seluruh);
		$criteria->compare('jmlcicit_lakilaki',$this->jmlcicit_lakilaki);
		$criteria->compare('jmlcicit_perempuan',$this->jmlcicit_perempuan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
