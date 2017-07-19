
<p>
    <?=\yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-default'])?>
</p>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>品牌名称</th>
        <th>简介</th>
        <th>LOGO</th>
        <th>排序号</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <?php if($model->status >=0){?>
            <tr>
                <td><?=$model->id?></td>
                <td><?=$model->name?></td>
                <td><?=$model->intro?></td>
                <td><?=\yii\bootstrap\Html::img('http://img.yii2shop.com'.$model->logo,['height'=>100])?></td>
                <td><?=$model->sort?></td>
                <td><?=$model->status?'显示':'隐藏'?></td>
                <td>
                    <?php echo \yii\bootstrap\Html::a('修改',['brand/edit','id'=>$model->id],['class'=>'btn btn-warning'])?>
                    <?php echo \yii\bootstrap\Html::a('删除',['brand/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
                    <?php echo \yii\bootstrap\Html::a($model->status > 0 ? '隐藏':'显示',['brand/state','id'=>$model->id],['class'=>'btn btn-default'])?>
                </td>
            </tr>

        <?php }?>
    <?php endforeach;?>
</table>
<?php
    echo \yii\widgets\LinkPager::widget([
            'pagination'=>$page,
    ]);