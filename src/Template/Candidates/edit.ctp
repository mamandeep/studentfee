<h1>Edit Application Form</h1>
<?php
    echo $this->Form->create($candidate);
    echo $this->Form->control('name');
    echo $this->Form->control('f_name');
    echo $this->Form->control('email');
    echo $this->Form->control('mobile');
    echo $this->Form->control('cucet_roll_no');
    echo $this->Form->control('cucet_id');
    echo $this->Form->control('dob');
    echo $this->Form->button(__('Save Form'));
    echo $this->Form->end();
?>