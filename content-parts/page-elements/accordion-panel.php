<ul class="accordion" data-accordion data-allow-all-closed="true">

<?php while ( have_rows('accordion_panel_group') ) : the_row(); ?>
	<li class="accordion-item" data-accordion-item>
		<a href="#" class="accordion-title"><?php echo get_sub_field('accordion_panel_title'); ?></a>

		<div class="accordion-content" data-tab-content>
			<?php echo get_sub_field('accordion_panel_body') ?>
		</div>
	</li>
<?php endwhile; ?>

</ul>


