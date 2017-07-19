<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Brand;
use Psr\Http\Message\UploadedFileInterface;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;
use crazyfd\qiniu\Qiniu;

class BrandController extends Controller
{

    public function actionIndex()
    {

        //获取数据表中所有模型对象
        $query = Brand::find()->where(['>=','status',0]);
        //总条数
        $total = $query->count();
        $page = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>3,
        ]);
        $models = $query->orderBy('sort')->offset($page->offset)->limit($page->limit)->all();
        //加载视图，发送模型
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }

    /**
     * @添加品牌
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //实例化Brand模型
        $model = new Brand();
        //实例化request组件
        $request = \Yii::$app->request;
        //如果加载数据成功
        if($model->load($request->post())){
//            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
            //验证
            if($model->validate()){//验证成功
                $model->imgFile = UploadedFile::getInstance($model,'imgFile');
                $dataPath = \Yii::getAlias('@data');
                $filePath = $dataPath.'/'.date('Y-m-d',time());//D:\phpStudy\WWW\yii2shop/data/2017-07-19/
                if(!is_dir($filePath)){
                    mkdir($filePath,0777,true);
                }
                $filename = uniqid(time()).'.'.$model->imgFile->getExtension();
                $imgPath = $filePath.'/'.$filename;
                //移动图片
                $model->imgFile->saveAs($imgPath);
                $model->logo = str_replace($dataPath,'',$imgPath);
                //保存
                $model->save();
                //提示
                \Yii::$app->session->setFlash('success','品牌添加成功');
                //跳转列表
                return $this->redirect(['brand/index']);
            }else{//验证失败
                var_dump($model->getErrors());exit;
            }
        }
        //加载视图，发送模型
        return $this->render('add',['model'=>$model]);
    }

    /**
     * @删除品牌
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDel($id){
        //根据id获取模型对象
        $model = Brand::findOne(['id'=>$id]);
        //删除
        $model->status = -1;
        $model->save();
        //跳转列表
        \Yii::$app->session->setFlash('success','品牌删除成功');
        return $this->redirect(['brand/index']);
    }

    /**
     * 更改状态
     * @param $id
     * @return \yii\web\Response
     */
    public function actionState($id){

        //根据id获取模型对象
        $model = Brand::findOne(['id'=>$id]);
            if($model->status == 0){
                $model->status = 1;
            }else{
                $model->status = 0;
            }
        $model->save();
        //跳转列表
        return $this->redirect(['brand/index']);
    }
    public function actionEdit($id){
        //根据id获取模型对象
        $model = Brand::findOne(['id'=>$id]);
        //实例化request组件
        $request = \Yii::$app->request;
        //如果加载数据成功
        if($model->load($request->post())){
//            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
            //验证
            if($model->validate()){//验证成功

                //保存
                $model->save();
                //提示
                \Yii::$app->session->setFlash('success','品牌修改成功');
                //跳转列表
                return $this->redirect(['brand/index']);
            }else{//验证失败
                var_dump($model->getErrors());exit;
            }
        }
        //加载视图，发送模型
        return $this->render('add',['model'=>$model]);
    }

}
