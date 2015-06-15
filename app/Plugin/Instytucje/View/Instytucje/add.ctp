<?php echo $this->Form->create('Instytucje', array(
    'class' => 'form-vertical',
    'inputDefaults' => array(
        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => array('class' => 'control-group'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
    )));?>
    <fieldset>
        <?php echo $this->Form->inputs(); ?>
    </fieldset>
<?php echo $this->Form->end();?>


<? echo $this->Form->create('Instytucje'); ?>

<?php echo $this->Form->end('Zapisz'); ?>