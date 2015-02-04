<div class="view">

        <h3><?php echo CHtml::link(CHtml::encode($data->name),array('view','id'=>$data->id)); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>$data->active == 1 ? 'Active' : 'Inactive (click to activate)',
                'type'=>$data->active == 1 ? 'primary' : 'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'mini', // null, 'large', 'small' or 'mini'
                'url'=>$data->active == 1 ? '' : array('makeactive', 'id'=>$data->id)
            )); ?>
        </h3>
    
        <blockquote>

            <b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
            <?php echo CHtml::encode($data->createUser->username); ?>
            <br />

            <b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
            <?php echo CHtml::encode($data->formatDate($data->create_time)); ?>
            <br />

            <b><?php echo CHtml::encode($data->getAttributeLabel('update_user_id')); ?>:</b>
            <?php echo CHtml::encode($data->updateUser->username); ?>
            <br />

            <b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
            <?php echo CHtml::encode($data->formatDate($data->update_time)); ?>
            <br />
        </blockquote>

</div>