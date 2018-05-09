<nav id="menu">
    <div class="container">
        <div class="row">
            <?php
			wp_nav_menu( array(
				'theme_location' => 'ltm_menu_default',
				'container_class' => 'col',
				'menu_class'      => 'mn'
			) );
			?>
		</div>
    </div>
</nav>