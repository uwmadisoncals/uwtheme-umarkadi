<?php
/**
 * The template for displaying the footer.
 *
 * @package UW Theme
 */
?>

	<footer id="colophon" class="uw-footer">
		<div class="uw-footer-content">
			<div class="uw-logo">
				<a href="http://www.wisc.edu" aria-label="Link to main university website">
          <?php echo get_svg('uw-symbol-crest-footer', array("title"=>"University logo that links to main university website")); ?>
        </a>
			</div>
      <?php
        for ($i = 1; $i <= 2; $i++) {

          $uwmadison_footer_menu = wp_get_nav_menu_object( get_theme_mod("uwmadison_footer_menu_$i",null) );

          if ( $uwmadison_footer_menu ) { ?>
              <div>
                <h3 class="uw-footer-header"><?php echo $uwmadison_footer_menu->name ?></h3>
                <?php
                  wp_nav_menu(
                    array(
                      'menu'=>$uwmadison_footer_menu->term_id,
                      'menu_class'=>'',
                      'menu_id'=>'',
                      'container'=>null

                    )
                  );
                ?>
              </div>

        <?php } ?>
      <?php } ?>

			<?php echo uwmadison_footer_contact(); ?>
		</div>

    <?php get_template_part('content-parts/page-elements/footer', 'content'); ?>

		<div class="uw-copyright">
			<p>&copy; <?php echo date('Y'); ?> Board of Regents of the <a href="http://www.wisconsin.edu" title = "University of Wisconsin System" >University of Wisconsin System</a></p>
		</div>
	</footer>

  <?php wp_footer(); ?>
</body>
</html>

