<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

<div class="container">
    <?php echo validation_errors(); ?>

    <?php echo form_open(null, array('role' => 'form')) ?>
        <?php foreach ($menuTypes as $menuType) {
            $menuHeader = sprintf('<h4>%s (%s-%s)</h4>', $menuType['name'], $menuType['minimum'], $menuType['maximum']);
            echo $menuHeader;
            echo '<table class="table"><thead><tr><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th></tr></thead><tbody>';

            $findMenuItemsOfType = function ($menuItemType)
            {
                return function ($item) use ($menuItemType) { return ($item['type'] == $menuItemType); };
            };
            $menuItemsOfType = array_filter($menu, $findMenuItemsOfType($menuType['id']));
            foreach($menuItemsOfType as $menuItem)
            {
                echo '<tr>';
                echo '<td>'.$menuItem['name'].'</td>';
                echo '<td>'.$menuItem['description'].'</td>';
                echo '<td>$'.$menuItem['price'].'</td>';
                echo '<td><input name="'.$menuItem['id'].'" type="number" value="0" /></td>';
                echo '</tr>';
            }
            echo '</tbody></table><br/>';
        }
        ?>
        <input type="submit" name="submit" value="Order" class="btn btn-default" />
    </form>
</div><!-- end of container-->

<?php $this->load->view('shared/footer') ?>