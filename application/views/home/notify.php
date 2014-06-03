<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

    <h1>Step 2</h1>

    <div class="container">
        <?php echo validation_errors(); ?>

        <h2>Delivery Information</h2>
        <?php echo form_open(null, array('role' => 'form')) ?>

        <div class="form-group">
            <label>How would you like to inform the recipient?</label>
            <?php
                $options = array(
                    '1'  => 'Printed Gift Certificate (you deliver)',
                    '2'    => 'We\'ll Email the Recipient',
                    '3'   => 'We\'ll Call the Recipient'
                );
                echo form_dropdown('notification', $options)
            ?>
        </div>

        <div class="form-group">
            <label>Note to Recipient</label>
            <?php echo form_textarea($note); ?>
        </div>

        <input type="submit" value="Continue" class="btn btn-default" />

        </form>
    </div>

<script type="text/javascript">
    $(document).ready(function (){
        $(".selector").datepicker({ dateFormat: "yy-mm-dd" });
    });
</script>

<?php $this->load->view('shared/footer') ?>