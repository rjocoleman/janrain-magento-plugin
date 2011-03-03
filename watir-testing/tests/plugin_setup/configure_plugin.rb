require 'rubygems'
require 'firewatir'
require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/ruby_lib/lib.rb"


# test Engage apikey (example is bh-test01)...
MGP_ENGAGE_APIKEY="1ea372282118fd1574f6fdd1e3961cec868b21f4"

# ...should result in all of the following:
MGP_ENGAGE_REALM="bh-test01.rpxnow.com"
MGP_ENGAGE_REALM_SCHEME="https"
MGP_ENGAGE_APP_ID="kknlmbekkcenihlcfnld"
MGP_ENGAGE_ADMIN_URL="https://rpxnow.com/relying_parties/bh-test01"
MGP_ENGAGE_SOCIAL_PUB="twitter"
MGP_ENGAGE_ENABLED_PROVIDERS="aol, google, yahoo, openid, twitter"


def configure_plugin_tests browser

  puts "configure_plugin tests..."

  # try logging in to admin
  admin_logged_out? browser, true

  # insert the API key, submit, see that the correct Engage values are shown.
#  configure_plugin browser

  # try placing the auth widget
  configure_engage_authentication_link browser


  puts "done with configure_plugin tests."

end


def configure_plugin browser

  # go to system / configuration
  navigate_to_system_configuration_page browser

  # go to engage config page
  click_engage_configuration_link browser

  # insert API key
  insert_engage_api_key browser, MGP_ENGAGE_APIKEY

  # save the config
  save_config browser

  # show the account data - not really a test, just nice to show while test is running
  show_account_info browser

  # test Account Info values
  test_account_info_values browser

end


def configure_engage_authentication_link browser


  # cms / widgets /
  navigate_to_cms_widgets browser

  # click add new widget instance
  click_add_new_widget_instance browser


  # first page:

  # type engage auth
  pulldown_widget_type browser

  # package theme
  pulldown_package_theme browser

  # click continue button
  # submit_widget_form browser
  widget_form_continue browser


  # next page:

  # set widget instance title
  set_widget_instance_title browser

  # assign to store views
  pulldown_assign_to_store_views browser

  #save and continue edit
  click_save_and_continue_edit browser



  # add layout update
  click_add_layout_update browser

  


  # which design package?  start with default/default   have tried some  (maybe base/default)

  # save - name the widget
  # add new layout instance
  # display on Simple Product
  # products all
  # add to main content area


  # select which block 



  # maybe try changing from small to large







end