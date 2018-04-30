<?php
/*
 * Plugin Name: UsersManager
 * Plugin URI:  https://wordpress.org/plugins/usersmanager
 * Description: UsersManager ti consente di creare e gestire pagamenti ricorrenti
 * Version:     1.0.0
 * Author:      Stackhouse
 * Author URI:  https://www.stackhouse.it
 * Text Domain: UsersManager
 * License:     GPL-2.0+
 * License URI: http://www.usersmanager.com/terms
 */

$env_um = 'www';
function usrmng_add_menu_items() {
    $settings_name='UsersManager'; //Plugin Name Side Menu
    add_menu_page(
        $settings_name,
        $settings_name,
        "manage_options",
        "theme-options",
        "usrmng_theme_options",
        plugin_dir_url( __FILE__ ) . 'public/images/usersmanager-18.png',
        100
    );
}
function usrmng_get_tab() {
    $titles = array("Page","Background Color","Page Preview");
    $names = array("url","color","preview");
    for ($i = 0; $i <= 2 ; $i++) {
        add_settings_field("usrmng_".$names[$i], $titles[$i], "usrmng_".$names[$i]."_code", "theme-options", "header_section");
        register_setting("header_section", "usrmng_" . $names[$i]);
    }
}
function usrmng_theme_options() {
$logo = plugin_dir_url( __FILE__ ) . 'public/images/logousers.png';
echo <<<EOF
<div id="usrmngThemeOptions" class=\"usersmanager\">
    <div class="usrmngCentered">
    <img id="usrmngAdminLogo" src='$logo'/>
        <div id="usrmngThemeSubtitle">
            UsersManager ti consente di creare e gestire pagamenti ricorrenti
        </div>
    </div>
</div>
EOF;
$tab_name = "Settings";
    ?>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h1><?php echo $option_title; ?></h1>
            </h2>
            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php
                    settings_fields("header_section");
                    do_settings_sections("theme-options");
                    submit_button();   
                ?>
            </form>
        </div>
    <?php 
}
function usrmng_view_options() {
    $theme_header_title = "";
    add_settings_section("header_section", $theme_header_title, "usrmng_optional_header_content", "theme-options");
    usrmng_get_tab();    
}
function usrmng_upload_file($options) {
    if(!empty($_FILES["background_picture"]["tmp_name"])) {
        $urls = wp_handle_upload($_FILES["background_picture"], array('test_form' => FALSE));
        $temp = $urls["url"];
        return $temp;  
    }
    return get_option("background_picture");
}

