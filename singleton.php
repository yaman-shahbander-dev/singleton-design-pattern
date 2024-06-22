<?php

class Singleton
{
	private static array $instances = [];

	private function __construct() {}

	protected function __clone() {}

	public static function getInstance(): Singleton
	{
		$class = static::class;
		if (!isset(self::$instances[$class])) self::$instances[$class] = new static();
		return self::$instances[$class];
	}
}

class Logger extends Singleton
{
	private $fileHandle;

	protected function __construct()
	{
		$this->fileHandle = fopen('php://stdout', 'w');
	}

	public function get(string $message): void
	{
		$logger = static::getInstance();
		$logger->writeLog($message);
	}

	public function set(string $message): void
	{
		$date = date('Y-m-d');
		fwrite($this->fileHandle, "$date: $message\n");
	}
}

class Config extends Singleton
{
	private array $hashmap = [];

	public function get(string $key): string
	{
		return $this->hashmap[$key];
	}

	public function set(string $key, string $value): void
	{
		$this->hashmap[$key] = $value;
	}
}

$s1 = Config::getInstance();
$s2 = Config::getInstance();

if ($s1 === $s2) {
    echo "Config has a single instance.";
} else {
    echo "Configs are different.";
}
