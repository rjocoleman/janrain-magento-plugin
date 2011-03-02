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

  # go to engage config page
  click_engage_configuration_link browser

  puts "done with configure_plugin tests."

end
