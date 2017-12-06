<script>
    function CheckAll(e) {
        var allCheckBoxes = document.getElementsByName("checklist[]");
        for (var i = 0; i < allCheckBoxes.length; i++) {
           if(allCheckBoxes[i].checked) 
                allCheckBoxes[i].checked = false;
            else
                allCheckBoxes[i].checked = true;
        }
    }
</script>    
<div class="users form">
<h1>Users</h1>
<table>
    <thead>
        <tr>
            <th><?php echo $this->Form->checkbox('toggleall', array('onClick' => 'CheckAll(this)')); ?></th>
            <th><?php echo $this->Paginator->sort('username', 'Username');?>  </th>
            <th><?php echo $this->Paginator->sort('email', 'E-Mail');?></th>
            <th><?php echo $this->Paginator->sort('created', 'Created');?></th>
            <th><?php echo $this->Paginator->sort('modified','Last Update');?></th>
            <th><?php echo $this->Paginator->sort('role','Role');?></th>
            <th><?php echo $this->Paginator->sort('status','Status');?></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>                       
        <?php $count=0; ?>
        <?php foreach($users as $user): ?>                
        <?php $count ++;?>
        <?php if($count % 2): echo '<tr>'; else: echo '<tr class="zebra">' ?>
        <?php endif; ?>
            <td><?php echo $this->Form->checkbox('checklist.', array('value' => $user->id)); ?></td>
            <td><?php echo $this->Html->link( $user->username  ,   array('action'=>'edit', $user->id),array('escape' => false) );?></td>
            <td style="text-align: center;"><?php echo $user->email; ?></td>
            <td style="text-align: center;"><?php echo $this->Time->nice($user->created); ?></td>
            <td style="text-align: center;"><?php echo $this->Time->nice($user->modified); ?></td>
            <td style="text-align: center;"><?php echo $user->role; ?></td>
            <td style="text-align: center;"><?php echo $user->status; ?></td>
            <td >
            <?php echo $this->Html->link(    "Edit",   array('action'=>'edit', $user->id) ); ?> | 
            <?php
                if( $user->status != 0){ 
                    echo $this->Html->link(    "Delete", array('action'=>'delete', $user->id));}else{
                    echo $this->Html->link(    "Re-Activate", array('action'=>'activate', $user->id));
                    }
            ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php unset($user); ?>
    </tbody>
</table>
<?php echo $this->Paginator->prev(' << ' . __('previous'));?>
<?php echo $this->Paginator->numbers();?>
<?php echo $this->Paginator->next(__('next') . ' >>');?>
</div>                
<?php echo $this->Html->link( "Add A New User.",   array('action'=>'add'),array('escape' => false) ); ?>
<br/>
<?php 
echo $this->Html->link( "Logout",   array('action'=>'logout') ); 
?>