<?php
/*
Plugin Name: My School Holidays
Version: 1.0
Plugin URI: http://myschoolholidays.com
Description: Embed a school holiday countdown or calendar widget showing school holiday and term dates in a blog post or in your sidebar.  My School Holidays has most countries covered so all you will need to do is search for your school or district and drag the widget into your sidebar.  Shortcode options are available and can be seen on the Settings -> My School Holidays page.
Author: Primary Technology
Author URI: http://primaryt.co.uk
*/


/*
* Default options settings
*/

function School_Holidays_get_options(){
  $School_Holidays_options = get_option('School_Holidays_options');
  if (!isset($School_Holidays_options["settings_school_name"])) {
    $School_Holidays_options["settings_school_name"] = "";
  }
  
  if (!isset($School_Holidays_options["settings_school_id"])) {
    $School_Holidays_options["settings_school_id"] = 1;
  }
  
  if (!isset($School_Holidays_options["settings_school_url"])) {
    $School_Holidays_options["settings_school_url"] = "";
  }

  if (!isset($School_Holidays_options["settings_style"])) {
    $School_Holidays_options["settings_style"] = "small";
  }
  
  if (!isset($School_Holidays_options["settings_showlink"])) {
    $School_Holidays_options["settings_showlink"] = "yes";
  }

  add_option('School_Holidays_options', $School_Holidays_options);
  return $School_Holidays_options;
}


/*
* Adding School Holidays point to admin menu
*/

function School_Holidays_add_page(){
  global $current_user;

  if(current_user_can('manage_options')){
      add_options_page('My School Holidays', 'My School Holidays', 6, __FILE__, 'School_Holidays_configuration_page');
  }
}
add_action('admin_menu', 'School_Holidays_add_page');


/*
* Initialize text domain for other languages
*/

function init_textdomain_School_Holidays() {
    load_plugin_textdomain('School_Holidays', PLUGINDIR . '/' . dirname(plugin_basename (__FILE__)) . '/lang');
}

add_action('init', 'init_textdomain_School_Holidays');


/*
* School Holidays Admin page layout
*/

