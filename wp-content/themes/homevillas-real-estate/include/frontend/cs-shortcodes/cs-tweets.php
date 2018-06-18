<?php

/*
 *
 * @Shortcode Name :  Start function for Tweets shortcode/element front end view
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_tweets_shortcode') ) {

    function wp_rem_cs_var_tweets_shortcode($atts, $content = "") {
        $html = '';
        $page_element_size = isset($atts['tweets_element_size']) ? $atts['tweets_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }

        $defaults = array( 'column_size' => '',
            'wp_rem_cs_var_tweets_user_name' => 'default',
            'wp_rem_cs_var_tweets_color' => '',
            'wp_rem_cs_var_no_of_tweets' => '',
            'wp_rem_cs_var_tweets_class' => '',
            'wp_rem_api_consumer_key' => '',
            'wp_rem_api_consumer_secret_key' => '',
            'wp_rem_api_access_token_key' => '',
            'wp_rem_api_access_token_secret_key' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $column_class = wp_rem_cs_var_custom_column_class($column_size);

        $CustomId = '';
        if ( isset($wp_rem_cs_var_tweets_class) && $wp_rem_cs_var_tweets_class ) {
            $CustomId = 'id="' . wp_rem_cs_allow_special_char($wp_rem_cs_var_tweets_class) . '"';
        }
        $wp_rem_cs_var_tweets_color = isset($wp_rem_cs_var_tweets_color) ? $wp_rem_cs_var_tweets_color : '';
        $tweets_color = '';
        if ( isset($wp_rem_cs_var_tweets_color) && ! empty($wp_rem_cs_var_tweets_color) ) {
            $tweets_color = ' style="background-color:' . $wp_rem_cs_var_tweets_color . '"';
        }
        $wp_rem_api_consumer_key = isset($wp_rem_api_consumer_key) ? $wp_rem_api_consumer_key : '';
        $wp_rem_api_consumer_secret_key = isset($wp_rem_api_consumer_secret_key) ? $wp_rem_api_consumer_secret_key : '';
        $wp_rem_api_access_token_key = isset($wp_rem_api_access_token_key) ? $wp_rem_api_access_token_key : '';
        $wp_rem_api_access_token_secret_key = isset($wp_rem_api_access_token_secret_key) ? $wp_rem_api_access_token_secret_key : '';
        $wp_rem_cs_var_tweets_user_name = isset($wp_rem_cs_var_tweets_user_name) ? $wp_rem_cs_var_tweets_user_name : '';
        $api_array = array(
            'consumer_key' => $wp_rem_api_consumer_key,
            'consumer_secret_key' => $wp_rem_api_consumer_secret_key,
            'access_token' => $wp_rem_api_access_token_key,
            'access_token_secret' => $wp_rem_api_access_token_secret_key,
        );
        $html .= ' <div class="rem-twitter rem-tweet-slider" ' . $tweets_color . '>
                    <span class="tweet-bg"><i class="icon-twitter2"></i></span>
                    <div class="tweet-head">
                            <span><i class="icon-twitter2"></i>@' . $wp_rem_cs_var_tweets_user_name . '</span>
                         <div class="swiper-tweet-next"><i class="icon-reply"></i></div>
                        <div class="swiper-tweet-prev"><i class="icon-reply"></i></div>
                    </div>
                        <div class="swiper-container">
                            <div class="swiper-wrapper">';
        $html .= wp_rem_cs_get_tweets($wp_rem_cs_var_tweets_user_name, $wp_rem_cs_var_no_of_tweets, $wp_rem_cs_var_tweets_color, $api_array);
        $html . '</div>';
        $html .= '</div>
            </div>';
        $wp_rem_cs_inline_script = '
		jQuery(document).ready(function () {
                            if ("" != jQuery(".rem-tweet-slider").length) {
                                new Swiper(".rem-tweet-slider .swiper-container", {
                                    slidesPerView: 1,
                                    nextButton: ".swiper-tweet-next",
                                    prevButton: ".swiper-tweet-prev",
                                    spaceBetween: 30,
                                    autoplay: 3000,
                                    speed: 2000,
                                    
                                });
                            }
                        });';
        wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp_rem_cs-functions');
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '</div>';
        }
        return $html;
    }

    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('wp_rem_cs_tweets', 'wp_rem_cs_var_tweets_shortcode');
    }
}

/*
 *
 * @ Start function for Get Tweets through APi
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_get_tweets') ) {

    function wp_rem_cs_get_tweets($username, $numoftweets, $wp_rem_cs_tweets_color = '', $api_keys = '') {
        global $wp_rem_cs_var_options, $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $username = html_entity_decode($username);
        $numoftweets = $numoftweets;
        if ( $numoftweets == '' ) {
            $numoftweets = 2;
        }
        if ( class_exists('wp_rem_real_estate_framework') ) {


            if ( strlen($username) > 1 ) {
                $text = '';
                $return = '';
                $cacheTime = 10000;
                $transName = 'latest-tweets';
                wp_rem_cs_include_file(wp_rem_real_estate_framework::plugin_path() . '/includes/cs-twitter/twitteroauth.php');

                $consumerkey = isset($api_keys['consumer_key']) ? $api_keys['consumer_key'] : '';
                $consumersecret = isset($api_keys['consumer_secret_key']) ? $api_keys['consumer_secret_key'] : '';
                $accesstoken = isset($api_keys['access_token']) ? $api_keys['access_token'] : '';
                $accesstokensecret = isset($api_keys['access_token_secret']) ? $api_keys['access_token_secret'] : '';
                $connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
                $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $username . "&count=" . $numoftweets);
                if ( ! is_wp_error($tweets) and is_array($tweets) ) {
                    set_transient($transName, $tweets, 60 * $cacheTime);
                } else {
                    $tweets = get_transient('latest-tweets');
                }
                if ( ! is_wp_error($tweets) and is_array($tweets) ) {

                    $twitter_text_color = '';
                    if ( ! empty($wp_rem_cs_tweets_color) ) {
                        $twitter_text_color = "style='color: wp_rem_cs_allow_special_char($wp_rem_cs_tweets_color) !important'";
                    }
                    $rand_id = rand(11115, 300000);
                    $exclude = 0;
                    $return = '';
                    foreach ( $tweets as $tweet ) {
                        $exclude ++;
                        $text = $tweet->{'text'};
                        foreach ( $tweet->{'user'} as $type => $userentity ) {
                            if ( $type == 'profile_image_url' ) {
                                $profile_image_url = $userentity;
                            } else if ( $type == 'screen_name' ) {
                                $screen_name = '<a href="https://twitter.com/' . wp_rem_cs_allow_special_char($userentity) . '" target="_blank" class="colrhover" title="' . wp_rem_cs_allow_special_char($userentity) . '">@' . wp_rem_cs_allow_special_char($userentity) . '</a>';
                            }
                        }
                        foreach ( $tweet->{'entities'} as $type => $entity ) {
                            if ( $type == 'hashtags' ) {
                                foreach ( $entity as $j => $hashtag ) {
                                    $update_with = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&amp;src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
                                    $text = str_replace('#' . $hashtag->{'text'}, $update_with, $text);
                                }
                            }
                        }
                        $large_ts = time();
                        $n = $large_ts - strtotime($tweet->{'created_at'});
                        if ( $n < (60) ) {
                            $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_tweets_secongs_ago'), $n);
                        } elseif ( $n < (60 * 60) ) {
                            $minutes = round($n / 60);
                            $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_minute_ago'), $minutes);
                            if ( $minutes > 1 ) {
                                $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_minutes_ago'), $minutes);
                            }
                        } elseif ( $n < (60 * 60 * 16) ) {
                            $hours = round($n / (60 * 60));

                            $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_hour_ago'), $hours);
                            if ( $hours > 1 ) {
                                $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_hours_ago'), $hours);
                            }
                        } elseif ( $n < (60 * 60 * 24) ) {
                            $hours = round($n / (60 * 60));

                            $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_hour_ago'), $hours);
                            if ( $hours > 1 ) {
                                $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_hours_ago'), $hours);
                            }
                        } elseif ( $n < (60 * 60 * 24 * 6.5) ) {
                            $days = round($n / (60 * 60 * 24));

                            $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_day_ago'), $days);
                            if ( $days > 1 ) {
                                $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_days_ago'), $days);
                            }
                        } elseif ( $n < (60 * 60 * 24 * 7 * 3.5) ) {
                            $weeks = round($n / (60 * 60 * 24 * 7));

                            $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_week_ago'), $weeks);
                            if ( $weeks > 1 ) {
                                $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_weeks_ago'), $weeks);
                            }
                        } elseif ( $n < (60 * 60 * 24 * 7 * 4 * 11.5) ) {
                            $months = round($n / (60 * 60 * 24 * 7 * 4));

                            $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_month_ago'), $months);
                            if ( $months > 1 ) {
                                $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_months_ago'), $months);
                            }
                        } elseif ( $n >= (60 * 60 * 24 * 7 * 4 * 12) ) {
                            $years = round($n / (60 * 60 * 24 * 7 * 52));

                            $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_year_ago'), $years);
                            if ( $years > 1 ) {
                                $posted = sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tweets_years_ago'), $years);
                            }
                        }
                        $return .= '
                        <div class="swiper-slide">
                            <div class="text-holder"><span>' . $text . '</span> <span class="tweet-time"> ' . $posted . ' </span> </div>
                            
                        </div>';
                    }
                    return $return;
                } else {
                    if ( isset($tweets->errors[0]) && $tweets->errors[0] <> "" ) {
                        return '<div class="cs-twitter item" data-hash="dummy-one"><h4>' . $tweets->errors[0]->message . esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_valid_api')) . '</h4></div>';
                    } else {
                        return '<div class="cs-twitter item" data-hash="dummy-two"><h4>' . esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_tweets_found')) . '</h4></div>';
                    }
                }
            } else {
                return '<div class="cs-twitter item" data-hash="dummy-three"><h4>' . esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_tweets_found')) . '</h4></div>';
            }
        }
    }

}
