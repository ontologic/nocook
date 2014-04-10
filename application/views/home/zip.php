<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

    <div class="container">
        <?php echo validation_errors(); ?>

        <h2>Enter your zip code to get started:</h2>
        <?php echo form_open(null, array('role' => 'form')) ?>
            <input type="text" name="zip" />
            <input type="submit" name="submit" value="View Menu" class="btn btn-default" />
        </form>
    </div>

<?php $this->load->view('shared/footer') ?>