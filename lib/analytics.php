<?php

	class Analytics
	{
		
		public static function track()
		{
			?>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=UA-68142519-11"></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				gtag('config', 'UA-68142519-11');
			</script>
			<?php
		}
	}
?>