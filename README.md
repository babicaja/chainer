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
->run($request)
```

The actions passed to the `Chainer\Chain` `then` method can be any of the following
- Class extending the abstract `Chainer\Link`
- Invokable class (implements `__invoke` method)
- Callbacks/Callables

### Extending Chainer\Link

Any class extending the abstract `Chainer\Link` class is valid. 
Pass the class FQN or instance to the `Chainer\Chain` `then` method as shown in the example below

```php
use Chainer\Chain;
use Chainer\Link;

class LinkCatchTime extends Link
{
    /**
     * Handle payload.
     *
     * @param mixed $payload
     * @return mixed
     */
    public function handle($payload = null)
    {
        sleep(1);
        $payload[] = time();
        return $payload;
    }
}

$result = Chain::do(LinkCatchTime::class)
    ->then(new LinkCatchTime())
    ->run([]);

echo json_encode($result); //[1603357212,1603357213]
```

### Invokable classes

Any class that implements the `__invoke` magic method is valid.
Pass the class FQN or instance to the `Chainer\Chain` `then` method as shown in the example below

```php
use Chainer\Chain;
use Chainer\Link;

class InvokableCatchTime
{
    /**
     * @param mixed $payload
     */
    public function __invoke($payload = null)
    {
        sleep(1);
        $payload[] = time();
        return $payload;
    }
}

$result = Chain::do(InvokableCatchTime::class)
    ->then(new InvokableCatchTime())
    ->run([]);

echo json_encode($result); //[1603359696,1603359697]
```

### Callbacks/Callable

Any valid `Callback` or `Callable` is valid 

```php
use Chainer\Chain;
use Chainer\Link;

class CatchTime
{
    /** @param mixed $payload */
    public function catch($payload = null)
    {
        sleep(1);
        $payload[] = time();
        return $payload;
    }
    
    /** @param mixed $payload */
    public static function staticCatch($payload = null)
    {
        sleep(1);
        $payload[] = time();
        return $payload;
    }
}

$result = Chain::do([new CatchTime(), 'catch'])
    ->then([CatchTime::class, 'staticCatch'])
    ->then(function ($payload) {
        sleep(1);
        $payload[] = time();
        return $payload;
    })
    ->run([]);

echo json_encode($result); //[1603360373,1603360374,1603360375]
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
