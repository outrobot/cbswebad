<?php
$this->breadcrumbs=array(
	'Uploads'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Upload','url'=>array('index')),
	array('label'=>'Create Upload','url'=>array('create')),
	array('label'=>'Update Upload','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Upload','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Upload','url'=>array('admin')),
);
?>

<h1>View Upload #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'filename',
		'file_size',
		'file_ext',
		'create_user_id',
		'create_time',
		'update_user_id',
		'update_time',
		'client_id',
	),
)); ?>
