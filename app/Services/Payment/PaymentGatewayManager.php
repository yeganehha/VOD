<?php

namespace App\Services\Payment;

use App\Services\Helper;
use App\Services\Payment\Contracts\PaymentGatewayInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use ReflectionClass;
use RegexIterator;

class PaymentGatewayManager
{
    protected PaymentGatewayInterface $driver;
    protected ?array $config;
    protected array $availableDrivers = [];

    /**
     * @throws \Exception
     */
    public function __construct($driver = null)
    {
        $driver = $driver ?? Helper::setting('ipgType' , config('payment.default'));
        $this->config = config("payment.gateways.{$driver}") ?? [];

        $this->availableDrivers = $this->discoverDrivers();

        if (isset($this->availableDrivers[strtolower($driver)])) {
            $this->driver =  new ($this->availableDrivers[strtolower($driver)])();
            $this->driver->setConfig($this->config);
        } elseif (in_array($driver , $this->availableDrivers)) {
            $this->driver =  new ($driver)();
            $key = array_search($driver , $this->availableDrivers);
            $this->config = [];
            foreach ( config("payment.gateways") ?? [] as $class => $config)
                if ( strtolower($class) == $key )
                    $this->config = $config ?? [];
            $this->driver->setConfig((array) $this->config);
        } else {
            throw new \Exception("Payment gateway driver [{$driver}] not supported.");
        }
    }


    protected function discoverDrivers()
    {
        $drivers = [];
        $namespace = 'App\\Services\\Payment\\Drivers';
        $path = app_path('Services/Payment/Drivers');
//        $files = Storage::allFiles($path);
//        foreach ($files as $file) {
        $directoryIterator = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        $regex = new RegexIterator($iterator, '/^.+\.php$/i', RegexIterator::GET_MATCH);

        foreach ($regex as $file) {
            $filePath = $file[0];

            $relativePath = str_replace($path . DIRECTORY_SEPARATOR, '', $filePath);
            $className = $namespace . '\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);
                if ($reflection->implementsInterface(PaymentGatewayInterface::class)) {
                    $driverKey = strtolower(basename($relativePath, '.php'));
                    $drivers[$driverKey] = $className;
                }
            }
        }

        return $drivers;
    }

    /**
     * @throws \Exception
     */
    public static function getDriver(?string $driver = null):PaymentGatewayInterface
    {
        $object = new self($driver);
        return $object->driver;
    }
}
