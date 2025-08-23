# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial package structure
- MakeEntity command for generating CRUD entities
- Service layer generation with service design pattern
- Controller generation with CRUD operations
- Model, Request, Resource, and Migration generation
- Configuration file support
- Force overwrite option
- Interactive file overwrite confirmation

### Changed
- Refactored original MakeEntity command for package structure
- Improved error handling and user feedback
- Enhanced stub files with better code quality

### Fixed
- Fixed DB transaction syntax in controller stub
- Improved service update method logic
- Added proper error handling in controller methods

## [1.0.0] - 2024-08-23

### Added
- Initial release of Laravel Entity Generator package
- Complete CRUD entity generation
- Service design pattern implementation
- Laravel package structure and autoloading
- Comprehensive documentation and examples
