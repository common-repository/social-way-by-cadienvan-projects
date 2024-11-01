<?php
function social_way_plugin_admin(){
    add_options_page("Social Way Plugin", "Social Way Plugin", "manage_options", "social-way-plugin", "social_way_admin_page");
    $page = add_menu_page("Social Way Plugin", "Social Way Plugin", "manage_options", "social-way-plugin", "social_way_admin_page", plugin_dir_url( __FILE__ )."icon.png", 105);

    add_action( 'admin_print_styles-' . $page, 'social_way_plugin_admin_styles' );
    add_action( 'admin_print_scripts-' . $page, 'social_way_plugin_admin_scripts' );
    add_action( 'wp_ajax_save_edits', 'socialwaysaveedits' );
}

function socialwaysaveedits() {
    global $wpdb;
    if(IsSet($_POST['edit'])){
        if(empty($_POST['page_list'])) $_POST['page_list'] = array();
        if(empty($_POST['btn_list'])) $_POST['btn_list'] = array();
        if(empty($_POST['widget_list'])) $_POST['widget_list'] = array();

        //Insert pages
        $sql = $wpdb->prepare("DELETE FROM ".SOCIAL_WAY_TABLE_NAME."_pages");
        $wpdb->query($sql);
        $q = "INSERT INTO ".SOCIAL_WAY_TABLE_NAME."_pages VALUES ";
        foreach($_POST['page_list'] AS $k=>$v)
            $q .= "('".$v."'),";
        $q = substr($q, 0, strlen($q)-1);
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta ( $q );


        //Insert Buttons
        $sql = $wpdb->prepare("DELETE FROM ".SOCIAL_WAY_TABLE_NAME."_btn");
        $wpdb->query($sql);
        $q = "INSERT INTO ".SOCIAL_WAY_TABLE_NAME."_btn VALUES ";
        foreach($_POST['btn_list'] AS $k=>$v)
            $q .= "('".$v."'),";
        $q = substr($q, 0, strlen($q)-1);
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta ( $q );


        //Insert Widget Buttons
        $sql = $wpdb->prepare("DELETE FROM ".SOCIAL_WAY_TABLE_NAME."_widget");
        $wpdb->query($sql);
        $q = "INSERT INTO ".SOCIAL_WAY_TABLE_NAME."_widget VALUES ";
        foreach($_POST['widget_list'] AS $k=>$v)
            $q .= "('".$v."'),";
        $q = substr($q, 0, strlen($q)-1);
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta ( $q );



        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => (!empty($_POST['all_pages'])) ? "1" : "0"),
            array('field' => 'auto_pages'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => (!empty($_POST['all_posts'])) ? "1" : "0"),
            array('field' => 'auto_posts'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pos']),
            array('field' => 'position'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['lang']),
            array('field' => 'lang'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['fb_l']),
            array('field' => 'fb_like_url'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['fb_f']),
            array('field' => 'fb_follow_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tw_via']),
            array('field' => 'twitter_via'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tw_follow']),
            array('field' => 'twitter_follow'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tw_hash']),
            array('field' => 'twitter_hashtag'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tw_ment']),
            array('field' => 'twitter_mention'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['in_comp']),
            array('field' => 'linkedin_company_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['in_compn']),
            array('field' => 'linkedin_company_name'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['in_pub']),
            array('field' => 'linkedin_public_profile'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['gp_id']),
            array('field' => 'google_plus_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['gp_page']),
            array('field' => 'google_plus_page_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['gp_comm']),
            array('field' => 'google_plus_community_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pin_prof']),
            array('field' => 'pinterest_profile'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pin_img']),
            array('field' => 'pinterest_img'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pin_id']),
            array('field' => 'pinterest_pin_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pin_board']),
            array('field' => 'pinterest_board'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['askfm_user']),
            array('field' => 'askfm_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['lastfm_apikey']),
            array('field' => 'lastfm_apikey'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['lastfm_location']),
            array('field' => 'lastfm_location'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['youtube_vid']),
            array('field' => 'youtube_vid'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['youtube_user']),
            array('field' => 'youtube_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tumblr_user']),
            array('field' => 'tumblr_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['skype_user']),
            array('field' => 'skype_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['vimeo_user']),
            array('field' => 'vimeo_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['steam_apikey']),
            array('field' => 'steam_apikey'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['steam_user']),
            array('field' => 'steam_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['steam_userid']),
            array('field' => 'steam_userid'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['fb_post']),
            array('field' => 'fb_post'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['fb_page']),
            array('field' => 'fb_page'),
            array('%s'),
            array('%s')
        );

    }
    $list = array();
    $btns = array();
    $list_q = $wpdb->get_results("SELECT page_id FROM ".SOCIAL_WAY_TABLE_NAME."_pages");
    foreach($list_q AS $l)
        $list[] = $l->page_id;
    $btn_q = $wpdb->get_results("SELECT btn FROM ".SOCIAL_WAY_TABLE_NAME."_btn");
    foreach($btn_q AS $b)
        $btns[] = $b->btn;

    $widget_q = $wpdb->get_results("SELECT btn FROM ".SOCIAL_WAY_TABLE_NAME."_widget");
    foreach($widget_q AS $w)
        $widget[] = $w->btn;
}

function social_way_plugin_admin_styles(){
    wp_enqueue_style( 'socialwaystylesheet' );
}

function social_way_plugin_admin_scripts(){
    wp_enqueue_script( 'socialwayscript' );
}

function social_way_plugin_admin_init(){
    wp_register_style( 'socialwaystylesheet', plugins_url('style.css', __FILE__) );
    wp_register_script( 'socialwayscript', plugins_url('script.js', __FILE__) );

}
function social_way_admin_page(){
    global $wpdb;
    if(IsSet($_POST['edit'])){
        if(empty($_POST['page_list'])) $_POST['page_list'] = array();
        if(empty($_POST['btn_list'])) $_POST['btn_list'] = array();
        if(empty($_POST['widget_list'])) $_POST['widget_list'] = array();

        //Insert pages
        $sql = $wpdb->prepare("DELETE FROM ".SOCIAL_WAY_TABLE_NAME."_pages");
        $wpdb->query($sql);
        $q = "INSERT INTO ".SOCIAL_WAY_TABLE_NAME."_pages VALUES ";
        foreach($_POST['page_list'] AS $k=>$v)
            $q .= "('".$v."'),";
        $q = substr($q, 0, strlen($q)-1);
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta ( $q );


        //Insert Buttons
        $sql = $wpdb->prepare("DELETE FROM ".SOCIAL_WAY_TABLE_NAME."_btn");
        $wpdb->query($sql);
        $q = "INSERT INTO ".SOCIAL_WAY_TABLE_NAME."_btn VALUES ";
        foreach($_POST['btn_list'] AS $k=>$v)
            $q .= "('".$v."'),";
        $q = substr($q, 0, strlen($q)-1);
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta ( $q );


        //Insert Widget Buttons
        $sql = $wpdb->prepare("DELETE FROM ".SOCIAL_WAY_TABLE_NAME."_widget");
        $wpdb->query($sql);
        $q = "INSERT INTO ".SOCIAL_WAY_TABLE_NAME."_widget VALUES ";
        foreach($_POST['widget_list'] AS $k=>$v)
            $q .= "('".$v."'),";
        $q = substr($q, 0, strlen($q)-1);
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta ( $q );



        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => (!empty($_POST['all_pages'])) ? "1" : "0"),
            array('field' => 'auto_pages'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => (!empty($_POST['all_posts'])) ? "1" : "0"),
            array('field' => 'auto_posts'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pos']),
            array('field' => 'position'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['lang']),
            array('field' => 'lang'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['fb_l']),
            array('field' => 'fb_like_url'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['fb_f']),
            array('field' => 'fb_follow_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tw_via']),
            array('field' => 'twitter_via'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tw_follow']),
            array('field' => 'twitter_follow'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tw_hash']),
            array('field' => 'twitter_hashtag'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tw_ment']),
            array('field' => 'twitter_mention'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['in_comp']),
            array('field' => 'linkedin_company_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['in_compn']),
            array('field' => 'linkedin_company_name'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['in_pub']),
            array('field' => 'linkedin_public_profile'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['gp_id']),
            array('field' => 'google_plus_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['gp_page']),
            array('field' => 'google_plus_page_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['gp_comm']),
            array('field' => 'google_plus_community_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pin_prof']),
            array('field' => 'pinterest_profile'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pin_img']),
            array('field' => 'pinterest_img'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pin_id']),
            array('field' => 'pinterest_pin_id'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['pin_board']),
            array('field' => 'pinterest_board'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['askfm_user']),
            array('field' => 'askfm_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['lastfm_apikey']),
            array('field' => 'lastfm_apikey'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['lastfm_location']),
            array('field' => 'lastfm_location'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['youtube_vid']),
            array('field' => 'youtube_vid'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['youtube_user']),
            array('field' => 'youtube_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['tumblr_user']),
            array('field' => 'tumblr_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['skype_user']),
            array('field' => 'skype_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['vimeo_user']),
            array('field' => 'vimeo_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['steam_apikey']),
            array('field' => 'steam_apikey'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['steam_user']),
            array('field' => 'steam_user'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['steam_userid']),
            array('field' => 'steam_userid'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['fb_post']),
            array('field' => 'fb_post'),
            array('%s'),
            array('%s')
        );
        $wpdb->update(
            SOCIAL_WAY_TABLE_NAME,
            array('val' => $_POST['fb_page']),
            array('field' => 'fb_page'),
            array('%s'),
            array('%s')
        );

    }
    $list = array();
    $btns = array();
    $list_q = $wpdb->get_results("SELECT page_id FROM ".SOCIAL_WAY_TABLE_NAME."_pages");
    foreach($list_q AS $l)
        $list[] = $l->page_id;
    $btn_q = $wpdb->get_results("SELECT btn FROM ".SOCIAL_WAY_TABLE_NAME."_btn");
    foreach($btn_q AS $b)
        $btns[] = $b->btn;

    $widget_q = $wpdb->get_results("SELECT btn FROM ".SOCIAL_WAY_TABLE_NAME."_widget");
    foreach($widget_q AS $w)
        $widget[] = $w->btn;

    $pos = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='position'"), 0);
    $lang = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='lang'"), 0);
    $auto_pages = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='auto_pages'"), 0);
    $auto_posts = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='auto_posts'"), 0);
    $tw_via = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='twitter_via'"), 0);
    $tw_follow = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='twitter_follow'"), 0);
    $tw_hash = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='twitter_hashtag'"), 0);
    $tw_ment = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='twitter_mention'"), 0);
    $in_comp = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='linkedin_company_id'"), 0);
    $in_compn = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='linkedin_company_name'"), 0);
    $in_pub = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='linkedin_public_profile'"), 0);
    $pin_prof = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='pinterest_profile'"), 0);
    $pin_img = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='pinterest_img'"), 0);
    $pin_id = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='pinterest_pin_id'"), 0);
    $pin_board = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='pinterest_board'"), 0);
    $gp_id = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='google_plus_id'"), 0);
    $gp_page = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='google_plus_page_id'"), 0);
    $gp_comm = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='google_plus_community_id'"), 0);
    $fb_l = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='fb_like_url'"), 0);
    $fb_f = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='fb_follow_user'"), 0);
    $fb_post = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='fb_post'"), 0);
    $fb_page = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='fb_page'"), 0);
    $askfm_user = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='askfm_user'"), 0);
    $lastfm_apikey = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='lastfm_apikey'"), 0);
    $lastfm_location = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='lastfm_location'"), 0);
    $youtube_vid = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='youtube_vid'"), 0);
    $youtube_user = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='youtube_user'"), 0);
    $tumblr_user = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='tumblr_user'"), 0);
    $skype_user = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='skype_user'"), 0);
    $vimeo_user = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='vimeo_user'"), 0);
    $steam_user = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='steam_user'"), 0);
    $steam_userid = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='steam_userid'"), 0);
    $steam_apikey = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='steam_apikey'"), 0);
    ?>
    <a href="http://www.cadienvanprojects.tk/" target=_blank><img src="http://www.cadienvanprojects.tk/wp-content/uploads/2013/08/logo_new1.png" class="logo" alt="Cadienvan Projects" title="Cadienvan Projects"></a>
    <form class="social_way" action=# method=POST>
    <h2>The AutoSave function is active. It will automatically update the database when you click on any checkbox, radio button or if you remove your focus from any text input.</h2>
    <input type=hidden id="plugin_url" value="<?php echo SOCIAL_WAY_PLUGIN_URL; ?>">
    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/set.png" alt="Settings"> <?php _e('General Settings', 'socialway'); ?></h1>
    <div class="Settings menu">
        <p>
            <label for="lang"><?php _e('Shortcodes Language', 'socialway'); ?></label>
        <div class="lang">
            <div class="arrow"></div>
            <select id=lang name=lang>
                <?php
                $q = mysql_query("SELECT ccode AS c1, country AS c2 FROM ".SOCIAL_WAY_TABLE_NAME."_countries");
                while($country = mysql_fetch_assoc($q)){
                    echo "<option value=".$country['c1']." ";
                    if($country['c1']==$lang)
                        echo "selected";
                    echo ">".$country['c2']."</option>";
                }
                ?>
            </select>
        </div>
        </p>
        <p><input type="checkbox" id="all_pages" name="all_pages" <?php echo ($auto_pages==1) ? "checked" : ""; ?> value=1><label for="all_pages"><span></span> <?php _e('View Shortcodes in all pages', 'socialway'); ?></label></p>
        <p><input type="checkbox" id="all_posts" name="all_posts" <?php echo ($auto_posts==1) ? "checked" : ""; ?> value=1><label for="all_posts"><span></span> <?php _e('View Shortcodes in all posts', 'socialway'); ?></label></p>
        <p>Position <input type="radio" id="pos_top" name="pos" value="top" <?php echo ($pos=="top") ? "checked" : ""; ?>><label for="pos_top"><span></span> <?php _e('Top', 'socialway'); ?></label> <input type="radio" id="pos_bottom" name="pos" value="bottom" <?php echo ($pos=="bottom") ? "checked" : ""; ?>><label for="pos_bottom"><span></span> <?php _e('Bottom', 'socialway'); ?></label></p>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/fb.png" alt="Facebook"> <?php _e('Facebook Settings', 'socialway'); ?></h1>
    <div class="Facebook menu">
        <p>
            <label for="fb_l">Facebook Like</label> <input type="text" id="fb_l" name="fb_l" value="<?php echo $fb_l; ?>">
        </p>
        <p>
            <label for="fb_f">Facebook Follow</label> <input type="text" id="fb_f" name="fb_f" value="<?php echo $fb_f; ?>">
        </p>
        <p>
            <label for="fb_post">Facebook Post</label> <input type="text" id="fb_post" name="fb_post" value="<?php echo $fb_post; ?>">
        </p>
        <p>
            <label for="fb_page">Facebook Page</label> <input type="text" id="fb_page" name="fb_page" value="<?php echo $fb_page; ?>">
        </p>
    </div>

    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/tw.png" alt="Twitter"> <?php _e('Twitter Settings', 'socialway'); ?></h1>
    <div class="Twitter menu">
        <p>
            <label for="tw_via">Twitter Via</label> @<input type=text id="tw_via" name="tw_via" value="<?php echo $tw_via; ?>">
        </p>
        <p>
            <label for="tw_follow">Twitter Follow</label> @<input type=text id="tw_follow" name="tw_follow" value="<?php echo $tw_follow;?>">
        </p>
        <p>
            <label for="tw_hash">Twitter Hash</label> #<input type=text id="tw_hash" name="tw_hash" value="<?php echo $tw_hash;?>">
        </p>
        <p>
            <label for="tw_ment">Twitter Mention</label> @<input type=text id="tw_ment" name="tw_ment" value="<?php echo $tw_ment;?>">
        </p>
    </div>

    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/in.png" alt="LinkedIn"> <?php _e('LinkedIn Settings', 'socialway'); ?></h1>
    <div class="LinkedIn menu">
        <p>
            <label for="in_comp">LinkedIn Company Id</label> <input type=text id="in_comp" name="in_comp" value="<?php echo $in_comp;?>">
        </p>
        <p>
            <label for="in_compn">LinkedIn Company Name</label> <input type=text id="in_compn" name="in_compn" value="<?php echo $in_compn;?>">
        </p>
        <p>
            <label for="in_pub">LinkedIn Public Profile</label> <input type=text id="in_pub" name="in_pub" value="<?php echo $in_pub;?>">
        </p>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/gp.png" alt="GooglePlus"> <?php _e('Google+ Settings', 'socialway'); ?></h1>
    <div class="GooglePlus menu">
        <p>
            <label for="gp_id">Google+ Id</label> <input type=text id="gp_id" name="gp_id" value="<?php echo $gp_id;?>">
        </p>
        <p>
            <label for="gp_page">Google+ Page Id</label> <input type=text id="gp_page" name="gp_page" value="<?php echo $gp_page;?>">
        </p>
        <p>
            <label for="gp_comm">Google+ Community Id</label> <input type=text id="gp_comm" name="gp_comm" value="<?php echo $gp_comm;?>">
        </p>
    </div>

    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/pin.png" alt="Pinterest"> <?php _e('Pinterest Settings', 'socialway'); ?></h1>
    <div class="Pinterest menu">
        <p>
            <label for="pin_prof">Pinterest Profile</label> <input type=text id="in_comp" name="pin_prof" value="<?php echo $pin_prof;?>">
        </p>
        <p>
            <label for="pin_img">Pinterest Image</label> <input type=text id="pin_img" name="pin_img" value="<?php echo $pin_img;?>">
        </p>
        <p>
            <label for="pin_id">Pinterest Pin Id</label> <input type=text id="pin_id" name="pin_id" value="<?php echo $pin_id;?>">
        </p>
        <p>
            <label for="pin_board">Pinterest Pin Board</label> <?php echo $pin_prof; ?>/<input type=text id="pin_board" name="pin_board" value="<?php echo $pin_board;?>">
        </p>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/ask.png" alt="Ask"> <?php _e('Ask.fm Settings', 'socialway'); ?></h1>
    <div class="Ask menu">
        <p>
            <label for="askfm_user">Ask.fm User</label> <input type=text id="askfm_user" name="askfm_user" value="<?php echo $askfm_user; ?>">
        </p>
    </div>

    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/lastfm.png" alt="Lastfm"> <?php _e('Last.fm Settings', 'socialway'); ?></h1>
    <div class="Lastfm menu">
        <p>
            <label for="lastfm_apikey">Last.fm API Key</label> <input type=text id="lastfm_apikey" name="lastfm_apikey" value="<?php echo $lastfm_apikey; ?>">
        </p>
        <p>
            <label for="lastfm_location">Last.fm Location</label> <input type=text id="lastfm_location" name="lastfm_location" value="<?php echo $lastfm_location; ?>">
        </p>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/youtube.png" alt="Youtube"> <?php _e('Youtube Settings', 'socialway'); ?></h1>
    <div class="Youtube menu">
        <p>
            <label for="youtube_vid">Youtube Video ID</label> <input type=text id="youtube_vid" name="youtube_vid" value="<?php echo $youtube_vid; ?>">
        </p>
        <p>
            <label for="youtube_user">Youtube User</label> <input type=text id="youtube_user" name="youtube_user" value="<?php echo $youtube_user; ?>">
        </p>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/tumblr.png" alt="Tumblr"> <?php _e('Tumblr Settings', 'socialway'); ?></h1>
    <div class="Tumblr menu">
        <p>
            <label for="tumblr_user">Tumblr User</label> <input type=text id="tumblr_user" name="tumblr_user" value="<?php echo $tumblr_user; ?>">
        </p>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/skype.png" alt="Skype"> <?php _e('Skype Settings', 'socialway'); ?></h1>
    <div class="Skype menu">
        <p>
            <label for="skype_user">Skype User</label> <input type=text id="skype_user" name="skype_user" value="<?php echo $skype_user; ?>">
        </p>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/vimeo.png" alt="Vimeo"> <?php _e('Vimeo Settings', 'socialway'); ?></h1>
    <div class="Vimeo menu">
        <p>
            <label for="vimeo_user">Vimeo User</label> <input type=text id="vimeo_user" name="vimeo_user" value="<?php echo $vimeo_user; ?>">
        </p>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/steam.png" alt="Steam"> <?php _e('Steam Settings', 'socialway'); ?></h1>
    <div class="Steam menu">
        <p>
            <label for="steam_apikey">Steam Api Key</label> <input type=text id="steam_apikey" name="steam_apikey" value="<?php echo $steam_apikey; ?>">
        </p>
        <p>
            <label for="steam_user">Steam User</label> <input type=text id="steam_user" name="steam_user" value="<?php echo $steam_user; ?>">
        </p>
        <p>
            <label for="steam_userid">Steam User ID</label> <input type=text id="steam_userid" name="steam_userid" value="<?php echo $steam_userid; ?>">
        </p>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/list.png" alt="Pages"> <?php _e('Pages List', 'socialway'); ?></h1>
    <div class="Pages menu">
        <table border=0 width=100%>
            <?php
            $pages = get_pages();
            $i=0;
            $j=0;
            foreach ( $pages as $page ) {
                if($j==0)
                    echo "<tr width=100%>";
                $j++;
                $i++;
                $checked = (in_array($page->ID, $list)) ? "checked" : "";
                echo "<td style='width: 33%;'>\n<p>\n<input type=checkbox id=el".$i." name=page_list[] value=".$page->ID." ".$checked."><label for=el".$i."><span></span> ".$page->post_title."</label>\n</p>\n</td>";
                if($j==3){ echo "</tr>"; $j=0; }
            }
            ?>
        </table>
    </div>

    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/list.png" alt="Buttons"> <?php _e('Buttons List', 'socialway'); ?></h1>
    <div class="Buttons menu">
        <table border=0 width=100%>
            <tr width=100%>
                <td><p><input type=checkbox id=tw_share name=btn_list[] value="tw_share" <?php echo (in_array("tw_share", $btns)) ? "checked" : ""; ?>><label for="tw_share"><span></span>[tw-share]</label></p></td>
                <td><p><input type=checkbox id=tw_follow2 name=btn_list[] value="tw_follow" <?php echo (in_array("tw_follow", $btns)) ? "checked" : ""; ?>><label for="tw_follow2"><span></span>[tw-follow]</label></p></td>
                <td><p><input type=checkbox id=tw_hashtag name=btn_list[] value="tw_hashtag" <?php echo (in_array("tw_hashtag", $btns)) ? "checked" : ""; ?>><label for="tw_hashtag"><span></span>[tw-hashtag]</label></p></td>
            </tr><tr width=100%>
                <td><p><input type=checkbox id=tw_mention name=btn_list[] value="tw_mention" <?php echo (in_array("tw_mention", $btns)) ? "checked" : ""; ?>><label for="tw_mention"><span></span>[tw-mention]</label></p></td>
                <td><p><input type=checkbox id=in_share name=btn_list[] value="in_share" <?php echo (in_array("in_share", $btns)) ? "checked" : ""; ?>><label for="in_share"><span></span>[in-share]</label></p></td>
                <td><p><input type=checkbox id=in_follow name=btn_list[] value="in_follow" <?php echo (in_array("in_follow", $btns)) ? "checked" : ""; ?>><label for="in_follow"><span></span>[in-follow]</label></p></td>
            </tr><tr width=100%>
                <td><p><input type=checkbox id=in_company_profile name=btn_list[] value="in_company_profile" <?php echo (in_array("in_company_profile", $btns)) ? "checked" : ""; ?>><label for="in_company_profile"><span></span>[in-company-profile]</label></p></td>
                <td><p><input type=checkbox id=in_public_profile name=btn_list[] value="in_public_profile" <?php echo (in_array("in_public_profile", $btns)) ? "checked" : ""; ?>><label for="in_public_profile"><span></span>[in-public-profile]</label></p></td>
                <td><p><input type=checkbox id=pin_it name=btn_list[] value="pin_it" <?php echo (in_array("pin_it", $btns)) ? "checked" : ""; ?>><label for="pin_it"><span></span>[pin-it]</label></p></td>
            </tr><tr width=100%>
                <td><p><input type=checkbox id=pin_follow name=btn_list[] value="pin_follow" <?php echo (in_array("pin_follow", $btns)) ? "checked" : ""; ?>><label for="pin_follow"><span></span>[pin-follow]</label></p></td>
                <td><p><input type=checkbox id=pin_widget name=btn_list[] value="pin_widget" <?php echo (in_array("pin_widget", $btns)) ? "checked" : ""; ?>><label for="pin_widget"><span></span>[pin-widget]</label></p></td>
                <td><p><input type=checkbox id=pin_profile_widget name=btn_list[] value="pin_profile_widget" <?php echo (in_array("pin_profile_widget", $btns)) ? "checked" : ""; ?>><label for="pin_profile_widget"><span></span>[pin-profile-widget]</label></p></td>
            </tr><tr width=100%>
                <td><p><input type=checkbox id=pin_board_widget name=btn_list[] value="pin_board_widget" <?php echo (in_array("pin_board_widget", $btns)) ? "checked" : ""; ?>><label for="pin_board_widget"><span></span>[pin-board-widget]</label></p></td>
                <td><p><input type=checkbox id=google_share name=btn_list[] value="google_share" <?php echo (in_array("google_share", $btns)) ? "checked" : ""; ?>><label for="google_share"><span></span>[google-share]</label></p></td>
                <td><p><input type=checkbox id=google_plus_one name=btn_list[] value="google_plus_one" <?php echo (in_array("google_plus_one", $btns)) ? "checked" : ""; ?>><label for="google_plus_one"><span></span>[google-plus-one]</label></p></td>
            </tr><tr width=100%>
                <td><p><input type=checkbox id=google_profile_badge name=btn_list[] value="google_profile_badge" <?php echo (in_array("google_profile_badge", $btns)) ? "checked" : ""; ?>><label for="google_profile_badge"><span></span>[google-profile-badge]</label></p></td>
                <td><p><input type=checkbox id=google_page_badge name=btn_list[] value="google_page_badge" <?php echo (in_array("google_page_badge", $btns)) ? "checked" : ""; ?>><label for="google_page_badge"><span></span>[google-page-badge]</label></p></td>
                <td><p><input type=checkbox id=google_community_badge name=btn_list[] value="google_community_badge" <?php echo (in_array("google_community_badge", $btns)) ? "checked" : ""; ?>><label for="google_community_badge"><span></span>[google-community-badge]</label></p></td>
            </tr><tr width=100%>
                <td><p><input type=checkbox id=google_follow name=btn_list[] value="google_follow" <?php echo (in_array("google_follow", $btns)) ? "checked" : ""; ?>><label for="google_follow"><span></span>[google-follow]</label></p></td>
                <td><p><input type=checkbox id=fb_like name=btn_list[] value="fb_like" <?php echo (in_array("fb_like", $btns)) ? "checked" : ""; ?>><label for="fb_like"><span></span>[fb-like]</label></p></td>
                <td><p><input type=checkbox id=fb_follow name=btn_list[] value="fb_follow" <?php echo (in_array("fb_follow", $btns)) ? "checked" : ""; ?>><label for="fb_follow"><span></span>[fb-follow]</label></p></td>
            </tr><tr width=100%>
                <td><p><input type=checkbox id=fb_share name=btn_list[] value="fb_share" <?php echo (in_array("fb_share", $btns)) ? "checked" : ""; ?>><label for="fb_share"><span></span>[fb-share]</label></p></td>
                <td><p><input type=checkbox id=youtube_follow name=btn_list[] value="youtube_follow" <?php echo (in_array("youtube_follow", $btns)) ? "checked" : ""; ?>><label for="youtube_follow"><span></span>[youtube-follow]</label></p></td>
                <td><p><input type=checkbox id=tumblr_follow name=btn_list[] value="tumblr_follow" <?php echo (in_array("tumblr_follow", $btns)) ? "checked" : ""; ?>><label for="tumblr_follow"><span></span>[tumblr-follow]</label></p></td>
            </tr>
            <tr width=100%>
                <td><p><input type=checkbox id=skype_user2 name=btn_list[] value="skype_call" <?php echo (in_array("skype_call", $btns)) ? "checked" : ""; ?>><label for="skype_user2"><span></span>[skype-call]</label></p></td>
            </tr>
        </table>
    </div>


    <h1><img src="<?php echo SOCIAL_WAY_PLUGIN_URL;?>/social.png" alt="Widget"> <?php _e('Widget Buttons', 'socialway'); ?></h1>
    <div class="Widget menu">
        <table border=0 width=100%>
            <tr width=100%>
                <td><p><input type=checkbox id=widget_twitter name=widget_list[] value="twitter" <?php echo (in_array("twitter", $widget)) ? "checked" : ""; ?>><label for="widget_twitter"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_twitter.png' /></label></p></td>
                <td><p><input type=checkbox id=widget_facebook name=widget_list[] value="facebook" <?php echo (in_array("facebook", $widget)) ? "checked" : ""; ?>><label for="widget_facebook"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_facebook.png' /></label></p></td>
                <td><p><input type=checkbox id=widget_google name=widget_list[] value="google" <?php echo (in_array("google", $widget)) ? "checked" : ""; ?>><label for="widget_google"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_google.png' /></label></p></td>
                <td><p><input type=checkbox id=widget_linkedin name=widget_list[] value="linkedin" <?php echo (in_array("linkedin", $widget)) ? "checked" : ""; ?>><label for="widget_linkedin"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_linkedin.png' /></label></p></td>
                <td><p><input type=checkbox id=widget_youtube name=widget_list[] value="youtube" <?php echo (in_array("youtube", $widget)) ? "checked" : ""; ?>><label for="widget_youtube"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_youtube.png' /></label></p></td>
            </tr>
            <tr width=100%>
                <td><p><input type=checkbox id=widget_pinterest name=widget_list[] value="pinterest" <?php echo (in_array("pinterest", $widget)) ? "checked" : ""; ?>><label for="widget_pinterest"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_pinterest.png' /></label></p></td>
                <td><p><input type=checkbox id=widget_vimeo name=widget_list[] value="vimeo" <?php echo (in_array("vimeo", $widget)) ? "checked" : ""; ?>><label for="widget_vimeo"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_vimeo.png' /></label></p></td>
                <td><p><input type=checkbox id=widget_tumblr name=widget_list[] value="tumblr" <?php echo (in_array("tumblr", $widget)) ? "checked" : ""; ?>><label for="widget_tumblr"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_tumblr.png' /></label></p></td>
                <td><p><input type=checkbox id=widget_steam name=widget_list[] value="steam" <?php echo (in_array("steam", $widget)) ? "checked" : ""; ?>><label for="widget_steam"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_steam.png' /></label></p></td>
                <td><p><input type=checkbox id=widget_skype name=widget_list[] value="skype" <?php echo (in_array("skype", $widget)) ? "checked" : ""; ?>><label for="widget_skype"><span></span> <img src='<?php echo SOCIAL_WAY_PLUGIN_URL."/"; ?>widget_skype.png' /></label></p></td>
            </tr>

        </table>
    </div>
    </div>
    <input type="submit" name="edit" value="Edit!">
    </form>
    <div style='clear: both;'></div>
<?php
}
?>