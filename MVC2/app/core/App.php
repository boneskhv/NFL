<?php

/*class App
{
	protected $controller = 'home';
	protected $method = 'index';
	protected $params = [];

	public function __construct()
	{
		$url = $this->parseUrl();

		if (file_exists('../app/controllers/' . $url[0] . '.php'))
		{
			$this->controller = $url[0];
			unset($url[0]);
		}

		require_once '../app/controllers/' . $this->controller . '.php';

		if (isset($url[1]))
		{
			if (method_exists($this->controller, $url[1]))
			{
				$this->method = $url[1];
				unset($url[1]);
			}
		}

		$this->params = $url ? array_values ($url) : [] ;

		call_user_func_array([$this->controller, $this->method], $this->params );
	}

	public function parseUrl()
	{

		$url = parse_url($_SERVER["REQUEST_URI"])["path"];
		$url = array_filter(explode("/", $url));
		$pos = array_search("index.php", $url);

		for ($i = 0; $i <= $pos; $i++)
			unset($url[$i]);

		return $url = array_values ($url);

		//print_r($_GET['URL']);
		//if (isset($_GET['URL'])) {
		//	return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		
	}

}
*/


class App
{
	//protected $controller = 'home';
	protected $controller = 'User';
	protected $method = 'index';
	protected $params = [];
	public function __construct()
	{
		$url = $this->parseUrl();
		if (file_exists('../app/controllers/' . $url[0] . '.php'))
		{
			$this->controller = $url[0];
			unset($url[0]);
		}
		require_once '../app/controllers/' . $this->controller . '.php';
		if (isset($url[1]))
		{
			if (method_exists($this->controller, $url[1]))
			{
				$this->method = $url[1];
				unset($url[1]);
			}
		}
		$this->params = $url ? array_values ($url) : [] ;
		call_user_func_array([$this->controller, $this->method], $this->params );
	}
	public function parseUrl()
	{
		if (isset($_GET['url'])) {
			return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}