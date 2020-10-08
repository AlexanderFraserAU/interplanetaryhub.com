<?php
	class Cookie {
		public static function exists($name) {
			return (isset($_COOKIE[$name]));
		}

		public static function get($name) {
			return $_COOKIE[$name];
		}

		public static function put($name, $value, $expiry) {
			//var_dump(headers_list());
			//echo "<br>";
			//echo headers_sent();
			//setcookie("DOG", "test", time() + $expiry, '/');
			if (setcookie($name, $value, time() + $expiry, '/')) { 
				return true;
			}
			return false;
		}
	
		public static function delete($name) {
			self::put($name, '', time()-1);
		}
	}
?>
