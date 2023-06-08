## Sanitizer extension for Laravel 5+

### License

This software is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Installation

Add as a service provider to your config/app.php

    ...
    'providers' => array(
            'Smorken\Sanitizer\ServiceProvider',
    ...
    
Use by DI (either injected or by calling app)

```

public function __construct(\Smorken\Sanitizer\Contracts\Sanitize $sanitize) { }

public function someFunction($some_var)
{
    $sanitize = app('\Smorken\Sanitizer\Contracts\Sanitize');
    //specify sanitizer
    $result = $sanitize->get('standard')->sanitize('string', $some_var);
    //or (default)
    $result = $sanitize->sanitize('string', $some_var);
    //or (default)
    $result = $sanitize->get()->string($some_var);
    //or (default)
    $result = $sanitize->string($some_var);
    //parameters
    $result = $sanitize->stripTags($some_var, 'script');
}
```

Without DI/Laravel

```
$options = [
               'default' => 'standard',
               'sanitizers' => [
                   'standard' => \Smorken\Sanitizer\Sanitizers\Standard::class,
                   'sis' => \Smorken\Sanitizer\Sanitizers\RdsCds::class,
               ],
           ];

$sanitize = new \Smorken\Sanitizer\Handler($options);
```