function usrmng_url_code() {
    global $env_um;
    $url = get_option('usrmng_url'); 
    echo <<<EOF
        <input id="usrmng_url" class="usrmngAdminTextBox" type="text" onkeyup="checkUrlInput()" placeholder="Inserisci il nome della tua pagina" name="usrmng_url" value="$url" />
        <h4 id="users_error_message" class="usrmngColor"></h4>
        <h4>Non hai ancora una pagina su usersmanager?  <a target="_blank" href="https://$env_um.usersmanager.com/create">Clicca qui</a> per creare una pagina</h4>
EOF;
}
function usrmng_optional_header_content(){ echo ""; }
function usrmng_color_code() {
    if(get_option('usrmng_color') == "#000") $color = "#FFF";
    else $color = get_option('usrmng_color');
    if($color == '') $color = '#ffffff';
    echo <<<EOF
    <div class="usrmngFlex1">
        <input id="usrmngColorPicker" type="color" onchange="clickColor(this)" value="$color">
        <input id="usrmng_color" class="usrmngAdminTextBox" name="usrmng_color" placeholder="Inserisci il colore esadecimale" value="$color">
        <span id="usrmngEmptySpace"></span>
        <input type="submit" name="submit" id="submit" class="usrmngSaveChanges" class="button button-primary" value="Save Changes">
    </div>
EOF;
}
function usrmng_preview_code() {
    $url = get_option('usrmng_url');
    $bgcolor = substr(get_option( 'usrmng_color' ), 1);
    $bgcard = substr(get_option( 'usrmng_bgcard' ), 1);
    global $env_um;
    if($url != ""){
        echo <<<EOF
        <div>
            <iframe id="myIframeUsersManager-$url" class="iframeusersmanager" src="https://$env_um.usersmanager.com/widget?page=$url&bgcolor=$bgcolor" scrolling="no" frameBorder="0"></iframe>
            <script>usrmngResize("$url");</script>
        </div>   
        <div id="usrmngTextTutorial">
        Per visualizzare i prodotti <span class="usrmngColor">UsersManager</span> nelle tue pagine basta utilizzare il tag apposito.
        <br/>
        Puoi inserirlo attraverso l'editor delle pagine così come segue:
        <br/><br/><span class="usrmngColor">[usersmanager]</span>
        </div>
EOF;
}
    else echo "<h4>Preview non disponibile. Non hai inserito ancora nessuna pagina UsersManager</h4>";
}
//HEADER
add_action('admin_head', 'usrmng_set_head');
function usrmng_set_head() {
echo <<<EOF
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
EOF;
}
//SHORTCODE
function usrmng_shortcode( $atts, $content = null ) { 
    ob_start();
    $id = "";
    $tags = "";
    $layout = "";
    $height = '600';
    $url = get_option( 'usrmng_url' );
    $page = $url;
    $env_um = $GLOBALS['env_um'];
    $height = get_option( 'usrmng_height' );
    $bgcard = substr(get_option( 'usrmng_bgcard' ), 1);
    $bgcolor = substr(get_option( 'usrmng_color' ), 1);
    if (is_array($atts) && isset($atts['id'])) $id = $atts['id'];
    if (is_array($atts) && isset($atts['env'])) $env = $atts['env'];
    if (is_array($atts) && isset($atts['page'])) $page = $atts['page'];
    if (is_array($atts) && isset($atts['tags'])) $tags = $atts['tags'];
    if (is_array($atts) && isset($atts['layout'])) $layout = $atts['layout'];
    if (is_array($atts) && isset($atts['bgcard'])) $bgcard = $atts['bgcard'];
    if (is_array($atts) && isset($atts['bgcolor'])) $bgcolor = $atts['bgcolor'];
    echo <<<EOF
    <iframe id="myIframeUsersManager-$page" class="iframeusersmanager" src="https://$env_um.usersmanager.com/widget?page=$page&bgcolor=$bgcolor&id=$id&tags=$tags&layout=$layout" scrolling="no" frameBorder="0"></iframe>
    <script>usrmngResize("$page");</script>
EOF;
    return ob_get_clean();
}
add_shortcode( 'usersmanager', 'usrmng_shortcode' );
//QUICKTAG
function usrmng_quicktag() {
    if (wp_script_is('quicktags')){
    echo <<<EOF
    <script type="text/javascript"> QTags.addButton( 'usersmanager', 'Users Manager', '[usersmanager]', '', 'usersmanager', 'UsersManager', 1 ); </script>
EOF;
    }
}
//SCRIPTS
function usrmng_scripts() {
wp_register_script( 'usrmng-script-js', plugin_dir_url( __FILE__ ) . '/public/js/script.js', '', '', false);
wp_enqueue_script('usrmng-script-js');
wp_register_script( 'usrmng-resizer-js', plugin_dir_url( __FILE__ ) . '/public/js/usrmng_resizer.js', '', '', false);
wp_enqueue_script('usrmng-resizer-js');
}
//STYLES
wp_enqueue_style( 'usrmng-style', plugin_dir_url( __FILE__ ) . '/public/css/style.css',false,'','all');

add_action( 'wp_enqueue_scripts', 'usrmng_scripts' );
add_action( 'admin_enqueue_scripts', 'usrmng_scripts' );
add_action( 'admin_menu' , 'usrmng_add_menu_items' );
add_action( 'admin_print_footer_scripts', 'usrmng_quicktag' );   
add_action( 'admin_init', 'usrmng_view_options' );
