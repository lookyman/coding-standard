# Coding Standard

Variation of [Slevomat Coding Standard](https://github.com/slevomat/coding-standard).

Install with [Composer](https://getcomposer.org):

```sh
composer require --dev lookyman/coding-standard:^0.0.2
```

Then mention in `ruleset.xml`, on PHP 7.0:

```xml
<?xml version="1.0"?>
<ruleset name="AcmeProject">
    <rule ref="vendor/lookyman/coding-standard/CodingStandard/ruleset-7.0.xml"/>
    <!-- additional settings -->
</ruleset>
```

Or if you are on PHP 7.1:

```xml
<?xml version="1.0"?>
<ruleset name="AcmeProject">
    <rule ref="vendor/lookyman/coding-standard/CodingStandard/ruleset-7.1.xml"/>
    <!-- additional settings -->
</ruleset>
```
