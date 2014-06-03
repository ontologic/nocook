<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

    <h1>Step 3</h1>

    <div class="container">
        <?php echo validation_errors(); ?>

        <?php echo form_open(null, array('role' => 'form')) ?>

        <div class="form-group">
            <label>Are you picking out the food and date?</label>
            <?php
            $options = array(
                'true'  => 'Yes',
                'false'    => 'No'
            );
            echo form_dropdown('picking', $options)
            ?>
        </div>

        <div class="form-group">
            <label>Date</label>
            <?php echo form_input($date); ?>
        </div>

        <input type="submit" value="Continue" class="btn btn-default" />

        </form>
    </div>

    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/jquery-ui-1.10.4.min.css" />
    <script src="<?php echo base_url();?>/assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url();?>/assets/js/jquery-ui-1.10.4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            $("#date").datepicker({
                dateFormat: "mm-dd-yy",
                minDate: 0,
                maxDate: "+2D"
            });

            $("select").change(function (){
                var val = $(this).val();
                if(val === "true"){
                    $("#date").parent().show();
                } else {
                    $("#date").parent().hide();
                }
            });
            $("select").trigger("change");
        });
    </script>

<?php $this->load->view('shared/footer') ?>