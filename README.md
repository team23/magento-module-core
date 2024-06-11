# TEAM23 Core

TEAM23 Core extension for Magento 2

The Core extension adds a TEAM23 tab with logo to adminhtml system settings. This allows grouping of all TEAM23
extensions that provide settings.

## Usage

In your custom Magento 2 Extension, add the tab with id `team23` to your settings.

For example:
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Config:etc/system_file.xsd">
    <system>
        <section id="your_configuration_id"
                 translate="label"
                 sortOrder="1"
                 showInDefault="1"
                 showInWebsite="1"
                 showInStore="1">
            <label>TEAM23 YOUR EXTENSION</label>
            <tab>team23</tab>
            ...
        </section>
    </system>
</config>
```

Please make sure your component will be loaded after the `Team23_Core` extension, by adding a sequence in your
`module.xml`. Example:

```xml
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="Team23_YourExtension">
        <sequence>
            <module name="Team23_Core"/>
        </sequence>
    </module>
</config>
```

## Installation via Composer

```bash
composer require team23/module-core
```

Now register the module with `bin/magento setup:upgrade`.
