---
title: Magento CLI Constructor Arg Auto Proxy  
keywords: Magento, CLI, Proxy, ObjectManager  
author: Vlad Podorozhnyi  
send_questions_to: vpodorozh@gmail.com | vlad.podorozhnyi@run-as-root.sh  
category: System
---
![Magento 2](https://img.shields.io/badge/Magento-2.4.*-orange)
![PHP](https://img.shields.io/badge/php-7.4-blue)
![composer](https://shields.io/badge/composer-v2-darkgreen)
![packagist](https://img.shields.io/badge/packagist-f28d1a)

<br />
<div align="center">
  <img src="images/logo.png" alt="Logo" width="100" height="80">

<h3 align="center">Magento 2 - Auto Proxy to CLI class arguments</h3>

  <p align="center">
    Automatically injects Proxy for any argument defined in CLI command class constructor.
    <br />
  </p>
</div>

## About The Project

### Purpose:
* speed up `php bin/magento` command execution;
* eliminate `.flag table not found` issues while installation of your project with fresh database (usually used with integration tests) - caused by not using Proxy in CLI of 3rd parties.

## Getting Started

### Prerequisites
* Magento v2.4.* and upper
* composer v2 and upper

### Structure
* magento2-component - see [README.md](component/README.md)
* library - see [README.md](lib/README.md)

### Installation

```bash
composer req vpodorozh/magento-cli-auto-proxy:*
```

## Roadmap

- [x] MVP release
- [x] Documentation
- [ ] PHP 8 support (mostl likely supported already :suspect: )
- [ ] Unit tests coverage
- [ ] Static tests coverage
  - [ ] php linting
  - [ ] phpcs
  - [ ] phpmd
  - [ ] phpstan
- [ ] Integration tests coverage
- [ ] Pipelines tests automation
    - [ ] Static tests
    - [ ] Unit tests
    - [ ] Integration tests
    - [ ] Magento multiversions tests

## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

## Contact

_Vlad Podorozhnyi_  
Twitter: [![@vpodorozh](https://img.shields.io/twitter/url?style=social&url=https%3A%2F%2Ftwitter.com%2Fvpodorozh)](https://twitter.com/vpodorozh)  
Email: `vpodorozh@gmail.com` | `vlad.podorozhnyi@run-as-root.sh`
