# Web Application Firewall for TYPO3 CMS
This is a native TYPO3 extension to increase security of TYPO3 websites. Currently the main focus is to block suspicious HTTP requests in the frontend.

## 2 Usage

### 2.1 Installation

#### Installation as extension from TYPO3 Extension Repository (TER)
Download and install the [extension][1] with the extension manager module.

#### 2.2 Installation with composer
composer req slavlee/waf

### 2.2 Configuration
After installing the extenions you need to do the following steps:

1. Admin Tools -> Maintenance -> Flush Injection Cache
2. Admin Tools -> Settings -> Configure extensions -> waf. Do your changes and press save.

## 3 Documentations
[Testing Documentation](Documentation/Testing/Index.md)

## 4 Changelog
The changelogs can be found inside the CHANGES.md file.

## 5 Final words
I give my best to make TYPO3 websites as secure as possible. Unfortunately I can't promise or guarantee that your site will be 100% secure. You are still responsible for your website.
Please be aware that this WAF my also block valid requests, there is on option to exlude arguments or urls at the moment.

[1]: https://extensions.typo3.org/extension/waf
