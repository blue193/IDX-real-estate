<?php

/*
  pagination class_alias */

if (!class_exists('Wp_rem_Pagination')) {

    Class Wp_rem_Pagination {

        public function __construct() {
            add_action('wp_rem_pagination', array($this, 'wp_rem_pagination_callback'),11,1);
        }

        public function wp_rem_pagination_callback($args) {
             $total_posts='';
             $posts_per_page='5';
              $paging_var='paged_id';
              $show_pagination='yes';
            extract($args);
            if ($show_pagination <> 'yes') {
                return;
            } else if ($total_posts < $posts_per_page) {
                return;
            } else {
            if(!isset($_GET['page_id'])){
                $_GET['page_id']='';
            }
			$qrystr = '';

                $html = '';
                $dot_pre = '';

                $dot_more = '';

                $total_page = 0;
                if ($total_posts <> 0)
                    $total_page = ceil($total_posts / $posts_per_page);
                $paged_id = 1;
                if (isset($_GET[$paging_var]) && $_GET[$paging_var] != '') {
                    $paged_id = $_GET[$paging_var];
                }
                $loop_start = $paged_id - 2;

                $loop_end = $paged_id + 2;
 
                if ($paged_id < 3) {

                    $loop_start = 1;

                    if ($total_page < 5)
                        $loop_end = $total_page;
                    else
                        $loop_end = 5;
                }

                else if ($paged_id >= $total_page - 1) {

                    if ($total_page < 5)
                        $loop_start = 1;
                    else
                        $loop_start = $total_page - 4;

                    $loop_end = $total_page;
                }

                $html .= '<div class="page-nation"><ul class="pagination pagination-large">';
                if( $total_posts > $posts_per_page ){
                    if ($paged_id > 1) {
                        $html .= '<li><a href="?'.$paging_var.'=' . ($paged_id - 1) . $qrystr . '"  class="prev page-numbers">'. wp_rem_plugin_text_srt('wp_rem_pagination_prev') .' </a></li>';
                    } else {
                        $html .= '<li class="disabled"><span>'. wp_rem_plugin_text_srt('wp_rem_pagination_prev') .'</span></li>';
                    }
                }

                if ($paged_id > 3 and $total_page > 5)
                    $html .= '<li><a class="page-numbers" href="?'.$paging_var.'=1' . $qrystr . '">1</a></li>';

                if ($paged_id > 4 and $total_page > 6)
                    $html .= '<li><a>. . .</a><li>';

                if ($total_page > 1) {

                    for ($i = $loop_start; $i <= $loop_end; $i ++) {

                        if ($i <> $paged_id)
                            $html .= '<li><a class="page-numbers" href="?'.$paging_var.'=' . $i . $qrystr . '">' . $i . '</a></li>';
                        else
                            $html .= '<li><a class="page-numbers active">' . $i . '</a></li>';
                    }
                }
                if ($loop_end <> $total_page and $loop_end <> $total_page - 1) {
                    $html .= '<li><a>. . .</a></li>';
                }
                if ($loop_end <> $total_page) {
                    $html .= '<li><a href="?'.$paging_var.'=' . $total_page . '&' . $qrystr . '">' . $total_page . '</a></li>';
                }
                if( $total_posts > $posts_per_page ){
                    if ($total_posts > 0 and $paged_id < ($total_posts / $posts_per_page)) {
                        $html .= '<li><a class="next page-numbers" href="?'.$paging_var.'=' . ($paged_id + 1) . $qrystr . '" >'. wp_rem_plugin_text_srt('wp_rem_pagination_next') .'</a></li>';
                    } else {
                        $html .= '<li class="disabled"><span>'. wp_rem_plugin_text_srt('wp_rem_pagination_next') .'</span></li>';
                    }
                }
                $html .= "</ul></div>";
                echo force_balance_tags($html);
            }
        }

    }

    global $Wp_rem_Pagination;
    $Wp_rem_Pagination = new Wp_rem_Pagination();
}
?>