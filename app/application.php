<?php 

namespace App;

class Application extends \Illuminate\Foundation\Application
{
	/**
	 * Get the path to the public / web directory.
	 *
	 * @return string
	 */
	public function publicPath()
	{
	   return $this->basePath;
	}
}