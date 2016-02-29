# Dwoo for PHPTransformers

[Dwoo](http://dwoo.org/) support for [PHPTransformers](http://github.com/phptransformers/phptransformer).

## Install

Via Composer

``` bash
$ composer require phptransformers/dwoo
```

## Usage

``` php
$engine = new DwooTransformer();
echo $engine->render('Hello, {$name}!', array('name' => 'phptransformers'));
```

### Options

``` php
$engine = new DwooTransformer(array(
    'cache-dir' => 'path/to/the/cache', // Default to the system temporary directory
    'compile-dir' => 'path/to/the/compile/dir', // Default to the system temporary directory
    'template-dir' => 'path/to/the/templates' // By default search for absolute path
));

// ...

$core = new \Dwoo\Core();
$engine = new DwooTransformer(array(
    'dwoo' => $core // All others options are ignored
));
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.