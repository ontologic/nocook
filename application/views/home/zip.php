<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

    <div class="container">
        <?php echo validation_errors(); ?>
        <h2>Enter your zip code to get started:</h2>
        <?php echo form_open(null, array('role' => 'form')) ?>
            <?php echo form_input($zip); ?>
            <input type="submit" name="submit" value="View Menu" class="btn btn-default" />
        </form>
    </div>

<?php $this->load->view('shared/footer') ?>