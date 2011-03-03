require 'rubygems'
require 'firewatir'
require "#{ENV['MAGENTO_1d5_PLUGIN']}/watir-testing/tests/ruby_lib/lib.rb"


# test Engage apikey (example is bh-test01)
MGP_ENGAGE_APIKEY="1ea372282118fd1574f6fdd1e3961cec868b21f4"
MGP_ENGAGE_REALM="bh-test01.rpxnow.com"
MGP_ENGAGE_REALM_SCHEME="https"
MGP_ENGAGE_APP_ID="kknlmbekkcenihlcfnld"
MGP_ENGAGE_ADMIN_URL="https://rpxnow.com/relying_parties/bh-test01"
MGP_ENGAGE_SOCIAL_PUB="twitter"
MGP_ENGAGE_ENABLED_PROVIDERS="aol, google, yahoo, openid, twitter"

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
  insert_engage_api_key browser, MGP_ENGAGE_APIKEY

  # save the config
  save_config browser

  # show the account data - not really a test, just nice to show as test is running
  show_account_info browser

  # test Account Info values
  test_account_info_values browser


  puts "done with configure_plugin tests."

end

def insert_engage_api_key browser, apikey
  t = browser.text_field(:id, "engage_options_apikey")
  t.set(apikey)
end

def show_account_info browser
  l = browser.link(:id,"engage_accountdata-head")
  l.click
end

def test_account_info_values browser

  [MGP_ENGAGE_REALM,
   MGP_ENGAGE_REALM_SCHEME,
   MGP_ENGAGE_APP_ID,
   MGP_ENGAGE_ADMIN_URL,
   MGP_ENGAGE_SOCIAL_PUB,
   MGP_ENGAGE_ENABLED_PROVIDERS
  ].each do |lookup|

    result = browser.table(:xpath, "//table[./tbody/tr/td[contains(.,'#{lookup}')]]")
    if !result.exists?
      raise "unable to see [#{lookup}] for configured Engage account"
    else
      puts "for configured Engage account: can see [#{lookup}]"
    end

  end

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