require 'rubygems'
require 'firewatir'

$browser = Watir::Browser.new

$browser.goto("#{ENV['MGP_ROOT']}/index.php/admin/system_config/index/key/7fef2ebca22c8956f80a2eb770e46644/")

#works:
#$l = $browser.link(:xpath,"//a[@class='go-try']")
#$l = $browser.link(:xpath,"//a[@href='http://golinks.magento.com/CE15']")
#$l = $browser.link(:xpath,"//a[@href='http://magento.dan.janrain.com/magento/index.php/admin/system_config/index/key/7fef2ebca22c8956f80a2eb770e46644/']")
#$l = $browser.link(:xpath,"//a[contains(span, 'Configuration')]")
#$l.click

#$janrain = $browser.dt(:xpath, "//dt[@class='label' and contains(.,'Janrain')]")
#puts $janrain.html
#
#$engage = $browser.dd(:xpath, "//dd[./a/span[contains(.,'Engage')]]")
#puts $engage.html


# http://magento.dan.janrain.com/magento/index.php/admin/system_config/index/key/7fef2ebca22c8956f80a2eb770e46644/