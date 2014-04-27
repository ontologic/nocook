<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

<div class="container">
    <?php foreach ($menuTypes as $menuType) {
        $menuHeader = sprintf('<h4>%s ($%s)</h4>', $menuType['name'], $menuType['price']);
        echo $menuHeader;
        echo '<table class="table"><thead><tr><th>Name</th><th>Description</th><th>Price</th></tr></thead><tbody>';

        $findMenuItemsOfType = function ($menuItemType)
        {
            return function ($item) use ($menuItemType) { return ($item['menuitemtype'] == $menuItemType); };
        };
        $menuItemsOfType = array_filter($menu, $findMenuItemsOfType($menuType['id']));
        foreach($menuItemsOfType as $menuItem)
        {
            echo '<tr>';
            echo '<td>'.$menuItem['name'].'</td>';
            echo '<td>'.$menuItem['description'].'</td>';
            echo '<td>$'.$menuType['price'].'</td>';
            echo '</tr>';
        }
        echo '</tbody></table><br/>';
    }
    ?>
    <a href="<?php echo base_url();?>home/order/<?php echo $zip;?>"><button class="btn btn-default">Order</button></a>
    <a href="<?php echo base_url();?>home/gift/<?php echo $zip;?>"><button class="btn btn-default">Order as Gift</button></a>
</div><!-- end of container-->

<?php $this->load->view('shared/footer') ?>