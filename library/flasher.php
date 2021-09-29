<?php 
	
	class flasher
	{
		public static function setFlash($act, $msg)
		{
			$_SESSION['flash'] = [
				'msg' 	=> $msg,
				'act'	=> $act,	
			];
		}

		public static function flash()
		{
			if( isset($_SESSION['flash']) ){
				echo '<div class="alert alert-'.(($_SESSION['flash']['act'] == 'success') ? 'success' : 'danger').' alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>'.$_SESSION['flash']['msg'].'</strong>
                    </div>';
                unset($_SESSION['flash']);
			}
		}
    }