# putio-drive-sdk

## Installation
Install the bundle:
```bash
$ composer require gpenverne/putio-drive-sdk
```

Load bunle in AppKernel:
```php
    new Gpenverne\PutioDriveBundle\PutioDriveBundle(),
```

### Configuration
```
parameters:
    putio:
        client_id: your-client-id
        client_secret: your-client-secret
        callback_route: callback_route
```
With your custom route in callback_route (for example, to display a success message)

Add your endpoints to your routing.yml or use our controllers endpoints:
```
putio.callback:
    path:     /putio/callback
    defaults: { _controller: putio.drive.controller:callbackAction }

putio.redirect:
    path:     /putio/redirect
    defaults: { _controller: putio.drive.controller:redirectAction }
```



### obtain the user token
Call the previous created route (putio.redirect) .
After access granted, user will be redirected to previous configured "callback_route" parameter

### retrieving the token
Once token obtained, "events.putio.token" event is dispatched.  
This event is handled by putio drive service, and you can retrieve it using putio.drive service:
```php
// In a controller:
$token = $this->container->get('putio.drive')->getToken();
```

### using the putio php sdk
You can use our builtin file/folder finder:
```php
$putioDrive = $this->container->get('putio.drive');
$putioDrive->setToken($token);

// Retrieving a folder
$folder = $putioDrive->findByPath('/MyMovies');

// Retrieving files in the folder
// Will return FileInterface and FolderInterface
// cf. (psr-cloud-files)[https://packagist.org/packages/gpenverne/psr-cloud-files]
$files = $folder->getFiles();

// Or retrieve a full path file
// Will return FileInterface
// cf. (psr-cloud-files)[https://packagist.org/packages/gpenverne/psr-cloud-files]
$file = $putioDrive->findByPath('/MyMovies/MyMovie.mp4');

// Retrieving the download url:
$file = $putioDrive->findByPath('/MyMovies/MyMovie.mp4');
$downloadUrl = $file->getLink();
```

Thanks to [https://github.com/nicoSWD/put.io-api-v2](https://github.com/nicoSWD/put.io-api-v2), you can easily make api calls:
```php
// In a controller, using the previous catched token:
$putioApiClient = $this->container->get('putio.drive')->getApiClient();

// In a controller, using a custom token:
$putioApiClient = $this->container->get('putio.drive')->getApiClient('custom token');
```
