<?php
/*--------------------------------------*/
/*	Custom Login Logo
/*--------------------------------------*/
function it_custom_login_logo() {
    global $it_data;
    if(($it_data['custom_login_logo'] !='') || ($it_data['custom_login_background'] !='')) {
    
    
        $custom_login_logo_css = '';
        $custom_login_logo_css .= '<style type="text/css">';
        
        // login h1 class
        
        $custom_login_logo_css .= '.login h1 a {';
        $custom_login_logo_css .= 'background-image:url('. $it_data['custom_login_logo'] .') !important;width: auto !important;background-size: auto !important;';
        if($it_data['custom_login_logo_height']) {
            $custom_login_logo_css .= 'height: '.$it_data['custom_login_logo_height'].' !important;';
        }
        $custom_login_logo_css .= '}';
        
        
        // login background
        
        $custom_login_logo_css .= 'body.login{';
        $custom_login_logo_css .= 'background: url('. $it_data['custom_login_background'] .');';
        $custom_login_logo_css .= 'z-index:1';
        $custom_login_logo_css .= '}';
        
        
        // login responsive
        
        $custom_login_logo_css .= '
        
        #login {
		width: 420px;
		padding: 114px 0 0;
		margin-left: 100px;
		}

        
        @media (max-width: 480px) {
     
        #login{
        margin:auto;
        width:300px;
        }
	
        body.login div#login h1 a{
		width:298px;
		margin-left:2px;	
		}

	
		}';
	        
        $custom_login_logo_css .= '</style>';

        echo $custom_login_logo_css;
    }
}
add_action('login_head', 'it_custom_login_logo');
?>