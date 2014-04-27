<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

    <div class="container">
        <?php echo validation_errors(); ?>

        <?php echo form_open(null, array('role' => 'form')) ?>
        <?php foreach ($menuTypes as $menuType) {
            $menuHeader = sprintf('<h4>%s ($%s)</h4>', $menuType['name'], $menuType['price']);
            echo $menuHeader;
            echo '<td><input name="'.$menuType['id'].'" type="number" value="0" /></td>';
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
        <input type="submit" value="Order as Gift" class="btn btn-default" />
        </form>
    </div><!-- end of container-->

<?php $this->load->view('shared/footer') ?>