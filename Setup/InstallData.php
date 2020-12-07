<?php
/**
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

namespace Alsurmedia\Faq\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Api\Data\StoreInterface;
use Alsurmedia\Faq\Model\Faq;
use Alsurmedia\Faq\Model\Faqcategory;

use Alsurmedia\Faq\Model\FaqFactory;
use Alsurmedia\Faq\Model\FaqcategoryFactory;

/**
 * Install Data
 */
class InstallData implements InstallDataInterface
{

    CONST DEVHOST = 'm2faq.alsur.dev';

    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    
    protected $store;

    protected $faq;

    protected $faqcategory;

    protected $faqFactory;

    protected $faqcategoryFactory;

    /**
     * Construct
     *
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        StoreInterface $store,
        Faq $faq,
        Faqcategory $faqcategory,
        FaqFactory $faqFactory,
        FaqcategoryFactory $faqcategoryFactory
    ) {
        $this->storeManager = $storeManager;
        $this->store = $store;
        $this->faq = $faq;
        $this->faqcategory = $faqcategory;
        $this->faqFactory = $faqFactory;
        $this->faqcategoryFactory = $faqcategoryFactory;
    }

    /**
     * {@inheritdoc}
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        $stores = $this->storeManager->getStores(true, true);
        foreach ($stores as $store) {
            if ($store->getData()['store_id'] > 0) {

                $storeLocale = ($this->store->getLocaleCode() !== null) ? $this->store->getLocaleCode() : 'en_US';
                $storeUrl = parse_url($this->storeManager->getStore()->getBaseUrl());
                if(strpos(self::DEVHOST, $storeUrl['host']) !== false) {
                    $this->createSampleData($storeLocale, $store->getData()['store_id']);
                }
            }
        }
    }

    public function createSampleData($locale = 'en_US', $storeId)
    {
        $catIds = $this->createCategories($locale, $storeId);
        foreach ($catIds as $catId) {
            $this->createFaqs($locale, $catId, $storeId);
        }
    }

    public function createCategories($locale = 'en_US', $storeId)
    {

        $catIds = [];
        for ($i = 0; $i < 6; $i++) {
            $category = $this->faqcategory->setData($this->getFaqCategoryData($locale, $storeId))->save();
            $catIds[] = $category->getId();
        }

        return $catIds;
    }

    public function createFaqs($locale = 'en_US', $catId, $storeId)
    {
        for ($i = 0; $i < 5; $i++) {
            $this->faq->setData($this->getFaqData($locale, $catId, $storeId))->save();
        }
    }

    public function getFaqData($locale = 'en_US', $catId, $storeId)
    {
        $faker = \Faker\Factory::create($locale);

        return [
            'title' => $faker->sentence(8, true),
            'content' => $faker->paragraphs(4, true),
            'creation_time' => $faker->date('Y-m-d H:i:s'),
            'update_time' => $faker->date('Y-m-d H:i:s'),
            'is_active' => true,
            'sort_order' => true,
            'liked' => $faker->randomNumber(2),
            'disliked' => $faker->randomNumber(1),
            'viewed' => $faker->numberBetween(1,999),
            'most_frequently' => $faker->boolean(40),
            'user_id' => 1,
            'meta_keywords' => implode(',', $faker->words(5)),
            'meta_description' => $faker->text(15),
            'category_id' => $catId,
            'stores' => [$storeId]
        ];
    }

    public function getFaqCategoryData($locale = 'en_US', $storeId)
    {
        $faker = \Faker\Factory::create($locale);

        $basePath = '/home/alsurdev/domains/m2faq.alsur.dev/public_html/pub/media/';
        $img = basename($faker->image($basePath.'alsurmedia/faq/category', 640, 480, 'cats'));

        return [
            'title' => trim($faker->sentence(2, true), '.'),
            'meta_keywords' => implode(',', $faker->words(5)),
            'meta_description' => $faker->text(15),
            'image' => $img,
            'user_id' => 1,
            'count' => $faker->randomNumber(2),
            'is_active' => true,
            'sort_order' => true,
            'creation_time' => $faker->date('Y-m-d H:i:s'),
            'update_time' => $faker->date('Y-m-d H:i:s'),
            'stores' => [$storeId]
        ];
    }
}
