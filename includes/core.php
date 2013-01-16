<?php
  /**
   * Main functionality
  **/

  $debuggify_settings_name = 'Debuggify';

  // delete_option($debuggify_settings_name);

  $debuggify_options = debuggify_get_options(NULL);


  /**
   * Get settings if already saved from database else return default
   */
  function debuggify_get_options($action = NULL){

    global $debuggify_settings_name;

    // Plugin Defaults
    $defaults = array(
      'apikey' => '6487a4edf9e534c6164579dd327b01f4',
      'enabled' => '0'
    );

    //Return default settings
    if($action == "reset"){
      delete_option($debuggify_settings_name);
      add_option($debuggify_settings_name, $defaults);
      return $defaults;
    }

      //Get the settings from the database
      $database_settings =  get_option($debuggify_settings_name);
      if($database_settings){
        $need_to_update = false;

          //Check whether all the settings are present or not
          foreach($defaults as $k => $v){

            if( !array_key_exists( $k, $database_settings)) {
                $database_settings[$k] = $v;
                $need_to_update = true;
            }
          }

          if($need_to_update) {
            update_option($debuggify_settings_name, $database_settings);
          }

        return $database_settings;
      }else{
        //Add the settings
        add_option($debuggify_settings_name, $defaults);
        return $defaults;
      }
  }

  /**
   * Queuing the script if enabled
   */
  function debuggify_enqueue_script() {
    global $debuggify_options;
    if($debuggify_options['enabled'] == '1') {
      wp_enqueue_script('debuggify-logger-http-js', 'https://cdn.debuggify.net/js/'.$debuggify_options['apikey'].'/debuggify.logger.http.js', null, DEBUGGIFY_VERSION.'&platform=wordpress', false);
    }
  }

  // Adding actions for all admin and non admin pages
  add_action('wp_enqueue_scripts', 'debuggify_enqueue_script');
  add_action('admin_enqueue_scripts', 'debuggify_enqueue_script');
  add_action('login_enqueue_scripts', 'debuggify_enqueue_script');

  /**
   * Google Analytics Helper
   */
  function debuggify_google_analytics() {
  $ga = <<<EOD
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33559087-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
EOD;
  return $ga;
}

?>