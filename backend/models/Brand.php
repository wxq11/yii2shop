<?php
namespace backend\models;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19
 * Time: 8:58
 */
class Brand extends \yii\db\ActiveRecord
{
    public $imgFile;

    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @验证
     */
    public function rules()
    {
        return [
            [['name', 'intro', 'sort', 'status'], 'required'],
            [['intro','logo'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
//            ['logo','file','extensions'=>['jpg','png','gif']],
        ];
    }

    /**
     * @中文显示属性
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名称',
            'intro' => '简介',
            'logo' => 'LOGO',
            'sort' => '排序',
            'status' => '状态',
        ];
    }

}