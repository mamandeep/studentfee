<?= $this->Form->create()?>
<div class="form-group">
    <?= $this->Form->input('email', array('class' => 'form-group','autocomplete' => 'off' ,'required' => 'required'))?>
</div>
<div class="form-group">    
    <?= $this->Form->button('Continue', array('class' => 'form-group primary'))?>
</div>
<?= $this->Form->end()?>