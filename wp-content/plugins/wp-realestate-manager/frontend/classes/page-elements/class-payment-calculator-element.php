<?php
/**
 * File Type: Payment Calculator Property Page Element
 */
if ( ! class_exists('wp_rem_payment_calculator_element') ) {

    class wp_rem_payment_calculator_element {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_rem_payment_calculator_html', array( $this, 'wp_rem_payment_calculator_html_callback' ), 11, 1);
        }

        public function wp_rem_payment_calculator_html_callback($property_id = '') {
            global $post, $wp_rem_form_fields_frontend, $wp_rem_plugin_options;
            wp_enqueue_script('wp_rem_piechart_frontend');
            $sidebar_calculator = isset($wp_rem_plugin_options['wp_rem_property_detail_page_sidebar_calculator']) ? $wp_rem_plugin_options['wp_rem_property_detail_page_sidebar_calculator'] : '';
            if ( $sidebar_calculator != 'on' ) {
                return;
            }


            $wp_rem_mortgage_static_text_block = isset($wp_rem_plugin_options['wp_rem_mortgage_static_text_block']) ? $wp_rem_plugin_options['wp_rem_mortgage_static_text_block'] : '';

            $wp_rem_mortgage_min_year = isset($wp_rem_plugin_options['wp_rem_mortgage_min_year']) && ! empty($wp_rem_plugin_options['wp_rem_mortgage_min_year']) ? $wp_rem_plugin_options['wp_rem_mortgage_min_year'] : '2';
            $wp_rem_mortgage_max_year = isset($wp_rem_plugin_options['wp_rem_mortgage_max_year']) && ! empty($wp_rem_plugin_options['wp_rem_mortgage_max_year']) ? $wp_rem_plugin_options['wp_rem_mortgage_max_year'] : '10';
            if ( $property_id == '' ) {
                $property_id = $post->ID;
            }
            if ( $property_id != '' ) {
                $wp_rem_property_price_options = get_post_meta($property_id, 'wp_rem_property_price_options', true);
                $wp_rem_property_price = '';
                if ( $wp_rem_property_price_options == 'price' ) {
                    $wp_rem_property_price = get_post_meta($property_id, 'wp_rem_property_price', true);
                } else if ( $wp_rem_property_price_options == 'on-call' ) {
                    $wp_rem_property_price = 0;
                } else if ( $wp_rem_property_price_options == 'none' ) {
                    $wp_rem_property_price = 0;
                }
                if ( ! is_numeric($wp_rem_property_price) ) {
                    $wp_rem_property_price = 0;
                }
                ?>
                <div class="widget widget-payment-sec pd0">
                    <h6><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_heading'); ?></h6>
                    <?php
                    $default_deposit_price = '';
                    if ( isset($wp_rem_property_price) && $wp_rem_property_price >= 0 ) {
                        $default_deposit_price = $wp_rem_property_price / 2;
                    }
                    $default_property_price = 0;
                    $default_deposit_pricee = 0;
                    $default_annual_int = 0;
                    $default_annual_min_year = 0;
                    $default_annual_max_year = 0;
                    if ( isset($wp_rem_property_price) && $wp_rem_property_price != '' && $wp_rem_property_price > 0 ) {
                        $default_property_price = $wp_rem_property_price;
                        $default_deposit_pricee = $default_deposit_price;
                        $default_annual_int = 10;
                        $default_annual_min_year = $wp_rem_mortgage_min_year;
                        $default_annual_max_year = $wp_rem_mortgage_max_year;
                    }
                    if ( isset($default_property_price) && $default_property_price == 0 ) {
                        ?>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                function get_data() {
                                    var out = [
                                        {"name": "", "hvalue": 100, "color": "#5a2e8a"},
                                    ]
                                    return out;
                                }
                                $("#chartContainer").donutpie({
                                    radius: 140,
                                    tooltip: false,
                                });
                                $("#chartContainer").donutpie('update', get_data());
                            });
                        </script>
                        <?php
                    }
                    ?>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            var price_pie = <?php echo esc_html($wp_rem_property_price); ?>;
                            var deposit_value = <?php echo esc_html($default_deposit_pricee); ?>;
                            var year_pie = <?php echo esc_html($default_annual_min_year); ?>;
                            var annual_interest = (price_pie * year_pie) / 100;
                            var total_interest = price_pie + annual_interest + deposit_value;
                            var price_percentage = ((price_pie / total_interest) * 100);
                            var deposite_percentage = ((deposit_value / total_interest) * 100);
                            var interest_percentage = ((annual_interest / total_interest) * 100);
                            function get_data() {
                                var out = [
                                    {"name": "price", "hvalue": price_percentage, "color": "#5a2e8a"},
                                    {"name": "deposit", "hvalue": deposite_percentage, "color": "#d64521"},
                                    {"name": "interest", "hvalue": interest_percentage, "color": "#555555"},
                                ]
                                return out;
                            }
                            doCalc();
                            $("#chartContainer").donutpie({
                                radius: 140,
                                tooltip: true,
                            });
                            $("#chartContainer").donutpie('update', get_data());
                        });
                    </script>
                    <div class="widget-payment-holder">
                        <script language="JavaScript">
                            function doCalc(button_loader)
                            {
                                var thisObj = jQuery('.get-btn');
                                if (button_loader != '' && button_loader != 'undefined' && button_loader != undefined && button_loader == 'show-loader-btn') {
                                    wp_rem_show_loader('.get-btn', '', 'button_loader', thisObj);
                                }
                                zeroBlanks(document.mortform);
                                var down_payment = numval(document.mortform.down_payment.value);
                                var p = numval(document.mortform.p.value);
                                p = p - down_payment;
                                var rate_of_interest = numval(document.mortform.r.value);
                                var r = (numval(document.mortform.r.value) / 100);
                                var y = numval(document.mortform.y.value);

                                setTimeout(function () {
                                    var total = formatNumber(mortgagePayment(p, r / 12, y * 12), 2);
                                    jQuery("#totoal_price").html(total + ' / <small><?php echo wp_rem_plugin_text_srt('wp_rem_mortgage_calculator_month'); ?></small>');
                                    if (total > 0) {
                                        jQuery("#demo-pie-1").attr("data-percent", parseInt(total));
                                        var price_pie = p;
                                        var deposit_value = down_payment;
                                        var annual_interest = (price_pie * y) / 100;
                                        var total_interest = price_pie + annual_interest + deposit_value;
                                        var price_percentage = ((price_pie / total_interest) * 100);
                                        var deposite_percentage = ((deposit_value / total_interest) * 100);
                                        var interest_percentage = ((annual_interest / total_interest) * 100);
                                        function get_data() {
                                            var out = [
                                                {"name": "price", "hvalue": price_percentage, "color": "#5a2e8a"},
                                                {"name": "deposit", "hvalue": deposite_percentage, "color": "#d64521"},
                                                {"name": "interest", "hvalue": interest_percentage, "color": "#555555"},
                                            ]
                                            return out;
                                        }
                                        $("#chartContainer").donutpie('update', get_data());
                                    }

                                }, 1000);

                                setTimeout(function () {
                                    wp_rem_show_response('', '', thisObj);
                                }, 500);

                            }
                            function zeroBlanks(formname)
                            {
                                var i, ctrl;
                                for (i = 0; i < formname.elements.length; i++)
                                {
                                    ctrl = formname.elements[i];
                                    if (ctrl.type == "text")
                                    {
                                        if (makeNumeric(ctrl.value) == "")
                                            ctrl.value = "0";
                                    }
                                }
                            }
                            function filterChars(s, charList)
                            {
                                var s1 = "" + s; // force s1 to be a string data type
                                var i;
                                for (i = 0; i < s1.length; )
                                {
                                    if (charList.indexOf(s1.charAt(i)) < 0)
                                        s1 = s1.substring(0, i) + s1.substring(i + 1, s1.length);
                                    else
                                        i++;
                                }
                                return s1;
                            }
                            function makeNumeric(s)
                            {
                                return filterChars(s, "1234567890.-");
                            }
                            function numval(val, digits, minval, maxval)
                            {
                                val = makeNumeric(val);
                                if (val == "" || isNaN(val))
                                    val = 0;
                                val = parseFloat(val);
                                if (digits != null)
                                {
                                    var dec = Math.pow(10, digits);
                                    val = (Math.round(val * dec)) / dec;
                                }
                                if (minval != null && val < minval)
                                    val = minval;
                                if (maxval != null && val > maxval)
                                    val = maxval;
                                return parseFloat(val);
                            }

                            function formatNumber(val, digits, minval, maxval)
                            {
                                var sval = "" + numval(val, digits, minval, maxval);
                                var i;
                                var iDecpt = sval.indexOf(".");
                                if (iDecpt < 0)
                                    iDecpt = sval.length;
                                if (digits != null && digits > 0)
                                {
                                    if (iDecpt == sval.length)
                                        sval = sval + ".";
                                    var places = sval.length - sval.indexOf(".") - 1;
                                    for (i = 0; i < digits - places; i++)
                                        sval = sval + "0";
                                }
                                var firstNumchar = 0;
                                if (sval.charAt(0) == "-")
                                    firstNumchar = 1;
                                for (i = iDecpt - 3; i > firstNumchar; i -= 3)
                                    sval = sval.substring(0, i) + "," + sval.substring(i);

                                return sval;
                            }
                            function mortgagePayment(p, r, y)
                            {
                                return futureValue(p, r, y) / geomSeries(1 + r, 0, y - 1);
                            }
                            function futureValue(p, r, y)
                            {
                                return p * Math.pow(1 + r, y);
                            }
                            function geomSeries(z, m, n)
                            {
                                var amt;
                                if (z == 1.0)
                                    amt = n + 1;
                                else
                                    amt = (Math.pow(z, n + 1) - 1) / (z - 1);
                                if (m >= 1)
                                    amt -= geomSeries(z, 0, m - 1);
                                return amt;
                            }
                        </script>
                        <form name="mortform" action="#" method="post">
                            <div class="progress-holder">
                                <div class="chartContainer-wrp">
                                    <div id="chartContainer" style="height: 102px; width: 100%;"></div>
                                </div>
                                <div class="text-holder">
                                    <span><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_your_payment'); ?></span>
                                    <span class="price" id="totoal_price"><?php echo force_balance_tags(wp_rem_get_currency($wp_rem_property_price, true)); ?> / <small><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_mo'); ?></small></span>
                                    <ul>
                                        <li><span style="background-color:#67237a;"></span><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_your_price'); ?></li>
                                        <li><span style="background-color:#d64521;"></span><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_your_deposit'); ?></li>
                                        <li><span style="background-color:#555555;"></span><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_your_interest'); ?></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="range-slider-holder">
                                <div class="range-slider">
                                    <label>
                                        <span class="title"><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_property_price'); ?></span>
                                    </label>
                                    <span id="#ex5SliderVal" class="price"><?php echo wp_rem_get_currency_sign(); ?><small class="slider-value"> <?php echo esc_html($default_property_price); ?></small></span>
                                    <?php
                                    $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                            array(
                                                'cust_name' => 'p',
                                                'cust_id' => 'ex2',
                                                'classes' => 'slider-field',
                                                'extra_atr' => 'onchange="javascript:doCalc()" data-slider-id="ex2Slider" data-slider-min="0" data-slider-step="1" data-slider-max="' . wp_rem_get_currency($wp_rem_property_price, false) . '"  data-slider-value="' . esc_html($wp_rem_property_price) . '" style="display:none;"',
                                            )
                                    );
                                    ?>  
                                </div>
                                <div class="range-slider">
                                    <label>
                                        <span class="title"><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_deposit'); ?></span>
                                    </label>
                                    <span id="#ex6SliderVal" class="price"><?php echo wp_rem_get_currency_sign(); ?><small class="slider-value"><?php echo esc_html($default_deposit_pricee); ?></small></span>
                                    <?php
                                    $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                            array(
                                                'cust_name' => 'down_payment',
                                                'cust_id' => 'ex3',
                                                'classes' => 'slider-field',
                                                'extra_atr' => 'onchange="javascript:doCalc()" data-slider-id="ex2Slider" data-slider-min="0" data-slider-step="1" style="display:none;" data-slider-max="' . wp_rem_get_currency($wp_rem_property_price, false) . '"  data-slider-value="' . esc_html($default_deposit_price) . '"',
                                            )
                                    );
                                    ?>  
                                </div>
                                <div class="range-slider">
                                    <label>
                                        <span class="title"><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_annual_interest'); ?></span>
                                    </label>
                                    <span id="#ex7SliderVal" class="price"><small class="slider-value"><?php echo esc_html($default_annual_int); ?></small>%</span>
                                    <?php
                                    $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                            array(
                                                'cust_name' => 'r',
                                                'cust_id' => 'ex4',
                                                'classes' => 'slider-field',
                                                'extra_atr' => 'onchange="javascript:doCalc()" data-slider-id="ex2Slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" style="display:none;" data-slider-value="' . esc_html($default_annual_int) . '"',
                                            )
                                    );
                                    ?>  
                                </div>
                                <div class="range-slider">
                                    <label>
                                        <span class="title"><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_year'); ?></span>
                                    </label>
                                    <span id="#ex8SliderVal" class="price"><small class="slider-value"><?php echo esc_html($default_annual_min_year); ?></small></span>
                                    <?php
                                    $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                            array(
                                                'cust_name' => 'y',
                                                'cust_id' => 'ex5',
                                                'classes' => 'slider-field',
                                                'extra_atr' => 'onchange="javascript:doCalc()" data-slider-id="ex2Slider" data-slider-min="' . esc_html($default_annual_min_year) . '" data-slider-max="' . esc_html($default_annual_max_year) . '" data-slider-step="1" data-slider-value="' . esc_html($default_annual_min_year) . '" style="display:none;"',
                                            )
                                    );
                                    ?>  
                                </div>
                            </div>
                            <a class="get-btn slider-field" onClick="javascript:doCalc('show-loader-btn');" href="javascript:void(0);"><?php echo wp_rem_plugin_text_srt('wp_rem_payment_calculator_get_loan_btn'); ?></a>
                        </form>

                        <?php
                        if ( isset($wp_rem_mortgage_static_text_block) && ! empty($wp_rem_mortgage_static_text_block) ) {
                            ?>
                            <p><?php echo htmlspecialchars_decode($wp_rem_mortgage_static_text_block); ?></p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }

    }

    global $wp_rem_payment_calculator;
    $wp_rem_payment_calculator = new wp_rem_payment_calculator_element();
}