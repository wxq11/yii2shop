<?php

namespace backend\controllers;


use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class ArticleController extends Controller
{

    public function actionIndex()
    {
        //获取所有文章对象
        $query = Article::find();
        $total = $query->count();
        $page = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>2,
        ]);
        $models = $query->orderBy('sort')->offset($page->offset)->limit($page->limit)->all();

        return $this->render('index',['models'=>$models,'page'=>$page]);
    }

    /**
     * 添加文章
     * @return string
     */
    public function actionAdd(){
        //实例化文章模型对象
        $model = new Article();
        //示例化文章详情对象
        $detail = new ArticleDetail();
        //实例化request组件
        $request = \Yii::$app->request;
        //判断是否加载成功
        if($model->load($request->post())&&$detail->load($request->post())){
            $model->create_time = time();
            //验证
            if($model->validate()&&$detail->validate()){
                //保存
                $model->save();
                $detail->save();
                //提示信息
                \Yii::$app->session->setFlash('success','文章添加成功');
                //跳转列表
                return $this->redirect(['article/index']);
            }else{
                var_dump($detail->getErrors());exit;
            }

        }
        //获取文章分类对象
        $categorys = ArticleCategory::find()->asArray()->where('status>=0')->all();
        $category = ArrayHelper::map($categorys,'id','name');
        /*$category[0]='请选择';
        foreach($categorys as $v){
            if($v['status']>=0)$category[$v['id']]=$v['name'];
        }*/
        //加载视图，发送模型
        return $this->render('add',['model'=>$model,'detail'=>$detail,'category'=>$category]);
    }

    /**
     * 删除文章
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDel($id){
        $model = Article::findOne(['id'=>$id]);
        $model->status = -1;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['article/index']);
    }

    /**
     * 修改状态
     * @param $id
     * @return \yii\web\Response
     */
    public function actionState($id){
        //根据id获取模型对象
        $model = Article::findOne(['id'=>$id]);
        if($model->status == 0){
            $model->status = 1;
        }else{
            $model->status = 0;
        }
        $model->save();
        //跳转列表

        return $this->redirect(['article/index']);
    }

    /**
     * 修改文章
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id){
        $model = Article::findOne(['id'=>$id]);
        //示例化文章详情对象
        $detail = ArticleDetail::findOne(['article_id'=>$id]);
        //实例化request组件
        $request = \Yii::$app->request;
        //判断model是否加载成功
        if($model->load($request->post())){
            $model->create_time = time();
            //验证model
            if($model->validate()){
                //判断detail是否加载成功
                if($detail->load($request->post())) {
                    //验证detail
                    if ($detail->validate()) {
                        //保存
                        $model->save();
                        $detail->save();
                    }else{
                        var_dump($detail->getErrors());exit;
                    }
                }
                //跳转列表
                \Yii::$app->session->setFlash('success','文章添加成功');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        //获取文章分类对象
        $categorys = ArticleCategory::find()->asArray()->all();
        foreach($categorys as $v){
            static $category = [0=>'选择文章分类'];
            $v = [$v['id']=>$v['name']];
            $category = array_merge($category,$v);
        }
        //加载视图，发送模型
        return $this->render('add',['model'=>$model,'detail'=>$detail,'category'=>$category]);
    }
}
