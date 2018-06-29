<div class="suggestion-search">
    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="form-inline">
        <fieldset>
            <div class="input-group">
                <input type="text" name="s" id="search" placeholder="<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_about_search'); ?>" value="<?php the_search_query(); ?>"
                       class="form-control" />
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default search-form-btn-loader"><i class="icon-search5"></i></button>
                </span>
            </div>
        </fieldset>
    </form>
</div>