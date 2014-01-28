<?php ///revCMS sys/_init.php
///Initialize CMS, add templates, run commands

///Implements locks for every class method
class _Locks {
	protected static $LOCKS = array();

	///Class function - is locked?
	final protected static function is_locked($n = 2) {
		$r = isset(self::$LOCKS[($c = get_called_class())][($f = debug_backtrace()[$n]['function'])]);
		return array($r, $c, $f);
	}

	///Set the lock, but 1st time return false
	final protected static function lock() {
		list($r, $c, $f) = self::is_locked();
		return $r ? TRUE : (!(self::$LOCKS[$c][$f] = TRUE));
	}

	///Unset the lock, but 1st time return false
	final protected static function unlock() {
		list($r, $c, $f) = self::is_locked();
		if ($r)
			self::$LOCKS[$c][$f] = NULL;
		return !$r;
	}
}

///dumper
function pre_dump() {
	$vars = func_get_args();
	echo '<pre>';
	foreach ($vars as $v) {
		var_dump($v);
		echo '<br />';
	}
	echo '</pre>';
}
function vdump(){
	call_user_func_array('pre_dump', func_get_args());
}

/**
 * Return trimmed dirs in string
 * @param $str
 * @return trimmed ROOT
 */
function pathdiff($str) {
	return str_replace(ROOT, '', $str);
}

///clone array, w. dereferencing
function array_copy($source) {
	$arr = array();

	foreach ($source as $k => $el)
		if (is_array($el))
			$arr[$k] = array_copy($el);
		elseif (is_object($el))
			// make an object copy
			$arr[$k] = clone $el;
		else
			$arr[$k] = $el;
	return $arr;
}

require_once ROOT.'/sys/Errors.php';

set_exception_handler('Error::h');
set_error_handler('Error::h', E_ALL);
register_shutdown_function('Error::h');

require_once ROOT.'/sys/Mod.php';

spl_autoload_register('CMS\Mod::class_load');

//helpers that should not obscure init script, but still are required
require_once ROOT.'/sys/_helpers.php';

CMS::go();