<?php //debug($cucetregister); 
     echo $this->Form->create($cucetregister); ?>
    <fieldset>
        <legend><strong><?= __('Registration Details') ?></strong></legend>
        <table width="100%">
            <tr>
                <td class="form-label">CUPB Registration Number (e.g. 16XXXXXXYY)</td>
                <td><?php echo $this->Form->control('username', ['label' => false]) ?></td>
            </tr>
            <tr>
                <td class="form-label">Name</td>
                <td><?php echo $this->Form->control('name', ['label' => false]) ?></td>
            </tr>
            <tr>
                <td class="form-label">Email ID</td>
                <td><?php echo $this->Form->control('email', ['label' => false]) ?></td>
            </tr>
            <tr>
                <td class="form-label">Mobile No. (10 digit)</td>
                <td><?php echo $this->Form->control('mobile', ['label' => false]) ?></td>
            </tr>
            <tr>
                <td class="form-label">Password</td>
                <td><?php echo $this->Form->control('password', ['label' => false]) ?>
                    <div>
                        <ul>
                            <li>The passoword must be atleast 8 characters long and must have atleast 1 number and 1 alphabet.</li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="form-label">Confirm Password</td>
                <td><?php echo $this->Form->control('password_confirm', ['label' => false, 'type' => 'password']) ?>
                     <?php echo $this->Form->control('role', [ 
                        'value' => 'student',
                        'type' => 'hidden'
                    ]) ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><?php echo $this->Form->button(__('Submit')); ?></td>
            </tr>
        </table>
   </fieldset>
<?php echo $this->Form->end() ?>