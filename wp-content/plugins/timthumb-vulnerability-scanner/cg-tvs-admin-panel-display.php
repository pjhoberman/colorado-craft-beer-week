<?php
// Direct calls to this file are Forbidden when core files are not present
if ( !function_exists('add_action') ){
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		die();
}

if ( !current_user_can('manage_options') ){
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		die();
}
?>
<div class="wrap">
	<h2>Timthumb Scanner</h2>
    <ul class="subsubsub">
      <li><a href="tools.php?page=cg-timthumb-scanner" <?php if($_GET['tab'] != 'options'): ?>class="current"<?php endif; ?>>Scan for Issues</a> | </li>
      <li><a href="tools.php?page=cg-timthumb-scanner&tab=options" <?php if($_GET['tab'] == 'options'): ?>class="current"<?php endif; ?>>Options</a></li>
    </ul>
    <?php 
    switch($_GET['tab']){
      case 'options':
?>
  <div style="width:65%;min-width:500px;float:left;clear:both;">
  	<div class="postbox metabox-holder">
      <h3>Options</h3>
  		<form action="" method="post">
  		  <input type="hidden" name="cg-tvs-action" value="update-options">
        <?php wp_nonce_field( 'update_tvs_options'); ?>
        <table class="form-table">
          <tr>
            <th><label for="scan-daily">Automatically run this scan daily</label></th>
            <td><input id="scan-daily" name="scan-daily" type="checkbox" <?php if($this->scan_daily):?> checked="checked"<?php endif; ?>></td>
          </tr>
          <tr>
            <th><input type="submit" class="button-primary"></th>
          </tr>
        </table>
      </form>
    </div>
  </div>
<?php
        break;
      case 'scan':
      default:
?>
  <div style="width:65%;min-width:500px;float:left;clear:both;">
  	<div class="postbox metabox-holder">
  		<h3 class="hndle">1. Scan</h3>
  		<form action="" method="post">
  		  <input type="hidden" name="cg-tvs-action" value="scan">
    		<div class="inside">
    			<p>When you click "Scan", we'll scan all of the php in your wp-content directory looking for the timthumb script.  We'll check the version of every found file to see if the file is outdated or unsafe.  Outdated or unsafe files can be 1 click updated to the latest version.</p>
    			<p style="text-align:center;padding-top:15px;"><input type="submit" class="button-primary" value="Scan!"></p>
    		</div>
      </form>
  	</div>
    <h3>Scan Results</h3>
    <?php if($this->last_scan == 0): ?>
      <p>It doesn't look like you've run a scan yet.  Click the "Scan!" button above to get started.</p>
    <?php else: ?>
    <p>The latest version of the Timthumb script is <strong><?php echo $this->script_latest_version; ?></strong>.  The oldest safe version is version <strong><?php echo $this->script_safe_version; ?></strong>.  Last scan run <?php echo human_time_diff($this->last_scan) ?> ago.</p>
    <form action="" method="post">
      <input type="hidden" name="cg-tvs-action" value="fix">
      <?php wp_nonce_field( 'fix_timthumb_files'); ?>
      <table class="widefat">
        <thead>
        <tr>
          <th class="manage-column column-cb check-column" id="cb"><input type="checkbox"></th>    
          <th>Status</th>    
          <th>Version</th>    
          <th>Filename</th>    
          <th>Full Path</th>
        </tr>
        </thead>
        <?php if(empty($this->script_instances)): ?>
        <tr>
          <td colspan="5" style="text-align:center"><strong style="color:forestgreen">No instances of timthumb were found on your server.</strong></td>
        </tr>
        <?php else: ?>
        <?php foreach($this->script_instances as $key=>$instance): ?>
        <tr class="<?php if($alternate > 0){ echo 'alternate'; $alternate = -1; }else{ $alternate = 1; } ?>">
          <?php if($this->get_version_status($instance['version']) == 'Up to Date'): ?>
            <th scope="row" class="check-column">&nbsp;</th>
          <?php else: ?>
            <th scope="row" class="check-column"><input type="checkbox" name="fix[]" value="<?php echo $key; ?>"></td>
          <?php endif; ?>
          <td><?php echo $this->display_version_status($instance['version']); ?></td>
          <td><?php echo $instance['version']; ?></td>
          <td><?php echo basename($instance['path']); ?></td>
          <td><?php echo $instance['path']; ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </table>
      <p>
        <input type="submit" class="button-primary" value="Upgrade Selected Files">
      </p>
    </form>
    <?php endif; ?>
  
    <?php if(!empty($this->suspicious_files)): ?>
    <h3 style="color:#ff0000">Suspicious Files</h3>
    <p>These files likely indicate that hackers have <strong>already</strong> compromised your system.  They should be deleted.  Please note:  No files listed here does <strong>NOT</strong> guarantee you haven't already been compromised, but files listed here almost certainly means you have.</p>
    <p>If your server has been compromised, your best bet is to hire a professional to clean your site up (<a href="http://codegarage.com/hack-cleanup">Click here for more info</a> - even if all you want is a little advice).</p>
      <table class="widefat">
        <thead>
        <tr>
          <th>Filename</th>    
          <th>Full Path</th>
        </tr>
        </thead>
        <?php foreach($this->suspicious_files as $key=>$file): ?>
        <tr class="<?php if($alternate > 0){ echo 'alternate'; $alternate = -1; }else{ $alternate = 1; } ?>">
          <td><?php echo basename($file); ?></td>
          <td><?php echo $file; ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php if(empty($this->suspicious_files)): ?>
      <p><strong>Worried that you're already hacked?</strong> <a href="http://codegarage.com/hack-cleanup">Get in touch with us</a>.</p>
      <?php endif; ?>
    <?php endif; ?>
    
  </div>
<?php          
        break;
      } ?>
  	
  	
  <div style="float:right;width:33%;">
  	<div class="postbox metabox-holder" style="padding-top:0px">
  		<h3 class="hndle" style="text-align:center"><a href="http://codegarage.com/"><img src="<?php echo WP_PLUGIN_URL; ?>/<?php echo basename( dirname( __FILE__ ) ); ?>/locker_logo.png"></a></h3>
  		<div class="inside">
  			<p><strong>Tired of worrying about your WordPress sites?</strong></p>
  			<p><a href="http://codegarage.com/?ref=tvs" target="_blank" >Locker</a> from <a href="http://codegarage.com/?ref=tvs"  target="_blank" >Code Garage</a> provides rock solid daily backups and hack monitoring and cleanup (for malicious code and vulnerabilities like this one), as well as personal, one on one support when you need it.</p>
  			<p style="text-align:center;padding-top:15px;"><a href="http://codegarage.com/?ref=tvs" target="_blank" class="button-primary">Click here to learn more</a></p>
  		</div>
  	</div>
  
  	<div class="postbox metabox-holder" style="padding-top:0px">
  		<h3 class="hndle" >Stay Informed</h3>
  		<div class="inside">
  			<p>Stay up to date on best practices and stay ahead of new vulnerabilities that could threaten your site.</p>
  			<h4>WP Security Newsletter</h4>
        <!-- Begin MailChimp Signup Form -->
        <style type="text/css">
        	#mce-EMAIL{background:#fff; 
        	   border:1px solid #ccc; 
        	   padding:5px;
        	   font-size:14px;
        	   width:70%;
        	   margin-bottom:10px; }
        </style>
        <div id="mc_embed_signup">
          <form action="http://codegarage.us1.list-manage1.com/subscribe/post?u=18eaf7659266bae84144eef88&amp;id=0029c09237" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
          	<label for="mce-EMAIL"></label>
          	<div >
          	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
          	<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button-secondary">
          	</div>
          </form>
        <!--End mc_embed_signup-->
  			<h4>Codegarage on Twitter</h4>
<a href="https://twitter.com/yourcodegarage" class="twitter-follow-button" data-show-count="false">Follow @yourcodegarage</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
  			<h4><a href="http://codegarage.com/blog/?src=tvs" >Codegarage Blog</a></h4>
        </div>
  		</div>
  	</div>
  </div>
</div>

