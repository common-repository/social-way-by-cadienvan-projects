<?php
/*
Plugin Name: Social Way By Cadienvan Projects
Plugin URI: http://www.cadienvanprojects.tk/socialway-plugin/
Description: Social Way is a Wordpress Plugin that allows you to share, like or follow everyone and everything with a simple shortcode! APIs and buttons with one click! Instructions & How-to-use at <a href='http://www.cadienvanprojects.tk/cadien-lab/social-way-plugin/'>http://www.cadienvanprojects.tk/cadien-lab/social-way-plugin/</a>
Version: 1.0
Author: Michael Di Prisco
Author URI: http://www.cadienvanprojects.tk/
License: GPLv2
Text Domain: socialway
*/
error_reporting(0);

register_activation_hook( __FILE__, 'social_way_plugin_install' );
register_activation_hook( __FILE__, 'social_way_plugin_install_data' );
add_action( 'init', 'social_way_plugin_lang' );
global $wpdb;
define('SOCIAL_WAY_TABLE_NAME', $wpdb->prefix ."socialwaycpplugin");
define('SOCIAL_WAY_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));
define('SOCIAL_WAY_PLUGIN_URL', plugins_url() . '/' . SOCIAL_WAY_PLUGIN_NAME);
define('SOCIAL_WAY_LANG', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='lang'"), 0));
define('SOCIAL_WAY_TWITTER_VIA', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='twitter_via'"), 0));
define('SOCIAL_WAY_TWITTER_FOLLOW', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='twitter_follow'"), 0));
define('SOCIAL_WAY_TWITTER_HASHTAG', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='twitter_hashtag'"), 0));
define('SOCIAL_WAY_TWITTER_MENTION', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='twitter_mention'"), 0));
define('SOCIAL_WAY_LINKEDIN_COMPANY_ID', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='linkedin_company_id'"), 0));
define('SOCIAL_WAY_LINKEDIN_COMPANY_NAME', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='linkedin_company_name'"), 0));
define('SOCIAL_WAY_LINKEDIN_PUBLIC_PROFILE', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='linkedin_public_profile'"), 0));
define('SOCIAL_WAY_PINTEREST_IMG', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='pinterest_img'"), 0));
define('SOCIAL_WAY_PINTEREST_PIN_ID', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='pinterest_pin_id'"), 0));
define('SOCIAL_WAY_PINTEREST_PROFILE', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='pinterest_profile'"), 0));
define('SOCIAL_WAY_PINTEREST_BOARD', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='pinterest_board'"), 0));
define('SOCIAL_WAY_GOOGLE_PLUS_ID', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='google_plus_id'"), 0));
define('SOCIAL_WAY_GOOGLE_PLUS_PAGE_ID', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='google_plus_page_id'"), 0));
define('SOCIAL_WAY_GOOGLE_PLUS_COMMUNITY_ID', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='google_plus_community_id'"), 0));
define('SOCIAL_WAY_FB_LIKE_URL', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='fb_like_url'"), 0));
define('SOCIAL_WAY_FB_FOLLOW_USER', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='fb_follow_user'"), 0));
define('SOCIAL_WAY_ASKFM_USER', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='askfm_user'"), 0));
define('SOCIAL_WAY_CURRENT_URL', 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
define('SOCIAL_WAY_LASTFM_APIKEY', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='lastfm_apikey'"), 0));
define('SOCIAL_WAY_LASTFM_LOCATION', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='lastfm_location'"), 0));
define('SOCIAL_WAY_YOUTUBE_VID', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='youtube_vid'"), 0));
define('SOCIAL_WAY_YOUTUBE_USER', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='youtube_user'"), 0));
define('SOCIAL_WAY_TUMBLR_USER', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='tumblr_user'"), 0));
define('SOCIAL_WAY_SKYPE_USER', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='skype_user'"), 0));
define('SOCIAL_WAY_VIMEO_USER', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='vimeo_user'"), 0));
define('SOCIAL_WAY_KONGREGATE_USER', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='kongregate_user'"), 0));
define('SOCIAL_WAY_STEAM_USER', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='steam_user'"), 0));
define('SOCIAL_WAY_STEAM_USERID', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='steam_userid'"), 0));
define('SOCIAL_WAY_STEAM_APIKEY', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='steam_apikey'"), 0));
define('SOCIAL_WAY_FB_POST', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='fb_post'"), 0));
define('SOCIAL_WAY_FB_PAGE', mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='fb_page'"), 0));

class social_way_social_widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'social_way_social_widget', // Base ID
            'Social Way Social Widget', // Name
            array( 'description' => __( 'Add Social Buttons all around!', 'socialway' ), ) // Args
        );
    }

    public function widget( $args, $instance ) {
        wp_register_style( 'socialwaysocialwidget', plugins_url('socialwaysocialwidget.css', __FILE__) );
        wp_enqueue_style( 'socialwaysocialwidget' );
        global $wpdb;
        $title = apply_filters( 'widget_title', $instance['title'] );
        $url['facebook'] = "htps://www.facebook.com/".urlencode(SOCIAL_WAY_FB_FOLLOW_USER);
        $url['twitter'] = "https://twitter.com/".urlencode(SOCIAL_WAY_TWITTER_FOLLOW);
        $url['linkedin'] = SOCIAL_WAY_LINKEDIN_PUBLIC_PROFILE;
        $url['youtube'] = "http://www.youtube.com/user/".urlencode(SOCIAL_WAY_YOUTUBE_USER);
        $url['google'] = "https://plus.google.com/".urlencode(SOCIAL_WAY_GOOGLE_PLUS_ID);
        $url['pinterest'] = "http://pinterest.com/".urlencode(SOCIAL_WAY_PINTEREST_PROFILE);
        $url['vimeo'] = "https://vimeo.com/".urlencode(SOCIAL_WAY_VIMEO_USER);
        $url['tumblr'] = "http://".urlencode(SOCIAL_WAY_TUMBLR_USER).".tumblr.com/";
        $url['skype'] = "http://myskype.info/".urlencode(SOCIAL_WAY_SKYPE_USER);
        $url['steam'] = "http://steamcommunity.com/id/".urlencode(SOCIAL_WAY_STEAM_USER);

        echo $args['before_widget'];
        if ( ! empty( $title ) && !empty($instance['show_title']))
            echo $args['before_title'] . $title . $args['after_title'];
        $widget_q = $wpdb->get_results("SELECT btn FROM ".SOCIAL_WAY_TABLE_NAME."_widget");
        foreach($widget_q AS $w)
            $widget[] = $w->btn;
        foreach($widget AS $w)
            echo "<div class='social_way_social'><a href='".$url[$w]."' target=_blank><img src='".SOCIAL_WAY_PLUGIN_URL."/widget_".$w.".png'></a></div>";
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $user = (!empty($instance['user'])) ? $instance['user'] : SOCIAL_WAY_TWITTER_FOLLOW;
        $count = (!empty($instance['count'])) ? $instance['count'] : 10;
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Last Tweets', 'socialway' );
        }
        if ( !empty( $instance[ 'show_title' ] ) )
            $ch = "checked";
        else
            $ch = "";
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input placeholder="Spotify Player" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <br />
            <input id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" type="checkbox" value="1" <?php echo $ch; ?>> <label for="<?php echo $this->get_field_id('show_title'); ?>"><?php _e("Show Title", "socialway"); ?></label>
        </p>
        <p>All the social buttons are defined in the Social Way Plugin admin page under the voice "Widget Buttons"</p>

    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['show_title'] = (!empty($new_instance['show_title'])) ? strip_tags($new_instance['show_title']) : '';
        return $instance;    }
}


class social_way_twitter_widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'social_way_twitter_widget', // Base ID
            'Social Way Twitter Widget', // Name
            array( 'description' => __( 'Your latest Twitter posts wherever you want!', 'socialway' ), ) // Args
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];
        if ( ! empty( $title ) && !empty($instance['show_title']))
            echo $args['before_title'] . $title . $args['after_title'];
        echo do_shortcode('[tw-tweets user="'.$instance['user'].'" count='.$instance['count'].']');
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $user = (!empty($instance['user'])) ? $instance['user'] : SOCIAL_WAY_TWITTER_FOLLOW;
        $count = (!empty($instance['count'])) ? $instance['count'] : 10;
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Last Tweets', 'socialway' );
        }
        if ( !empty( $instance[ 'show_title' ] ) )
            $ch = "checked";
        else
            $ch = "";
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input placeholder="Spotify Player" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <br />
            <input id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" type="checkbox" value="1" <?php echo $ch; ?>> <label for="<?php echo $this->get_field_id('show_title'); ?>"><?php _e("Show Title", "socialway"); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'user' ); ?>"><?php _e( 'Username:' ); ?></label>
            <input placeholder="Twitter Username" class="widefat" id="<?php echo $this->get_field_id( 'user' ); ?>" name="<?php echo $this->get_field_name( 'user' ); ?>" type="text" value="<?php echo esc_attr( $user ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of Tweets:' ); ?></label>
            <input type="range" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" min="1" max="10" value="<?php echo esc_attr($count); ?>">
        </p>

    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['show_title'] = (!empty($new_instance['show_title'])) ? strip_tags($new_instance['show_title']) : '';
        $instance['user'] = (!empty($new_instance['user'])) ? $new_instance['user'] : '';
        $instance['count'] = (!empty($new_instance['count'])) ? $new_instance['count'] : '10';
        return $instance;    }
}

class social_way_spotify_widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'social_way_spotify_widget', // Base ID
            'Social Way Spotify Widget', // Name
            array( 'description' => __( 'Include your Spotify music everywhere!', 'socialway' ), ) // Args
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];
        if ( ! empty( $title ) && !empty($instance['show_title']))
            echo $args['before_title'] . $title . $args['after_title'];
        if($instance['show_type']==1) $t = "artist";
        if($instance['show_type']==2) $t = "album";
        if($instance['show_type']==3) $t = "track";
        $size = ($instance['big']==1) ? "big" : "";
        $theme = ($instance['theme']==1) ? "white" : "";
        $cover = ($instance['coverart']==1) ? "coverart" : "";
        $uri = $instance['uri'];
        if(!empty($instance['search'])){
            $t = "search_".$t;
            $uri = $instance['search'];
        }
        echo do_shortcode('[spotify '.$t.'="'.$uri.'" '.$size.' '.$theme.' '.$cover.' widget]');
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        if ( !empty( $instance[ 'show_title' ] ) )
            $ch = "checked";
            else
            $ch = "";
        $ar = ($instance['show_type']==1) ? "checked" : 0;
        $al = ($instance['show_type']==2) ? "checked" : 0;
        $tr = ($instance['show_type']==3) ? "checked" : 0;
        $uri = (!empty($instance['uri'])) ? $instance['uri'] : "";
        $search_uri = (!empty($instance['search'])) ? $instance['search'] : "";
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Spotify Player', 'socialway' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'socialway' ); ?></label>
            <input placeholder="Spotify Player" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <br />
            <input id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" type="checkbox" value="1" <?php echo $ch; ?>> <label for="<?php echo $this->get_field_id('show_title'); ?>"><?php _e("Show Title", "socialway"); ?></label>
        </p>
        <p>
            <input type="radio" id="<?php echo $this->get_field_id( 'artist' ); ?>" name="<?php echo $this->get_field_name( 'show_type' ); ?>" value=1 <?php echo $ar; ?>><label for="<?php echo $this->get_field_id( 'artist' ); ?>"> Artist</label>
            <input type="radio" id="<?php echo $this->get_field_id( 'album' ); ?>" name="<?php echo $this->get_field_name( 'show_type' ); ?>" value=2 <?php echo $al; ?>><label for="<?php echo $this->get_field_id( 'album' ); ?>"> Album</label>
            <input type="radio" id="<?php echo $this->get_field_id( 'track' ); ?>" name="<?php echo $this->get_field_name( 'show_type' ); ?>" value=3 <?php echo $tr; ?>><label for="<?php echo $this->get_field_id( 'track' ); ?>"> Track</label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'uri' ); ?>"><?php _e( 'Spotify URI:' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'uri' ); ?>" name="<?php echo $this->get_field_name( 'uri' ); ?>" value="<?php echo esc_attr($uri); ?>" placeholder="Insert Spotify URI here..." />
        </p>
        <p>
            Or
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'search_uri' ); ?>"><?php _e( 'Search for a Spotify URI:' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'search_uri' ); ?>" name="<?php echo $this->get_field_name( 'search_uri' ); ?>" value="<?php echo esc_attr($search_uri); ?>" placeholder="Insert query here..." />
            <small>*Leave this field blank to enable the Spotify URI above</small>

        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'big' ); ?>" name="<?php echo $this->get_field_name( 'big' ); ?>" value=1 <?php echo (!empty($instance['big'])) ? "checked" : ""; ?>><label for="<?php echo $this->get_field_id( 'big' ); ?>"> Big</label>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'theme' ); ?>" name="<?php echo $this->get_field_name( 'theme' ); ?>" value=1 <?php echo (!empty($instance['theme'])) ? "checked" : ""; ?>><label for="<?php echo $this->get_field_id( 'theme' ); ?>"> White Theme</label>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'coverart' ); ?>" name="<?php echo $this->get_field_name( 'coverart' ); ?>" value=1 <?php echo (!empty($instance['coverart'])) ? "checked" : ""; ?>><label for="<?php echo $this->get_field_id( 'coverart' ); ?>"> Coverart View</label>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['show_title'] = (!empty($new_instance['show_title'])) ? strip_tags($new_instance['show_title']) : '';
        $instance['show_type'] = (!empty($new_instance['show_type'])) ? $new_instance['show_type'] : 1;
        $instance['uri'] = (!empty($new_instance['uri'])) ? $new_instance['uri'] : '';
        $instance['big'] = (!empty($new_instance['big'])) ? $new_instance['big'] : '';
        $instance['search'] = (!empty($new_instance['search_uri'])) ? $new_instance['search_uri'] : "";
        $instance['theme'] = (!empty($new_instance['theme'])) ? $new_instance['theme'] : "";
        $instance['coverart'] = (!empty($new_instance['coverart'])) ? $new_instance['coverart'] : "";



        return $instance;    }
}
add_action( 'widgets_init', function(){
    register_widget( 'social_way_spotify_widget' );
    register_widget( 'social_way_twitter_widget' );
    register_widget( 'social_way_social_widget' );
});

add_action( 'admin_init', 'social_way_plugin_admin_init' );
add_action( 'admin_menu', 'social_way_plugin_admin' );
add_filter( 'the_content', 'social_way_plugin_content', 20);
function social_way_plugin_lang() {
    $plugin_dir = basename(dirname(__FILE__));
    load_plugin_textdomain('socialway', false, $plugin_dir  . '/languages/');
}
add_action('plugins_loaded', 'social_way_plugin_lang');

function autolink($str, $attributes=array()) {
    $attrs = '';
    foreach ($attributes as $attribute => $value) {
        $attrs .= " {$attribute}=\"{$value}\"";
    }

    $str = ' ' . $str;
    $str = preg_replace(
        '`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
        '$1<a href="$2"'.$attrs.' target=_blank>$2</a>',
        $str
    );
    $str = substr($str, 1);

    return $str;
}

function social_way_plugin_install(){
    global $wpdb;
    $table_name = SOCIAL_WAY_TABLE_NAME;
    $sql = "CREATE TABLE $table_name (
`ID` int(11) NOT NULL AUTO_INCREMENT,
`field` varchar(200) NOT NULL,
`val` varchar(200) NOT NULL,
PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";


    $sql2 = "CREATE TABLE IF NOT EXISTS `".$table_name."_countries` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
`ccode` varchar(2) NOT NULL DEFAULT '',
`country` varchar(200) NOT NULL DEFAULT '',
PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=251 ;";


    $sql3 = "INSERT INTO `".$table_name."_countries` (`ID`, `ccode`, `country`) VALUES
(1, 'IE', 'Ireland'),
(2, 'AD', 'Andorra'),
(3, 'AE', 'United Arab Emirates'),
(4, 'AF', 'Afghanistan'),
(5, 'AG', 'Antigua and Barbuda'),
(6, 'AI', 'Anguilla'),
(7, 'AL', 'Albania'),
(8, 'AM', 'Armenia'),
(9, 'AO', 'Angola'),
(10, 'AQ', 'Antarctica'),
(11, 'AR', 'Argentina'),
(12, 'AS', 'American Samoa'),
(13, 'AT', 'Austria'),
(14, 'AU', 'Australia'),
(15, 'AW', 'Aruba'),
(16, 'AX', 'Ã…land'),
(17, 'AZ', 'Azerbaijan'),
(18, 'BA', 'Bosnia and Herzegovina'),
(19, 'BB', 'Barbados'),
(20, 'BD', 'Bangladesh'),
(21, 'BE', 'Belgium'),
(22, 'BF', 'Burkina Faso'),
(23, 'BG', 'Bulgaria'),
(24, 'BH', 'Bahrain'),
(25, 'BI', 'Burundi'),
(26, 'BJ', 'Benin'),
(27, 'BL', 'Saint BarthÃ©lemy'),
(28, 'BM', 'Bermuda'),
(29, 'BN', 'Brunei'),
(30, 'BO', 'Bolivia'),
(31, 'BQ', 'Bonaire'),
(32, 'BR', 'Brazil'),
(33, 'BS', 'Bahamas'),
(34, 'BT', 'Bhutan'),
(35, 'BV', 'Bouvet Island'),
(36, 'BW', 'Botswana'),
(37, 'BY', 'Belarus'),
(38, 'BZ', 'Belize'),
(39, 'CA', 'Canada'),
(40, 'CC', 'Cocos [Keeling] Islands'),
(41, 'CD', 'Democratic Republic of the Congo'),
(42, 'CF', 'Central African Republic'),
(43, 'CG', 'Republic of the Congo'),
(44, 'CH', 'Switzerland'),
(45, 'CI', 'Ivory Coast'),
(46, 'CK', 'Cook Islands'),
(47, 'CL', 'Chile'),
(48, 'CM', 'Cameroon'),
(49, 'CN', 'China'),
(50, 'CO', 'Colombia'),
(51, 'CR', 'Costa Rica'),
(52, 'CU', 'Cuba'),
(53, 'CV', 'Cape Verde'),
(54, 'CW', 'Curacao'),
(55, 'CX', 'Christmas Island'),
(56, 'CY', 'Cyprus'),
(57, 'CZ', 'Czechia'),
(58, 'DE', 'Germany'),
(59, 'DJ', 'Djibouti'),
(60, 'DK', 'Denmark'),
(61, 'DM', 'Dominica'),
(62, 'DO', 'Dominican Republic'),
(63, 'DZ', 'Algeria'),
(64, 'EC', 'Ecuador'),
(65, 'EE', 'Estonia'),
(66, 'EG', 'Egypt'),
(67, 'EH', 'Western Sahara'),
(68, 'ER', 'Eritrea'),
(69, 'ES', 'Spain'),
(70, 'ET', 'Ethiopia'),
(71, 'FI', 'Finland'),
(72, 'FJ', 'Fiji'),
(73, 'FK', 'Falkland Islands'),
(74, 'FM', 'Micronesia'),
(75, 'FO', 'Faroe Islands'),
(76, 'FR', 'France'),
(77, 'GA', 'Gabon'),
(78, 'GB', 'United Kingdom'),
(79, 'GD', 'Grenada'),
(80, 'GE', 'Georgia'),
(81, 'GF', 'French Guiana'),
(82, 'GG', 'Guernsey'),
(83, 'GH', 'Ghana'),
(84, 'GI', 'Gibraltar'),
(85, 'GL', 'Greenland'),
(86, 'GM', 'Gambia'),
(87, 'GN', 'Guinea'),
(88, 'GP', 'Guadeloupe'),
(89, 'GQ', 'Equatorial Guinea'),
(90, 'GR', 'Greece'),
(91, 'GS', 'South Georgia and the South Sandwich Islands'),
(92, 'GT', 'Guatemala'),
(93, 'GU', 'Guam'),
(94, 'GW', 'Guinea-Bissau'),
(95, 'GY', 'Guyana'),
(96, 'HK', 'Hong Kong'),
(97, 'HM', 'Heard Island and McDonald Islands'),
(98, 'HN', 'Honduras'),
(99, 'HR', 'Croatia'),
(100, 'HT', 'Haiti'),
(101, 'HU', 'Hungary'),
(102, 'ID', 'Indonesia'),
(103, 'IL', 'Israel'),
(104, 'IM', 'Isle of Man'),
(105, 'IN', 'India'),
(106, 'IO', 'British Indian Ocean Territory'),
(107, 'IQ', 'Iraq'),
(108, 'IR', 'Iran'),
(109, 'IS', 'Iceland'),
(110, 'IT', 'Italy'),
(111, 'JE', 'Jersey'),
(112, 'JM', 'Jamaica'),
(113, 'JO', 'Jordan'),
(114, 'JP', 'Japan'),
(115, 'KE', 'Kenya'),
(116, 'KG', 'Kyrgyzstan'),
(117, 'KH', 'Cambodia'),
(118, 'KI', 'Kiribati'),
(119, 'KM', 'Comoros'),
(120, 'KN', 'Saint Kitts and Nevis'),
(121, 'KP', 'North Korea'),
(122, 'KR', 'South Korea'),
(123, 'KW', 'Kuwait'),
(124, 'KY', 'Cayman Islands'),
(125, 'KZ', 'Kazakhstan'),
(126, 'LA', 'Laos'),
(127, 'LB', 'Lebanon'),
(128, 'LC', 'Saint Lucia'),
(129, 'LI', 'Liechtenstein'),
(130, 'LK', 'Sri Lanka'),
(131, 'LR', 'Liberia'),
(132, 'LS', 'Lesotho'),
(133, 'LT', 'Lithuania'),
(134, 'LU', 'Luxembourg'),
(135, 'LV', 'Latvia'),
(136, 'LY', 'Libya'),
(137, 'MA', 'Morocco'),
(138, 'MC', 'Monaco'),
(139, 'MD', 'Moldova'),
(140, 'ME', 'Montenegro'),
(141, 'MF', 'Saint Martin'),
(142, 'MG', 'Madagascar'),
(143, 'MH', 'Marshall Islands'),
(144, 'MK', 'Macedonia'),
(145, 'ML', 'Mali'),
(146, 'MM', 'Myanmar [Burma]'),
(147, 'MN', 'Mongolia'),
(148, 'MO', 'Macao'),
(149, 'MP', 'Northern Mariana Islands'),
(150, 'MQ', 'Martinique'),
(151, 'MR', 'Mauritania'),
(152, 'MS', 'Montserrat'),
(153, 'MT', 'Malta'),
(154, 'MU', 'Mauritius'),
(155, 'MV', 'Maldives'),
(156, 'MW', 'Malawi'),
(157, 'MX', 'Mexico'),
(158, 'MY', 'Malaysia'),
(159, 'MZ', 'Mozambique'),
(160, 'NA', 'Namibia'),
(161, 'NC', 'New Caledonia'),
(162, 'NE', 'Niger'),
(163, 'NF', 'Norfolk Island'),
(164, 'NG', 'Nigeria'),
(165, 'NI', 'Nicaragua'),
(166, 'NL', 'Netherlands'),
(167, 'NO', 'Norway'),
(168, 'NP', 'Nepal'),
(169, 'NR', 'Nauru'),
(170, 'NU', 'Niue'),
(171, 'NZ', 'New Zealand'),
(172, 'OM', 'Oman'),
(173, 'PA', 'Panama'),
(174, 'PE', 'Peru'),
(175, 'PF', 'French Polynesia'),
(176, 'PG', 'Papua New Guinea'),
(177, 'PH', 'Philippines'),
(178, 'PK', 'Pakistan'),
(179, 'PL', 'Poland'),
(180, 'PM', 'Saint Pierre and Miquelon'),
(181, 'PN', 'Pitcairn Islands'),
(182, 'PR', 'Puerto Rico'),
(183, 'PS', 'Palestine'),
(184, 'PT', 'Portugal'),
(185, 'PW', 'Palau'),
(186, 'PY', 'Paraguay'),
(187, 'QA', 'Qatar'),
(188, 'RE', 'RÃ©union'),
(189, 'RO', 'Romania'),
(190, 'RS', 'Serbia'),
(191, 'RU', 'Russia'),
(192, 'RW', 'Rwanda'),
(193, 'SA', 'Saudi Arabia'),
(194, 'SB', 'Solomon Islands'),
(195, 'SC', 'Seychelles'),
(196, 'SD', 'Sudan'),
(197, 'SE', 'Sweden'),
(198, 'SG', 'Singapore'),
(199, 'SH', 'Saint Helena'),
(200, 'SI', 'Slovenia'),
(201, 'SJ', 'Svalbard and Jan Mayen'),
(202, 'SK', 'Slovakia'),
(203, 'SL', 'Sierra Leone'),
(204, 'SM', 'San Marino'),
(205, 'SN', 'Senegal'),
(206, 'SO', 'Somalia'),
(207, 'SR', 'Suriname'),
(208, 'SS', 'South Sudan'),
(209, 'ST', 'SÃ£o TomÃ© and PrÃ­ncipe'),
(210, 'SV', 'El Salvador'),
(211, 'SX', 'Sint Maarten'),
(212, 'SY', 'Syria'),
(213, 'SZ', 'Swaziland'),
(214, 'TC', 'Turks and Caicos Islands'),
(215, 'TD', 'Chad'),
(216, 'TF', 'French Southern Territories'),
(217, 'TG', 'Togo'),
(218, 'TH', 'Thailand'),
(219, 'TJ', 'Tajikistan'),
(220, 'TK', 'Tokelau'),
(221, 'TL', 'East Timor'),
(222, 'TM', 'Turkmenistan'),
(223, 'TN', 'Tunisia'),
(224, 'TO', 'Tonga'),
(225, 'TR', 'Turkey'),
(226, 'TT', 'Trinidad and Tobago'),
(227, 'TV', 'Tuvalu'),
(228, 'TW', 'Taiwan'),
(229, 'TZ', 'Tanzania'),
(230, 'UA', 'Ukraine'),
(231, 'UG', 'Uganda'),
(232, 'UM', 'U.S. Minor Outlying Islands'),
(233, 'US', 'United States'),
(234, 'UY', 'Uruguay'),
(235, 'UZ', 'Uzbekistan'),
(236, 'VA', 'Vatican City'),
(237, 'VC', 'Saint Vincent and the Grenadines'),
(238, 'VE', 'Venezuela'),
(239, 'VG', 'British Virgin Islands'),
(240, 'VI', 'U.S. Virgin Islands'),
(241, 'VN', 'Vietnam'),
(242, 'VU', 'Vanuatu'),
(243, 'WF', 'Wallis and Futuna'),
(244, 'WS', 'Samoa'),
(245, 'XK', 'Kosovo'),
(246, 'YE', 'Yemen'),
(247, 'YT', 'Mayotte'),
(248, 'ZA', 'South Africa'),
(249, 'ZM', 'Zambia'),
(250, 'ZW', 'Zimbabwe');";

    $sql4 = "CREATE TABLE IF NOT EXISTS `".$table_name."_pages` (
`page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $sql5 = "CREATE TABLE IF NOT EXISTS `".$table_name."_btn` (
`btn` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $sql6 = "CREATE TABLE IF NOT EXISTS `".$table_name."_widget` (
`btn` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    dbDelta( $sql2 );
    dbDelta( $sql3 );
    dbDelta( $sql4 );
    dbDelta( $sql5 );
    dbDelta( $sql6 );
}

function social_way_plugin_install_data(){
    global $wpdb;
    $table_name = SOCIAL_WAY_TABLE_NAME;
    $ins1 = $wpdb->insert( $table_name, array( 'field' => "auto_pages", 'val' => "0" ), array('%s', '%s') );
    $ins2 = $wpdb->insert( $table_name, array( 'field' => "auto_posts", 'val' => "1" ), array('%s', '%s') );
    $ins3 = $wpdb->insert( $table_name, array( 'field' => "position", 'val' => "top" ), array('%s', '%s') );
    $ins4 = $wpdb->insert( $table_name, array( 'field' => "lang", 'val' => "it" ), array('%s', '%s') );
    $ins5 = $wpdb->insert( $table_name, array( 'field' => "twitter_via", 'val' => "Cadienvan" ), array('%s', '%s') );
    $ins6 = $wpdb->insert( $table_name, array( 'field' => "twitter_follow", 'val' => "Cadienvan" ), array('%s', '%s') );
    $ins7 = $wpdb->insert( $table_name, array( 'field' => "twitter_hashtag", 'val' => "Cadienvan" ), array('%s', '%s') );
    $ins8 = $wpdb->insert( $table_name, array( 'field' => "twitter_mention", 'val' => "Cadienvan" ), array('%s', '%s') );
    $ins9 = $wpdb->insert( $table_name, array( 'field' => "linkedin_company_id", 'val' => "3288254" ), array('%s', '%s') );
    $ins10 = $wpdb->insert( $table_name, array( 'field' => "linkedin_company_name", 'val' => "Cadienvan Projects" ), array('%s', '%s') );
    $ins11 = $wpdb->insert( $table_name, array( 'field' => "linkedin_public_profile", 'val' => "http://www.linkedin.com/pub/michael-di-prisco/6a/427/aa7" ), array('%s', '%s') );
    $ins12 = $wpdb->insert( $table_name, array( 'field' => "pinterest_profile", 'val' => "Cadienvan" ), array('%s', '%s') );
    $ins13 = $wpdb->insert( $table_name, array( 'field' => "pinterest_img", 'val' => "http://media-cache-ak0.pinimg.com/550x/75/a7/aa/75a7aa68b61a9aae16040046280c5ad0.jpg" ), array('%s', '%s') );
    $ins14 = $wpdb->insert( $table_name, array( 'field' => "pinterest_pin_id", 'val' => "520025088193849096" ), array('%s', '%s') );
    $ins15 = $wpdb->insert( $table_name, array( 'field' => "pinterest_board", 'val' => "avalon" ), array('%s', '%s') );
    $ins16 = $wpdb->insert( $table_name, array( 'field' => "google_plus_id", 'val' => "115849578437408459892" ), array('%s', '%s') );
    $ins17 = $wpdb->insert( $table_name, array( 'field' => "google_plus_page_id", 'val' => "108063110146430216177" ), array('%s', '%s') );
    $ins18 = $wpdb->insert( $table_name, array( 'field' => "google_plus_community_id", 'val' => "101580391460669837908" ), array('%s', '%s') );
    $ins19 = $wpdb->insert( $table_name, array( 'field' => "fb_like_url", 'val' => "http://www.cadienvanprojects.tk" ), array('%s', '%s') );
    $ins20 = $wpdb->insert( $table_name, array( 'field' => "fb_follow_user", 'val' => "Cadienvan.DiPri" ), array('%s', '%s') );
    $ins21 = $wpdb->insert( $table_name, array( 'field' => "askfm_user", 'val' => "askfm" ), array('%s', '%s') );
    $ins22 = $wpdb->insert( $table_name, array( 'field' => "lastfm_apikey", 'val' => "5b3172ad9f94cdf0fa7b0ec19c8296ce" ), array('%s', '%s') );
    $ins23 = $wpdb->insert( $table_name, array( 'field' => "lastfm_location", 'val' => "Milano" ), array('%s', '%s') );
    $ins24 = $wpdb->insert( $table_name, array( 'field' => "youtube_vid", 'val' => "9bZkp7q19f0" ), array('%s', '%s') );
    $ins25 = $wpdb->insert( $table_name, array( 'field' => "youtube_user", 'val' => "Cadienvan" ), array('%s', '%s') );
    $ins26 = $wpdb->insert( $table_name, array( 'field' => "tumblr_user", 'val' => "Microsoft" ), array('%s', '%s') );
    $ins27 = $wpdb->insert( $table_name, array( 'field' => "skype_user", 'val' => "Cadienvan" ), array('%s', '%s') );
    $ins28 = $wpdb->insert( $table_name, array( 'field' => "vimeo_user", 'val' => "brad" ), array('%s', '%s') );
    $ins29 = $wpdb->insert( $table_name, array( 'field' => "steam_user", 'val' => "cadienvan" ), array('%s', '%s') );
    $ins30 = $wpdb->insert( $table_name, array( 'field' => "steam_userid", 'val' => "76561197960435530" ), array('%s', '%s') );
    $ins31 = $wpdb->insert( $table_name, array( 'field' => "steam_apikey", 'val' => "" ), array('%s', '%s') );
    $ins32 = $wpdb->insert( $table_name, array( 'field' => "fb_post", 'val' => "10151471074398553" ), array('%s', '%s') );
    $ins33 = $wpdb->insert( $table_name, array( 'field' => "fb_page", 'val' => "Cadienvan" ), array('%s', '%s') );

}


add_shortcode( 'fb-like', 'fb_like' );
add_shortcode( 'fb-send', 'fb_send' );
add_shortcode( 'fb-share', 'fb_share' );
add_shortcode( 'fb-embed', 'fb_embed' );
add_shortcode( 'fb-follow', 'fb_follow' );
add_shortcode( 'fb-rec-bar', 'fb_rec_bar');
add_shortcode( 'fb-like-box', 'fb_like_box' );
add_shortcode( 'tw-tweets', 'tw_tweets' );
add_shortcode( 'tw-share', 'tw_share' );
add_shortcode( 'tw-follow', 'tw_follow' );
add_shortcode( 'tw-hashtag', 'tw_hashtag' );
add_shortcode( 'tw-mention', 'tw_mention' );
add_shortcode( 'google-share', 'google_share' );
add_shortcode( 'google-follow', 'google_follow' );
add_shortcode( 'google-plus-one', 'google_plus_one' );
add_shortcode( 'google-profile-badge', 'google_profile_badge' );
add_shortcode( 'google-page-badge', 'google_page_badge' );
add_shortcode( 'google-community-badge', 'google_community_badge' );
add_shortcode( 'spotify', 'spotify' );
add_shortcode( 'youtube', 'youtube' );
add_shortcode( 'youtube-subscribe', 'youtube_subscribe' );
add_shortcode( 'tumblr-follow', 'tumblr_follow');
add_shortcode( 'tumblr-share', 'tumblr_share');
add_shortcode( 'in-share', 'in_share' );
add_shortcode( 'in-follow', 'in_follow' );
add_shortcode( 'in-company-profile', 'in_company_profile' );
add_shortcode( 'in-public-profile', 'in_public_profile' );
add_shortcode( 'pin-it', 'pin_it' );
add_shortcode( 'pin-follow', 'pin_follow' );
add_shortcode( 'pin-widget', 'pin_widget' );
add_shortcode( 'pin-profile-widget', 'pin_profile_widget' );
add_shortcode( 'pin-board-widget', 'pin_board_widget' );
add_shortcode( 'vimeo-user', 'vimeo_user' );
add_shortcode( 'vimeo-vids', 'vimeo_vids' );
add_shortcode( 'vimeo-likes', 'vimeo_likes' );
add_shortcode( 'vimeo-appears', 'vimeo_appears' );
add_shortcode( 'vimeo-subs', 'vimeo_subs' );
add_shortcode( 'vimeo-albums', 'vimeo_albums' );
add_shortcode( 'vimeo-channels', 'vimeo_channels' );
add_shortcode( 'vimeo-groups', 'vimeo_groups' );
add_shortcode( 'last-fm', 'last_fm' );
add_shortcode( 'ask-fm', 'ask_fm' );
add_shortcode( 'skype-call', 'skype_call');
add_shortcode( 'steam-appnews', 'steam_appnews' );
add_shortcode( 'steam-user', 'steam_user' );

function social_way_plugin_content($content){
    global $wpdb;
    $list = array();
    $btns = array();
    $return = "";
    $pos = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='position'"), 0);
    $auto_pages = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='auto_pages'"), 0);
    $auto_posts = mysql_result(mysql_query("SELECT val FROM ".SOCIAL_WAY_TABLE_NAME." WHERE field='auto_posts'"), 0);
    $btn_q = $wpdb->get_results("SELECT btn FROM ".SOCIAL_WAY_TABLE_NAME."_btn");
    foreach($btn_q AS $b)
        $btns[] = $b->btn;

    if(is_single()){
        if($auto_posts==1)
            foreach($btns AS $short){
                $sh = '['.str_replace("_", "-", $short).']';
                $return .= do_shortcode($sh);
            }
    }

    if(is_page()){
        if($auto_pages==0){
            $list_q = $wpdb->get_results("SELECT page_id FROM ".SOCIAL_WAY_TABLE_NAME."_pages");
            foreach($list_q AS $l)
                $list[] = $l->page_id;
            if(in_array(get_the_ID(), $list)){
                foreach($btns AS $short){
                    $sh = '['.str_replace("_", "-", $short).']';
                    $return .= do_shortcode($sh);
                }
            }
        }
        else{
            foreach($btns AS $short){
                $sh = '['.str_replace("_", "-", $short).']';
                $return .= do_shortcode($sh);
            }
        }
    }
    if($pos=="top") return $return.$content;
    else            return $content.$return;
}

require_once("admin_page.php");

function fb_like($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $theme = (in_array("dark", $attr)) ? "data-colorscheme='dark'" : "";
    $url = (array_key_exists("url", $attr)) ? $attr['url'] : SOCIAL_WAY_FB_LIKE_URL;
    $width = (array_key_exists("width", $attr)) ? $attr['width'] : "450";
    $faces = (in_array("faces", $attr)) ? "true" : "false";
    $send = (in_array("send", $attr)) ? "true" : "false";
    $layout = (in_array("button", $attr)) ? "data-layout='button_count'" : "";
    if(empty($layout)) $layout = (in_array("box", $attr)) ? "data-layout='box_count'" : "";
    $rec = (in_array("recommend", $attr)) ? "data-action='recommend'" : "";
    $font = (array_key_exists("font", $attr)) ? "data-font='".$attr['font']."'" : "";
    $kids = (in_array("nokids", $attr)) ? "" : "data-kid-directed-site='true'";
    return "<div id=\"fb-root\"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = \"//connect.facebook.net/".$lang."_".strtoupper($lang)."/all.js#xfbml=1&appId=357041161093013\";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<div class=\"fb-like fl\" ".$theme." data-href=\"".$url."\" ".$font." data-width=\"".$width."\" data-show-faces=\"".$faces."\" data-send=\"".$send."\" ".$layout." ".$rec." ".$kids."></div>";
}

function fb_send($attr){
    if(empty($attr)) $attr = array();
    $html = "";
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $url = (array_key_exists("url", $attr)) ? $attr['url'] : SOCIAL_WAY_FB_LIKE_URL;
    $dark = (in_array("dark", $attr)) ? 'data-colorscheme="dark"' : '';
    $font = (array_key_exists("font", $attr)) ? "data-font='".$attr['font']."'" : "";
    $kids = (in_array("nokids", $attr)) ? "" : "data-kid-directed-site='true'";

    return "<div id=\"fb-root\"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = \"//connect.facebook.net/".$lang."_".strtoupper($lang)."/all.js#xfbml=1&appId=357041161093013\";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class='fb-send' ".$kids." data-href='".$url."' ".$dark." ".$font."></div>";
}

function fb_share($attr){
    if(empty($attr)) $attr = array();
    $width = (array_key_exists("width", $attr)) ? $attr['width'] : "626";
    $height = (array_key_exists("height", $attr)) ? $attr['height'] : "436";
    $url = urlencode((array_key_exists("url", $attr)) ? $attr['url'] : SOCIAL_WAY_CURRENT_URL);
    return "
<a href=\"#\"
onclick=\"
window.open(
'https://www.facebook.com/sharer/sharer.php?u=".$url."',
'facebook-share-dialog',
'width=".$width."',
'height=".$height."');
return false;\">
<img src='".SOCIAL_WAY_PLUGIN_URL."/facebook_share.png' />
</a>";
}

function fb_embed($attr){
    if(empty($attr)) $attr = array();
    $html = "";
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $post = (array_key_exists("post", $attr)) ? $attr['post'] : SOCIAL_WAY_FB_POST;

    return "<div id=\"fb-root\"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = \"//connect.facebook.net/".$lang."_".strtoupper($lang)."/all.js#xfbml=1&appId=357041161093013\";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class='fb-post' data-href='https://www.facebook.com/FacebookDevelopers/posts/".$post."'></div>";
}

function fb_follow($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_FB_FOLLOW_USER;
    $theme = (in_array("dark", $attr)) ? "data-colorscheme='dark'" : "";
    $width = (array_key_exists("width", $attr)) ? $attr['width'] : "450";
    $faces = (in_array("faces", $attr)) ? "true" : "false";
    $layout = (in_array("button", $attr)) ? "data-layout='button_count'" : "";
    if(empty($layout)) $layout = (in_array("box", $attr)) ? "data-layout='box_count'" : "";
    $font = (array_key_exists("font", $attr)) ? "data-font='".$attr['font']."'" : "";
    $kids = (in_array("nokids", $attr)) ? "" : "data-kid-directed-site='true'";

    return "<div id=\"fb-root\"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = \"//connect.facebook.net/".$lang."_".strtoupper($lang)."/all.js#xfbml=1&appId=357041161093013\";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<div class=\"fb-follow\" ".$theme." ".$font." ".$kids." data-href=\"https://www.facebook.com/".$user."\" data-width=\"".$width."\" data-show-faces=\"".$faces."\" ".$layout."></div>";
}

function fb_rec_bar($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $site = (array_key_exists("site", $attr)) ? $attr['site'] : SOCIAL_WAY_FB_LIKE_URL;
    $side = (array_key_exists("left", $attr)) ? "data-side=\"left\"" : "";
    $rec = (array_key_exists("recommend", $attr)) ? "data-action=\"recommend\"" : "";
    $exp = (array_key_exists("expand", $attr)) ? $attr['expand'] : "30";
    $num = (array_key_exists("count", $attr)) ? $attr['count'] : "2";
    $max_age = (array_key_exists("max_age", $attr)) ? "data-max_age=".$attr['max_age'] : "";
    return "<div id=\"fb-root\"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = \"//connect.facebook.net/".$lang."_".strtoupper($lang)."/all.js#xfbml=1&appId=357041161093013\";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<div class=\"fb-recommendations-bar\" data-read_time=".$exp." data-num_recommendations=".$num." ".$max_age." data-site=\"".$site."\" ".$side." ".$rec."></div>";
}

function fb_like_box($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $page = (array_key_exists("page", $attr)) ? $attr['user'] : SOCIAL_WAY_FB_PAGE;
    $width = (array_key_exists("width", $attr)) ? $attr['width'] : 292;
    $dark = (in_array("dark", $attr)) ? "data-colorscheme='dark'" : "";
    $faces = (in_array("faces", $attr)) ? "data-show-faces='true'" : "";
    $header = (in_array("header", $attr)) ? "data-header='true'" : "";
    $stream = (in_array("stream", $attr)) ? "data-stream='true'" : "";
    $border = (in_array("border", $attr)) ? "data-show-border='true'" : "";
    return "<div id=\"fb-root\"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = \"//connect.facebook.net/".$lang."_".strtoupper($lang)."/all.js#xfbml=1&appId=357041161093013\";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class='fb-like-box' data-href='https://www.facebook.com/".$page."' data-width='".$width."' ".$dark." ".$faces." ".$header." ".$stream." ".$border."></div>";
}

function tw_tweets($attr){
    wp_register_style( 'socialwaytwitter', plugins_url('socialwaytwitter.css', __FILE__) );
    wp_enqueue_style( 'socialwaytwitter' );
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_TWITTER_FOLLOW;
    $html = file_get_html('https://mobile.twitter.com/'.$user);
    $ret = "";
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : "10";
    $i=0;
    foreach($html->find('table.tweet') as $article) {
        $i++;
        if($i<=$count){
            $avatar = $article->find('.tweet-header img', 0)->src;
            $fullname = $article->find('.tweet-header .fullname', 0)->plaintext;
            $username = str_replace(" ", "", $article->find('.tweet-header .username', 0)->plaintext);
            $timestamp = $article->find('.tweet-header .timestamp', 0)->innertext;
            $tweet = $article->find('.tweet-container .tweet-content .tweet-text div', 0)->innertext;

            $ret .= "<div class='socialway_tweet'>";
            $ret .= "<div class='socialway_tweet_img'>";
            $ret .= "<img src='".$avatar."' height=100% />";
            $ret .= "</div>";
            $ret .= "<div class='socialway_tweet_header'><a href='javascript:void(0)' onclick='window.open(\"https://www.twitter.com/".str_replace("@", "", $username)."\");'>";
            $ret .= "<div class='socialway_tweet_fullname'>".$fullname."</div> ";
            $ret .= "<div class='socialway_tweet_username'>".$username."</div></a>";
            $ret .= "<div class='socialway_tweet_timestamp'>".str_replace(">", "target=_blank >", str_replace("href=\"/", "href=\"https://www.twitter.com/", $timestamp))."</div>";
            $ret .= "</div>";
            $ret .= "<div class='social_way_body'>";
            $ret .= str_replace("/search", "https://www.twitter.com/search", $tweet);
            $ret .= "</div>";
            $ret .= "</div>";
        }
    }
    return $ret;
}

function tw_share($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $large = (in_array('large', $attr)) ? "data-size='large'" : "";
    $url = (array_key_exists("url", $attr)) ? $attr['url'] : SOCIAL_WAY_CURRENT_URL;
    $via = (array_key_exists("via", $attr)) ? $attr['via'] : SOCIAL_WAY_TWITTER_VIA;
    $count = (in_array("count", $attr)) ? "" : "data-count='none'";
    return "<a href=\"https://twitter.com/share\" data-url=\"".$url."\" class=\"twitter-share-button\" data-via=\"".$via."\" ".$large." data-lang=\"".$lang."\" ".$count." >Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
}

function tw_follow($attr){
    if(empty($attr)) $attr = array();
    $follow = (array_key_exists("follow", $attr)) ? $attr['follow'] : SOCIAL_WAY_TWITTER_FOLLOW;
    $large = (in_array("large", $attr)) ? "data-size='large'" : "";
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $count = (in_array("count", $attr)) ? "" : "data-count='none'";
    return "<a href=\"https://twitter.com/".$follow."\" class=\"twitter-follow-button\" ".$count." ".$large." data-lang=\"".$lang."\" >Follow ".$follow." </a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
}

function tw_hashtag($attr){
    if(empty($attr)) $attr = array();
    $hashtag = (array_key_exists("hashtag", $attr)) ? $attr['hashtag'] : SOCIAL_WAY_TWITTER_HASHTAG;
    $large = (in_array("large", $attr)) ? "data-size='large'" : "";
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    return "<a href=\"https://twitter.com/intent/tweet?button_hashtag=".$hashtag."\" class=\"twitter-hashtag-button\" data-related=\"".$hashtag."\" ".$large." data-lang=\"".$lang."\" >Tweet #".$hashtag."</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
}

function tw_mention($attr){
    if(empty($attr)) $attr = array();
    $mention = (array_key_exists("mention", $attr)) ? $attr['mention'] : SOCIAL_WAY_TWITTER_MENTION;
    $large = (in_array("large", $attr)) ? "data-size='large'" : "";
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    return "<a href=\"https://twitter.com/intent/tweet?screen_name=".$mention."\" class=\"twitter-mention-button\" ".$large." data-lang=\"".$lang."\" data-related=\"".$mention."\">Tweet to @".$mention."</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
}

function google_share($attr){
//Accepts annotation="bubble", "vertical-bubble", height="AMOUNT", width="AMOUNT", href="LINK", https://developers.google.com/+/web/share/#available-languages
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $url = (array_key_exists("url", $attr)) ? $attr['url'] : SOCIAL_WAY_CURRENT_URL;
    $annotation = (array_key_exists("annotation", $attr)) ? "annotation='".$attr['annotation']."'" : "";
    $width = (array_key_exists("width", $attr)) ? "width='".$attr['width']."'" : "";
    $height = (array_key_exists("height", $attr)) ? "height='".$attr['height']."'" : "";
    return "<script type=\"text/javascript\">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
window.___gcfg = {
lang: '".$lang."',
parsetags: 'onload'
};
</script>
<g:plus action=\"share\" href='".$url."' ".$annotation." ".$width." ".$height."></g:plus>";
}

function google_follow($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $id = (array_key_exists("id", $attr)) ? $attr['id'] : SOCIAL_WAY_GOOGLE_PLUS_ID;
    $annotation = (array_key_exists("annotation", $attr)) ? "annotation='".$attr['annotation']."'" : "";
    $rel = (in_array("publisher", $attr)) ? "rel='publisher'" : "rel='author'" ;
    return "<script type=\"text/javascript\">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
window.___gcfg = {
lang: '".$lang."',
parsetags: 'onload'
};
</script>
<g:follow href=\"https://plus.google.com/".$id."\" ".$annotation." ".$rel."></g:follow>";
}

function google_plus_one($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $annotation = (array_key_exists("annotation", $attr)) ? "annotation='".$attr['annotation']."'" : "";
    $size = (array_key_exists("size", $attr)) ? "size='".$attr['size']."'" : "";
    $width = (array_key_exists("width", $attr)) ? "width='".$attr['width']."'" : "";
    $height = (array_key_exists("height", $attr)) ? "height='".$attr['height']."'" : "";
    return "<script type=\"text/javascript\">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
window.___gcfg = {
lang: '".$lang."',
parsetags: 'onload'
};
</script>
<g:plusone ".$annotation." ".$size." ".$width." ".$height."></g:plusone>";
}

function google_profile_badge($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $type = (in_array("pic", $attr)) ? "person" : "plus";
    $id = (array_key_exists("id", $attr)) ? $attr['id'] : SOCIAL_WAY_GOOGLE_PLUS_ID;
    $layout = (in_array("landscape", $attr)) ? "layout=landscape" : "layout=portrait";
    $cover = (in_array("coverphoto", $attr)) ? "" : "showcoverphoto=false";
    $tagline = (in_array("tagline", $attr)) ? "" : "showtagline=false";
    $theme = (in_array("dark", $attr)) ? "theme=dark" : "";
    $width = (array_key_exists("width", $attr)) ? "width='".$attr['width']."'" : "";
    $height = (in_array("small", $attr)) ? "height='69'" : "height='131'";
    return "<script type=\"text/javascript\">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
window.___gcfg = {
lang: '".$lang."',
parsetags: 'onload'
};
</script>
<g:".$type." href=\"https://plus.google.com/".$id."\" ".$layout." ".$cover." ".$tagline." ".$theme." ".$width." ".$height." data-rel=\"author\"></g:".$type.">";
}

function google_page_badge($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $type = (in_array("pic", $attr)) ? "page" : "plus";
    $id = (array_key_exists("id", $attr)) ? $attr['id'] : SOCIAL_WAY_GOOGLE_PLUS_PAGE_ID;
    $cover = (in_array("coverphoto", $attr)) ? "" : "showcoverphoto=false";
    $tagline = (in_array("tagline", $attr)) ? "" : "showtagline=false";
    $theme = (in_array("dark", $attr)) ? "theme=dark" : "";
    $width = (array_key_exists("width", $attr)) ? "width='".$attr['width']."'" : "";
    $owners = (in_array("owners", $attr)) ? "showowners='true'" : "";
    $height = (in_array("small", $attr)) ? "height='69'" : "height='131'";

    return "<script type=\"text/javascript\">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
window.___gcfg = {
lang: '".$lang."',
parsetags: 'onload'
};
</script>
<g:".$type." href=\"https://plus.google.com/".$id."\" ".$cover." ".$tagline." ".$theme." ".$owners." ".$width." ".$height." data-rel=\"author\"></g:".$type.">";
}

function google_community_badge($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    $id = (array_key_exists("id", $attr)) ? $attr['id'] : SOCIAL_WAY_GOOGLE_PLUS_COMMUNITY_ID;
    $layout = (in_array("landscape", $attr)) ? "layout=landscape" : "layout=portrait";
    $cover = (in_array("coverphoto", $attr)) ? "" : "showcoverphoto=false";
    $tagline = (in_array("tagline", $attr)) ? "" : "showtagline=false";
    $theme = (in_array("dark", $attr)) ? "theme=dark" : "";
    $width = (array_key_exists("width", $attr)) ? "width='".$attr['width']."'" : "";
    $owners = (in_array("owners", $attr)) ? "showowners='true'" : "";
    return "<script type=\"text/javascript\">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
window.___gcfg = {
lang: '".$lang."',
parsetags: 'onload'
};
</script>
<g:community href=\"https://plus.google.com/communities/".$id."\" ".$layout." ".$cover." ".$tagline." ".$theme." ".$owners." ".$width." data-rel=\"author\"></g:community>";
}

function spotify($attr){
    if(empty($attr)) $attr = array();
    $width = (array_key_exists("width", $attr)) ? $attr['width'] : '300';
    $width = (in_array("widget", $attr)) ? "100%" : $width;

    $search_artist = (array_key_exists("search_artist", $attr)) ? $attr['search_artist'] : "";
    $search_album = urlencode((array_key_exists("search_album", $attr))) ? $attr['search_album'] : "";
    $search = urlencode((array_key_exists("search_track", $attr)) ? $attr['search_track'] : "");

    $artist = (array_key_exists("artist", $attr)) ? $attr['artist'] : "";
    $track = (array_key_exists("track", $attr)) ? $attr['track'] : "";
    $album = (array_key_exists("album", $attr)) ? $attr['album'] : "";


    $view = (in_array("coverart", $attr)) ? "&view=coverart" : "";
    $theme = (in_array("white", $attr)) ? "&theme=white" : "";
    $html = "";
    $h = in_array("big", $attr) ? 380 : 80;
    if(!empty($search_artist)){
        $url = "http://ws.spotify.com/search/1/artist.json?q=".urlencode($search_artist);
        $response = wp_remote_get($url);
        $json = wp_remote_retrieve_body($response);
        $json = json_decode($json, true);
        $pos = (in_array("random", $attr)) ? intval(rand(0, 10)) : 0;
        $html .= '<div class="social_way_spotify_album"><iframe src="https://embed.spotify.com/?uri='.$json['artists'][$pos]['href'].$view.$theme.'" width="'.$width.'" height="'.$h.'" frameborder="0" allowtransparency="true"></iframe></div>';
    }
    else if(!empty($artist))
        $html .= '<div class="social_way_spotify_album"><iframe src="https://embed.spotify.com/?uri='.$artist.$view.$theme.'" width="'.$width.'" height="'.$h.'" frameborder="0" allowtransparency="true"></iframe></div>';
    else if(!empty($album))
        $html .= '<div class="social_way_spotify_album"><iframe src="https://embed.spotify.com/?uri='.$album.$view.$theme.'" width="'.$width.'" height="'.$h.'" frameborder="0" allowtransparency="true"></iframe></div>';
    else if(!empty($track))
        $html .= '<div class="social_way_spotify_track"><iframe src="https://embed.spotify.com/?uri='.$track.$view.$theme.'" width="'.$width.'" height="'.$h.'" frameborder="0" allowtransparency="true"></iframe></div>';
    else if(!empty($search_album)){
        $url = "http://ws.spotify.com/search/1/track.json?q=".urlencode($search_album);
        $response = wp_remote_get($url);
        $json = wp_remote_retrieve_body($response);
        $json = json_decode($json, true);
        $pos = (in_array("random", $attr)) ? intval(rand(0, 10)) : 0;
        $html .= '<div class="social_way_spotify_album"><iframe src="https://embed.spotify.com/?uri='.$json['tracks'][$pos]['album']['href'].$view.$theme.'" width="'.$width.'" height="'.$h.'" frameborder="0" allowtransparency="true"></iframe></div>';
    }
    else if(!empty($search)){
        $info = (in_array("info", $attr)) ? 1 : 0;
        $url = "http://ws.spotify.com/search/1/track.json?q=".urlencode($search);
        $response = wp_remote_get($url);
        $json = wp_remote_retrieve_body($response);
        $json = json_decode($json, true);
        $pos = (in_array("random", $attr)) ? intval(rand(0, 10)) : 0;
        if($info)
            $html .= '<div class="social_way_spotify_album"><iframe src="https://embed.spotify.com/?uri='.$json['tracks'][$pos]['album']['href'].$view.$theme.'" width="'.$width.'" height="'.$h.'" frameborder="0" allowtransparency="true"></iframe></div>';
        $html .= '<div class="social_way_spotify_track"><iframe src="https://embed.spotify.com/?uri='.$json['tracks'][$pos]['href'].$view.$theme.'" width="'.$width.'" height="'.$h.'" frameborder="0" allowtransparency="true"></iframe></div>';

    }
    return $html;
}

function youtube($attr){
    if(empty($attr)) $attr = array();
    $vid = (array_key_exists("vid", $attr)) ? $attr['vid'] : SOCIAL_WAY_YOUTUBE_VID;
    $playlist = (array_key_exists("playlist", $attr)) ? $attr['playlist'] : "";
    $full = (in_array("nofull", $attr)) ? "" : "allowfullscreen";
    $ap = (in_array("autoplay", $attr)) ? 1 : 0;
    $ctrl = (in_array("nocontrols", $attr)) ? "&controls=0" : "";
    $info = (in_array("noinfo", $attr)) ? "&showinfo=0" : "";
    $rel = (in_array("norel", $attr)) ? "&rel=0" : "";
    $theme = (in_array("white", $attr)) ? "light" : "dark";
    $kb = (in_array("nokb", $attr)) ? "&disablekb=1" : "";
    $logo = (in_array("nologo", $attr)) ? "&modestbranding=1" : "";
    $start = (array_key_exists("start", $attr)) ? "&start=".$attr['start'] : "";
    $end = (array_key_exists("end", $attr)) ? "&end=".$attr['end'] : "";

    if($playlist)
        $html = '<iframe width="560" height="315" src="//www.youtube.com/embed/'.$vid.'?listType=playlist&list='.$playlist.'&autoplay='.$start.$end.$ap.$ctrl.$info.$logo.$rel.'&theme='.$theme.$kb.'" frameborder="0" '.$full.'></iframe>';
    else
        $html = '<iframe width="560" height="315" src="//www.youtube.com/embed/'.$vid.'?autoplay='.$start.$end.$ap.$ctrl.$info.$logo.$rel.'&theme='.$theme.$kb.'" frameborder="0" '.$full.'></iframe>';
    return $html;
}

function youtube_subscribe($attr){
    if(empty($attr)) $attr = array();
    include_once "googleplus.php";
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_YOUTUBE_USER;
    $layout = (in_array("big", $attr)) ? "full" : "default";
    $theme = (in_array("dark", $attr)) ? "data-theme='dark'" : "";
    $html= "";
    $html .= '<div class="g-ytsubscribe" data-channel="'.$user.'" data-layout="'.$layout.'" '.$theme.'></div>';
    return $html;
}

function tumblr_follow($attr){
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_TUMBLR_USER;
    $theme = (in_array("dark", $attr)) ? "dark" : "light";
    $btn = (in_array("icon", $attr)) ? 3 : 1;
    if(in_array("follow", $attr)) $btn = 2;
    $html = '<iframe class="btn" frameborder="0" border="0" scrolling="no" allowtransparency="true" height="25"  src="http://platform.tumblr.com/v1/follow_button.html?button_type='.$btn.'&tumblelog='.$user.'&color_scheme='.$theme.'"></iframe>';
    return $html;
}

function tumblr_share($attr){
    if(empty($attr)) $attr = array();
    wp_register_script('socialwaytumblr', 'http://platform.tumblr.com/v1/share.js', array(), 'version', false );
    wp_enqueue_script('socialwaytumblr');
    $gray = (in_array("gray", $attr)) ? "T" : "";
    $btn = (array_key_exists("mode", $attr)) ? $attr['mode'] : "1";
    $width[1] = 91;
    $width[2] = 61;
    $width[3] = 129;
    $width[4] = 20;
    $html = "";
    $html .= '<a href="http://www.tumblr.com/share/link" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:'.$width[$btn].'px; height:20px; background:url(\'http://platform.tumblr.com/v1/share_'.$btn.$gray.'.png\') top left no-repeat transparent;">Share on Tumblr</a>';
    return $html;

}

function in_share($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    include_once "linkedin.php?lang=".$lang;
    $link = (!empty($attr['url'])) ? "data-url='".$attr['url']."'" : "";
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : "none";
    return "<script type='IN/Share' ".$link." data-counter=\"".$count."\"></script>";
}

function in_follow($attr){
    if(empty($attr)) $attr = array();
    $lang = (array_key_exists("lang", $attr)) ? $attr['lang'] : SOCIAL_WAY_LANG;
    include_once "linkedin.php?lang=".$lang;
    $id = (array_key_exists("id", $attr)) ? $attr['id'] : SOCIAL_WAY_LINKEDIN_COMPANY_ID;
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : "none";
    return "<script type=\"IN/FollowCompany\" data-id=\"".$id."\" ".$count."></script>";
}

function in_company_profile($attr){
    include_once "linkedin.php";
    if(empty($attr)) $attr = array();
    $id = (array_key_exists("id", $attr)) ? $attr['id'] : SOCIAL_WAY_LINKEDIN_COMPANY_ID;
    $format = (in_array("click", $attr)) ? "click" : "";
    if(empty($format)) $format = (in_array("inline", $attr)) ? "inline" : "hover";
    $text = (array_key_exists("text", $attr)) ? $attr['text'] : "";
    if(empty($text)) $text = (in_array("text", $attr)) ? SOCIAL_WAY_LINKEDIN_COMPANY_NAME : "";
    return"<script type=\"IN/CompanyProfile\" data-id=\"".$id."\" data-format=\"".$format."\" data-text=\"".$text."\" ></script>";
}

function in_public_profile($attr){
    include_once "linkedin.php";
    if(empty($attr)) $attr = array();
    $prof = (array_key_exists("url", $attr)) ? $attr['url'] : SOCIAL_WAY_LINKEDIN_PUBLIC_PROFILE;
    $format = (in_array("click", $attr)) ? "click" : "";
    if(empty($format)) $format = (in_array("inline", $attr)) ? "inline" : "hover";
    $connections = (in_array("connections", $attr)) ? "" : "data-related=\"false\"";
    return "<script type=\"IN/MemberProfile\" data-id=\"".$prof."\" data-format=\"".$format."\" ".$connections."></script>";
}

function pin_it($attr){
    if(empty($attr)) $attr = array();
    $url = urlencode((array_key_exists("url", $attr)) ? $attr['url'] : SOCIAL_WAY_CURRENT_URL);
    $img = urlencode((array_key_exists("img", $attr)) ? $attr['img'] : SOCIAL_WAY_PINTEREST_IMG);
    $desc = urlencode((array_key_exists("desc", $attr)) ? $attr['desc'] : "No Description");
    return "<script type=\"text/javascript\">
(function(d){
var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
p.type = 'text/javascript';
p.async = true;
p.src = '//assets.pinterest.com/js/pinit.js';
f.parentNode.insertBefore(p, f);
}(document));
</script>
<a href=\"//pinterest.com/pin/create/button/?url=".$url."&media=".$img."&description=".$desc."\" data-pin-do=\"buttonPin\" data-pin-config=\"above\"><img src=\"//assets.pinterest.com/images/pidgets/pin_it_button.png\" /></a>";
}

function pin_follow($attr){
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_PINTEREST_PROFILE;
    return "<script type=\"text/javascript\">
(function(d){
var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
p.type = 'text/javascript';
p.async = true;
p.src = '//assets.pinterest.com/js/pinit.js';
f.parentNode.insertBefore(p, f);
}(document));
</script>
<a data-pin-do=\"buttonFollow\" href=\"http://pinterest.com/".$user."/\">".$user."</a>";
}

function pin_widget($attr){
    if(empty($attr)) $attr = array();
    $id = (array_key_exists("id", $attr)) ? $attr['id'] : SOCIAL_WAY_PINTEREST_PIN_ID;
    return "<script type=\"text/javascript\">
(function(d){
var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
p.type = 'text/javascript';
p.async = true;
p.src = '//assets.pinterest.com/js/pinit.js';
f.parentNode.insertBefore(p, f);
}(document));
</script>
<a data-pin-do=\"embedPin\" href=\"http://pinterest.com/pin/".$id."\"></a>";
}

function pin_profile_widget($attr){
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_PINTEREST_PROFILE;
    $width = (array_key_exists("width", $attr)) ? "data-pin-scale-width=".$attr['width'] : "";
    $height = (array_key_exists("height", $attr)) ? "data-pin-scale-height=".$attr['height'] : "";
    return "<script type=\"text/javascript\">
(function(d){
var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
p.type = 'text/javascript';
p.async = true;
p.src = '//assets.pinterest.com/js/pinit.js';
f.parentNode.insertBefore(p, f);
}(document));
</script>
<a data-pin-do=\"embedUser\" href=\"http://pinterest.com/".$user."/\" ".$width." ".$height." >></a>";
}

function pin_board_widget($attr){
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_PINTEREST_PROFILE;
    $board = (array_key_exists("board", $attr)) ? $attr['board'] : SOCIAL_WAY_PINTEREST_BOARD;
    $width = (array_key_exists("width", $attr)) ? "data-pin-scale-width=".$attr['width'] : "";
    $height = (array_key_exists("height", $attr)) ? "data-pin-scale-height=".$attr['height'] : "";
    return "<script type=\"text/javascript\">
(function(d){
var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
p.type = 'text/javascript';
p.async = true;
p.src = '//assets.pinterest.com/js/pinit.js';
f.parentNode.insertBefore(p, f);
}(document));
</script>
<a data-pin-do=\"embedBoard\" href=\"http://pinterest.com/".$user."/".$board."/\" ".$width." ".$height."></a>";
}

function vimeo_user($attr){
    wp_register_style( 'socialwayvimeo', plugins_url('socialwayvimeo.css', __FILE__) );
    wp_enqueue_style( 'socialwayvimeo' );
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_VIMEO_USER;
    $url = "http://vimeo.com/api/v2/".$user."/info.json";
    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $html = "";
    $type = "Normal";
    $type = ($json['is_staff']) ? "Staff" : $type;
    $type = ($json['is_plus']) ? "Plus" : $type;
    $type = ($json['is_pro']) ? "Pro" : $type;
    $html .= "<div class='social_way_vimeo_user'>";
    $html .= "<div class='social_way_vimeo_name'><a href='".$json['profile_url']."' target=_blank><img src='".$json['portrait_small']."'>".$json['display_name']."</a><span>".$type." Member</span></div>";
    $html .= "<div class='social_way_vimeo_location'>".$json['location']."</div>";
    $html .= "<div class='social_way_vimeo_website'><a href='".$json['url']."' target=_blank>".$json['url']."</a></div>";
    $html .= "<div class='social_way_vimeo_bio'>".$json['bio']."</div>";
    $html .= "<div class='social_way_vimeo_count'><a href='".$json['videos_url']."' target=_blank>".$json['total_videos_uploaded']."</a> Videos, <a href='".str_replace("videos", "likes", $json['videos_url'])."' target=_blank class='social_way_vimeo_likes'>".$json['total_videos_liked']."</a> liked, <a href='".$json['videos_url']."/appears' target=_blank class='social_way_vimeo_appear'>".$json['total_videos_appears_in']."</a> Appears</div>";
    $html .= "</div>";
    return $html;
}

function vimeo_vids($attr){
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_VIMEO_USER;
    $url = "http://vimeo.com/api/v2/".$user."/videos.json";
    $width = (array_key_exists("width", $attr)) ? $attr['width'] : 640;
    $height = (array_key_exists("height", $attr)) ? $attr['height'] : 385;
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 10;
    $title = (in_array("notitle", $attr)) ? "&title=0" : "";
    $byline = (in_array("nobyline", $attr)) ? "&byline=0" : "";
    $portrait = (in_array("noportrait", $attr)) ? "&portrait=0" : "";
    $color = (array_key_exists("color", $attr)) ? "&color=".str_replace("#", "", $attr['color']) : "";
    $autoplay = (in_array("autoplay", $attr)) ? "&autoplay=1" : "";
    $loop = (in_array("loop", $attr)) ? "&loop=1" : "";
    $get = "?".substr($title.$byline.$portrait.$color.$autoplay.$loop, 1);
    $full = (in_array("nofull", $attr)) ? "" : "webkitAllowFullScreen mozallowfullscreen allowFullScreen";

    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $html = "";
    $i = 0;
    foreach($json AS $vid){
        $i++;
        if($i<=$count)
            $html .= '<iframe src="http://player.vimeo.com/video/'.$vid["id"].$get.'" width="'.$width.'" height="'.$height.'" frameborder="0" '.$full.'></iframe>';
    }
    return $html;
}

function vimeo_likes($attr){
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_VIMEO_USER;
    $url = "http://vimeo.com/api/v2/".$user."/likes.json";
    $width = (array_key_exists("width", $attr)) ? $attr['width'] : 640;
    $height = (array_key_exists("height", $attr)) ? $attr['height'] : 385;
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 10;
    $title = (in_array("notitle", $attr)) ? "&title=0" : "";
    $byline = (in_array("nobyline", $attr)) ? "&byline=0" : "";
    $portrait = (in_array("noportrait", $attr)) ? "&portrait=0" : "";
    $color = (array_key_exists("color", $attr)) ? "&color=".str_replace("#", "", $attr['color']) : "";
    $autoplay = (in_array("autoplay", $attr)) ? "&autoplay=1" : "";
    $loop = (in_array("loop", $attr)) ? "&loop=1" : "";
    $get = "?".substr($title.$byline.$portrait.$color.$autoplay.$loop, 1);
    $full = (in_array("nofull", $attr)) ? "" : "webkitAllowFullScreen mozallowfullscreen allowFullScreen";

    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $html = "";
    $i = 0;
    foreach($json AS $vid){
        $i++;
        if($i<=$count)
            $html .= '<iframe src="http://player.vimeo.com/video/'.$vid["id"].$get.'" width="'.$width.'" height="'.$height.'" frameborder="0" '.$full.'></iframe>';
    }
    return $html;
}

function vimeo_appears($attr){
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_VIMEO_USER;
    $url = "http://vimeo.com/api/v2/".$user."/appears_in.json";
    $width = (array_key_exists("width", $attr)) ? $attr['width'] : 640;
    $height = (array_key_exists("height", $attr)) ? $attr['height'] : 385;
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 10;
    $title = (in_array("notitle", $attr)) ? "&title=0" : "";
    $byline = (in_array("nobyline", $attr)) ? "&byline=0" : "";
    $portrait = (in_array("noportrait", $attr)) ? "&portrait=0" : "";
    $color = (array_key_exists("color", $attr)) ? "&color=".str_replace("#", "", $attr['color']) : "";
    $autoplay = (in_array("autoplay", $attr)) ? "&autoplay=1" : "";
    $loop = (in_array("loop", $attr)) ? "&loop=1" : "";
    $get = "?".substr($title.$byline.$portrait.$color.$autoplay.$loop, 1);
    $full = (in_array("nofull", $attr)) ? "" : "webkitAllowFullScreen mozallowfullscreen allowFullScreen";

    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $html = "";
    $i = 0;
    foreach($json AS $vid){
        $i++;
        if($i<=$count)
            $html .= '<iframe src="http://player.vimeo.com/video/'.$vid["id"].$get.'" width="'.$width.'" height="'.$height.'" frameborder="0" '.$full.'></iframe>';
    }
    return $html;
}

function vimeo_subs($attr){
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_VIMEO_USER;
    $url = "http://vimeo.com/api/v2/".$user."/subscriptions.json";
    $width = (array_key_exists("width", $attr)) ? $attr['width'] : 640;
    $height = (array_key_exists("height", $attr)) ? $attr['height'] : 385;
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 10;
    $title = (in_array("notitle", $attr)) ? "&title=0" : "";
    $byline = (in_array("nobyline", $attr)) ? "&byline=0" : "";
    $portrait = (in_array("noportrait", $attr)) ? "&portrait=0" : "";
    $color = (array_key_exists("color", $attr)) ? "&color=".str_replace("#", "", $attr['color']) : "";
    $autoplay = (in_array("autoplay", $attr)) ? "&autoplay=1" : "";
    $loop = (in_array("loop", $attr)) ? "&loop=1" : "";
    $get = "?".substr($title.$byline.$portrait.$color.$autoplay.$loop, 1);
    $full = (in_array("nofull", $attr)) ? "" : "webkitAllowFullScreen mozallowfullscreen allowFullScreen";

    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $html = "";
    $i = 0;
    foreach($json AS $vid){
        $i++;
        if($i<=$count)
            $html .= '<iframe src="http://player.vimeo.com/video/'.$vid["id"].$get.'" width="'.$width.'" height="'.$height.'" frameborder="0" '.$full.'></iframe>';
    }
    return $html;
}

function vimeo_albums($attr){
    wp_register_style( 'socialwayvimeo', plugins_url('socialwayvimeo.css', __FILE__) );
    wp_enqueue_style( 'socialwayvimeo' );
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_VIMEO_USER;
    $url = "http://vimeo.com/api/v2/".$user."/albums.json";
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 10;
    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $html = "";
    $size = "small";
    $size = (in_array("medium", $attr)) ? "medium" : $size;
    $size = (in_array("large", $attr)) ? "large" : $size;
    $i = 0;
    foreach($json AS $album){
        $i++;
        if($i<=$count)
            $html .= "<a class='social_way_vimeo_album' alt='".$album['title']."' title='".$album['title']."' href='".$album['url']."' target=_blank><img src='".$album['thumbnail_'.$size]."' alt='".$album['title']."'></a>";
    }
    return $html;
}

function vimeo_channels($attr){
    wp_register_style( 'socialwayvimeo', plugins_url('socialwayvimeo.css', __FILE__) );
    wp_enqueue_style( 'socialwayvimeo' );
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_VIMEO_USER;
    $url = "http://vimeo.com/api/v2/".$user."/channels.json";
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 10;
    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $html = "";
    $i = 0;
    foreach($json AS $ch){
        $i++;
        if($i<=$count){
            $html .= "<div class='social_way_vimeo_channel'>";
            if(!empty($ch['logo']))
                $html .= "<div class='social_way_vimeo_channel_logo'><a href='".$ch['url']."' target=_blank><img src='".$ch['logo']."'></a></div>";
            $html .= "<div class='social_way_vimeo_channel_title'><a href='".$ch['url']."' target=_blank>".$ch['name']."</a></div>";
            $html .= "<div class='social_way_vimeo_channel_from'>From <a href='".$ch['creator_url']."' target=_blank>".$ch['creator_display_name']."</a></div>";
            $html .= "<div class='social_way_vimeo_channel_desc'>".autolink($ch['description'])."</div>";
            $html .= "</div>";
        }
    }
    return $html;
}

function vimeo_groups($attr){
    wp_register_style( 'socialwayvimeo', plugins_url('socialwayvimeo.css', __FILE__) );
    wp_enqueue_style( 'socialwayvimeo' );
    if(empty($attr)) $attr = array();
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_VIMEO_USER;
    $url = "http://vimeo.com/api/v2/".$user."/groups.json";
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 10;
    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $i = 0;
    $html = "";
    foreach($json AS $group){
        $i++;
        if($i<=$count){
            $html .= "<div class='social_way_vimeo_group'>";
            if(!empty($group['logo']))
                $html .= "<div class='social_way_vimeo_group_logo'><a href='".$group['url']."' target=_blank><img src='".$group['logo']."'></a></div>";
            $html .= "<div class='social_way_vimeo_group_title'><a href='".$group['url']."' target=_blank>".$group['name']."</a></div>";
            $html .= "<div class='social_way_vimeo_group_from'>From <a href='".$group['creator_url']."' target=_blank>".$group['creator_display_name']."</a></div>";
            $html .= "<div class='social_way_vimeo_group_desc'>".autolink($group['description'])."</div>";
            $html .= "</div>";
        }
    }
    return $html;
}

function last_fm($attr){
    wp_register_style( 'socialwaylastfm', plugins_url('socialwaylastfm.css', __FILE__) );
    wp_enqueue_style( 'socialwaylastfm' );
    if(empty($attr)) $attr = array();
    $html = "";
    $loc = (array_key_exists("location", $attr)) ? $attr['location'] : SOCIAL_WAY_LASTFM_LOCATION;
    $apikey = (array_key_exists("apikey", $attr)) ? $attr['apikey'] : SOCIAL_WAY_LASTFM_APIKEY;
    $distance = (array_key_exists("distance", $attr)) ? "&distance=".$attr['distance'] : "";
    $limit = (array_key_exists("count", $attr)) ? $attr['count'] : "10";
    if($limit<=1) $limit=2;
    $url = "http://ws.audioscrobbler.com/2.0/?method=geo.getevents&limit=".$limit."&location=".$loc."&api_key=".$apikey.$distance."&format=json";
    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    foreach ($json['events']['event'] as $event) {
        $artist = "";
        foreach($event['artists']['artist'] AS $ar)
            $artist .= "<a href='http://www.last.fm/music/".$ar."'' target=_blank>".$ar."</a>, ";
        $artist = substr($artist, 0, strlen($artist)-2);
        $id = $event['venue']['id'];
        $venue = $event['venue']['name'];
        $city = $event['venue']['location']['city'];
        $country = $event['venue']['location']['country'];
        $street = $event['venue']['location']['street'];
        $postalcode = $event['venue']['location']['postalcode'];
        $lasturl = $event['venue']['url'];
        $website = $event['venue']['website'];
        $date = $event['startDate'];
        $desc = $event['description'];
        $imgs = array();
        foreach($event['venue']['image'] AS $img)
            $imgs[$img['size']] = $img['#text'];
        $img = (!empty($imgs['medium'])) ? $imgs['medium'] : $imgs['small'];
        $img = (!empty($imgs['large'])) ? $imgs['large'] : $imgs['medium'];
        $img = (!empty($imgs['extralarge'])) ? $imgs['extralarge'] : $imgs['large'];
        $img = (!empty($imgs['mega'])) ? $imgs['mega'] : $imgs['extralarge'];


        $html .= "<div class='social_way_lastfm'>";
        $html .= "<div class='social_way_lastfm_header'>";
        $html .= "<div class='social_way_lastfm_logo'><a href='http://www.last.fm/venue/".$id."' target=_blank><img src='".$img."' ></a></div>";
        $html .= "<div class='social_way_lastfm_title'><h2><a href='http://www.last.fm/venue/".$id."'' target=_blank>".$event['title']."</a></h2></div>";
        $html .= "<div class='social_way_lastfm_artist'>".$artist."</div>";
        $html .= "<div class='social_way_lastfm_place'><a href='https://maps.google.ie/?q=".$venue." - ".$street.", ".$city.", ".$country."'' target=_blank>".$venue." - ".$street.", ".$city.", ".$country."</a></div>";
        $html .= "<div class='social_way_lastfm_date'>".$date."</div>";
        $html .= "<div class='social_way_lastfm_website'><a href='".$website."'' target=_blank>".$website."</a></div>";
        $html .= "</div>";
        $html .= "<div class='social_way_lastfm_body'>";
        $html .= "<div class='social_way_lastfm_desc'>".$desc."</div>";
        $html .= "<div class='social_way_lastfm_lasturl'><a href='".$lasturl."' target=_blank>Last.fm</a></div>";
        $html .= "</div>";
        $html .= "</div>";


    }
    return $html;
}

function ask_fm($attr){
    wp_register_style( 'socialwayask', plugins_url('socialwayask.css', __FILE__) );
    wp_enqueue_style( 'socialwayask' );
    if(empty($attr)) $attr = array();
    include_once(ABSPATH . WPINC . '/rss.php');
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_ASKFM_USER;
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 20;
    $rss = fetch_rss("http://ask.fm/feed/profile/".$user.".rss");
    $i=0;
    $html = "";
    foreach($rss AS $q)
        foreach($q AS $q2){
            $i++;
            if($i<=$count){
                $title = $q2['title'];
                $desc = autolink($q2['description']);
                $date = $q2['pubdate'];
                $link = $q2['link'];
                $html .= "<div class='socialway_ask'>";
                $html .= "<div class='socialway_ask_header'>";
                $html .= "<div class='socialway_ask_title'><h2>".$title."</h2></div>";
                $html .= "<div class='socialway_ask_date'> (".$date.")</div>";
                $html .= "</div>";
                $html .= "<div class='socialway_ask_desc'>".$desc."</div>";
                $html .= "<div class='socialway_ask_link'><a href='".$link."' target=_blank>Read It!</a></div>";
                $html .= "</div>";
            }
        }
    return $html;

}

function skype_call($attr){
    if(empty($attr)) $attr = array();
    include_once ("skype.php");
    $rand = rand(1, 100000);
    $img = (in_array("big", $attr)) ? 32 : 16;
    $chat = (in_array("chat", $attr)) ? "chat" : "call";
    if(in_array("dropdown", $attr)) $chat="dropdown";
    $color = (in_array("white", $attr)) ? "white" : "skype";
    $participants = (in_array("list", $attr)) ? 'listParticipants: "true",' : "";
    $user = (array_key_exists("user", $attr)) ? $attr['user'] : SOCIAL_WAY_SKYPE_USER;
    $html = '<div id="skype_call'.$rand.'">
    <script type="text/javascript">
        Skype.ui({
            name: "'.$chat.'",
            element: "skype_call'.$rand.'",
            participants: ["'.$user.'"],
            '.$participants.'
                imageColor: "'.$color.'",
            imageSize: '.$img.'

        });
    </script>
</div>';
    return $html;
}

function steam_user($attr){
    wp_register_style( 'socialwaysteam', plugins_url('socialwaysteam.css', __FILE__) );
    wp_enqueue_style( 'socialwaysteam' );
    if(empty($attr)) $attr = array();
    $apikey = (array_key_exists("apikey", $attr)) ? $attr['apikey'] : SOCIAL_WAY_STEAM_APIKEY;
    $id = (array_key_exists("id", $attr)) ? $attr['id'] : SOCIAL_WAY_STEAM_USERID;
    $games = (in_array("games", $attr)) ? 1 : 0;
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 100;
    $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$apikey."&steamids=".$id;
    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $html = "";
    foreach($json['response']['players'] AS $pl){
        $html .= "<div class='social_way_steam_user'>";
        $style = ($games) ? "style='padding-bottom: 4px; border-bottom: 2px solid #65635F; margin-bottom: 8px;'" : "";
        $img = $pl['avatar'];
        $img = (in_array("medium", $attr)) ? $pl['avatarmedium'] : $img;
        $img = (in_array("large", $attr)) ? $pl['avatarfull'] : $img;
        $html .= "<div class='social_way_steam_name' ".$style."><a href='".$pl['profileurl']."' target=_blank><img src='".$img."'> <span class='realname'>".$pl['realname']."</span> <span class='personaname'>(".$pl['personaname'].")</span></a></div>";
        if($games){

            $html .= "<div class='social_way_steam_games'>";
            $url2 = (in_array("recent", $attr)) ? "http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key=".$apikey."&steamid=".$id."&format=json" : "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=".$apikey."&include_appinfo=1&steamid=".$id."&format=json";
            $response2 = wp_remote_get($url2);
            $json2 = wp_remote_retrieve_body($response2);
            $json2 = json_decode($json2, true);
            $game_list = array();
            foreach($json2['response']['games'] AS $g)
                $game_list[$g['appid']] = $g['playtime_forever'];
            //arsort($game_list);
            array_multisort($game_list, SORT_DESC, $json2['response']['games']);
            $i = 0;
            foreach($json2['response']['games'] AS $game)
                if($game['playtime_forever']>0){
                    $i++;
                    if($i<=$count){
                        $img = $game['img_logo_url'];
                        //$img = ($game['playtime_forever']>72) ? $game['img_logo_url'] : $game['img_icon_url'];
                        $html .= "<a href='http://store.steampowered.com/app/".$game['appid']."' target=_blank><img src='http://media.steampowered.com/steamcommunity/public/images/apps/".$game['appid']."/".$img.".jpg'> ".$game['name']." (".$game['playtime_forever']." Hours)</a>";
                    }
                }
            $html .= "</div>";
        }
        $html .= "</div>";
    }
    return $html;
}

function steam_appnews($attr){
    wp_register_style( 'socialwaysteam', plugins_url('socialwaysteam.css', __FILE__) );
    wp_enqueue_style( 'socialwaysteam' );
    if(empty($attr)) $attr = array();
    $appid = (array_key_exists("appid", $attr)) ? $attr['appid'] : 420;
    $count = (array_key_exists("count", $attr)) ? $attr['count'] : 3;
    $url = "http://api.steampowered.com/ISteamNews/GetNewsForApp/v0002/?appid=".$appid."&count=".$count."&maxlength=300&format=json";
    $response = wp_remote_get($url);
    $json = wp_remote_retrieve_body($response);
    $json = json_decode($json, true);
    $html = "";
    foreach($json['appnews']['newsitems'] AS $news){
        $html .= "<div class='social_way_steam_appnews'>";
        $html .= "<div class='social_way_steam_title'><a href='".$news['url']."' target=_blank>".$news['title']."</a></div>";
        $html .= "<div class='social_way_steam_author'>".$news['author']."</div>";
        $html .= "<div class='social_way_steam_content'>".$news['contents']."</div>";
        $html .= "</div>";
    }
    return $html;
}

?>