<?php
namespace App\User;

use App\Exceptions\FileException;

class FileService extends \SplFileObject
{

	public function __construct(string $file, string $open_mode, bool $use_include_path = false)
	{

		$path = dirname($file);
		if (!is_dir($path)) {
			$perm = substr(sprintf('%o', fileperms(dirname($path))), -3);
			if ($perm != 777) {
				chmod(dirname($path), 0777);
			}
			if (false === @mkdir($path, 0777, true)) {
				throw new FileException(sprintf('Unable to create the "%s" directory', $path));
			}
		}

		parent::__construct($file, $open_mode, $use_include_path);
	}
	
	public function write($str, $length = null)
	{
		$seconds = 0;
		while(!$this->flock(LOCK_EX)){
			++$seconds;
			sleep(1);
			if($seconds == 30){
				throw new FileException('Cant to block file');
			}
		}
		
		return parent::fwrite($str, $length);
	}
	
}