
Here is a way to to add share buttons for each product on the product list pages. 
You can find it in the current default template here: 
/app/design/frontend/base/default/template/catalog/product/list.phtml

On the our demo site it was added between line 115: '</div>' and line 116: '</li>'.

<?php // per-product share buttons
    // clean and truncate description if needed
    $desc = str_replace('\"',"\'", addslashes(preg_replace('/\s\s+/', ' ', $_product->getShortDescription())));
    if(strlen($desc)>150) {$desc = substr($desc,0,150)."...";}
    
    // ouput the share buttons
    echo $this->getLayout()
      ->createBlock('engage/share', 'janrain_engage_share')
      ->setButtonText('Share')
      ->setShareUrl($_product->getProductUrl())
      ->setShareTitle($_helper->productAttribute($_product, $_product->getName(), 'name'))
      ->setShareDesc($desc)
      ->setShareImg($this->helper('catalog/image')->init($_product, 'small_image')->resize(135))
      ->toHtml();
?>

Here is a way to to add share buttons for each comment on the product pages. 
You can find it in the current default template here: 
/app/design/frontend/base/default/template/review/product/view/list.phtml

On the our demo site it was added between line 59: '<small class="date">' and line 60: '</dd>' adding a line break first.

<?php // per-comment share buttons added 7-25-12 by jeremy@janrain.com
    // clean and truncate description if needed
    $desc = str_replace('\"',"\'", addslashes(preg_replace('/\s\s+/', ' ', $_review->getDetail())));
    if(strlen($desc)>150) {$desc = substr($desc,0,150)."...";}
    
    // ouput the share buttons
    echo $this->getLayout()
      ->createBlock('engage/share', 'janrain_engage_share')
      ->setButtonText('Share')
      ->setShareUrl($this->getReviewUrl($_review->getId()))
      ->setShareTitle($this->htmlEscape($_review->getTitle()))
      ->setShareDesc($desc)
      ->toHtml();
?>
