<?php
/*
Plugin Name: Simply Excerpts
Plugin URI: http://www.shooflysolutions.com/simply-excerpt/
Description: Simply modify the number of words and replace the elipsis (...) with text for excerpts
Version: 1.2
Author: A. R. Jones
Author URI: http://shooflysolutions.com
*/

/*
Copyright (C) 2015 Shoofly Solutions
Contact me at http://www.shooflysolutions.com

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/
/*
/*
* Customize Read More Link. May be overriden by other plugins like Advanced Excerpt
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
new sfly_simply_excerpts();
/**
 * sfly_simply_excerpts class.
 */
class sfly_simply_excerpts
{
    var  $postid;
    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
           add_action( 'admin_menu', array( $this, 'sfly_excerpt_menu_settings' ) ); //Add an admin menu
           add_action( 'admin_init', array( $this, 'sfly_excerpt_init_settings' ) ); //Do Initialization stuff
    }

    /**
     * sfly_excerpt_menu_settings function.
     * Add a menu item
     * @access public
     * @return void
     */
    function sfly_excerpt_menu_settings() {

        add_options_page( "Simply Excerpts Settings", "Simply Excerpts Settings", 'manage_options', 'sfly_excerpt_settings',
                         array($this, 'sfly_display_menu_settings' ) );
    }
    //Register thumbnail settings

     /**
      * sfly_excerpt_init_settings function.
      * Register settings
      * @access public
      * @return void
      */
     function sfly_excerpt_init_settings()
    {

        register_setting( 'sfly_simply_excerpt','sfly_simply_excerpt_words_enabled' );
        register_setting( 'sfly_simply_excerpt', 'sfly_simply_excerpt_words' );
        register_setting( 'sfly_simply_excerpt','sfly_simply_excerpt_read_more_enabled' );
        register_setting( 'sfly_simply_excerpt', 'sfly_simply_excerpt_read_more' );


    }
    //Admin menu settings
    /**
     * sfly_display_menu_settings function.
     * Create a settings page
     * @access public
     * @return void
     */
    function sfly_display_menu_settings() {

        ?>
        </pre>
        <div class="wrap" style="width:80%; margin: auto">
         <div style="width: 400px; float: left">
                <form action="options.php" method="post" name="sfly_tgrid_options"><!--send to the Options.Php file-->

                <?php
                   settings_fields( 'sfly_simply_excerpt' );
                   $sfly_simply_excerpt_words_enabled = get_option( 'sfly_simply_excerpt_words_enabled', 0 );
                   $sfly_simply_excerpt_words = get_option( 'sfly_simply_excerpt_words', 55 );
                   $sfly_simply_excerpt_read_more = get_option( 'sfly_simply_excerpt_read_more', 'Read the rest' );
                   $sfly_simply_excerpt_read_more_enabled = get_option( 'sfly_simply_excerpt_read_more_enabled', 0 );

                ?>
                <h2>Simply Excerpts Settings</h2>
                <h3>Check to enable feature</h3>
                <div style="padding-bottom: 10px">
                <div>
                    <p>Maximum number of words to display in an excerpt</p>
                    <input type="checkbox" id="sfly_simply_excerpt_words_enabled" name="sfly_simply_excerpt_words_enabled" <?php if($sfly_simply_excerpt_words_enabled=="1") echo 'checked="checked"'; ?> value="1"></input>

                     <input name="sfly_simply_excerpt_words" id="sfly_simply_excerpt_words" type="number" value="<?php echo $sfly_simply_excerpt_words?>"></input>
               </div>
                <div>
                       <p>Read More Text</p>
             <input type="checkbox" id="sfly_simply_excerpt_read_more_enabled" name="sfly_simply_excerpt_read_more_enabled" <?php if($sfly_simply_excerpt_read_more_enabled=="1") echo 'checked="checked"'; ?> value="1"></input>
                    <input type="text" id="sfly_simply_excerpt_read_more" name="sfly_simply_excerpt_read_more" value="<?php echo $sfly_simply_excerpt_read_more?>"></input>
               </div>
                 </div>
                 <div style="text-align:center; padding:10px;"><input type="submit" name="Submit" value="Update" /></div></form>
           </div>

          <div style="margin: 40px auto; width:250px; float:right;border: black 1px solid;padding-left: 25px;padding-bottom: 25px;">
             <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <h3>Thank you for using our plugin. Donations for extended support are appreciated but never required!</h3>
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="NERK4N9L2QSUL">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            <div >
                <a href="">Rate this plugin!</a>
            </div>
        </div>

         </div>
       <pre>
    <?php

    }
}
/**
 *Set the Read More Text
 *
 * @param int length - Number of words displayed ine xcerpt
 */

 if ( !function_exists( 'sfly_modify_read_more_link' ) ):
    /**
     * sfly_modify_read_more_link function.
     * Modify the Read More Link
     * @access public
     * @return void
     */
    function sfly_modify_read_more_link() {
         $sfly_simply_excerpt_read_more = esc_attr ( get_option( 'sfly_simply_excerpt_read_more', 'Read the rest' ) );
        return '<div><a class="more-link" href="' . get_permalink() . '">' . $sfly_simply_excerpt_read_more . '</a></div>';
    }
endif;
if ( get_option( 'sfly_simply_excerpt_read_more_enabled', false ) == "1" )
    add_filter( 'excerpt_more', 'sfly_modify_read_more_link' );

/**
 *Set the Excerpt Word Length.
 *
 * @param int length - Number of words displayed ine xcerpt
 */

if ( !function_exists( 'sfly_simply_excerpt_words' ) ):
    /**
     * sfly_simply_excerpt_words function.
     * Set the number of words
     * @access public
     * @param mixed $length
     * @return void
     */
    function sfly_simply_excerpt_words( $length ) {
	    return  $sfly_simply_excerpt_words = esc_attr(get_option( 'sfly_simply_excerpt_words', '55' ) );
    }
endif;
if (get_option( 'sfly_simply_excerpt_words_enabled', false) == "1" )
    add_filter( 'excerpt_length', 'sfly_simply_excerpt_words', 999 );

?>