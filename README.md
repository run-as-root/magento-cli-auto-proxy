![Magento 2](https://img.shields.io/badge/Magento-2.4.*-orange)
![PHP](https://img.shields.io/badge/php-7.4-blue)
![PHP](https://img.shields.io/badge/php-8.0-blue)
![PHP](https://img.shields.io/badge/php-8.1-blue)
![composer](https://shields.io/badge/composer-v2-darkgreen)
![packagist](https://img.shields.io/badge/packagist-f28d1a)
![build](https://github.com/run-as-root/magento-cli-auto-proxy/actions/workflows/test_extension.yml/badge.svg)

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
composer req run_as_root/magento-cli-auto-proxy:^1
```

## Roadmap

- [x] MVP release
- [x] Documentation
- [x] PHP 8 support (most likely supported already :suspect: )
- [x] Unit tests coverage
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

[_Vlad Podorozhnyi_](https://github.com/vpodorozh)  
Twitter: [![@vpodorozh](https://img.shields.io/twitter/url?style=social&url=https%3A%2F%2Ftwitter.com%2Fvpodorozh)](https://twitter.com/vpodorozh)  
Email: `vpodorozh@gmail.com` | `vlad.podorozhnyi@run-as-root.sh`  
<br>
[_run_as_root GmbH_](https://github.com/run-as-root) <img src="https://avatars.githubusercontent.com/u/42740374?s=200&v=4"  width="50" height="50"/>   
Twitter: [![@run_as_root](https://img.shields.io/twitter/url?style=social&url=https%3A%2F%2Ftwitter.com%2Frun_as_root)](https://twitter.com/run_as_root)  
Email: `info@run-as-root.sh`  