function School_Holidays_configuration_page(){
  global $wpdb;

  $School_Holidays_options = School_Holidays_get_options();

  if (isset($_POST['submit'])) {
    if (empty($_POST['settings_showlink'])) $_POST['settings_showlink'] = "no";
    
    $School_Holidays_options['settings_school_name']   = $_POST['settings_school_name'];
    $School_Holidays_options['settings_school_id']     = $_POST['settings_school_id'];
    $School_Holidays_options['settings_school_url']    = $_POST['settings_school_url'];
    $School_Holidays_options['settings_style']         = $_POST['settings_style'];
    $School_Holidays_options['settings_showlink']      = $_POST['settings_showlink'];
    
    update_option('School_Holidays_options', $School_Holidays_options);
  }
  
  $dir = '../'.PLUGINDIR.'/'.dirname(plugin_basename (__FILE__)).'/';
?>
<link rel='stylesheet' href='<?php echo $dir; ?>css/main.css' type='text/css' media='all' /> 
<script type="text/javascript" src="<?php echo $dir; ?>js/main.js"></script>

<form method="post" action="">
<div class="wrap">
  <h2><?php _e('My School Holidays', 'School_Holidays'); ?></h2>

  <div class="mt-20">
    <div style='background:url("<?php echo $dir; ?>/img/search_f.png") no-repeat scroll 0 0 transparent;font-size: 18px;padding: 16px 0 10px 40px;'>Search by School Name or Council</span>
  </div>
  
  <div class="mt-20">
    <div class="ds-container" id="ds-container-fb">
      <input type="text" id="fb" placeholder="<?php _e('Search by School Name or Council', 'School_Holidays'); ?>" autocomplete="off" x-webkit-speech="" class="ds-input" name="settings_school_name" value="<?php echo $School_Holidays_options['settings_school_name']; ?>" />
      <div class="ds-results" id="ds-results-fb" style="display: none; ">
        <ul class="ds-list" style="width: 500px;"></ul>
      </div>
    </div>
    <input type="hidden" name="settings_school_id" id="id_settings_school" value="<?php echo $School_Holidays_options['settings_school_id']; ?>" />
    <input type="hidden" name="settings_school_url" id="url_settings_school" value="<?php echo $School_Holidays_options['settings_school_url']; ?>" />
  </div>
  <div class="mt-20">
    <div><h3><?php _e('Choose style', 'School_Holidays'); ?></h3></div>
    <div class="mt-20">
      <div>
        <input type="radio" name="settings_style" value="classic" id="settings_style-5" <?php if ($School_Holidays_options['settings_style'] == "classic") echo 'checked="checked"';?> />
        <label for="settings_style-5" style="font-size:17px;"><?php _e('Classic School Holiday Countdown', 'School_Holidays'); ?></label>
      </div>
      <div class="shortcode-for-style">[SchoolHolidays id="<span><?php echo $School_Holidays_options['settings_school_id']; ?></span>" type="classic"]</div>
      <div><iframe width="275" height="150" allowtransparency="true" frameborder=0 scrolling=no id="schools-frame-classic" src="http://myschoolholidays.com/plugin.php?type=4&s=<?php echo $School_Holidays_options['settings_school_id']; ?>"></iframe></div>
    </div>

    <div class="mt-20">
      <div>
        <input type="radio" name="settings_style" value="small" id="settings_style-1" <?php if ($School_Holidays_options['settings_style'] == "small") echo 'checked="checked"';?> /> 
        <label for="settings_style-1" style="font-size:17px;"><?php _e('Small Holiday Countdown', 'School_Holidays'); ?></label>
      </div>
      <div class="shortcode-for-style">[SchoolHolidays id="<span><?php echo $School_Holidays_options['settings_school_id']; ?></span>" type="small"]</div>
      <div><iframe width="280" height="330" allowtransparency="true" frameborder=0 scrolling=no id="schools-frame-small" src="http://myschoolholidays.com/plugin.php?type=3&s=<?php echo $School_Holidays_options['settings_school_id']; ?>;"></iframe></div>
    </div>
    <div class="mt-20">
      <div>
        <input type="radio" name="settings_style" value="large" id="settings_style-2" <?php if ($School_Holidays_options['settings_style'] == "large") echo 'checked="checked"';?> /> 
        <label for="settings_style-2" style="font-size:17px;"><?php _e('Large Holiday Countdown', 'School_Holidays'); ?></label>
      </div>
      <div class="shortcode-for-style">[SchoolHolidays id="<span><?php echo $School_Holidays_options['settings_school_id']; ?></span>" type="large"]</div>
      <div><iframe width="650" height="330" allowtransparency="true" frameborder=0 scrolling=no id="schools-frame-large" src="http://myschoolholidays.com/plugin.php?type=2&s=<?php echo $School_Holidays_options['settings_school_id']; ?>"></iframe></div>
    </div>
    <div class="mt-20">
      <div>
        <input type="radio" name="settings_style" value="fullsize" id="settings_style-3" <?php if ($School_Holidays_options['settings_style'] == "fullsize") echo 'checked="checked"';?> /> 
        <label for="settings_style-3" style="font-size:17px;"><?php _e('Full Size School Holiday Calendar Widget / Plugin', 'School_Holidays'); ?></label>
      </div>
      <div class="shortcode-for-style">[SchoolHolidays id="<span><?php echo $School_Holidays_options['settings_school_id']; ?></span>" type="fullsize"]</div>
      <div><iframe width="680" height="675" allowtransparency="true" frameborder=0 scrolling=no id="schools-frame-fullsize" src="http://myschoolholidays.com/myschool.php?type=wide&s=<?php echo $School_Holidays_options['settings_school_id']; ?>"></iframe></div>
    </div>
    <div class="mt-20">
      <div>
        <input type="radio" name="settings_style" value="sidebar" id="settings_style-4" <?php if ($School_Holidays_options['settings_style'] == "sidebar") echo 'checked="checked"';?> /> 
        <label for="settings_style-4" style="font-size:17px;"><?php _e('Sidebar School Holiday Calendar Widget / Plugin', 'School_Holidays'); ?></label>
      </div>
      <div class="shortcode-for-style">[SchoolHolidays id="<span><?php echo $School_Holidays_options['settings_school_id']; ?></span>" type="sidebar"]</div>
      <div><iframe width="220" height="675" allowtransparency="true" frameborder=0 scrolling=no id="schools-frame-sidebar" src="http://myschoolholidays.com/myschool.php?s=<?php echo $School_Holidays_options['settings_school_id']; ?>"></iframe></div>
    </div>
  </div>
  
  <div class="mt-20">
    <input type="checkbox" name="settings_showlink" value="yes" id="settings_showlink_id" <?php if ($School_Holidays_options['settings_showlink'] == "yes") echo 'checked';?> /><label for="settings_showlink_id"><?php _e('Show school link under frame', 'School_Holidays'); ?></label><br>
  </div>
  
  <div class="mt20-200" style="float: right;">
    <input type="submit" name="submit" value="<?php _e('Save', 'School_Holidays'); ?>" />
  </div>

</div>
</form>
<?php
}


/*
* Try to find Shortcode in posts/page text
*/

