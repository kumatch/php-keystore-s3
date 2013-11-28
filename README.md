PHP KeyStore-S3
===========

[kumatch/keystore](https://github.com/kumatch/php-keystore) driver for AWS S3.


Install
-----

Add "kumatch/fs-keystore-s3" as a dependency in your project's composer.json file.


    {
      "require": {
        "kumatch/fs-keystore-s3": "*"
      }
    }

And install your dependencies.

    $ composer install


Usage
-----

```php
use Kumatch\KeyStore\S3\Driver;
use Kumatch\KeyStore\S3\AwsRegion; // AwsRegion extends Aws\Common\Enum\Region (aws-sdk)

$config = array(
    "key" => "aws_key",
    "secret" => "aws_secret",
    "region" => AwsRegion::US_WEST_1,
);
$bucket = "mybucket";

$driver = new Driver($config, $bucket);
```

### __construct (array $s3Config, $bucket)

Set AWS S3 configurations (same an array of configuration options by "AWS SDK for PHP" S3 client, see [docs](http://docs.aws.amazon.com/aws-sdk-php/latest/class-Aws.S3.S3Client.html#_factory)) and bucket name.


License
--------

Licensed under the MIT License.

Copyright (c) 2013 Yosuke Kumakura

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
