# Chainer

> Chain your actions and make a complex workflow more readable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/babicaja/chainer)](https://packagist.org/packages/babicaja/chainer)
[![Total Downloads](https://img.shields.io/packagist/dt/babicaja/chainer)](https://packagist.org/packages/babicaja/chainer)
[![tests](https://github.com/babicaja/chainer/workflows/tests/badge.svg)](https://github.com/babicaja/chainer/workflows/tests/badge.svg)
[![Coverage](https://codecov.io/gh/babicaja/chainer/branch/master/graph/badge.svg)](https://codecov.io/gh/babicaja/chainer)
[![Licence](https://img.shields.io/github/license/babicaja/chainer)](https://github.com/babicaja/chainer)

- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)

## Installation

Install `Chainer` using composer with the following command

```bash
composer require babicaja/chainer
```

## Usage

Chain actions and pass any type of payload through a simple interface

```php
Chain::do(TaskOne::class)
->then(TaskTwo::class)
->then(TaskThree::class)
->run('payload');
```

The actions passed to the `Chainer\Chain->then()` method can be any of the following

- [Chain Instance](#chain-instance)
- [Invokable Class](#invokable-class) 
- [Callback / Callable](#callback--callable)

### Chain Instance

```php
namespace Examples;

use Chainer\Chain;

class FirstAction
{
    public function __invoke($payload = null)
    {
        $payload[] = __METHOD__;
        return $payload;
    }
}

class SecondAction
{
    public function __invoke($payload = null)
    {
        $payload[] = __METHOD__;
        return $payload;
    }
}

$chain = Chain::do(FirstAction::class)
    ->then(SecondAction::class);

$result = Chain::do($chain)
    ->then(FirstAction::class)
    ->run([]);

echo json_encode($result); 
```

Result

```php
[
    "Examples\\FirstAction::handle",
    "Examples\\SecondAction::handle",
    "Examples\\FirstAction::handle"
]
```

### Invokable Class

|:information_source: Invokable can be an instance or fqn `Chain::do(new FirstAction())`  or `Chain::do(FirstAction::class)` |
|----------------------------------------------------------------------------------------------------------------------------|

```php
namespace Examples;

use Chainer\Chain;

class FirstAction
{
    public function __invoke($payload = null)
    {
        $payload[] = __METHOD__;
        return $payload;
    }
}

class SecondAction
{
    public function __invoke($payload = null)
    {
        $payload[] = __METHOD__;
        return $payload;
    }
}

$result = Chain::do(FirstAction::class)
    ->then(SecondAction::class)
    ->run();

echo json_encode($result); 
```

Result

```php
[
    "Examples\\FirstAction::__invoke",
    "Examples\\SecondAction::__invoke"
]
```

### Callback / Callable

```php
namespace Examples;

use Chainer\Chain;

function helper($payload)
{
    $payload[] = __METHOD__;
    return $payload;
}

class Util
{
    public function method($payload)
    {
        $payload[] = __METHOD__;
        return $payload;
    }

    public static function staticMethod($payload)
    {
        $payload[] = __METHOD__;
        return $payload;
    }
}

class App
{
    public function run()
    {
        return Chain::do(fn($payload) => $this->method($payload))
            ->then(fn($payload) => self::staticMethod($payload))
            ->then([new Util(), 'method'])
            ->then([Util::class, 'staticMethod'])
            ->then('Examples\helper')
            ->then(function ($payload) {
                $payload[] = __METHOD__;
                return $payload;
            })
            ->run([]);
    }

    private function method($payload)
    {
        $payload[] = __METHOD__;
        return $payload;
    }

    private static function staticMethod($payload)
    {
        $payload[] = __METHOD__;
        return $payload;
    }
}

$app = new App();
echo json_encode($app->run());
```

Result

```php
[
    "Examples\\App::method",
    "Examples\\App::staticMethod",
    "Examples\\Util::method",
    "Examples\\Util::staticMethod",
    "Examples\\helper",
    "Examples\\{closure}"
]
```

## Contributing

Contributors:

 - [babicaja](https://github.com/babicaja)

You are more than welcome to contribute to this project. The main goal is to keep it simple because there are more than enough libraries with advance features. To take your work into consideration please create a Pull Request along the following guidelines:

```
## What's the purpose of this PR?
(Insert the description of the purpose of this change here)
## Impact Analysis
(What will this possibly affect?)
## Where should the tester start?
(Hints tips or tricks regarding how to test this, things to watch out for, etc)
## What are the relevant tickets?
(Is this related to a ticket/bug at the moment?)
```

Don't forget to write unit tests! All contributors will be listed.