function School_Holidays_Shortcode( $atts ) {
  extract( shortcode_atts( array(
    'id'   => 1,
    'type' => 'small',
  ), $atts ) );
  
  $School_Holidays_options = School_Holidays_get_options();
  
  if ($School_Holidays_options['settings_showlink'] == "yes") 
      $direct = '&dontShowUrl=true';
  else 
      $direct = '&dontShowUrl=false';

  switch ($type) {
      case "class":
          $o = '<iframe width="100%" height="175" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/plugin.php?type=4&s='.$id.$direct.'"></iframe>';
          break;
      case "small":
          $o = '<iframe width="280" height="330" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/plugin.php?type=3&s='.$id.$direct.'"></iframe>';
          break;
      case "large":
          $o = '<iframe width="650" height="330" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/plugin.php?type=2&s='.$id.$direct.'"></iframe>';
          break;
      case "fullsize":
          $o = '<iframe width="680" height="675" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/myschool.php?type=wide&s='.$id.$direct.'"></iframe>';
          break;
      case "sidebar":
          $o = '<iframe width="220" height="675" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/myschool.php?s='.$id.$direct.'"></iframe>';
          break;
  }
  
  if (!empty($School_Holidays_options['settings_school_url'])) {
      $o .= '<div><a href="'.$School_Holidays_options['settings_school_url'].'">'.$School_Holidays_options['settings_school_name'].' Holiday and School</a></div>';
  }

  return $o;
}

add_shortcode( 'SchoolHolidays', 'School_Holidays_Shortcode' );


/*
* Widget
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'School_Holidays_load_widgets' );

/**
 * Register our widget.
 */
function School_Holidays_load_widgets() {
  register_widget( 'School_Holidays_Widget' );
}

/**
 * School Holidays Widget class.
 */
class School_Holidays_Widget extends WP_Widget {

  /**
   * Widget setup.
   */
  function School_Holidays_Widget() {
    /* Widget settings. */
    $widget_ops = array( 'classname' => 'School_Holidays', 'description' => __('School Holiday and term start Countdown or school holiday dates in calendar format', 'School_Holidays') );

    /* Widget control settings. */
    //$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'schoolholidays-widget' );
    $control_ops = array( 'id_base' => 'schoolholidays-widget' );

    /* Create the widget. */
    $this->WP_Widget( 'schoolholidays-widget', __('My School Holidays', 'School_Holidays'), $widget_ops, $control_ops );
  }

  /**
   * How to display the widget on the screen.
   */
  function widget( $args, $instance ) {
    extract( $args );
    
    /* Our variables from the widget settings. */
    $title        = apply_filters('widget_title', $instance['title'] );
    $school_name  = $instance['school_name'];
    $id           = $instance['school_id'];
    $school_url   = $instance['school_url'];
    $school_link  = $instance['school_link'];
    $type         = $instance['type'];

    /* Before widget (defined by themes). */
    echo $before_widget;

    /* Display the widget title if one was input (before and after defined by themes). */
    if ( $title )
      echo $before_title . $title . $after_title;

    if ($school_link == "yes") 
      $direct = '&dontShowUrl=true';
    else 
      $direct = '&dontShowUrl=false';

    switch ($type) {
        case "classic":
            $o = '<iframe width="100%" height="175" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/plugin.php?type=4&s='.$id.$direct.'"></iframe>';
            break;
        case "small":
            $o = '<iframe width="280" height="330" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/plugin.php?type=3&s='.$id.$direct.'"></iframe>';
            break;
        case "large":
            $o = '<iframe width="650" height="330" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/plugin.php?type=2&s='.$id.$direct.'"></iframe>';
            break;
        case "fullsize":
            $o = '<iframe width="680" height="675" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/myschool.php?type=wide&s='.$id.$direct.'"></iframe>';
            break;
        case "sidebar":
            $o = '<iframe width="220" height="675" allowtransparency="true" frameborder=0 scrolling=no src="http://myschoolholidays.com/myschool.php?s='.$id.$direct.'"></iframe>';
            break;
    }
    
    
    if (!empty($school_url)) {
      $o .= '<div><a href="'.$school_url.'">'.$school_name.' Holiday and Term Dates</a></div>';
    }

    /* After widget (defined by themes). */
    echo $o.$after_widget;
  }

  /**
   * Update the widget settings.
   */
  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;

    /* No need to strip tags for sex and show_sex. */
    $instance['title']       =  $new_instance['title'];
    $instance['school_name'] =  $new_instance['school_name'];
    $instance['school_id']   =  $new_instance['school_id'];
    $instance['school_url']  =  $new_instance['school_url'];
    $instance['school_link'] =  $new_instance['school_link'];
    $instance['type']        =  $new_instance['type'];

