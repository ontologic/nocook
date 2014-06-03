<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

<div class="container">
    <?php echo validation_errors(); ?>
    <?php echo form_open(null, array('role' => 'form')) ?>
        <div>Adults: <?php echo form_input($adults); ?> ($23/adult first 2 then $16/adult after)</div>
        <div>Children: <?php echo form_input($children); ?> ($12/child)</div>
        <!--<div>Adults: <input type="text" name="adults" placeholder="Enter number" /> ($23/adult first 2 then $16/adult after)</div>
        <div>Children: <input type="text" name="adults" placeholder="Enter number" /> ($12/child)</div>-->

        <div><?php echo form_radio($self); ?>Ordering for Self</div>
        <div><?php echo form_radio($gift); ?>Ordering as a Gift</div>

        <!--<a href="<?php /*echo base_url();*/?>home/order/<?php /*echo $zip;*/?>"><button class="btn btn-default">Place Order</button></a>-->
        <!--<a href="<?php /*echo base_url();*/?>home/gift/<?php /*echo $zip;*/?>"><button class="btn btn-default">Order as a Gift</button></a>-->
        <input type="submit" value="Place Order" />
    </form>
</div>