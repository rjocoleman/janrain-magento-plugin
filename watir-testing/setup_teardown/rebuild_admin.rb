require 'rubygems'
require 'firewatir'

require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/ruby_lib/lib.rb"


def rebuild_magento browser

  # log the admin in - this time with default username/pwd after a db rebuild
  admin_logged_out? browser, true, "admin", "admin123"

  #raise "stop during rebuild_magento"

  # just after submitting credentials:

  # click close on incoming message dialog box

  # go to messages inbox
  # view 100 msgs per page
  # select all
  # action - mark as read
  # submit

  # click on Index Management
  # select all
  # submit

  # System / Permissions / Users
  # click on admin
  # new password:
  # new password confirmation:
  # save user



  # to reload Magento completely:
  # drop the magento folder
  # drop in a new one
  # cd ~/Sites/magento
  # chmod 777 app/etc/
  # chmod 777 var/
  # chmod 777 media/

  # then run through the installer:
  # http://magento.dan.janrain.com/magento/


  

end