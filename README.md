Guardian360 Resonance
=====================

[![Build Status](https://travis-ci.org/guardian360/Resonance.svg?branch=master)](https://travis-ci.org/guardian360/Resonance)
[![Coverage Status](https://img.shields.io/coveralls/github/guardian360/Resonance/master.svg)](https://coveralls.io/github/guardian360/Resonance?branch=master)

Resonance aims to make performing HTTP requests and getting responses extremely
simple.

Requirements
------------

* PHP >=7.0.0

Installation
------------

Install via composer.

```sh
$ composer require guardian360/resonance
```

Usage
-----

Currently, only a Guzzle driver is implemented. I'm not necessarily expecting
to expand drivers myself, as writing your own drivers is extremely simple using
the Driver contract shipped with the library. You can simply create your own
driver implementation with pretty much any HTTP library.

Without further ado, a simple example is shown below.

```php
// First, we set up a library client which we want our client to use. Here, we
// are using a Guzzle client, which we can predefine beforehand with options
// such as headers, cookies or multipart requests.
$library = new GuzzleHttp\Client(['base_uri' => 'https://localhost']);

// Next we feed the library to the driver we'd like to use. In this case, since
// we've setup a Guzzle client, we'll be using the Guzzle driver naturally.
$driver = new Resonance\Drivers\Guzzle($library);

// Finally we feed the driver we want to use to our client.
$client = new Resonance\Client($driver);

// Then we can simply perform HTTP requests and get the response body.
// For example, GET requests...
$response = $client->get('/');

// POST requests...
$response = $client->post('/contact', [
    'email' => 'someone@example.com',
    'subject' => 'Hi there',
    'content' => 'Resonance is so cool, it makes everything so simple!'
]);

// PUT requests...
$response = $client->put('/users/1/edit', ['name' => 'Mambo Jambo']);

// And DELETE requests.
$response = $client->delete('/posts/1');
```
