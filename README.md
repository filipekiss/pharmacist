# Pharmacist

[![Latest Version](https://img.shields.io/github/release/filipekiss/pharmacist.svg?style=flat-square)](https://github.com/filipekiss/pharmacist/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

A simple command line to generate PHAR files.

## Usage

``` bash
pharmacist create MySourceDirectory MyPhar.phar
```

### Included files

By default, Pharmacist will package only the files in your `src` and `vendor` folder. This is to prevent useless files to be packaged together making the output file unnecessarily big. This options takes a PCRE as argument. The default is `/(src|vendor)/`. To include all files, for example, you could call

``` bash
pharmacist create MySourceDirectory MyPhar.phar —include-files "/.*/"
```

The `CLI entry point` and the `Web Entry Point` will be added separately, so you don't need to worry about them in this option.


## Security

If you discover any security related issues, please email me@filipekiss.com.br instead of using the issue tracker.

## Credits

- [Filipe Kiss](https://github.com/filipekiss)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.