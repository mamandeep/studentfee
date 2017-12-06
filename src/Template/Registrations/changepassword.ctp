<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Password Details') ?></legend>
        <?= $this->Form->control('password', ['label' => 'New Password', 'type' => 'password']) ?>
        <?= $this->Form->control('password_confirm', ['label' => 'Confirm New Password', 'type' => 'password']) ?>
        <ul>
            <li>The passoword must be atleast 8 characters long.</li>
            <li>The passoword must contain atleast 1 number.</li>
            <li>The passoword must contain atleast 1 alphabet.</li>
        </ul>
        <?= $this->Form->control('otp_value', ['label' => 'OTP (One Time Password)', 'type' => 'password']) ?>
        <?= $this->Form->control('role', [ 
            'value' => 'student',
            'type' => 'hidden'
        ]) ?>
   </fieldset>
<?= $this->Form->button(__('Submit')); ?>
<?= $this->Form->end() ?>
</div>