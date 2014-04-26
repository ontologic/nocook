<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header">Manage</li>
                    <!--<li class="active"><a href="#">Link</a></li>-->
                    <?php
                        if($this->ion_auth->in_group('admin')){
                            echo '<li><a href="'.base_url().'dash/restaurants">Sales</a></li>';
                            echo '<li><a href="'.base_url().'dash/restaurants">Edit/Delete Orders</a></li>';
                            echo '<li><a href="'.base_url().'dash/restaurant/index">Restaurants</a></li>';
                        } else if($this->ion_auth->in_group('Operator')){
                            echo '<li><a href="dash/restaurants">Menu</a></li>';
                        } else if($this->ion_auth->in_group('Manager')){
                            echo '<li><a href="dash/restaurants">Menu</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="span9">