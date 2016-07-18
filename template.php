<?php

/**
 * @file
 * This file contains the main theme functions hooks and overrides.
 */

/**
 * Override or insert variables into the maintenance page template.
 */
function msh_adminimal_preprocess_maintenance_page(&$vars) {
  // While markup for normal pages is split into page.tpl.php and html.tpl.php,
  // the markup for the maintenance page is all in the single
  // maintenance-page.tpl.php template. So, to have what's done in
  // msh_adminimal_preprocess_html() also happen on the maintenance page, it has to be
  // called here.
  msh_adminimal_preprocess_html($vars);
}

/**
 * Override or insert variables into the html template.
 */
function msh_adminimal_preprocess_html(&$vars) {

  // Get msh_adminimal folder path.
  $adminimal_path = drupal_get_path('theme', 'msh_adminimal');

  // Add default styles.
  drupal_add_css($adminimal_path . '/css/reset.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => -999));
  drupal_add_css($adminimal_path . '/css/style.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));

  // Add conditional CSS for IE8 and below.
  drupal_add_css($adminimal_path . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 8', '!IE' => FALSE), 'weight' => 999, 'preprocess' => TRUE));

  // Add conditional CSS for IE7 and below.
  drupal_add_css($adminimal_path . '/css/ie7.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'weight' => 999, 'preprocess' => TRUE));

  // Add conditional CSS for IE6.
  drupal_add_css($adminimal_path . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 6', '!IE' => FALSE), 'weight' => 999, 'preprocess' => TRUE));

  //Add Homebox module support
  if (module_exists('homebox')) {
    drupal_add_css($adminimal_path . '/css/homebox_custom.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 1));
  }

  // Add theme name to body class.
  $vars['classes_array'][] = 'adminimal-theme';

  // Style checkbox and radio buttons in Webkit Browsers.
  if (theme_get_setting('style_checkboxes')) {
    $vars['classes_array'][] = 'style-checkboxes';
  }

  // Disable rounded buttons setting.
  if (!theme_get_setting('rounded_buttons')) {
    $vars['classes_array'][] = 'no-rounded-buttons';
  }

  // Enable sticky action buttons.
  if (theme_get_setting('sticky_actions')) {
    $vars['classes_array'][] = 'sticky-actions';
  }

  // Add icons to the admin configuration page.
  if (theme_get_setting('display_icons_config')) {
    drupal_add_css($adminimal_path . '/css/icons-config.css', array('group' => CSS_THEME, 'weight' => 10, 'preprocess' => TRUE));
  }

  // Add icons to the admin configuration page.
  if (theme_get_setting('avoid_custom_font')) {
    drupal_add_css($adminimal_path . '/css/avoid_custom_font.css', array('group' => CSS_THEME, 'weight' => 9000, 'preprocess' => TRUE));
  }

  // Load CKEditor styles if enabled in settings.
  if (theme_get_setting('adminimal_ckeditor')) {
    drupal_add_css($adminimal_path . '/css/ckeditor-adminimal.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 2));
  }

  // Define Default media queries.
  // Those values are also used in variables.less file, so update both if you want to keep consistency. 
  $mobile = array('0', '480');
  $tablet = array('481', '1024');

  $media_query_mobile = 'only screen and (max-width: '.$mobile[1].'px)';
  $media_query_tablet = 'only screen and (min-width : '.$tablet[0].'px) and (max-width : '.$tablet[1].'px)';

  drupal_add_js(array('msh_adminimal' => array('mobile' => $mobile, 'tablet' => $tablet)), 'setting');

  // Load custom Adminimal skin.
  $adminimal_skin = theme_get_setting('msh_adminimal_theme_skin');
  if ((!is_null($adminimal_skin))) {
    drupal_add_css($adminimal_path . '/skins/' . $adminimal_skin . '/' . $adminimal_skin . '.css', array('group' => CSS_THEME, 'weight' => 900, 'preprocess' => TRUE));
    // Add conditional CSS for Mac OS X.
    drupal_add_css($adminimal_path . '/skins/' . $adminimal_skin . '/mac_os_x.css', array('group' => CSS_THEME, 'weight' => 950, 'preprocess' => TRUE));
    drupal_add_js($adminimal_path . '/skins/' . $adminimal_skin . '/' . $adminimal_skin . '.js');
    $vars['classes_array'][] = 'adminimal-skin-' . $adminimal_skin ;
  }
  else {
    drupal_add_css($adminimal_path . '/skins/default/default.css', array('group' => CSS_THEME, 'weight' => 900, 'preprocess' => TRUE));
    // Add conditional CSS for Mac OS X.
    drupal_add_css($adminimal_path . '/skins/default/mac_os_x.css', array('group' => CSS_THEME, 'weight' => 950, 'preprocess' => TRUE));
    drupal_add_js($adminimal_path . '/skins/default/default.js');
    $vars['classes_array'][] = 'adminimal-skin-default' ;
  }

  // Add responsive styles.
  drupal_add_css($adminimal_path . '/css/mobile.css', array('group' => CSS_THEME, 'media' => $media_query_mobile, 'weight' => 1000));
  drupal_add_css($adminimal_path . '/css/tablet.css', array('group' => CSS_THEME, 'media' => $media_query_tablet, 'weight' => 1000));

  // Add custom CSS.
  $custom_css_path = 'public://adminimal-custom.css';
  if (theme_get_setting('custom_css') && file_exists($custom_css_path)) {
    drupal_add_css($custom_css_path, array('group' => CSS_THEME, 'weight' => 9999, 'preprocess' => TRUE));
  }

  // Fix the viewport and zooming in mobile devices.
  $viewport = array(
   '#tag' => 'meta',
   '#attributes' => array(
     'name' => 'viewport',
     'content' => 'width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no, initial-scale=1',
   ),
  );
  drupal_add_html_head($viewport, 'viewport');

  // Remove the no-sidebars class which is always added by core. Core assumes
  // the sidebar regions are called sidebar_first and sidebar_second, which
  // is not the case in this theme.
  $key = array_search('no-sidebars', $vars['classes_array']);
  if ($key !== FALSE) {
    unset($vars['classes_array'][$key]);
  }
  // Add information about the number of sidebars.
  if (!empty($vars['page']['sidebar_left']) && !empty($vars['page']['sidebar_right'])) {
    $vars['classes_array'][] = 'two-sidebars';
  }
  elseif (!empty($vars['page']['sidebar_left'])) {
    $vars['classes_array'][] = 'one-sidebar sidebar-left';
  }
  elseif (!empty($vars['page']['sidebar_right'])) {
    $vars['classes_array'][] = 'one-sidebar sidebar-right';
  }
  else {
    $vars['classes_array'][] = 'no-sidebars';
  }

  // Add iconfont
  drupal_add_css($adminimal_path . '/iconfont/flaticon.css', array('group' => CSS_THEME, 'weight' => 1000));

  // Add font styles
  drupal_add_css('https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,400italic,500italic,300italic', 'external');

  // Add overriden styles generated by LESS.
  drupal_add_css($adminimal_path . '/css/less.css', array('group' => CSS_THEME, 'weight' => 1000));
  
  // Add navbar behaviours
  drupal_add_js($adminimal_path.'/js/resizing.js');

  // Add general JS file to msh_adminimal theme
  // Contains: search form adjustments
  drupal_add_js($adminimal_path.'/js/msh_adminimal.js');

  // Add calendar JS file for view adjustments and modal events display
  if (in_array('html__admin__activities__calendar', $vars['theme_hook_suggestions'])) {
    drupal_add_js($adminimal_path.'/js/msh_calendar.js');
  }

  // Add navbar behaviours
  drupal_add_js($adminimal_path.'/js/msh_navbar.js');

  // Additional libraries
  drupal_add_library('msh_core', 'enquirejs');
  drupal_add_library('msh_core', 'tablesaw');
}

/**
 * Override or insert variables into the page template.
 */
function msh_adminimal_preprocess_page(&$vars) {
  $vars['primary_local_tasks'] = $vars['tabs'];
  unset($vars['primary_local_tasks']['#secondary']);
  $vars['secondary_local_tasks'] = array(
    '#theme' => 'menu_local_tasks',
    '#secondary' => $vars['tabs']['#secondary'],
  );
  unset($vars['page']['hidden']);

  // Search box
  if (module_exists('search')) {
    $search_box = drupal_get_form('search_form');
    $vars['search_box'] = $search_box;
  } else {
    $vars['search_box'] = '';
  }

  // User data used in top bar
  global $user;
  if ($user->uid) {
    if (isset($user->picture) && !(empty($user->picture))) {
      $vars['user_picture'] = file_load($user->picture);
      $image_style = image_style_url('thumbnail', $vars['user_picture']->uri);
      $vars['user_picture'] = theme('image', array('path' => $image_style));
    }
    $vars['username'] = $user->name;
    $vars['user_link'] = url('user/'.$user->uid);
  }
}

/*
 * Override forms.
 * Contains: search form, node_form
 */
function msh_adminimal_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_form') {
    $form['basic']['keys']['#title'] = t('Type here to search');
  }

  if (strpos($form_id, '_node_form') !== false) {
    // Add wrapper with custom classes to form buttons on every node add/edit form
    $actions_elements = element_children($form['actions']);
    foreach($actions_elements as $value) {
      $form['actions'][$value]['#prefix'] = '<div class="actions ' . drupal_clean_css_identifier($value) .'">';
      $form['actions'][$value]['#suffix'] = '</div>';
    }
  }
}

/**
 * Implement template_preprocess_field().
 */
function msh_adminimal_preprocess_field(&$variables) {
  if ($variables['element']['#field_name'] == 'field_category_icon') {
    $variables['classes_array'][] = str_replace("_", "-", $variables['element']['#object']->field_category_icon['und'][0]['value']);
  }
}

/**
 * Display the list of available node types for node creation.
 */
function msh_adminimal_node_add_list($variables) {
  $content = $variables['content'];
  $output = '';
  if ($content) {
    $output = '<ul class="admin-list">';
    foreach ($content as $item) {
      $output .= '<li class="clearfix">';
      $output .= '<span class="label">' . l($item['title'], $item['href'], $item['localized_options']) . '</span>';
      $output .= '<div class="description">' . filter_xss_admin($item['description']) . '</div>';
      $output .= '</li>';
    }
    $output .= '</ul>';
  }
  else {
    $output = '<p>' . t('You have not created any content types yet. Go to the <a href="@create-content">content type creation page</a> to add a new content type.', array('@create-content' => url('admin/structure/types/add'))) . '</p>';
  }
  return $output;
}

/**
 * Implements theme_msh_adminimal_block_content().
 *
 * Use unordered list markup in both compact and extended mode.
 */
function msh_adminimal_adminimal_block_content($variables) {
  $content = $variables['content'];
  $output = '';
  if (!empty($content)) {
    $output = system_adminimal_compact_mode() ? '<ul class="admin-list compact">' : '<ul class="admin-list">';
    foreach ($content as $item) {
      $output .= '<li class="leaf">';
      $output .= l($item['title'], $item['href'], $item['localized_options']);
      if (isset($item['description']) && !system_adminimal_compact_mode()) {
        $output .= '<div class="description">' . filter_xss_admin($item['description']) . '</div>';
      }
      $output .= '</li>';
    }
    $output .= '</ul>';
  }
  return $output;
}

/**
 * Implements theme_tablesort_indicator().
 *
 * Use our own image versions, so they show up as black and not gray on gray.
 */
function msh_adminimal_tablesort_indicator($variables) {
  $style = $variables['style'];
  $theme_path = drupal_get_path('theme', 'msh_adminimal');
  if ($style == 'asc') {
    return theme('image', array('path' => $theme_path . '/images/arrow-asc.png', 'alt' => t('sort ascending'), 'width' => 13, 'height' => 13, 'title' => t('sort ascending')));
  }
  else {
    return theme('image', array('path' => $theme_path . '/images/arrow-desc.png', 'alt' => t('sort descending'), 'width' => 13, 'height' => 13, 'title' => t('sort descending')));
  }
}

/**
 * Implements hook_css_alter().
 */
function msh_adminimal_css_alter(&$css) {
  // Use Seven's vertical tabs style instead of the default one.
  if (isset($css['misc/vertical-tabs.css'])) {
    $css['misc/vertical-tabs.css']['data'] = drupal_get_path('theme', 'msh_adminimal') . '/css/vertical-tabs.css';
  }
  if (isset($css['misc/vertical-tabs-rtl.css'])) {
    $css['misc/vertical-tabs-rtl.css']['data'] = drupal_get_path('theme', 'msh_adminimal') . '/css/vertical-tabs-rtl.css';
  }
  // Use Seven's jQuery UI theme style instead of the default one.
  if (isset($css['misc/ui/jquery.ui.theme.css'])) {
    $css['misc/ui/jquery.ui.theme.css']['data'] = drupal_get_path('theme', 'msh_adminimal') . '/css/jquery.ui.theme.css';
  }
}

/**
 * Implements hook_js_alter().
 */
function msh_adminimal_js_alter(&$javascript) {
  // Fix module filter available updates page.
  if (isset($javascript[drupal_get_path('module','module_filter').'/js/update_status.js'])) {
    $javascript[drupal_get_path('module','module_filter').'/js/update_status.js']['data'] = drupal_get_path('theme', 'msh_adminimal') . '/js/update_status.js';
  }
}

/**
 * Implements theme_admin_block().
 * Adding classes to the administration blocks see issue #1869690.
 */
function msh_adminimal_admin_block($variables) {
  $block = $variables['block'];
  $output = '';

  // Don't display the block if it has no content to display.
  if (empty($block['show'])) {
    return $output;
  }

  if (!empty($block['path'])) {
    $output .= '<div class="admin-panel ' . check_plain(str_replace("/", " ", $block['path'])) . ' ">';
  }
  elseif (!empty($block['title'])) {
    $output .= '<div class="admin-panel ' . check_plain(strtolower($block['title'])) . '">';
  }
  else {
    $output .= '<div class="admin-panel">';
  }

  if (!empty($block['title'])) {
    $output .= '<h3 class="title">' . $block['title'] . '</h3>';
  }

  if (!empty($block['content'])) {
    $output .= '<div class="body">' . $block['content'] . '</div>';
  }
  else {
    $output .= '<div class="description">' . $block['description'] . '</div>';
  }

  $output .= '</div>';

  return $output;
}

/**
 * Implements theme_admin_block_content().
 * Adding classes to the administration blocks see issue #1869690.
 */
function msh_adminimal_admin_block_content($variables) {
  $content = $variables['content'];
  $output = '';

  if (!empty($content)) {
    $class = 'admin-list';
    if ($compact = system_admin_compact_mode()) {
      $class .= ' compact';
    }
    $output .= '<dl class="' . $class . '">';
    foreach ($content as $item) {
      if (!isset($item['path'])) {
          $item['path']='';
      }
      $output .= '<div class="admin-block-item ' . check_plain(str_replace("/", "-", $item['path'])) . '"><dt>' . l($item['title'], $item['href'], $item['localized_options']) . '</dt>';
      if (!$compact && isset($item['description'])) {
        $output .= '<dd class="description">' . filter_xss_admin($item['description']) . '</dd>';
      }
      $output .= '</div>';
    }
    $output .= '</dl>';
  }
  return $output;
}

/**
 * Implements theme_table().
 */
function msh_adminimal_table($variables) {
  $header = $variables['header'];
  $rows = $variables['rows'];
  $attributes = $variables['attributes'];
  $caption = $variables['caption'];
  $colgroups = $variables['colgroups'];
  $sticky = $variables['sticky'];
  $empty = $variables['empty'];

  // Add sticky headers, if applicable.
  if (count($header) && $sticky) {
    drupal_add_js('misc/tableheader.js');
    // Add 'sticky-enabled' class to the table to identify it for JS.
    // This is needed to target tables constructed by this function.
    $attributes['class'][] = 'sticky-enabled';
  }

  $output = '<div class="overflow-fix">';
  $output .= '<table' . drupal_attributes($attributes) . ">\n";

  if (isset($caption)) {
    $output .= '<caption>' . $caption . "</caption>\n";
  }

  // Format the table columns:
  if (count($colgroups)) {
    foreach ($colgroups as $number => $colgroup) {
      $attributes = array();

      // Check if we're dealing with a simple or complex column
      if (isset($colgroup['data'])) {
        foreach ($colgroup as $key => $value) {
          if ($key == 'data') {
            $cols = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $cols = $colgroup;
      }

      // Build colgroup
      if (is_array($cols) && count($cols)) {
        $output .= ' <colgroup' . drupal_attributes($attributes) . '>';
        $i = 0;
        foreach ($cols as $col) {
          $output .= ' <col' . drupal_attributes($col) . ' />';
        }
        $output .= " </colgroup>\n";
      }
      else {
        $output .= ' <colgroup' . drupal_attributes($attributes) . " />\n";
      }
    }
  }

  // Add the 'empty' row message if available.
  if (!count($rows) && $empty) {
    $header_count = 0;
    foreach ($header as $header_cell) {
      if (is_array($header_cell)) {
        $header_count += isset($header_cell['colspan']) ? $header_cell['colspan'] : 1;
      }
      else {
        ++$header_count;
      }
    }
    $rows[] = array(array(
      'data' => $empty,
      'colspan' => $header_count,
      'class' => array('empty', 'message'),
    ));
  }

  // Format the table header:
  if (count($header)) {
    $ts = tablesort_init($header);
    // HTML requires that the thead tag has tr tags in it followed by tbody
    // tags. Using ternary operator to check and see if we have any rows.
    $output .= (count($rows) ? ' <thead><tr>' : ' <tr>');
    foreach ($header as $cell) {
      $cell = tablesort_header($cell, $header, $ts);
      $output .= _theme_table_cell($cell, TRUE);
    }
    // Using ternary operator to close the tags based on whether or not there are rows
    $output .= (count($rows) ? " </tr></thead>\n" : "</tr>\n");
  }
  else {
    $ts = array();
  }

  // Format the table rows:
  if (count($rows)) {
    $output .= "<tbody>\n";
    $flip = array(
      'even' => 'odd',
      'odd' => 'even',
    );
    $class = 'even';
    foreach ($rows as $number => $row) {
      // Check if we're dealing with a simple or complex row
      if (isset($row['data'])) {
        $cells = $row['data'];
        $no_striping = isset($row['no_striping']) ? $row['no_striping'] : FALSE;

        // Set the attributes array and exclude 'data' and 'no_striping'.
        $attributes = $row;
        unset($attributes['data']);
        unset($attributes['no_striping']);
      }
      else {
        $cells = $row;
        $attributes = array();
        $no_striping = FALSE;
      }
      if (count($cells)) {
        // Add odd/even class
        if (!$no_striping) {
          $class = $flip[$class];
          $attributes['class'][] = $class;
        }

        // Build row
        $output .= ' <tr' . drupal_attributes($attributes) . '>';
        $i = 0;
        foreach ($cells as $cell) {
          $cell = tablesort_cell($cell, $header, $ts, $i++);
          $output .= _theme_table_cell($cell);
        }
        $output .= " </tr>\n";
      }
    }
    $output .= "</tbody>\n";
  }

  $output .= "</table>\n";
  $output .= "</div>\n";
  return $output;
}

/**
 * Implements hook_views_pre_render().
 */
function msh_adminimal_views_pre_render(&$view) {

}

/**
 * Implements hook_preprocess_views_view().
 */
function msh_adminimal_preprocess_views_view(&$vars) {
  if ($vars['view']->name == 'activity_dates' && $vars['view']->current_display == 'page_1') {
    if (isset($vars['view']->result) && empty($vars['view']->result)) {
      $vars['classes_array'][] = 'no-results';
    }
  }
}

/**
 * Implements template_preprocess_views_view_table().
 */
function msh_adminimal_preprocess_views_view_table(&$vars) {
  if ($vars['view']->plugin_name == 'table') {
    // Add classes and attributes for responsive tables using tablesaw plugin
    $vars['classes_array'][] = 'tablesaw';
    $vars['classes_array'][] = 'tablesaw-stack';
    
    $vars['attributes_array']['data-tablesaw-mode'] = 'stack'; 
  }
}
