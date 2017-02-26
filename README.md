# putio-drive-sdk

### Configuration
```
parameters:
    putio:
        client_id: your-client-id
        client_secret: your-client-secret
        callback_route: callback_route
```
With your custom route in callback_route (for example, to display a success message)

### obtain the user token
Use the route: "putio.redirect"  
After access granted, user will be redirected to "callback_route"

### retrieving the token
Once token obtained, "events.putio.token" event is dispatched.  
This event is handled by putio drive service, and you can retrieve it using putio.drive service:
```php
// In a controller:
$token = $this->container->get('putio.drive')->getToken();
```

### using the putio php sdk
Thanks to [https://github.com/nicoSWD/put.io-api-v2](https://github.com/nicoSWD/put.io-api-v2), you can easily make api calls:
```php
// In a controller, using the previous catched token:
$putioApiClient = $this->container->get('putio.drive')->getApiClient();

// In a controller, using a custom token:
$putioApiClient = $this->container->get('putio.drive')->getApiClient('custom token');
```
