phpfox-service
=====================================
>
> This library does not support service locator pattern.  
> All service must be declare in configure explicit.
> 

Service manager is a container which control the way to create an object using their name instead of create them explicit.

There are 4 methods in the container
- has($id): bool
- get($id): mixed
- set($id, $object)
- build($id): mixed
- remove($id): void

In other to configure an object, declare them in `module.config.php`.

```php
return [
    'services'=>[
        'map'=>[
            'db'=> [null, ServiceClass],
            'db2'=> [ServiceFactoryClass,],
        ]
    ]
]
```

```php
```


We support 2 way of $scheme value:
- If the first value is null, the constructor of `ServiceClass` will be called.
- If the first value is a string, It must implement `FactoryInterface`, so the factory pattern will be used. 

Example

`module.config.php`

```php
return [
    'services'=>[
        'map'=>[
            'models'=>[null, 'Phpfox\Model\GatewayManager'],
            'other_service'=> [OtherServiceFactory,]
        ]
    ]
]

class OtherServiceFactory {
    function factory($className){
        return new ExampleService();
    }
}
```

Use class name directly

```php
$models  =  $service->get('models');
echo get_class($models);
//print "Phpfox\Model\GatewayManager"
```

Use factory class name

```php
$others  =  $service->get('other_service');
echo get_class($others);
//print "ExampleService"
```

Service Manager is a container, when you call `get($id)`
- If the first call, they build a service map to $id, then store in their container.
- Call `get($id)` again, it return the object in its container.
- If you want to create a new instance of $id, call `build($id)` instead. 