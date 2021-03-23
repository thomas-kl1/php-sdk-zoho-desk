# Change Log

All notable changes to this publication will be documented in this file.

## 3.0.0 - 2021-03-23
- Fix composer PSR-4 autoloader mapper
- Expose services as read-only properties in the gateway facade

## 2.1.0 - 2020-12-06
- Include the Zcrm OAuth codebase into the package due to the Zoho team who archived the zcrm package

## 2.0.0 - 2020-06-29
- Fix invalid type returned by `getEntityId` in `AbstractDataObject`
- Fix a false-positive error when there is no results in the API response
- Open the operation pool in the gateway facade and remove delegated methods
- Add the list entities operation

## 1.0.2 - 2020-06-26
- Add verbose in the error messages

## 1.0.1 - 2020-06-16
- Remove the `zcrmsdk\crm` dependency in the oauth client initialization

## 1.0.0 - 2020-06-12
- First stable release.
