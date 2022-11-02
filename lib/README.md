---
title: [library] CLI Constructor Arg Auto Proxy  
keywords: CLI, Proxy, ObjectManager  
author: Vlad Podorozhnyi  
send_questions_to: vpodorozh@gmail.com | vlad.podorozhnyi@run-as-root.sh  
category: System  
---
![Magento 2](https://img.shields.io/badge/Magento-2.4.*-orange)
![PHP](https://img.shields.io/badge/php-7.4-blue)
![composer](https://shields.io/badge/composer-v2-darkgreen)
![packagist](https://img.shields.io/badge/packagist-f28d1a)

## **\[library\] Cli Constructor Arg Auto Proxy**

## Features

### Auto add proxies as arguments to CLI command classes

Automatically injects Proxy for any argument defined in CLI command class constructor.  
Entry point of functionality is based on DI config reader that is used in both cases - developer and production modes.

## Technical Specification

### Plugins

#### `\Vpodorozh\CliConstructorArgAutoProxy\Plugin\Dom\EnrichCliConfigWithProxyPlugin`
* responsible for enriching DI config with Proxies for CLI command constructor arguments;
* executed after DI config reading;
* plugin is executed in not trivial way - via preference on DOM config reader of DI (see section bellow for more details) 
* Caller class: `\Vpodorozh\CliConstructorArgAutoProxy\Preference\Framework\ObjectManager\Config\Reader\Dom\Interceptor`

### Preferences

| source-class                                       | custom-class                                                          |
|----------------------------------------------------|-----------------------------------------------------------------------|
| Magento\Framework\ObjectManager\Config\Reader\Dom  | ...\Preference\Framework\ObjectManager\Config\Reader\Dom\Interceptor  |


#### `\Vpodorozh\CliConstructorArgAutoProxy\Preference\Framework\ObjectManager\Config\Reader\Dom\Interceptor`
Workaround for plugin execution.  
This override has the same purpose as regular Magento 2 Interceptors - hook for calling plugins.  
It is not possible to define plugin over DOM config reader, as it is created before Magento plugin functionality starts. 
Preference is the only way to hook in.

### Services

#### `\Vpodorozh\CliConstructorArgAutoProxy\Service\EnrichCliConfigWithProxyService`
Enrich provided DI config with proxies for CLI class commands only.

#### `\Vpodorozh\CliConstructorArgAutoProxy\Service\GetProxiedConstructArgsConfigService`
Receives CLI command constructor arguments types and reformat them to Proxy types.  
Using `IsClassEligibleForProxyValidator` to determine is class eligible to be Proxied.

### Validator

#### `\Vpodorozh\CliConstructorArgAutoProxy\Validator\IsClassEligibleForProxyValidator`
Check is Proxy applicable for this specific class.  

### Mapper

#### `\Vpodorozh\CliConstructorArgAutoProxy\Mapper\ProxiedConstructArgsToDiConfigMapper`
Adds Proxy DI configs for specific CLI class command to DI configs pool.
