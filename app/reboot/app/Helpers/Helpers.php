<?php

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Laravel\Lumen\Application;
use Laravel\Lumen\Routing\UrlGenerator;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpFoundation\Cookie;

if (!function_exists('d')) {
    /**
     * dump the var
     *
     * @param string $any
     *
     * @return string
     */
    function d(...$dump)
    {
		echo "<pre>";
		return var_dump($dump);
    }
}

if (!function_exists('flatten')) {
    /**
     * Get the flat array with dots.
     *
     * @param string $multiarray
     *
     * @return string
     */
    function flatten($multiArr)
    {
		$ritit = new RecursiveIteratorIterator(new RecursiveArrayIterator($multiArr));
		$result = array();
		foreach ($ritit as $leafValue) {
			$keys = array();
			foreach (range(0, $ritit->getDepth()) as $depth) {
				$keys[] = $ritit->getSubIterator($depth)->key();
			}
			$result[ join('.', $keys) ] = $leafValue;
		}
		return $result;
    }
}


if (!function_exists('csvToArray')) {
    /**
     * Get the current time.
     *
     * @param string $csv
     *
     * @return string
     */
    function csvToArray($csv, $separator = ',')
    {
        //$rows = array_map('str_getcsv',preg_split('/\n/', $csv));
        $rows = array_map(function ($v) use ($separator) {return str_getcsv($v, $separator); }, preg_split('/\n/', $csv));
        $header = array_shift($rows);
        $data = [];
        foreach ($rows as $row) {
            $data[] = array_combine($header, $row);
        }

        return $data;
    }
}

if (!function_exists('now')) {
    /**
     * Get the current time.
     *
     * @param string $date
     *
     * @return string
     */
    function now($date = null)
    {
        if ($date) {
            return Carbon::parse($date);
        }

        return Carbon::now();
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param string $path
     *
     * @return string
     */
    function public_path($path = '')
    {
        return rtrim(app()->basePath('public/'.$path), DIRECTORY_SEPARATOR);
    }
}

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     *
     * @return string
     */
    function config_path($path = '')
    {
        return rtrim(app()->basePath('config/'.$path), DIRECTORY_SEPARATOR);
    }
}

if (!function_exists('mix')) {
    /**
     * Get the path to a versioned Mix file.
     *
     * @param string $path
     * @param string $manifestDirectory
     *
     * @throws \Exception
     *
     * @return \Illuminate\Support\HtmlString
     */
    function mix($path, $manifest = false, $shouldHotReload = false)
    {
        if (!$manifest) {
            static $manifest;
        }
        if (!$shouldHotReload) {
            static $shouldHotReload;
        }

        if (!$manifest) {
            $manifestPath = public_path('mix-manifest.json');
            $shouldHotReload = file_exists(public_path('hot'));

            if (!file_exists($manifestPath)) {
                throw new Exception(
                    'The Laravel Mix manifest file does not exist. '.
                    'Please run "npm run webpack" and try again.'
                );
            }

            $manifest = json_decode(file_get_contents($manifestPath), true);
        }

        if (!Str::startsWith($path, '/')) {
            $path = "/{$path}";
        }

        if (!array_key_exists($path, $manifest)) {
            throw new Exception(
                "Unknown Laravel Mix file path: {$path}. Please check your requested ".
                'webpack.mix.js output path, and try again.'
            );
        }
        $HMR_PORT = isset($_ENV['MIX_HMR']) ? $_ENV['MIX_HMR'] : 8080;

        return $shouldHotReload
            ? "http://localhost:{$HMR_PORT}{$manifest[$path]}"
            : url($manifest[$path]);
    }
}

if (!function_exists('auth')) {
    /**
     * Get the available auth instance.
     *
     * @param string|null $guard
     *
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function auth($guard = null)
    {
        if (is_null($guard)) {
            return app(AuthFactory::class);
        }

        return app(AuthFactory::class)->guard($guard);
    }
}

if (!function_exists('abort_if')) {
    /**
     * Throw an HttpException with the given data if the given condition is true.
     *
     * @param bool   $boolean
     * @param int    $code
     * @param string $message
     * @param array  $headers
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return void
     */
    function abort_if($boolean, $code, $message = '', array $headers = [])
    {
        if ($boolean) {
            abort($code, $message, $headers);
        }
    }
}

if (!function_exists('abort_unless')) {
    /**
     * Throw an HttpException with the given data unless the given condition is true.
     *
     * @param bool   $boolean
     * @param int    $code
     * @param string $message
     * @param array  $headers
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return void
     */
    function abort_unless($boolean, $code, $message = '', array $headers = [])
    {
        if (!$boolean) {
            abort($code, $message, $headers);
        }
    }
}

if (!function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->make($value, $options);
    }
}

if (!function_exists('cookie')) {
    /**
     * Create a new cookie instance.
     *
     * @param string      $name
     * @param string      $value
     * @param int         $minutes
     * @param string      $path
     * @param string      $domain
     * @param bool        $secure
     * @param bool        $httpOnly
     * @param bool        $raw
     * @param string|null $sameSite
     *
     * @return \Illuminate\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie
     */
    function cookie($name = null, $value = null, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = true, $raw = false, $sameSite = null)
    {
        list($path, $domain, $secure, $sameSite) = [$path, $domain, $secure, $sameSite];

        $time = ($minutes == 0) ? 0 : Carbon::now()->addSeconds($minutes * 60)->getTimestamp();

        return new Cookie($name, $value, $time, $path, $domain, $secure, $httpOnly, $raw, $sameSite);
    }
}

