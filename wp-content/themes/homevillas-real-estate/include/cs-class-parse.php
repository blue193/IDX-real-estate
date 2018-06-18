<?php

/**
 * A simple parser that allows you to Convert  wordpress shortcode  to multidimentional array.
 * * The Shortcode API (new in 2.4) is a simple regex based parser that allows you to replace simple wordpress shortcode like tags within a HTMLText or HTMLVarchar field when rendered into a template. It is inspired by and very similar to the [Wordpress implementation](http://codex.wordpress.org/Shortcode_API) of shortcodes. Examples of shortcode tags are:
 * 
 * <code>
 *     [shortcode]
 *     [shortcode /]
 *     [shortcode parameter="value"]
 *     [shortcode parameter="value"]Enclosed Content[/shortcode]
 * </code>
 * Example : Note : define your Prefix (like tabs || tab_item ) in pattren. (ref. wp_rem_cs_get_pattern())
 *  $text = '[tabs animation="fadeIn" size="1/2"]
 *  [tab_item color="#CCCCCC" icon="fa-user"]Tab 1 contents[/tab_item]
 *  [tab_item color="#CCCCCC" icon="fa-login"]Tab 2 contents[/tab_item]
 *  [/tabs]';
 * 	$Output = array();
 *  $PREFIX = 'prefix'; //user prefix as wp_rem_cs_message OR wp_rem_cs_tabs | tab_item
 * 	$parseInstance 	= new ShortcodeParse();
 * 	$output = $b->wp_rem_cs_shortcodes( $output, $text );
 * 	echo '<pre>';
 * 	var_dump( array_values( $output ) );
 *  echo '</pre>';
 */
if (!class_exists('ShortcodeParse')) {

    class ShortcodeParse {

        // start function to construct shortcode
        function __construct() {
            # code...
        }

        //Start function to get content pattern 
        
        function wp_rem_cs_get_pattern($content, $PREFIX) {
            $pattern = '\[(\[?)(' . $PREFIX . ')(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
            preg_match_all("/$pattern/s", $content, $matches);
            return $matches;
        }

        // Start function to parse atts content
        function wp_rem_cs_parse_atts($content) {
            $pattern = get_shortcode_regex();
            $content = preg_match_all('/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/', trim($content), $c);
            list( $dummy, $keys, $values ) = array_values($c);
            $c = array();
            foreach ($keys as $key => $value) {
                $value = trim($values[$key], "\"'");
                $c[$keys[$key]] = $value;
            }
            return $c;
        }

        // Start function to get content and output 
        function wp_rem_cs_shortcodes(&$output, $content, $child = true, $PREFIX) {
            $patts = $this->wp_rem_cs_get_pattern($content, $PREFIX);
            $t = array_filter($this->wp_rem_cs_get_pattern($content, $PREFIX));
            if (!empty($t)) {
                list( $d, $d, $parents, $atts, $d, $contents ) = $patts;
                $outputNew = array();
                $n = 0;
                foreach ($parents as $k => $parent) {
                    ++$n;
                    $name = $child ? 'child' . $n : $n;
                    $t = array_filter($this->wp_rem_cs_get_pattern($contents[$k], $PREFIX));
                    $t_s = $this->wp_rem_cs_shortcodes($outputNew, $contents[$k], true, $PREFIX);
                    $output[$name] = array('name' => $parents[$k]);
                    $output[$name]['atts'] = $this->wp_rem_cs_parse_atts($atts[$k]);
                    $output[$name]['original_content'] = $contents[$k];
                    $output[$name]['content'] = !empty($t) && !empty($t_s) ? $t_s : $contents[$k];
                }
            }
            return array_values($output);
        }

    }

}