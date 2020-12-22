> Into Template file
```twig
  {{isTrue(var)}}
```

> Into config/app-config.php file
```php
$app->setViewFilters([
  //here, key is required
  "isTrue" => function ($value = true) {
    return $value;
  }
]);
```