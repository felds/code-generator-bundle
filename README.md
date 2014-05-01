Felds/CodeGeneratorBundle
=========================

Create random strings based on length and character list


Installation
------------

### 1. Require the bundle with composer

```bash
./composer.phar require felds/code-generator-bundle dev-master
```

### 2. Enable the bundle

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Felds\CodeGeneratorBundle(),
    );
}
```
