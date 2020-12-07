# Magento 2 - FAQ Module

Module to manage a Faq section with its own module and methods to easily include Faq items in other entities.

## Features:

### Frontend:
- Create categories to classify questions
- Searching through questions
- Allow votes on questions
- Multistore ready
- Create url rewrites

### Backend:
- Manage Faq Items (Add, Update, Delete)
- Manage Faq Categories (Add, Update, Delete)

## Install process

### 1 - Add module files


##### Composer

```
composer require alsurmedia/magento2-faq-module

```

#### Manual
Install FAQ extension for Magento2
 * Download the extension
 * Unzip the file
 * Create a folder {Magento root}/app/code/Alsurmedia/Faq
 * Copy the content from the unzip folder


### 2 - Enable module
 * php bin/magento module:enable Alsurmedia_Faq
 * php bin/magento setup:upgrade
 * php bin/magento cache:clean
 * php bin/magento setup:static-content:deploy

### 3 - See results
Log into your Magento admin:
 - Faq Items: Faq -> Faq Items
 - Faq Categories: Faq -> Faq Categories


## Uninstall process

#### Manual

Use this sql

```
ALTER TABLE alsurmedia_faq_store DROP FOREIGN KEY ALSURMEDIA_FAQ_STORE_FAQ_ID_ALSURMEDIA_FAQ_FAQ_ID;
ALTER TABLE alsurmedia_faq_store DROP FOREIGN KEY ALSURMEDIA_FAQ_STORE_STORE_ID_STORE_STORE_ID;
ALTER TABLE alsurmedia_faq_category_store DROP FOREIGN KEY ALSURMDA_FAQ_CTGR_STORE_CTGR_ID_ALSURMDA_FAQ_CTGR_CTGR_ID;
ALTER TABLE alsurmedia_faq_category_store DROP FOREIGN KEY ALSURMEDIA_FAQ_CATEGORY_STORE_STORE_ID_STORE_STORE_ID;
ALTER TABLE alsurmedia_faq_category_id DROP FOREIGN KEY ALSURMDA_FAQ_CTGR_ID_CTGR_ID_ALSURMDA_FAQ_CTGR_CTGR_ID;
ALTER TABLE alsurmedia_faq_category_id DROP FOREIGN KEY ALSURMEDIA_FAQ_CATEGORY_ID_FAQ_ID_ALSURMEDIA_FAQ_FAQ_ID;
DROP TABLE alsurmedia_faq_store;
DROP TABLE alsurmedia_faq_category_store;
DROP TABLE alsurmedia_faq_category_id;
DROP TABLE alsurmedia_faq_category;
DROP TABLE alsurmedia_faq;
delete from setup_module where module = 'Alsurmedia_Faq';
```

#### Composer

Use the command
```
bin/magento module:uninstall Alsurmedia_Faq
```


## Next steps

Create widget to add a group of questions to: 
- Cart
- Success
- Order Confirmation Email
- Product pages: Allow selecting attribute values / product skus
    - Allow it in different positions like "After description", "Info Block", "New tab"
