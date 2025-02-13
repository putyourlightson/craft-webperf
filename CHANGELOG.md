# Webperf Changelog

All notable changes to this project will be documented in this file.

## 1.0.10 - 2018.05.21
### Changed
* Updated to the latest version of the beacon (Boomerang 1.650.0), which fixes some issues
* Updated build system

## 1.0.9 - 2018.05.01
### Changed
* Removed vestigial debugging code
* Added a Sample Trimming Rate Limit that defaults to once per hour, to prevent the sample trimming from impacting performance

## 1.0.8 - 2018.04.19
### Changed
* Fixed an issue where an empty **Exclude Patterns** table and the use of Project Config on Craft 3.1 or later could cause an exception to be thrown when a 404 is thrown
* Fixed an issue where Webperf would fire during Live Preview when it shouldn't
* Updated Twig namespacing to be compliant with deprecated class aliases in 2.7.x

## 1.0.7 - 2019-03-15
### Changed
* Fixed a potential `Undefined property` in the MetricsController 
* Don't allow editing of the plugin settings if `allowAdminChanges` is false
* Fixed an issue where an error would be thrown on the Performance Detail page if you were not running Craft 3.1 or later

## 1.0.6 - 2019-02-28
### Changed
* Fixed a potential division by zero error in the memory limit recommendation under rare circumstances

## 1.0.5 - 2019-02-27
### Changed
* Fixed a `A non well formed numeric value` if you have your `memory_limit` set a certain way in your `php.ini`

## 1.0.4 - 2019-02-26
### Changed
* Fixed an issue with Craft 3.1.5 no longer allowing non-numeric values in the nav `badgeCount`
* Fixed a potential division by zero error in the memory limit recommendation

## 1.0.3 - 2019-02-22
### Changed
* Updated the beacon to remove `AutoXHR` and add in `MD5`
* If you're using Craft 3.1, Webperf will use Craft [environmental variables](https://docs.craftcms.com/v3/config/environments.html#control-panel-settings) for secrets

## 1.0.2 - 2019-02-20
### Changed
* Removed the unimplemented Widget stub

## 1.0.1 - 2019-02-12
### Changed
* Fixed the docs and changelog URLs in composer.json
* Price is now $59; I want as many people using Webperf as possible

## 1.0.0 - 2019-02-12
### Added
* Initial release
