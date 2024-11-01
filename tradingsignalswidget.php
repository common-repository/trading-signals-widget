<?php

/*

Plugin Name: Trading Signals Widget

Plugin URI: http://www.tradingsignalsgadget.com/

Description: The Trading Signals Widget Displays a chart with the score of our proprietary trading signals algorithm on it with brief instructions as to how to use it <a href="http://www.tradingsignalsgadget.com/Usage.html">here</a>. <strong>External links to terms and disclaimer files should not be removed from the widget. Webmasters wishing to remove the links (nofollow links to non-indexed pages) should not use this widget</strong>.

Author: Barry Livingstone

Version: 0.1.4.7

Author URI: http://onefineham.com/

*/



/*  Copyright 2012  Barry Livingstone  (email : webmaster@onefineham.com)



    This program is free software; you can redistribute it and/or modify

    it under the terms of the GNU General Public License, version 2, as 

    published by the Free Software Foundation.



    This program is distributed in the hope that it will be useful,

    but WITHOUT ANY WARRANTY; without even the implied warranty of

    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

    GNU General Public License for more details.



    You should have received a copy of the GNU General Public License

    along with this program; if not, write to the Free Software

    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/



class TradingSignalsWidget extends WP_Widget

{



  function TradingSignalsWidget()

  {

    $widget_ops = array('classname' => 'TradingSignalsWidget', 'description' => 'Displays our Risk Gauge Score' );

    $this->WP_Widget('TradingSignalsWidget', 'Risk Gauge Score', $widget_ops);

  function tsw_css_enqueue() 

  {

    // Register the style like this for a plugin:  

    wp_register_style( 'trading-signals-widget-style', plugins_url( '/trading-signals-widget.css', __FILE__ ), array(), '1.0', 'all' );  

	wp_enqueue_style('trading-signals-widget-style');

					}

add_action( 'wp_print_styles', 'tsw_css_enqueue' );

  }



  function form($instance)

  {

    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

    $title = $instance['title'];

?>

  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

<?php

  }

 

  function update($new_instance, $old_instance)

  {

    $instance = $old_instance;

    $instance['title'] = $new_instance['title'];

    return $instance;

  }

 

  function widget($args, $instance)

  {

    extract($args, EXTR_SKIP);



    echo $before_widget;

    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

 

    if (!empty($title))

      echo $before_title . $title . $after_title;;





    // WIDGET CODE GOES HERE

   echo "<div class='tsw-css'><center><img src='https://docs.google.com/spreadsheet/oimg?key=0AvvUG0bOJhmvdDYtOFdqdlZhVjJaRzlUeTVaNHRPUFE&oid=9&zx=6va7mulyqlt1' alt='Not for Live Trading' id='tsw-score'/></center>";

   echo "<center>Score Dynamically Updates Once Per Minute During Global Market Hours<br/><a href='http://www.tradingsignalsgadget.com/Disclaimer.html' rel='external nofollow'>Disclaimer</a> | <a href='http://www.tradingsignalsgadget.com/Terms.html' rel='external nofollow'>Terms</a> | <a href='http://www.tradingsignalsgadget.com/buy_datasets.html' title='Historical datasets now available' rel='external nofollow'>Datasets</a></center></div>";



   echo $after_widget;

   $src = plugins_url('tsw-updater.js', __FILE__);

wp_register_script( 'tsw-js', $src );

wp_enqueue_script( 'tsw-js' );



add_action('init','tsw_test_init');

function tsw_test_init() {

    wp_enqueue_script( 'tsw-js', plugins_url( '/tsw-updater.js', __FILE__ ));

			}

  }

}

add_action( 'widgets_init', create_function('', 'return register_widget("TradingSignalsWidget");') );?>