    return $instance;
  }

  /**
   * Displays the widget settings controls on the widget panel.
   * Make use of the get_field_id() and get_field_name() function
   * when creating your form elements. This handles the confusing stuff.
   */
  function form( $instance ) {
    $School_Holidays_options = School_Holidays_get_options();
    
    /* Set up some default widget settings. */
    $defaults = array( 'title' => __('My School Holidays', 'School_Holidays'), 'school_name' => $School_Holidays_options['settings_school_name'], 'school_id' => $School_Holidays_options['settings_school_id'], 'school_url' => $School_Holidays_options['settings_school_url'], 'type' => $School_Holidays_options['settings_style'], 'school_link' => $School_Holidays_options['settings_showlink']);
    $instance = wp_parse_args( (array) $instance, $defaults ); 
    
    $dir = '../'.PLUGINDIR.'/'.dirname(plugin_basename (__FILE__)).'/';
    
    if ($instance['type'] == "large" || $instance['type'] == "fullsize") 
      $instance['type'] = "small";
    
    ?>
    <link rel='stylesheet' href='<?php echo $dir; ?>css/main.css' type='text/css' media='all' /> 
    <script type="text/javascript" src="<?php echo $dir; ?>js/widget.js"></script>
    
    <!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
      <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" onclick="clicker();" />
    </p>

    <!-- Your School Name: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id( 'school_name' ); ?>"><?php _e('Choose school:', 'hybrid'); ?></label>
      <div class="ds-container" id="ds-container-fb">
        <input type="hidden" name="<?php echo $this->get_field_name( 'school_id' ); ?>" id="<?php echo $this->get_field_id( 'school_id' ); ?>" value="<?php echo $instance['school_id']; ?>" />
        <input type="text" id="fb" placeholder="<?php _e('Search by School Name or Council', 'School_Holidays'); ?>" autocomplete="off" x-webkit-speech="" class="ds-input" name="<?php echo $this->get_field_name( 'school_name' ); ?>" id="<?php echo $this->get_field_id( 'school_name' ); ?>" value="<?php echo $instance['school_name']; ?>" style="width: 230px;font-size: 13px;" onkeyup="School_Holidays_getschools(this);" />
        <div class="ds-results" id="ds-results-fb" style="display: none; ">
        <input type="hidden" name="<?php echo $this->get_field_name( 'school_url' ); ?>" id="<?php echo $this->get_field_id( 'school_url' ); ?>" value="<?php echo $instance['school_url']; ?>" />
        <ul class="ds-list" style="width: 230px; "></ul>
        </div>
      </div>
    </p>

    <!-- Select Type Box -->
    <p>
    <label><?php _e('Choose style:', 'hybrid'); ?></label>
    <div><input type="radio" name="<?php echo $this->get_field_name( 'type' ); ?>" value="classic" id="<?php echo $this->get_field_id( 'type' ); ?>5" <?php if ($instance['type'] == "classic") echo 'checked="checked"';?> />
      <label for="<?php echo $this->get_field_id( 'type' ); ?>5"><?php _e('Classic Small Holiday Countdown', 'School_Holidays'); ?></label>
    </div>

    <div><input type="radio" name="<?php echo $this->get_field_name( 'type' ); ?>" value="small" id="<?php echo $this->get_field_id( 'type' ); ?>1" <?php if ($instance['type'] == "small") echo 'checked="checked"';?> /> 
      <label for="<?php echo $this->get_field_id( 'type' ); ?>1"><?php _e('Small Holiday Countdow', 'School_Holidays'); ?></label>
    </div>
    <div><input type="radio" name="<?php echo $this->get_field_name( 'type' ); ?>" value="sidebar" id="<?php echo $this->get_field_id( 'type' ); ?>4" <?php if ($instance['type'] == "sidebar") echo 'checked="checked"';?> /> 
      <label for="<?php echo $this->get_field_id( 'type' ); ?>4"><?php _e('Sidebar School Holiday Calendar', 'School_Holidays'); ?></label>
    </div>
    </p>
    
    <!-- Show url checkbox -->
    <p>
    <label><?php _e('', 'hybrid'); ?></label>
    <div><input type="checkbox" name="<?php echo $this->get_field_name( 'school_link' ); ?>" value="yes" id="<?php echo $this->get_field_id( 'school_link' ); ?>" <?php if ($instance['school_link'] == "yes") echo 'checked="checked"';?> /> <label for="<?php echo $this->get_field_id( 'school_link' ); ?>"><?php _e('Show school link under frame', 'School_Holidays'); ?></label>
    </div>
    </p>
  <?php
  }
}


