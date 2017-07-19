<?php
/* @var $this yii\web\View */
?>
<p><?=\yii\bootstrap\Html::a('添加',['article-category/add'],['class'=>'btn btn-default'])?></p>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>分类名称</th>
        <th>简介</th>
        <th>排序号</th>
        <th>状态</th>
        <th>是否帮助文档</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <?php if($model->status >=0){?>
            <tr>
                <td><?=$model->id?></td>
                <td><?=$model->name?></td>
                <td><?=$model->intro?></td>
                <td><?=$model->sort?></td>
                <td><?=$model->status?'显示':'隐藏'?></td>
                <td><?=$model->is_help?'是':'否'?></td>
                <td>
                    <?php if(Yii::$app->user->can('article-category/edit'))echo \yii\bootstrap\Html::a('修改',['article-category/edit','id'=>$model->id],['class'=>'btn btn-warning'])?>
                    <?php if(Yii::$app->user->can('article-category/del'))echo \yii\bootstrap\Html::a('删除',['article-category/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
                    <?php if(Yii::$app->user->can('article-category/state'))echo \yii\bootstrap\Html::a($model->status > 0 ? '隐藏':'显示',['article-category/state','id'=>$model->id],['class'=>'btn btn-default'])?>
                </td>
            </tr>

        <?php }?>
    <?php endforeach;?>
</table>
<?php
    echo \yii\widgets\LinkPager::widget([
            'pagination'=>$page,
        'prevPageLabel'=>'上一页',
        'nextPageLabel'=>'下一页',
    ]);
