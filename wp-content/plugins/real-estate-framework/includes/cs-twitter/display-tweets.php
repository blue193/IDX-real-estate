<?php
/**
 * Get twitter authentication.
 *
 * @param string $id twitter username.
 * @param number $max_tweets number of tweets.
 */
function get_auth( $id, $max_tweets ) {
	global $wp_rem_cs_twitter_arg;
	$include_rts = true; // include retweets is set to true by default, if you don't want to include retweets set this to false.
	$exclude_replies = true; // Replies are not displayed by default.  If you wish to change this set this to false.
	$consumer_key = $wp_rem_cs_twitter_arg['consumerkey'];
	$consumer_secret = $wp_rem_cs_twitter_arg['consumersecret'];
	$user_token = $wp_rem_cs_twitter_arg['accesstoken'];
	$user_secret = $wp_rem_cs_twitter_arg['accesstokensecret'];

	require_once 'includes/tmhOAuth.php';

	$tmhOAuth = new tmhOAuth( array(
		'consumer_key' => $consumer_key,
		'consumer_secret' => $consumer_secret,
		'user_token' => $user_token,
		'user_secret' => $user_secret
	) );
	$twitter_settings_arr = array(
		'count' => $max_tweets,
		'screen_name' => $id,
		'include_rts' => $include_rts,
		'exclude_replies' => $exclude_replies,
	);

	$code = $tmhOAuth->request( 'GET', $tmhOAuth->url( '1.1/statuses/user_timeline' ), $twitter_settings_arr );

	$res_code = array(
		'200',
		'304',
	);
	if ( in_array( $code, $res_code ) ) {
		$data = $tmhOAuth->response['response'];
		return $data;
	} else {
		return $data = '500';
	}
}
/**
 * Twitter Cache.
 *
 * @param string $id twitter username.
 * @param number $max_tweets number of tweets.
 * @param number $time cache time.
 */
function cache_json( $id, $max_tweets, $time ) {
	$cache_dir = plugin_dir_path( __FILE__ ) . 'cache/';
	$cache = $cache_dir . $id . '.json'; // Twitter cache wp_rem_cs.
	$cache_folder = $cache_dir; // Twitter cache wp_rem_cs.
	if ( ! file_exists( $cache ) ) {
		if ( ! file_exists( $cache_folder ) ) {
			$cache_dir = mkdir( $cache_folder );
			$cache_data = true;
		}
		if ( ! file_exists( $cache ) ) {
			$cache_data = true;
		}
	} else {
		$cache_time = time() - filemtime( $cache );
		if ( $cache_time > 60 * $time ) {
			$cache_data = true;
		}
	}
	$tweets = '';

	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once ( ABSPATH . '/wp-admin/includes/file.php' );
		WP_Filesystem();
	}

	if ( isset( $cache_data ) ) {
		$data = get_auth( $id, $max_tweets );
		if ( $data != '500' ) {
			$cached = $wp_filesystem->put_contents( $cache, $data );
		}
	}
	$tweets = json_decode( $wp_filesystem->get_contents( $cache ), true );

	return $tweets;
}
/**
 * Date Difference.
 *
 * @param number $time1 Today time.
 * @param number $time2 Tweet publication time.
 * @param number $precision number of day/days precision.
 */
function dateDiff( $time1, $time2, $precision = 6 ) {
	if ( ! is_int( $time1 ) ) {
		$time1 = strtotime( $time1 );
	}
	if ( ! is_int( $time2 ) ) {
		$time2 = strtotime( $time2 );
	}
	if ( $time1 > $time2 ) {
		$ttime = $time1;
		$time1 = $time2;
		$time2 = $ttime;
	}
	$intervals = array(
		'year',
		'month',
		'day',
		'hour',
		'minute',
		'second'
	);
	$diffs = array();
	foreach ( $intervals as $interval ) {
		$diffs[ $interval ] = 0;
		$ttime = strtotime( '+1 ' . $interval, $time1 );
		while ( $time2 >= $ttime ) {
			$time1 = $ttime;
			$diffs[ $interval ] ++;
			$ttime = strtotime( '+1'  . $interval, $time1 );
		}
	}
	$count = 0;
	$times = array();
	foreach ( $diffs as $interval => $value ) {
		if ( $count >= $precision ) {
			break;
		}
		if ( $value > 0 ) {
			if ( 1 !== intval( $value ) ) {
				$interval .= 's';
			}
			$times[] = $value . ' ' . $interval;
			$count ++;
		}
	}
	return implode( ', ', $times );
}
/**
 * Display tweets.
 *
 * @param string $id Twitter username.
 * @param string $style Tweet date time format.
 * @param number $max_tweets number of tweets.
 * @param number $max_cache_tweets cache time.
 * @param number $time tweets time.
 */
