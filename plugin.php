<?php
/*
Plugin Name: MatomoTracking
Plugin URI: https://github.com/NothingTV/matomo-yourls
Description: Track the redirections with matomo.
Version: 1.0.1
Author: NothingTV
Author URI: https://github.com/NothingTV
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();
// Hook our custom function into the 'pre_redirect' event
yourls_add_action( 'pre_redirect', 'warning_redirection' );

// Our custom function that will be triggered when the event occurs
function warning_redirection( $args ) {
    $url = $args[0];
    $code = $args[1];
	
	$matomo_url = ""; // Add your URL from matomo here. Example: analytics.example.de
	$matomo_id = ""; // Add your Tracking ID here
	$content = "<html><head><meta http-equiv=\"refresh\" content=\"0; URL='$url'\">
	<!-- Matomo -->
	<script type=\"text/javascript\">
	  var _paq = window._paq || [];
	  /* tracker methods like \"setCustomDimension\" should be called before \"trackPageView\" */
	  _paq.push(['trackPageView']);
	  _paq.push(['enableLinkTracking']);
	  (function() {
		var u=\"https://" . $matomo_url . "/\";
		_paq.push(['setTrackerUrl', u+'matomo.php']);
		_paq.push(['setSiteId', '" . $matomo_id . "']);
		var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
	  })();
	</script>
	<noscript><p><img src=\"https://" . $matomo_url . "/matomo.php?idsite=" . $matomo_id . "&amp;rec=1\" style=\"border:0;\" alt=\"\" /></p></noscript>
	<!-- End Matomo Code --></head></html>";
	echo $content;
	
    // Now die so the normal flow of event is interrupted
    die();
}