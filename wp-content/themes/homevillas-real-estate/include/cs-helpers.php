<?php

/**
 * Core Helper Functions of Framework
 *
 * @return
 * @package wp_rem_cs-framework
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!function_exists('is_set')) {
	/**
     * Check if a variable/index is set, return it if exists else default.
     *
     * @param	mixed $var
     * @param	string	$default
     * @return	mixed
     */
    function is_set(&$var, $default = null) {
        return isset($var) ? $var : $default;
    }
}

if (!function_exists('wp_rem_cs_server_protocol')) {
	/**
     * Return whether request is on SSL or not. Return protocol.
     *
     * @return string
     */
    function wp_rem_cs_server_protocol() {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            return 'https://';
        }
        return 'http://';
    }

}

if (!function_exists('wp_rem_cs_get_input')) {
	/**
     * Return an input variable from $_REQUEST if exists else default.
     *
     * @param	string $name name of the variable.
     * @param string $default default value.
     * @param string $filter
     * @return string
     */
    function wp_rem_cs_get_input($name, $default = null, $filter = 'cmd') {
        if (isset($_REQUEST[$name])) {
            return wp_rem_cs_input_clean($_REQUEST[$name], $filter);
        }
        return $default;
    }
}


if (!function_exists('wp_rem_cs_get_server')) {

    /**
     * Return an input variable from $_SERVER if exists else default.
     *
     * @param	string $name name of the variable.
     * @param string $default default value.
     * @return string
     */
    function wp_rem_cs_get_server($name, $default = null) {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : $default;
    }

}

if (!function_exists('wp_rem_cs_get_all_server')) {

    /**
     * Return an input variable from $_SERVER
     *
     * @return string
     */
    function wp_rem_cs_get_all_server() {
        return $_SERVER;
    }
}

if (!function_exists('wp_rem_cs_get_cookie')) {

    /**
     * Return an input variable from $_COOKIE if exists else default.
     *
     * @param	string $name name of the variable.
     * @param string $default default value.
     * @return string
     */
    function wp_rem_cs_get_cookie($name, $default = null) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
    }
}

if (!function_exists('wp_rem_cs_get_all_request')) {

    /**
     * Return an input variable from $_REQUEST
     *
     * @return string
     */
    function wp_rem_cs_get_all_request() {
        return $_REQUEST;
    }
}

if (!function_exists('wp_rem_cs_get_all_cookie')) {

    /**
     * Return an input variable from $_COOKIE
     *
     * @return string
     */
    function wp_rem_cs_get_all_cookie() {
        return $_COOKIE;
    }
}

if (!function_exists('wp_rem_cs_input_clean')) {
	/**
     * Clean given string by applying requested filter.
     *
     * @param   mixed   $source  Input string/array-of-string to be 'cleaned'
     * @param   string  $type    Return type for the variable (INT, UINT, FLOAT, BOOLEAN, WORD, ALNUM, CMD, BASE64, STRING, ARRAY, PATH, NONE)
     *
     * @return  mixed  'Cleaned' version of input parameter
     */
    function wp_rem_cs_input_clean($source, $type = 'string') {
        // Handle the type constraint
        switch (strtoupper($type)) {
            case 'INT':
            case 'INTEGER':
                // Only use the first integer value.
                preg_match('/-?[0-9]+/', (string) $source, $matches);
                $result = @ (int) $matches[0];
                break;

            case 'UINT':
                // Only use the first integer value.
                preg_match('/-?[0-9]+/', (string) $source, $matches);
                $result = @ abs((int) $matches[0]);
                break;

            case 'FLOAT':
            case 'DOUBLE':
                // Only use the first floating point value.
                preg_match('/-?[0-9]+(\.[0-9]+)?/', (string) $source, $matches);
                $result = @ (float) $matches[0];
                break;

            case 'BOOL':
            case 'BOOLEAN':
                $result = (bool) $source;
                break;

            case 'WORD':
                $result = (string) preg_replace('/[^A-Z_]/i', '', $source);
                break;

            case 'ALNUM':
                $result = (string) preg_replace('/[^A-Z0-9]/i', '', $source);
                break;

            case 'CMD':
                $result = (string) preg_replace('/[^A-Z0-9_\.-]/i', '', $source);
                $result = ltrim($result, '.');
                break;

            case 'BASE64':
                $result = (string) preg_replace('/[^A-Z0-9\/+=]/i', '', $source);
                break;

            case 'STRING':
                $result = (string) esc_html(wp_rem_cs_decode_str((string) $source));
                break;

            case 'HTML':
                $result = (string) $source;
                break;

            case 'ARRAY':
                $result = (array) $source;
                break;

            case 'PATH':
                $pattern = '/^[A-Za-z0-9_-]+[A-Za-z0-9_\.-]*([\\\\\/][A-Za-z0-9_-]+[A-Za-z0-9_\.-]*)*$/';
                preg_match($pattern, (string) $source, $matches);
                $result = @ (string) $matches[0];
                break;

            case 'USERNAME':
                $result = (string) preg_replace('/[\x00-\x1F\x7F<>"\'%&]/', '', $source);
                break;

            default:
                // Are we dealing with an array?
                if (is_array($source)) {
                    foreach ($source as $key => $value) {
                        // filter element for XSS and other 'bad' code etc.
                        if (is_string($value)) {
                            $source[$key] = esc_html(wp_rem_cs_decode_str($value));
                        }
                    }
                    $result = $source;
                } else {
                    // Or a string?
                    if (is_string($source) && !empty($source)) {
                        // filter source for XSS and other 'bad' code etc.
                        $result = esc_html(wp_rem_cs_decode_str($source));
                    } else {
                        // Not an array or string.. return the passed parameter.
                        $result = $source;
                    }
                }
                break;
        }

        return $result;
    }
}

if (!function_exists('wp_rem_cs_decode_str')) {
	/**
     * Try to convert to plaintext
     *
     * @param   string  $source  The source string.
     * @return  string  Plaintext string
     */
    function wp_rem_cs_decode_str($source) {
        static $ttr;

        if (!is_array($ttr)) {
            // Entity decode.
            $trans_tbl = get_html_translation_table(HTML_ENTITIES);
            foreach ($trans_tbl as $k => $v) {
                $ttr[$v] = utf8_encode($k);
            }
        }
        $source = strtr($source, $ttr);
        // Convert decimal.
        $source = preg_replace('/&#(\d+);/me', "utf8_encode(chr(\\1))", $source); // Decimal notation.
        // Convert hex.
        $source = preg_replace('/&#x([a-f0-9]+);/mei', "utf8_encode(chr(0x\\1))", $source); // Hex notation.
        return $source;
    }
}

if (!function_exists('wp_rem_cs_dbg')) {
	/**
     * Used for debugging, output given data to browser console.
     *
     * @param  mixed  $data		The data to be debugged.
     * @param  string $label	The label to shown with debugged data.
     */
    function wp_rem_cs_dbg($data, $label = '') {
        if ('' === $label) {
            $key = array_search(__FUNCTION__, array_column(debug_backtrace(), 'wp_rem_cs_dbg'));
            $label = 'Debuged from \'' . basename(debug_backtrace()[$key]['file']) . '\'';
        }
        $data = var_export($data, true);
        $data = explode("\n", $data); // Plz don't remove double quotes arround newline character.
        $output = '';
        foreach ($data as $line) {
            if (trim($line)) {
                $line = addslashes($line);
                $output .= 'console.log( " ' . $line . '" );';
            }
        }
        echo '<script>console.log( "' . $label . ': "); ' . $output . ' </script>';
    }
}
