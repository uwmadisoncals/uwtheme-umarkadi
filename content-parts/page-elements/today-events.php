<?php
$today_url = get_sub_field('todaywiscedu_url');
$count = get_sub_field('number_of_events');
$header = get_sub_field('header_text');

// Switch timezone temporarily
$wp_timezone = date_default_timezone_get();
date_default_timezone_set('America/Chicago');

if ( ! function_exists( 'my_uw_events_group_by' ) ) :
	/**
	 * Filter the date string to group events by month
	 *
	 * @return String PHP strftime format string (http://php.net/manual/en/function.strftime.php)
	 */
	function my_uw_events_group_by($group_by) {
		return "%B";
	}
	add_filter('uwmadison_events_group_by', 'my_uw_events_group_by');
endif;

// get our data
$event_feed = uwmadison_events_get_remote($today_url, array('limit' => (int)$count));

if (!empty($header))
	echo '<h2 class="uw-content-box-header">' . $header . '</h2>';

// loop through events; events will be grouped by month
if (!empty($event_feed->data)) {
	echo '<ul class="uw-events">';
	foreach ($event_feed->data['grouped'] as $month => $events) {
		if ( !empty($events) ) {
			echo '<li><span class="uw-event-month">' . $month . '</span>';
				echo '<ul class="uw-events">';

				foreach ($events as $event) {
					echo '<li class="uw-event">';

						// Windows doesn't have the strftime variable %e.
						// For more information see: http://php.net/manual/en/function.strftime.php
						if (preg_match('/^win/i', PHP_OS)) {
							echo '<div class="uw-event-date">' . strftime("<span class=\"show-for-sr\">%B</span> %#d",$event->start_timestamp) . '</div>';
						} else {
							echo '<div class="uw-event-date">' . strftime("<span class=\"show-for-sr\">%B</span> %e",$event->start_timestamp) . '</div>';
						}

						echo '<div class="uw-event-listing">';
							echo '<span class="uw-event-title"><a href="' . $event->link . '">' . $event->title . '</a></span>';

							if ( !empty($event->subtitle) )
								echo '<span class="uw-event-subtitle">' . $event->subtitle . '</span>';

							echo '<span class="uw-event-time">' . strftime("%l:%M %p",$event->start_timestamp) . '</span>';

							if ( !empty($event->location) ) {
								echo ', <span class="uw-event-location">';

								if ( !empty($event->uw_map_url))
									echo '<a href="' . $event->uw_map_url . '">';

								echo $event->location;

								if ( !empty($event->uw_map_url))
									echo '</a>';

								echo '</span>';
							}
						echo '</div>';
					echo '</li>';
				}

				echo '</ul>';
			echo '</li>';
		}
	}
	echo '</ul>';
	echo '<div><a class="uw-more-link" href="' . $today_url . '">More events ' . get_svg('uw-symbol-more') . '</a></div>';
} else {
	echo '<p>No events returned.</p>';
}

// revert timezone
date_default_timezone_set($wp_timezone);