function display_tweets( $id, $style = '', $max_tweets = 10, $max_cache_tweets = 10, $time = 60 ) {
	global $wp_rem_cs_var_frame_static_text;
	$tweets = cache_json( $id, $max_tweets, $time );
	$twitter = '';

	$twitter .= '<ul>';
	if ( ! empty( $tweets ) ) {
		$tweet_flag = 1;
		foreach ( $tweets as $tweet ) {
			$pub_date = $tweet['created_at'];
			$tweet = $tweet['text'];
			$today = time();
			$time = substr( $pub_date, 11, 5 );
			$day = substr( $pub_date, 0, 3 );
			$date = substr( $pub_date, 7, 4 );
			$month = substr( $pub_date, 4, 3 );
			$year = substr( $pub_date, 25, 5 );
			$english_suffix = date( 'jS', strtotime( preg_replace( '/\s+/', ' ', $pub_date ) ) );
			$full_month = date( 'F', strtotime( $pub_date ) );

			// pre-defined tags.
			$default = $full_month . $date . $year;
			$full_date = $day . $date . $month . $year;
			$ddmmyy = $date . $month . $year;
			$mmyy = $month . $year;
			$mmddyy = $month . $date . $year;
			$ddmm = $date . $month;

			// Time difference.
			$time_diff = dateDiff( $today, $pub_date, 1 );

			// Turn URLs into links.
			$tweet = preg_replace( '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\./-]*(\?\S+)?)?)?)@', '<a target="blank" title="$1" href="$1">$1</a>', $tweet );

			// Turn hashtags into links.
			$tweet = preg_replace( '/#([0-9a-zA-Z_-]+)/', "<a target='blank' title='$1' href=\"http://twitter.com/search?q=%23$1\">#$1</a>", $tweet );

			// Turn @replies into links.
			$tweet = preg_replace( "/@([0-9a-zA-Z_-]+)/", "<a target='blank' title='$1' href=\"http://twitter.com/$1\">@$1</a>", $tweet );

			$twitter .= '<li>';
			$twitter .= '<i class="icon-twitter2"></i>';
			if ( isset( $style ) ) {
				if ( ! empty( $style ) ) {
					$when = ( 'time_since' === $style ) ? '' : esc_html( wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_tweets_time_on' ) );
					$twitter .= '<span>' . $when . '&nbsp;';

					switch ( $style ) {
						case 'eng_suff':
						{
							$twitter .= $english_suffix . '&nbsp;' . $full_month;
						}
						break;
						case 'time_since';
						{
							$twitter .= $time_diff . '&nbsp;ago';
						}
						break;
						case 'ddmmyy';
						{
							$twitter .= $ddmmyy;
						}
						break;
						case 'ddmm';
						{
							$twitter .= $ddmm;
						}
						break;
						case 'full_date';
						{
							$twitter .= $full_date;
						}
						break;
						case 'default';
						{
							$twitter .= $default;
						}
						} // end switch statement.
						$twitter .= '</span>'; // end of List.
				}
			}
			$twitter .= '<p>' . $tweet . '</p>';
			$twitter .= "</li>\n";
			if ( $max_cache_tweets <= $tweet_flag ) {
				break;
			}
			$tweet_flag ++;
		} //end of foreach.
	} else {
		$twitter .= '<li>' . esc_html( wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_no_tweets_found' ) ) . '</li>';
	} //end if statement.
	$twitter .= '</ul>'; // end of Unordered list (Notice it's after the foreach loop!).
	echo $twitter;
}

