<?php ///rev engine \rev\View\Explicit
namespace rev\View;
use \rev\File;

/**
 * Explicit view loader - mostly static stuff
 * MVC For The Win!
 */
class Explicit {
	protected $vars = [];
	protected $basepath = '';
	protected $node = '';

	protected function inc() {
		foreach (func_get_arg(0) as $k => $v)
			${$k} = $v;
		return (include ROOT.func_get_arg(1));
	}

	protected function view($args) {
		$view = $this->basepath.'view/'.$args[0].'.php';
		unset($args[0]);
		if (!File::fileExists($view))
			throw new \rev\Error404("View \"{$view}\" was not found");

		$this->inc($args, $view);
	}

	public function __construct($basepath, $node, $vars = []) {
		$this->basepath = $basepath;
		$this->node = $node;
		$this->vars = $vars;
	}

	public function go() {
		$route = $this->basepath.'control/'.$this->node;

		if (File::fileExists($route.'.php'))
			$route .= ($extension = '.php');
		elseif (File::fileExists($route.'/index.php'))
			$route .= ($extension = '/index.php');
		else
			throw new \rev\Error404("Page not found: \"{$this->node}\"");

		$ret = $this->inc($this->vars, $route);
		$this->vars = [];
		unset($route);

		if (is_array($ret)) {
			if (!isset($ret[0]) || is_string($ret[0])) {
				$view = $this->basepath.'view/'.(isset($ret[0]) ? $ret[0].'.php' : $this->node.$extension);
				unset($ret[0]);

				if (!File::fileExists($view))
					throw new \rev\Error404("View \"{$view}\" was not found");

				$this->inc($ret, $view);

			} elseif (isset($ret[0]) && is_int($ret[0])) {
				$view = '\\rev\\Error'.$ret[0];
				if (isset($ret[1]))
					throw (new $view($ret[1]));
				throw (new $view());
			}
		}
		$this->vars = [];
	}

	/** @see rev\View::setContentType */
	public function setContentType($v) {
		\rev\View::setContentType($v);
	}

	/** @see rev\View::redirect */
	public function redirect($v) {
		\rev\View::redirect($v);
	}

	/** Render view subpath */
	public function sub($path, $vars = []) {
		(new Explicit($this->basepath, $path, $vars))->go();
	}
}
