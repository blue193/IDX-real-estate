<?php
/**
 * Helpers for Property Alert Notifications
 *
 * @package	Homevillas
 */
// Direct access not allowed.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * WP_Property_Hunt_Alert_Helpers class.
 */
class WP_Property_Hunt_Alert_Helpers {

    public static function get_script_str() {
        ob_start();
       
        ?>
            (function ($) {
                $(function () {
                    $(".delete-property-alert a").click(function () {
                        var post_id = $(this).data("post-id");
                        var thisObj = jQuery(this);
                        var loader_class = 'icon-spinner icon-spin';
                        $('#id_confrmdiv').show();
                        $('#id_truebtn').click(function () {
                            var dataString = 'post_id=' + post_id + '&action=wp_rem_remove_property_alert';
                            thisObj.find('i').removeClass('icon-close');
                            thisObj.find('i').addClass(loader_class);
                            jQuery.ajax({
                                type: "POST",
                                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                data: dataString,
                                dataType: "JSON",
                                success: function (response) {
                                    if (response.status == 0) {
                                        thisObj.find('i').removeClass(loader_class);
                                        show_alert_msg(response.msg);
                                    } else {
                                        thisObj.find('i').removeClass(loader_class);
                                        thisObj.closest('li').hide('slow');
                                        var msg_obj = {msg: 'Deleted Successfully.', type: 'success'};
                                        wp_rem_show_response(msg_obj);
                                    }
                                }
                            });
                            $('#id_confrmdiv').hide();
                            return false;
                        });
                        $('#id_falsebtn').click(function () {
                            $('#id_confrmdiv').hide();
                            return false;
                        });
                        return false;
                    });
                });
            })(jQuery);
            <?php
            return ob_get_clean();
        }

        public static function query_to_array($query) {
            $qrystr_arr = getMultipleParameters($query);
            $arr = array();

            foreach ($qrystr_arr as $qry_var => $qry_val) {
                if ($qry_val != '') {
                    if (!is_array($qry_val))
                        if (strpos($qry_val, ',') !== FALSE) {
                            $qry_val = explode(",", $qry_val);
                        }
                    if (is_array($qry_val)) {
                        foreach ($qry_val as $qry_val_var => $qry_val_value) {
                            if ($qry_val_value != '') {
                                $qrystr1 = str_replace("&" . $qry_var . '[]=' . $qry_val_value, "", $qry_val_value);
                                $qrystr1 = str_replace("&" . $qry_var . '=' . $qry_val_value, "", $qry_val_value);
                                $arr[$qry_var] = str_replace("+", " ", $qry_val_value);
                            }
                        }
                    } else {
                        $arr[$qry_var] = str_replace("+", " ", $qry_val);
                    }
                }
            }
            $arr = array_filter($arr, function ( $elem ) {
                $extra = array("200", "Find Property");
                return !in_array($elem, $extra);
            });
            //return implode(',', $arr);
            return $arr;
        }

    }
    