if (!function_exists('policy')) {
    /**
     * Get a policy instance for a given class.
     *
     * @param object|string $class
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    function policy($class)
    {
        return app(Gate::class)->getPolicyFor($class);
    }
}

if (!function_exists('report')) {
    /**
     * Report an exception.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    function report($exception)
    {
        if ($exception instanceof Throwable &&
            !$exception instanceof Exception) {
            $exception = new FatalThrowableError($exception);
        }
        app(ExceptionHandler::class)->report($exception);
    }
}

if (!function_exists('action')) {
    /**
     * Generate the URL to a controller action.
     *
     * @param string $name
     * @param array  $parameters
     * @param bool   $absolute
     *
     * @return string
     */
    function action($name, $parameters = [], $absolute = true)
    {
        /** @var Application $app */
        $app = app();
        $matches = [];
        if (preg_match('/Lumen \(([0-9\.]+)\)/', $app->version(), $matches)) {
            $version = floatval(trim($matches[1]));
            if (5.5 <= $version) {
                $routes = app('router')->getRoutes();
            } else {
                $routes = $app->getRoutes();
            }
        } else {
            $routes = $app->getRoutes();
        }
        foreach ($routes as $route) {
            $uri = $route['uri'];
            $action = $route['action'];
            if (isset($action['uses'])) {
                if ($action['uses'] === $name) {
                    $uri = preg_replace_callback('/\{(.*?)(:.*?)?(\{[0-9,]+\})?\}/', function ($m) use (&$parameters) {
                        return isset($parameters[$m[1]]) ? array_pull($parameters, $m[1]) : $m[0];
                    }, $uri);
                    $uri = with(new UrlGenerator($app))->to($uri, []);
                    if (!$absolute) {
                        $root = $app->make('request')->root();
                        if (starts_with($uri, $root)) {
                            $uri = Str::substr($uri, Str::length($root));
                            if (empty($uri)) {
                                $uri = '/';
                            }
                        }
                    }
                    if (!empty($parameters)) {
                        $uri .= '?'.http_build_query($parameters);
                    }

                    return $uri;
                }
            }
        }

        throw new InvalidArgumentException("Action {$name} not defined.");
    }
}

if (!function_exists('app_with')) {
    /**
     * Get the available container instance.
     *
     * @param string $abstract
     * @param array  $parameters
     *
     * @return mixed|Application
     */
    function app_with($abstract = null, array $parameters = [])
    {
        /** @var Application $app */
        $app = Application::getInstance();
        if (is_null($abstract)) {
            return $app;
        }
        if (method_exists($app, 'makeWith')) {
            return empty($parameters)
                ? $app->make($abstract)
                : $app->makeWith($abstract, $parameters);
        } else {
            return $app->make($abstract, $parameters);
        }
    }
}

if (!function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool   $secure
     *
     * @return string
     */
    function asset($path, $secure = null)
    {
        return (new UrlGenerator(app()))->to($path, null, $secure);
    }
}

if (!function_exists('back')) {
    /**
     * Create a new redirect response to the previous location.
     *
     * @param int   $status
     * @param array $headers
     * @param mixed $fallback
     *
     * @return RedirectResponse
     */
    function back($status = 302, $headers = [], $fallback = false)
    {
        return redirect()->back($status, $headers, $fallback);
    }
}

if (!function_exists('cache')) {
    /**
     * Get / set the specified cache value.
     *
     * If an array is passed, we'll assume you want to put to the cache.
     *
     * @param dynamic key|key,default|data,expiration|null
     *
     * @throws \Exception
     *
     * @return mixed
     */
    function cache()
    {
        $arguments = func_get_args();
        if (empty($arguments)) {
            return app('cache');
        }
        if (is_string($arguments[0])) {
            return app('cache')->get($arguments[0], isset($arguments[1]) ? $arguments[1] : null);
        }
        if (!is_array($arguments[0])) {
            throw new Exception(
                'When setting a value in the cache, you must pass an array of key / value pairs.'
            );
        }
        if (!isset($arguments[1])) {
            throw new Exception(
                'You must specify an expiration time when setting a value in the cache.'
            );
        }

        return app('cache')->put(key($arguments[0]), reset($arguments[0]), $arguments[1]);
    }
}

if (!function_exists('logger')) {
    /**
     * Log a debug message to the logs.
     *
     * @param null  $message
     * @param array $context
     *
     * @return Log|null
     */
    function logger($message = null, array $context = [])
    {
        if (is_null($message)) {
            return app('log');
        }

        return app('log')->debug($message, $context);
    }
}

if (!function_exists('method_field')) {
    /**
     * Generate a form field to spoof the HTTP verb used by forms.
     *
     * @param $method
     *
     * @return HtmlString
     */
    function method_field($method)
    {
        return new HtmlString('<input type="hidden" name="_method" value="'.$method.'" />');
    }
}

if (!function_exists('validator')) {
    /**
     * Create a new Validator instance.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     *
     * @return Validator|ValidationFactory
     */
    function validator(array $data = [], array $rules = [], array $messages = [], array $customAttributes = [])
    {
        /** @var ValidationFactory $factory */
        $factory = app(ValidationFactory::class);
        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($data, $rules, $messages, $customAttributes);
    }
}

if (!function_exists('request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param array|string $key
     * @param mixed        $default
     *
     * @return \Illuminate\Http\Request|string|array
     */
    function request($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('request');
        }

        if (is_array($key)) {
            return app('request')->only($key);
        }

        $value = app('request')->__get($key);

        return is_null($value) ? value($default) : $value;
    }
}
