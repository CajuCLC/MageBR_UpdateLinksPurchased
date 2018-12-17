<?php

/**
 * Class MageBR_UpdateLinksPurchased_Model_Observer
 *
 * @category MageBR
 * @package  MageBR_UpdateLinksPurchased
 * @author   Eric Cavalcanti <magentobr@gmail.com>
 * @license  Apache License 2.0
 * @link     https://www.MageBR.com
 */
class MageBR_UpdateLinksPurchased_Model_Observer
{
  
  /**
   * @param $observer
   * @return MageBR_UpdateLinksPurchased_Model_Observer
   */
  public function updateLinksPurchased($observer)
  {
    $product = $observer->getEvent()->getProduct();
    if($product->getTypeId()=="downloadable")
    {
      $date = new DateTime();
      $productPurchasedItem = Mage::getModel('downloadable/link_purchased_item')->getCollection()
        ->addFieldToFilter('product_id',$product->getId());
      if($product->getTypeInstance(true)->hasLinks($product)){
        $productLinks=$product->getTypeInstance(true)->getLinks($product);
        foreach($productLinks as $productLink){
          if(!is_null($productPurchasedItem))
          {
            foreach ($productPurchasedItem as $itemPurchased) {
              $itemPurchased->setLinkUrl($productLink["link_url"])
                ->setLinkId($productLink["link_id"])
                ->setLinkType($productLink["link_type"])
                ->setLinkTitle($productLink["title"])
                ->setLinkFile($productLink["link_file"])
                ->setUpdatedAt($date->format('Y-m-d H:i:s'))
                //->setNumberOfDownloads($productLink["number_of_downloads_bought"])
                //->setNumberOfDownloadsUsed($productLink["number_of_downloads_used"])
                //->setStatus(Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_AVAILABLE)
                //->setStatus($productLink["status"])
                ->save();
            }
          }
        }
      }
    }
  }
}
