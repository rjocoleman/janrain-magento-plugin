require 'rubygems'
require 'firewatir'
require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/ruby_lib/lib.rb"

def configure_plugin_tests browser

  puts "configure_plugin tests..."

  ##############
  # try logging in to admin
  admin_logged_out? browser, true

  # go to system / configuration
  navigate_to_system_configuration_page browser

  stop

  # go to engage config page
  click_engage_configuration_link browser


  # todo - set up plugin config for a completely new Magento install

  
  

  puts "done with configure_plugin tests."

end


def configure_engage_authentication_link browser


  # cms / widgets /
  # click add new widget instance
  # type engage auth
  # which design package?    have tried some  (maybe base/default)
  # save - name the widget
  # add new layout instance
  # select which block 



end