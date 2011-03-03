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

  # insert API key
  insert_engage_api_key browser, "#{ENV['MGP_ENGAGE_APIKEY']}"

  # save the config
  save_config browser


  # todo - test that the right data is showing up in the About section below the API key


  
  puts "done with configure_plugin tests."

end

def insert_engage_api_key browser, apikey
  t = browser.text_field(:id, "engage_options_apikey")
  t.set(apikey)
end


def configure_engage_authentication_link browser


  # cms / widgets /
  # click add new widget instance
  # type engage auth

  # which design package?  start with default/default   have tried some  (maybe base/default)

  # save - name the widget
  # add new layout instance
  # display on Simple Product
  # products all
  # add to main content area


  # select which block 



  # maybe try changing from small to large







end