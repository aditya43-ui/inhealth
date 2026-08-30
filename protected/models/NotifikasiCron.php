<?php

/** digunakan sebagai model dasar untuk cron job - untuk menghindari penggunaan user cconsole (fungsi pada yii)
 *	@author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *	@website	<https://piinfonesia.co.id>
 * 
 */
class NotifikasiCron extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notifikasi_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, tglnotifikasi, judulnotifikasi, isinotifikasi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('instalasi_id, modul_id, lamahrnotif', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time','default','value'=>date( 'Y-m-d H:i:s'),'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'on'=>'update'),
			array('create_loginpemakai_id','default','value'=>Params::LOGINPEMAKAI_ID_ADMIN,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Params::LOGINPEMAKAI_ID_ADMIN,'on'=>'update,insert'),
			array('judulnotifikasi', 'length', 'max'=>50),
			array('isread, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nofitikasi_id, instalasi_id, modul_id, tglnotifikasi, judulnotifikasi, isinotifikasi, isread, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, lamahrnotif', 'safe', 'on'=>'search'),
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
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'modul' => array(self::BELONGS_TO, 'ModulK', 'modul_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
		);
	}

	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
}
