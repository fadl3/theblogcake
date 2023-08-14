<div class="form users">
    <?php echo $this->Form->create('User'); ?>

    <fieldset>
        <legend>
            <?php echo __('Log in'); ?>
        </legend>

        <?php   echo $this->Form->input('username');  
                echo $this->Form->input('password');  
        ?>

    </fieldset>
    <?php echo $this->Form->end(__('submit'));  ?>

</div>