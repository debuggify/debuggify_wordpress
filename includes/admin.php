<?php

/**
 * Admin functions
 */

  global $debuggify_options, $debuggify_settings_name;

  // If data is submited then process and take actions
  if ( !empty($_POST )  && isset($_POST['submit'])){

    $status_message = __('Your changes have been saved successfully!', 'debuggify');
    show_admin_notices('updated', $status_message);

    foreach (array(
      'enabled', 'apikey'

      )as $field) {

        if(isset($_POST[$field])) {

          $debuggify_options[$field] = $_POST[$field];
        } else {
          $debuggify_options[$field] = NULL;
        }
    }


    update_option($debuggify_settings_name, $debuggify_options);

  }

  /**
   * Show admin notices
   * @param  String $type updated | error
   * @param  String $msg  Any message string
   */
  function show_admin_notices($type, $msg) {
    printf( '<div class="%s"> <p> %s </p> </div>', $type, esc_html__( $msg, 'debuggify' ) );
  }

 function debuggify_settings_page() {

  global $debuggify_options, $debuggify_settings_name;

  $object = NULL;

?>

  <div class="wrap">

    <div class="icon32" id="icon-options-general">
      <br>
    </div>

    <?php

      printf(
        '<h2> %s <a href="%s" > %s </a></h2>',
        esc_html__('Debuggify','debuggify'),
        esc_url(admin_url('admin.php?page=debuggify.php')),
        esc_html__('Settings','debuggify')
      );

    ?>

    <form name="debuggify-settings" id="debuggify-settings" action="" method="post">

      <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">

          <div id="post-body-content">

            <div class="form-horizontal">


              <table class="form-table">
                <tbody>
                  <tr>
                    <th scope="row">Enable ?</th>
                    <td>
                      <fieldset><legend class="screen-reader-text"><span>Enable ?</span></legend>
                      <label title="Yes"><input <?= (($debuggify_options['enabled'] == "1") ? 'checked="checked"' :  "") ?> type="radio" name="enabled" value="1"  > <span><?php _e('Yes', 'debuggify'); ?></span></label><br>
                      <label title="No"><input <?= (($debuggify_options['enabled'] == "1") ? "" : 'checked="checked"') ?> type="radio" name="enabled" value="0"  > <span><?php _e('No', 'debuggify'); ?></span></label>

                      <p class="description">Enabled / Disable the plugin's functionality.</p>
                      </fieldset>
                    </td>
                  </tr>

                  <tr valign="top">
                    <th scope="row">
                      <label for="apikey">Apikey</label>
                    </th>

                    <td>
                      <input name="apikey" type="text" id="apikey" value="<?= $debuggify_options['apikey'] ?>" class="regular-text">
                      <p class="description">Get your own  apikey from <a href="https://www.debuggify.net">Debuggify</a>. Its just take a few minutes</p>
                    </td>
                  </tr>

                </tbody>
              </table>
              <?php

                submit_button(
                  __( 'Save Changes', 'debuggify' ),
                  'primary',
                  'submit'
                );

              ?>

            </div>
          </div>

          <div id="postbox-container-1" class="postbox-container">
            <?php do_meta_boxes('','side',$object); ?>
          </div>

          <div id="postbox-container-2" class="postbox-container">
            <?php do_meta_boxes('','normal',$object); ?>
            <?php do_meta_boxes('','advanced',$object); ?>
          </div>

        </div>

      </div>
    </form>


  </div>

<?php


} // end debuggify_settings_page

?>