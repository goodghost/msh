<?php
/**
* @file
* Main page template.
*/
?>
<div class="top-bar">
  <div class="left">
    <?php if ($logo): ?>
      <a href="<?php print url('<front>'); ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
        <span class="helper"></span><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
    <?php endif; ?>
  </div>

  <div class="right">
    <?php /* Search box */ ?>
    <?php if (!empty($search_box) && $logged_in) : ?>
      <div class="search-block">
        <i class="flaticon flaticon-tool-1"></i><?php print drupal_render($search_box); ?>
      </div>
    <?php endif; ?>
    <div class="navbar-burger-menu"><i class="fa fa-bars"></i></div>

    <?php if ($logged_in) : ?>
     <div class="logout">
       <a href="<?php print url('user/logout'); ?>"><i class="flaticon flaticon-interface"></i><span><?php print t('Log Out'); ?></span></a>
     </div>
     <div class="user-data">
        <?php if (isset($user_picture) && !empty($user_picture)) : ?>
          <a href="<?php print $user_link; ?>" class="avatar"> 
            <?php print $user_picture; ?>
          </a>
        <?php else : ?>
          <div class="no-avatar"><i class="fa fa-user"></i></div>
        <?php endif; ?>
       <a class="username-link" href="<?php print $user_link; ?>"><?php print $username; ?></a>
     </div>
     <div class="events unread"> 
       <div class="label"><?php print t('Unread events'); ?></div>
       <div class="count">2</div>
     </div>
   <?php endif; ?>
  </div>
</div>

<div id="branding" class="clearfix">

	<?php print render($title_prefix); ?>

	<?php if ($title): ?>
		<h1 class="page-title"><?php print $title; ?></h1>
	<?php endif; ?>

	<?php print render($title_suffix); ?>

  <?php print $breadcrumb; ?>

</div>

<div id="navigation">
  <?php if ($primary_local_tasks): ?>
    <?php print render($primary_local_tasks); ?>
  <?php endif; ?>

  <?php if ($secondary_local_tasks): ?>
    <div class="tabs-secondary clearfix"><ul class="tabs secondary"><?php print render($secondary_local_tasks); ?></ul></div>
  <?php endif; ?>
</div>

<div id="page">

	<div id="content" class="clearfix">
		<div class="element-invisible"><a id="main-content"></a></div>

	<?php if ($messages): ?>
		<div id="console" class="clearfix"><?php print $messages; ?></div>
	<?php endif; ?>

	<?php if ($page['help']): ?>
		<div id="help">
			<?php print render($page['help']); ?>
		</div>
	<?php endif; ?>

	<?php if (isset($page['content_before'])): ?>
		<div id="content-before">
			<?php print render($page['content_before']); ?>
		</div>
	<?php endif; ?>

	<?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>

  <div id="content-wrapper">

    <?php if (isset($page['sidebar_left'])): ?>
      <div id="sidebar-left">
        <?php print render($page['sidebar_left']); ?>
      </div>
    <?php endif; ?>

    <div id="main-content">
	    <?php print render($page['content']); ?>
	  </div>

    <?php if (isset($page['sidebar_right'])): ?>
      <div id="sidebar-right">
        <?php print render($page['sidebar_right']); ?>
      </div>
    <?php endif; ?>
	
	</div>

	<?php if (isset($page['content_after'])): ?>
		<div id="content-after">
			<?php print render($page['content_after']); ?>
		</div>
	<?php endif; ?>

	</div>

	<div id="footer">
		<?php print $feed_icons; ?>
	</div>

</div>
